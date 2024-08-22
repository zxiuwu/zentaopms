<?php
/**
 * The html productlist file of productlist method of product module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/sortable.html.php';?>
<?php $app->loadLang('roadmap');?>
<?php js::set('productLines', $productLines); ?>
<?php $canBatchEdit = common::hasPriv('product', 'batchEdit'); ?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolBar pull-left">
    <?php common::sortFeatureMenu();?>
    <?php foreach($lang->product->featureBar['all'] as $key => $label):?>
    <?php $recTotalLabel = $browseType == $key ? " <span class='label label-light label-badge'>{$recTotal}</span>" : '';?>
    <?php echo html::a(inlink("all", "browseType=$key&orderBy=$orderBy"), "<span class='text'>{$label}</span>" . $recTotalLabel, '', "class='btn btn-link' id='{$key}Tab'");?>
    <?php endforeach;?>
    <?php if($canBatchEdit) echo html::checkbox('showEdit', array('1' => $lang->product->edit), $showBatchEdit);?>
    <a class="btn btn-link querybox-toggle" id='bysearchTab'><i class="icon icon-search muted"></i> <?php echo $lang->product->searchStory;?></a>
  </div>
  <div class="btn-toolbar pull-right">
    <?php common::printLink('product', 'export', "status=$browseType&orderBy=$orderBy", "<i class='icon-export muted'> </i>" . $lang->export, '', "class='btn btn-link export'", true, true)?>
    <?php common::printLink('product', 'create', '', '<i class="icon icon-plus"></i>' . $lang->product->create, '', 'class="btn btn-primary create-product-btn"');?>
  </div>
</div>
<div id="mainContent" class="main-row fade">
  <?php if(empty($productStructure)):?>
  <div class="cell<?php if($browseType == 'bySearch') echo ' show';?>" id="queryBox" data-module='product'></div>
  <div class="table-empty-tip">
    <p><span class="text-muted"><?php echo $lang->product->noProduct;?></span></p>
  </div>
  <?php else:?>
  <div class="main-col">
    <div class="cell<?php if($browseType == 'bySearch') echo ' show';?>" id="queryBox" data-module='product'></div>
    <form class="main-table table-product" data-ride="table" data-nested='true' id="productListForm" method="post" action='<?php echo inLink('batchEdit', '');?>' data-preserve-nested='true' data-expand-nest-child='true'>
      <table id="productList" class="table has-sort-head table-nested table-fixed">
        <?php $vars = "browseType=$browseType&orderBy=%s";?>
        <thead>
          <tr class="text-center">
            <?php if($canBatchEdit):?>
            <th class='text-left c-checkbox' rowspan="2">
              <?php echo "<div class='checkbox-primary check-all' title='{$this->lang->selectAll}'><label></label></div>";?>
            </th>
            <?php endif;?>
            <th class='table-nest-title text-left c-name' rowspan="2">
              <?php if($config->systemMode == 'ALM'):?>
              <a class='table-nest-toggle table-nest-toggle-global' data-expand-text='<?php echo $lang->expand; ?>' data-collapse-text='<?php echo $lang->collapse; ?>'></a>
              <?php endif;?>
              <?php common::printOrderLink('name', $orderBy, $vars, $lang->product->name);?>
            </th>
            <th class='c-PO' rowspan="2">
              <?php common::printOrderLink('PMT', $orderBy, $vars, $lang->product->PMT);?>
            </th>
            <th class='c-PO' rowspan="2">
              <?php common::printOrderLink('type', $orderBy, $vars, $lang->product->type);?>
            </th>
            <th class="c-roadmap" colspan="2"><?php echo $lang->roadmap->common;?></th>
            <th class="c-story" colspan="4"><?php echo $lang->story->requirement;?></th>
            <?php
            $extendFields = $this->product->getFlowExtendFields();
            foreach($extendFields as $extendField) echo "<th rowspan='2'>{$extendField->name}</th>";
            ?>
            <th class='c-actions' rowspan="2"><?php echo $lang->actions;?></th>
          </tr>
          <tr class="text-center">
            <th style="border-left: 1px solid #ddd;"><?php echo $lang->roadmap->statusList['wait'];?></th>
            <th><?php echo $lang->roadmap->statusList['launched'];?></th>
            <th style="border-left: 1px solid #ddd;"><?php echo $lang->story->draft;?></th>
            <th><?php echo $lang->story->activate;?></th>
            <th><?php echo $lang->story->statusList['launched'];?></th>
            <th><?php echo $lang->story->statusList['developing'];?></th>
          </tr>
        </thead>
        <tbody id="productTableList">
        <?php $lineNames = array();?>
        <?php foreach($productStructure as $programID => $program):?>
        <?php
        $trAttrs  = "data-id='program.$programID' data-parent='0' data-nested='true'";
        $trClass  = 'is-top-level table-nest-child text-center';
        $trAttrs .= " class='$trClass'";
        ?>
          <?php
          if(isset($programLines[$programID]))
          {
              foreach($programLines[$programID] as $lineID => $lineName)
              {
                  if(!isset($program[$lineID]))
                  {
                      $program[$lineID] = array();
                      $program[$lineID]['product']  = '';
                      $program[$lineID]['lineName'] = $lineName;
                  }
              }
          }
          ?>
          <?php if(isset($program['programName']) and $config->systemMode == 'ALM'):?>
          <tr class="row-program" <?php echo $trAttrs;?>>
            <?php if($canBatchEdit):?>
            <td class='c-checkbox'><div class='checkbox-primary program-checkbox'><label></label></div></td>
            <?php endif;?>
            <td class='text-left table-nest-title' title="<?php echo $program['programName']?>">
              <i class="table-nest-icon icon table-nest-toggle icon-plus"></i>
              <i class="icon icon-cards-view"></i>
              <span><?php echo $program['programName']?></span>
            </td>
            <td class='c-manager'>
              <?php
              if(!empty($program['programPM']))
              {
                  $programPM = $program['programPM'];
                  $userName  = zget($users, $programPM);
                  echo html::smallAvatar(array('avatar' => $usersAvatar[$programPM], 'account' => $programPM, 'name' => $userName), 'avatar-circle avatar-top avatar-' . zget($userIdPairs, $programPM));

                  $userID = isset($userIdPairs[$programPM]) ? $userIdPairs[$programPM] : '';
                  echo html::a($this->createLink('user', 'profile', "userID=$userID", '', true), $userName, '', "title='{$userName}' class='iframe' data-width='600'");
              }
              ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $program['draftRequirements'];?></td>
            <td><?php echo $program['activeRequirements'];?></td>
            <td><?php echo $program['launchedRequirements'];?></td>
            <td><?php echo $program['developingRequirements'];?></td>
            <?php foreach($extendFields as $extendField) echo "<td></td>";?>
            <td></td>
          </tr>
          <?php unset($program['programName']);?>
          <?php endif;?>

          <?php foreach($program as $lineID => $line):?>
          <?php if(isset($line['lineName']) and isset($line['products']) and is_array($line['products']) and $config->systemMode == 'ALM'):?>
          <?php $lineNames[] = $line['lineName'];?>
          <?php
          if($this->config->systemMode == 'ALM' and $programID)
          {
              $trAttrs  = "data-id='line.$lineID' data-parent='program.$programID'";
              $trAttrs .= " data-nest-parent='program.$programID' data-nest-path='program.$programID,line.$lineID'" . "class='text-center'";
          }
          else
          {
              $trAttrs  = "data-id='line.$lineID' data-parent='0' data-nested='true'";
              $trClass  = 'is-top-level table-nest-child text-center';
              $trAttrs .= " class='$trClass'";
          }
          ?>
          <tr class="row-line" <?php echo $trAttrs;?>>
            <?php if($canBatchEdit):?>
            <td class='c-checkbox'><div class='checkbox-primary program-checkbox'><label></label></div></td>
            <?php endif;?>
            <td class='text-left table-nest-title' title="<?php echo $line['lineName']?>">
              <span class="table-nest-icon icon table-nest-toggle"></span>
              <?php echo $line['lineName']?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo isset($line['draftRequirements']) ? $line['draftRequirements'] : 0;?></td>
            <td><?php echo isset($line['activeRequirements']) ? $line['activeRequirements'] : 0;?></td>
            <td><?php echo isset($line['launchedRequirements']) ? $line['launchedRequirements'] : 0;?></td>
            <td><?php echo isset($line['developingRequirements']) ? $line['developingRequirements'] : 0;?></td>
            <?php foreach($extendFields as $extendField) echo "<td></td>";?>
            <td></td>
          </tr>
          <?php unset($line['lineName']);?>
          <?php endif;?>

          <?php if(isset($line['products']) and is_array($line['products'])):?>
          <?php foreach($line['products'] as $productID => $product):?>
          <?php

          $trClass = '';
          if($product->line and $this->config->systemMode == 'ALM')
          {
              $path = "line.$product->line,$product->id";
              if($this->config->systemMode == 'ALM' and $product->program) $path = "program.$product->program,$path";
              $trAttrs  = "data-id='$product->id' data-parent='line.$product->line'";
              $trClass .= ' is-nest-child  table-nest';
              $trAttrs .= " data-nest-parent='line.$product->line' data-nest-path='$path'";
          }
          elseif($product->program and $this->config->systemMode == 'ALM')
          {
              $trAttrs  = "data-id='$product->id' data-parent='program.$product->program'";
              $trClass .= ' is-nest-child  table-nest';
              $trAttrs .= " data-nest-parent='program.$product->program' data-nest-path='program.$product->program,$product->id'";
          }
          else
          {
              $trAttrs  = "data-id='$product->id' data-parent='0'";
              $trClass .= ' no-nest';
          }
          $trAttrs .= " class='$trClass'";
          ?>
          <tr class="row-product" <?php echo $trAttrs;?>>
            <?php if($canBatchEdit):?>
            <td class='c-checkbox'><?php echo html::checkbox('productIDList', array($product->id => ''));?></td>
            <?php endif;?>
            <td class="c-name text-left sort-handler table-nest-title" title='<?php echo $product->name?>'>
              <?php
              echo html::a($this->createLink('product', 'browse', 'productID=' . $product->id . '&branch=&browseType=&param=0&storyType=requirement'), $product->name);
              ?>
            </td>
            <?php
            $PMTList = '';
            foreach(explode(',', $product->PMT) as $PMT) $PMTList .= zget($users, $PMT) . "&nbsp;";
            ?>
            <td class='c-manager' title=<?php echo $PMTList;?>>
              <?php echo $PMTList;?>
            </td>
            <td><?php echo zget($lang->product->typeList, $product->type, '');?></td>
            <td><?php echo isset($roadmapGroup[$product->id]['wait']->count)     ? $roadmapGroup[$product->id]['wait']->count     : 0;?></td>
            <td><?php echo isset($roadmapGroup[$product->id]['launched']->count) ? $roadmapGroup[$product->id]['launched']->count : 0;?></td>
            <td><?php echo $product->draftStories;?></td>
            <td><?php echo $product->activeStories;?></td>
            <td><?php echo $product->launchedStories;?></td>
            <td><?php echo $product->developingStories;?></td>
            <?php foreach($extendFields as $extendField) echo "<td>" . $this->loadModel('flow')->getFieldValue($extendField, $product) . "</td>";?>
            <td class='c-actions'><?php echo $this->product->buildOperateMenu($product, 'browse');?></td>
          </tr>
          <?php endforeach;?>
          <?php endif;?>
          <?php endforeach;?>
        <?php endforeach;?>
        </tbody>
      </table>
      <div class='table-footer'>
        <?php echo $pager->show('left', 'pagerjs');?>
        <?php if(!empty($product) and $canBatchEdit):?>
        <div class="checkbox-primary check-all"><label><?php echo $lang->selectAll?></label></div>
        <?php
        $summary = (empty($productLines) or $this->config->systemMode == 'light') ? sprintf($lang->product->pageSummary, count($productStats)) : sprintf($lang->product->lineSummary, count($lineNames), count($productStats));
        echo "<div id='productsCount' class='statistic'>$summary</div>";
        ?>
        <div class="table-actions btn-toolbar">
          <?php
          $actionLink = $this->createLink('product', 'batchEdit');
          echo html::commonButton($lang->edit, "id='editBtn' data-form-action='$actionLink'");
          ?>
        </div>
        <?php endif;?>
      </div>
    </form>
  </div>
  <?php endif;?>
</div>
<?php js::set('orderBy', $orderBy)?>
<?php js::set('browseType', $browseType)?>
<?php js::set('checkedProducts', $lang->product->checkedProducts);?>
<?php js::set('cilentLang', $this->app->getClientLang());?>
<?php if(commonModel::isTutorialMode()): ?>
<style>
#productListForm {overflow: hidden;}
#productList .table-nest-title {width: 200px;}
</style>
<?php endif; ?>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
