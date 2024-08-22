<?php
$lang->admin->menuList->feature['subMenu']['demand']  = array('link' => "Demandpool|custom|required|module=demand", 'exclude' => 'set,required');
$lang->admin->menuList->feature['subMenu']['market']  = array('link' => "Market|custom|set|module=market", 'exclude' => 'set,required');
$lang->admin->menuList->feature['subMenu']['charter'] = array('link' => "Charter|custom|set|module=charter", 'exclude' => 'set,required');

$lang->admin->menuList->feature['tabMenu']['demand']['demand']   = array('link' => "Demand|custom|required|module=demand&field=priList", 'exclude' => 'custom-set');
$lang->admin->menuList->feature['tabMenu']['charter']['charter'] = array('link' => "Charter|custom|set|module=charter&field=charterList", 'exclude' => 'custom-required');

//$lang->admin->menuList->feature['tabMenu']['market']['marketreport']   = array('link' => "{$lang->marketreport->common}|custom|set|module=marketreport", 'exclude' => 'custom-set');
//$lang->admin->menuList->feature['tabMenu']['market']['marketresearch'] = array('link' => "{$lang->marketresearch->common}|custom|set|module=marketresearch", 'exclude' => 'custom-set');
$lang->admin->menuList->feature['tabMenu']['market']['market']         = array('link' => "{$lang->market->common}|custom|set|module=market&field=strategyList", 'exclude' => 'custom-set');

$lang->admin->menuList->feature['menuOrder']['6']  = 'demand';
$lang->admin->menuList->feature['menuOrder']['8']  = 'market';
$lang->admin->menuList->feature['menuOrder']['11'] = 'charter';

unset($lang->admin->menuList->switch);
unset($lang->admin->menuList->model);
unset($lang->admin->menuList->dev);
unset($lang->admin->menuList->convert);
unset($lang->admin->menuList->platform);
unset($lang->admin->menuList->system['subMenu']['mode']);
unset($lang->admin->menuList->system['subMenu']['cron']);
unset($lang->admin->menuList->system['subMenu']['ldap']);
unset($lang->admin->menuList->system['subMenu']['libreoffice']);
unset($lang->admin->menuList->system['subMenu']['xuanxuan']);

unset($lang->admin->menuList->feature['tabMenu']['product']['productplan']);
unset($lang->admin->menuList->feature['tabMenu']['product']['release']);
unset($lang->admin->menuList->feature['tabMenu']['menuOrder']['product']['15']);
unset($lang->admin->menuList->feature['tabMenu']['menuOrder']['product']['20']);

unset($lang->admin->menuList->feature['subMenu']['execution']);
unset($lang->admin->menuList->feature['subMenu']['qa']);
unset($lang->admin->menuList->feature['subMenu']['kanban']);
unset($lang->admin->menuList->feature['subMenu']['doc']);
unset($lang->admin->menuList->feature['subMenu']['feedback']);
unset($lang->admin->menuList->feature['subMenu']['measure']);
unset($lang->admin->menuList->feature['subMenu']['meetingroom']);
unset($lang->admin->menuList->feature['subMenu']['approval']);

unset($lang->admin->menuList->system['menuOrder']['5']);
unset($lang->admin->menuList->system['menuOrder']['20']);
unset($lang->admin->menuList->system['menuOrder']['35']);
unset($lang->admin->menuList->system['menuOrder']['55']);
unset($lang->admin->menuList->system['menuOrder']['60']);

unset($lang->admin->menuList->feature['menuOrder']['15']);
unset($lang->admin->menuList->feature['menuOrder']['20']);
unset($lang->admin->menuList->feature['menuOrder']['25']);
unset($lang->admin->menuList->feature['menuOrder']['30']);
unset($lang->admin->menuList->feature['menuOrder']['35']);
unset($lang->admin->menuList->feature['menuOrder']['40']);
unset($lang->admin->menuList->feature['menuOrder']['45']);
unset($lang->admin->menuList->feature['menuOrder']['55']);
