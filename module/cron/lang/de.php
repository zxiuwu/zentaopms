<?php
$lang->cron->common       = 'Geplante Tasks';
$lang->cron->id           = 'ID';
$lang->cron->buildin      = 'Build In';
$lang->cron->index        = 'Geplante Tasks List';
$lang->cron->list         = 'Tasks';
$lang->cron->create       = 'Hinzufügen';
$lang->cron->createAction = 'Add Cron';
$lang->cron->edit         = 'Bearbeiten';
$lang->cron->delete       = 'Löschen';
$lang->cron->toggle       = 'Aktivieren/Deaktivieren';
$lang->cron->turnon       = 'Ein/Aus';
$lang->cron->openProcess  = 'Neustart';
$lang->cron->restart      = 'Neustart Tasks';

$lang->cron->m        = 'Minute';
$lang->cron->h        = 'Stunde';
$lang->cron->dom      = 'Tag';
$lang->cron->mon      = 'Monat';
$lang->cron->dow      = 'Woche';
$lang->cron->command  = 'Befehl';
$lang->cron->status   = 'Status';
$lang->cron->type     = 'Typ';
$lang->cron->remark   = 'Bemerkung';
$lang->cron->lastTime = 'Letze Ausführung';

$lang->cron->turnonList['1'] = 'On';
$lang->cron->turnonList['0'] = 'Shutdown';

$lang->cron->statusList['normal']  = 'Geplant';
$lang->cron->statusList['running'] = 'Läuft';
$lang->cron->statusList['stop']    = 'Gestoppt';

$lang->cron->typeList['zentao'] = 'Selbstaufruf';
global $config;
if($config->features->cronSystemCall) $lang->cron->typeList['system'] = 'System Kommando';

$lang->cron->toggleList['start'] = 'Aktivieren';
$lang->cron->toggleList['stop']  = 'Deaktivieren';

$lang->cron->confirmDelete = 'Möchten Sie den geplanten Task löschen?';
$lang->cron->confirmTurnon = 'Möchten Sie die geplanten Tasks abschalten?';
$lang->cron->introduction  = <<<EOD
<p>Cron is set to do scheduled actions, such as update burndown chart, backup, etc.</p>
<p>Features of Cron need to be improved, so it is turned off by default.</p>
EOD;
$lang->cron->confirmOpen = <<<EOD
<p>Do you want to turn it on?<a href="%s" target='hiddenwin'><strong>Turn On Cron<strong></a></p>
EOD;

$lang->cron->notice = new stdclass();
$lang->cron->notice->m    = 'Bereich:0-59，"*" means the numbers within the range, "/" means "per", "-" means ranger.';
$lang->cron->notice->h    = 'Bereich:0-23';
$lang->cron->notice->dom  = 'Bereich:1-31';
$lang->cron->notice->mon  = 'Bereich:1-12';
$lang->cron->notice->dow  = 'Bereich:0-6';
$lang->cron->notice->help = 'Hinweis：nach einem Server Neustart oder wenn die geplanten Tasks nicht funktionieren, bedeutet das, dass die Aufgaben nicht ausgeführt werden. Sie können die Aufgaben neustarten indem Sie 【Neustart】 klicken oder diese Seite neu laden. Wenn sich die Zeit der letzen Ausführung ändert, beduetet das, dass die geplanten Tasks funktionieren.';
$lang->cron->notice->errorRule = '"%s" ist nicht gültig';
