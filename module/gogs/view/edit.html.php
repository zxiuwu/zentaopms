<?php
/**
 * The edit view file of gogs module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2017 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     gogs
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainContent' class='main-row'>
  <div class='main-col main-content'>
    <div class='center-block'>
      <div class='main-header'>
        <h2><?php echo $lang->gogs->edit;?></h2>
      </div>
      <form id='gogsForm' method='post' class='form-ajax'>
        <table class='table table-form'>
          <tr>
            <th><?php echo $lang->gogs->name;?></th>
            <td class='required'><?php echo html::input('name', isset($gogs->name) ? $gogs->name : '', "class='form-control'");?></td>
            <td class="tips-git"></td>
          </tr>
          <tr>
            <th><?php echo $lang->gogs->url;?></th>
            <td class='required'><?php echo html::input('url', isset($gogs->url) ? $gogs->url : '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->gogs->token;?></th>
            <td><?php echo html::input('token', isset($gogs->token) ? $gogs->token : '', "class='form-control'");?></td>
          </tr>
          <tr>
            <td colspan='2' class='text-center form-actions'>
              <?php echo html::submitButton();?>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
