<?php
/**
 * The browse view file of client module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Memory <lvtao@cnezsoft.com>
 * @package     client
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/marked.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->client->browse?></strong>
    <div class='pull-right panel-actions'>
      <?php commonModel::printLink('client', 'checkUpgrade', '', $lang->client->checkUpgrade, 'class="btn btn-primary"');?>
      <?php commonModel::printLink('client', 'create', '', "<i class='icon icon-plus'> ". $lang->client->create . "</i>", 'class="btn btn-primary" data-toggle="modal"');?>
    </div>
  </div>
  <table class='table table-hover'>
    <thead>
      <tr>
        <th class="w-80px text-center"><?php echo $lang->client->id?></th>
        <th class="w-150px text-center"><?php echo $lang->client->version?></th>
        <th class="text-left"><?php echo $lang->client->desc?></th>
        <th class="w-150px text-center"><?php echo $lang->client->strategy?></th>
        <th class="w-150px text-center"><?php echo $lang->client->releaseStatus?></th>
        <th class="w-150px text-center"><?php echo $lang->actions?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($clients as $client):?>
    <tr class="text-center">
      <td><?php echo $client->id?></td>
      <td><?php echo $client->version?></td>
      <td class="text-left" title='<?php echo $client->desc;?>'><?php echo $client->desc?></td>
      <td><?php echo $lang->client->strategies[$client->strategy]?></td>
      <td><?php echo $lang->client->status[$client->status]?></td>
      <td>
        <?php if(empty($client->changeLog)):?>
        <a class='disabled'><?php echo $lang->client->changeLog;?></a>
        <?php else:?>
        <?php commonModel::printLink('client', 'changelog', "id={$client->id}", $lang->client->changeLog, "data-toggle='modal' data-title='{$lang->client->changeLog} {$client->version}' data-size='lg'");?>
        <?php endif;?>
        <?php commonModel::printLink('client', 'edit', "id={$client->id}", $lang->edit, "data-toggle='modal'");?>
        <?php commonModel::printLink('client', 'delete', "id={$client->id}", $lang->delete, "class='deleter'");?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
