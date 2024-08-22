<?php
/**
 * The auto backup view file of instance module of QuCheng.
 *
 * @copyright Copyright 2021-2022 北京渠成软件有限公司(BeiJing QurCheng Software Co,LTD, www.qucheng.cn)
 * @license   ZPL (http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author    Jianhua Wang <wangjianhua@easycorp.ltd>
 * @package   instance
 * @version   $Id$
 * @link      https://www.qucheng.cn
 */
?>
<?php include $this->app->getModuleRoot() . '/common/view/header.html.php';?>
<?php include $this->app->getModuleRoot() . '/common/view/datepicker.html.php';?>
<?php js::set('instanceNotices', $lang->instance->notices);?>
<?php js::set('instanceID', $instance->id);?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2><?php echo $lang->instance->backup->autoBackup;?></h2>
    </div>
    <div>
      <form id='backupSettingForm' method='post' class="cell not-watch load-indicator main-form">
        <h4><?php echo html::checkbox('autoBackup', array('true' => $lang->instance->backup->enableAutoBackup), $backupSettings->autoBackup ? 'true' : '');?></h4>
        <table class="table table-form backup-settings">
          <tbody>
            <tr>
              <th><?php echo $lang->instance->backup->backupTime;?></th>
              <td class='required'>
                <div class='input-group'>
                  <div class='datepicker-wrapper datepicker-date'>
                  <?php echo html::input('backupTime', $backupSettings->backupTime, "class='form-control form-time' data-picker-position='bottom-right' maxlength='20'");?>
                  </div>
                </div>
              </td>
              <td></td>
            </tr>
            <tr>
              <th class='w-80px'><?php echo $lang->instance->backup->cycleDays;?></th>
              <td class='required w-250px'>
                <div class='input-group'><?php echo html::select('cycleDays', $lang->instance->backup->cycleList, $backupSettings->cycleDays, "class='form-control' maxlength='20'");?></div>
              </td>
              <td></td>
            </tr>
            <tr>
              <th><?php echo $lang->instance->backup->keepDays;?></th>
              <td class='required'>
                <div class='input-group'><?php echo html::number('keepDays', $backupSettings->keepDays, "class='form-control' maxlength='2' min='1' max='30'");?></div>
                <span><?php echo $lang->instance->backup->keepDayRange;?></span>
              </td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <div class="text-center form-actions"><?php echo html::commonButton($lang->save, "id='saveSetting'", 'btn btn-primary');?></div>
      </form>
    </div>
</div>
<?php include $this->app->getModuleRoot() . '/common/view/footer.html.php';?>
