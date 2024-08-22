<?php
/**
 * The report view file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: report.html.php 4657 2013-04-17 02:01:26Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php echo html::a($this->createLink('bug', 'browse', "productID=$productID&branch=0&browseType=$browseType&moduleID=$moduleID"), "<i class='icon icon-back icon-sm'> </i> " . $lang->goback, '', "class='btn btn-link'");?>
    <div class='divider'></div>
    <div class='page-title'>
      <span class='text'><?php echo $lang->bug->report->common;?></span>
    </div>
  </div>
</div>
<div id="mainContent" class='main-row'>
  <div class='side-col col-lg'>
    <div class='panel'>
      <div class='panel-heading'>
        <div class='panel-title'><?php echo $lang->bug->report->select;?></div>
      </div>
      <div class='panel-body'>
        <form method='post' id='chartTypesForm' class='no-stash'>
          <div class='checkboxes'>
            <?php echo html::checkBox('charts', $lang->bug->report->charts, $checkedCharts, '', 'block');?>
          </div>
          <div class='btn-toolbar'>
            <?php echo html::selectAll();?>
            <?php echo html::submitButton($lang->bug->report->create, '', 'btn btn-primary');?>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class='main-col'>
    <div class='cell'>
      <div class='btn-toolbar'>
        <?php foreach($lang->report->typeList as $type => $typeName):?>
        <?php echo html::a("javascript:changeChartType(\"$type\")", ($type == 'default' ? "<i class='icon icon-list-alt muted'></i> " : "<i class='icon icon-chart-{$type} muted'></i>") . $typeName, '', "class='btn btn-link " . ($type == $chartType ? 'btn-active-line' : '') . "'")?>
        <?php endforeach;?>
      </div>
      <div class='text-muted' style='padding-top:5px'><?php echo str_replace('%tab%', $lang->bug->unclosed . $lang->bug->common, $lang->report->notice->help);?></div>
      <?php foreach($charts as $chartType => $chartOption):?>
      <div class='table-row chart-row'>
        <div class='main-col'>
          <div class='chart-wrapper text-center'>
            <h4><?php echo $lang->bug->report->charts[$chartType];?></h4>
            <div class='chart-canvas'><canvas id='chart-<?php echo $chartType ?>' width='<?php echo $chartOption->width;?>' height='<?php echo $chartOption->height;?>' data-responsive='true'></canvas></div>
          </div>
        </div>
        <div class='side-col col-xl'>
          <div style="overflow:auto;" class='table-wrapper'>
            <table class='table table-condensed table-hover table-striped table-bordered table-chart' data-chart='<?php echo $chartOption->type; ?>' data-target='#chart-<?php echo $chartType ?>' data-animation='false'>
              <thead>
                <tr>
                  <th class='chart-label' colspan='2'><?php echo $lang->report->item;?></th>
                  <th class='w-50px text-right'><?php echo $lang->report->value;?></th>
                  <th class='w-60px text-right'><?php echo $lang->report->percent;?></th>
                </tr>
              </thead>
              <?php
              $colorList = array();
              if(strpos(strtolower($chartType), 'pri') !== false)
              {
                  $colorList = $config->bug->colorList->pri;
              }
              elseif(strpos(strtolower($chartType), 'severity') !== false)
              {
                  $colorList = $config->bug->colorList->severity;
              }
              ?>
              <?php foreach($datas[$chartType] as $key => $data):?>
              <tr data-color="<?php echo !empty($colorList) ? zget($colorList, $key, '#C0C0C0') : '';?>">
                <td class='chart-color'><i class='chart-color-dot'></i></td>
                <td class='chart-label text-left' title='<?php echo isset($data->title) ? $data->title : $data->name;?>'><?php echo $data->name;?></td>
                <td class='chart-value text-right'><?php echo $data->value;?></td>
                <td class='text-right'><?php echo ($data->percent * 100) . '%';?></td>
              </tr>
              <?php endforeach;?>
            </table>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php js::set('productID', $productID);?>
<?php js::set('browseType', $browseType);?>
<?php js::set('branchID', $branchID);?>
<?php js::set('moduleID', $moduleID);?>
<?php include '../../common/view/footer.html.php';?>
