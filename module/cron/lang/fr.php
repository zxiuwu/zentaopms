<?php
$lang->cron->common       = 'Cron';
$lang->cron->id           = 'ID';
$lang->cron->buildin      = 'Build In';
$lang->cron->index        = 'Accueil Cron List';
$lang->cron->list         = 'Tâches';
$lang->cron->create       = 'Ajouter';
$lang->cron->createAction = 'Ajouter Cron';
$lang->cron->edit         = 'Editer Cron';
$lang->cron->delete       = 'Supprimer Cron';
$lang->cron->toggle       = 'Activer/Désactiver';
$lang->cron->turnon       = 'On/Off';
$lang->cron->openProcess  = 'Redémarrer';
$lang->cron->restart      = 'Redémarrer Cron';

$lang->cron->m        = 'Minute';
$lang->cron->h        = 'Heure';
$lang->cron->dom      = 'Jour';
$lang->cron->mon      = 'Mois';
$lang->cron->dow      = 'Semaine';
$lang->cron->command  = 'Commande';
$lang->cron->status   = 'Statut';
$lang->cron->type     = 'Type';
$lang->cron->remark   = 'Commentaire';
$lang->cron->lastTime = 'Dernier Run';

$lang->cron->turnonList['1'] = 'On';
$lang->cron->turnonList['0'] = 'Off';

$lang->cron->statusList['normal']  = 'Normal';
$lang->cron->statusList['running'] = 'Running';
$lang->cron->statusList['stop']    = 'Stop';

$lang->cron->typeList['zentao'] = 'Self Call';
global $config;
if($config->features->cronSystemCall) $lang->cron->typeList['system'] = 'Command Système';

$lang->cron->toggleList['start'] = 'Activer';
$lang->cron->toggleList['stop']  = 'Désactiver';

$lang->cron->confirmDelete = 'Voulez-vous supprimer ce cron ?';
$lang->cron->confirmTurnon = 'Voulez-vous arrêter le cron ?';
$lang->cron->introduction  = <<<EOD
<p>Cron is set to do scheduled actions, such as update burndown chart, backup, etc.</p>
<p>Features of Cron need to be improved, so it is turned off by default.</p>
EOD;
$lang->cron->confirmOpen = <<<EOD
<p>Do you want to turn it on?<a href="%s" target='hiddenwin'><strong>Turn On Cron<strong></a></p>
EOD;

$lang->cron->notice = new stdclass();
$lang->cron->notice->m    = 'Range:0-59，"*" signifie les nombres dans la plage, "/" signifie "par", "-" indique la plage.';
$lang->cron->notice->h    = 'Range:0-23';
$lang->cron->notice->dom  = 'Range:1-31';
$lang->cron->notice->mon  = 'Range:1-12';
$lang->cron->notice->dow  = 'Range:0-6';
$lang->cron->notice->help = "Note ： Si le serveur est redémarré ou que le Cron ne fonctionne pas, cela signifie que le Cron s'est arrêté. Vous pouvez le redémarrer en cliquant sur 【Restart】 ou en rafraichissant cette page. Si la dernière heure d'exécution est modifiée, cela signifie que le Cron est en cours d'exécution.";
$lang->cron->notice->errorRule = '"%s" invalide';
