<?php
/**
 * The mail file of deploy module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     deploy
 * @version     $Id: sendmail.html.php 4626 2013-04-10 05:34:36Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php $mailTitle = $this->lang->deploy->common . ' #' . $deploy->id . ' ' . substr($deploy->begin, 0, 16) . ' ~ ' . substr($deploy->end, 0, 16) . ' ' . $deploy->name;?>
<?php include $this->app->getModuleRoot() . 'common/view/mail.header.html.php';?>
<tr>
  <td>
    <table cellpadding='0' cellspacing='0' width='600' style='border: none; border-collapse: collapse;'>
      <tr>
        <td style='padding: 10px; background-color: #F8FAFE; border: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid #e5e5e5;'><?php echo html::a(zget($this->config->mail, 'domain', common::getSysURL()) . helper::createLink('deploy', 'view', "deployID=$deploy->id"), $mailTitle, '', "style='color: #333; text-decoration: underline;'");?></td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td style='padding: 10px; border: none;'>
    <fieldset style='border: 1px solid #e5e5e5'>
      <legend style='color: #114f8e'><?php echo $this->lang->deploy->desc;?></legend>
      <div style='padding:5px;'><?php echo $deploy->desc;?></div>
    </fieldset>
  </td>
</tr>
<?php include $this->app->getModuleRoot() . 'common/view/mail.footer.html.php';?>
