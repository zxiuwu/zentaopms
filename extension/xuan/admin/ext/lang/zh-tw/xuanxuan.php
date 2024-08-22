<?php
$lang->admin->xuanxuan        = '聊天狀態';
$lang->admin->blockStatus     = '狀態監控';
$lang->admin->blockStatistics = '系統統計';
$lang->admin->xuanxuanSetting = '參數設置';

$lang->admin->fileSize      = '附件大小';
$lang->admin->countUsers    = '當前在綫用戶數';
$lang->admin->setServer     = '伺服器設置';
$lang->admin->totalUsers    = '總用戶數';
$lang->admin->totalGroups   = '討論組數';
$lang->admin->totalMessages = '消息數量';
$lang->admin->xxdStartDate  = 'XXD上次啟動時間';

$lang->admin->message = array();
$lang->admin->message['total'] = '總消息數';
$lang->admin->message['hour']  = '最近一小時消息數';
$lang->admin->message['day']   = '最近一天消息數';

$lang->admin->sizeType = array();
$lang->admin->sizeType['K'] = 1024;
$lang->admin->sizeType['M'] = 1024 * 1024;
$lang->admin->sizeType['G'] = 1024 * 1024 * 1024;

global $config;
if($config->vision != 'lite')
{
    $lang->admin->menuList->system['subMenu']['xuanxuan'] = array('link' => '聊天|admin|xuanxuan|', 'subModule' => 'client,setting,conference');
    $lang->admin->menuList->system['menuOrder']['20'] = 'xuanxuan';

    $lang->admin->menuList->system['tabMenu']['xuanxuan']['index']   = array('link' => '首頁|admin|xuanxuan|');
    $lang->admin->menuList->system['tabMenu']['xuanxuan']['setting'] = array('link' => '參數|setting|xuanxuan|');
    if($config->edition != 'open')
    {
        $lang->admin->menuList->system['tabMenu']['xuanxuan']['conference'] = array('link' => '音視頻|conference|admin|');
        $lang->navGroup->conference = 'admin';
    }
    $lang->admin->menuList->system['tabMenu']['xuanxuan']['update'] = array('link' => '更新|client|browse|', 'subModule' => 'client');
}
