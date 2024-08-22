<?php
$config->message->objectTypes = array();
$config->message->objectTypes['product']     = array('opened', 'edited', 'closed', 'undeleted');
$config->message->objectTypes['story']       = array('opened', 'edited', 'commented', 'frombug', 'changed', 'reviewed', 'closed', 'activated', 'assigned');
$config->message->objectTypes['productplan'] = array('opened', 'edited');
$config->message->objectTypes['project']     = array('opened', 'edited', 'started', 'delayed', 'suspended', 'closed', 'activated', 'undeleted');
$config->message->objectTypes['task']        = array('opened', 'edited', 'commented', 'assigned', 'confirmed', 'started', 'finished', 'paused', 'canceled', 'restarted', 'closed', 'activated');
$config->message->objectTypes['bug']         = array('opened', 'edited', 'commented', 'assigned', 'confirmed', 'bugconfirmed', 'resolved', 'closed', 'activated');
$config->message->objectTypes['case']        = array('opened', 'edited', 'commented', 'reviewed', 'confirmed');
$config->message->objectTypes['testtask']    = array('opened', 'edited', 'started', 'blocked', 'closed', 'activated');
$config->message->objectTypes['todo']        = array('opened', 'edited');
$config->message->objectTypes['doc']         = array('created', 'edited');
$config->message->objectTypes['kanbancard']  = array('created', 'edited', 'finished', 'activated', 'archived', 'restore', 'deleted', 'moved');

$config->message->available = array();
$config->message->available['mail']['story']      = $config->message->objectTypes['story'];
$config->message->available['mail']['task']       = $config->message->objectTypes['task'];
$config->message->available['mail']['bug']        = $config->message->objectTypes['bug'];
$config->message->available['mail']['testtask']   = array('opened', 'edited', 'closed');
$config->message->available['mail']['doc']        = $config->message->objectTypes['doc'];
$config->message->available['mail']['kanbancard'] = $config->message->objectTypes['kanbancard'];

$config->message->available['webhook']  = $config->message->objectTypes;

$config->message->available['message']['bug']        = $config->message->objectTypes['bug'];
$config->message->available['message']['story']      = $config->message->objectTypes['story'];
$config->message->available['message']['task']       = $config->message->objectTypes['task'];
$config->message->available['message']['testtask']   = $config->message->objectTypes['testtask'];
$config->message->available['message']['todo']       = $config->message->objectTypes['todo'];
$config->message->available['message']['doc']        = $config->message->objectTypes['doc'];
$config->message->available['message']['kanbancard'] = $config->message->objectTypes['kanbancard'];

$config->message->typeLink = array();
$config->message->typeLink['mail']    = 'mail|index';
$config->message->typeLink['webhook'] = 'webhook|browse';

$config->message->setting = array();
$config->message->setting['message']['setting']  = $config->message->available['message'];
$config->message->setting['webhook']['setting']  = $config->message->available['webhook'];
$config->message->setting['mail']['setting']     = $config->message->available['mail'];

$config->message->browser = new stdclass();
$config->message->browser->turnon   = 1;
$config->message->browser->pollTime = 300;
