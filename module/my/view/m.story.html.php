<?php
/**
 * The story browse mobile view file of my module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2016 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Fei Chen <chenfei@cnezsoft.com>
 * @package     my
 * @version     $Id: index.html.php 3830 2016-05-18 09:34:17Z liugang $
 * @link        http://www.zentao.net
 */
?>

<?php
$bodyClass = 'with-menu-top';
include "../../common/view/m.header.html.php";
?>

<nav id='menu' class='menu nav affix dock-top canvas'>
  <?php
  echo html::a(inlink('story', "type=assignedTo"),  $lang->my->storyMenu->assignedToMe);
  echo html::a(inlink('story', "type=openedBy"),    $lang->my->storyMenu->openedByMe);
  echo html::a(inlink('story', "type=reviewedBy"),  $lang->my->storyMenu->reviewedByMe);
  echo html::a(inlink('story', "type=closedBy"),    $lang->my->storyMenu->closedByMe);
  ?>
  <a class='moreMenu hidden' data-display='dropdown' data-placement='beside-bottom'><?php echo $lang->more;?></a>
  <div id='moreMenu' class='list dropdown-menu'></div>
</nav>

<div class='heading'>
  <div class='title'>
    <a id='sortTrigger' class='text-right sort-trigger' data-display data-target='#sortPanel' data-backdrop='true'><i class='icon icon-sort'></i>&nbsp;<span class='sort-name'><?php echo $lang->sort ?></span></a>
  </div>
</div>

<section id='page' class='section list-with-actions list-with-pager'>
  <?php $refreshUrl = $this->createLink('my', 'story', "type={$type}&orderBy=$orderBy&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}");?>
  <div class='box' data-page='<?php echo $pager->pageID;?>' data-refresh-url='<?php echo $refreshUrl;?>'>
    <table class='table bordered'>
      <thead>
        <tr>
          <th><?php echo $lang->story->title;?> </th>
          <th class='text-center w-80px'><?php echo $lang->statusAB;?> </th>
          <th class='text-center w-80px'><?php echo $lang->story->stage;?> </th>
        </tr>
      </thead>
      <?php foreach($stories as $story):?>
      <tr class='text-center' data-url='<?php echo $this->createLink('story', 'view', "storyID={$story->id}");?>' data-id='<?php echo $story->id;?>'>
        <td class='text-left'><?php echo $story->title;?></td>
        <td class='story-<?php echo $story->status?>'><?php echo $lang->story->statusList[$story->status];?></td>
        <td><?php echo zget($lang->story->stageList, $story->stage);?></td>
      </tr>
      <?php endforeach;?>
    </table>
  </div>

  <nav class='nav justify pager'>
    <?php $pager->show($align = 'justify');?>
  </nav>
</section>

<div class='list sort-panel hidden affix enter-from-bottom layer' id='sortPanel'>
  <?php
  $vars = "type={$type}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";
  $sortOrders = array('id', 'pri', 'title', 'assignedTo', 'estimate', 'status', 'stage', 'openedBy');
  foreach ($sortOrders as $sortOrder)
  {
      commonModel::printOrderLink($sortOrder, $orderBy, $vars, '<i class="icon icon-sort-indicator"></i>' . ($lang->story->{$sortOrder}));
  }
  ?>
</div>

<script>
$('#menu > a').removeClass('active').filter('[href*="<?php echo $type ?>"]').addClass('active');
</script>
<?php include "../../common/view/m.footer.html.php"; ?>
