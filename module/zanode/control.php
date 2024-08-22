<?php
/**
 * The control file of ZenAgent Node of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      liyuchun <liyuchun@easycorp.ltd>
 * @package     qa
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class zanode extends control
{

    /**
     * Browse ZenAgent Node page.
     *
     * @param  string   $browseType
     * @param  string   $param
     * @param  string   $orderBy
     * @param  int      $recTotal
     * @param  int      $recPerPage
     * @param  int      $pageID
     * @access public
     * @return void
     */
    public function browse($browseType = 'all', $param = 0, $orderBy = 't1.id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $browseType = strtolower($browseType);

        $this->app->loadClass('pager', $static = true);

        $queryID  = ($browseType == 'bysearch')  ? (int)$param : 0;
        $pager    = pager::init($recTotal, $recPerPage, $pageID);
        $nodeList = $this->zanode->getListByQuery($browseType, $queryID, $orderBy, $pager);
        $hosts    = $this->loadModel('zahost')->getPairs('host');

        /* Build the search form. */
        $actionURL = $this->createLink('zanode', 'browse', "browseType=bySearch&queryID=myQueryID");
        $this->config->zanode->search['actionURL'] = $actionURL;
        $this->config->zanode->search['queryID']   = $queryID;
        $this->config->zanode->search['onMenuBar'] = 'no';
        $this->config->zanode->search['params']['host']['values'] = array('' => '') + $hosts;
        $this->loadModel('search')->setSearchParams($this->config->zanode->search);

        $showFeature = false;
        $accounts = !empty($this->config->global->skipAutomation) ? $this->config->global->skipAutomation : '';
        if(strpos(",$accounts,", $this->app->user->account) === false)
        {
            $showFeature = true;
            $accounts .= ',' . $this->app->user->account;
            $this->loadModel('setting')->setItem('system.common.global.skipAutomation', $accounts);
        }

        $this->view->title       = $this->lang->zanode->common;
        $this->view->users       = $this->loadModel('user')->getPairs('noletter|nodeleted');
        $this->view->nodeList    = $nodeList;
        $this->view->pager       = $pager;
        $this->view->param       = $param;
        $this->view->orderBy     = $orderBy;
        $this->view->browseType  = $browseType;
        $this->view->showFeature = $showFeature;

        $this->display();
    }

    /**
     * Browse ZenAgent Node list in zahost view.
     *
     * @param  int    $hostID
     * @param  string $orderBy
     * @access public
     * @return void
     */
    public function nodeList($hostID, $orderBy = 'id_desc')
    {
        if(!commonModel::hasPriv('zanode', 'browse'))
        {
            $this->loadModel('common')->deny('zanode', 'browse', false);
        }

        $this->view->title    = $this->lang->zanode->common;
        $this->view->nodeList = $this->zanode->getListByHost($hostID, $orderBy);
        $this->view->orderBy  = $orderBy;
        $this->view->hostID   = $hostID;

        $this->display();
    }

    /**
     * Create node.
     *
     * @param  int    $hostID
     * @access public
     * @return void
     */
    public function create($hostID = 0)
    {
        if(!empty($_POST))
        {
            $nodeID = $this->zanode->create();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('view', "id=$nodeID")));
        }

        $this->view->title     = $this->lang->zanode->create;
        $this->view->hostPairs = array('' => '') + $this->loadModel('zahost')->getPairs($this->session->product);
        $this->view->hostID    = $hostID;

        return $this->display();
    }

    /**
     * Edit node.
     *
     * @param  int    $id
     * @access public
     * @return void
     */
    public function edit($id)
    {
        if($_POST)
        {
            $changes = $this->zanode->update($id);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('zanode', $id, 'Edited');
                if(!empty($changes)) $this->action->logHistory($actionID, $changes);
            }

            if(isonlybody()) return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $zanode = $this->zanode->getNodeByID($id);

        $this->view->title  = $this->lang->zanode->editAction;
        $this->view->zanode = $zanode;
        if($zanode->type == 'node')
        {
            $this->view->host  = $this->zanode->getHostByID($this->view->zanode->parent);
            $this->view->image = $this->zanode->getImageByID($this->view->zanode->image);
        }
        $this->display();
    }

    /**
     * View Node.
     *
     * @param  int    $id
     * @access public
     * @return void
     */
    public function view($id)
    {
        $node = $this->zanode->getNodeByID($id);
        $vnc  = $this->zanode->getVncUrl($node);

        $this->view->url          = $node->ip . ":" . $node->hzap;
        $this->view->host         = !empty($vnc->hostIP) ? $vnc->hostIP:'';
        $this->view->token        = !empty($vnc->token) ? $vnc->token:'';
        $this->view->title        = $this->lang->zanode->view;
        $this->view->zanode       = $node;
        $this->view->snapshotList = $this->zanode->getSnapshotList($id);
        $this->view->initBash     = sprintf(zget($this->config->zanode->versionToOs, $node->osName, '') != '' ? $this->config->zanode->initPosh : $this->config->zanode->initBash, $node->secret, getWebRoot(true));
        $this->view->actions      = $this->loadModel('action')->getList('zanode', $id);
        $this->view->users        = $this->loadModel('user')->getPairs('noletter');

        $this->display();
    }

    /**
     * start Node.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function start($nodeID)
    {
        $this->handleNode($nodeID, 'boot');
    }

    /**
     * shutdown Node.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function close($nodeID)
    {
        $this->handleNode($nodeID, 'destroy');
    }

    /**
     * Suspend Node.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function suspend($nodeID)
    {
        $this->handleNode($nodeID, 'suspend');
    }

    /**
     * Reboot Node.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function reboot($nodeID)
    {
        $this->handleNode($nodeID, 'reboot');
    }

    /**
     * Resume Node.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function resume($nodeID)
    {
        $this->handleNode($nodeID, 'resume');
    }

    /**
     * Boot node.
     *
     * @param  int    $nodeID
     * @param  string $type
     * @return void
     */
    public function handleNode($nodeID, $type)
    {
        $error = $this->zanode->handleNode($nodeID, $type);

        if($error)
        {
            return print(js::alert($error) . js::reload('parent'));
        }
        else
        {
            return print(js::alert($this->lang->zanode->actionSuccess) . js::reload('parent'));
        }
    }

    /**
     * Create custom image.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function createImage($nodeID = 0)
    {
        $task        = '';
        $node        = $this->zanode->getNodeByID($nodeID);
        $customImage = $this->zanode->getCustomImage($nodeID, 'created,inprogress');
        if($customImage) $task = $this->zanode->getTaskStatus($node, $customImage->id, 'exportVm');

        if($_POST)
        {
            $this->zanode->createImage($nodeID);

            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->task = $task;
        $this->view->node = $node;
        $this->view->rate = !empty($task->rate) ? $task->rate : 0;
        $this->display();
    }

    /**
     * Create snapshot.
     *
     * @param  int    $zanodeID
     * @access public
     * @return void
     */
    public function createSnapshot($nodeID = 0)
    {
        $node = $this->zanode->getNodeByID($nodeID);

        if($_POST)
        {
            $this->zanode->createSnapshot($nodeID);

            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));
        }

        $this->view->node = $node;
        $this->display();
    }

    /**
     * Edit Snapshot.
     *
     * @param int $snapshotID
     * @access public
     * @return void
     */
    public function editSnapshot($snapshotID)
    {
        $snapshot = $this->zanode->getImageByID($snapshotID);
        if($_POST)
        {
            $this->zanode->editSnapshot($snapshotID);

            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }
            $this->loadModel('action')->create('zanode', $snapshot->host, 'editSnapshot', '', $snapshot->localName ? $snapshot->localName : $snapshot->name);
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));
        }

        $this->view->snapshot = $snapshot;
        $this->display();
    }

    /**
     * Delete Snapshot.
     *
     * @param  int    $snapshotID
     * @param  string $confirm
     * @access public
     * @return void
     */
    public function deleteSnapshot($snapshotID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->zanode->confirmDeleteSnapshot, inlink('deleteSnapshot', "snapshotID={$snapshotID}&confirm=yes")));
        }

        $result = $this->zanode->deleteSnapshot($snapshotID);

        if($result !== true)
        {
            return print(js::alert($result));
        }
        else
        {
            if(isonlybody()) return print(js::alert($this->lang->zanode->actionSuccess) . js::reload('parent.parent'));
            return print(js::alert($this->lang->zanode->actionSuccess) . js::locate($this->createLink('zanode', 'browse'), 'parent'));
        }
    }

    /**
     * Desctroy node.
     *
     * @param  int    $nodeID
     * @param  string $confirm
     * @return void
     */
    public function destroy($nodeID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->zanode->confirmDelete, inlink('destroy', "zanodeID={$nodeID}&confirm=yes")));
        }

        $error = $this->zanode->destroy($nodeID);

        if(!empty($error))
        {
            return print(js::alert($error));
        }
        else
        {
            return print(js::alert($this->lang->zanode->actionSuccess) . js::locate($this->createLink('zanode', 'browse'), 'parent.parent'));
        }
    }

    /**
     * Bring up novmc management view.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function getVNC($nodeID)
    {
        $node = $this->zanode->getNodeByID($nodeID);
        $vnc  = $this->zanode->getVncUrl($node);

        /* Add action log. */
        if(!empty($vnc->token)) $this->loadModel('action')->create('zanode', $nodeID, 'getVNC');

        $this->view->title = $this->lang->zanode->getVNC;
        $this->view->url   = $node->ip . ":" . $node->hzap;
        $this->view->host  = !empty($vnc->hostIP) ? $vnc->hostIP:'';
        $this->view->token = !empty($vnc->token) ? $vnc->token:'';
        $this->display();
    }

    /**
     * Browse snapshot.
     *
     * @param int    $nodeID
     * @param string $browseType
     * @param int    $param
     * @param string $orderBy
     * @param int    $recTotal
     * @param int    $recPerPage
     * @param int    $pageID
     * @access public
     * @return void
     */
    public function browseSnapshot($nodeID, $browseType = 'all', $param = 0, $orderBy = 'id', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadLang('zahost');
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $snapshotList = $this->zanode->getSnapshotList($nodeID, $orderBy, $pager);

        $this->view->title        = $this->lang->zanode->browseSnapshot;
        $this->view->nodeID       = $nodeID;
        $this->view->node         = $this->zanode->getNodeByID($nodeID);
        $this->view->snapshotList = $snapshotList;
        $this->view->users        = $this->loadModel('user')->getPairs('noletter');
        $this->view->pager        = $pager;
        $this->view->param        = $param;
        $this->view->orderBy      = $orderBy;
        $this->view->browseType   = $browseType;

        $this->display();
    }

    /**
     * Restore node.
     *
     * @param  int    $nodeID
     * @param  int    $snapshotID
     * @param  string $confirm
     * @return void
     */
    public function restoreSnapshot($nodeID, $snapshotID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->zanode->confirmRestore, inlink('restoreSnapshot', "nodeID={$nodeID}&snapshotID={$snapshotID}&confirm=yes")));
        }

        $this->zanode->restoreSnapshot($nodeID, $snapshotID);

        if(dao::isError())
        {
            $errors = dao::getError();
            if(is_array($errors)) $errors = implode(',', $errors);
            return print(js::alert($errors) . js::reload('parent'));
        }
        else
        {
            if(isonlybody()) return print(js::alert($this->lang->zanode->actionSuccess) . js::reload('parent.parent'));
            return print(js::alert($this->lang->zanode->actionSuccess) . js::locate($this->createLink('zanode', 'browse'), 'parent'));
        }
    }

    /**
     * Ajax get template pairs by api.
     *
     * @param  int    $hostID
     * @access public
     * @return void
     */
    public function ajaxGetImages($hostID)
    {
        $templatePairs = $this->loadModel('zahost')->getImagePairs($hostID);

        return print(html::select('image', $templatePairs, '', "class='form-control chosen'"));
    }

    /**
     * Ajax get template info.
     *
     * @param  int    $imageID
     * @access public
     * @return void
     */
    public function ajaxGetImage($imageID)
    {
        $template = $this->loadModel('zahost')->getImageByID($imageID);
        return print(json_encode($template));
    }

    /**
     * Ajax get task status.
     *
     * @param  int    $nodeID
     * @param  int    $taskID
     * @param  string $type
     * @param  string $status
     * @access public
     * @return void
     */
    public function ajaxGetTaskStatus($nodeID, $taskID = 0, $type = '', $status = '')
    {
        $node   = $this->zanode->getNodeByID($nodeID);
        $result = $this->zanode->getTaskStatus($node, $taskID, $type, $status);
        return print(json_encode($result));
    }

    /**
     * Update image.
     *
     * @param  int    $imageID
     * @access public
     * @return void
     */
    public function ajaxUpdateImage($imageID = 0)
    {
        if($_POST)
        {
            $data = fixer::input('post')->get();
            $this->dao->update(TABLE_IMAGE)->data($data)->where('id')->eq($imageID)->autoCheck()->exec();

            $response = array();
            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;
            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
            }
            return $this->send($response);
        }
    }

    /**
     * Check service status by ajax.
     *
     * @param  int    $nodeID
     * @access public
     * @return void
     */
    public function ajaxGetServiceStatus($hostID)
    {
        $node          = $this->zanode->getNodeById($hostID);
        $serviceStatus = $this->zanode->getServiceStatus($node);
        if ($node->status != 'running')
        {
            $serviceStatus['ZenAgent'] = 'unknown';
            $serviceStatus['ZTF']      = 'unknown';
        }
        $node->status = $node->status == 'online' ? 'ready' : $node->status;
        $serviceStatus['node'] = $node->status;

        return $this->send(array('result' => 'success', 'message' => '', 'data' => $serviceStatus));
    }

    /**
     * Install service by ajax.
     *
     * @param  int    $nodeID
     * @param  string $service
     * @access public
     * @return void
     */
    public function ajaxInstallService($nodeID, $service)
    {
        $node   = $this->zanode->getNodeById($nodeID);
        $result = $this->zanode->installService($node, $service);

        return $this->send(array('result' => 'success', 'message' => '', 'data' => $result));
    }

    /**
     * Ajax: get ZTF script.
     *
     * @param string $type
     * @param int    $objectID
     * @access public
     * @return void
     */
    public function ajaxGetZTFScript($type = 'product', $objectID = 0)
    {
        $script = array();
        if($type == '')        $script = $this->zanode->getAutomationByID($objectID);
        if($type == 'product') $script = $this->zanode->getAutomationByProduct($objectID);
        return $this->send(array('result' => 'success', 'data' => $script));
    }

    /**
     * Ajax: run ZTF script.
     *
     * @param  int    $scriptID
     * @param  string $taskID
     * @access public
     * @return void
     */
    public function ajaxRunZTFScript($scriptID = 0, $taskID = 0)
    {
        if($_POST)
        {
            $caseIDList = $_POST['caseIDList'];
            $runIDList  = empty($_POST['runIDList']) ? array() : $_POST['runIDList'];
            $script     = $this->zanode->getAutomationByID($scriptID);
            $cases      = $this->loadModel('testcase')->getByList($caseIDList);

            $runs = array();
            if($taskID)
            {
                $runs = $this->dao->select('id, `case`')->from(TABLE_TESTRUN)
                ->where('`case`')->in($caseIDList)
                ->andWhere('task')->eq($taskID)->fi()
                ->fetchPairs('case', 'id');
            }

            $caseIDListArray = explode(',', $caseIDList);
            $runIDListArray  = explode(',', $runIDList);
            $case2RunMap     = array();

            foreach($caseIDListArray as $index => $caseID) $case2RunMap[$caseID] = empty($runIDListArray[$index]) ? 0 : $runIDListArray[$index];

            foreach($cases as $id => $case)
            {
                if($case->auto != 'auto') continue;
                $resultID = $this->loadModel('testtask')->initResult($case2RunMap[$id], $id, $case->version, $script->node);
                if(!dao::isError()) $this->zanode->runZTFScript($script->id, $id, $resultID);
            }

            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => 'success'));
        }
    }

    /**
     * Ajax：get nodes.
     *
     * @access public
     * @return void
     */
    public function ajaxGetNodes()
    {
        $nodeList = $this->zanode->getPairs();
        return print(html::select("node", $nodeList, '', "class='form-control picker-select'"));
    }
}
