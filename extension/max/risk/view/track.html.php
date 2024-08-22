<?php
/**
 * The track of risk module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuchun Li <liyuchun@cnezsoft.com>
 * @package     risk
 * @version     $Id: track.html.php 4903 2020-09-04 09:32:59Z lyc $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div id="mainContent" class="main-content fade">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->risk->track;?></h2>
    </div>
    <form class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data' id='dataform'>
      <table class="table table-form">
        <tbody>
          <tr>
            <th><?php echo $lang->risk->isChange;?></th>
            <td><?php echo html::radio('isChange', $lang->risk->isChangeList, 0, "onclick=refreshPage(this)");?></td>
            <td></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->name;?></th>
            <td><?php echo html::input('name', $risk->name, "class='form-control'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->category;?></th>
            <td><?php echo html::select('category', $lang->risk->categoryList, $risk->category, "class='form-control chosen'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->strategy;?></th>
            <td><?php echo html::select('strategy', $lang->risk->strategyList, $risk->strategy, "class='form-control chosen'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->impact;?></th>
            <td><?php echo html::select('impact', $lang->risk->impactList, $risk->impact, "class='form-control chosen'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->probability;?></th>
            <td><?php echo html::select('probability', $lang->risk->probabilityList, $risk->probability, "class='form-control chosen'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->rate;?></th>
            <td><?php echo html::input('rate', $risk->rate, "class='form-control'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->pri;?></th>
            <td id='priValue'><?php echo html::select('pri', $lang->risk->priList, $risk->pri, "class='form-control chosen'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->trackedBy;?></th>
            <td><?php echo html::select('trackedBy', $users, $this->app->user->account, "class='form-control chosen'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->trackedDate;?></th>
            <td><?php echo html::input('trackedDate', $risk->trackedDate == '0000-00-00' ? helper::today() : $risk->trackedDate , "class='form-control form-date'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->prevention;?></th>
            <td colspan='2'><?php echo html::textarea('prevention', $risk->prevention, "class='form-control'");?></td>
          </tr>
          <tr class='track hidden'>
            <th><?php echo $lang->risk->resolution;?></th>
            <td colspan='2'><?php echo html::textarea('resolution', $risk->resolution, "class='form-control'");?></td>
          </tr>
          <tr class='not-track'>
            <th><?php echo $lang->comment;?></th>
            <td colspan='2'><?php echo html::textarea('comment', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <td colspan='3' class='form-actions text-center'>
              <?php echo html::submitButton() . html::backButton();?>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
