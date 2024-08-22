<?php
/**
 * The browse view file of makeup module of RanZhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     makeup
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.lite.html.php';?>
<?php js::set('confirmReview', $lang->makeup->confirmReview)?>
<?php $batchReview = $type == 'browseReview' && commonModel::hasPriv('makeup', 'batchReview');?>
<div class='panel xuanxuan-card'>
<?php $batchReview = false;?>
  <?php if($batchReview):?>
  <form id='ajaxForm' method='post' action='<?php echo inlink('batchReview', 'status=pass');?>'>
  <?php endif;?>
  <table class='table table-hover text-center table-fixed tablesorter' id='makeupTable'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "&date={$date}&orderBy=%s";?>
        <?php if($batchReview):?>
        <th class='w-50px'><?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->makeup->id);?></th>
        <?php endif;?>
        <th class='w-80px'><?php commonModel::printOrderLink('createdBy', $orderBy, $vars, $lang->makeup->createdBy);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('begin', $orderBy, $vars, $lang->makeup->begin);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('end', $orderBy, $vars, $lang->makeup->end);?></th>
        <th class='text-left'><?php echo $lang->makeup->desc;?></th>
      </tr>
    </thead>
    <?php foreach($makeupList as $makeup):?>
    <?php $viewUrl = commonModel::hasPriv('leave', 'view') ? $this->createLink('leave', 'view', "id=$makeup->id&type=$type") : '';?>
    <tr id='makeup<?php echo $makeup->id;?>' >
      <?php if($batchReview):?>
      <td class='idTD'>
        <label class='checkbox-inline'><input type='checkbox' name='makeupIDList[]' value='<?php echo $makeup->id;?>'/> <?php echo $makeup->id;?></label>
      </td>
      <?php endif;?>
      <td><?php echo zget($users, $makeup->createdBy);?></td>
      <td><?php echo formatTime($makeup->begin . ' ' . $makeup->start, DT_DATETIME2);?></td>
      <td><?php echo formatTime($makeup->end . ' ' . $makeup->finish, DT_DATETIME2);?></td>
      <td class='text-left' title='<?php echo $makeup->desc?>'><?php echo $makeup->desc;?></td>
    </tr>
    <?php endforeach;?>
  </table>
  <?php if($makeupList && $batchReview):?>
  <?php endif;?>
  <?php if(!$makeupList):?>
  <?php endif;?>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
