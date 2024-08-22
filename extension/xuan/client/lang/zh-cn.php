<?php
$lang->client->common       = '版本更新';
$lang->client->create       = '客户端版本';
$lang->client->browse       = '客户端版本更新列表';
$lang->client->edit         = '编辑客户端';
$lang->client->delete       = '删除版本';
$lang->client->checkUpgrade = '检查更新';
$lang->client->set          = '参数设置';
$lang->client->xxdStatus    = 'XXD状态';
$lang->client->polling      = '轮询间隔';
$lang->client->xxdRunTime   = 'XXD运行时间';

$lang->client->id              = 'ID';
$lang->client->version         = '客户端版本';
$lang->client->update          = '更新';
$lang->client->xxcVersion      = 'XXC版本';
$lang->client->main            = '重要更新内容';
$lang->client->createdDate     = '发布日期';
$lang->client->desc            = '升级描述';
$lang->client->see             = '查看';
$lang->client->changeLog       = '更新日志';
$lang->client->strategy        = '升级策略';
$lang->client->download        = '下载';
$lang->client->downloading     = '下载中...';
$lang->client->downloadLink    = '下载地址';
$lang->client->downloadFail    = '下载失败，' . $lang->client->downloadLink;
$lang->client->downloadSuccess = '下载成功';
$lang->client->releaseStatus   = '发布状态';
$lang->client->wrongVersion    = '<strong>版本</strong>格式不正确，例如：3.4.9 、3.5 或者 3.5 beta1';
$lang->client->downloadTip     = '下载后请检查压缩包完整性，如果压缩包损坏，请使用其它工具下载后上传至 www/data/client 对应的目录下';
$lang->client->versionError    = '获取更新信息异常，请稍后再试，或者联系喧喧官方客服。';
$lang->client->urlError        = '<strong>%s</strong> 应当为合法的 zip 格式升级包下载地址。';

$lang->client->noData                 = '暂无';
$lang->client->saveClientError        = '无法保持更新信息。';
$lang->client->downloadErrorTip       = '请使用其它工具下载后上传至';
$lang->client->downloadFailedTip      = '无法下载安装包，请稍后重新尝试下载，或者使用其它工具下载后上传至 www/data/client 对应的目录下。';
$lang->client->alreadyLastestVersion  = '当前已是最新版本';
$lang->client->cannotUseUpdateServer  = '无法获取官方版本信息';
$lang->client->foundNewVersion        = '发现新版本客户端';
$lang->client->currentVersion         = '当前版本';
$lang->client->upgradeToThisVersion   = '升级到此版本';
$lang->client->downloadClientPackages = '选择用于升级的安装包';
$lang->client->publishUpdate          = '立即发布更新';
$lang->client->saveUpdate             = '仅保存更新';
$lang->client->selectUpgradeStrategy  = '选择升级策略';
$lang->client->or                     = '或';
$lang->client->inCatalog              = '目录下。';
$lang->client->fileNameIs             = '安装包文件名为';
$lang->client->fileSize               = '附件大小';
$lang->client->goUpdate               = '去更新';
$lang->client->countUsers             = '当前在线用户数';
$lang->client->setServer              = '服务器设置';
$lang->client->totalUsers             = '总用户数';
$lang->client->totalGroups            = '讨论组数';
$lang->client->totalMessages          = '消息数量';
$lang->client->xxdStartDate           = 'XXD上次启动时间';
$lang->client->xxcNotice              = '喧喧发布新版本';

$lang->client->strategies['force']    = '强制';
$lang->client->strategies['optional'] = '可选';

$lang->client->status['wait']     = '待发布';
$lang->client->status['released'] = '已发布';

$lang->client->zipList['win64zip']   = 'Windows 64位';
$lang->client->zipList['win32zip']   = 'Windows 32位';
$lang->client->zipList['macOSzip']   = 'macOS';
$lang->client->zipList['linux64zip'] = 'Linux 64位';
$lang->client->zipList['linux32zip'] = 'Linux 32位';

$lang->client->message = array();
$lang->client->message['total'] = '总消息数';
$lang->client->message['hour']  = '最近一小时消息数';
$lang->client->message['day']   = '最近一天消息数';

$lang->client->sizeType = array();
$lang->client->sizeType['K'] = 1024;
$lang->client->sizeType['M'] = 1024 * 1024;
$lang->client->sizeType['G'] = 1024 * 1024 * 1024;

$lang->client->xxdStatusList = array();
$lang->client->xxdStatusList['online']  = '在线';
$lang->client->xxdStatusList['offline'] = '离线';

$lang->client->downloadClient = '下载客户端';
$lang->client->os             = '操作系统';
$lang->client->downloading    = '正在获取安装包';
$lang->client->downloaded     = '成功获取安装包';
$lang->client->setting        = '正在设置配置信息';
$lang->client->setted         = '成功设置配置信息';

$lang->client->generate = '生成';
$lang->client->copy     = '复制';
$lang->client->links    = '下载链接';
$lang->client->getDownloadLinks = '获取客户端下载链接';
$lang->client->serverMightHang  = '下载和处理客户端时，服务器可能暂时失去响应，请耐心等待。';

$lang->client->osList['win64']   = 'Windows 64';
$lang->client->osList['win32']   = 'Windows 32';
$lang->client->osList['linux64'] = 'Linux 64';
$lang->client->osList['linux32'] = 'Linux 32';
$lang->client->osList['mac']     = 'macOS';

$lang->client->errorInfo = new stdclass();
$lang->client->errorInfo->downloadError  = '获取安装包失败';
$lang->client->errorInfo->configError    = '配置用户信息失败';
$lang->client->errorInfo->manualOpt      = '请<a href="%s" target="_blank" rel="noreferrer noopener">手动获取安装包</a>。';
$lang->client->errorInfo->dirNotExist    = '客户端下载存储路径 <span class="code text-red">%s</span> 不存在，请创建该目录。';
$lang->client->errorInfo->dirNotWritable = '客户端下载存储路径 <span class="code text-red">%s</span> 不可写 <br />linux下面请执行命令：<span class="code text-red">sudo chmod 777 %s</span>来修正';

$lang->client->userDownloadTips = '点击下载按钮即可下载包含当前服务器信息和账号配置的喧喧客户端。';
$lang->client->generateLinkTips = '点击获取链接按钮可以生成用于在内部分发的喧喧客户端 zip 包下载链接。';

$lang->client->releaseTip = "发布后用户将会在客户端收到版本升级提醒。";
