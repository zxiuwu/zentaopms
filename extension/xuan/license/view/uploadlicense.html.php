<?php
/**
 * The upload license view of license module of xxb.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Guanxiying
 * @package     license
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<?php if($writable):?>
<div>
  <?php echo $writableTip;?>
</div>
<?php else:?>
<form method='post' enctype='multipart/form-data' id='uploadForm' action='<?php echo inlink('uploadLicense')?>'>
  <div id='responser'></div>
  <div class='input-group'>
    <input type='file' name='file' class='form-control' />
    <div class='input-group-btn'><?php echo html::submitButton($lang->license->uploadLicense);?></div>
  </div>
</form>
<?php endif;?>
<?php include '../../common/view/footer.modal.html.php';?>
