<?php
/**
 * The dept module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禪道軟件（青島）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dept
 * @version     $Id: zh-tw.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
$lang->dept->id           = '編號';
$lang->dept->path         = '路徑';
$lang->dept->position     = '職位';
$lang->dept->manageChild  = "下級部門";
$lang->dept->edit         = "編輯部門";
$lang->dept->delete       = "刪除部門";
$lang->dept->parent       = "上級部門";
$lang->dept->manager      = "負責人";
$lang->dept->name         = "部門名稱";
$lang->dept->browse       = "部門維護";
$lang->dept->manage       = "維護部門";
$lang->dept->updateOrder  = "部門排序";
$lang->dept->add          = "添加部門";
$lang->dept->grade        = "部門級別";
$lang->dept->order        = "排序";
$lang->dept->dragAndSort  = "拖動排序";
$lang->dept->noDepartment = "無部門";

$lang->dept->manageChildAction = "維護下級部門";

$lang->dept->confirmDelete = " 您確定刪除該部門嗎？";
$lang->dept->successSave   = " 修改成功。";
$lang->dept->repeatDepart  = " 存在部門名稱重複，您確認添加嗎？";

$lang->dept->error = new stdclass();
$lang->dept->error->hasSons  = '該部門有子部門，不能刪除！';
$lang->dept->error->hasUsers = '該部門有職員，不能刪除！';
