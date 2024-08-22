<?php
/**
 * The html template file of confirm method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id: confirm.html.php 4129 2013-01-18 01:58:14Z wwccss $
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<?php js::set('writable', $writable);?>
<div class='container'>
  <form method='post' onsubmit="submit.disabled=1">
    <div class='modal-dialog'>
      <div class='modal-header'>
        <strong><?php echo $lang->upgrade->confirm;?></strong>
      </div>
      <div class='modal-body'>
        <textarea rows='20' class='form-control' readonly='readonly'><?php echo $confirm;?></textarea>
      </div>
      <div class='modal-footer'>
        <?php echo html::submitButton($lang->upgrade->sureExecute) . html::hidden('fromVersion', $fromVersion);?>
        <p style='margin-top:10px;' class='text-danger hidden' id='upgradingTips'><?php echo $lang->upgrade->upgradingTips;?></p>
      </div>
    </div>
  </form>
</div>
<div class="modal fade" id='progress'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h1 class='title'>1%</h1>
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
          </div>
        </div>
        <span><?php echo $lang->upgrade->upgradingTip;?></span>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
