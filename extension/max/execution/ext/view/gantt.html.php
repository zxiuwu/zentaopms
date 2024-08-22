<?php
/**
 * The control file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     execution
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/gantt.html.php';?>
<style>
#ganttView {height: 600px;}
#ganttPris > span {display: inline-block; line-height: 20px; min-width: 20px; border-radius: 2px;}
.gantt_container, .gantt_tooltip {font-family: "Helvetica Neue", Helvetica, Tahoma, Arial, "PingFang SC", "Source Han Sans CN", "Source Han Sans", "Hiragino Sans GB", "WenQuanYi Micro Hei", sans-serif}
.gantt_grid_scale .gantt_grid_head_cell,.gantt_task .gantt_task_scale .gantt_scale_cell {color: #838a9d;}
.gantt_task_line.gantt_selected {box-shadow: 0 1px 1px rgba(0,0,0,.05), 0 2px 6px 0 rgba(0,0,0,.045)}
.gantt_link_arrow_right {border-left-color: #2196F3;}
.gantt_link_arrow_left {border-right-color: #2196F3;}
.gantt_task_link .gantt_line_wrapper div{background-color: #2196F3;}
.gantt_critical_link .gantt_line_wrapper>div {background-color: #e63030 !important;}
.gantt_critical_link.start_to_start .gantt_link_arrow_right {border-left-color: #e63030 !important;}
.gantt_critical_link.finish_to_start .gantt_link_arrow_right {border-left-color: #e63030 !important;}
.gantt_critical_link.start_to_finish .gantt_link_arrow_left {border-right-color: #e63030 !important;}
.gantt_critical_link.finish_to_finish .gantt_link_arrow_left {border-right-color: #e63030 !important;}
.gantt_task_link.start_to_start .gantt_line_wrapper div { background-color: #DD55EA; }
.gantt_task_link.start_to_start:hover .gantt_line_wrapper div { box-shadow: 0 0 5px 0px #DD55EA; }
.gantt_task_link.start_to_start .gantt_link_arrow_right { border-left-color: #DD55EA; }
.gantt_task_link.finish_to_start .gantt_line_wrapper div { background-color: #7576ba; }
.gantt_task_link.finish_to_start:hover .gantt_line_wrapper div { box-shadow: 0 0 5px 0px #7576ba; }
.gantt_task_link.finish_to_start .gantt_link_arrow_right { border-left-color: #7576ba; }
.gantt_task_link.finish_to_finish .gantt_line_wrapper div { background-color: #55d822; }
.gantt_task_link.finish_to_finish:hover .gantt_line_wrapper div { box-shadow: 0 0 5px 0px #55d822; }
.gantt_task_link.finish_to_finish .gantt_link_arrow_left { border-right-color: #55d822; }
.gantt_task_link.start_to_finish .gantt_line_wrapper div { background-color: #975000; }
.gantt_task_link.start_to_finish:hover .gantt_line_wrapper div { box-shadow: 0 0 5px 0px #975000; }
.gantt_task_link.start_to_finish .gantt_link_arrow_left { border-right-color: #975000; }
.gantt_critical_task{background:#e63030 !important; border-color:#9d3a3a !important;}
.gantt_grid_head_cell.gantt_grid_head_text{overflow:visible;}
.gantt_grid_head_cell.gantt_grid_head_text .btn-group .dropdown-menu{text-align:left;}

#ganttDownload, #ganttHeader {display: none;}
#ganttContainer {margin-top: 10px;}
#mainContent:before {background: #fff;}
#mainContent.loading {overflow: hidden}
#mainContent.loading #ganttView {overflow: hidden}
#mainContent.loading #ganttHeader {display: block; padding-bottom: 20px; margin: 0; height: 46px;}
#mainContent.loading #ganttDownload {display: inline}
#mainContent.loading #ganttContainer {padding: 40px;}
#mainContent.loading .scrollVer_cell,
#mainContent.loading .scrollVer_cell {display: none;}

.gantt-fullscreen #header,
.gantt-fullscreen #mainMenu,
.gantt-fullscreen #footer {display: none!important;}
.gantt-fullscreen #mainContent {position: fixed; top: 0; right: 0; bottom: 0; left: 0}

.gantt_cell .delay {background: #e84e0f; color: white; display: inline-block;}
.gantt_task_content{color:#000000;}
.gantt_grid_head_cell .sort {
    position: relative;
    display: inline-block;
    padding-right: 16px;
    color: #3c4353;
}
.gantt_grid_head_cell .sort.sort-up,.gantt_grid_head_cell .sort.sort-down{
    color: #000;
    text-decoration: none;
}
.gantt_grid_head_cell .sort:before,.gantt_grid_head_cell .sort:after{
    position: absolute;
    top: 10px;
    right: 0;
    font-family: ZentaoIcon;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    font-variant: normal;
    line-height: 1;
    color: #3c495c;
    text-transform: none;
    content: "\f0de";
    opacity: .5;
    speak: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.gantt_grid_head_cell .week.sort:before,.gantt_grid_head_cell .week.sort:after  { top: 26px;}
.gantt_grid_head_cell .month.sort:before,.gantt_grid_head_cell .month.sort:after{ top: 26px;}
.gantt_grid_head_cell .sort:after{content: "\f0dd";}
.gantt_grid_head_cell .sort.sort-down:after, .gantt_grid_head_cell .sort.sort-up:before { color: #000; opacity: 1;}
.gantt_grid_head_cell, .gantt_scale_cell{color:#000000!important;}
.gantt_tree_content{color:#838A9D;}
.gantt_row > div:first-child .gantt_tree_content{color:#3C4353;}
.gantt_task_line.gantt_task_inline_color{border:0px;}
.gantt_grid_scale, .gantt_task_scale, .gantt_task_vscroll{background-color: #F2F7FF;}

#myCover {display:none;left:24px !important;height:unset!important;}
</style>
<?php js::set('canGanttEdit', common::hasPriv('execution', 'ganttEdit'));?>
<?php include "featurebar.html.php";?>
<div id='mainContent' class='main-content load-indicator' data-loading='<?php echo $lang->execution->gantt->exporting;?>'>
  <div id='ganttContainer'>
    <h1 id='ganttHeader'>
      <?php echo $lang->execution->gantt->common . ' - ' . $executionName;?>
      &nbsp; <small id='ganttExportDate'></small>
    </h1>
    <div class='gantt' id='ganttView'></div>
  </div>
  <?php $fileName = ($execution->type == 'stage' ? "$project->name-" : '') . $executionName . '-' . $lang->execution->ganttchart;?>
  <a id='ganttDownload' target='hiddenwin' download='<?php echo "$fileName.png";?>'></a>
  <?php
  $typeHtml  = '<div class="btn-group">';
  $typeHtml .= '<button class="btn btn-link" data-toggle="dropdown"><span class="text">' . $lang->execution->gantt->browseType[$ganttType] . '</span> <span class="caret"></span></button>';
  $typeHtml .= '<ul class="dropdown-menu">';
  foreach($lang->execution->gantt->browseType as $browseType => $typeName)
  {
      $typeHtml .= '<li ' . ($ganttType == $browseType ? "class='active'" : '') . '>' . html::a($this->createLink('execution', 'gantt', "executionID=$executionID&type=$browseType"), $typeName) . '</li>';
  }
  $typeHtml .= '</ul></div>';
  ?>
</div>
<div id="myCover">
  <div class="gantt_control">
    <div class='btn btn-link' id='ganttPris'>
      <strong><?php echo $lang->task->pri . " : "?></strong>
      <?php foreach($lang->execution->gantt->progressColor as $pri => $color):?>
      <?php if($pri <= 4):?>
      <span style="background:<?php echo $color?>"><?php echo $pri;?></span> &nbsp;
      <?php endif;?>
      <?php endforeach;?>
    </div>
  </div>
  <div id="gantt_here"></div>
</div>
<script>
var scriptLoadedMap = {};
var loadingPrefixText = '<?php echo $lang->execution->gantt->exporting;?>';

//After that you have to redefine the getFullscreenElement() method to return a custom root node that will be expanded to full screen:
gantt.ext.fullscreen.getFullscreenElement = function() {
    return document.getElementById("myCover");
}
gantt.init("gantt_here");

var showError = function(message)
{
    new $.zui.Messager(message, {
        type: 'danger',
        icon: 'exclamation-sign'
    }).show();
};

// before gantt is expanded to full screen
gantt.attachEvent("onBeforeExpand",function(){
    $('#myCover').css('display', 'unset');
    $('#myCover').css('padding', '8px');
    $('#mainContent').css('padding', '40px');
    return true;
});

// when gantt exited the full screen mode
gantt.attachEvent("onCollapse", function (){
    $('#myCover').css('display', 'none');
});

/**
 * Get remote script for export.
 *
 * @param  string $url
 * @param  function $successCallback
 * @param  function $errorCallback
 * @access public
 * @return void
 */
function getRemoteScript(url, successCallback, errorCallback)
{
    if(scriptLoadedMap[url]) return successCallback && successCallback();
    $.getScript(url, function()
    {
        scriptLoadedMap[url] = true;
        if(successCallback) successCallback();
    }).fail(function()
    {
        if(errorCallback) errorCallback('Cannot load "' + url + '".');
    });
}

/**
 * Update export progress.
 *
 * @param  int $progress
 * @access public
 * @return void
 */
function updateProgress(progress)
{
    var progressText = loadingPrefixText;
    if(progress < 1) progressText += Math.floor(progress * 100) + '%';
    $('#mainContent').attr('data-loading', progressText);
}

/**
 * Draw gantt to canvas.
 *
 * @param  string   $exportType
 * @param  function $successCallback
 * @param  function $errorCallback
 * @access public
 * @return void
 */
function drawGanttToCanvas(exportType, successCallback, errorCallback)
{
    updateProgress(0);

    exportType = exportType || 'image';
    var $ganttView      = $('#ganttView');
    var oldHeight       = $ganttView.css('height');
    var $ganttContainer = $('#ganttContainer');
    var $ganttDataArea  = $ganttView.find('.gantt_data_area');
    var $ganttDridData  = $ganttView.find('.gantt_grid_data');
    var ganttHeight     = $ganttView.find('.gantt_task_bg').outerHeight() + $ganttView.find('.gantt_grid_scale').outerHeight() + 1;
    var ganttWidth      = $ganttDataArea.outerWidth() + $ganttDridData.outerWidth();

    $ganttContainer.css(
    {
        height: ganttHeight + $('#ganttHeader').outerHeight() + 80,
        width: ganttWidth + 93
    });
    $ganttView.css('height', ganttHeight);

    gantt.render();

    updateProgress(0.1);
    getRemoteScript('<?php echo $jsRoot . 'html2canvas/min.js';?>', function()
    {
        updateProgress(0.2);

        var afterFinish = function(canvas)
        {
            $ganttContainer.css(
            {
                width: '',
                height: ''
            });
            $ganttView.css('height', oldHeight);
            if(canvas)
            {
                try
                {
                    canvas.removeNode(true)
                }
                catch(err)
                {
                    canvas.remove()
                };
            }
        };
        var delayTime = Math.max(1000, Math.floor(10 * (ganttHeight * ganttWidth) / 100000));
        var progressTimer;

        if(delayTime > 1500)
        {
            var startProgress = 0.2;
            var deltaProgress = 0.5 / Math.floor(delayTime/1000);
            progressTimer = setInterval(function()
            {
                startProgress += deltaProgress;
                updateProgress(Math.min(0.7, startProgress));
            }, 1000);
        }

        setTimeout(function()
        {
            if(progressTimer) clearInterval(progressTimer);

            updateProgress(0.7);
            html2canvas($ganttContainer[0], {logging: false}).then(function(canvas)
            {
                var isExportPDF = exportType === 'pdf';
                updateProgress(isExportPDF ? 0.8 : 0.9);
                canvas.onerror = function()
                {
                    afterFinish(canvas);
                    if(errorCallback) errorCallback('Cannot convert image to blob.');
                };

                if(isExportPDF)
                {
                    var width = canvas.width;
                    var height = canvas.height;

                    getRemoteScript('<?php echo $jsRoot . 'pdfjs/min.js';?>', function()
                    {
                        updateProgress(0.8);
                        var pdf = new jsPDF(
                        {
                            format: [width, height],
                            unit: 'px',
                            orientation: width > height ? 'l' : 'p'
                        });
                        pdf.addImage(canvas, 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
                        pdf.save('<?php echo "$fileName.pdf"?>');
                        if(successCallback) successCallback(pdf);
                        afterFinish();
                    }, function(error)
                    {
                        afterFinish(canvas);
                        if(errorCallback) errorCallback(error);
                    });
                }
                else
                {
                    canvas.toBlob(function(blob)
                    {
                        updateProgress(0.95);
                        var imageUrl = URL.createObjectURL(blob);
                        if(navigator.msSaveBlob)
                        {
                            navigator.msSaveOrOpenBlob(blob, '<?php echo $fileName; ?>.png');
                        }
                        else
                        {
                            $('#ganttDownload').attr({href: imageUrl})[0].click();
                        }
                        if(successCallback) successCallback(imageUrl);
                        afterFinish(canvas);
                    });
                }
            }).catch(function(error)
            {
                afterFinish();
                if(errorCallback) errorCallback('Cannot draw graphic to canvas.');
            });
        }, delayTime);
    }, errorCallback);
}

/**
 * Export gantt.
 *
 * @param  string $exportType
 * @access public
 * @return void
 */
function exportGantt(exportType)
{
    var $mainContent = $('#mainContent');
    $mainContent.addClass('loading').css('height', Math.max(200, Math.floor($(window).height() - $('#footer').outerHeight() - $('#header').outerHeight() - $('#mainMenu').outerHeight() - 38)));
    $('#ganttExportDate').text(new Date().format('yyyy-MM-dd hh:mm:ss'));
    var afterFinish = function(url)
    {
        setTimeout(function()
        {
            $mainContent.css('height', '').removeClass('loading');
        }, 300);
        updateProgress(1);
    };
    drawGanttToCanvas(exportType, afterFinish, function(errorText)
    {
        afterFinish();
        $.zui.messager.danger('<?php echo $lang->execution->gantt->exportFail;?>' + (errorText || ''));
    });
}

/**
 * Get by id for gantt.
 *
 * @param  array  $list
 * @param  string $id
 * @access public
 * @return string
 */
function getByIdForGantt(list, id)
{
    for (var i = 0; i < list.length; i++)
    {
        if (list[i].key == id) return list[i].label || "";
    }
    return id;
}

/**
 * Zoom tasks.
 *
 * @param  node $node
 * @access public
 * @return void
 */
function zoomTasks(node)
{
    switch(node.value)
    {
        case "day":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: "year", step: 1, format: "%Y"}, {unit: 'day', step: 1, format: '%m-%d'}];
            gantt.config.scale_height = 22 * gantt.config.scales.length;
        break;
        case "week":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: "year", step: 1, format: "%Y"}, {unit: 'week', step: 1, format: "<?php echo $lang->execution->gantt->zooming['week'];?> #%W"}, {unit:"day", step:1, date:"%D"}]
            gantt.config.scale_height = 22 * gantt.config.scales.length;
        break;
        case "month":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: "year", step: 1, format: "%Y"}, {unit: 'month', step: 1, format: '%M'}, {unit:"week", step:1, date:"<?php echo $lang->execution->gantt->zooming['week'];?> #%W"}];
            gantt.config.scale_height = 22 * gantt.config.scales.length;
        break;
    }

    gantt.render();
    $('.gantt_grid_head_cell .sort').addClass(node.value);
}

/**
 * Update criticalPath
 *
 * @access public
 * @return void
 */
function updateCriticalPath()
{
    gantt.config.highlight_critical_path = !gantt.config.highlight_critical_path;
    if(gantt.config.highlight_critical_path)
    {
        $('#criticalPath').html(<?php echo json_encode($lang->execution->gantt->hideCriticalPath);?>);
        gantt.config.highlight_critical_path = true;
    }
    else
    {
        $('#criticalPath').html(<?php echo json_encode($lang->execution->gantt->showCriticalPath);?>);
        gantt.config.highlight_critical_path = false;
    }

    gantt.render();
}

/**
 * Validate resources.
 *
 * @param int id
 * @access public
 * @return bool
 */
function validateResources(id)
{
    var task = gantt.getTask(id);
    var from = new Date(task.start_date),
        to   = new Date(task.end_date);
    var status = task.status;
    var statusLang = "<?php echo $this->lang->task->statusList['wait'];?>";
    flag = true;

    if(task.id < 0) return false;

    /* Check status. */
    if(status !== statusLang)
    {
        showError("<?php echo $lang->programplan->error->taskDrag;?>".replace('%s', status))
        gantt.refreshData();
        return false;
    }

    /* Check data. */
    var postData = {
        'id'        : task.id,
        'startDate': from.toLocaleDateString('en-CA'),
        'endDate'  : to.toLocaleDateString('en-CA'),
        'type'      : 'task'
    };
    var link = createLink('programplan', 'ajaxResponseGanttDragEvent');
    /* Sync Close. */
    $.ajax({
        url: link,
        dataType: "json",
        async: false,
        data: postData,
        type: "post",
        success: function(response)
        {
            if(response.result == 'fail' && response.message)
            {
                showError(response.message)
                flag = false;
            }
        }
    });

    return flag;
}

$(function()
{
    // Set gantt view height
    var resizeGanttView = function()
    {
        if(gantt.getState().fullscreen) return false;
        $('#ganttView').css('height', Math.max(200, Math.floor($(window).height() - $('#footer').outerHeight() - $('#header').outerHeight() - $('#mainMenu').outerHeight() - 80)));
    };

    var ganttData = $.parseJSON(<?php echo json_encode($executionData);?>);
    if(!ganttData.data) ganttData.data = [];

    gantt.serverList("userList", <?php echo json_encode($userList);?>);

    gantt.config.readonly            = canGanttEdit ? false : true;
    gantt.config.details_on_dblclick = false;
    gantt.config.order_branch        = false;
    gantt.config.drag_progress       = false;
    gantt.config.drag_links          = true;
    gantt.config.smart_rendering     = true;
    gantt.config.smart_scales        = true;
    gantt.config.static_background   = true;
    gantt.config.show_task_cells     = false;
    gantt.config.row_height          = 32;
    gantt.config.min_column_width    = 40;
    gantt.config.details_on_create   = false;
    gantt.config.scales              = [{unit: "year", step: 1, format: "%Y"}, {unit: 'day', step: 1, format: '%m-%d'}];
    gantt.config.scale_height        = 18 * gantt.config.scales.length;
    gantt.config.duration_unit       = "day";

    gantt.config.columns = [{name: 'text', width: '*', tree: true, resize: true, min_width:120, width:250}, {name: 'owner_id', align: 'center', resize: true, width:90, template: function(task){return getByIdForGantt(gantt.serverList('userList'), task.owner_id)}}, {name: 'progress', align: 'left', resize: true, width:70, template: function(task) { return Math.floor(task.progress * 100) + '%'}}, {name: 'start_date', align: 'center', resize: true, width: 90}, {name: 'end_date', align: 'center', resize: true, width: 90}, {name: 'duration', align: 'center', width: 70}];

    gantt.templates.task_end_date = function(data)
    {
        return gantt.templates.task_date(new Date(date.valueOf() - 1));
    }
    var gridDateToStr = gantt.date.date_to_str("%Y-%m-%d");

    gantt.templates.date_grid = function(date, task, column){
        if(column === "end_date")
        {
            var endDate = gridDateToStr(new Date(date.valueOf() - 1));
            if(task.isDelay) endDate = "<span class='delay'>" + endDate + "</span>";
            return endDate;
        }
        else
        {
            return gridDateToStr(date);
        }
    }

    <?php list($orderField, $orderDirect) = $this->execution->parseOrderBy($orderBy);?>
    gantt.locale.labels.column_text = <?php echo json_encode($typeHtml);?>;
    <?php
    list($fieldOrderBy, $fieldClass) = $this->execution->buildKanbanOrderBy('owner_id', $orderField, $orderDirect);
    $link = $this->createLink('execution', 'gantt', "executionID=$executionID&type=$ganttType&orderBy=$fieldOrderBy");
    ?>
    gantt.locale.labels.column_owner_id = <?php echo json_encode(html::a($link, $lang->task->assignedTo, '', "class='$fieldClass'"));?>;
    <?php
    list($fieldOrderBy, $fieldClass) = $this->execution->buildKanbanOrderBy('progress', $orderField, $orderDirect);
    $link = $this->createLink('execution', 'gantt', "executionID=$executionID&type=$ganttType&orderBy=$fieldOrderBy");
    ?>
    gantt.locale.labels.column_progress = <?php echo json_encode(html::a($link, $lang->task->progress, '', "class='$fieldClass'"));?>;
    <?php
    list($fieldOrderBy, $fieldClass) = $this->execution->buildKanbanOrderBy('start_date', $orderField, $orderDirect);
    $link = $this->createLink('execution', 'gantt', "executionID=$executionID&type=$ganttType&orderBy=$fieldOrderBy");
    ?>
    gantt.locale.labels.column_start_date = <?php echo json_encode(html::a($link, $lang->execution->gantt->startDate, '', "class='$fieldClass'"));?>;
    <?php
    list($fieldOrderBy, $fieldClass) = $this->execution->buildKanbanOrderBy('deadline', $orderField, $orderDirect);
    $link = $this->createLink('execution', 'gantt', "executionID=$executionID&type=$ganttType&orderBy=$fieldOrderBy");
    ?>
    gantt.locale.labels.column_end_date = <?php echo json_encode(html::a($link, $lang->execution->gantt->endDate, '', "class='$fieldClass'"));?>;
    <?php
    list($fieldOrderBy, $fieldClass) = $this->execution->buildKanbanOrderBy('duration', $orderField, $orderDirect);
    $link = $this->createLink('execution', 'gantt', "executionID=$executionID&type=$ganttType&orderBy=$fieldOrderBy");
    ?>
    gantt.locale.labels.column_duration = <?php echo json_encode(html::a($link, $lang->execution->gantt->duration, '', "class='$fieldClass'"));?>;

    var date2Str = gantt.date.date_to_str(gantt.config.task_date);
    var today    = new Date();
    gantt.addMarker({
        start_date: today,
        css: "today",
        text: "<?php echo $lang->action->dynamic->today;?>",
        title: "<?php echo $lang->action->dynamic->today;?>: " + date2Str(today)
    });

    gantt.templates.task_class     = function(start, end, task){return 'pri-' + (task.pri || 0);};
    gantt.templates.rightside_text = function(start, end, task)
    {
        return getByIdForGantt(gantt.serverList('userList'), task.owner_id);
    };
    gantt.templates.scale_cell_class = function(date)
    {
        if(date.getDay() == 0 || date.getDay() == 6) return 'weekend';
    };
    gantt.templates.timeline_cell_class = function(item, date)
    {
        if(date.getDay() == 0 || date.getDay() == 6) return 'weekend';
    };
    gantt.templates.link_class = function(link)
    {
        var types = gantt.config.links;
        if(link.type == types.finish_to_start)  return 'finish_to_start';
        if(link.type == types.start_to_start)   return 'start_to_start';
        if(link.type == types.finish_to_finish) return 'finish_to_finish';
        if(link.type == types.start_to_finish)  return 'start_to_finish';
    };

    gantt.templates.tooltip_text = function (start, end, task){return task.text;};

    gantt.templates.grid_file = function(item){return "";};

    gantt.attachEvent('onTemplatesReady', function()
    {
        $('#fullScreenBtn').click(function()
        {
            gantt.expand();
        });
    });

    var isGanttExpand    = false;
    var delayTimer       = null;
    var handleFullscreen = function()
    {
        if(isGanttExpand)
        {
            $('body').addClass('gantt-fullscreen');
            $('#ganttView').css('height', $(window).height() - 60);
            isGanttExpand = false;
        }
        else
        {
            $('body').removeClass('gantt-fullscreen');
            resizeGanttView();
        }
        delayTimer = null;
    };
    var delayHandleFullscreen = function()
    {
        if(delayTimer) clearTimeout(delayTimer);
        delayTimer = setTimeout(handleFullscreen, 50);
    };

    gantt.attachEvent('onBeforeExpand', function()
    {
        $('body').addClass('gantt-fullscreen');
        isGanttExpand = true;
        return true;
    });

    if(document.addEventListener)
    {
        document.addEventListener('webkitfullscreenchange', delayHandleFullscreen, false);
        document.addEventListener('mozfullscreenchange', delayHandleFullscreen, false);
        document.addEventListener('fullscreenchange', delayHandleFullscreen, false);
        document.addEventListener('MSFullscreenChange', delayHandleFullscreen, false);
    }

    resizeGanttView();
    $(window).resize(resizeGanttView);

    gantt.templates.grid_folder = function(item) {
        return "";
    };

    gantt.templates.grid_file = function(item) {
        return "";
    };

    gantt.init('ganttView');
    gantt.parse(ganttData);

    // Show task in modal on click task
    var taskModalTrigger = new $.zui.ModalTrigger({type: 'iframe', width: '95%'});
    gantt.attachEvent('onTaskClick', function(id, e)
    {
        if($(e.srcElement).hasClass('gantt_close') || $(e.srcElement).hasClass('gantt_open')) return false;

        if(typeof id === 'string') id = parseInt(id);
        if(!isNaN(id) && id > 0)
        {
            taskModalTrigger.show({url: createLink('task', 'view', 'taskID=' + id, 'html', true)});
        }
    });

    // Make folder can open or close by click
    $('#ganttView').on('click', '.gantt_close,.gantt_open', function()
    {
        var $task = $(this).closest('.gantt_row_task');
        var task  = gantt.getTask($task.attr('task_id'));
        if(task) gantt[task.$open ? 'close' : 'open'](task.id);
    });

    $('#ganttContainer').mouseleave(function()
    {
        setTimeout(function(){$('.gantt_tooltip').remove()}, 100);
    });

    gantt.attachEvent("onBeforeTaskChanged", function(id, mode, task)
    {
        return validateResources(id);
    });

    gantt.attachEvent('onBeforeLinkAdd', function(id, link)
    {
        var source = +link.source;
        var target = +link.target;
        if(source <= 0 || target <= 0)
        {
            let message = "<?php echo $lang->execution->error->wrongGanttRelation;?>";
            if(source <= 0) message += "<?php echo $lang->execution->error->wrongGanttRelationSource;?>";
            if(target <= 0) message += "<?php echo $lang->execution->error->wrongGanttRelationTarget;?>";
            showError(message);

            return false;
        }

        return true;
    });

    gantt.attachEvent('onAfterLinkAdd', function(id, item)
    {
        var source       = +item.source;
        var target       = +item.target;
        var type         = +item.type;
        var condition    = (type == 1 || type == 3) ? 'begin' : 'end';
        var action       = (type == 1 || type == 0) ? 'begin' : 'end';
        var newid        = {1:1}
        var newpretask   = {1:source}
        var newcondition = {1:condition}
        var newtask      = {1:target}
        var newaction    = {1:action}
        var relation     = {newid, newpretask, newcondition, newtask, newaction};

        var link = createLink('execution', 'ajaxMaintainRelation', 'executionID=<?php echo $execution->id;?>');
        $.post(link, relation, function(response)
        {
            response = $.parseJSON(response)
            if(response.result == 'fail' && response.message)
            {
                showError(response.message);
                gantt.deleteLink(id);
            }
        });
    });

    gantt.attachEvent("onLinkDblClick", function(id,e)
    {
        return false;
    });
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
