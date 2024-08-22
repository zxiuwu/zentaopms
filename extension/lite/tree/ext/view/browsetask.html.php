<?php
/**
 * The browse view file of tree module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id: browse.html.php 4796 2013-06-06 02:21:59Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include $this->app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('tab', $app->tab);?>
<style>
li.story-item > .tree-actions .tree-action[data-type=sort] {display: none;}
li.story-item > .tree-actions .tree-action[data-type=edit] {display: none;}
li.story-item > .tree-actions .tree-action[data-type=delete] {display: none;}
#modulesTree li.dragging {opacity: .3;}
</style>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php $backLink = $this->session->taskList ? $this->session->taskList : 'javascript:history.go(-1)';?>
    <a href="<?php echo $backLink;?>" class="btn btn-secondary">
      <i class="icon icon-back icon-sm"></i> <?php echo $lang->goback;?>
    </a>
    <div class="divider"></div>
    <div class="page-title">
      <span class='text' title='<?php echo $root->name;?>'><?php echo $lang->tree->common . $lang->colon . $root->name;?></span>
    </div>
  </div>
</div>
<div id="mainContent" class="main-row">
  <div class="side-col col-4">
    <div class='panel'>
      <div class='panel-heading'>
        <div class='panel-title'><?php echo $title;?></div>
      </div>
      <div class='panel-body'>
        <ul id='modulesTree' data-name='tree-task'></ul>
      </div>
    </div>
  </div>
  <div class="main-col col-8">
    <form id='childrenForm' method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'manageChild', "root={$root->id}&viewType=task");?>'>
      <div class='panel'>
        <div class='panel-heading'>
          <div class='panel-title'><?php echo $lang->tree->manageTaskChild;?></div>
        </div>
        <div class='panel-body'>
          <table class='table table-form table-auto'>
            <tr>
              <td class="text-middle text-right with-padding">
                <?php
echo "<span>" . html::a($this->createLink('tree', 'browsetask', "root={$root->id}&productID=$productID&viewType=task"), $root->name, '', "data-app='{$app->tab}'") . "<i class='icon icon-angle-right muted'></i></span>";
                foreach($parentModules as $module)
                {
                    echo "<span>" . html::a($this->createLink('tree', 'browsetask', "root={$root->id}&productID=$productID&moduleID=$module->id"), $module->name, '', "data-app='{$app->tab}'") . " <i class='icon icon-angle-right muted'></i></span>";
                }
                ?>
              </td>
              <td>
                <div id='sonModule'>
                  <?php $maxOrder = 0;?>
                  <?php if($newModule and !$productID):?>
                  <?php foreach($products as $product):?>
                  <div class="table-row row-module">
                    <div class="table-col col-module"><?php echo html::input("products[id$product->id]", $product->name, 'class=form-control disabled="true"')?></div>
                  </div>
                  <?php endforeach;?>
                  <?php endif;?>
                  <?php foreach($sons as $sonModule):?>
                  <?php
                  if($sonModule->order > $maxOrder) $maxOrder = $sonModule->order;
                  $disabled = $sonModule->type == 'task' ? '' : 'disabled';
                  ?>
                  <div class='table-row row-module'>
                    <div class='table-col col-module'><?php echo html::input("modules[id$sonModule->id]", $sonModule->name, "class='form-control' placeholder='{$lang->tree->name}' $disabled")?></div>
                    <div class='table-col col-shorts'>
                      <?php
                      echo html::input("shorts[id$sonModule->id]", $sonModule->short, "class='form-control' placeholder='{$lang->tree->short}' $disabled");
                      echo html::hidden("order[id$sonModule->id]", $sonModule->order);
                      ?>
                    </div>
                    <div class="table-col col-actions"> </div>
                  </div>
                  <?php endforeach;?>
                  <?php for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++):?>
                  <div class="table-row row-module row-module-new">
                    <div class='table-col col-module'><?php echo html::input("modules[]", '', "class='form-control' placeholder='{$lang->tree->name}'")?></div>
                    <div class='table-col col-shorts'><?php echo html::input("shorts[]", '', "class='form-control' placeholder='{$lang->tree->short}'")?></div>
                    <div class="table-col col-actions">
                      <button type="button" class="btn btn-link btn-icon btn-add" onclick="addItem(this)"><i class="icon icon-plus"></i></button>
                      <button type="button" class="btn btn-link btn-icon btn-delete" onclick="deleteItem(this)"><i class="icon icon-close"></i></button>
                    </div>
                    <?php echo html::hidden('branch[]', empty($module) ? 0 : $module->branch);?>
                  </div>
                  <?php endfor;?>
                </div>
                <div id="insertItemBox" class="template">
                  <div class="table-row row-module row-module-new">
                    <div class="table-col col-module"><?php echo html::input("modules[]", '', "class='form-control' placeholder='{$lang->tree->name}'");?></div>
                    <div class="table-col col-shorts"><?php echo html::input("shorts[]", '', "class='form-control' placeholder='{$lang->tree->short}'");?></div>
                    <div class="table-col col-actions">
                      <button type="button" class="btn btn-link btn-icon btn-add" onclick="addItem(this)"><i class="icon icon-plus"></i></button>
                      <button type="button" class="btn btn-link btn-icon btn-delete" onclick="deleteItem(this)"><i class="icon icon-close"></i></button>
                    </div>
                    <?php echo html::hidden('branch[]', empty($module) ? 0 : (int)$module->branch);?>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td colspan='2' class="form-actions">
                <?php
                if($canBeChanged) echo html::submitButton();
                echo html::a($backLink, $lang->goback, '', "class='btn btn-wide'");
                echo html::hidden('parentModuleID', $currentModuleID);
                echo html::hidden('maxOrder', $maxOrder);
                ?>
                <input type='hidden' value='<?php echo $currentModuleID;?>' name='parentModuleID' />
              </td>
            </tr>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
function getTree(data)
{
    var tree = [];
    $.each(data,function(index, value){
        if(value.type === 'product')
        {
            for (var child of value.children) tree.push(child);
        }
        else
        {
            tree.push(value);
        }
    });

    return tree;
}

$(function()
{
    var data = $.parseJSON('<?php echo helper::jsonEncode4Parse($tree);?>');
    data = getTree(data);
    var options = {
        initialState: 'preserve',
        data: data,
        itemCreator: function($li, item)
        {
            var $toggle = $('<span class="module-name" data-id="' + item.id + '">' + link + '</span>');

            var title = (item.type === 'product' ? '<i class="icon icon-product text-muted"></i> ' : '') + item.name;
            var link = item.id !== undefined ? ('<a data-app=' + tab + ' href="' + createLink('tree', 'browsetask', 'rootID=<?php echo $rootID ?>&viewType=task&moduleID={0}'.format(item.id)) + '">' + title + '</a>') : ('<span class="tree-toggle">' + title + '</span>');
            var $toggle = $('<span class="module-name" data-id="' + item.id + '">' + link + '</span>');
            if(item.type === 'task')
            {
                $li.addClass('task-item');
            }
            if(item.type === 'story') $li.addClass('story-item');
            $li.append($toggle);
            if(item.nodeType) $li.addClass('tree-item-' + item.nodeType);
            return true;
        },
        actions:
        {
            sort:
            {
                title: '<?php echo $lang->tree->dragAndSort ?>',
                template: '<a class="sort-handler" href="javascript:;"><i class="icon icon-move"></i></a>'
            },
            edit:
            {
                linkTemplate: '<?php echo helper::createLink('tree', 'edit', "moduleID={0}&type=task"); ?>',
                title: '<?php echo $lang->tree->edit ?>',
                template: '<a href="javascript:;"><i class="icon icon-edit"></i></a>'
            },
            "delete":
            {
                linkTemplate: '<?php echo helper::createLink('tree', 'delete', "rootID=$rootID&moduleID={0}"); ?>',
                title: '<?php echo $lang->tree->delete ?>',
                template: '<a href="javascript:;"><i class="icon icon-trash"></i></a>'
            },
            subModules:
            {
                linkTemplate: '<?php echo helper::createLink('tree', 'browsetask', "rootID=$rootID&viewType=task&moduleID={0}"); ?>',
                title: '<?php echo $lang->tree->child ?>',
                template: '<a href="javascript:;"><i class="icon icon-split"></i></a>'
            }
        },
        action: function(event)
        {
            var action = event.action, $target = $(event.target), item = event.item;
            if(action.type === 'edit')
            {
                new $.zui.ModalTrigger({
                    type: 'ajax',
                    url: action.linkTemplate.format(item.id),
                    keyboard: true
                }).show();
            }
            else if(action.type === 'delete')
            {
                hiddenwin.location.href = action.linkTemplate.format(item.id);
            }
            else if(action.type === 'add')
            {
                window.location.href = action.linkTemplate.format(item.id);
            }
            else if(action.type === 'sort')
            {
                var orders = {};
                $('#modulesTree').find('li:not(.tree-action-item)').each(function()
                {
                    var $li = $(this);
                    var item = $li.data();
                    orders['orders[' + item.id + ']'] = $li.attr('data-order') || item.order;
                });
                $.post('<?php echo $this->createLink('tree', 'updateOrder', "root={$root->id}&viewType=task");?>', orders, function(data)
                {
                    $('.main-col').load(location.href + ' .main-col .panel');
                }).error(function()
                {
                    bootbox.alert(lang.timeout);
                });
            }
            else if(action.type === 'subModules')
            {
                window.location.href = action.linkTemplate.format(item.id, item.branch);
            }
        }
    };

    if(<?php echo (common::hasPriv('tree', 'updateorder') and $canBeChanged) ? 'false' : 'true' ?>) options.actions["sort"] = false;
    if(<?php echo (common::hasPriv('tree', 'edit') and $canBeChanged) ? 'false' : 'true' ?>) options.actions["edit"] = false;
    if(<?php echo (common::hasPriv('tree', 'delete') and $canBeChanged) ? 'false' : 'true' ?>) options.actions["delete"] = false;
    if(<?php echo $canBeChanged ? 'false' : 'true' ?>) options.actions["subModules"] = false;

    var $tree = $('#modulesTree').tree(options);

    var tree = $tree.data('zui.tree');
    if(!tree.store.time) tree.expand($tree.find('li:not(.tree-action-item)').first());
    <?php if($currentModuleID): ?>
    var $currentLi = $tree.find('.module-name[data-id=' + <?php echo $currentModuleID ?> + ']').closest('li');
    if($currentLi.length) tree.show($currentLi);
    <?php endif; ?>

    $tree.on('mouseenter', 'li:not(.tree-action-item)', function(e)
    {
        $('#modulesTree').find('li.hover').removeClass('hover');
        $(this).addClass('hover');
        e.stopPropagation();
    });

    $tree.find('[data-toggle="tooltip"]').tooltip();
});
</script>
<?php include $this->app->getModuleRoot() . 'common/view/footer.html.php';?>
