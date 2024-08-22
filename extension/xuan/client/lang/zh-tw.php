<?php
$lang->client->common       = '版本更新';
$lang->client->create       = '客戶端版本';
$lang->client->browse       = '客戶端版本更新列表';
$lang->client->edit         = '編輯客戶端';
$lang->client->delete       = '刪除版本';
$lang->client->checkUpgrade = '檢查更新';
$lang->client->set          = '參數設置';
$lang->client->xxdStatus    = 'XXD狀態';
$lang->client->polling      = '輪詢間隔';
$lang->client->xxdRunTime   = 'XXD運行時間';

$lang->client->id              = 'ID';
$lang->client->version         = '客戶端版本';
$lang->client->update          = '更新';
$lang->client->xxcVersion      = 'XXC版本';
$lang->client->main            = '重要更新內容';
$lang->client->createdDate     = '發佈日期';
$lang->client->desc            = '升級描述';
$lang->client->see             = '查看';
$lang->client->changeLog       = '更新日誌';
$lang->client->strategy        = '升級策略';
$lang->client->download        = '下載';
$lang->client->downloading     = '下載中...';
$lang->client->downloadLink    = '下載地址';
$lang->client->downloadFail    = '下載失敗，' . $lang->client->downloadLink;
$lang->client->downloadSuccess = '下載成功';
$lang->client->releaseStatus   = '發佈狀態';
$lang->client->wrongVersion    = '<strong>版本</strong>格式不正確，例如：3.4.9 、3.5 或者 3.5 beta1';
$lang->client->downloadTip     = '下載後請檢查壓縮包完整性，如果壓縮包損壞，請使用其它工具下載後上傳至 www/data/client 對應的目錄下';
$lang->client->versionError    = '獲取更新信息異常，請稍後再試，或者聯繫喧喧官方客服。';
$lang->client->urlError        = '<strong>%s</strong> 應當為合法的 zip 格式升級包下載地址。';

$lang->client->noData                 = '暫無';
$lang->client->saveClientError        = '無法保持更新信息。';
$lang->client->downloadErrorTip       = '請使用其它工具下載後上傳至';
$lang->client->downloadFailedTip      = '無法下載安裝包，請稍後重新嘗試下載，或者使用其它工具下載後上傳至 www/data/client 對應的目錄下。';
$lang->client->alreadyLastestVersion  = '當前已是最新版本';
$lang->client->cannotUseUpdateServer  = '無法獲取官方版本信息';
$lang->client->foundNewVersion        = '發現新版本客戶端';
$lang->client->currentVersion         = '當前版本';
$lang->client->upgradeToThisVersion   = '升級到此版本';
$lang->client->downloadClientPackages = '選擇用於升級的安裝包';
$lang->client->publishUpdate          = '立即發佈更新';
$lang->client->saveUpdate             = '僅保存更新';
$lang->client->selectUpgradeStrategy  = '選擇升級策略';
$lang->client->or                     = '或';
$lang->client->inCatalog              = '目錄下。';
$lang->client->fileNameIs             = '安裝包檔案名為';
$lang->client->fileSize               = '附件大小';
$lang->client->goUpdate               = '去更新';
$lang->client->countUsers             = '當前在綫用戶數';
$lang->client->setServer              = '伺服器設置';
$lang->client->totalUsers             = '總用戶數';
$lang->client->totalGroups            = '討論組數';
$lang->client->totalMessages          = '消息數量';
$lang->client->xxdStartDate           = 'XXD上次啟動時間';
$lang->client->xxcNotice              = '喧喧發佈新版本';

$lang->client->strategies['force']    = '強制';
$lang->client->strategies['optional'] = '可選';

$lang->client->status['wait']     = '待發佈';
$lang->client->status['released'] = '已發佈';

$lang->client->zipList['win64zip']   = 'Windows 64位';
$lang->client->zipList['win32zip']   = 'Windows 32位';
$lang->client->zipList['macOSzip']   = 'macOS';
$lang->client->zipList['linux64zip'] = 'Linux 64位';
$lang->client->zipList['linux32zip'] = 'Linux 32位';

$lang->client->message = array();
$lang->client->message['total'] = '總消息數';
$lang->client->message['hour']  = '最近一小時消息數';
$lang->client->message['day']   = '最近一天消息數';

$lang->client->sizeType = array();
$lang->client->sizeType['K'] = 1024;
$lang->client->sizeType['M'] = 1024 * 1024;
$lang->client->sizeType['G'] = 1024 * 1024 * 1024;

$lang->client->xxdStatusList = array();
$lang->client->xxdStatusList['online']  = '在綫';
$lang->client->xxdStatusList['offline'] = '離線';

$lang->client->downloadClient = '下載客戶端';
$lang->client->os             = '操作系統';
$lang->client->downloading    = '正在獲取安裝包';
$lang->client->downloaded     = '成功獲取安裝包';
$lang->client->setting        = '正在設置配置信息';
$lang->client->setted         = '成功設置配置信息';

$lang->client->generate = '生成';
$lang->client->copy     = '複製';
$lang->client->links    = '下載連結';
$lang->client->getDownloadLinks = '獲取客戶端下載連結';
$lang->client->serverMightHang  = '下載和處理客戶端時，伺服器可能暫時失去響應，請耐心等待。';

$lang->client->osList['win64']   = 'Windows 64';
$lang->client->osList['win32']   = 'Windows 32';
$lang->client->osList['linux64'] = 'Linux 64';
$lang->client->osList['linux32'] = 'Linux 32';
$lang->client->osList['mac']     = 'macOS';

$lang->client->errorInfo = new stdclass();
$lang->client->errorInfo->downloadError  = '獲取安裝包失敗';
$lang->client->errorInfo->configError    = '配置用戶信息失敗';
$lang->client->errorInfo->manualOpt      = '請<a href="%s" target="_blank" rel="noreferrer noopener">手動獲取安裝包</a>。';
$lang->client->errorInfo->dirNotExist    = '客戶端下載存儲路徑 <span class="code text-red">%s</span> 不存在，請創建該目錄。';
$lang->client->errorInfo->dirNotWritable = '客戶端下載存儲路徑 <span class="code text-red">%s</span> 不可寫 <br />linux下面請執行命令：<span class="code text-red">sudo chmod 777 %s</span>來修正';

$lang->client->userDownloadTips = '點擊下載按鈕即可下載包含當前伺服器信息和賬號配置的喧喧客戶端。';
$lang->client->generateLinkTips = '點擊獲取連結按鈕可以生成用於在內部分發的喧喧客戶端 zip 包下載連結。';

$lang->client->releaseTip = "發佈後用戶將會在客戶端收到版本升級提醒。";
