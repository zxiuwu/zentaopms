<?php
$lang->roadmap = new stdclass();
$lang->roadmap->common = 'Roadmap';

$lang->roadmap->linkURAB      = 'Relate';
$lang->roadmap->linkUR        = 'Link Requirement';
$lang->roadmap->activate      = 'Activate';
$lang->roadmap->name          = 'Name';
$lang->roadmap->begin         = 'Plan Begin';
$lang->roadmap->end           = 'Plan End';
$lang->roadmap->status        = 'Status';
$lang->roadmap->desc          = 'Description';
$lang->roadmap->future        = 'TBD';
$lang->roadmap->view          = 'RoadMap View';
$lang->roadmap->delete        = 'Delete';
$lang->roadmap->basicInfo     = 'Basic Info';
$lang->roadmap->updateOrder   = 'Order';
$lang->roadmap->linkedURS     = 'Linked Stories';
$lang->roadmap->unlinkUR      = 'Unlink Story';
$lang->roadmap->unlinkURAB    = 'Unlink';
$lang->roadmap->unlinkedUR    = 'Unlinked Stories';
$lang->roadmap->batchUnlinkUR = 'Batch Unlink';
$lang->roadmap->createdBy     = 'Created By';
$lang->roadmap->createdDate   = 'Created Date';
$lang->roadmap->closedBy      = 'Closed By';
$lang->roadmap->closedDate    = 'Closed Date';
$lang->roadmap->closedReason  = 'Closed Reason';

$lang->roadmap->browse = 'Roadmap Gantt';
$lang->roadmap->create = 'Create Roadmap';
$lang->roadmap->edit   = 'Edit Roadmap';
$lang->roadmap->close  = 'Close Roadmap';

$lang->roadmap->branch      = '%s';
$lang->roadmap->requirment  = 'Requirement';
$lang->roadmap->requirments = 'Requirments';
$lang->roadmap->actions     = 'Actions';

$lang->roadmap->statusList['wait']      = 'Wait';
$lang->roadmap->statusList['launching'] = 'Launching';
$lang->roadmap->statusList['launched']  = 'Launched';
$lang->roadmap->statusList['reject']    = 'Reject';
$lang->roadmap->statusList['closed']    = 'Closed';

$lang->roadmap->confirmDelete           = 'Do you want to delete this roadmap?';
$lang->roadmap->confirmActivate         = 'Do you want to activate this roadmap?';
$lang->roadmap->confirmUnlinkStory      = 'Do you want to unlink this story?';
$lang->roadmap->confirmBatchUnlinkStory = "Do you want to batch unlink these stories?";
$lang->roadmap->changeBranchTips        = 'After the roadmap adjusts the branch, the requirements of the previously associated branch and the adjusted branch will be removed from the roadmap. Please confirm whether to continue to modify the branch to which the roadmap belongs.';
$lang->roadmap->changeRoadmapTips       = 'The roadmap is in %s status and cannot be moved to another roadmap.';
$lang->roadmap->batchUnlinkURSTips      = 'The roadmap is in %s status and cannot be moved to story.';
$lang->roadmap->failedRemoveTip         = 'The story is in %s status and cannot be removed.';
$lang->roadmap->deleteRoadmapTips       = 'The roadmap is in %s status and cannot be deleted.';

$lang->roadmap->zooming['month']   = 'Month';
$lang->roadmap->zooming['quarter'] = 'Quarter';
$lang->roadmap->zooming['year']    = 'Year';

$lang->roadmap->action = new stdclass();
$lang->roadmap->action->linkur   = '$date, <strong>$actor</strong> link stories <strong>$extra</strong>.' . "\n";
$lang->roadmap->action->unlinkur = '$date, <strong>$actor</strong> remove stories <strong>$extra</strong> from roadmap.' . "\n";
$lang->roadmap->action->changedbycharter = array('main' => '$date, Deleted charter <strong>$extra</strong>，The status is changed to wait.');
$lang->roadmap->action->linked2charter   = array('main' => '$date, Linked by <strong>$actor</strong> to charter <strong>$extra</strong>。');

$lang->roadmap->beginGtEnd = 'Planned begin date cannot be greater than planned end date';

$lang->roadmap->reasonList['']         = '';
$lang->roadmap->reasonList['done']     = 'Done';
$lang->roadmap->reasonList['canceled'] = 'Canceled';
