<?php
/**
 * The control file of artifactrepo module of QuCheng.
 *
 * @copyright Copyright 2021-2022 北京渠成软件有限公司(BeiJing QuCheng Software Co,LTD, www.qucheng.com)
 * @license   ZPL (http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author    Jianhua Wang <wangjianhua@easycorp.ltd>
 * @package   artifactrepo
 * @version   $Id$
 * @link      https://www.qucheng.com
 */
class artifactrepo extends control
{
    /**
     * Browse artifactrepo.
     *
     * @param  int    $param
     * @param  string $type
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
       @access public
     * @return void
     */
    public function browse($browseType = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 25, $pageID = 1)
    {
        /* Load pager. */
        $this->app->loadClass('pager', true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $artifactRepos = $this->artifactrepo->getList($orderBy, $pager);

        $this->view->title          = $this->lang->artifactrepo->common;
        $this->view->orderBy        = $orderBy;
        $this->view->pager          = $pager;
        $this->view->browseType     = $browseType;
        $this->view->recTotal       = $recTotal;
        $this->view->recPerPage     = $recPerPage;
        $this->view->artifactRepos  = $artifactRepos;
        $this->view->products       = $this->loadModel('product')->getPairs('all', 0, '', 'all');
        $this->view->pageLink       = $this->createLink('artifactrepo', 'browse', "browseType={$browseType}&orderBy={$orderBy}&recTotal={$recTotal}&recPerPage={$recPerPage}&pageID={$pageID}");

        $this->display();
    }

    /**
     * 创建一个制品库。
     * Create a artifactrepo.
     *
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $repo = form::data($this->config->artifactrepo->form->create)
                ->join('products', ',')
                ->add('editedBy',  $this->app->user->account)
                ->add('createdBy', $this->app->user->account)
                ->add('createdDate', helper::now())
                ->get();
            if($repo->products) $repo->products = ',' . $repo->products . ',';

            $repoID = $this->artifactrepo->create($repo);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('artifactRepo', $repoID, 'created');
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'load' => inlink('browse')));
        }

        $nexusList = $this->loadModel('pipeline')->getPairs('nexus');

        $this->view->title     = $this->lang->artifactrepo->create;
        $this->view->nexusList = $nexusList;
        $this->view->products  = $this->loadModel('product')->getPairs('', 0, '', 'all');

        $this->display();
    }

    /**
     * 编辑一个制品库。
     * Edit a artifact repo.
     *
     * @param  int    $artifactRepoID
     * @access public
     * @return viod
     */
    public function edit(int $artifactRepoID)
    {
        if($_POST)
        {
            $repo = form::data($this->config->artifactrepo->form->edit)
                ->join('products', ',')
                ->add('editedBy', $this->app->user->account)
                ->add('editedDate', helper::now())
                ->get();
            if($repo->products) $repo->products = ',' . $repo->products . ',';

            $changes = $this->artifactrepo->update($repo, $artifactRepoID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $artifactRepo = $this->artifactrepo->getByID($artifactRepoID);

        $products           = $this->loadModel('product')->getPairs('', 0, '', 'all');
        $linkedProducts     = $this->loadModel('product')->getByIdList(explode(',', $artifactRepo->products));
        $linkedProductPairs = array_combine(array_keys($linkedProducts), helper::arrayColumn($linkedProducts, 'name'));
        $products           = $products + $linkedProductPairs;

        $this->view->title        = $this->lang->artifactrepo->edit;
        $this->view->artifactRepo = $artifactRepo;
        $this->view->products     = $products;

        $this->display();
    }

    public function delete(int $artifactRepoID, string $confirm = 'no')
    {
        if($confirm == 'yes')
        {
            $linkBuild = $this->dao->select('*')->from(TABLE_BUILD)->where('artifactRepoID')->eq($artifactRepoID)->fetch();
            if($linkBuild) return $this->send(array('result' => 'fail', 'message' => $this->lang->artifactrepo->deleteError));

            $this->artifactrepo->delete(TABLE_ARTIFACTREPO, $artifactRepoID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            return $this->send(array('result' => 'success', 'load' => true));
        }

    }

    /**
     * ajax方式获取版本库列表。
     * Get artifact repos by ajax.
     *
     * @param  int    $serverID
     * @access public
     * @return void
     */
    public function ajaxGetArtifactRepos(int $serverID)
    {
        $repos = $this->artifactrepo->getServerRepos($serverID);

        if(!$repos['result']) return $this->send(array('result' => 'fail', 'message' => $this->lang->artifactrepo->loseConnect));

        return print(json_encode($repos['data']));
    }

    public function ajaxUpdateArtifactRepos()
    {
        $artifactRepos = $this->artifactrepo->getList();
        $serverRepos   = array();
        foreach($artifactRepos as $repo)
        {
            if(!isset($serverRepos[$repo->serverID])) $serverRepos[$repo->serverID] = $this->artifactrepo->getServerRepos($repo->serverID);
        }

        $hasUpdate = false;
        foreach($artifactRepos as $repo)
        {
            if(!isset($serverRepos[$repo->serverID])) continue;
            foreach($serverRepos[$repo->serverID]['data'] as $serverRepo)
            {
                $serverRepo->onlineStatus = $serverRepo->online ? 'online' : 'offline';
                if($serverRepo->name == $repo->repoName && $serverRepo->onlineStatus != $repo->status)
                {
                    $this->artifactrepoZen->updateStatus($repo->id, $serverRepo->onlineStatus);
                    $hasUpdate = true;
                }
            }
        }

        return print(json_encode(array('hasUpdate' => $hasUpdate)));
    }
}
