<?php
/**
 * The suspend file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang<wwccss@gmail.com>
 * @package     execution
 * @version     $Id: suspend.html.php 935 2013-01-16 07:49:24Z wwccss@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php js::import($jsRoot . 'misc/date.js');?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2>
      <span class='prefix label-id'><strong><?php echo $execution->id;?></strong></span>
      <?php echo isonlybody() ? ("<span title='$execution->name'>" . $execution->name . '</span>') : html::a($this->createLink('execution', 'view', 'execution=' . $execution->id), $execution->name, '_blank');?>
      <?php if(!isonlybody()):?>
      <small><?php echo $lang->arrow . $lang->execution->activate;?></small>
      <?php endif;?>
    </h2>
  </div>
  <form class='load-indicator main-form' method='post' target='hiddenwin'>
    <table class='table table-form'>
      <tr style='height:50px;'>
        <th class='w-70px'><?php echo $lang->execution->beginAndEnd;?></th>
        <td class='muted' colspan='2'>
          <div id='sourceTimeBox'><?php echo $execution->begin . ' ~ ' . $execution->end;?></div>
          <div id='readjustTimeBox' class='hide'>
            <div class='input-group'>
              <?php echo html::input('begin', $newBegin, "class='form-control form-date'")?>
              <span class='input-group-addon'> ~ </span>
              <?php echo html::input('end', $newEnd, "class='form-control form-date'");?>
            </div>
          </div>
        </td>
        <td colspan='3'>
          <div class='clearfix row'>
            <div class='col-md-6 pull-left'>
              <div class="checkbox-primary"><input name="readjustTime" value="1" id="readjustTime" type="checkbox"><label for="readjustTime" class="no-margin"><?php echo $lang->execution->readjustTime;?></label></div>
            </div>
            <div class='col-md-6 pull-left'>
              <div id='readjustTaskBox' class='checkbox-primary hidden'><input name="readjustTask" value="1" id="readjustTask" type="checkbox"> <label for='readjustTask' class='no-margin'><?php echo $lang->execution->readjustTask?></label></div>
            </div>
          </div>
        </td>
      </tr>
      <tr class='hide'>
        <th><?php echo $lang->execution->status;?></th>
        <td><?php echo html::hidden('status', 'doing');?></td>
      </tr>
      <?php $this->printExtendFields($execution, 'table', 'columns=5');?>
      <tr>
        <th><?php echo $lang->comment;?></th>
        <td colspan='5'><?php echo html::textarea('comment', '', "rows='6' class='form-control kindeditor' hidefocus='true'");?></td>
      </tr>
      <tr>
        <td class='text-center form-actions' colspan='6'><?php echo html::submitButton($lang->execution->activate . $lang->executionCommon) . html::linkButton($lang->goback, $this->session->taskList, 'self', '', 'btn btn-wide'); ?></td>
      </tr>
    </table>
  </form>
  <hr class='small' />
  <div class='main'><?php include '../../common/view/action.html.php';?></div>
</div>
<script>
$(function()
{
    $('#readjustTime').change(function()
    {
        $('#sourceTimeBox').toggle(!$(this).prop('checked'))
        $('#readjustTimeBox').toggle($(this).prop('checked'))
        $('#readjustTaskBox').toggleClass('hidden')
    })
})
</script>
<?php include '../../common/view/footer.html.php';?>
