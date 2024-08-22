<?php
$lang->ticket->common          = 'Ticket';
$lang->ticket->index           = 'Ticket index';
$lang->ticket->id              = 'ID';
$lang->ticket->idAB            = 'ID';
$lang->ticket->product         = $lang->productCommon;
$lang->ticket->branch          = 'Branch/Platform';
$lang->ticket->module          = 'Module';
$lang->ticket->type            = 'Type';
$lang->ticket->status          = 'Status';
$lang->ticket->subStatus       = 'Sub Status';
$lang->ticket->openedBuild     = 'OpenBuild';
$lang->ticket->allBuilds       = 'All Build';
$lang->ticket->assignedTo      = 'AssignedTo';
$lang->ticket->assignedDate    = 'AssignedDate';
$lang->ticket->deadline        = 'Deadline';
$lang->ticket->title           = 'Title';
$lang->ticket->pri             = 'Priority';
$lang->ticket->priAB           = 'P';
$lang->ticket->estimate        = 'Estimate';
$lang->ticket->desc            = 'Description';
$lang->ticket->source          = 'Ticket from';
$lang->ticket->keywords        = 'Keywords';
$lang->ticket->files           = 'Files';
$lang->ticket->from            = 'Source';
$lang->ticket->customer        = 'Customer';
$lang->ticket->contact         = 'Contact';
$lang->ticket->notifyEmail     = 'DiscovererEmail';
$lang->ticket->mailto          = 'Mailto';
$lang->ticket->resolution      = 'Resolution';
$lang->ticket->legendLife      = 'Ticket life';
$lang->ticket->legendMisc      = 'Misc.';
$lang->ticket->createdBy       = 'CreatedBy';
$lang->ticket->createdByAB     = 'CreatedBy';
$lang->ticket->createdDate     = 'CreatedDate';
$lang->ticket->colorTag        = 'Color Tag';
$lang->ticket->legendBasicInfo = 'Basic info';
$lang->ticket->legendLife      = 'Ticket life';
$lang->ticket->contacts        = 'Ticket Contact';
$lang->ticket->story           = 'Story';
$lang->ticket->bug             = 'Bug';
$lang->ticket->lastEditedBy    = 'Last EditedBy';
$lang->ticket->lastEditedDate  = 'Last Edited Date';
$lang->ticket->search          = 'Search';
$lang->ticket->fromFeedback    = 'Source Feedback';
$lang->ticket->deleted         = 'Deleted';
$lang->ticket->syncProduct     = 'Synchronize ' . $lang->productCommon . ' modules';
$lang->ticket->descFiles       = 'Files of desc';
$lang->ticket->resolutionFiles = 'Files of resolution';
$lang->ticket->addSource       = 'Add Source';
$lang->ticket->deleteSource    = 'Delete Source';
$lang->ticket->export          = 'Export';
$lang->ticket->exportAction    = 'Export Action';
$lang->ticket->openedBy        = 'openedBy';
$lang->ticket->openedDate      = 'openedDate';
$lang->ticket->feedback        = 'Transfor by feedback';
$lang->ticket->editedDate      = 'LastEditedDate';

$lang->ticket->create = 'Create';
$lang->ticket->browse = 'Ticket List';
$lang->ticket->edit   = 'Edit';
$lang->ticket->delete = 'Delete';
$lang->ticket->view   = 'View';

$lang->ticket->statusList['']        = '';
$lang->ticket->statusList['wait']    = 'Wait';
$lang->ticket->statusList['doing']   = 'Processing';
$lang->ticket->statusList['done']    = 'Processed';
$lang->ticket->statusList['closed']  = 'Closed';

$lang->ticket->typeList['']         = '';
$lang->ticket->typeList['code']     = 'Program Error';
$lang->ticket->typeList['data']     = 'Data Error';
$lang->ticket->typeList['stuck']    = 'Process Stuck';
$lang->ticket->typeList['security'] = 'Security issues';
$lang->ticket->typeList['affair']   = 'Affair';

$lang->ticket->priList[]  = '';
$lang->ticket->priList[1] = '1';
$lang->ticket->priList[2] = '2';
$lang->ticket->priList[3] = '3';
$lang->ticket->priList[4] = '4';

$lang->ticket->start            = 'Start';
$lang->ticket->started          = 'Started';
$lang->ticket->realStarted      = 'Real started';
$lang->ticket->createStory      = 'To Story';
$lang->ticket->createBug        = 'To Bug';
$lang->ticket->hour             = 'Hour';
$lang->ticket->consumed         = 'Consumed';
$lang->ticket->left             = 'Left';
$lang->ticket->assign           = 'Assign';
$lang->ticket->assignTo         = 'Assign';
$lang->ticket->estimate         = 'Estimate';
$lang->ticket->confirmDelete    = 'Are you sure you want to delete the ticket?';
$lang->ticket->confirmClose     = 'Are you sure you want to close the ticket?';
$lang->ticket->noTicket         = 'No Ticket';
$lang->ticket->close            = 'Close';
$lang->ticket->closedReason     = 'CloseReason';
$lang->ticket->repeatTicket     = 'Repeat ticket';
$lang->ticket->closedBy         = 'ClosedBy';
$lang->ticket->closedByAB       = 'ClosedBy';
$lang->ticket->closedDate       = 'Closed date';
$lang->ticket->noRequire        = '%s "%s" cannot be empty.';
$lang->ticket->notifyEmailError = '%s should be a validate mailbox.';
$lang->ticket->finish           = 'Finish';
$lang->ticket->finished         = 'Finished';
$lang->ticket->hasConsumed      = 'Has consumed';
$lang->ticket->currentConsumed  = 'Current consumed';
$lang->ticket->startedBy        = 'StartedBy';
$lang->ticket->startedDate      = 'StartedDate';
$lang->ticket->finishedBy       = 'FinishedBy';
$lang->ticket->finishedByAB     = 'FinishedBy';
$lang->ticket->finishedDate     = 'FinishedDate';
$lang->ticket->activate         = "Activate";
$lang->ticket->activatedBy      = "ActivatedBy";
$lang->ticket->activatedDate    = "ActivatedDate";
$lang->ticket->activatedCount   = "ActivatedCount";
$lang->ticket->editedBy         = "EditedBy";
$lang->ticket->editedByAB       = "EditedBy";
$lang->ticket->resolvedBy       = "ResolveBy";
$lang->ticket->resolvedDate     = "ResolveDate";
$lang->ticket->batchEdit        = 'Batch edit';
$lang->ticket->batchFinish      = 'Batch finish';
$lang->ticket->batchClose       = 'Batch close';
$lang->ticket->batchActivate    = 'Batch activate';
$lang->ticket->batchAssignTo    = 'Batch assignTo';
$lang->ticket->batchEditTip     = 'Ticket with ID %s the status is closed, batch edit cannot be performed.';
$lang->ticket->batchFinishTip   = 'Ticket with ID %s the status is done or closed, batch finish cannot be performed.';
$lang->ticket->batchActivateTip = 'Ticket with ID %s the status is wait or doing, batch activate cannot be performed.';
$lang->ticket->noAssigned       = 'Unassigned';

$lang->ticket->closedReasonList['']          = '';
$lang->ticket->closedReasonList['commented'] = 'Commented';
$lang->ticket->closedReasonList['repeat']    = 'Repeat';
$lang->ticket->closedReasonList['refuse']    = 'Refuse';

$lang->ticket->featureBar['browse']['all'] = 'All';
if($this->config->vision == 'lite')
{
    $lang->ticket->featureBar['browse']['unclosed'] = 'Unclosed';
}
else
{
    $lang->ticket->featureBar['browse']['wait']         = 'Wait';
    $lang->ticket->featureBar['browse']['doing']        = 'Processing';
    $lang->ticket->featureBar['browse']['done']         = 'Toclose';
    $lang->ticket->featureBar['browse']['finishedbyme'] = 'ResolvedByMe';
    $lang->ticket->featureBar['browse']['openedbyme']   = 'ReportedByMe';
    $lang->ticket->featureBar['browse']['assignedtome'] = 'AssignedToMe';
}

$lang->ticket->errorRecordMinus    = 'Work hours should not be negative number.';
$lang->ticket->errorCustomedNumber = '"Consumed" must be number';
$lang->ticket->accessDenied        = 'You have no access to the ticket.';
$lang->ticket->toStory             = 'To ' . $lang->SRCommon;
$lang->ticket->toBug               = 'To Bug';
