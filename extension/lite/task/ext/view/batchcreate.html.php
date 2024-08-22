<?php
/**
 * The batch create view of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $this->app->getModuleRoot() . '/common/view/header.html.php';?>
<?php include $this->app->getModuleRoot() . '/common/view/datepicker.html.php';?>
<?php js::set('taskConsumed', $taskConsumed);?>
<?php js::set('addChildTask', $lang->task->addChildTask);?>
<?php js::set('isonlybody', isonlybody())?>
<?php js::set('regionID', $regionID);?>
<?php js::set('requiredFields', $config->task->create->requiredFields);?>
<style>.c-lane,.c-region{width:150px;}</style>
<div id="mainContent" class="main-content fade">
  <div class="main-header clearfix">
    <h2 class="pull-left">
      <?php if($parent):?>
      <span class='pull-left'><?php echo $parentTitle . $this->lang->colon;?></span>
      <?php echo $lang->task->batchCreateChildren;?>
      <?php else:?>
      <?php echo $lang->task->batchCreate;?>
      <?php endif;?>
    </h2>
    <?php if($execution->type != 'ops'):?>
    <a class="checkbox-primary pull-left" id='zeroTaskStory' href='javascript:toggleZeroTaskStory();'>
      <label><?php echo $lang->story->zeroTask;?></label>
    </a>
    <?php endif;?>
    <div class="pull-right btn-toolbar">
      <button type='button' data-toggle='modal' data-target="#importLinesModal" class="btn btn-primary"><?php echo $lang->pasteText;?></button>
      <?php $customLink = $this->createLink('custom', 'ajaxSaveCustomFields', 'module=task&section=custom&key=batchCreateFields')?>
      <?php include $this->app->getModuleRoot() . '/common/view/customfield.html.php';?>
      <div class="divider"></div>
    </div>
  </div>
  <?php
  $visibleFields  = array();
  $requiredFields = array();
  foreach(explode(',', $showFields) as $field)
  {
      if($field)$visibleFields[$field] = '';
  }
  foreach(explode(',', $config->task->create->requiredFields) as $field)
  {
      if($field) $requiredFields[$field] = '';
  }
  $colspan = count($visibleFields) + 3;
  ?>
  <form method='post' class='batch-actions-form' target='hiddenwin' enctype='multipart/form-data' id="batchCreateForm">
    <div class="table-responsive">
      <table class="table table-form" id="tableBody">
        <thead>
          <tr>
            <th class='c-id'><?php echo $lang->idAB;?></th>
            <th class='c-module<?php echo zget($visibleFields, 'module', ' hidden') . zget($requiredFields, 'module', '', ' required');?> moduleBox'><?php echo $lang->task->module?></th>
            <?php if($execution->type != 'ops'):?>
            <th class='c-story<?php echo zget($visibleFields, 'story', ' hidden') . zget($requiredFields, 'story', '', ' required');?> storyBox'><?php echo $lang->task->story;?></th>
            <?php endif;?>
            <th class='c-name required has-btn'><?php echo $lang->task->name;?></span></th>
            <th class='c-region required<?php echo zget($visibleFields, 'region', ' hidden');?> regionBox'><?php echo $lang->task->region;?></th>
            <th class='c-lane required<?php echo zget($visibleFields, 'lane', ' hidden');?> laneBox'><?php echo $lang->task->lane;?></th>
            <th class='c-type required'><?php echo $lang->typeAB;?></span></th>
            <th class='c-assigned<?php echo zget($visibleFields, 'assignedTo', ' hidden') . zget($requiredFields, 'assignedTo', '', ' required');?>'><?php echo $lang->task->assignedTo;?></th>
            <th class='c-estimate<?php  echo zget($visibleFields, 'estimate', ' hidden') . zget($requiredFields, 'estimate', '', ' required');?> estimateBox'><?php echo $lang->task->estimateAB;?></th>
            <th class='c-date<?php echo zget($visibleFields, 'estStarted', ' hidden') . zget($requiredFields, 'estStarted', '', ' required');?> estStartedBox'><?php echo $lang->task->estStarted;?></th>
            <th class='c-date<?php echo zget($visibleFields, 'deadline', ' hidden') . zget($requiredFields, 'deadline',   '', ' required');?> deadlineBox'><?php echo $lang->task->deadline;?></th>
            <th class='c-desc<?php echo zget($visibleFields, 'desc', ' hidden') . zget($requiredFields, 'desc', '', ' required');?> descBox'><?php echo $lang->task->desc;?></th>
            <th class='c-pri<?php  echo zget($visibleFields, 'pri', ' hidden') . zget($requiredFields, 'pri', '', ' required');?> priBox'><?php echo $lang->task->pri;?></th>
            <?php
            $extendFields = $this->task->getFlowExtendFields();
            foreach($extendFields as $extendField) echo "<th class='w-100px'>{$extendField->name}</th>";
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $stories['ditto'] = $lang->task->ditto;
          $lang->task->typeList['ditto'] = $lang->task->ditto;
          $members['ditto'] = $lang->task->ditto;
          $modules['ditto'] = $lang->task->ditto;
          if($execution->type == 'ops') $colspan = $colspan - 1;
          ?>
          <?php for($i = 1; $i <= $config->task->batchCreate; $i++):?>
          <?php
          if($i == 1)
          {
              $currentStory = $storyID;
              $type         = '';
              $member       = '';
          }
          else
          {
              $currentStory = $type = $member = $moduleID = 'ditto';
          }
          ?>
          <?php $pri = 3;?>
          <tr>
            <td class='text-center'><?php echo $i;?></td>
            <td class="<?php echo zget($visibleFields, 'module', 'hidden')?> moduleBox" style='overflow:visible'>
              <?php echo html::select("module[$i]", $modules, $moduleID, "class='form-control chosen' onchange='setStories(this.value, $execution->id, $i)'")?>
              <?php echo html::hidden("parent[$i]", $parent);?>
            </td>
            <?php if($execution->type != 'ops'):?>
            <td class="<?php echo zget($visibleFields, 'story', 'hidden');?> storyBox" style='overflow: visible'>
              <div class='input-group'>
                <?php echo html::select("story[$i]", $stories, $currentStory, "class='form-control chosen' onchange='setStoryRelated($i)'");?>
                <span class='input-group-btn'>
                  <a id='preview<?php echo $i;?>' href='#' class='btn iframe btn-link btn-icon btn-copy' disabled='disabled' title='<?php echo $lang->preview; ?>'><i class='icon-eye'></i></a>
                  <a href='javascript:copyStoryTitle(<?php echo $i;?>)' class='btn btn-link btn-icon btn-copy' title='<?php echo $lang->task->copyStoryTitle; ?>'><i class='icon-arrow-right'></i></a>
                  <?php echo html::hidden("storyEstimate$i") . html::hidden("storyDesc$i") . html::hidden("storyPri$i");?>
                </span>
              </div>
            </td>
            <?php endif;?>
            <td style='overflow:visible'>
              <div class="input-control has-icon-right">
                <?php echo html::input("name[$i]", '', "class='form-control title-import'");?>
                <div class="colorpicker">
                  <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><span class="cp-title"></span><span class="color-bar"></span><i class="ic"></i></button>
                  <ul class="dropdown-menu clearfix pull-right">
                    <li class="heading"><?php echo $lang->task->colorTag;?><i class="icon icon-close"></i></li>
                  </ul>
                  <?php echo html::hidden("color[$i]", '', "data-provide='colorpicker' data-icon='color' data-wrapper='input-control-icon-right'  data-update-color='#name\\[$i\\]'");?>
                </div>
              </div>
            </td>
            <td class="<?php echo zget($visibleFields, 'region', 'hidden');?> regionBox" style='overflow:visible'><?php echo html::select("region[$i]", $regionList, isset($regionID) ? $regionID : '', "class='form-control chosen' onchange='loadLaneGroup(this.value, $i)'");?></td>
            <td class="<?php echo zget($visibleFields, 'lane', 'hidden');?> laneBox" style='overflow:visible'><?php echo html::select("lane[$i]", $lanes, '', "class='form-control chosen'");?></td>
            <td><?php echo html::select("type[$i]", $lang->task->typeList, $type, "class='form-control chosen'");?></td>
            <td class="<?php echo zget($visibleFields, 'assignedTo', 'hidden')?> assignedToBox" style='overflow:visible'><?php echo html::select("assignedTo[$i]", $members, $member, "class='form-control chosen'");?></td>
            <td class="<?php echo zget($visibleFields, 'estimate', 'hidden')?> estimateBox"><?php echo html::input("estimate[$i]", '', "class='form-control text-center'");?></td>
            <td class="<?php echo zget($visibleFields, 'estStarted', 'hidden')?> estStartedBox">
              <div class='input-group'>
                <?php
                echo html::input("estStarted[$i]", '', "class='form-control text-center form-date' onkeyup='toggleCheck(this)'");
                if($i != 1) echo "<span class='input-group-addon estStartedBox'><input type='checkbox' name='estStartedDitto[$i]' id='estStartedDitto$i' " . ($i > 1 ? "checked" : '') . " /> {$lang->task->ditto}</span>";
                ?>
              </div>
            </td>
            <td class="<?php echo zget($visibleFields, 'deadline', 'hidden')?> deadlineBox">
              <div class='input-group'>
                <?php
                echo html::input("deadline[$i]", '', "class='form-control text-center form-date' onkeyup='toggleCheck(this)'");
                if($i != 1) echo "<span class='input-group-addon deadlineBox'><input type='checkbox' name='deadlineDitto[$i]' id='deadlineDitto$i' " . ($i > 0 ? "checked" : '') . " /> {$lang->task->ditto}</span>";
                ?>
              </div>
            </td>
            <td class="<?php echo zget($visibleFields, 'desc', 'hidden')?> descBox"><?php echo html::textarea("desc[$i]", '', "rows='1' class='form-control autosize'");?></td>
            <td class="<?php echo zget($visibleFields, 'pri', 'hidden')?> priBox"><?php echo html::select("pri[$i]", (array)$lang->task->priList, $pri, 'class=form-control');?></td>
            <?php foreach($extendFields as $extendField) echo "<td" . (($extendField->control == 'select' or $extendField->control == 'multi-select') ? " style='overflow:visible'" : '') . ">" . $this->loadModel('flow')->getFieldControl($extendField, '', $extendField->field . "[$i]") . "</td>";?>
          </tr>
          <?php endfor;?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan='<?php echo $colspan?>' class='text-center form-actions'>
              <?php echo html::submitButton();?>
              <?php echo html::backButton();?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
</div>
<table class='template' id='trTemp'>
  <tbody>
    <tr>
      <td class='text-center'>%s</td>
      <td class="<?php echo zget($visibleFields, 'module', 'hidden')?> moduleBox" style='overflow:visible'>
        <?php echo html::select("module[%s]", $modules, $moduleID, "class='form-control chosen' onchange='setStories(this.value, $execution->id, \"%s\")'")?>
        <?php echo html::hidden("parent[%s]", $parent);?>
      </td>
      <td class="<?php echo zget($visibleFields, 'story', 'hidden');?> storyBox" style='overflow: visible'>
        <div class='input-group'>
          <?php echo html::select("story[%s]", $stories, $currentStory, "class='form-control chosen' onchange='setStoryRelated(\"%s\")'");?>
          <span class='input-group-btn'>
            <a id="preview%s" href='#' class='btn iframe btn-link btn-icon btn-copy' disabled='disabled' title='<?php echo $lang->preview; ?>'><i class='icon-eye'></i></a>
            <a href='javascript:copyStoryTitle("%s")' class='btn btn-link btn-icon btn-copy' title='<?php echo $lang->task->copyStoryTitle; ?>'><i class='icon-arrow-right'></i></a>
          </span>
        </div>
      </td>
      <td style='overflow:visible'>
        <div class="input-control has-icon-right">
          <?php echo html::input("name[%s]", '', "class='form-control title-import'");?>
          <div class="colorpicker">
            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><span class="cp-title"></span><span class="color-bar"></span><i class="ic"></i></button>
            <ul class="dropdown-menu clearfix pull-right">
              <li class="heading"><?php echo $lang->task->colorTag;?><i class="icon icon-close"></i></li>
            </ul>
            <?php echo html::hidden("color[%s]", '', "data-provide='colorpicker-later' data-icon='color' data-wrapper='input-control-icon-right'  data-update-color='#name\\[%s\\]'");?>
          </div>
        </div>
        </div>
      </td>
      <td class="<?php echo zget($visibleFields, 'region', 'hidden');?> regionBox" style='overflow:visible'><?php echo html::select("region[%s]", $regionList, isset($regionID) ? $regionID : '', "class='form-control chosen' onchange='loadLaneGroup(this.value, $i)'");?></td>
      <td class="<?php echo zget($visibleFields, 'lane', 'hidden');?> laneBox" style='overflow:visible'><?php echo html::select("lane[%s]", $lanes, '', "class='form-control chosen'");?></td>
      <td><?php echo html::select("type[%s]", $lang->task->typeList, $type, 'class="form-control"');?></td>
      <td class="<?php echo zget($visibleFields, 'assignedTo', 'hidden');?> assignedToBox" style='overflow:visible'><?php echo html::select("assignedTo[%s]", $members, $member, "class='form-control chosen'");?></td>
      <td class="<?php echo zget($visibleFields, 'estimate', 'hidden');?> estimateBox"><?php echo html::input("estimate[%s]", '', "class='form-control text-center'");?></td>
      <td class="<?php echo zget($visibleFields, 'estStarted', 'hidden');?> estStartedBox">
        <div class='input-group'>
          <?php
          echo html::input("estStarted[%s]", '', "class='form-control text-center form-date' onkeyup='toggleCheck(this)'");
          echo "<span class='input-group-addon estStartedBox'><input type='checkbox' name='estStartedDitto[%s]' id='estStartedDitto%s' checked/>{$lang->task->ditto}</span>";
          ?>
        </div>
      </td>
      <td class="<?php echo zget($visibleFields, 'deadline', 'hidden')?> deadlineBox">
        <div class='input-group'>
          <?php
          echo html::input("deadline[%s]", '', "class='form-control text-center form-date' onkeyup='toggleCheck(this)'");
          echo "<span class='input-group-addon deadlineBox'><input type='checkbox' name='deadlineDitto[%s]' id='deadlineDitto%s' checked/>{$lang->task->ditto}</span>";
          ?>
        </div>
      <td class="<?php echo zget($visibleFields, 'desc', 'hidden')?> descBox"><?php echo html::textarea("desc[%s]", '', "rows='1' class='form-control autosize'");?></td>
      <td class="<?php echo zget($visibleFields, 'pri', 'hidden')?> priBox"><?php echo html::select("pri[%s]", (array)$lang->task->priList, $pri, 'class=form-control');?></td>
      <?php foreach($extendFields as $extendField) echo "<td" . (($extendField->control == 'select' or $extendField->control == 'multi-select') ? " style='overflow:visible'" : '') . ">" . $this->loadModel('flow')->getFieldControl($extendField, '', $extendField->field . "[%s]") . "</td>";?>
    </tr>
  </tbody>
</table>
<?php js::set('executionType', $execution->type);?>
<?php js::set('storyTasks', $storyTasks);?>
<?php js::set('mainField', 'name');?>
<?php js::set('ditto', $lang->task->ditto);?>
<?php js::set('storyID', $storyID);?>
<script>
function loadLaneGroup(regionID, num)
{
    var link = createLink('kanban', 'ajaxGetLanes', 'regionID=' + regionID + '&type=task&field=lane&i=' + num);
    $.post(link, function(data)
    {
        $('#lane' + num).replaceWith(data);
        $('#lane' + num + '_chosen').remove();
        $('#lane' + num).chosen();
    });
}
$(function()
{
    /* Initial fetch of kanban lanes. */
    var link = createLink('kanban', 'ajaxGetLanes', 'regionID=' + regionID + '&type=task&field=lane&i=1');
    $.post(link, function(data)
    {
        for(var num = 1; num <= 10; num++)
        {
            $('#lane' + num).replaceWith(data.replace('lane1', 'lane' + num).replace('lane[1]', 'lane[' + num + ']'));
            $('#lane' + num + '_chosen').remove();
            $('#lane' + num).chosen();
        }
        if($('#lane1').children().length < 2 && $('#region1').children().length < 2)
        {
            $('.c-region').addClass('hide');
            $('.c-lane').addClass('hide');
            for(var num = 1; num <= 10; num++)
            {
                $('#region' + num).parent().addClass('hide');
                $('#lane' + num).parent().addClass('hide');
            }
        }
    });
})
</script>
<?php if(isonlybody()):?>
<style>
.body-modal .main-header{padding-right:0px;}
.btn-toolbar>.dropdown{margin:0px;}
</style>
<?php $html = '<div class="divider"></div><button id="closeModal" type="button" class="btn btn-link" data-dismiss="modal"><i class="icon icon-close"></i></button>';?>
<script>$(function()
{
    parent.$('#triggerModal .modal-content .modal-header .close').hide();
    $('#mainContent .main-header .pull-right.btn-toolbar').append(<?php echo json_encode($html)?>);
})
</script>
<?php endif;?>
<?php include $this->app->getModuleRoot() . '/common/view/pastetext.html.php';?>
<?php include $this->app->getModuleRoot() . '/common/view/footer.html.php';?>
