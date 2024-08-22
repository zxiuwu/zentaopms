<?php
$lang->product->PMT          = 'PMT';
$lang->product->storySummary = "Total <strong>%s</strong> %s on this page. Estimates: <strong>%s</strong> ({$lang->hourCommon}).";
$lang->product->checkedSummary = "<strong>%total%</strong> %storyCommon% selected";

$lang->product->statusList['wait'] = 'Wait';

$lang->product->aclList['private'] = "Private ({$lang->productCommon}Relevant person in charge, reviewer, person in charge of project set and stakeholder,team members and stakeholders of the associated {$lang->projectCommon} can access)";

$lang->product->featureBar['all'] = array();
$lang->product->featureBar['all']['all']    = 'All';
$lang->product->featureBar['all']['mine']   = 'Mine';
$lang->product->featureBar['all']['wait']   = 'Wait';
$lang->product->featureBar['all']['normal'] = 'Normal';
$lang->product->featureBar['all']['closed'] = 'Closed';

$lang->product->featureBar['browse'] = array();
$lang->product->featureBar['browse']['allstory']        = 'All';
$lang->product->featureBar['browse']['assignedtome']    = $lang->product->assignedToMe;
$lang->product->featureBar['browse']['draftstory']      = $lang->product->draftStory;
$lang->product->featureBar['browse']['reviewingstory']  = 'Reviewing';
$lang->product->featureBar['browse']['changingstory']   = 'Changing';
$lang->product->featureBar['browse']['launchedstory']   = 'Lanched';
$lang->product->featureBar['browse']['developingstory'] = 'Developing';
$lang->product->featureBar['browse']['more']            = $lang->more;

$lang->product->moreSelects['browse'] = array();
$lang->product->moreSelects['browse']['more']['closedstory'] = 'Closed';

$lang->product->waitedRoadmaps    = 'waited roadmaps';
$lang->product->launchedRoadmaps  = 'launched roadmaps';
$lang->product->launchedStories   = 'launched requirements';
$lang->product->developingStories = 'developing requirements';
