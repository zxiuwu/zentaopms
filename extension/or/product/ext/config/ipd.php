<?php
global $lang, $app;

$config->product->customBatchEditFields = 'PMT,type,acl';
$config->product->custom->batchEditFields = 'PMT';
$app->loadLang('story');
$app->loadLang('demand');
$config->product->search['fields'] = array();
$config->product->search['fields']['title']          = $lang->story->title;
$config->product->search['fields']['id']             = $lang->story->id;
$config->product->search['fields']['pri']            = $lang->story->pri;
$config->product->search['fields']['status']         = $lang->story->status;
$config->product->search['fields']['product']        = $lang->story->product;
$config->product->search['fields']['branch']         = '';
$config->product->search['fields']['module']         = $lang->story->module;
$config->product->search['fields']['assignedTo']     = $lang->story->assignedTo;
$config->product->search['fields']['assignedDate']   = $lang->story->assignedDate;
$config->product->search['fields']['category']       = $lang->story->category;
$config->product->search['fields']['duration']       = $lang->story->duration;
$config->product->search['fields']['BSA']            = $lang->story->BSA;
$config->product->search['fields']['source']         = $lang->story->source;
$config->product->search['fields']['sourceNote']     = $lang->story->sourceNote;
$config->product->search['fields']['feedbackBy']     = $lang->story->feedbackBy;
$config->product->search['fields']['notifyEmail']    = $lang->story->notifyEmail;
$config->product->search['fields']['reviewedBy']     = $lang->story->reviewedBy;
$config->product->search['fields']['reviewedDate']   = $lang->story->reviewedDate;
$config->product->search['fields']['openedBy']       = $lang->story->openedBy;
$config->product->search['fields']['openedDate']     = $lang->story->openedDate;
$config->product->search['fields']['closedBy']       = $lang->story->closedBy;
$config->product->search['fields']['closedDate']     = $lang->story->closedDate;
$config->product->search['fields']['closedReason']   = $lang->story->closedReason;
$config->product->search['fields']['lastEditedBy']   = $lang->story->lastEditedBy;
$config->product->search['fields']['lastEditedDate'] = $lang->story->lastEditedDate;
$config->product->search['fields']['activatedDate']  = $lang->story->activatedDate;
$config->product->search['fields']['mailto']         = $lang->story->mailto;
$config->product->search['fields']['version']        = $lang->story->version;

$config->product->search['params']['BSA']         = array('operator' => '=',       'control' => 'select',  'values' => $lang->demand->bsaList);
$config->product->search['params']['duration']    = array('operator' => '=',       'control' => 'select',  'values' => $lang->demand->durationList);
$config->product->search['params']['feedbackBy']  = array('operator' => 'include', 'control' => 'input',   'values' => '');
$config->product->search['params']['notifyEmail'] = array('operator' => 'include', 'control' => 'input',   'values' => '');

$config->product->statisticFields['requirements'] = array('draftRequirements', 'activeRequirements', 'changingRequirements', 'reviewingRequirements', 'launchedRequirements', 'developingRequirements', 'closedRequirements');


$app->loadLang('product');
$config->product->all = new stdclass();
$config->product->all->search['module']                = 'product';
$config->product->all->search['fields']['name']        = $lang->product->name;
if(isset($config->setCode) and $config->setCode == 1) $config->product->all->search['fields']['code'] = $lang->product->code;
$config->product->all->search['fields']['desc']        = $lang->product->desc;
$config->product->all->search['fields']['PMT']         = $lang->product->PMT;
$config->product->all->search['fields']['reviewer']    = $lang->product->reviewer;
$config->product->all->search['fields']['type']        = $lang->product->type;
$config->product->all->search['fields']['createdDate'] = $lang->product->createdDate;
$config->product->all->search['fields']['createdBy']   = $lang->product->createdBy;

$config->product->all->search['params']['name']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
if(isset($config->setCode) and $config->setCode == 1) $config->product->all->search['params']['code'] = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->product->all->search['params']['id']          = array('operator' => '=',       'control' => 'input',  'values' => '');
$config->product->all->search['params']['desc']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->product->all->search['params']['PMT']         = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->product->all->search['params']['reviewer']    = array('operator' => 'include', 'control' => 'select', 'values' => 'users');
$config->product->all->search['params']['type']        = array('operator' => '=',       'control' => 'select', 'values' => $lang->product->typeList);
$config->product->all->search['params']['createdDate'] = array('operator' => '=',       'control' => 'input',  'values' => '', 'class' => 'date');
$config->product->all->search['params']['createdBy']   = array('operator' => '=',       'control' => 'select', 'values' => 'users');

$config->product->list = new stdclass();
$config->product->list->exportFields = 'id,name,PMT,type,waitedRoadmaps,launchedRoadmaps,draftStories,activeStories,launchedStories,developingStories';
