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
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('currentModuleID', $currentModuleID);?>
<div id="mainContent" class="main-row">
  <div class="side-col col-4">
    <div class="panel">
      <div class="panel-heading">
        <div class="panel-title"><?php echo $lang->baseline->catalog;?></div>
      </div>
      <div class="panel-body">
        <ul id='modulesTree' data-name='tree-baseline'></ul>
      </div>
    </div>
  </div>
  <div class="main-col col-8">
    <div class="panel">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo $lang->baseline->manageChild;?>
        </div>
      </div>
      <div class="panel-body">
        <form id='childrenForm' method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'manageChild', "root=0&viewType=doc");?>'>
          <table class='table table-form table-auto'>
            <tr>
              <td class="text-middle text-right with-padding">
                <?php
                foreach($parentModules as $module)
                {
                    echo "<span>" . html::a($this->createLink('baseline', 'browse', "moduleID=$module->id"), $module->name) . " <i class='icon icon-angle-right muted'></i></span>";
                }
                ?>
              </td>
              <td>
                <div id='sonModule'>
                  <?php $maxOrder = 0;?>
                  <?php foreach($sons as $sonModule):?>
                  <?php if($sonModule->order > $maxOrder) $maxOrder = $sonModule->order;?>
                  <div class="table-row row-module">
                    <div class="table-col col-module"><?php echo html::input("modules[id$sonModule->id]", $sonModule->name, 'class="form-control"');?></div>
                    <div class="table-col col-shorts"><?php echo html::input("shorts[id$sonModule->id]", $sonModule->short, "class='form-control' placeholder='{$lang->tree->short}'") . html::hidden("order[id$sonModule->id]", $sonModule->order);?></div>
                    <div class="table-col col-actions"> </div>
                  </div>
                  <?php endforeach;?>
                  <?php for($i = 0; $i < 5; $i ++):?>
                  <div class="table-row row-module row-module-new">
                    <div class="table-col col-module"><?php echo html::input("modules[]", '', "class='form-control' placeholder='{$lang->baseline->name}'");?></div>
                    <div class="table-col col-shorts"><?php echo html::input("shorts[]", '', "class='form-control' placeholder='{$lang->tree->short}'");?></div>
                    <div class="table-col col-actions">
                      <button type="button" class="btn btn-link btn-icon btn-add" onclick="addItem(this)"><i class="icon icon-plus"></i></button>
                      <button type="button" class="btn btn-link btn-icon btn-delete" onclick="deleteItem(this)"><i class="icon icon-close"></i></button>
                    </div>
                  </div>
                  <?php endfor;?>
                </div>

                <div id="insertItemBox" class="template">
                  <div class="table-row row-module row-module-new">
                    <div class="table-col col-module"><?php echo html::input("modules[]", '', "class='form-control' placeholder='{$lang->baseline->name}'");?></div>
                    <div class="table-col col-shorts"><?php echo html::input("shorts[]", '', "class='form-control' placeholder='{$lang->tree->short}'");?></div>
                    <div class="table-col col-actions">
                      <button type="button" class="btn btn-link btn-icon btn-add" onclick="addItem(this)"><i class="icon icon-plus"></i></button>
                      <button type="button" class="btn btn-link btn-icon btn-delete" onclick="deleteItem(this)"><i class="icon icon-close"></i></button>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td colspan="2" class="form-actions">
                <?php echo html::submitButton();?>
                <?php echo html::backButton();?>
                <?php echo html::hidden('parentModuleID', $currentModuleID);?>
                <?php echo html::hidden('maxOrder', $maxOrder);?>
              </td>
            </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function()
{
    var data = $.parseJSON('<?php echo helper::jsonEncode4Parse($tree);?>');
    var options =
    {
        initialState: 'preserve',
        data: data,
        sortable:
        {
            lazy: true,
            nested: true,
            canMoveHere: function($ele, $target)
            {
                if($ele && $target && $ele.parent().closest('li').attr('data-id') !== $target.parent().closest('li').attr('data-id')) return false;
            }
        },
        itemCreator: function($li, item)
        {
            var link = (item.id !== undefined && item.type != 'line') ? ('<a href="' + createLink('baseline', 'catalog', 'moduleID={0}'.format(item.id, item.branch)) + '">' + item.name + '</a>') : ('<span class="tree-toggle">' + item.name + '</span>');
            var $toggle = $('<span class="module-name" data-id="' + item.id + '">' + link + '</span>');
            $li.append($toggle);
            if(item.nodeType || item.type) $li.addClass('tree-item-' + (item.nodeType || item.type));
            if(currentModuleID == item.id) $li.addClass('active');
            return true;
        },
        actions:
        {
            sort:
            {
                title: '<?php echo $lang->tree->dragAndSort ?>',
                template: '<a class="sort-handler"><i class="icon-move"></i></a>'
            },
            //edit:
            //{
            //    linkTemplate: '<?php echo helper::createLink('tree', 'edit', "moduleID={0}&type=baseline"); ?>',
            //    title: '<?php echo $lang->tree->edit ?>',
            //    template: '<a><i class="icon-edit"></i></a>'
            //},
            "delete":
            {
                linkTemplate: '<?php echo helper::createLink('tree', 'delete', "rootID=0&moduleID={0}"); ?>',
                title: '<?php echo $lang->tree->delete ?>',
                template: '<a><i class="icon-trash"></i></a>'
            },
            subModules:
            {
                linkTemplate: '<?php echo helper::createLink('baseline', 'catalog', "moduleID={0}"); ?>',
                title: '<?php echo $title;?>',
                template: '<a><?php echo '<i class="icon-treemap-alt"></i>';?></a>',
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
            else if(action.type === 'sort')
            {
                var orders = {};
                $('#modulesTree').find('li:not(.tree-action-item)').each(function()
                {
                    var $li = $(this);
                    if($li.hasClass('tree-item-branch')) return;

                    var item = $li.data();
                    orders['orders[' + item.id + ']'] = $li.attr('data-order') || item.order;
                });
                $.post('<?php echo $this->createLink('tree', 'updateOrder', "rootID=0&viewType=baseline");?>', orders).error(function()
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

    if(<?php echo common::hasPriv('tree', 'updateorder') ? 'false' : 'true' ?>) options.actions["sort"] = false;
    if(<?php echo common::hasPriv('tree', 'edit') ? 'false' : 'true' ?>) options.actions["edit"] = false;
    if(<?php echo common::hasPriv('tree', 'delete') ? 'false' : 'true' ?>) options.actions["delete"] = false;

    var $tree = $('#modulesTree').tree(options);

    var tree = $tree.data('zui.tree');
    if(<?php echo $currentModuleID ?>)
    {
        var $currentLi = $tree.find('.module-name[data-id=' + <?php echo $currentModuleID ?> + ']').closest('li');
        if($currentLi.length) tree.show($currentLi);
    }

    $tree.on('mouseenter', 'li:not(.tree-action-item)', function(e)
    {
        $('#modulesTree').find('li.hover').removeClass('hover');
        $(this).addClass('hover');
        e.stopPropagation();
    });
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
