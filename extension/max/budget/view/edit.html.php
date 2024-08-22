<?php
/**
 * The edit view of budget module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     budget
 * @version     $Id: edit.html.php 4903 2013-06-26 05:32:59Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div id="mainContent" class="main-content fade">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->budget->edit . $lang->budget->common;?></h2>
    </div>
    <form class="main-form form-ajax" method='post' enctype='multipart/form-data'>
      <table class="table table-form">
        <tbody>
          <tr>
            <th class='w-120px'><?php echo $lang->budget->stage;?> </th>
            <td><?php echo html::select('stage', $plans, $budget->stage, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->budget->subject;?> </th>
            <td><?php echo html::select('subject', $subjects, $budget->subject, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->budget->amount;?> </th>
            <td>
              <div class='input-group'>
              <?php echo html::input('amount', $budget->amount, 'class="form-control"');?>
              <span class='input-group-addon'><?php echo $lang->budget->{$project->budgetUnit};?></span>
              </div>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->budget->name;?> </th>
            <td colspan='3'><?php echo html::input('name', $budget->name, 'class="form-control"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->budget->desc;?> </th>
            <td colspan='3'><?php echo html::textarea('desc', $budget->desc, 'class="form-control"');?></td>
          </tr>
          <tr>
            <td colspan='4' class='text-center form-actions'><?php echo html::submitButton() . html::backButton();?></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
