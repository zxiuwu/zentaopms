<?php
/**
 * The stage module English file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     stage
 * @version     $Id: en.php 4729 2013-05-03 07:53:55Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
/* Actions. */
$lang->stage->browse      = 'Waterfall Stage List';
$lang->stage->create      = 'Create Stage';
$lang->stage->batchCreate = 'Batch Create';
$lang->stage->edit        = 'Edit';
$lang->stage->delete      = 'Delete';
$lang->stage->view        = 'Details';
$lang->stage->plusBrowse  = 'Waterfall Plus Stage List';

/* Fields. */
$lang->stage->id      = 'ID';
$lang->stage->name    = 'Name';
$lang->stage->type    = 'Type';
$lang->stage->percent = 'Workload %';
$lang->stage->setType = 'Set Type';

$lang->stage->typeList['mix']     = 'Mix';
$lang->stage->typeList['request'] = 'Story';
$lang->stage->typeList['design']  = 'Design';
$lang->stage->typeList['dev']     = 'Development';
$lang->stage->typeList['qa']      = 'Test';
$lang->stage->typeList['release'] = 'Release';
$lang->stage->typeList['review']  = 'Review';
$lang->stage->typeList['other']   = 'Other';

$lang->stage->ipdTypeList['concept']   = 'Concept';
$lang->stage->ipdTypeList['plan']      = 'Plan';
$lang->stage->ipdTypeList['develop']   = 'Develop';
$lang->stage->ipdTypeList['qualify']   = 'Qualify';
$lang->stage->ipdTypeList['launch']    = 'Launch';
$lang->stage->ipdTypeList['lifecycle'] = 'Lifecycel';

$lang->stage->viewList      = 'Stage List';
$lang->stage->noStage       = 'No stage yet';
$lang->stage->confirmDelete = 'Do you want to delete it?';

$lang->stage->error              = new stdclass();
$lang->stage->error->percentOver = 'The sum of "Workload %" cannot exceed 100%.';
$lang->stage->error->notNum      = 'The workload ratio should be numerical';
