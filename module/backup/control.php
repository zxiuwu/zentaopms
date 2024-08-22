<?php
/**
 * The control file of backup of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     backup
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class backup extends control
{
    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct($moduleName = '', $methodName = '')
    {
        parent::__construct($moduleName, $methodName);

        $this->backupPath = $this->backup->getBackupPath();

        if($this->app->methodName != 'setting')
        {
            if(!is_dir($this->backupPath))
            {
                if(!mkdir($this->backupPath, 0777, true)) $this->view->error = sprintf($this->lang->backup->error->noWritable, dirname($this->backupPath));
            }
            else
            {
                if(!is_writable($this->backupPath)) $this->view->error = sprintf($this->lang->backup->error->noWritable, $this->backupPath);
            }
            if(!is_writable($this->app->getTmpRoot())) $this->view->error = sprintf($this->lang->backup->error->noWritable, $this->app->getTmpRoot());
        }
    }

    /**
     * Index
     *
     * @access public
     * @return void
     */
    public function index()
    {
        $this->loadModel('action');

        $backups = array();
        if(empty($this->view->error))
        {
            $sqlFiles = glob("{$this->backupPath}*.sql*");
            if(!empty($sqlFiles))
            {
                foreach($sqlFiles as $file)
                {
                    $fileName   = basename($file);
                    $backupFile = new stdclass();
                    $backupFile->time  = filemtime($file);
                    $backupFile->name  = substr($fileName, 0, strpos($fileName, '.'));
                    $backupFile->files[$file] = $this->backup->getBackupSummary($file);

                    $fileBackup = $this->backup->getBackupFile($backupFile->name, 'file');
                    if($fileBackup) $backupFile->files[$fileBackup] = $this->backup->getBackupSummary($fileBackup);

                    $codeBackup = $this->backup->getBackupFile($backupFile->name, 'code');
                    if($codeBackup) $backupFile->files[$codeBackup] = $this->backup->getBackupSummary($codeBackup);

                    $backups[$backupFile->name] = $backupFile;
                }
            }
        }
        krsort($backups);

        $this->view->title      = $this->lang->backup->common;
        $this->view->position[] = $this->lang->backup->common;
        $this->view->backups    = $backups;
        if(!is_writable($this->backupPath))        $this->view->backupError = sprintf($this->lang->backup->error->plainNoWritable, $this->backupPath);
        if(!is_writable($this->app->getTmpRoot())) $this->view->backupError = sprintf($this->lang->backup->error->plainNoWritable, $this->app->getTmpRoot());
        $this->display();
    }

    /**
     * Ajax get disk space.
     *
     * @access public
     * @return void
     */
    public function ajaxGetkDiskSpace()
    {
        set_time_limit(0);
        session_write_close();
        $diskSapce = $this->backup->getkDiskSpace($this->backupPath);
        $diskSapce = explode(',', $diskSapce);

        $space = new stdclass();
        $space->freeSpace = intval($diskSapce[0]);
        $space->needSpace = intval($diskSapce[1]);

        echo json_encode($space);
    }

    /**
     * Backup.
     *
     * param   string $reload yes|no
     * @access public
     * @return void
     */
    public function backup($reload = 'no')
    {
        if($reload == 'yes') session_write_close();
        set_time_limit(0);
        $nofile = strpos($this->config->backup->setting, 'nofile') !== false;
        $nosafe = strpos($this->config->backup->setting, 'nosafe') !== false;

        $fileName = date('YmdHis') . mt_rand(0, 9);
        $backFileName = "{$this->backupPath}{$fileName}.sql";
        if(!$nosafe) $backFileName .= '.php';
        $result = $this->backup->backSQL($backFileName);

        if(!$result->result)
        {
            if($reload == 'yes')
            {
                return print(sprintf($this->lang->backup->error->noWritable, $this->backupPath));
            }
            else
            {
                printf($this->lang->backup->error->noWritable, $this->backupPath);
            }
        }
        if(!$nosafe) $this->backup->addFileHeader($backFileName);

        if(!$nofile)
        {
            $backFileName = "{$this->backupPath}{$fileName}.file";

            $result = $this->backup->backFile($backFileName);

            if(!$result->result)
            {
                if($reload == 'yes')
                {
                    return print(sprintf($this->lang->backup->error->backupFile, $result->error));
                }
                else
                {
                    printf($this->lang->backup->error->backupFile, $result->error);
                }
            }

            $backFileName = "{$this->backupPath}{$fileName}.code";

            $result = $this->backup->backCode($backFileName);
            if(!$result->result)
            {
                if($reload == 'yes')
                {
                    return print(sprintf($this->lang->backup->error->backupCode, $result->error));
                }
                else
                {
                    printf($this->lang->backup->error->backupCode, $result->error);
                }
            }
        }

        /* Delete expired backup. */
        $backupFiles = glob("{$this->backupPath}*.*");
        if(!empty($backupFiles))
        {
            $time  = time();
            $zfile = $this->app->loadClass('zfile');
            foreach($backupFiles as $file)
            {
                /* Only delete backup file. */
                $fileName = basename($file);
                if(!preg_match('/[0-9]+\.(sql|file|code)/', $fileName)) continue;

                /* Remove before holdDays file. */
                if($time - filemtime($file) > $this->config->backup->holdDays * 24 * 3600)
                {
                    $rmFunc = is_file($file) ? 'removeFile' : 'removeDir';
                    $zfile->{$rmFunc}($file);
                    if($rmFunc == 'removeDir') $this->backup->processSummary($file, 0, 0, array(), 0, 'delete');
                }
            }
        }

        if($reload == 'yes') return print($this->lang->backup->success->backup);
        echo $this->lang->backup->success->backup . "\n";
    }

    /**
     * Restore.
     *
     * @param  string $fileName
     * @param  string $confirm  yes|no
     * @access public
     * @return void
     */
    public function restore($fileName, $confirm = 'no')
    {
        if($confirm == 'no') return $this->send(array('result' => 'fail', 'message' => $this->lang->backup->confirmRestore));

        set_time_limit(0);

        /* Restore database. */
        if(file_exists("{$this->backupPath}{$fileName}.sql.php"))
        {
            $sqlBackup = "{$this->backupPath}{$fileName}.sql.php";
            $this->backup->removeFileHeader($sqlBackup);
            $result = $this->backup->restoreSQL($sqlBackup);
            $this->backup->addFileHeader($sqlBackup);
            if(!$result->result) return $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreSQL, $result->error)));
        }
        elseif(file_exists("{$this->backupPath}{$fileName}.sql"))
        {
            $result = $this->backup->restoreSQL("{$this->backupPath}{$fileName}.sql");
            if(!$result->result) return $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreSQL, $result->error)));
        }

        /* Restore attatchments. */
        if(file_exists("{$this->backupPath}{$fileName}.file.zip.php"))
        {
            $fileBackup = "{$this->backupPath}{$fileName}.file.zip.php";
            $this->backup->removeFileHeader($fileBackup);
            $result = $this->backup->restoreFile($fileBackup);
            $this->backup->addFileHeader($fileBackup);
            if(!$result->result) return $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreFile, $result->error)));
        }
        elseif(file_exists("{$this->backupPath}{$fileName}.file.zip"))
        {
            $result = $this->backup->restoreFile("{$this->backupPath}{$fileName}.file.zip");
            if(!$result->result) return $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreFile, $result->error)));
        }
        elseif(file_exists("{$this->backupPath}{$fileName}.file"))
        {
            $result = $this->backup->restoreFile("{$this->backupPath}{$fileName}.file");
            if(!$result->result) return $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreFile, $result->error)));
        }

        return $this->send(array('result' => 'success', 'message' => $this->lang->backup->success->restore));
    }

    /**
     * remove PHP header.
     *
     * @param  string $fileName
     * @access public
     * @return void
     */
    public function rmPHPHeader($fileName)
    {
        if(file_exists($this->backupPath . $fileName . '.sql.php'))
        {
            $this->backup->removeFileHeader($this->backupPath . $fileName . '.sql.php');
            rename($this->backupPath . $fileName . '.sql.php', $this->backupPath . $fileName . '.sql');
        }
        if(file_exists($this->backupPath . $fileName . '.file.zip.php'))
        {
            $this->backup->removeFileHeader($this->backupPath . $fileName . '.file.zip.php');
            rename($this->backupPath . $fileName . '.file.zip.php', $this->backupPath . $fileName . '.file.zip');
        }
        if(file_exists($this->backupPath . $fileName . '.code.zip.php'))
        {
            $this->backup->removeFileHeader($this->backupPath . $fileName . '.code.zip.php');
            rename($this->backupPath . $fileName . '.code.zip.php', $this->backupPath . $fileName . '.code.zip');
        }

        return print(js::reload('parent'));
    }

    /**
     * Delete.
     *
     * @param  string $fileName
     * @param  string $confirm  yes|no
     * @access public
     * @return void
     */
    public function delete($fileName, $confirm = 'no')
    {
        if($confirm == 'no') return print(js::confirm($this->lang->backup->confirmDelete, inlink('delete', "fileName=$fileName&confirm=yes")));

        /* Delete database file. */
        if(file_exists($this->backupPath . $fileName . '.sql.php') and !unlink($this->backupPath . $fileName . '.sql.php'))
        {
            return print(js::alert(sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.sql.php')));
        }
        if(file_exists($this->backupPath . $fileName . '.sql') and !unlink($this->backupPath . $fileName . '.sql'))
        {
            return print(js::alert(sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.sql')));
        }

        /* Delete attatchments file. */
        if(file_exists($this->backupPath . $fileName . '.file.zip.php') and !unlink($this->backupPath . $fileName . '.file.zip.php'))
        {
            return print(js::alert(sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.file.zip.php')));
        }
        if(file_exists($this->backupPath . $fileName . '.file.zip') and !unlink($this->backupPath . $fileName . '.file.zip'))
        {
            return print(js::alert(sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.file.zip')));
        }
        if(file_exists($this->backupPath . $fileName . '.file'))
        {
            $zfile = $this->app->loadClass('zfile');
            $zfile->removeDir($this->backupPath . $fileName . '.file');
            $this->backup->processSummary($this->backupPath . $fileName . '.file', 0, 0, array(), 0, 'delete');
        }

        /* Delete code file. */
        if(file_exists($this->backupPath . $fileName . '.code.zip.php') and !unlink($this->backupPath . $fileName . '.code.zip.php'))
        {
            return print(js::alert(sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.code.zip.php')));
        }
        if(file_exists($this->backupPath . $fileName . '.code.zip') and !unlink($this->backupPath . $fileName . '.code.zip'))
        {
            return print(js::alert(sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.code.zip')));
        }
        if(file_exists($this->backupPath . $fileName . '.code'))
        {
            $zfile = $this->app->loadClass('zfile');
            $zfile->removeDir($this->backupPath . $fileName . '.code');
            $this->backup->processSummary($this->backupPath . $fileName . '.code', 0, 0, array(), 0, 'delete');
        }

        return print(js::reload('parent'));
    }

    /**
     * Change hold days.
     *
     * @access public
     * @return void
     */
    public function change()
    {
        if($_POST)
        {
            $data = fixer::input('post')->get();
            $this->loadModel('setting')->setItem('system.backup.holdDays', $data->holdDays);
            return print(js::reload('parent.parent'));
        }

        $this->display();
    }

    /**
     * Setting backup
     *
     * @access public
     * @return void
     */
    public function setting()
    {
        /* Check safe file. */
        $statusFile = $this->loadModel('common')->checkSafeFile();
        if($statusFile)
        {
            $this->app->loadLang('extension');

            $search = $this->app->getBasePath();
            $pos    = strpos($statusFile, $search);
            $okFile = $statusFile;
            if($pos !== false) $okFile = substr_replace($statusFile, '', $pos, strlen($search));

            $this->view->error = sprintf($this->lang->extension->noticeOkFile, $okFile, $statusFile);
            return print($this->display());
        }

        if(strtolower($this->server->request_method) == "post")
        {
            $data = fixer::input('post')->join('setting', ',')->get();

            /*save change*/
            if(isset($data->holdDays)) $this->loadModel('setting')->setItem('system.backup.holdDays', $data->holdDays);

            $setting = '';
            if(isset($data->setting)) $setting = $data->setting;
            $this->loadModel('setting')->setItem('system.backup.setting', $setting);

            $settingDir = $data->settingDir;
            if($settingDir)
            {
                $settingDir = rtrim($settingDir, DS) . DS;
                if(!is_dir($settingDir) and mkdir($settingDir, 0777, true)) return print(js::alert($this->lang->backup->error->noCreateDir));
                if(!is_writable($settingDir)) return print(js::alert(strip_tags(sprintf($this->lang->backup->error->noWritable, $settingDir))));
                if($data->settingDir == $this->app->getTmpRoot() . 'backup' . DS) $settingDir = '';
            }

            $this->setting->setItem('system.backup.settingDir', $settingDir);

            return print(js::reload('parent.parent'));
        }
        $this->display();
    }

    /**
     * Ajax get progress.
     *
     * @access public
     * @return void
     */
    public function ajaxGetProgress()
    {
        session_write_close();

        $files = glob($this->backupPath . '/*.*');
        rsort($files);

        $fileName = basename($files[0]);
        $fileName = substr($fileName, 0, strpos($fileName, '.'));

        $sqlFileName = $this->backupPath . $fileName . '.sql';
        if(!file_exists($sqlFileName)) $sqlFileName .= '.php';
        $sqlFileName = $this->backup->getBackupFile($fileName, 'sql');
        if($sqlFileName)
        {
            $summary = $this->backup->getBackupSummary($sqlFileName);
            $message = sprintf($this->lang->backup->progressSQL, $this->backup->processFileSize($summary['size']));
        }

        $attachFileName = $this->backup->getBackupFile($fileName, 'file');
        if($attachFileName)
        {
            $log = $this->backup->getBackupDirProgress($attachFileName);
            $message = sprintf($this->lang->backup->progressAttach, zget($log, 'allCount', 0), zget($log, 'count', 0));
        }

        $codeFileName = $this->backup->getBackupFile($fileName, 'code');
        if($codeFileName)
        {
            $log = $this->backup->getBackupDirProgress($codeFileName);
            $message = sprintf($this->lang->backup->progressCode, zget($log, 'allCount', 0), zget($log, 'count', 0));
        }

        return print($message);
    }
}
