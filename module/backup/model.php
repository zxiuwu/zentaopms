<?php
/**
 * The model file of backup module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     backup
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class backupModel extends model
{
    /**
     * Backup SQL.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function backSQL($backupFile)
    {
        $zdb = $this->app->loadClass('zdb');
        return $zdb->dump($backupFile);
    }

    /**
     * Backup file.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function backFile($backupFile)
    {
        $zfile  = $this->app->loadClass('zfile');

        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        if(!is_dir($backupFile)) mkdir($backupFile, 0777, true);

        $tmpLogFile = $this->getTmpLogFile($backupFile);
        $dataDir    = $this->app->getAppRoot() . 'www/data/';
        $count      = $zfile->getCount($dataDir, array('course'));
        file_put_contents($tmpLogFile, json_encode(array('allCount' => $count)));

        $result = $zfile->copyDir($dataDir, $backupFile, $logLevel = false, $tmpLogFile, array('course'));
        $this->processSummary($backupFile, $result['count'], $result['size'], $result['errorFiles'], $count);
        unlink($tmpLogFile);

        return $return;
    }

    /**
     * Backup code.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function backCode($backupFile)
    {
        $zfile  = $this->app->loadClass('zfile');
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $tmpLogFile  = $this->getTmpLogFile($backupFile);
        $appRoot     = $this->app->getAppRoot();
        $fileList    = glob($appRoot . '*');
        $wwwFileList = glob($appRoot . 'www/*');

        $tmpFile  = array_search($appRoot . 'tmp', $fileList);
        $wwwFile  = array_search($appRoot . 'www', $fileList);
        $dataFile = array_search($appRoot . 'www/data', $wwwFileList);
        unset($fileList[$tmpFile]);
        unset($fileList[$wwwFile]);
        unset($wwwFileList[$dataFile]);

        $fileList = array_merge($fileList, $wwwFileList);

        if(!is_dir($backupFile)) mkdir($backupFile, 0777, true);

        $allCount = 0;
        foreach($fileList as $codeFile) $allCount += $zfile->getCount($codeFile);
        file_put_contents($tmpLogFile, json_encode(array('allCount' => $allCount)));

        $copiedCount = 0;
        $copiedSize  = 0;
        $errorFiles  = array();
        foreach($fileList as $codeFile)
        {
            $file = trim(str_replace($appRoot, '', $codeFile), DS);
            if(is_dir($codeFile))
            {
                if(!is_dir($backupFile . DS . $file)) mkdir($backupFile . DS . $file, 0777, true);
                $result = $zfile->copyDir($codeFile, $backupFile . DS . $file, $logLevel = false, $tmpLogFile);
                $copiedCount += $result['count'];
                $copiedSize  += $result['size'];
                $errorFiles  += $result['errorFiles'];
            }
            else
            {
                $dirName = dirname($file);
                if(!is_dir($backupFile . DS . $dirName)) mkdir($backupFile . DS . $dirName, 0777, true);
                if($zfile->copyFile($codeFile, $backupFile . DS . $file))
                {
                    $copiedCount += 1;
                    $copiedSize  += filesize($codeFile);
                }
                else
                {
                    $errorFiles[] = $codeFile;
                }
            }
        }

        $this->processSummary($backupFile, $copiedCount, $copiedSize, $errorFiles, $allCount);
        unlink($tmpLogFile);

        return $return;
    }

    /**
     * Restore SQL.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function restoreSQL($backupFile)
    {
        $zdb    = $this->app->loadClass('zdb');
        $nosafe = strpos($this->config->backup->setting, 'nosafe') !== false;

        $backupDir    = dirname($backupFile);
        $fileName     = date('YmdHis') . mt_rand(0, 9);
        $backFileName = "{$backupDir}/{$fileName}.sql";
        if(!$nosafe) $backFileName .= '.php';

        $result = $this->backSQL($backFileName);
        if($result->result and !$nosafe) $this->addFileHeader($backFileName);

        $allTables = $zdb->getAllTables();
        foreach($allTables as $tableName => $tableType)
        {
            try
            {
                $this->dbh->query("DROP $tableType IF EXISTS `$tableName`");
            }
            catch(PDOException $e){}
        }

        return $zdb->import($backupFile);
    }

    /**
     * Restore File.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function restoreFile($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        if(is_file($backupFile))
        {
            $oldDir = getcwd();
            chdir($this->app->getTmpRoot());
            $this->app->loadClass('pclzip', true);
            $zip = new pclzip($backupFile);
            if($zip->extract(PCLZIP_OPT_PATH, $this->app->getAppRoot() . 'www/data/', PCLZIP_OPT_TEMP_FILE_ON) == 0)
            {
                $return->result = false;
                $return->error  = $zip->errorInfo();
            }
            chdir($oldDir);
        }
        elseif(is_dir($backupFile))
        {
            $zfile = $this->app->loadClass('zfile');
            $zfile->copyDir($backupFile, $this->app->getAppRoot() . 'www/data/', $showDetails = false);
        }

        return $return;
    }

    /**
     * Add file header.
     *
     * @param  string    $fileName
     * @access public
     * @return bool
     */
    public function addFileHeader($fileName)
    {
        $firstline = false;
        $die       = "<?php die();?" . ">\n";
        $fileSize  = filesize($fileName);

        $fh    = fopen($fileName, 'c+');
        $delta = strlen($die);
        while(true)
        {
            $offset = ftell($fh);
            $line   = fread($fh, 1024 * 1024);
            if(!$firstline)
            {
                $line = $die . $line;
                $firstline = true;
            }
            else
            {
                $line = $compensate . $line;
            }

            $compensate = fread($fh, $delta);
            fseek($fh, $offset);
            fwrite($fh, $line);

            if(ftell($fh) >= $fileSize)
            {
                fwrite($fh, $compensate);
                break;
            }
        }
        fclose($fh);
        return true;
    }

    /**
     * Remove file header.
     *
     * @param  string    $fileName
     * @access public
     * @return bool
     */
    public function removeFileHeader($fileName)
    {
        $firstline = false;
        $die       = "<?php die();?" . ">\n";
        $fileSize  = filesize($fileName);

        $fh = fopen($fileName, 'c+');
        while(true)
        {
            $offset = ftell($fh);
            if($firstline and $delta) fseek($fh, $offset + $delta);
            $line = fread($fh, 1024 * 1024);
            if(!$firstline)
            {
                $firstline    = true;
                $beforeLength = strlen($line);
                $line         = str_replace($die, '', $line);
                $afterLength  = strlen($line);
                $delta        = $beforeLength - $afterLength;
                if($delta == 0)
                {
                    fclose($fh);
                    return true;
                }
            }
            fseek($fh, $offset);
            fwrite($fh, $line);

            if(ftell($fh) >= $fileSize - $delta) break;
        }
        ftruncate($fh, ($fileSize - $delta));
        fclose($fh);
        return true;
    }

    /**
     * Get dir size.
     *
     * @param  string    $backup
     * @access public
     * @return int
     */
    public function getBackupSummary($backup)
    {
        $zfile = $this->app->loadClass('zfile');
        if(is_file($backup))
        {
            $summary = array();
            $summary['allCount'] = 1;
            $summary['count']    = 1;
            $summary['size']     = $zfile->getFileSize($backup);

            return $summary;
        }

        $summaryFile = dirname($backup) . DS . 'summary';
        if(!file_exists($summaryFile)) return array();

        $summary = json_decode(file_get_contents(dirname($backup) . DS . 'summary'), true);
        return isset($summary[basename($backup)]) ? $summary[basename($backup)] : array();
    }

    /**
     * Get backup path.
     *
     * @access public
     * @return string
     */
    public function getBackupPath()
    {
        $backupPath = empty($this->config->backup->settingDir) ? $this->app->getTmpRoot() . 'backup' . DS : $this->config->backup->settingDir;
        return rtrim(str_replace('\\', '/', $backupPath), '/') . '/';
    }

    /**
     * Get backup file.
     *
     * @param  string    $name
     * @param  string    $type
     * @access public
     * @return string
     */
    public function getBackupFile($name, $type)
    {
        $backupPath = $this->getBackupPath();
        if($type == 'sql')
        {
            if(file_exists($backupPath . $name . ".{$type}")) return $backupPath . $name . ".{$type}";
            if(file_exists($backupPath . $name . ".{$type}.php")) return $backupPath . $name . ".{$type}.php";
        }
        else
        {
            if(file_exists($backupPath . $name . ".{$type}")) return $backupPath . $name . ".{$type}";
            if(file_exists($backupPath . $name . ".{$type}.zip")) return $backupPath . $name . ".{$type}.zip";
            if(file_exists($backupPath . $name . ".{$type}.zip.php")) return $backupPath . $name . ".{$type}.zip.php";
        }

        return false;
    }

    /**
     * Get tmp log file.
     *
     * @param  string $backupFile
     * @access public
     * @return string
     */
    public function getTmpLogFile($backupFile)
    {
        $backupDir  = dirname($backupFile);
        return $backupDir . DS . basename($backupFile) . '.tmp.summary';
    }

    /**
     * Get backup dir progress.
     *
     * @param  string $backup
     * @access public
     * @return array
     */
    public function getBackupDirProgress($backup)
    {
        $tmpLogFile = $this->getTmpLogFile($backup);
        if(file_exists($tmpLogFile)) return json_decode(file_get_contents($tmpLogFile), true);
        return array();
    }

    /**
     * Process filesize.
     *
     * @param  int    $fileSize
     * @access public
     * @return string
     */
    public function processFileSize($fileSize)
    {
        $bit = 'KB';
        $fileSize = round($fileSize / 1024, 2);
        if($fileSize >= 1024)
        {
            $bit = 'MB';
            $fileSize = round($fileSize / 1024, 2);
        }
        if($fileSize >= 1024)
        {
            $bit = 'GB';
            $fileSize = round($fileSize / 1024, 2);
        }

        return $fileSize . $bit;
    }

    /**
     * Process backup summary.
     *
     * @param  string $file
     * @param  int    $count
     * @param  int    $size
     * @param  array  $errorFiles
     * @param  int    $allCount
     * @param  string $action  add|delete
     * @access public
     * @return bool
     */
    public function processSummary($file, $count, $size, $errorFiles = array(), $allCount = 0, $action = 'add')
    {
        $backupPath = dirname($file);
        $fileName   = basename($file);

        $summaryFile = $backupPath . DS . 'summary';
        if(!file_exists($summaryFile) and !touch($summaryFile)) return false;

        $summary = json_decode(file_get_contents($summaryFile), true);
        if(empty($summary)) $summary = array();

        if($action == 'add')
        {
            $summary[$fileName]['allCount']   = $allCount;
            $summary[$fileName]['errorFiles'] = $errorFiles;
            $summary[$fileName]['count']      = $count;
            $summary[$fileName]['size']       = $size;
        }
        else
        {
            unset($summary[$fileName]);
        }

        if(file_put_contents($summaryFile, json_encode($summary))) return true;
        return false;
    }

    /**
     * Get disk space.
     *
     * @param  int    $backupPath
     * @access public
     * @return int
     */
    public function getkDiskSpace($backupPath)
    {
        $nofile        = strpos($this->config->backup->setting, 'nofile') !== false;
        $diskFreeSpace = disk_free_space($backupPath);
        $backFileSize  = 0;

        $zfile = $this->app->loadClass('zfile');

        if(!$nofile)
        {
            $appRoot      = $this->app->getAppRoot();
            $appRootSize  = $this->getZentaoSize($appRoot);
            $backFileSize = $appRootSize - $zfile->getDirSize($appRoot . 'tmp') - $zfile->getDirSize($appRoot . 'www/course');
        }

        $backSqlSize = $this->dao->select('sum(data_length+index_length) as size')
            ->from('information_schema.tables')
            ->where('TABLE_SCHEMA')->eq($this->config->db->name)
            ->groupBy('TABLE_SCHEMA')
            ->fetch('size');

        return $diskFreeSpace . ',' . ($backFileSize + $backSqlSize);
    }

    /**
     * Get zentao size.
     *
     * @param  string $appRoot
     * @access public
     * @return int
     */
    public function getZentaoSize($appRoot)
    {
        $totalSize = 0;
        $tmpDir    = realPath($appRoot . 'tmp/');
        $dataDir   = realPath($appRoot . 'www/data/');
        $iterator  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($appRoot, RecursiveDirectoryIterator::SKIP_DOTS));

        foreach($iterator as $file)
        {
            $filePath = $file->getRealPath();
            if(strpos($filePath, $tmpDir) !== 0 and strpos($filePath, $dataDir) !== 0)
            {
                $totalSize += $file->getSize();
            }
        }
        return $totalSize;
    }
}
