<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div id="mainContent" class="main-content fade">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->roadmap->create;?></h2>
    </div>
    <form class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data' id='dataform'>
      <table class="table table-form">
        <tbody>
          <?php if($branches):?>
          <tr>
            <th><?php echo sprintf($lang->roadmap->branch, $lang->product->branchName[$product->type]);?></th>
            <td><?php echo html::select('branch', $branches, '', "class='form-control chosen'");?></td>
          </tr>
          <?php endif;?>
          <tr>
            <th><?php echo $lang->roadmap->name;?></th>
            <td><?php echo html::input('name', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->roadmap->begin;?></th>
            <td><?php echo html::input('begin', '', "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->roadmap->end;?></th>
            <td><?php echo html::input('end', '', "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->roadmap->desc;?></th>
            <td colspan='3'><?php echo html::textarea('desc', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <td class='form-actions text-center' colspan='4'>
            <?php echo html::submitButton();?>
            <?php echo html::backButton();?>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
