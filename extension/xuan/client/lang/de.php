<?php
$lang->client->common       = 'Client updates';
$lang->client->create       = 'Add client version';
$lang->client->browse       = 'Client update versions';
$lang->client->edit         = 'Edit client update version';
$lang->client->delete       = 'Delete client updates';
$lang->client->checkUpgrade = 'Check for updates';
$lang->client->set          = 'Params';
$lang->client->xxdStatus    = 'XXD Status';
$lang->client->polling      = 'Polling';
$lang->client->xxdRunTime   = 'XXD Run Time';

$lang->client->id              = 'ID';
$lang->client->version         = 'Client version';
$lang->client->update          = 'Update';
$lang->client->xxcVersion      = 'XXC Version';
$lang->client->main            = 'Main Content';
$lang->client->createdDate     = 'Created Date';
$lang->client->desc            = 'Description';
$lang->client->see             = 'See';
$lang->client->changeLog       = 'Log';
$lang->client->strategy        = 'Strategy';
$lang->client->download        = 'Download';
$lang->client->downloading     = 'Downloading...';
$lang->client->downloadLink    = 'Download link';
$lang->client->downloadFail    = 'Download fail,' . $lang->client->downloadLink;
$lang->client->downloadSuccess = 'Download success';
$lang->client->releaseStatus   = 'Status';
$lang->client->wrongVersion    = '<strong>Version</strong> format is incorrect. Example：3.4.9 , 3.5 or 3.5 beta1';
$lang->client->downloadTip     = 'Please check the integrity of the package after downloading. If it is damaged, please upload it to the corresponding directory of www/data/client.';
$lang->client->versionError    = 'Update error';
$lang->client->urlError        = '<strong>%s</strong> is expected to be a URL of upgrade ZIP file.';

$lang->client->noData                 = 'No Data';
$lang->client->saveClientError        = 'Cannot save update info data.';
$lang->client->downloadErrorTip       = 'Some packages download failed, please upload it to the corresponding directory of www/data/client.';
$lang->client->downloadFailedTip      = 'Download packages failed. Please try again later or download them by other way and upload them to the corresponding directory of www/data/client.';
$lang->client->alreadyLastestVersion  = 'The current version is up to date';
$lang->client->cannotUseUpdateServer  = 'Unable to get official version information';
$lang->client->foundNewVersion        = 'Found new client version';
$lang->client->currentVersion         = 'Current version';
$lang->client->upgradeToThisVersion   = 'Upgrade to this version';
$lang->client->downloadClientPackages = 'Select the installation package for the upgrade';
$lang->client->publishUpdate          = 'Publish this upgrade';
$lang->client->saveUpdate             = 'Save this upgrade';
$lang->client->selectUpgradeStrategy  = 'Upgrade Strategy';
$lang->client->or                     = 'OR';
$lang->client->inCatalog              = 'Under the catalog';
$lang->client->fileNameIs             = 'File name is';
$lang->client->fileSize               = 'File Size';
$lang->client->goUpdate               = 'Update';
$lang->client->countUsers             = 'Online';
$lang->client->setServer              = 'Set';
$lang->client->totalUsers             = 'Users';
$lang->client->totalGroups            = 'Groups';
$lang->client->totalMessages          = 'Messages';
$lang->client->xxdStartDate           = 'XXD Last Start Time';
$lang->client->xxcNotice              = 'Xuan Xuan New Version';

$lang->client->strategies['force']    = 'Force';
$lang->client->strategies['optional'] = 'Optional';

$lang->client->status['wait']     = 'Not release';
$lang->client->status['released'] = 'Released';

$lang->client->zipList['win64zip']   = 'Windows 64';
$lang->client->zipList['win32zip']   = 'Windows 32';
$lang->client->zipList['macOSzip']   = 'macOS';
$lang->client->zipList['linux64zip'] = 'Linux 64';
$lang->client->zipList['linux32zip'] = 'Linux 32';

$lang->client->message = array();
$lang->client->message['total'] = 'Total';
$lang->client->message['hour']  = 'An Hour';
$lang->client->message['day']   = 'An Day';

$lang->client->sizeType = array();
$lang->client->sizeType['K'] = 1024;
$lang->client->sizeType['M'] = 1024 * 1024;
$lang->client->sizeType['G'] = 1024 * 1024 * 1024;

$lang->client->xxdStatusList = array();
$lang->client->xxdStatusList['online']  = 'Online';
$lang->client->xxdStatusList['offline'] = 'Offline';

$lang->client->downloadClient = 'Download Client';
$lang->client->os             = 'Select OS';
$lang->client->downloading    = 'Downloading base package';
$lang->client->downloaded     = 'Base package downloaded!';
$lang->client->setting        = 'Writing client configuration...';
$lang->client->setted         = 'Done!';

$lang->client->generate = 'Generate Links';
$lang->client->copy     = 'Copy Links';
$lang->client->links    = 'Download links';
$lang->client->getDownloadLinks = 'Get client download links';
$lang->client->serverMightHang  = 'Server might hang during fetching and packing client zips, please wait patiently.';

$lang->client->osList['win64']   = 'Windows 64';
$lang->client->osList['win32']   = 'Windows 32';
$lang->client->osList['linux64'] = 'Linux 64';
$lang->client->osList['linux32'] = 'Linux 32';
$lang->client->osList['mac']     = 'macOS';

$lang->client->errorInfo = new stdclass();
$lang->client->errorInfo->downloadError  = 'Failed to download base package!';
$lang->client->errorInfo->configError    = 'Failed to write configuration!';
$lang->client->errorInfo->manualOpt      = 'Please <a href="%s" target="_blank" rel="noreferrer noopener">download the base client package manually</a>.';
$lang->client->errorInfo->dirNotExist    = 'The directory <span class="code text-red">%s</span> does not exist. Please create it.';
$lang->client->errorInfo->dirNotWritable = 'The directory <span class="code text-red">%s</span> is not writable. <br /> Please execute:<span class="code text-red">sudo chmod 777 %s</span> in Linux.';

$lang->client->userDownloadTips = 'Click the button below to download Xuan client packed with the server address and your account information.';
$lang->client->generateLinkTips = 'Click generate link button to generate links of Xuan client zips (for internal usages or faster downloads).';

$lang->client->releaseTip = "Users will receive version update alerts in the client after the release.";
