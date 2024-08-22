<?php
/**
 * The create view of issue module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     issue
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div class="main-content" id="mainContent" <?php if(isonlybody()) echo 'style="margin-top: 40px;"';?>>
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->issue->create;?></h2>
    </div>
    <form method="post" class="main-form form-ajax" enctype="multipart/form-data" id="issueForm">
      <table class="table table-form">
        <tbody>
          <tr>
            <th><?php echo $lang->issue->type;?></th>
            <td class="required"><?php echo html::select('type', $lang->issue->typeList, '', 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->title;?></th>
            <td class="required"><?php echo html::input('title', '', 'class="form-control"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->risk;?></th>
            <td class="riskBox"><?php echo html::select('risk', $risks, '', 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->severity;?></th>
            <td class="required"><?php echo html::select('severity', $lang->issue->severityList, '', 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->execution;?></th>
            <td><?php echo html::select('execution', $executions, isset($executionID) ? $executionID : '', "class='form-control chosen'");?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->pri;?></th>
            <td><?php echo html::select('pri', $lang->issue->priList, '3', 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $teamMembers, '', 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->owner;?></th>
            <td><?php echo html::select('owner', $teamMembers, $app->user->account, 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->deadline;?></th>
            <td><?php echo html::input('deadline', '', 'class="form-control form-date"');?></td>
            <td></td>
            <td></td>
          </tr>
          <?php if($from == 'stakeholder'):?>
          <tr>
            <th><?php echo $lang->issue->owner;?></th>
            <td><?php echo html::select('owner', $owners, $owner, 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <?php endif;?>
          <tr>
            <th><?php echo $lang->issue->desc;?></th>
            <td colspan="3"><?php echo html::textarea('desc', '', 'row="6"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->files;?></th>
            <td><?php echo $this->fetch('file', 'buildform');?></td>
          </tr>
          <tr>
            <td colspan='4' class='text-center form-actions'><?php echo html::submitButton() . html::backButton($lang->goback, "data-app='{$app->tab}'");?></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php js::set('projectID', $projectID)?>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
