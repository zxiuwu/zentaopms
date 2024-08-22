<?php
/**
 * The browse view file of workflowhook module of ZDOO.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     workflowhook
 * @version     $Id$
 * @link        http://www.zdoo.com
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php js::set('action', $action->id);?>
<div id='createHook'>
  <?php extCommonModel::printLink('workflowhook', 'create', "action=$action->id", "<i class='icon-plus'> </i>" . $lang->workflowhook->create, "class='btn btn-primary loadInModal iframe'");?>
</div>
<div class='panel main-table'>
  <table class='table table-fixed' id='hookTable'>
    <thead>
      <tr>
        <th><?php echo $lang->workflowhook->common;?></th>
        <th><?php echo $lang->workflowhook->condition;?></th>
        <th class='w-180px'><?php echo $lang->comment;?></th>
        <th class='w-80px text-center'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($action->hooks as $key => $hook):?>
      <tr>
        <td title="<?php echo $hook->sql;?>"><?php echo $hook->sql;?></td>
        <?php $title = is_object($hook->conditions) ? $hook->conditions->sql : '';?>
        <td title="<?php echo $title;?>">
          <?php 
          if(is_object($hook->conditions))
          {
              echo $hook->conditions->sql;
          }
          elseif(is_array($hook->conditions))
          {
              foreach($hook->conditions as $k => $condition)
              {
                  if($k > 0) echo ' ' . $lang->workflowhook->logicalOperatorList[$condition->logicalOperator] . ' ';
                  echo zget($fields, $condition->field);
                  echo zget($config->workflowhook->operatorList, $condition->operator);
                  if(strpos($config->workflow->virtualParams, ",$condition->param,") !== false)
                  {
                      echo $lang->workflowhook->options[$condition->param];
                  }
                  else
                  {
                      echo $condition->param;
                  }
              }
          }
          else
          {
              echo $hook->conditions;
          }
          ?>
        </td>
        <td title='<?php echo zget($hook, 'comment', '');?>'><?php echo zget($hook, 'comment', '');?></td>
        <td class='actions'>
          <?php extCommonModel::printLink('workflowhook', 'edit',   "action=$action->id&key=$key", $lang->edit, "class='edit loadInModal iframe'");?>
          <?php extCommonModel::printLink('workflowhook', 'delete', "action=$action->id&key=$key", $lang->delete, "class='deleter reloadModal'");?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.modal.html.php';?>
