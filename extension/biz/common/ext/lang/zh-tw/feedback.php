<?php
$lang->navIcons['feedback'] = "<i class='icon icon-feedback'></i>";

$lang->feedback     = new stdclass();
$lang->feedbackpriv = new stdclass();

$lang->feedback->common     = '反饋';
$lang->feedbackpriv->common = '反饋權限';

$lang->mainNav->feedback      = "{$lang->navIcons['feedback']} {$lang->feedback->common}|feedback|admin|browseType=wait";
$lang->navGroup->feedback     = 'feedback';
$lang->navGroup->faq          = 'feedback';
$lang->navGroup->ticket       = 'feedback';
$lang->navGroup->feedbackpriv = 'feedback';

$lang->searchLang = '搜索';

$lang->feedback->menu = new stdclass();
$lang->feedback->menu->browse   = array('link' => '反饋|feedback|admin|browseType=wait', 'alias' => 'create,edit,view,adminview,batchedit,browse,showimport,batchclose');
$lang->feedback->menu->ticket   = array('link' => '工單|ticket|browse', 'alias' => 'create,edit,view,batchedit,browse,showimport,createstory,createbug');
$lang->feedback->menu->faq      = array('link' => 'FAQ|faq|browse', 'alias' => 'create,edit');
$lang->feedback->menu->products = array('link' => '設置|feedback|products', 'alias' => 'manageproduct');

$lang->feedback->menuOrder[5]  = 'browse';
$lang->feedback->menuOrder[10] = 'ticket';
$lang->feedback->menuOrder[15] = 'faq';
$lang->feedback->menuOrder[20] = 'products';

$lang->ticket = new stdclass();
$lang->ticket->common = '工單';
$lang->ticket->navGroup['ticket'] = 'feedback';

$lang->faq = new stdclass();
$lang->faq->navGroup['faq'] = 'feedback';

$lang->my->menu->work['subMenu']->feedback = array('link' => "{$lang->feedback->common}|my|work|mode=feedback&type=assigntome", 'subModule' => 'feedback');
$lang->my->menu->work['subMenu']->ticket   = array('link' => "{$lang->ticket->common}|my|work|mode=ticket&type=assignedtome", 'subModule' => 'feedback');
$lang->my->menu->work['menuOrder'][80] = 'feedback';

$lang->feedbackView[0] = '研發界面';
$lang->feedbackView[1] = '非研發界面';

$lang->switchFeedbackView[1] = '切換研發界面';
$lang->switchFeedbackView[0] = '切換非研發界面';

global $config;
if($config->vision == 'lite')
{
    $lang->feedback->menu->browse = array('link' => '反饋|feedback|browse|browseType=unclosed', 'alias' => 'create,edit,view,adminview,batchedit,browse,admin');

    unset($lang->feedback->menu->products);
    unset($lang->feedback->menuOrder[15]);
}

$lang->noMenuModule[] = 'faq';
$lang->noMenuModule[] = 'feedback';
$lang->noMenuModule[] = 'deploy';
$lang->noMenuModule[] = 'host';
$lang->noMenuModule[] = 'serverroom';
$lang->noMenuModule[] = 'service';
$lang->noMenuModule[] = 'ops';
