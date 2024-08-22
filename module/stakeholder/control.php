<?php
class stakeholder extends control
{
    /**
     * Stakeholder list.
     *
     * @param  int    $projectID
     * @param  string $browseType
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function browse($projectID, $browseType = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $this->loadModel('project')->setMenu($projectID);

        $stakeholders = $this->stakeholder->getStakeholders($projectID, $browseType, $orderBy, $pager);

        $this->view->title       = $this->lang->stakeholder->browse;
        $this->view->position[]  = $this->lang->stakeholder->browse;

        $this->view->pager        = $pager;
        $this->view->recTotal     = $recTotal;
        $this->view->recPerPage   = $recPerPage;
        $this->view->pageID       = $pageID;
        $this->view->projectID    = $projectID;
        $this->view->orderBy      = $orderBy;
        $this->view->browseType   = $browseType;
        $this->view->stakeholders = $stakeholders;

        $this->display();
    }

    /**
     * Create a stakeholder.
     *
     * @param  int objectID
     * @access public
     * @return void
     */
    public function create($objectID = 0)
    {
        if($_POST)
        {
            $stakeholderID = $this->stakeholder->create($objectID);

            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;

            if(!$stakeholderID or dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            $actionID = $this->loadModel('action')->create('stakeholder', $stakeholderID, 'added');
            if($this->viewType == 'json') return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'id' => $stakeholderID));

            $moduleName = $this->app->tab == 'program' ? 'program'              : $this->moduleName;
            $methodName = $this->app->tab == 'program' ? 'stakeholder'          : 'browse';
            $param      = $this->app->tab == 'program' ? "programID=$objectID" : "projectID=$objectID";
            $locate     = $this->createLink($moduleName, $methodName, $param);
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $locate));
        }

        $members = array();
        if($this->app->tab == 'program')
        {
            $this->loadModel('program')->setMenu($objectID);
            $members = $this->loadModel('program')->getTeamMemberPairs($objectID);
        }
        else
        {
            $this->loadModel('project')->setMenu($objectID);
            $members = $this->loadModel('user')->getTeamMemberPairs($objectID, 'project');
        }

        $stakeholders = $this->loadModel('stakeholder')->getStakeHolderPairs($objectID);
        foreach($members as $account => $realname)
        {
            if(isset($stakeholders[$account])) unset($members[$account]);
        }

        $this->view->title      = $this->lang->stakeholder->create;
        $this->view->position[] = $this->lang->stakeholder->create;
        $this->view->companys   = $this->loadModel('company')->getOutsideCompanies();
        $this->view->programID  = $this->app->tab == 'program' ? $objectID : 0;
        $this->view->projectID  = $this->app->tab == 'project' ? $objectID : 0;
        $this->view->members    = $members;

        $this->display();
    }

    /**
     * Batch create stakeholders.
     *
     * @param  int    $projectID
     * @param  string $dept
     * @param  string $dept
     * @access public
     * @return void
     */
    public function batchCreate($projectID, $dept = '', $parentID = 0)
    {
        if($_POST)
        {
            $stakeholderList = $this->stakeholder->batchCreate($projectID);
            if($this->viewType == 'json') return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'idList' => $stakeholderList));
            return print(js::locate($this->createLink('stakeholder', 'browse', "projectID=$projectID"), 'parent'));
        }

        if($this->app->tab == 'program')
        {
            $this->loadModel('program')->setMenu($projectID);
        }
        else
        {
            $this->loadModel('project')->setMenu($projectID);
        }

        $this->loadModel('user');
        $this->loadModel('dept');
        $this->loadModel('execution');
        $deptUsers = $dept === '' ? array() : $this->dept->getDeptUserPairs($dept);

        $this->view->title      = $this->lang->stakeholder->batchCreate;
        $this->view->position[] = $this->lang->stakeholder->batchCreate;

        $this->view->project            = $this->loadModel('project')->getByID($this->session->project);
        $this->view->users              = $this->user->getPairs('all|nodeleted|noclosed');
        $this->view->deptUsers          = $deptUsers;
        $this->view->dept               = $dept;
        $this->view->projectID          = $projectID;
        $this->view->depts              = array('' => '') + $this->dept->getOptionMenu();
        $this->view->stakeholders       = $this->stakeholder->getStakeholders($projectID, 'all', 'id_desc');
        $this->view->parentStakeholders = $this->loadModel('program')->getStakeholders($parentID, 't1.id_desc');

        $this->display();
    }

    /**
     * Edit a stakeholder.
     *
     * @param  int $stakeholderID
     * @access public
     * @return void
     */
    public function edit($stakeholderID = 0)
    {
        $stakeholder = $this->stakeholder->getByID($stakeholderID);
        $this->loadModel('project')->setMenu($stakeholder->objectID);

        if($_POST)
        {
            $changes = $this->stakeholder->edit($stakeholderID);

            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;

            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            $actionID = $this->loadModel('action')->create('stakeholder', $stakeholderID, 'Edited');
            $this->action->logHistory($actionID, $changes);
            $response['locate'] = $this->createLink('stakeholder', 'browse', "projectID=$stakeholder->objectID");
            return $this->send($response);
        }

        $users = array('' => '');
        if($stakeholder->from == 'team') $users = $this->loadModel('user')->getTeamMemberPairs($this->session->project, 'project');
        elseif($stakeholder->from == 'company')
        {
            $members = $this->loadModel('user')->getTeamMemberPairs($this->session->project, 'project');
            $users   = $this->user->getPairs('noclosed');
            $users   = array('' => '') + array_diff($users, $members);
        }

        $this->view->title       = $this->lang->stakeholder->edit;
        $this->view->position[]  = $this->lang->stakeholder->edit;

        $this->view->stakeholder = $stakeholder;
        $this->view->users       = $users;
        $this->view->companys    = $this->loadModel('company')->getOutsideCompanies();
        $this->display();
    }

    /**
     * Ajax get members.
     *
     * @param  string $user
     * @param  int    $programID
     * @param  int    $projectID
     * @access public
     * @return void
     */
    public function ajaxGetMembers($user = '', $programID = 0, $projectID = 0)
    {
        if($programID)
        {
            $members = $this->loadModel('program')->getTeamMemberPairs($programID);
        }
        else
        {
            $members = $this->loadModel('user')->getTeamMemberPairs($projectID, 'project');
        }
        $stakeholders = $this->loadModel('stakeholder')->getStakeHolderPairs($programID ? $programID : $projectID);
        foreach($members as $account => $realname)
        {
            if(isset($stakeholders[$account])) unset($members[$account]);
        }

        echo html::select('user', $members, $user, "class='form-control chosen'");
    }

    /**
     * Ajax get company user.
     *
     * @param  string $user
     * @param  int    $programID
     * @param  int    $projectID
     * @access public
     * @return void
     */
    public function ajaxGetCompanyUser($user = '', $programID = 0, $projectID = 0)
    {
        if($programID)
        {
            $members = $this->loadModel('program')->getTeamMemberPairs($programID);
        }
        else
        {
            $members = $this->loadModel('user')->getTeamMemberPairs($projectID, 'project');
        }

        $users        = $this->loadModel('user')->getPairs('noclosed');
        $companyUsers = array('' => '') + array_diff($users, $members);
        $stakeholders = $this->loadModel('stakeholder')->getStakeHolderPairs($programID ? $programID : $projectID);
        foreach($companyUsers as $account => $realname)
        {
            if(isset($stakeholders[$account])) unset($companyUsers[$account]);
        }

        echo html::select('user', $companyUsers, $user, "class='form-control chosen'");
    }

    /**
     * Ajax get outside user.
     *
     * @access public
     * @return void
     */
    public function ajaxGetOutsideUser($objectID = 0)
    {
        $users        = $this->loadModel('user')->getPairs('noclosed|outside|noletter');
        $stakeholders = $this->loadModel('stakeholder')->getStakeHolderPairs($objectID);
        foreach($users as $account => $realname)
        {
            if(isset($stakeholders[$account])) unset($users[$account]);
        }

        echo html::select('user', $users, '', "class='form-control chosen' onchange=changeUser(this.value);");
    }

    /**
     * Ajax get control.
     *
     * @access public
     * @return void
     */
    public function ajaxGetControl($activityID = 0)
    {
        $plan      = $this->dao->select('*')->from(TABLE_INTERVENTION)->where('activity')->eq($activityID)->fetch();
        $begin     = html::input("begin[$activityID]", isset($plan->begin) ? $plan->begin : '', 'class="form-control form-date"');
        $realBegin = html::input("realBegin[$activityID]", isset($plan->realBegin) ? $plan->realBegin: '', 'class="form-control form-date"');
        $status    = html::select("status[$activityID]", $this->lang->stakeholder->planField->stautsList, isset($plan->status) ? $plan->status : '', 'class="form-control"');
        $situation = html::select("situation[$activityID]", $this->lang->stakeholder->situationList, isset($plan->situation) ? $plan->situation : '', 'class="form-control"');

        $stakeholders = $this->stakeholder->getListByType();
        $partakeList = isset($plan->partake) ? json_decode($plan->partake) : new stdclass();
        $insideList  = array("<td style='width: 100px;'></td>");
        $outsideList = array("<td style='width: 100px;'></td>");
        if(isset($stakeholders['inside']))
        {
            $insideList = array();
            foreach($stakeholders['inside'] as $user)
            {
                $partake = isset($partakeList->{$user->account}) ? $partakeList->{$user->account} : '';
                $insideList[] = "<td style='width: 100px;'>" . html::select("partake[$activityID][$user->account]", $this->lang->stakeholder->planField->partakeList, $partake, "class='form-control'") . '</td>';
            }
        }

        if(isset($stakeholders['outside']))
        {
            $outsideList = array();
            foreach($stakeholders['outside'] as $user)
            {
                $partake = isset($partakeList->{$user->account}) ? $partakeList->{$user->account} : '';
                $outsideList[] = "<td style='width: 100px;'>" . html::select("partake[$activityID][$user->account]", $this->lang->stakeholder->planField->partakeList, $partake, "class='form-control'") . '</td>';
            }
        }

        $partakeList = array_merge($insideList, $outsideList);

        echo json_encode(array('begin' => $begin, 'realBegin' => $realBegin, 'status' => $status, 'situation' => $situation, 'partakeList' => $partakeList));
    }

    /**
     * Deleted user.
     *
     * @access public
     * @param  int    $userID
     * @param  string $confirm  yes|no
     * @return void
    */
    public function delete($userID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->stakeholder->confirmDelete, inLink('delete', "userID=$userID&confirm=yes")));
        }
        else
        {
            $stakeholder = $this->stakeholder->getByID($userID);
            $this->stakeholder->delete(TABLE_STAKEHOLDER, $userID);
            $this->loadModel('user')->updateUserView($this->session->project, 'project');

            /* Update linked products view. */
            if($stakeholder->objectType == 'project' and $stakeholder->objectID)
            {
                $this->loadModel('project')->updateInvolvedUserView($stakeholder->objectID, $stakeholder->user);
            }
            return print(js::reload('parent'));
        }
    }

    /**
     * User details.
     *
     * @access public
     * @param  int  $userID
     * @return void
    */
    public function view($userID = 0)
    {
        $user = $this->stakeholder->getByID($userID);
        $this->loadModel('project')->setMenu($user->objectID);
        $this->commonAction($userID, 'stakeholder');

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->view;
        $this->view->position[] = $this->lang->stakeholder->view;

        $this->view->user    = $user;
        $this->view->users   = $this->loadModel('user')->getTeamMemberPairs($this->session->project, 'project', 'nodeleted');
        $this->view->expects = $this->stakeholder->getExpectByUser($userID);

        $this->display();
    }

    /**
     * Add communication record.
     *
     * @access public
     * @param  int  $userID
     * @return void
    */
    public function communicate($userID)
    {
        $this->commonAction($userID, 'stakeholder');
        if(!empty($_POST))
        {
            $result = $this->stakeholder->communicate($userID);
            if(dao::isError()) return print(js::error(dao::getError()));
            if(isonlybody()) return print(js::closeModal('parent.parent', 'this'));
        }

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->communicate;
        $this->view->position[] = $this->lang->stakeholder->view;
        $this->view->user       = $this->stakeholder->getByID($userID);
        $this->view->users      = $this->loadModel('user')->getTeamMemberPairs($this->session->project, 'project', 'nodeleted');
        $this->display();
    }

    /**
     * Add expect record.
     *
     * @access public
     * @param  int  $expectID
     * @return void
    */
    public function expect($expectID)
    {
        $user = $this->stakeholder->getByID($expectID);

        if(!empty($_POST))
        {
            $expectID = $this->stakeholder->expect($user->id);
            if(dao::isError()) return print(js::error(dao::getError()));

            return print(js::closeModal('parent.parent', 'this'));
        }

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->communicate;
        $this->view->position[] = $this->lang->stakeholder->view;
        $this->view->user       = $user;
        $this->display();
    }

    /**
     * Common actions of stakeholder module.
     *
     * @param  int    $stakeholderID
     * @access public
     * @return void
     */
    public function commonAction($stakeholderID, $object)
    {
        $this->view->actions = $this->loadModel('action')->getList($object, $stakeholderID);
    }

    /**
     * Issue details.
     *
     * @access public
     * @param  int  $userID
     * @return void
    */
    public function userIssue($userID)
    {
        $this->app->loadLang('issue');
        $stakeholder = $this->stakeholder->getByID($userID);

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->communicate;
        $this->view->position[] = $this->lang->stakeholder->view;

        $this->view->stakeholder = $stakeholder;
        $this->view->projectID   = $stakeholder->objectID;
        $this->view->issueList   = $this->stakeholder->getStakeholderIssue($stakeholder->user);

        $this->display();
    }
}
