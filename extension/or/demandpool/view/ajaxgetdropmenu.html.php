<?php js::set('poolID', $poolID);?>
<?php js::set('module', $module);?>
<?php js::set('method', $method);?>
<style>
#navTabs {position: sticky; top: 0; background: #fff; z-index: 950;}
#navTabs>li {padding: 0px 10px; display: inline-block}
#navTabs>li>span {display: inline-block;}
#navTabs>li>a {margin: 0!important; padding: 8px 0px; display: inline-block}

#tabContent {margin-top: 5px; z-index: 900; max-width: 220px}
.demandpoolTree ul {list-style: none; margin: 0}
.demandpoolTree .demandpools>ul {padding-left: 7px;}
.demandpoolTree .demandpools>ul>li>div {display: flex; flex-flow: row nowrap; justify-content: flex-start; align-items: center;}
.demandpoolTree .demandpools>ul>li label {background: rgba(255,255,255,0.5); line-height: unset; color: #838a9d; border: 1px solid #d8d8d8; border-radius: 2px; padding: 1px 4px;}
.demandpoolTree li a i.icon {font-size: 15px !important;}
.demandpoolTree li a i.icon:before {min-width: 16px !important;}
.demandpoolTree li .label {position: unset; margin-bottom: 0;}
.demandpoolTree li>a, div.hide-in-search>a {display: block; padding: 2px 10px 2px 5px; overflow: hidden; line-height: 20px; text-overflow: ellipsis; white-space: nowrap; border-radius: 4px;}
.demandpoolTree .tree li>.list-toggle {line-height: 24px;}
.demandpoolTree .tree li.has-list.open:before {content: unset;}

#swapper li>div.hide-in-search>a:focus, #swapper li>div.hide-in-search>a:hover {color: #838a9d; cursor: default;}
#swapper li > a {margin-top: 4px; margin-bottom: 4px;}
#swapper li {padding-top: 0; padding-bottom: 0;}
#swapper .tree li>.list-toggle {top: -1px;}

#closed {width: 93px; height: 25px; line-height: 25px; background-color: #ddd; color: #3c495c; text-align: center; margin-left: 15px; border-radius: 2px;}
#gray-line {width:230px; height: 1px; margin-left: 10px; margin-bottom:2px; background-color: #ddd;}
</style>
<?php
$demandpoolCounts = array();
$demandpoolNames  = array();
$link         = $this->createLink('demand', 'browse', "poolID=%s");
$tabActive    = '';
$myDemandpools    = 0;
$others       = 0;
$dones        = 0;

$demandpoolCounts['myDemandpool'] = 0;
$demandpoolCounts['others']    = 0;
$demandpoolCounts['closed']    = 0;
foreach($demandpools as $index => $demandpool)
{
    if($demandpool->status != 'closed' and strpos(",{$demandpool->owner},", ",{$this->app->user->account},") !== false) $demandpoolCounts['myDemandpool'] ++;
    if($demandpool->status != 'closed' and strpos(",{$demandpool->owner},", ",{$this->app->user->account},") === false) $demandpoolCounts['others'] ++;
    if($demandpool->status == 'closed') $demandpoolCounts['closed'] ++;
    $demandpoolNames[] = $demandpool->name;
}

$demandpoolsPinYin = common::convert2Pinyin($demandpoolNames);

$myDemandpoolsHtml     = '<ul class="tree tree-angles" data-ride="tree">';
$normalDemandpoolsHtml = '<ul class="tree tree-angles" data-ride="tree">';
$closedDemandpoolsHtml = '<ul class="tree tree-angles" data-ride="tree">';

foreach($demandpools as $index => $demandpool)
{
    $selected    = $demandpool->id == $poolID ? 'selected' : '';
    $demandpoolName = $demandpool->name;

    if($demandpool->status != 'closed' and strpos(",{$demandpool->owner},", ",{$this->app->user->account},") !== false)
    {
        $myDemandpoolsHtml .= '<li>' . html::a(sprintf($link, $demandpool->id), $demandpoolName, '', "class='$selected clickable' title='{$demandpool->name}' data-key='" . zget($demandpoolsPinYin, $demandpool->name, '') . "'") . '</li>';

        if($selected == 'selected') $tabActive = 'myDemandpool';

        $myDemandpools ++;
    }
    else if($demandpool->status != 'closed' and strpos(",{$demandpool->owner},", ",{$this->app->user->account},") === false)
    {
        $normalDemandpoolsHtml .= '<li>' . html::a(sprintf($link, $demandpool->id), $demandpoolName, '', "class='$selected clickable' title='{$demandpool->name}' data-key='" . zget($demandpoolsPinYin, $demandpool->name, '') . "'") . '</li>';

        if($selected == 'selected') $tabActive = 'other';

        $others ++;
    }
    else if($demandpool->status == 'closed')
    {
        $closedDemandpoolsHtml .= '<li>' . html::a(sprintf($link, $demandpool->id), $demandpoolName, '', "class='$selected clickable' title='$demandpool->name' data-key='" . zget($demandpoolsPinYin, $demandpool->name, '') . "'") . '</li>';

        if($selected == 'selected') $tabActive = 'closed';
    }
}
$myDemandpoolsHtml     .= '</ul>';
$normalDemandpoolsHtml .= '</ul>';
$closedDemandpoolsHtml .= '</ul>';
?>

<div class="table-row">
  <div class="table-col col-left">
    <div class='list-group'>
      <?php $tabActive = ($myDemandpools and ($tabActive == 'closed' or $tabActive == 'myDemandpool')) ? 'myDemandpool' : 'other';?>
      <?php if($myDemandpools): ?>
      <ul class="nav nav-tabs  nav-tabs-primary" id="navTabs">
        <li class="<?php if($tabActive == 'myDemandpool') echo 'active';?>"><?php echo html::a('#myDemandpool', $lang->demandpool->myDemand, '', "data-toggle='tab' class='not-list-item not-clear-menu'");?><span class="label label-light label-badge"><?php echo $myDemandpools;?></span><li>
        <li class="<?php if($tabActive == 'other') echo 'active';?>"><?php echo html::a('#other', $lang->demandpool->other, '', "data-toggle='tab' class='not-list-item not-clear-menu'")?><span class="label label-light label-badge"><?php echo $others;?></span><li>
      </ul>
      <?php endif;?>
      <div class="tab-content demandpoolTree" id="tabContent">
        <div class="tab-pane demandpools <?php if($tabActive == 'myDemandpool') echo 'active';?>" id="myDemandpool">
          <?php echo $myDemandpoolsHtml;?>
        </div>
        <div class="tab-pane demandpools <?php if($tabActive == 'other') echo 'active';?>" id="other">
          <?php echo $normalDemandpoolsHtml;?>
        </div>
      </div>
    </div>
    <div class="col-footer">
      <?php //echo html::a(helper::createLink('demandpool', 'browse', 'programID=0&browseType=all'), '<i class="icon icon-cards-view muted"></i> ' . $lang->demandpool->all, '', 'class="not-list-item"'); ?>
      <a class='pull-right toggle-right-col not-list-item'><?php echo $lang->demandpool->doneDemands?><i class='icon icon-angle-right'></i></a>
    </div>
  </div>
  <div id="gray-line" hidden></div>
  <div id="closed" hidden><?php echo $lang->demandpool->closedDemandpool?></div>
  <div class="table-col col-right demandpoolTree">
   <div class='list-group demandpools'><?php echo $closedDemandpoolsHtml;?></div>
  </div>
</div>
<script>scrollToSelected();</script>
<script>
$(function()
{
    $('.nav-tabs li span').hide();
    $('.nav-tabs li.active').find('span').show();

    $('.nav-tabs>li a').click(function()
    {
        if($('#swapper input[type="search"]').val() == '')
        {
            $(this).siblings().show();
            $(this).parent().siblings('li').find('span').hide();
        }
    })

    $('#swapper [data-ride="tree"]').tree('expand');

    $('#swapper #dropMenu .search-box').on('onSearchChange', function(event, value)
    {
        if(value != '')
        {
            $('div.hide-in-search').siblings('i').addClass('hide-in-search');
            $('.nav-tabs li span').hide();
        }
        else
        {
            $('div.hide-in-search').siblings('i').removeClass('hide-in-search');
            $('li.has-list div.hide-in-search').removeClass('hidden');
            $('.nav-tabs li.active').find('span').show();
        }
        if($('.form-control.search-input').val().length > 0)
        {
            $('#closed').attr("hidden", false);
            $('#gray-line').attr("hidden", false);
        }
        else
        {
            $('#closed').attr("hidden", true);
            $('#gray-line').attr("hidden", true);
        }
    });

    $('#swapper #dropMenu').on('onSearchComplete', function(event, value)
    {
        if($('.list-group.demandpools').height() == 0)
        {
            $('#closed').attr("hidden", true);
            $('#gray-line').attr("hidden", true);
        }
    });
})
</script>
