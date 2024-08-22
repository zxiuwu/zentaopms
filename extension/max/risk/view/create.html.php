<?php
/**
 * The create of risk module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuchun Li <liyuchun@cnezsoft.com>
 * @package     risk
 * @version     $Id: create.html.php 4903 2020-09-04 09:32:59Z lyc $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div id="mainContent" class="main-content fade">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->risk->create;?></h2>
    </div>
    <form class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data' id='dataform'>
      <table class="table table-form">
        <tbody>
          <tr>
            <th><?php echo $lang->risk->source;?></th>
            <td><?php echo html::select('source', $lang->risk->sourceList, '', "class='form-control chosen'");?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->name;?></th>
            <td><?php echo html::input('name', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->issues;?></th>
            <td class='issueBox'><?php echo html::select('issues[]', $issues, '', "class='form-control chosen' multiple");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->execution;?></th>
            <td><?php echo html::select('execution', $executions, isset($executionID) ? $executionID : '', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->category;?></th>
            <td><?php echo html::select('category', $lang->risk->categoryList, '', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->strategy;?></th>
            <td><?php echo html::select('strategy', $lang->risk->strategyList, '', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->impact;?></th>
            <td><?php echo html::select('impact', $lang->risk->impactList, 3, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->probability;?></th>
            <td><?php echo html::select('probability', $lang->risk->probabilityList, 3, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->rate;?></th>
            <td><?php echo html::input('rate', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->pri;?></th>
            <td id='priValue'><?php echo html::select('pri', $lang->risk->priList, '', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->identifiedDate;?></th>
            <td><?php echo html::input('identifiedDate', '', "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->plannedClosedDate;?></th>
            <td><?php echo html::input('plannedClosedDate', '', "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $users, '', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->prevention;?></th>
            <td colspan='3'><?php echo html::textarea('prevention', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->risk->remedy;?></th>
            <td colspan='3'><?php echo html::textarea('remedy', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <td colspan='4' class='form-actions text-center'>
              <?php echo html::submitButton() . html::backButton($lang->goback, "data-app='{$app->tab}'");?>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php js::set('projectID', $projectID);?>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
