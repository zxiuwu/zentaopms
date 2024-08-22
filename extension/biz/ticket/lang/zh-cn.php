<?php
$lang->ticket->common          = '工单';
$lang->ticket->index           = '工单首页';
$lang->ticket->id              = '工单编号';
$lang->ticket->idAB            = 'ID';
$lang->ticket->product         = '所属' . $lang->productCommon;
$lang->ticket->branch          = '分支/平台';
$lang->ticket->module          = '所属模块';
$lang->ticket->type            = '类型';
$lang->ticket->status          = '状态';
$lang->ticket->subStatus       = '子状态';
$lang->ticket->openedBuild     = '影响版本';
$lang->ticket->allBuilds       = '所有';
$lang->ticket->assignedTo      = '指派给';
$lang->ticket->assignedDate    = '指派日期';
$lang->ticket->deadline        = '截止日期';
$lang->ticket->title           = '标题';
$lang->ticket->pri             = '优先级';
$lang->ticket->priAB           = 'P';
$lang->ticket->estimate        = '预计';
$lang->ticket->desc            = '描述';
$lang->ticket->source          = '工单来源';
$lang->ticket->keywords        = '关键字';
$lang->ticket->files           = '文件';
$lang->ticket->from            = '来源';
$lang->ticket->customer        = '来源客户';
$lang->ticket->contact         = '联系人';
$lang->ticket->notifyEmail     = '通知邮箱';
$lang->ticket->mailto          = '抄送给';
$lang->ticket->resolution      = '解决方案';
$lang->ticket->legendLife      = '工单的一生';
$lang->ticket->legendMisc      = '其他相关';
$lang->ticket->createdBy       = '创建者';
$lang->ticket->createdByAB     = '由谁创建';
$lang->ticket->createdDate     = '创建日期';
$lang->ticket->colorTag        = '颜色标签';
$lang->ticket->legendBasicInfo = '基本信息';
$lang->ticket->legendLife      = '工单的一生';
$lang->ticket->contacts        = '工单联系人';
$lang->ticket->story           = '需求';
$lang->ticket->bug             = 'Bug';
$lang->ticket->lastEditedBy    = '最后修改';
$lang->ticket->lastEditedDate  = '最后操作时间';
$lang->ticket->search          = '搜索';
$lang->ticket->fromFeedback    = '来源反馈';
$lang->ticket->deleted         = '已删除';
$lang->ticket->syncProduct     = '同步' . $lang->productCommon . '模块';
$lang->ticket->descFiles       = '描述的附件';
$lang->ticket->resolutionFiles = '解决方案的附件';
$lang->ticket->addSource       = '添加来源';
$lang->ticket->deleteSource    = '删除来源';
$lang->ticket->export          = '导出';
$lang->ticket->exportAction    = '导出工单';
$lang->ticket->openedBy        = '由谁创建';
$lang->ticket->openedDate      = '创建时间';
$lang->ticket->feedback        = '由反馈转化';
$lang->ticket->editedDate      = '最后修改时间';

$lang->ticket->create = '创建工单';
$lang->ticket->browse = '工单列表';
$lang->ticket->edit   = '编辑工单';
$lang->ticket->delete = '删除工单';
$lang->ticket->view   = '工单详情';

$lang->ticket->statusList['']        = '';
$lang->ticket->statusList['wait']    = '等待';
$lang->ticket->statusList['doing']   = '处理中';
$lang->ticket->statusList['done']    = '已处理';
$lang->ticket->statusList['closed']  = '已关闭';

$lang->ticket->typeList['']         = '';
$lang->ticket->typeList['code']     = '程序报错';
$lang->ticket->typeList['data']     = '数据错误';
$lang->ticket->typeList['stuck']    = '流程卡断';
$lang->ticket->typeList['security'] = '安全问题';
$lang->ticket->typeList['affair']   = '事务';

$lang->ticket->priList[]  = '';
$lang->ticket->priList[1] = '1';
$lang->ticket->priList[2] = '2';
$lang->ticket->priList[3] = '3';
$lang->ticket->priList[4] = '4';

$lang->ticket->start            = '开始';
$lang->ticket->started          = '开始了';
$lang->ticket->realStarted      = '实际开始';
$lang->ticket->createStory      = '提需求';
$lang->ticket->createBug        = '提Bug';
$lang->ticket->hour             = '小时';
$lang->ticket->consumed         = '总计消耗';
$lang->ticket->left             = '预计剩余';
$lang->ticket->assign           = '指派';
$lang->ticket->assignTo         = '指派';
$lang->ticket->estimate         = '最初预计';
$lang->ticket->confirmDelete    = '您确认要删除这个工单吗？';
$lang->ticket->confirmClose     = '您确认要关闭这个工单吗？';
$lang->ticket->noTicket         = '暂时没有工单';
$lang->ticket->close            = '关闭';
$lang->ticket->closedReason     = '关闭原因';
$lang->ticket->repeatTicket     = '重复工单';
$lang->ticket->closedBy         = '关闭者';
$lang->ticket->closedByAB       = '由谁关闭';
$lang->ticket->closedDate       = '关闭时间';
$lang->ticket->noRequire        = '%s“%s”不能为空。';
$lang->ticket->notifyEmailError = '%s应当为合法的邮箱。';
$lang->ticket->finish           = '完成';
$lang->ticket->finished         = '完成了';
$lang->ticket->hasConsumed      = '之前消耗';
$lang->ticket->currentConsumed  = '本次消耗';
$lang->ticket->startedBy        = '由谁开始';
$lang->ticket->startedDate      = '开始时间';
$lang->ticket->finishedBy       = '完成者';
$lang->ticket->finishedByAB     = '由谁完成';
$lang->ticket->finishedDate     = '完成时间';
$lang->ticket->activate         = "激活";
$lang->ticket->activatedBy      = "由谁激活";
$lang->ticket->activatedDate    = "激活时间";
$lang->ticket->activatedCount   = "激活次数";
$lang->ticket->editedBy         = "由谁编辑";
$lang->ticket->editedByAB       = "最后操作";
$lang->ticket->resolvedBy       = "解决者";
$lang->ticket->resolvedDate     = "解决时间";
$lang->ticket->batchEdit        = '批量编辑';
$lang->ticket->batchFinish      = '批量完成';
$lang->ticket->batchClose       = '批量关闭';
$lang->ticket->batchActivate    = '批量激活';
$lang->ticket->batchAssignTo    = '批量指派';
$lang->ticket->batchEditTip     = '工单ID%s状态为已关闭，无法进行批量编辑操作。';
$lang->ticket->batchFinishTip   = '工单ID%s状态为已处理或已关闭，无法进行批量完成操作。';
$lang->ticket->batchActivateTip = '工单ID%s状态为等待或处理中，无法进行批量激活操作。';
$lang->ticket->noAssigned       = '未指派';

$lang->ticket->closedReasonList['']          = '';
$lang->ticket->closedReasonList['commented'] = '已处理';
$lang->ticket->closedReasonList['repeat']    = '重复';
$lang->ticket->closedReasonList['refuse']    = '不予处理';

$lang->ticket->featureBar['browse']['all'] = '全部';
if($this->config->vision == 'lite')
{
    $lang->ticket->featureBar['browse']['unclosed'] = '未关闭';
}
else
{
    $lang->ticket->featureBar['browse']['wait']         = '待处理';
    $lang->ticket->featureBar['browse']['doing']        = '处理中';
    $lang->ticket->featureBar['browse']['done']         = '待关闭';
    $lang->ticket->featureBar['browse']['finishedbyme'] = '由我解决';
    $lang->ticket->featureBar['browse']['openedbyme']   = '由我创建';
    $lang->ticket->featureBar['browse']['assignedtome'] = '指派给我';
}

$lang->ticket->errorRecordMinus    = '工时不能为负数';
$lang->ticket->errorCustomedNumber = '"本次消耗"必须为数字';
$lang->ticket->accessDenied        = '您无权访问该工单';
$lang->ticket->toStory             = '转' . $lang->SRCommon;
$lang->ticket->toBug               = '转Bug';
