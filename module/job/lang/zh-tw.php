<?php
$lang->job->common        = '構建任務';
$lang->job->browse        = '瀏覽構建任務';
$lang->job->create        = '添加流水綫';
$lang->job->edit          = '編輯流水綫';
$lang->job->exec          = '執行流水綫';
$lang->job->runPipeline   = '運行流水綫';
$lang->job->view          = '流水綫詳情';
$lang->job->delete        = '刪除流水綫';
$lang->job->confirmDelete = '確認刪除該流水綫';
$lang->job->dirChange     = '目錄改動';
$lang->job->buildTag      = '打標籤';
$lang->job->execSuccess   = '執行成功';

$lang->job->browseAction = '流水綫列表';

$lang->job->id              = 'ID';
$lang->job->name            = '流水綫名稱';
$lang->job->repo            = '關聯代碼庫';
$lang->job->branch          = '分支';
$lang->job->product         = '關聯' . $lang->productCommon;
$lang->job->svnDir          = 'SVN監控路徑';
$lang->job->jenkins         = 'Jenkins';
$lang->job->jkHost          = 'Jenkins伺服器';
$lang->job->jkJob           = 'Jenkins任務';
$lang->job->buildSpec       = '構建對象'; // 'pipeline@server'
$lang->job->engine          = '引擎';
$lang->job->server          = '伺服器';
$lang->job->pipeline        = '流水綫';
$lang->job->buildType       = '構建類型';
$lang->job->frame           = '工具/框架';
$lang->job->triggerType     = '觸發方式';
$lang->job->atDay           = '自定義日期';
$lang->job->atTime          = '執行時間';
$lang->job->lastStatus      = '最後執行狀態';
$lang->job->lastExec        = '最後執行時間';
$lang->job->comment         = '匹配關鍵字';
$lang->job->customParam     = '自定義構建參數';
$lang->job->paramName       = '名稱';
$lang->job->paramValue      = '值';
$lang->job->custom          = '自定義';
$lang->job->createdBy       = '由誰創建';
$lang->job->createdDate     = '創建日期';
$lang->job->editedBy        = '由誰編輯';
$lang->job->editedDate      = '編輯日期';
$lang->job->lastTag         = '最後標籤';
$lang->job->deleted         = '已刪除';
$lang->job->repoServer      = '版本庫伺服器';
$lang->job->sonarqubeServer = 'SonarQube伺服器';
$lang->job->projectKey      = 'SonarQube項目';

$lang->job->lblBasic = '基本信息';

$lang->job->example        = '舉例';
$lang->job->commitEx       = "用於匹配創建構建任務的關鍵字，多個關鍵字用','分割";
$lang->job->cronSample     = '如 0 0 2 * * 2-6/1 表示每個工作日凌晨2點';
$lang->job->sendExec       = '發送執行請求成功！執行結果：%s';
$lang->job->inputName      = '請輸入參數名稱。';
$lang->job->invalidName    = '參數名稱應該是英文字母、數字或下劃線的組合。';
$lang->job->repoExists     = '此版本庫已關聯構建任務『%s』';
$lang->job->projectExists  = '此SonarQube項目已關聯構建任務『%s』';
$lang->job->mustUseJenkins = 'SonarQube工具/框架僅在構建引擎為JenKins的情況下使用';
$lang->job->jobIsDeleted   = '此版本庫已關聯構建任務,請從資源回收筒查看數據';
$lang->job->selectPipeline = '請選擇流水綫';

$lang->job->buildTypeList['build']          = '僅構建';
$lang->job->buildTypeList['buildAndDeploy'] = '構建部署';
$lang->job->buildTypeList['buildAndTest']   = '構建測試';

$lang->job->triggerTypeList['tag']      = '打標籤';
$lang->job->triggerTypeList['commit']   = '提交註釋包含關鍵字';
$lang->job->triggerTypeList['schedule'] = '定時計劃';

$lang->job->frameList['']          = '';
$lang->job->frameList['junit']     = 'JUnit';
$lang->job->frameList['testng']    = 'TestNG';
$lang->job->frameList['phpunit']   = 'PHPUnit';
$lang->job->frameList['pytest']    = 'Pytest';
$lang->job->frameList['jtest']     = 'JTest';
$lang->job->frameList['cppunit']   = 'CppUnit';
$lang->job->frameList['gtest']     = 'GTest';
$lang->job->frameList['qtest']     = 'QTest';
$lang->job->frameList['sonarqube'] = 'SonarQube';

$lang->job->paramValueList['']                 = '';
$lang->job->paramValueList['$zentao_version']  = '當前版本號';
$lang->job->paramValueList['$zentao_account']  = '當前用戶名';
$lang->job->paramValueList['$zentao_product']  = "當前{$lang->productCommon}ID";
$lang->job->paramValueList['$zentao_repopath'] = '當前版本庫路徑';

$lang->job->engineList = array();
$lang->job->engineList['']        = '';
$lang->job->engineList['gitlab']  = 'GitLab';
$lang->job->engineList['jenkins'] = 'Jenkins';

$lang->job->engineTips = new stdclass;
$lang->job->engineTips->success = '構建引擎將使用GitLab項目內置的流水綫。';
$lang->job->engineTips->error   = '當前GitLab項目內沒有可用的流水綫，請先前往GitLab配置。';

$lang->job->pipelineTips                      = "選擇要運行流水綫的分支名或標籤名";
$lang->job->pipelineVariables                 = "變數";
$lang->job->pipelineVariablesKeyPlaceHolder   = "輸入變數的名稱";
$lang->job->pipelineVariablesValuePlaceHolder = "輸入變數的值";
$lang->job->pipelineVariablesTips             = "指定要在此次運行中使用的變數值。CI/CD設置中指定的值將用作預設值。";
$lang->job->setReferenceTips                  = "在執行構建前，請先設置代碼庫的分支信息。";

$lang->job->featureBar['browse']['job']     = '列表';
$lang->job->featureBar['browse']['compile'] = '執行歷史';
