<?php
/**
 * Get not imported stories.
 *
 * @param  array  $libraries
 * @param  int    $libID
 * @param  int    $projectID
 * @param  int    $productID
 * @param  string $orderBy
 * @param  string $browseType
 * @param  int    $queryID
 * @access public
 * @return array
 */
public function getNotImported($libraries, $libID, $projectID, $productID, $orderBy = 'id_desc', $browseType = '', $queryID = 0)
{
    $query = '';
    if($browseType == 'bysearch')
    {
        if($queryID)
        {
            $this->session->set('projectstoryQuery', ' 1 = 1');
            $query = $this->loadModel('search')->getQuery($queryID);
            if($query)
            {
                $this->session->set('projectstoryQuery', $query->sql);
                $this->session->set('projectstoryForm', $query->form);
            }
        }
        else
        {
            if($this->session->projectstoryQuery == false) $this->session->set('projectstoryQuery', ' 1 = 1');
        }

        $query  = $this->session->projectstoryQuery;
        $allLib = "`lib` = 'all'";
        $withAllLib = strpos($query, $allLib) !== false;
        if($withAllLib)  $query  = str_replace($allLib, 1, $query);
        if(!$withAllLib) $query .= " AND `lib` = '$libID'";
    }

    $stories = $this->dao->select('*')->from(TABLE_STORY)
        ->where('deleted')->eq(0)
        ->andWhere('status')->eq('active')
        ->andWhere('lib')->in(array_keys($libraries))
        ->beginIF($browseType != 'bysearch')->andWhere('lib')->eq($libID)->fi()
        ->beginIF($browseType == 'bysearch')->andWhere($query)->fi()
        ->orderBy($orderBy)
        ->fetchAll('id');

    $imported = $this->dao->select('t1.fromStory,t1.fromVersion')->from(TABLE_STORY)->alias('t1')
        ->leftJoin(TABLE_PROJECTSTORY)->alias('t2')->on('t1.id=t2.story')
        ->where('t1.lib')->eq(0)
        ->andWhere('t1.fromStory')->ne(0)
        ->andWhere('t1.product')->eq($productID)
        ->andWhere('t2.project')->eq($projectID)
        ->andWhere('t1.deleted')->eq(0)
        ->orderBy('t1.fromVersion_asc')
        ->fetchPairs();
    if(empty($imported)) return $stories;

    foreach($stories as $story)
    {
        if(!isset($imported[$story->id])) continue;
        if($story->version == $imported[$story->id]) unset($stories[$story->id]);
    }

    return $stories;
}

/**
 * Import from library.
 *
 * @param  int    $projectID
 * @param  int    $productID
 * @access public
 * @return void
 */
public function importFromLib($projectID, $productID)
{
    $this->loadModel('story');
    $this->loadModel('action');
    $data = fixer::input('post')->get();

    $storyIdList  = $data->storyIdList;
    $branches     = isset($data->branches) ? $data->branches : array();
    $storyList    = $this->dao->select('*')->from(TABLE_STORY)->where('id')->in(array_keys($storyIdList))->fetchAll('id');
    $lastOrder    = $this->dao->select('*')->from(TABLE_PROJECTSTORY)->where('project')->eq($projectID)->orderBy('order_desc')->fetchPairs('story', 'order');
    $storyContent = $this->dao->select('story,spec,verify')->from(TABLE_STORYSPEC)->where('story')->in(array_keys($storyIdList))->fetchAll('story');

    $now = helper::now();
    foreach($storyList as $id => $story)
    {
        $story->product     = $productID;
        $story->branch      = isset($branches[$id]) ? $branches[$id] : 0;
        $story->status      = 'active';
        $story->fromVersion = $story->version;
        $story->version     = 1;
        $story->fromStory   = $story->id;
        $story->openedBy    = $this->app->user->account;
        $story->openedDate  = $now;

        $fromLib         = $story->lib;
        $needUnsetFields = array('lib','id','lastEditedBy','lastEditedDate','assignedTo','assignedDate','approvedDate');
        foreach($needUnsetFields as $field) unset($story->$field);

        $this->dao->insert(TABLE_STORY)->data($story)->autoCheck()->exec();
        if(dao::isError())
        {
            echo js::error(dao::getError());
            die(js::reload('parent'));
        }

        $storyID = $this->dao->lastInsertID();

        $data = new stdclass();
        $data->project = $projectID;
        $data->product = $productID;
        $data->story   = $storyID;
        $data->version = 1;
        $data->order   = reset($lastOrder) + 1;
        $this->dao->insert(TABLE_PROJECTSTORY)->data($data)->exec();

        $content  = $storyContent[$id];
        $specData = new stdclass();
        $specData->story   = $storyID;
        $specData->version = 1;
        $specData->title   = $story->title;
        $specData->spec    = $content->spec;
        $specData->verify  = $content->verify;
        $this->dao->insert(TABLE_STORYSPEC)->data($specData)->exec();

        $this->story->setStage($storyID);

        $this->action->create('story', $storyID, 'importfromstorylib', '', $fromLib);
    }
}
