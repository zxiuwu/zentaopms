<?php
/**
 * The feedback edit mobile view file of feedback module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2016 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Fei Chen <chenfei@cnezsoft.com>
 * @package     feedback
 * @version     $Id
 * @link        http://www.zentao.net
 */
?>
<div class='heading divider'>
  <div class='title'><i class='icon-plus muted'></i> <strong><?php echo $lang->feedback->edit;?></strong></div>
  <nav class='nav'><a data-dismiss='display'><i class='icon icon-remove muted'></i></a></nav>
</div>
<form class='content box' data-form-refresh='#page' method='post' id='createForm' action='<?php echo $this->createLink('feedback', 'edit', "feedbackID=$feedback->id");?>' target='hiddenwin' enctype='multipart/form-data'>
  <div class="control">
    <label for='module'><?php echo $lang->feedback->product;?></label>
    <div class='select'><?php echo html::select('product', $products, $feedback->product);?></div>
  </div>
  <div class='control'>
    <label for='name'><?php echo $lang->feedback->title;?></label>
    <?php echo html::input('title', $feedback->title, "class='input' placeholder='{$lang->required}'");?>
  </div>
  <div class='control'>
    <div class='checkbox'>
      <input type='checkbox' id='public' name='public' value='1' <?php if($feedback->public) echo 'checked'?>>
      <label for='public'> <?php echo $lang->feedback->public;?></label>
    </div>
  </div>
  <div class='control'>
    <label for='desc'><?php echo $lang->feedback->desc;?></label>
    <?php echo html::textarea('desc', $feedback->desc, "rews='5' class='textarea'");?>
  </div>
  <div class='control'>
    <?php echo $this->fetch('file', 'buildForm', 'fileCount=1');?>
  </div>
  <div class='control'>
    <div class='checkbox'>
      <input type='checkbox' id='notify' name='notify' value='1' <?php if($feedback->notify) echo 'checked'?>>
      <label for='notify'> <?php echo $lang->feedback->mailNotify;?></label>
    </div>
  </div>
</form>

<div class='footer has-padding'>
  <button type='button' id='submitButton' class='btn primary'><?php echo $lang->save;?></button>
</div>

<script>
$(function()
{
    $('#submitButton').click(function(){$('#createForm').submit()});
});
</script>
