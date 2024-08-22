<?php
/**
 * The ai prompt role assign view file of ai module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Wenrui LI <liwenrui@easycorp.ltd>
 * @package     ai
 * @link        https://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<style>
  .center-wrapper {display: flex; justify-content: center; height: 100%;}
  .center-content {min-width: 800px; height: 100%; display: flex; flex-direction: column;}
  .content-row {display: flex; flex-direction: row; padding: 8px 0px;}
  .input-label {width: 120px; padding: 6px 12px; text-align: right;}
  .input {flex-grow: 1;}
  .v-top > * {vertical-align: top; display: inline-block;}
  .role-template-card p {margin: 0;}
  #roleTemplate {overflow: hidden;}
  #roleTemplate .btn-link:focus {background: unset;}
  #roleListContainer {flex-grow: 1; overflow-y: scroll;}
</style>
<?php include 'promptdesignprogressbar.html.php';?>
<div id='mainContent' class='main-content' style='height: calc(100vh - 120px); padding: 0;'>
  <form id="mainForm" onsubmit="return validateForm();" class='load-indicator main-form form-ajax' method='post' style='height: 100%;'>
    <div class='center-wrapper'>
      <div class='center-content' style="width: 100%; display: flex; flex-direction: row;">
        <div style="flex-grow: 1; padding: 20px;">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <h4><?php echo $lang->ai->prompts->assignRole;?></h4>
              <?php echo html::commonButton("<span>{$lang->ai->prompts->roleTemplate}</span> " . "<icon class='icon icon-first-page'></icon> ", 'id="expandRoleTemplatePanel"', 'btn btn-info');?>
            </div>
            <div class='content-row'>
              <div class='input-label'><span><?php echo $lang->ai->prompts->model;?></span></div>
              <div class='input mw-400px'>
                <?php echo html::select('model', $lang->ai->models->typeList, current(array_keys($lang->ai->models->typeList)), "class='form-control chosen' required");?>
              </div>
            </div>
            <div class='content-row'>
              <div class='input-label'><span><?php echo $lang->ai->prompts->role;?></span></div>
              <div class='input mw-400px'><?php echo html::input('role', $prompt->role, "class='form-control' placeholder='{$lang->ai->prompts->rolePlaceholder}'");?></div>
            </div>
            <div class='content-row'>
              <div class='input-label'><span><?php echo $lang->ai->prompts->characterization;?></span></div>
              <div class='input'><?php echo html::textarea('characterization', $prompt->characterization, "class='form-control' rows='4' placeholder='{$lang->ai->prompts->charPlaceholder}'");?></div>
            </div>
            <div class='content-row'>
              <div class='input-label'><span><?php echo $lang->ai->prompts->roleTemplateSave;?></span></div>
              <div class='input' style="display: flex; align-items: center;"><?php echo html::radio('saveTemplate', $lang->ai->prompts->roleTemplateSaveList, 'discard');?></div>
            </div>
          </div>
          <div style='display: flex; flex-grow: 1; flex-direction: column-reverse;'>
            <div style='display: flex; justify-content: center;'><?php echo html::submitButton($lang->ai->nextStep, 'disabled name="jumpToNext" value="1"');?></div>
          </div>
        </div>
        <div id="roleTemplate" style="display: none; flex-direction: column; width: 370px; flex-grow: 0; padding: 20px 24px; border-left: 1px solid #E6EAF1; background-color: #FCFDFE; border-top-right-radius: 4px; border-bottom-right-radius: 4px;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 4px; flex-grow: 0;">
            <h4 class="v-top"">
            <?php echo "<span style='margin-right: 4px;'>{$lang->ai->prompts->roleTemplate}</span>" . " <i class='icon icon-help' data-toggle='tooltip' data-placement='top' title='{$lang->ai->prompts->roleTemplateTip}'></i>";?>
            </h4>
            <?php echo html::commonButton("<i class='icon icon-plus icon-sm text-primary'></i>", 'data-toggle="modal" data-target="#createRoleTemplateModal"', 'btn btn-link'); ?>
          </div>
          <div id="roleListContainer">
            <?php include './roletemplates.html.php';?>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal fade" id="createRoleTemplateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only"><?php echo $lang->close; ?></span></button>
        <h4 class="modal-title"><?php echo $lang->ai->prompts->addRoleTemplate; ?></h4>
      </div>
      <div class="modal-body">
        <form id="createRoleForm" class="not-watch">
          <div class='content-row'>
            <div class='input-label'><span><?php echo $lang->ai->prompts->role;?></span></div>
            <div class='input mw-400px'><?php echo html::input('role', '', "class='form-control' placeholder='{$lang->ai->prompts->rolePlaceholder}'");?></div>
          </div>
          <div class='content-row'>
            <div class='input-label'><span><?php echo $lang->ai->prompts->characterization;?></span></div>
            <div class='input'><?php echo html::textarea('characterization', '', "class='form-control' rows='4' placeholder='{$lang->ai->prompts->charPlaceholder}'");?></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="createRoleButton" type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $lang->save; ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editRoleTemplateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only"><?php echo $lang->close; ?></span></button>
        <h4 class="modal-title"><?php echo $lang->ai->prompts->editRoleTemplate; ?> <small class="text-gray"><?php echo $lang->ai->prompts->editRoleTemplateTip;?> </small></h4>
      </div>
      <div class="modal-body">
        <form id="editRoleForm" class="not-watch">
          <div class='content-row'>
            <div class='input-label'><span><?php echo $lang->ai->prompts->role;?></span></div>
            <div class='input mw-400px'><?php echo html::input('role', '', "class='form-control' placeholder='{$lang->ai->prompts->rolePlaceholder}'");?></div>
          </div>
          <div class='content-row'>
            <div class='input-label'><span><?php echo $lang->ai->prompts->characterization;?></span></div>
            <div class='input'><?php echo html::textarea('characterization','', "class='form-control' rows='4' placeholder='{$lang->ai->prompts->charPlaceholder}'");?></div>
          </div>
          <input type="hidden" name="id">
        </form>
      </div>
      <div class="modal-footer">
        <button id="editRoleButton" type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $lang->save; ?></button>
      </div>
    </div>
  </div>
</div>

<script>
function validateForm()
{
  let pass = true;
  const model = document.getElementById('model')?.value;
  if(!model)
  {
    $.zui.messager.danger('<?php echo sprintf($lang->ai->validate->noEmpty, $lang->ai->prompts->model);?>');
    pass = false;
  }
  return pass;
}

(function ()
{
  let roleId = null;

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('select[name="model"]').change(function()
    {
      var model = $(this).val();
      if (model) $('button[type="submit"]').removeAttr('disabled');
      if (!model) $('button[type="submit"]').attr('disabled', 'disabled');
    });
    $('select[name="model"]').trigger('change');
  });

  $('#createRoleButton').on('click', function(e)
  {
    e.preventDefault();
    const formData = new FormData(document.getElementById('createRoleForm'));
    if(!formData.get('role'))
    {
      $.zui.messager.danger('<?php echo sprintf($lang->ai->validate->noEmpty, $lang->ai->prompts->role);?>');
      return false;
    }
    $.ajax({
      url: createLink('ai', 'roleTemplates'),
      type: 'POST',
      data: {method: 'create', role: formData.get('role'), characterization: formData.get('characterization')},
      dataType: 'html',
      success: function(response)
      {
        $('#createRoleForm [name="role"], #createRoleForm [name="characterization"]').each(function() {$(this).val('');});
        $.zui.messager.success('<?php echo $lang->ai->prompts->roleAddedSuccess; ?>');
        $('#roleList').html($($.parseHTML(response)).filter('#roleList').html());
      }
    });
  });

  $('#editRoleButton').on('click', function(e)
  {
    e.preventDefault();
    const formData = new FormData(document.getElementById('editRoleForm'));
    if(!formData.get('role'))
    {
      $.zui.messager.danger('<?php echo sprintf($lang->ai->validate->noEmpty, $lang->ai->prompts->role);?>');
      return false;
    }
    $.ajax({
      url: createLink('ai', 'roleTemplates'),
      type: 'POST',
      data: {
        method: 'edit',
        id: formData.get('id'),
        role: formData.get('role'),
        characterization: formData.get('characterization')
      },
      dataType: 'html',
      success: function(response)
      {
        $('#editRoleForm [name="role"], #editRoleForm [name="characterization"]').each(function() {$(this).val('');});
        $.zui.messager.success('<?php echo $lang->ai->prompts->roleAddedSuccess; ?>');
        $('#roleList').html($($.parseHTML(response)).filter('#roleList').html());
      }
    });
  });

  $('#roleListContainer').on('click', function(e)
  {
    const button = e.target.closest('#roleListContainer button');
    if(!button) return;
    const card = button.closest('.role-template-card');
    if(!card) return;
    e.preventDefault();

    const id = card.dataset.id;

    switch (button.dataset.action)
    {
      case 'apply':
      {
        $('#mainForm input[name="role"]').val(card.querySelector('.role').innerText).toggleClass('focus', true);
        $('#mainForm textarea[name="characterization"]').val(card.querySelector('.characterization').innerText).toggleClass('focus', true);
        setTimeout(() => {
          $('#mainForm input[name="role"]').toggleClass('focus', false);
          $('#mainForm textarea[name="characterization"]').toggleClass('focus', false);
        }, 1000);
        roleId = id;
        break;
      }
      case 'edit':
      {
        const model = $('#editRoleTemplateModal');
        model.find('input[name="id"]').val(id);
        model.find('input[name="role"]').val(card.querySelector('.role').innerText);
        model.find('textarea[name="characterization"]').val(card.querySelector('.characterization').innerText);
        model.modal('toggle');
        break;
      }
      case 'del':
      {
        if (window.confirm('<?php echo $lang->ai->prompts->roleDelConfirm; ?>')) {
          $.ajax({
            url: createLink('ai', 'roleTemplates'),
            type: 'POST',
            data: {method: 'delete', id: id},
            dataType: 'html',
            success: function (response) {
              $.zui.messager.success('<?php echo $lang->ai->prompts->roleDelSuccess; ?>');
              $('#roleList').html($($.parseHTML(response)).filter('#roleList').html());
            }
          });
        }
        break;
      }
    }
  });

  $('#mainForm').on('submit', function()
  {
    if($('#mainForm input[name="saveTemplate"]:checked').val() === 'discard') return true;
    if((roleId && !$(`#role-template-${roleId}`).length) || ($('#mainForm input[name="role"]').val() === $(`role-${roleId}`).text() && $('#mainForm textarea[name="characterization"]').val() === $(`characterization-${roleId}`).text()))
    {
      $('#mainForm input[name="saveTemplate"]#saveTemplatediscard').prop('checked', true);
    }
    return true;
  });

  const expandRoleTemplatePanel = document.getElementById('expandRoleTemplatePanel');
  if(expandRoleTemplatePanel)
  {
    expandRoleTemplatePanel.addEventListener('click', function (e) {
      const roleTemplate = document.getElementById('roleTemplate');
      const isPanelExpanded = roleTemplate.style.display === 'flex';
      expandRoleTemplatePanel.querySelector('icon').className = isPanelExpanded ? 'icon icon-first-page' : 'icon icon-last-page';
      if (roleTemplate) {
        roleTemplate.style.display = isPanelExpanded ? 'none' : 'flex';
      }
    });
  }
})();
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
