<form target="hiddenwin" method="post" name='ajaxAddMeasures' action="<?php echo $this->createLink('milestone','ajaxAddMeasures');?>">
  <table class="table table-bordered">
    <tbody>
      <?php if(count($measures)):?>
      <?php $totalMeasures = count($measures);?>
      <?php $delOrigin = 'id="delOrigin"';?>
      <?php foreach($measures as $item):?>
      <tr>
        <?php if($totalMeasures):?>
        <td rowspan="<?php echo $totalMeasures;?>" class="text-center" id="measuresTd"><strong><?php echo $lang->milestone->corrective;?></strong></td>
        <?php endif;?>
        <td colspan="6">
        <?php echo html::input('measures[]', $item, 'class="form-control measures-input" onchange="submitMeasurse()";');?>
        <?php echo html::a('javascript:;', '<i class="icon icon-plus"></i>', '', 'class="btn btn-link addItem" onclick="addItem(this)"');?>
        <?php echo html::a('javascript:;', '<i class="icon icon-close"></i>', '', 'class="btn btn-link delItem" onclick="delItem(this)"' . $delOrigin);?>
        <?php echo html::submitButton();?>
        <?php $totalMeasures = 0;?>
        <?php $delOrigin     = '';?>
        </td>
      </tr>
      <?php endforeach;?>
      <?php else:?>
      <tr>
        <td rowspan="1" class="text-center" id="measuresTd"><strong><?php echo $lang->milestone->corrective;?></strong></td>
        <td colspan="6">
        <?php echo html::input('measures[]', '', 'class="form-control measures-input" onchange="submitMeasurse()";');?>
        <?php echo html::a('javascript:;', '<i class="icon icon-plus"></i>', '', 'class="btn btn-link addItem" onclick="addItem(this)"');?>
        <?php echo html::a('javascript:;', '<i class="icon icon-close"></i>', '', 'class="btn btn-link delItem" onclick="delItem(this)" id="delOrigin"');?>
        <?php echo html::submitButton();?>
        </td>
      </tr>
      <?php endif;?>
      <tr class="hidden" id="measuresDiv">
        <td colspan="6">
        <?php echo html::input('measures[]', '', 'class="form-control measures-input" onchange="submitMeasurse()"');?>
        <?php echo html::a('javascript:;', '<i class="icon icon-plus"></i>', '', 'class="btn btn-link addItem" onclick="addItem(this)"');?>
        <?php echo html::a('javascript:;', '<i class="icon icon-close"></i>', '', 'class="btn btn-link delItem" onclick="delItem(this)"');?>
        <?php echo html::submitButton();?>
        </td>
      </tr>
    </tbody>
    <?php echo html::hidden('projectID', $projectID);?>
    <?php echo html::hidden('executionID', $executionID);?>
  </table>
</form>
