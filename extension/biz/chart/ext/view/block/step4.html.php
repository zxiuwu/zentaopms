<div id='mainContent' class='main-content'>
  <div class="display-content">
    <div class="cell">
      <div class='panel'>
        <div class='panel-heading'>
          <div class='panel-title ptitle'>
            <?php echo $chart->name;?>
            <?php common::printLink('chart', 'export', "chartID=0_{$chart->id}", "<i class='icon-export muted'> </i>" . $lang->export, '', "class='btn btn-link btn-export pull-right hidden' data-toggle='modal'")?>
          </div>
        </div>
        <div class='panel-body' style="padding: 16px;">
          <div id='filterContent'>
            <div id="filterItems"></div>
            <div id='queryButton4' class='hidden queryButton'>
              <button type="button" onclick='queryFilter()' class="btn btn-secondary save-step"><?php echo $lang->chart->query;?></button>
            </div>
          </div>
          <div id="draw" data-group='0' data-id='<?php echo $chart->id;?>' class='echart-content'></div>
        </div>
      </div>
    </div>
  </div>

  <div class="config-content" id="sidebar">
    <div class="cell">
      <div class='panel'>
        <div class='panel-heading border-bottom'>
          <div class='panel-title ptitle'>
            <?php echo $lang->chart->legendBasicInfo;?>
          </div>
        </div>
        <div class='panel-heading'>
          <div class='panel-body'>
            <div>
              <div class='tab-content'>
                <div class='tab-pane active' id='legendBasicInfo'>
                  <form method="post" class="form-ajax" id="releaseForm">
                  <table class="table table-form">
                    <tbody>
                      <tr>
                        <th class='w-60px'><?php echo $lang->chart->group;?></th>
                        <td>
                          <?php echo html::select('group[]', $groups, $chart->group, "class='chosen form-control' data-max_drop_width='200' onchange='basicChange(\"group\", this.value)' multiple");?>
                        </td>
                      </tr>
                      <tr>
                        <th class='thWidth'><?php echo $lang->chart->name;?></th>
                        <td class='w-400px'>
                          <?php echo html::input('name', $chart->name, "class='form-control' onchange='basicChange(\"name\", this.value)'");?>
                        </td>
                      </tr>
                      <tr>
                        <th><?php echo $lang->chart->desc;?></th>
                        <td><?php echo html::textarea('desc', $chart->desc, "rows='7' class='form-control' onchange='basicChange(\"desc\", this.value)'");?></td>
                      </tr>
                    </tbody>
                  </table>
                  </form>
                </div>
                <div class='tab-pane' id='legendConfig'>
                  <table class="table table-data">
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class='panel pull-bottom'>
        <div class='panel-heading'>
          <div class='panel-footer'>
            <?php echo '<button type="button" class="btn btn-primary btn-publish" onclick="publish()">' . $lang->chart->publish . '</button>';?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<template id='filterItemTpl'>
  <div class='filter-item filter-item-{index} input-group'>
    <span class='field-name input-group-addon'>{name}</span>
    {search}
  </div>
</template>

<script>
function basicChange(field, value)
{
    var chart = DataStorage.clone('chart');
    if(chart)
    {
        if(field == 'group' && $('#legendBasicInfo [name^=group]').val())
        {
            chart[field] = $('#legendBasicInfo [name^=group]').val().join(',');
        }
        else
        {
            chart[field] = value;
        }
    }
    DataStorage.chart = chart;
}
</script>
