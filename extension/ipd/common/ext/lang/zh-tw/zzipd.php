<?php
$lang->ipdName = 'IPD版';

$lang->ipd       = new stdclass();
$lang->ipd->menu = new stdclass();
$lang->ipd->menu = clone $lang->waterfall->menu;

$lang->ipd->menuOrder   = $lang->waterfall->menuOrder;
$lang->ipd->dividerMenu = $lang->waterfall->dividerMenu;
$lang->ipd->menu->settings['subModule'] = 'stakeholder,tree';

$lang->product->menu->roadmap   = array('link' => "{$lang->roadmap}|product|roadmap|productID=%s", 'exclude' => 'roadmap-browse,roadmap-view');
$lang->product->menu->orroadmap = array('link' => "路標|roadmap|browse|productID=%s", 'subModule' => 'roadmap');

$lang->product->menuOrder[5]  = 'dashboard';
$lang->product->menuOrder[10] = 'requirement';
$lang->product->menuOrder[15] = 'orroadmap';
$lang->product->menuOrder[20] = 'story';
$lang->product->menuOrder[25] = 'plan';
$lang->product->menuOrder[30] = 'track';
$lang->product->menuOrder[35] = 'project';
$lang->product->menuOrder[40] = 'release';
$lang->product->menuOrder[45] = 'roadmap';
$lang->product->menuOrder[50] = 'doc';
$lang->product->menuOrder[55] = 'dynamic';
$lang->product->menuOrder[60] = 'settings';
$lang->product->menuOrder[65] = 'create';

$lang->product->dividerMenu = $config->URAndSR ? ',story,requirement,doc,settings,' : ',story,track,settings,';

unset($lang->ipd->menu->cm);
unset($lang->ipd->menu->other['dropMenu']->pssp);
unset($lang->ipd->menu->other['dropMenu']->auditplan);
