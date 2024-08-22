<?php
global $config;

/* Actions. */
$lang->project->createGuide         = "選擇{$lang->projectCommon}模板";
$lang->project->index               = "{$lang->projectCommon}儀表盤";
$lang->project->home                = "{$lang->projectCommon}主頁";
$lang->project->create              = "創建{$lang->projectCommon}";
$lang->project->edit                = "編輯{$lang->projectCommon}";
$lang->project->batchEdit           = "批量編輯{$lang->projectCommon}";
$lang->project->view                = "{$lang->projectCommon}概況";
$lang->project->batchEdit           = '批量編輯';
$lang->project->browse              = "{$lang->projectCommon}列表";
$lang->project->all                 = "所有{$lang->projectCommon}";
$lang->project->involved            = "我參與的{$lang->projectCommon}";
$lang->project->start               = "啟動{$lang->projectCommon}";
$lang->project->finish              = "完成{$lang->projectCommon}";
$lang->project->suspend             = "掛起{$lang->projectCommon}";
$lang->project->delete              = "刪除{$lang->projectCommon}";
$lang->project->close               = "關閉{$lang->projectCommon}";
$lang->project->activate            = "激活{$lang->projectCommon}";
$lang->project->group               = "{$lang->projectCommon}權限列表";
$lang->project->createGroup         = "{$lang->projectCommon}創建分組";
$lang->project->editGroup           = "{$lang->projectCommon}編輯分組";
$lang->project->copyGroup           = "{$lang->projectCommon}複製分組";
$lang->project->manageView          = "{$lang->projectCommon}維護視野";
$lang->project->managePriv          = "{$lang->projectCommon}維護權限";
$lang->project->manageMembers       = '團隊管理';
$lang->project->export              = '導出';
$lang->project->addProduct          = "新建{$lang->productCommon}";
$lang->project->manageGroupMember   = '維護分組用戶';
$lang->project->moduleSetting       = '列表設置';
$lang->project->moduleOpen          = '顯示項目集名';
$lang->project->moduleOpenAction    = '顯示項目集名設置';
$lang->project->dynamic             = '動態';
$lang->project->execution           = '執行列表';
$lang->project->bug                 = 'Bug列表';
$lang->project->testcase            = '用例列表';
$lang->project->testtask            = '測試單';
$lang->project->build               = '版本';
$lang->project->updateOrder         = '排序';
$lang->project->sort                = "{$lang->projectCommon}排序";
$lang->project->whitelist           = "{$lang->projectCommon}白名單";
$lang->project->addWhitelist        = "{$lang->projectCommon}添加白名單";
$lang->project->unbindWhitelist     = "{$lang->projectCommon}移除白名單";
$lang->project->manageProducts      = "關聯{$lang->productCommon}";
$lang->project->manageOtherProducts = "關聯其他{$lang->productCommon}";
$lang->project->manageProductPlan   = "關聯{$lang->productCommon}和計劃";
$lang->project->copyTitle           = "請選擇要複製的{$lang->projectCommon}";
$lang->project->errorSameProducts   = "{$lang->projectCommon}不能關聯多個相同的{$lang->productCommon}。";
$lang->project->errorSameBranches   = "{$lang->projectCommon}不能關聯多個相同的分支。";
$lang->project->errorSamePlans      = "{$lang->projectCommon}不能關聯多個相同的計劃。";
$lang->project->errorNoProducts     = "最少關聯一個{$lang->productCommon}";
$lang->project->copyNoProject       = "沒有可用的{$lang->projectCommon}來複制";
$lang->project->searchByName        = "輸入{$lang->projectCommon}名稱進行檢索";
$lang->project->deleted             = '已刪除';
$lang->project->linkedProducts      = "已關聯{$lang->productCommon}";
$lang->project->unlinkedProducts    = '未關聯';
$lang->project->testreport          = '測試報告';
$lang->project->selectProgram       = '項目集篩選';
$lang->project->teamMember          = '團隊成員';
$lang->project->unlinkMember        = '移除成員';
$lang->project->unlinkMemberAction  = '移除團隊成員';
$lang->project->copyTeamTitle       = "選擇一個{$lang->projectCommon}團隊來複制";
$lang->project->daysGreaterProject  = "可用工日不能大於{$lang->projectCommon}的可用工日『%s』";
$lang->project->errorHours          = '可用工時/天不能大於『24』';
$lang->project->workdaysExceed      = '可用工作日不能超過『%s』天';
$lang->project->teamMembersCount    = '，團隊成員共%s人。';
$lang->project->budgetNumber        = '『預算』金額必須為數字。';
$lang->project->budgetGe0           = '『預算』金額必須大於等於0。';
$lang->project->allProjects         = "所有{$lang->projectCommon}";
$lang->project->ignore              = '忽略';
$lang->project->disableExecution    = "不啟用{$lang->executionCommon}的{$lang->projectCommon}";
$lang->project->selectProduct       = "選擇{$lang->productCommon}";

/* Fields. */
$lang->project->common             = "{$lang->projectCommon}";
$lang->project->id                 = "{$lang->projectCommon}ID";
$lang->project->project            = "所屬{$lang->projectCommon}";
$lang->project->stage              = '階段';
$lang->project->model              = "{$lang->projectCommon}管理方式";
$lang->project->PM                 = '負責人';
$lang->project->PO                 = "{$lang->projectCommon}負責人";
$lang->project->QD                 = '測試負責人';
$lang->project->RD                 = '發佈負責人';
$lang->project->name               = "{$lang->projectCommon}名稱";
$lang->project->category           = "{$lang->projectCommon}類型";
$lang->project->desc               = "{$lang->projectCommon}描述";
$lang->project->code               = "{$lang->projectCommon}代號";
$lang->project->hasProduct         = "是否關聯{$lang->productCommon}";
$lang->project->copy               = "複製{$lang->projectCommon}";
$lang->project->begin              = '計劃開始';
$lang->project->end                = '計劃完成';
$lang->project->status             = '狀態';
$lang->project->subStatus          = '子狀態';
$lang->project->type               = "{$lang->projectCommon}類型";
$lang->project->lifetime           = "{$lang->projectCommon}周期";
$lang->project->attribute          = '階段類型';
$lang->project->percent            = '工作量占比';
$lang->project->milestone          = '里程碑';
$lang->project->output             = '輸出';
$lang->project->path               = '路徑';
$lang->project->grade              = '層級';
$lang->project->version            = '版本';
$lang->project->parentVersion      = '父版本';
$lang->project->planDuration       = '計劃周期天數';
$lang->project->realDuration       = '實際周期天數';
$lang->project->openedVersion      = '創建版本';
$lang->project->pri                = '優先順序';
$lang->project->openedBy           = '由誰創建';
$lang->project->openedDate         = '創建日期';
$lang->project->lastEditedBy       = '最後編輯人';
$lang->project->lastEditedDate     = '最後編輯日期';
$lang->project->closedBy           = '由誰關閉';
$lang->project->closedDate         = '關閉日期';
$lang->project->canceledBy         = '由誰取消';
$lang->project->canceledDate       = '取消日期';
$lang->project->team               = '團隊';
$lang->project->teamAction         = '團隊列表';
$lang->project->order              = '排序';
$lang->project->budget             = '預算';
$lang->project->budgetUnit         = '預算單位';
$lang->project->suspendedDate      = '暫停日期';
$lang->project->vision             = '界面';
$lang->project->displayCards       = '每列最大卡片數';
$lang->project->fluidBoard         = '列寬度';
$lang->project->template           = "{$lang->projectCommon}模板";
$lang->project->estimate           = '預計';
$lang->project->consume            = '消耗';
$lang->project->surplus            = '剩餘';
$lang->project->progress           = '進度';
$lang->project->weekProgress       = '本週進度';
$lang->project->dateRange          = '計划起止日期';
$lang->project->to                 = '至';
$lang->project->realBeganAB        = '實際開始';
$lang->project->realEndAB          = '實際完成';
$lang->project->realBegan          = '實際開始日期';
$lang->project->realEnd            = '實際完成日期';
$lang->project->division           = '階段類型';
$lang->project->bygrid             = '看板';
$lang->project->bylist             = '列表';
$lang->project->bycard             = '卡片';
$lang->project->mine               = '我參與的';
$lang->project->myProject          = '我負責';
$lang->project->other              = '其他';
$lang->project->acl                = '訪問控制';
$lang->project->setPlanduration    = '設置工期';
$lang->project->auth               = '權限控制';
$lang->project->durationEstimation = '工作量估算';
$lang->project->leftStories        = '剩餘需求';
$lang->project->leftTasks          = '剩餘任務';
$lang->project->leftBugs           = '剩餘Bug';
$lang->project->leftHours          = '剩餘工時';
$lang->project->children           = "子{$lang->projectCommon}";
$lang->project->parent             = '所屬項目集';
$lang->project->allStories         = '總需求';
$lang->project->doneStories        = '已完成';
$lang->project->doneProjects       = '已結束';
$lang->project->allInput           = "{$lang->projectCommon}總投入";
$lang->project->weekly             = "{$lang->projectCommon}周報";
$lang->project->pv                 = 'PV';
$lang->project->ev                 = 'EV';
$lang->project->sv                 = 'SV';
$lang->project->ac                 = 'AC';
$lang->project->cv                 = 'CV';
$lang->project->pvTitle            = '計劃完成';
$lang->project->evTitle            = '實際完成';
$lang->project->svTitle            = '進度偏差';
$lang->project->acTitle            = '實際花費';
$lang->project->cvTitle            = '成本偏差';
$lang->project->teamCount          = '人數';
$lang->project->teamSumCount       = '共%s人';
$lang->project->longTime           = '長期';
$lang->project->future             = '待定';
$lang->project->moreProject        = "更多{$lang->projectCommon}";
$lang->project->days               = '可用工作日';
$lang->project->mailto             = '抄送給';
$lang->project->etc                = "等";
$lang->project->product            = "所屬{$lang->productCommon}";
$lang->project->branch             = '平台/分支';
$lang->project->plan               = '所屬計劃';
$lang->project->createKanban       = '添加看板';
$lang->project->kanban             = '項目看板';

/* Project Kanban. */
$lang->project->projectTypeList = array();
$lang->project->projectTypeList[1] = "{$lang->productCommon}型{$lang->projectCommon}";
$lang->project->projectTypeList[0] = "{$lang->projectCommon}型{$lang->projectCommon}";

/* Project Kanban. */
$lang->project->typeList = array();
$lang->project->typeList['my']    = "我負責的{$lang->projectCommon}";
$lang->project->typeList['other'] = "其他{$lang->projectCommon}";

$lang->project->divisionList['0'] = "按{$lang->projectCommon}創建";
$lang->project->divisionList['1'] = "按{$lang->productCommon}創建";

$lang->project->divisionSwitchList['0'] = '關閉';
$lang->project->divisionSwitchList['1'] = "開啟";

$lang->project->waitProjects    = "未開始的{$lang->projectCommon}";
$lang->project->doingProjects   = "進行中的{$lang->projectCommon}";
$lang->project->doingExecutions = '進行中的執行(最近1個)';
$lang->project->closedProjects  = "已關閉的{$lang->projectCommon}(最近2個)";
$lang->project->closedProject   = "已關閉的{$lang->projectCommon}";
$lang->project->noProgram       = "無項目集歸屬{$lang->projectCommon}";

$lang->project->laneColorList = array('#32C5FF', '#006AF1', '#9D28B2', '#FF8F26', '#FFC20E', '#00A78E', '#7FBB00', '#424BAC', '#C0E9FF', '#EC2761');

$lang->project->productNotEmpty        = "請關聯{$lang->productCommon}或創建{$lang->productCommon}。";
$lang->project->existProductName       = "{$lang->productCommon}名稱已存在。";
$lang->project->changeProgram          = '%s > 修改項目集';
$lang->project->changeProgramTip       = "修改項目集後，該{$lang->projectCommon}關聯{$lang->productCommon}的項目集也會被修改，請確認是否修改。";
$lang->project->linkedProjectsTip      = "關聯的{$lang->projectCommon}如下";
$lang->project->multiLinkedProductsTip = "該{$lang->projectCommon}關聯的如下{$lang->productCommon}還關聯了其他{$lang->projectCommon}，請取消關聯後再操作";
$lang->project->noticeDivsion          = "當前{$lang->projectCommon}為單套階段，點擊[開啟]可以變為多套階段，每套階段只關聯一個{$lang->productCommon}。";
$lang->project->linkStoryByPlanTips    = "此操作會將所選計划下面的{$lang->SRCommon}全部關聯到此{$lang->projectCommon}中";
$lang->project->createExecution        = "該{$lang->projectCommon}下沒有{$lang->executionCommon}，請先創建{$lang->executionCommon}";
$lang->project->unlinkExecutionMember  = "該用戶參與了%s%s%s個{$lang->execution->common}，是否同時將其移除？（該用戶所產生的數據不會受影響。）";
$lang->project->unlinkExecutionMembers = "移除的團隊成員還參與了{$lang->projectCommon}下的執行，是否同步從執行團隊中移除？";
$lang->project->productTip             = "點擊新建{$lang->productCommon}後，{$lang->projectCommon}將不會關聯已選中的{$lang->productCommon}。";
$lang->project->noDevStage             = "該{$lang->projectCommon}下沒有研發類型的階段，或者您沒有權限訪問，暫時不支持創建版本。";
$lang->project->budgetOverrun          = "{$lang->projectCommon}的預算超出了父項目集的剩餘預算：";
$lang->project->disabledInputTip       = '請先取消%s';
$lang->project->linkRepoFailed         = '關聯代碼庫失敗';
$lang->project->unLinkProductTip       = "您確認要取消與%s的關聯關係嗎？（不影響已關聯的需求）";
$lang->project->summary                = "本頁共 <strong>%s</strong> 個{$lang->projectCommon}。";
$lang->project->allSummary             = "本頁共 <strong>%s</strong> 個{$lang->projectCommon}，未開始 <strong>%s</strong>，進行中 <strong>%s</strong>，已掛起 <strong>%s</strong>，已關閉 <strong>%s</strong> 。";
$lang->project->checkedSummary         = "選中 <strong>%total%</strong> 個{$lang->projectCommon}。";
$lang->project->checkedAllSummary      = "選中 <strong>%total%</strong> 個{$lang->projectCommon}，未開始 <strong>%wait%</strong>，進行中 <strong>%doing%</strong>，已掛起 <strong>%suspended%</strong>，已關閉 <strong>%closed%</strong> 。";

$lang->project->tenThousand    = '萬';
$lang->project->hundredMillion = '億';

$lang->project->unitList['CNY'] = '人民幣';
$lang->project->unitList['USD'] = '美元';
$lang->project->unitList['HKD'] = '港元';
$lang->project->unitList['NTD'] = '台幣';
$lang->project->unitList['EUR'] = '歐元';
$lang->project->unitList['DEM'] = '馬克';
$lang->project->unitList['CHF'] = '瑞士法郎';
$lang->project->unitList['FRF'] = '法國法郎';
$lang->project->unitList['GBP'] = '英鎊';
$lang->project->unitList['NLG'] = '荷蘭盾';
$lang->project->unitList['CAD'] = '加拿大元';
$lang->project->unitList['RUR'] = '盧布';
$lang->project->unitList['INR'] = '盧比';
$lang->project->unitList['AUD'] = '澳大利亞元';
$lang->project->unitList['NZD'] = '新西蘭元';
$lang->project->unitList['THB'] = '泰國銖';
$lang->project->unitList['SGD'] = '新加坡元';

$lang->project->currencySymbol['CNY'] = '¥';
$lang->project->currencySymbol['USD'] = '$';
$lang->project->currencySymbol['HKD'] = 'HK$';
$lang->project->currencySymbol['NTD'] = 'NT$';
$lang->project->currencySymbol['EUR'] = '€';
$lang->project->currencySymbol['DEM'] = 'DEM';
$lang->project->currencySymbol['CHF'] = '₣';
$lang->project->currencySymbol['FRF'] = '₣';
$lang->project->currencySymbol['GBP'] = '£';
$lang->project->currencySymbol['NLG'] = 'ƒ';
$lang->project->currencySymbol['CAD'] = '$';
$lang->project->currencySymbol['RUR'] = '₽';
$lang->project->currencySymbol['INR'] = '₹';
$lang->project->currencySymbol['AUD'] = 'A$';
$lang->project->currencySymbol['NZD'] = 'NZ$';
$lang->project->currencySymbol['THB'] = '฿';
$lang->project->currencySymbol['SGD'] = 'S$';

$lang->project->modelList['']            = "";
if($config->systemMode == 'PLM') $lang->project->modelList['ipd'] = "IPD";
$lang->project->modelList['scrum']       = "Scrum";
if(helper::hasFeature('waterfall')) $lang->project->modelList['waterfall'] = "瀑布";
$lang->project->modelList['kanban']      = "看板";
$lang->project->modelList['agileplus']   = "融合敏捷";
if(helper::hasFeature('waterfallplus')) $lang->project->modelList['waterfallplus'] = "融合瀑布";

$lang->project->featureBar['browse']['all']       = '全部';
$lang->project->featureBar['browse']['undone']    = '未完成';
$lang->project->featureBar['browse']['wait']      = '未開始';
$lang->project->featureBar['browse']['doing']     = '進行中';
$lang->project->featureBar['browse']['suspended'] = '已掛起';
$lang->project->featureBar['browse']['closed']    = '已關閉';

$lang->project->featureBar['index']['all']       = '全部';
$lang->project->featureBar['index']['undone']    = '未完成';
$lang->project->featureBar['index']['wait']      = '未開始';
$lang->project->featureBar['index']['doing']     = '進行中';
$lang->project->featureBar['index']['suspended'] = '已掛起';
$lang->project->featureBar['index']['closed']    = '已關閉';

$lang->project->featureBar['execution']['all']       = '全部';
$lang->project->featureBar['execution']['undone']    = '未完成';
$lang->project->featureBar['execution']['wait']      = '未開始';
$lang->project->featureBar['execution']['doing']     = '進行中';
$lang->project->featureBar['execution']['suspended'] = '已掛起';
$lang->project->featureBar['execution']['closed']    = '已關閉';

$lang->project->featureBar['bug']['all']        = '全部';
$lang->project->featureBar['bug']['unresolved'] = '未解決';

$lang->project->featureBar['testcase']['all']         = '所有';
$lang->project->featureBar['testcase']['wait']        = '待評審';
$lang->project->featureBar['testcase']['needconfirm'] = "需求變動";
$lang->project->featureBar['testcase']['group']       = '分組查看';
$lang->project->featureBar['testcase']['zerocase']    = "零用例{$lang->SRCommon}";
$lang->project->featureBar['testcase']['suite']       = '套件';
$lang->project->featureBar['testcase']['autocase']    = '自動化';

$lang->project->featureBar['build']['all'] = '全部版本';

$lang->project->aclList['private'] = "私有 (只有{$lang->projectCommon}負責人、團隊成員和干係人可訪問)";
$lang->project->aclList['open']    = "公開 (有{$lang->projectCommon}視圖權限即可訪問)";

$lang->project->multipleList['1'] = '是';
$lang->project->multipleList['0'] = '否';

$lang->project->acls['private'] = '私有';
$lang->project->acls['open']    = '公開';

$lang->project->subAclList['private'] = "私有 (只有{$lang->projectCommon}負責人、團隊成員和干係人可訪問)";
$lang->project->subAclList['open']    = "公開 (有{$lang->projectCommon}視圖權限即可訪問)";
$lang->project->subAclList['program'] = "項目集內公開（所有上級項目集負責人和干係人、{$lang->projectCommon}負責人、團隊成員和干係人可訪問）";

$lang->project->kanbanAclList['private'] = "私有 (只有{$lang->projectCommon}負責人、團隊成員可訪問)";
$lang->project->kanbanAclList['open']    = "公開 (有{$lang->projectCommon}視圖權限即可訪問)";

$lang->project->kanbanSubAclList['private'] = "私有 (只有{$lang->projectCommon}負責人、團隊成員可訪問)";
$lang->project->kanbanSubAclList['open']    = "公開 (有{$lang->projectCommon}視圖權限即可訪問)";
$lang->project->kanbanSubAclList['program'] = "項目集內公開（所有上級項目集負責人和干係人、{$lang->projectCommon}負責人、團隊成員可訪問）";

if($config->systemMode == 'light')
{
    unset($lang->project->subAclList['program']);
    unset($lang->project->kanbanSubAclList['program']);
}

$lang->project->authList['extend'] = "繼承 (取系統權限與{$lang->projectCommon}權限的合集)";
$lang->project->authList['reset']  = "重新定義 (只取{$lang->projectCommon}權限)";

$lang->project->statusList['']          = '';
$lang->project->statusList['wait']      = '未開始';
$lang->project->statusList['doing']     = '進行中';
$lang->project->statusList['suspended'] = '已掛起';
$lang->project->statusList['closed']    = '已關閉';
$lang->project->statusList['delay']     = '已延期';

$lang->project->endList[31]  = '一個月';
$lang->project->endList[93]  = '三個月';
$lang->project->endList[186] = '半年';
$lang->project->endList[365] = '一年';
$lang->project->endList[999] = '長期';

$lang->project->ipdTitle           = "整合產品開發";
$lang->project->scrumTitle         = "敏捷開發全流程{$lang->projectCommon}管理";
$lang->project->waterfallTitle     = "瀑布式{$lang->projectCommon}管理";
$lang->project->kanbanTitle        = "專業研發看板{$lang->projectCommon}管理";
$lang->project->agileplusTitle     = "敏捷+看板{$lang->projectCommon}管理";
$lang->project->waterfallplusTitle = "瀑布+敏捷+看板{$lang->projectCommon}管理";
$lang->project->moreModelTitle     = '更多模型敬請期待...';

$lang->project->empty                  = "暫時沒有{$lang->projectCommon}";
$lang->project->nextStep               = '下一步';
$lang->project->hoursUnit              = '%s 工時';
$lang->project->membersUnit            = '%s人';
$lang->project->lastIteration          = "近期{$lang->executionCommon}";
$lang->project->lastKanban             = '近期看板';
$lang->project->ongoingStage           = '進行中的階段';
$lang->project->ipd                    = 'IPD';
$lang->project->scrum                  = 'Scrum';
$lang->project->waterfall              = '瀑布';
$lang->project->agileplus              = '融合敏捷';
$lang->project->waterfallplus          = '融合瀑布';
$lang->project->cannotCreateChild      = "該{$lang->projectCommon}已經有實際的內容，無法直接添加子{$lang->projectCommon}。您可以為當前{$lang->projectCommon}創建一個父{$lang->projectCommon}，然後在新的父{$lang->projectCommon}下面添加子{$lang->projectCommon}。";
$lang->project->emptyPM                = '暫無';
$lang->project->emptyBranch            = '分支不能為空！';
$lang->project->cannotChangeToCat      = "該{$lang->projectCommon}已經有實際的內容，無法修改為父{$lang->projectCommon}";
$lang->project->cannotCancelCat        = "該{$lang->projectCommon}下已經有子{$lang->projectCommon}，無法取消父{$lang->projectCommon}標記";
$lang->project->parentBeginEnd         = "父{$lang->projectCommon}起止時間：%s ~ %s";
$lang->project->childLongTime          = "子{$lang->projectCommon}中有長期{$lang->projectCommon}，父{$lang->projectCommon}也應該是長期{$lang->projectCommon}";
$lang->project->readjustTime           = "重新調整{$lang->projectCommon}起止時間";
$lang->project->notAllowRemoveProducts = "該{$lang->productCommon}中的需求與{$lang->projectCommon}進行了關聯或者{$lang->projectCommon}下的{$lang->execution->common}關聯了該{$lang->productCommon}，請取消關聯後再操作。";
$lang->project->ge                     = "『%s』應當不小於實際開始時間『%s』。";

$lang->project->programTitle['0']    = '不顯示';
$lang->project->programTitle['base'] = '只顯示一級項目集';
$lang->project->programTitle['end']  = '只顯示最後一級項目集';

$lang->project->accessDenied         = "您無權訪問該{$lang->projectCommon}！";
$lang->project->chooseProgramType    = "選擇{$lang->projectCommon}管理方式";
$lang->project->cannotCreateChild    = "該{$lang->projectCommon}已經有實際的內容，無法直接添加子{$lang->projectCommon}。您可以為當前{$lang->projectCommon}創建一個父{$lang->projectCommon}，然後在新的父{$lang->projectCommon}下面添加子{$lang->projectCommon}。";
$lang->project->hasChildren          = "該{$lang->projectCommon}有子{$lang->projectCommon}存在，不能刪除。";
$lang->project->confirmDelete        = "您確定刪除{$lang->projectCommon}“%s”嗎？";
$lang->project->cannotChangeToCat    = "該{$lang->projectCommon}已經有實際的內容，無法修改為父{$lang->projectCommon}";
$lang->project->cannotCancelCat      = "該{$lang->projectCommon}下已經有子{$lang->projectCommon}，無法取消父{$lang->projectCommon}標記";
$lang->project->parentBeginEnd       = "父{$lang->projectCommon}起止時間：%s ~ %s";
$lang->project->parentBudget         = "父項目集預算：";
$lang->project->beginLetterParent    = "{$lang->projectCommon}的開始日期小於了父項目集的開始日期：";
$lang->project->endGreaterParent     = "{$lang->projectCommon}的完成日期大於了父項目集的完成日期：";
$lang->project->dateExceedParent     = "{$lang->projectCommon}的起止日期已超出父項目集的起止日期：";
$lang->project->beginGreateChild     = "{$lang->projectCommon}的開始日期應大於等於項目集的最小開始日期：%s";
$lang->project->endLetterChild       = "{$lang->projectCommon}的完成日期應小於等於項目集的最大完成日期：%s";
$lang->project->begigLetterExecution = "{$lang->projectCommon}的開始日期應小於等於執行的最小開始日期：%s";
$lang->project->endGreateExecution   = "{$lang->projectCommon}的完成日期應大於等於{$lang->executionCommon}的最大完成日期：%s";
$lang->project->childLongTime        = "子{$lang->projectCommon}中有長期{$lang->projectCommon}，父{$lang->projectCommon}也應該是長期{$lang->projectCommon}";
$lang->project->confirmUnlinkMember  = "您確定從該{$lang->projectCommon}中移除該用戶嗎？";
$lang->project->divisionTips         = "按{$lang->projectCommon}創建為單套階段，階段關聯所有{$lang->productCommon}；按{$lang->productCommon}創建為多套階段，每套階段關聯一個{$lang->productCommon}。";

$lang->project->action = new stdclass();
$lang->project->action->managed = '$date, 由 <strong>$actor</strong> 維護。$extra' . "\n";

$lang->project->multiple = "啟用{$lang->executionCommon}";

$lang->project->copyProject = new stdClass();
$lang->project->copyProject->nameTips           = "『{$lang->projectCommon}名稱』不可重複需要修改。";
$lang->project->copyProject->codeTips           = "『{$lang->projectCommon}代號』不可重複需要修改。";
$lang->project->copyProject->endTips            = '『計劃完成』不能為空。';
$lang->project->copyProject->daysTips           = '『可用工作日』應當是數字。';

$lang->project->linkBranchStoryByPlanTips = "{$lang->projectCommon}按計劃關聯需求時，只導入本{$lang->projectCommon}所關聯%s的激活狀態的需求。";
$lang->project->linkNormalStoryByPlanTips = "{$lang->projectCommon}按計劃關聯需求時，只導入激活狀態的需求。";
$lang->project->cannotManageProducts      = "該{$lang->projectCommon}為{$lang->projectCommon}型{$lang->projectCommon}，不能關聯{$lang->productCommon}。";

$lang->project->featureBar['dynamic']['all']       = '全部';
$lang->project->featureBar['dynamic']['today']     = '今天';
$lang->project->featureBar['dynamic']['yesterday'] = '昨天';
$lang->project->featureBar['dynamic']['thisWeek']  = '本週';
$lang->project->featureBar['dynamic']['lastWeek']  = '上周';
$lang->project->featureBar['dynamic']['thisMonth'] = '本月';
$lang->project->featureBar['dynamic']['lastMonth'] = '上月';
