<?php
/**
 * The create view file of holiday module of ZenTao.
 *
 * @copyright   Copyright 2009-2018 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     holiday
 * @version     $Id$
 * @link        https://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<style>form{margin: 40px 0px}</style>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2>
        <?php echo $lang->holiday->create;?>
      </h2>
    </div>
    <form class='form-ajax' method='post'>
      <table class='table table-form table-condensed'>
        <tr>
          <th class='w-120px'><?php echo $lang->holiday->type;?></th>
          <td><?php echo html::radio('type', $lang->holiday->typeList, 'holiday');?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->holiday->begin;?></th>
          <td><?php echo html::input('begin', '', "class='form-control form-date' required");?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->holiday->end;?></th>
          <td><?php echo html::input('end', '', "class='form-control form-date' required");?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->holiday->name;?></th>
          <td><?php echo html::input('name', '', "class='form-control' required");?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->holiday->desc?></th>
          <td><?php echo html::textarea('desc', '', "class='form-control'")?></td>
          <td></td>
        </tr>
        <tr><th></th><td colspan='2'><?php echo baseHTML::submitButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
