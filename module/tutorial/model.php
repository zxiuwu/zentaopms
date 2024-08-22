<?php
/**
 * The model file of tutorial module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     tutorial
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class tutorialModel extends model
{
    /**
     * Check novice.
     *
     * @access public
     * @return bool
     */
    public function checkNovice()
    {
        $account = $this->app->user->account;
        if($account == 'guest') return false;
        if(!empty($this->app->user->modifyPassword)) return false;

        $count = $this->dao->select('count(*) as count')->from(TABLE_ACTION)->where('actor')->eq($account)->fetch('count');
        if($count < 10) return true;

        $this->loadModel('setting')->setItem($account . '.common.global.novice', 0);
        return false;

    }

    /**
     * Get tutorial product pairs.
     *
     * @access public
     * @return array
     */
    public function getProductPairs()
    {
        return array(1 => 'Test product');
    }

    /**
     * Get module pairs for tutorial.
     *
     * @access public
     * @return array
     */
    public function getModulePairs()
    {
        return array(1 => 'Test module');
    }

    /**
     * Get tutorial product.
     *
     * @access public
     * @return object
     */
    public function getProduct()
    {
        $product = new stdclass();
        $product->id             = 1;
        $product->program        = 0;
        $product->line           = 0;
        $product->plan           = 0;
        $product->name           = 'Test product';
        $product->code           = 'test';
        $product->type           = 'normal';
        $product->status         = 'normal';
        $product->desc           = '';
        $product->shadow         = '0';
        $product->PO             = $this->app->user->account;
        $product->QD             = '';
        $product->RD             = '';
        $product->acl            = 'open';
        $product->createdBy      = $this->app->user->account;
        $product->createdDate    = helper::now();
        $product->createdVersion = '8.1.3';
        $product->order          = 10;
        $product->deleted        = '0';
        $product->branch         = '';
        $product->reviewer       = $this->app->user->account;
        $product->branches       = array();
        $product->plans          = array('1' => 'Test plan');

        return $product;
    }

    /**
     * Get product stats for tutorial.
     *
     * @access public
     * @return array
     */
    public function getProductStats()
    {
        $product = $this->getProduct();
        $product->totalStories     = 0;
        $product->draftStories     = 0;
        $product->activeStories    = 0;
        $product->changingStories  = 0;
        $product->reviewingStories = 0;
        $product->plans            = 0;
        $product->releases         = 0;
        $product->unresolvedBugs   = 0;
        $product->fixedBugs        = 0;

        $productStat[$product->program][$product->line]['products'][$product->id] = $product;
        return $productStat;
    }

    /**
     * Get project for tutorial;
     *
     * @access public
     * @return object
     */
    public function getProject()
    {
        $project = new stdclass();
        $project->id           = 2;
        $project->project      = 0;
        $project->model        = 'scrum';
        $project->type         = 'project';
        $project->name         = 'Test Project';
        $project->code         = '';
        $project->lifetime     = '';
        $project->begin        = date('Y-m-d', strtotime('-7 days'));
        $project->end          = date('Y-m-d', strtotime('+7 days'));
        $project->realBegan    = '';
        $project->realEnd      = '';
        $project->days         = 10;
        $project->status       = 'wait';
        $project->pri          = '1';
        $project->desc         = '';
        $project->goal         = '';
        $project->acl          = 'open';
        $project->parent       = 0;
        $project->path         = ',2,';
        $project->grade        = 1;
        $project->PM           = $this->app->user->account;
        $project->PO           = $this->app->user->account;
        $project->QD           = $this->app->user->account;
        $project->RD           = $this->app->user->account;
        $project->openedBy     = $this->app->user->account;
        $project->whitelist    = '';
        $project->budget       = 0;
        $project->displayCards = 0;
        $project->fluidBoard   = 0;
        $project->deleted      = '0';
        $project->hasProduct   = '1';
        $project->multiple     = '';
        $project->division     = 0;

        return $project;
    }

    /**
     * Get tutorial project pairs.
     *
     * @access public
     * @return array
     */
    public function getProjectPairs()
    {
        return array(2 => 'Test Project');
    }

    /**
     * Get project stats for tutorial
     *
     * @param  string $browseType
     * @access public
     * @return array
     */
    public function getProjectStats($browseType = '')
    {
        $project   = $this->getProject();

        $project->progress    = 0;
        $project->estimate    = 0;
        $project->consumed    = 0;
        $project->left        = 0;
        $project->leftTasks   = '—';
        $project->teamMembers = array_keys($this->getTeamMembers());
        $project->teamCount   = count($project->teamMembers);

        if($browseType and $browseType != 'all') $project->name .= '-' . $browseType; // Fix bug #21096

        $projectStat[$project->id] = $project;
        return $projectStat;
    }

    /**
     * Get execution stats for tutorial.
     *
     * @param  string $browseType
     * @access public
     * @return array
     */
    public function getExecutionStats($browseType = '')
    {
        $execution = $this->getProject();

        $execution->progress       = 0;
        $execution->estimate       = 0;
        $execution->consumed       = 0;
        $execution->left           = 0;
        $execution->leftTasks    = '—';
        $execution->teamMembers  = array_keys($this->getTeamMembers());
        $execution->teamCount    = count($execution->teamMembers);
        $execution->hasProduct   = '1';
        $execution->multiple     = '';
        $execution->order        = 1;
        $execution->burns        = array('');
        $execution->type         = 'sprint';
        $execution->projectName  = '';
        $execution->projectModel = '';

        if($browseType and $browseType != 'all') $execution->name .= '-' . $browseType; // Fix bug #21096

        $executionStat[0] = $execution;
        return $executionStat;
    }

    /**
     * Get tutorial stories.
     *
     * @access public
     * @return array
     */
    public function getStories()
    {
        $story = new stdclass();
        $story->id             = 1;
        $story->product        = 1;
        $story->branch         = 0;
        $story->parent         = 0;
        $story->category       = 0;
        $story->module         = 1;
        $story->plan           = '';
        $story->planTitle      = '';
        $story->color          = '';
        $story->source         = 'po';
        $story->fromBug        = 0;
        $story->title          = 'Test story';
        $story->keywords       = '';
        $story->type           = '';
        $story->pri            = 3;
        $story->estimate       = 1;
        $story->status         = 'active';
        $story->stage          = 'wait';
        $story->openedBy       = $this->app->user->account;
        $story->openedDate     = helper::now();
        $story->assignedTo     = '';
        $story->assignedDate   = '';
        $story->reviewedBy     = $this->app->user->account;
        $story->reviewedDate   = helper::now();
        $story->closedBy       = '';
        $story->closedDate     = '';
        $story->closedReason   = '';
        $story->toBug          = 0;
        $story->childStories   = '';
        $story->linkStories    = '';
        $story->duplicateStory = 0;
        $story->version        = 1;
        $story->deleted        = '0';
        $story->order          = '0';
        $story->URChanged      = false;

        $stories = array();
        $stories[] = $story;
        $story = json_decode(json_encode($stories[0]));
        $story->id    = 2;
        $story->title = 'Test story 2';
        $stories[] = $story;
        return $stories;
    }

    /**
     * Get tutorial Execution pairs.
     *
     * @access public
     * @return array
     */
    public function getExecutionPairs()
    {
        return array(3 => 'Test execution');
    }

    /**
     * Get tutorial execution.
     *
     * @access public
     * @return object
     */
    public function getExecution()
    {
        /* Fix bug #21097. */
        $hours = new stdclass();
        $hours->totalEstimate = 52;
        $hours->totalConsumed = 43;
        $hours->totalLeft     = 7;
        $hours->progress      = 86;
        $hours->totalReal     = 50;

        $execution = new stdclass();
        $execution->id            = 3;
        $execution->project       = 2;
        $execution->type          = 'sprint';
        $execution->name          = 'Test execution';
        $execution->code          = 'test';
        $execution->lifetime      = '';
        $execution->attribute     = '';
        $execution->begin         = date('Y-m-d', strtotime('-7 days'));
        $execution->end           = date('Y-m-d', strtotime('+7 days'));
        $execution->realBegan     = '';
        $execution->realEnd       = '';
        $execution->suspendedDate = '';
        $execution->days          = 10;
        $execution->status        = 'wait';
        $execution->pri           = '1';
        $execution->desc          = '';
        $execution->goal          = '';
        $execution->acl           = 'open';
        $execution->parent        = 2;
        $execution->path          = ',2,3,';
        $execution->grade         = 1;
        $execution->PM            = $this->app->user->account;
        $execution->PO            = $this->app->user->account;
        $execution->QD            = $this->app->user->account;
        $execution->RD            = $this->app->user->account;
        $execution->deleted       = '0';
        $execution->consumed      = 0;
        $execution->left          = 0;
        $execution->hours         = 0;
        $execution->estimate      = 0;
        $execution->progress      = 0;
        $execution->displayCards  = 0;
        $execution->fluidBoard    = 0;
        $execution->hours         = $hours;
        $execution->burns         = array(35, 35);
        $execution->hasProduct    = '1';
        $execution->multiple      = '';
        $execution->colWidth      = '200';

        return $execution;
    }

    /**
     * Get tutorial execution products.
     *
     * @access public
     * @return array
     */
    public function getExecutionProducts()
    {
        $product = $this->getProduct();
        return array($product->id => $product);
    }

    /**
     * Get tutorial execution stories.
     *
     * @access public
     * @return array
     */
    public function getExecutionStories()
    {
        $stories = $this->getStories();
        $story   = $stories[0];
        return array($story->id => $story);
    }

    /**
     * Get tutorial execution story pairs.
     *
     * @access public
     * @return array
     */
    public function getExecutionStoryPairs()
    {
        $stories = $this->getStories();
        $story   = $stories[0];
        return array($story->id => $story->title);
    }

    /**
     * Get tutorial team members.
     *
     * @access public
     * @return array
     */
    public function getTeamMembers()
    {
        $member = new stdclass();
        $member->project     = 1;
        $member->account     = $this->app->user->account;
        $member->role        = $this->app->user->role;
        $member->join        = $this->app->user->join;
        $member->days        = 10;
        $member->hours       = 7.0;
        $member->totalHours  = 70.0;
        $member->realname    = $this->app->user->realname;
        $member->limited     = 'no';
        $member->userID      = $this->app->user->id;
        return array($member->account => $member);
    }

    /**
     * Get team members pairs.
     *
     * @access public
     * @return array
     */
    public function getTeamMembersPairs()
    {
        $account = $this->app->user->account;
        return array('' => '', $account => $this->app->user->realname);
    }

    /**
     * Get tutorial user pairs.
     *
     * @access public
     * @return void
     */
    public function getUserPairs()
    {
        $account = $this->app->user->account;

        $users['']       = '';
        $users[$account] = $account;
        $users['test']   = 'Test';
        return $users;
    }

    /**
     * Get tutorialed.
     *
     * @access public
     * @return string
     */
    public function getTutorialed()
    {
        return $this->dao->select('*')->from(TABLE_CONFIG)->where('module')->eq('tutorial')->andWhere('owner')->eq($this->app->user->account)->andWhere('section')->eq('tasks')->andWhere('`key`')->eq('setting')->fetch('value');
    }
}
