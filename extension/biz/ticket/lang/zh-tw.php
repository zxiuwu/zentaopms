<?php
$lang->ticket->common          = '工單';
$lang->ticket->index           = '工單首頁';
$lang->ticket->id              = '工單編號';
$lang->ticket->idAB            = 'ID';
$lang->ticket->product         = '所屬' . $lang->productCommon;
$lang->ticket->branch          = '分支/平台';
$lang->ticket->module          = '所屬模組';
$lang->ticket->type            = '類型';
$lang->ticket->status          = '狀態';
$lang->ticket->subStatus       = '子狀態';
$lang->ticket->openedBuild     = '影響版本';
$lang->ticket->allBuilds       = '所有';
$lang->ticket->assignedTo      = '指派給';
$lang->ticket->assignedDate    = '指派日期';
$lang->ticket->deadline        = '截止日期';
$lang->ticket->title           = '標題';
$lang->ticket->pri             = '優先順序';
$lang->ticket->priAB           = 'P';
$lang->ticket->estimate        = '預計';
$lang->ticket->desc            = '描述';
$lang->ticket->source          = '工單來源';
$lang->ticket->keywords        = '關鍵字';
$lang->ticket->files           = '檔案';
$lang->ticket->from            = '來源';
$lang->ticket->customer        = '來源客戶';
$lang->ticket->contact         = '聯繫人';
$lang->ticket->notifyEmail     = '通知郵箱';
$lang->ticket->mailto          = '抄送給';
$lang->ticket->resolution      = '解決方案';
$lang->ticket->legendLife      = '工單的一生';
$lang->ticket->legendMisc      = '其他相關';
$lang->ticket->createdBy       = '創建者';
$lang->ticket->createdByAB     = '由誰創建';
$lang->ticket->createdDate     = '創建日期';
$lang->ticket->colorTag        = '顏色標籤';
$lang->ticket->legendBasicInfo = '基本信息';
$lang->ticket->legendLife      = '工單的一生';
$lang->ticket->contacts        = '工單聯繫人';
$lang->ticket->story           = '需求';
$lang->ticket->bug             = 'Bug';
$lang->ticket->lastEditedBy    = '最後修改';
$lang->ticket->lastEditedDate  = '最後操作時間';
$lang->ticket->search          = '搜索';
$lang->ticket->fromFeedback    = '來源反饋';
$lang->ticket->deleted         = '已刪除';
$lang->ticket->syncProduct     = '同步' . $lang->productCommon . '模組';
$lang->ticket->descFiles       = '描述的附件';
$lang->ticket->resolutionFiles = '解決方案的附件';
$lang->ticket->addSource       = '添加來源';
$lang->ticket->deleteSource    = '刪除來源';
$lang->ticket->export          = '導出';
$lang->ticket->exportAction    = '導出工單';
$lang->ticket->openedBy        = '由誰創建';
$lang->ticket->openedDate      = '創建時間';
$lang->ticket->feedback        = '由反饋轉化';
$lang->ticket->editedDate      = '最後修改時間';

$lang->ticket->create = '創建工單';
$lang->ticket->browse = '工單列表';
$lang->ticket->edit   = '編輯工單';
$lang->ticket->delete = '刪除工單';
$lang->ticket->view   = '工單詳情';

$lang->ticket->statusList['']        = '';
$lang->ticket->statusList['wait']    = '等待';
$lang->ticket->statusList['doing']   = '處理中';
$lang->ticket->statusList['done']    = '已處理';
$lang->ticket->statusList['closed']  = '已關閉';

$lang->ticket->typeList['']         = '';
$lang->ticket->typeList['code']     = '程序報錯';
$lang->ticket->typeList['data']     = '數據錯誤';
$lang->ticket->typeList['stuck']    = '流程卡斷';
$lang->ticket->typeList['security'] = '安全問題';
$lang->ticket->typeList['affair']   = '事務';

$lang->ticket->priList[]  = '';
$lang->ticket->priList[1] = '1';
$lang->ticket->priList[2] = '2';
$lang->ticket->priList[3] = '3';
$lang->ticket->priList[4] = '4';

$lang->ticket->start            = '開始';
$lang->ticket->started          = '開始了';
$lang->ticket->realStarted      = '實際開始';
$lang->ticket->createStory      = '提需求';
$lang->ticket->createBug        = '提Bug';
$lang->ticket->hour             = '小時';
$lang->ticket->consumed         = '總計消耗';
$lang->ticket->left             = '預計剩餘';
$lang->ticket->assign           = '指派';
$lang->ticket->assignTo         = '指派';
$lang->ticket->estimate         = '最初預計';
$lang->ticket->confirmDelete    = '您確認要刪除這個工單嗎？';
$lang->ticket->confirmClose     = '您確認要關閉這個工單嗎？';
$lang->ticket->noTicket         = '暫時沒有工單';
$lang->ticket->close            = '關閉';
$lang->ticket->closedReason     = '關閉原因';
$lang->ticket->repeatTicket     = '重複工單';
$lang->ticket->closedBy         = '關閉者';
$lang->ticket->closedByAB       = '由誰關閉';
$lang->ticket->closedDate       = '關閉時間';
$lang->ticket->noRequire        = '%s“%s”不能為空。';
$lang->ticket->notifyEmailError = '%s應當為合法的郵箱。';
$lang->ticket->finish           = '完成';
$lang->ticket->finished         = '完成了';
$lang->ticket->hasConsumed      = '之前消耗';
$lang->ticket->currentConsumed  = '本次消耗';
$lang->ticket->startedBy        = '由誰開始';
$lang->ticket->startedDate      = '開始時間';
$lang->ticket->finishedBy       = '完成者';
$lang->ticket->finishedByAB     = '由誰完成';
$lang->ticket->finishedDate     = '完成時間';
$lang->ticket->activate         = "激活";
$lang->ticket->activatedBy      = "由誰激活";
$lang->ticket->activatedDate    = "激活時間";
$lang->ticket->activatedCount   = "激活次數";
$lang->ticket->editedBy         = "由誰編輯";
$lang->ticket->editedByAB       = "最後操作";
$lang->ticket->resolvedBy       = "解決者";
$lang->ticket->resolvedDate     = "解決時間";
$lang->ticket->batchEdit        = '批量編輯';
$lang->ticket->batchFinish      = '批量完成';
$lang->ticket->batchClose       = '批量關閉';
$lang->ticket->batchActivate    = '批量激活';
$lang->ticket->batchAssignTo    = '批量指派';
$lang->ticket->batchEditTip     = '工單ID%s狀態為已關閉，無法進行批量編輯操作。';
$lang->ticket->batchFinishTip   = '工單ID%s狀態為已處理或已關閉，無法進行批量完成操作。';
$lang->ticket->batchActivateTip = '工單ID%s狀態為等待或處理中，無法進行批量激活操作。';
$lang->ticket->noAssigned       = '未指派';

$lang->ticket->closedReasonList['']          = '';
$lang->ticket->closedReasonList['commented'] = '已處理';
$lang->ticket->closedReasonList['repeat']    = '重複';
$lang->ticket->closedReasonList['refuse']    = '不予處理';

$lang->ticket->featureBar['browse']['all'] = '全部';
if($this->config->vision == 'lite')
{
    $lang->ticket->featureBar['browse']['unclosed'] = '未關閉';
}
else
{
    $lang->ticket->featureBar['browse']['wait']         = '待處理';
    $lang->ticket->featureBar['browse']['doing']        = '處理中';
    $lang->ticket->featureBar['browse']['done']         = '待關閉';
    $lang->ticket->featureBar['browse']['finishedbyme'] = '由我解決';
    $lang->ticket->featureBar['browse']['openedbyme']   = '由我創建';
    $lang->ticket->featureBar['browse']['assignedtome'] = '指派給我';
}

$lang->ticket->errorRecordMinus    = '工時不能為負數';
$lang->ticket->errorCustomedNumber = '"本次消耗"必須為數字';
$lang->ticket->accessDenied        = '您無權訪問該工單';
$lang->ticket->toStory             = '轉' . $lang->SRCommon;
$lang->ticket->toBug               = '轉Bug';
