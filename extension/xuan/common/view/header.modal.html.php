<?php
/**
 * The header.modal view of common module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php if(helper::isAjaxRequest()):?>
<?php
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
$modalSizeList = array('lg' => '900px', 'sm' => '300px');
if(!isset($modalWidth)) $modalWidth = 700;
if(is_numeric($modalWidth))
{
    $modalWidth .= 'px';
}
else if(isset($modalSizeList[$modalWidth]))
{
    $modalWidth = $modalSizeList[$modalWidth];
}
if(isset($pageCSS)) css::internal($pageCSS);

/* set requiredField. */
if(isset($config->$moduleName->require->$methodName))
{
    $requiredFields = str_replace(' ', '', $config->$moduleName->require->$methodName);
}
?>
<div class="modal-dialog" style="width:<?php echo $modalWidth;?>;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <strong class="modal-title"><?php if(!empty($title)) echo $title; ?></strong>
      <?php if(!empty($subtitle)) echo "<label class='text-important'>" . $subtitle . '</label>'; ?>
    </div>
    <div class="modal-body">
<?php else:?>
<?php include $this->app->getModuleRoot() . 'common/view/header.lite.html.php';?>
<?php endif;?>
