<?php
$lang->review->delete            = 'Delete';
$lang->review->deleted           = 'Deleted';
$lang->review->common            = 'Review';
$lang->review->assess            = 'Review';
$lang->review->record            = 'History';
$lang->review->explain           = 'Notes';
$lang->review->resultExplain     = 'Result Notes';
$lang->review->reviewResult      = 'Review Result';
$lang->review->conclusion        = 'Review Conclusion(pass or not)';
$lang->review->recall            = 'Revoke';
$lang->review->files             = 'File';
$lang->review->start             = 'Start';
$lang->review->finish            = 'Finish';
$lang->review->submit            = 'Submit';
$lang->review->toAudit           = 'Audit';
$lang->review->create            = 'Create';
$lang->review->edit              = 'Edit';
$lang->review->browse            = 'View';
$lang->review->view              = 'Details';
$lang->review->viewFlow          = 'Preview Process';
$lang->review->title             = 'Title';
$lang->review->object            = 'Review Object';
$lang->review->content           = 'Review Content';
$lang->review->doclib            = 'Document Library';
$lang->review->template          = 'Template';
$lang->review->doc               = 'Doc';
$lang->review->version           = 'Version';
$lang->review->reviewedBy        = 'ReviewBy';
$lang->review->reviewReport      = 'Review Reprot';
$lang->review->reviewerCount     = 'No. of Reviewer';
$lang->review->deadline          = 'Deadline';
$lang->review->comment           = 'Comment';
$lang->review->createdBy         = 'CreatedBy';
$lang->review->createdDate       = 'Created';
$lang->review->reviewedHours     = 'Review Hours';
$lang->review->area              = 'Review Location';
$lang->review->audit             = 'Audit';
$lang->review->auditedBy         = 'AuditBy';
$lang->review->objectScale       = 'Object Scale';
$lang->review->issueCount        = 'Defect Count';
$lang->review->issueRate         = 'Defect Rate';
$lang->review->issueFoundRate    = 'Defect Discovery Rate';
$lang->review->issues            = 'Issue Found';
$lang->review->isIssue           = 'Defect';
$lang->review->result            = 'Review Result';
$lang->review->nodeDetail        = 'Node Details';
$lang->review->status            = 'Status';
$lang->review->opinion           = 'Suggestion';
$lang->review->finalOpinion      = 'Review Suggestion';
$lang->review->reviewcl          = 'Checklist';
$lang->review->reviewedDate      = 'Reviewed';
$lang->review->consumed          = 'Consumed';
$lang->review->basicInfo         = 'Basic Infomation';
$lang->review->product           = $lang->productCommon;
$lang->review->auditResult       = 'Audit Result';
$lang->review->auditedDate       = 'Audit';
$lang->review->auditOpinion      = 'Audit Opinion';
$lang->review->issueList         = 'Issue List';
$lang->review->lastIssue         = 'Legacy Issues';
$lang->review->fullScreen        = 'Full Screen';
$lang->review->auditedByEmpty    = 'Auditedby cannot be empty!';
$lang->review->exporting         = 'Exporting...';
$lang->review->lastReviewedDate  = 'Last Reviewed';
$lang->review->lastAuditedDate   = 'Last Audited';
$lang->review->createBaseline    = 'Create Baseline';
$lang->review->opinionDate       = 'Suggested';
$lang->review->objectScaleTip    = "{$lang->review->objectScale} counts story or user requirement points";
$lang->review->issueCountTip     = "{$lang->review->issueCount} counts problem count of {$lang->review->common} Non-conformities";
$lang->review->issueRateTip      = "{$lang->review->issueRate}={$lang->review->issueCount}/Issue Scale";
$lang->review->issueFoundRateTip = "{$lang->review->issueFoundRate}={$lang->review->issueCount}/{$lang->review->reviewedHours}";

$lang->review->browseAction = 'Reivew List';

$lang->review->pageAllSummary = 'Total reviews: %total%, Wait: %wait%, Reviewing: %reviewing%, Pass: %pass%, Auditing: %auditing%, Done: %done%.';
$lang->review->pageSummary    = 'Total reviews: %s.';

$lang->object = new stdclass();
$lang->object->product = $lang->review->product;

$lang->review->report = new stdclass();
$lang->review->report->common = 'Review Report';

$lang->review->reportCreatedBy  = 'Report CreatedBy';
$lang->review->reportApprovedBy = 'Report ApprovedBy';

$lang->review->listCategory = 'Category';
$lang->review->listTitle    = 'Content';
$lang->review->listItem     = 'Item';
$lang->review->listResult   = 'Result';

$lang->review->contentList['template'] = 'System Template';
$lang->review->contentList['doc']      = $lang->projectCommon . 'Document';

$lang->review->noBook        = 'No relevant statements. Go to the document to maintain statements.';
$lang->review->stopSubmit    = 'Nonconformities in the checklist!';
$lang->review->confirmDelete = 'Do you want to delete this review? If you delete it, the items under that review will also be deleted !';

$lang->review->statusList['draft']     = 'Draft';
$lang->review->statusList['wait']      = 'Wait';
$lang->review->statusList['reviewing'] = 'Reviewing';
$lang->review->statusList['pass']      = 'Pass';
$lang->review->statusList['fail']      = 'Fail';
$lang->review->statusList['auditing']  = 'Auditing';
$lang->review->statusList['done']      = 'Done';

$lang->review->resultList['pass']    = 'Pass';
$lang->review->resultList['fail']    = 'Fail';

$lang->review->auditResultList['pass']    = 'Pass';
$lang->review->auditResultList['needfix'] = 'Review';
$lang->review->auditResultList['fail']    = 'Fail';

$lang->review->resultLable['pass']    = 'success';
$lang->review->resultLable['fail']    = 'danger';
$lang->review->resultLable['needfix'] = 'info';

$lang->review->reviewResultList['pass']    = 'Pass';
$lang->review->reviewResultList['needfix'] = 'Pass after modification';
$lang->review->reviewResultList['fail']    = 'Fail';

$lang->review->checkList['1'] = 'Yes';
$lang->review->checkList['0'] = 'No';

$lang->review->resolvedList['1'] = 'Yes';
$lang->review->resolvedList['0'] = 'No';

$lang->review->featureBar['browse']['all']          = 'All';
$lang->review->featureBar['browse']['reviewing']    = 'Reviewing';
$lang->review->featureBar['browse']['done']         = 'Done';
$lang->review->featureBar['browse']['wait']         = 'Wait';
$lang->review->featureBar['browse']['reviewedbyme'] = 'Reviewed By Me';
$lang->review->featureBar['browse']['createdbyme']  = 'Created By Me';

$lang->review->resultExplainList['pass']    = 'Approved - The work is qualified, so "no modification is required" or "minor modification is required but no review is required".';
$lang->review->resultExplainList['needFix'] = 'Review - Passed with conditions: the work are basically qualified, and a minor modification is needed, and then it can be verified again.';
$lang->review->resultExplainList['fail']    = 'Fail - The work is not up to standard and requires major revision, after which it must be evaluated again.';

$lang->review->issue = new stdclass();
$lang->review->issue->id           = 'ID';
$lang->review->issue->summary      = 'Summary';
$lang->review->issue->desc         = 'Defect Description';
$lang->review->issue->analyse      = 'Defect Analysis';
$lang->review->issue->introAnalyse = 'Intro Analysis';
$lang->review->issue->resolvedBy   = 'ResolvedBy';
$lang->review->issue->deadline     = 'Deadline';
$lang->review->issue->resolvedDate = 'Resolved';
$lang->review->issue->severity     = 'Severity';
$lang->review->issue->verifiedBy   = 'VerifiedBy';
$lang->review->issue->status       = 'Status';

$lang->review->action = new stdclass();
$lang->review->action->reviewed = array('main' => '$date, reviewed by <strong>$actor</strong>，<strong>$extra</strong>.', 'extra' => 'resultList');
$lang->review->action->submit   = array('main' => '$date, submited review by <strong>$actor</strong>.');
$lang->review->action->recall   = array('main' => '$date, recalled by <strong>$actor</strong>.');
$lang->review->action->toaudit  = array('main' => '$date, submited audit by <strong>$actor</strong> , assigned to <strong>$extra</strong>.');
$lang->review->action->audited  = array('main' => '$date, audited by <strong>$actor</strong> , <strong>$extra</strong>.', 'extra' => 'auditResultList');

$lang->reviewresult = new stdclass();
$lang->reviewresult->consumed    = 'Consumed';
$lang->reviewresult->createdDate = 'Created Date';

$lang->review->selectApprovalText = 'Review：No.%s';
