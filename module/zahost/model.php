<?php
/**
 * The model file of zahost module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Wang Jianhua <wangjiahua@easycorp.ltd>
 * @package     zahost
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class zahostModel extends model
{
    /**
     * Set lang;
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->app->lang->host = $this->lang->zahost;
    }

    /**
     * Create a host.
     *
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $hostInfo = fixer::input('post')
            ->setDefault('cpuNumber,cpuCores,diskSize,memory', 0)
            ->trim('extranet')
            ->get();

        $this->dao->table      = 'zahost';
        $hostInfo->type        = 'zahost';
        $hostInfo->status      = 'wait';
        $hostInfo->createdBy   = $this->app->user->account;
        $hostInfo->createdDate = helper::now();
        $hostInfo->zap         = $this->config->zahost->defaultPort;
        $hostInfo->secret      = md5($hostInfo->name . time());

        $this->dao->update(TABLE_ZAHOST)->data($hostInfo)
            ->batchCheck($this->config->zahost->create->requiredFields, 'notempty')
            ->batchCheck('cpuCores,diskSize', 'gt', 0)
            ->batchCheck('diskSize,memory', 'float')
            ->check('name', 'unique', "type='zahost'")
            ->autoCheck();
        if(dao::isError()) return false;

        $ping = $this->checkAddress($hostInfo->extranet);
        if(!$ping)
        {
            return false;
        }

        $this->dao->insert(TABLE_ZAHOST)->data($hostInfo)->autoCheck()->exec();
        $hostID = $this->dao->lastInsertID();
        if(!dao::isError())
        {
            $this->loadModel('action')->create('zahost', $hostID, 'created');
            return $hostID;
        }

        return false;
    }

    /**
     * Update a host.
     *
     * @param  int    $hostID
     * @access public
     * @return array|bool
     */
    public function update($hostID)
    {
        $oldHost              = $this->getById($hostID);
        $hostInfo             = fixer::input('post')->get();
        $hostInfo->editedBy   = $this->app->user->account;
        $hostInfo->editedDate = helper::now();

        $this->dao->update(TABLE_ZAHOST)->data($hostInfo)
            ->batchCheck($this->config->zahost->create->requiredFields, 'notempty')
            ->batchCheck('diskSize,memory', 'float')
            ->check('name', 'unique', "id != $hostID and type in ('vhost', 'zahost')")
            ->autoCheck();

        if(dao::isError()) return false;

        $ping = $this->checkAddress($hostInfo->extranet);

        if(!$ping)
        {
            return false;
        }

        $this->dao->update(TABLE_ZAHOST)->data($hostInfo)->autoCheck()
            ->batchCheck('cpuCores,diskSize', 'gt', 0)
            ->batchCheck('diskSize,memory', 'float')
            ->where('id')->eq($hostID)->exec();
        return common::createChanges($oldHost, $hostInfo);
    }

    /**
     * Ping ip/domain.
     *
     * @param  string    $address
     * @access public
     * @return bool
     */
    public function ping($address)
    {
        if(!filter_var($address, FILTER_VALIDATE_IP) && !filter_var(gethostbyname($address), FILTER_VALIDATE_IP)) return false;

        if(strcasecmp(PHP_OS, 'WINNT') === 0)
        {
            exec("ping -n 1 {$address}", $outcome, $status);
        }
        elseif(strcasecmp(PHP_OS, 'Linux') === 0)
        {
            exec("ping -c 1 {$address}", $outcome, $status);
        }

        return 0 == $status;
    }

    /**
     * Telnet ip/domain.
     *
     * @param  string $address
     * @access public
     * @return bool
     */
    public function checkAddress($address)
    {
        $address = str_replace(array('https://', 'http://'), '', $address);

        if ($this->ping($address)) return true;

        foreach(array(80, 443, $this->config->zahost->defaultPort) as $port)
        {
            $fp = fsockopen($address, $port, $errno, $errstr, 3);
            if ($fp) return true;
        }

        return false;
    }

    /**
     * Get image by ID.
     *
     * @param  int    $imageID
     * @access public
     * @return object
     */
    public function getImageByID($imageID)
    {
        return $this->dao->select('*')->from(TABLE_IMAGE)->where('id')->eq($imageID)->fetch();
    }

    /**
     * Get image by name.
     *
     * @param  string $imageName
     * @param  int    $hostID
     * @access public
     * @return object
     */
    public function getImageByNameAndHostID($imageName, $hostID)
    {
        return $this->dao->select('*')->from(TABLE_IMAGE)
            ->where('host')->eq($hostID)
            ->andWhere('name')->eq($imageName)->fetch();
    }

    /**
     * Get image files from ZAgent server.
     *
     * @param  object $hostID
     * @access public
     * @return array
     */
    public function getImageList($hostID, $browseType = 'all', $param = 0, $orderBy = 'id', $pager = null)
    {
        $imageList = json_decode(commonModel::http($this->config->zahost->imageListUrl, array(), array()));
        if(empty($imageList)) return array();

        $downloadedImageList = $this->dao->select('*')->from(TABLE_IMAGE)
            ->where('host')->eq($hostID)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('name');

        $refreshPageData = false;
        foreach($imageList as $remoteImage)
        {
            $downloadedImage = zget($downloadedImageList, $remoteImage->name, '');
            if(empty($downloadedImage))
            {
                $refreshPageData = true;
                $remoteImage->status = 'notDownloaded';
                $remoteImage->from   = 'zentao';
                $remoteImage->osName = $remoteImage->os;
                $remoteImage->host   = $hostID;
                $remoteImage->status = 'notDownloaded';

                unset($remoteImage->os);
                $this->dao->insert(TABLE_IMAGE)->data($remoteImage, 'desc')->autoCheck()->exec();
            }
        }

        if($refreshPageData)
        {
            $downloadedImageList = $this->dao->select('*')->from(TABLE_IMAGE)
            ->where('host')->eq($hostID)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('name');
        }

        foreach($downloadedImageList as $image)
        {
            if($image->status == 'notDownloaded')
            {
                $image->cancelMisc   = sprintf("title='%s' class='btn image-cancel image-cancel-%d %s'", $this->lang->zahost->cancel, $image->id, "disabled");
                $image->downloadMisc = sprintf("title='%s' class='btn image-download image-download-%d %s'", $this->lang->zahost->image->downloadImage, $image->id, "");
            }
            else
            {
                $image->cancelMisc   = sprintf("title='%s' data-id='%s' class='btn image-cancel image-cancel-%d %s'", $this->lang->zahost->cancel, $image->id, $image->id, in_array($image->status, array("inprogress", "created")) ? "" : "disabled");
                $image->downloadMisc = sprintf("title='%s' data-id='%s' class='btn image-download image-download-%d %s'", $this->lang->zahost->image->downloadImage, $image->id, $image->id, in_array($image->status, array("completed", "inprogress", "created"))  || $image->from == 'user' ? "disabled" : "");
            }
        }

        return $downloadedImageList;
    }

    /**
     * create image.
     *
     * @param  int    $hostID
     * @param  string $imageName
     * @access public
     * @return object
     */
    public function createImage($hostID, $imageName)
    {
        $imageList = json_decode(commonModel::http($this->config->zahost->imageListUrl, array(), array()));

        $imageData = new stdclass;
        foreach($imageList  as $item) if($item->name == $imageName) $imageData = $item;

        $imageData->host = $hostID;
        $imageData->status = 'created';
        $imageData->osName = $imageData->os;
        unset($imageData->os);

        $this->dao->insert(TABLE_IMAGE)->data($imageData, 'desc')->autoCheck()->exec();
        if(dao::isError()) return false;

        $imageID = $this->dao->lastInsertID();
        $this->loadModel('action')->create('image', $imageID, 'Created');

        return $this->getImageByID($imageID);
    }

    /**
     * Send download image command to HOST.
     *
     * @param  object    $image
     * @access public
     * @return bool
     */
    public function downloadImage($image)
    {
        $host   = $this->getById($image->host);
        $apiUrl = 'http://' . $host->extranet . ':' . $host->zap . '/api/v1/download/add';

        $apiParams['md5']  = $image->md5;
        $apiParams['url']  = $image->address;
        $apiParams['task'] = intval($image->id);

        $response = json_decode(commonModel::http($apiUrl, array($apiParams), array(CURLOPT_CUSTOMREQUEST => 'POST'), array("Authorization:$host->tokenSN"), 'json'));

        if($response and $response->code == 'success')
        {
            $this->dao->update(TABLE_IMAGE)
                ->set('status')->eq('created')
                ->where('id')->eq($image->id)->exec();
            return true;
        }

        dao::$errors[] = $this->lang->zahost->image->downloadImageFail;
        return false;
    }

    /**
     * Query image download progress.
     *
     * @param  object $image
     * @access public
     * @return object Return Status code.
     */
    public function queryDownloadImageStatus($image)
    {
        if(empty($this->imageStatusList))
        {
            $host   = $this->getById($image->host);
            $apiUrl = 'http://' . $host->extranet . ':' . $host->zap . '/api/v1/task/getStatus';

            $this->imageStatusList = $result = json_decode(commonModel::http($apiUrl, array(), array(CURLOPT_CUSTOMREQUEST => 'POST'), array("Authorization:$host->tokenSN"), 'json'));
            if(!$result or $result->code != 'success') return $image->status;
        }else{
            $result = $this->imageStatusList;
        }

        $currentTask = null;
        $is_finish   = false;
        foreach($result->data as $status => $group)
        {
            if($is_finish) break;
            foreach($group as $task)
            {
                if($is_finish) break;
                if($task->task == $image->id)
                {
                    $task->endDate = substr($task->endDate, 0, 19);
                    if(empty($currentTask) || strtotime($task->endDate) > strtotime($currentTask->endDate))
                    {
                        $currentTask = $task;
                    }
                    if($task->status == 'inprogress')
                    {
                        $currentTask = $task;
                        $is_finish   = true;
                        break;
                    }
                }
            }
        }

        if($currentTask)
        {
            $image->rate   = $currentTask->rate;
            $image->status = $currentTask->status;

            if(!empty($result->data->inprogress) && $currentTask->task != $result->data->inprogress[0]->task && $currentTask->status == 'created') $image->status = 'pending';

            $this->dao->update(TABLE_IMAGE)
                ->set('status')->eq($image->status)
                ->set('path')->eq(!empty($currentTask->path) ? $currentTask->path : '')
                ->where('id')->eq($image->id)->exec();

            $image->taskID = $currentTask->id;
        }
        else
        {
            $image->taskID = 0;
        }

        return $image;
    }

    /**
     * Query download image status.
     *
     * @param  object $image
     * @access public
     * @return object
     */
    public function downloadImageStatus($image)
    {
        $host      = $this->getById($image->host);
        $statusApi = 'http://' . $host->extranet . ':' . $host->zap . '/api/v1/task/status';

        $response = json_decode(commonModel::http($statusApi, array(), array(CURLOPT_CUSTOMREQUEST => 'GET'), array("Authorization:$host->tokenSN"), 'json'));

        if($response->code == 200) return true;

        dao::$errors[] = $response->msg;
        return false;

    }

    /**
     * Send cancel download image command to HOST.
     *
     * @param  object    $image
     * @access public
     * @return bool
     */
    public function cancelDownload($image)
    {
        $zaInfo = $this->queryDownloadImageStatus($image);
        $host   = $this->getById($image->host);
        $apiUrl = 'http://' . $host->extranet . ':' . $host->zap . '/api/v1/download/cancel';

        $apiParams['id']  = intval($zaInfo->taskID);

        $response = json_decode(commonModel::http($apiUrl, $apiParams, array(CURLOPT_CUSTOMREQUEST => 'POST'), array("Authorization:$host->tokenSN"), 'json'));

        if($response and $response->code == 'success')
        {
            $this->dao->update(TABLE_IMAGE)
                ->set('status')->eq('canceled')
                ->where('id')->eq($image->id)->exec();
            return true;
        }

        dao::$errors[] = $this->lang->zahost->image->cancelDownloadFail;
        return false;
    }

    /**
     * Get host by id.
     *
     * @param  int    $hostID
     * @access public
     * @return object
     */
    public function getById($hostID)
    {
        $host = $this->dao->select('*,id as hostID')->from(TABLE_ZAHOST)
            ->where('id')->eq($hostID)
            ->fetch();
        $host->heartbeat = empty($host->heartbeat) ? '' : $host->heartbeat;

        if(time() - strtotime($host->heartbeat) > 60 && $host->status == 'online')
        {
            $host->status = 'offline';
        }

        return $host;
    }

    /**
     * Get pairs.
     *
     * @param  string  $idFrom
     * @access public
     * @return array
     */
    public function getPairs()
    {
        return $this->dao->select("id,name")->from(TABLE_ZAHOST)
            ->where('deleted')->eq('0')
            ->andWhere('type')->eq('zahost')
            ->orderBy('`group`')
            ->fetchPairs('id', 'name');
    }

    /**
     * Get host list.
     *
     * @param  string $browseType
     * @param  int    $param
     * @param  string $orderBy
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getList($browseType = 'all', $param = 0, $orderBy = 'id_desc', $pager = null)
    {
        $query = '';
        if($browseType == 'bysearch')
        {
            /* Concatenate the conditions for the query. */
            if($param)
            {
                $query = $this->loadModel('search')->getQuery($param);
                if($query)
                {
                    $this->session->set('zahostQuery', $query->sql);
                    $this->session->set('zahostForm', $query->form);
                }
                else
                {
                    $this->session->set('zahostQuery', ' 1 = 1');
                }
            }
            else
            {
                if($this->session->zahostQuery == false) $this->session->set('zahostQuery', ' 1 = 1');
            }
            $query = $this->session->zahostQuery;
        }

        $list = $this->dao->select('*,id as hostID')->from(TABLE_ZAHOST)
            ->where('deleted')->eq('0')
            ->andWhere('type')->eq('zahost')
            ->beginIF($query)->andWhere($query)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();

        foreach($list as $host)
        {
            $host->heartbeat = empty($host->heartbeat) ? '' : $host->heartbeat;
            if(time() - strtotime($host->heartbeat) > 60 && $host->status == 'online')
            {
                $host->status = 'offline';
            }
        }

        return $list;
    }

    /**
     * Get zanode group by zahost.
     *
     * @access public
     * @return void
     */
    public function getHostNodeGroup()
    {
        return $this->dao->select('t1.id as hostID, t2.*')->from(TABLE_ZAHOST)->alias('t1')
            ->leftJoin(TABLE_ZAHOST)->alias('t2')->on('t2.parent = t1.id')
            ->where('t2.deleted')->eq('0')
            ->andWhere('t1.deleted')->eq('0')
            ->fetchGroup('hostID', 'id');
    }

    /**
     * Build test task menu.
     *
     * @param  object $host
     * @param  string $type
     * @access public
     * @return string
     */
    public function buildOperateMenu($host, $type = 'view')
    {
        $function = 'buildOperate' . ucfirst($type) . 'Menu';
        return $this->$function($host);
    }

    /**
     * Build test task view menu.
     *
     * @param  object $host
     * @access public
     * @return string
     */
    public function buildOperateViewMenu($host)
    {
        if($host->deleted) return '';
        $nodeList = $this->loadModel('zanode')->getListByHost($host->id);
        $disabled = '';
        $title    = !empty($nodeList) ? $this->lang->zahost->undeletedNotice : $this->lang->zahost->delete;
        if($nodeList) $disabled = 'disabled';

        $menu   = '';
        $params = "hostID=$host->id";

        $menu  .= $this->buildMenu('zahost', 'browseImage', $params, $host, 'view', 'mirror', '', 'iframe', true, '', $this->lang->zahost->image->browseImage);
        $menu  .= "<div class='divider'></div>";
        $menu  .= $this->buildMenu('zahost', 'edit',   $params, $host, 'view');
        $menu  .= $this->buildMenu('zahost', 'delete', $params, $host, 'view', 'trash', 'hiddenwin', $disabled, true, '', $title);

        return $menu;
    }

    /**
     * Get image pairs by host.
     *
     * @param  int    $hostID
     * @access public
     * @return array
     */
    public function getImagePairs($hostID)
    {
        return $this->dao->select('id,name')->from(TABLE_IMAGE)->where('host')->eq($hostID)->andWhere('status')->eq('completed')->fetchPairs();
    }

    /**
     * Get service status from ZAgent server.
     *
     * @param  object $host
     * @access public
     * @return array
     */
    public function getServiceStatus($host)
    {
        if(in_array($host->status, array('wait', 'offline'))) return $this->lang->zahost->init->serviceStatus;
        $result = json_decode(commonModel::http("http://{$host->extranet}:{$host->zap}/api/v1/service/check", json_encode(array("services" => "all")), array(), array("Authorization:$host->tokenSN")));
        if(empty($result) || $result->code != 'success')
        {
            $result = new stdclass;
            $result->data = $this->lang->zahost->init->serviceStatus;
        }

        return $result->data;
    }
}
