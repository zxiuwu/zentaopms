<?php
/**
 * The gantt of programplan module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     programplan
 * @version     $Id: gantt.html.php 4903 2013-06-26 05:32:59Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/gantt.html.php';?>
<style>
#ganttView {height: 600px;}
#mainContent:before {background: #fff;}
.checkbox-primary {margin-top: 0px; margin-left: 10px;}
form {display: block; margin-top: 0em; margin-block-end: 1em;}
.gantt_task_content span.task-label, .gantt_task_content span.label-pri{display: none;}
#ganttPris > span {display: inline-block; line-height: 20px; min-width: 20px; border-radius: 2px;}
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
.gantt_marker .gantt_marker_content {left: -15px; background-color: #f51e1e;}
.gantt_row.task-item{cursor: pointer;}

#ganttDownload, #ganttHeader {display: none;}
#ganttContainer {margin-top: 40px;}
#mainContent {padding: 10px 20px 20px 20px;}
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
.gantt_grid_head_cell.gantt_grid_head_text{overflow:visible;}
.gantt_grid_head_cell, .gantt_scale_cell{color:#000000!important;}
.gantt_tree_content{color:#838A9D;}
.gantt_row > div:first-child .gantt_tree_content{color:#3C4353;}
.gantt_task_line.gantt_task_inline_color{border:0px;}
.gantt_grid_scale, .gantt_task_scale, .gantt_task_vscroll{background-color: #F2F7FF;}
#myCover {display:none;left:12px!important;z-index:10!important;top:9px!important;height:unset!important;}
.button-group{position: relative;}
.flax{display: flex; margin-bottom: 10px;}
.switchBtn > i {padding-left: 7px;}
#mainContent > .pull-left > .btn-group > .text{display: block;margin-top: 7px;}
#mainContent > .pull-left > .btn-group > a > .text{overflow: hidden;display: block;}
#mainContent > .pull-right > .button-group  .text{margin-left: 0px;}
.pull-right .icon-plus.icon-sm:before{vertical-align: 4%;}
.gantt_tree_content .btn { display: inline-block; width: 26px; padding: 2px; overflow: hidden; line-height: 20px; color: #18a6fd; background: 0 0; border-color: transparent; }
</style>
<?php js::set('module', $app->rawModule);?>
<?php js::set('method', $app->rawMethod);?>
<?php js::set('ganttType', $ganttType);?>
<?php js::set('vision', $config->vision);?>
<?php js::set('canGanttEdit', common::hasPriv('programplan', 'ganttEdit'));?>
<?php js::set('zooming', isset($zooming) ? $zooming : 'month');?>
<?php js::set('productType', $product->type);?>
<div id='mainContent' class='main-content load-indicator'>
  <div class='btn-toolbar pull-left'>
    <a href='javascript:fullScreen();' id='fullScreenBtn' class='btn btn-link'><i class='icon icon-fullscreen'></i> <?php echo $lang->programplan->full;?></a>
    <div class='btn btn-link'>
      <strong><?php echo $lang->execution->gantt->format . '：';?></strong>
      <?php echo html::radio('zooming', $lang->roadmap->zooming, 'month', "onchange='zoomTasks(this.value)'");?>
    </div>
  </div>
  <div class="pull-right btn-toolbar flax">
    <?php
    if(common::hasPriv('roadmap', 'create') and $config->vision == 'or') echo html::a($this->createLink('roadmap', 'create', "productID=$productID"), "<i class='icon icon-plus'></i> " . $this->lang->roadmap->create, '', "class='btn btn-primary'");
    ?>
  </div>
  <div id='ganttContainer'>
    <div class='gantt' id='ganttView'></div>
  </div>
  <?php $fileName = "gantt-export-{$productID}";?>
  <a id='ganttDownload' target='hiddenwin' download='<?php echo "{$fileName}.png";?>'></a>
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
var scriptLoadedMap   = {};
var loadingPrefixText = '<?php echo $lang->programplan->exporting;?>';

//After that you have to redefine the getFullscreenElement() method to return a custom root node that will be expanded to full screen:
gantt.ext.fullscreen.getFullscreenElement = function() {
    return document.getElementById("myCover");
}
gantt.init("gantt_here");

// before gantt is expanded to full screen
gantt.attachEvent("onBeforeExpand",function(){
    $('#myCover').css('display', 'unset');
    $('#mainContent .pull-right').css('opacity', '0');
    $('.btn-toolbar').css('display', 'none');
    return true;
});

// when gantt exited the full screen mode
gantt.attachEvent("onCollapse", function (){
    $('#myCover').css('display', 'none');
    $('#mainContent .pull-right').css('opacity', '1');
    $('.btn-toolbar').css('display', 'flex');
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

    var ganttRowHeight = $ganttView.find('.gantt_row').first().outerHeight() || 25;
    var ganttHeight    = $ganttView.find('.gantt_task_bg').outerHeight() + $ganttView.find('.gantt_grid_scale').outerHeight() + 1;
    var ganttWidth = $ganttDataArea.outerWidth() + $ganttDridData.outerWidth();

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
        $.zui.messager.danger('<?php echo $lang->programplan->exportFail;?>' + (errorText || ''));
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
 * @param  value
 * @access public
 * @return void
 */
function zoomTasks(value)
{
    switch(value)
    {
        case "month":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: "year", step: 1, format: "%Y"}, {unit: 'month', step: 1, format: '%M'}, {unit:"week", step:1, date:"<?php echo $lang->execution->gantt->zooming['week'];?> #%W"}];
            gantt.config.scale_height = 22 * gantt.config.scales.length;
        break;
        case "quarter":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: "year", step: 1, format: "%Y"}, { unit: "quarter", step: 1, format: function (date) { var dateToStr = gantt.date.date_to_str("%M"); var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day"); return dateToStr(date) + " - " + dateToStr(endDate);}}];
        break;
        case "year":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: "year", step: 1, format: "%Y"}, {unit: 'month', step: 1, format: '%M'}]
            gantt.config.scale_height = 22 * gantt.config.scales.length;
        break;
    }

    gantt.render();
    $('.gantt_grid_head_cell .sort').addClass(value);
}

window.onload = function () {
    zoomTasks(zooming);
}

$("#fullScreenBtn").on("click", function()
{
    $("#mainContent").css("z-index", "5");
    $("#ganttView").css("z-index", "5");
});

function exitHandler()
{
    if (module == 'review' && method == 'assess' && !document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement)
    {
        location.reload();
    }
}

$(function()
{
    document.addEventListener('fullscreenchange', exitHandler);
    var layout;

    // Set gantt view height
    var resizeGanttView = function()
    {
        if(gantt.getState().fullscreen) return false;
        $('#ganttView').css('height', Math.max(200, Math.floor($(window).height() - $('#footer').outerHeight() - $('#header').outerHeight() - $('#mainMenu').outerHeight() - 120)));
    };

    var ganttData = $.parseJSON(<?php echo json_encode(json_encode($roadmaps));?>);
    if(!ganttData.data) ganttData.data = [];

    <?php
    $userList = array();
    if(!empty($users))
    {
        foreach($users as $account => $realname)
        {
            $user = array();
            $user['key']   = $account;
            $user['label'] = $realname;
            $userList[]    = $user;
        }
    }
    ?>
    gantt.serverList("userList", <?php echo json_encode($userList);?>);

    gantt.config.readonly            = true;
    gantt.config.details_on_dblclick = false;
    gantt.config.order_branch        = ganttType == 'assignedTo' ? false : true;
    gantt.config.drag_progress       = false;
    gantt.config.drag_links          = false;
    gantt.config.drag_move           = false;
    gantt.config.drag_resize         = true;
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

    gantt.config.columns = [];
    gantt.config.columns.push({name: 'text', width: '*', tree: true, resize: true, min_width:120, width:200});
    if(productType != 'normal') gantt.config.columns.push({name: 'branch', align: 'center', resize: true, width: 100});
    gantt.config.columns.push({name: 'status', align: 'center', resize: true, width: 90});
    gantt.config.columns.push({name: 'start_date', align: 'center', resize: true, width: 90});
    gantt.config.columns.push({name: 'end_date', align: 'center', resize: true, width: 90});
    gantt.config.columns.push({name: 'requirements', align: 'center', resize: true, width: 90});
    if(vision == 'or') gantt.config.columns.push({name: 'actions', align: 'center', resize: true, width: 130});

    gantt.templates.task_end_date = function(data)
    {
        return gantt.templates.task_date(new Date(date.valueOf() - 1));
    }
    var gridDateToStr = gantt.date.date_to_str("%Y-%m-%d");
    gantt.templates.grid_date_format = function(date, column)
    {
        if(column === "end_date")
        {
            return gridDateToStr(new Date(date.valueOf() - 1));
        }
        else
        {
            return gridDateToStr(date);
        }
    }

    endField = gantt.config.columns.pop();
    endField.resize = false;
    gantt.config.columns.push(endField);

    gantt.locale.labels.column_text        = "<?php echo $lang->roadmap->name;?>";
    gantt.locale.labels.column_status      = "<?php echo $lang->roadmap->status;?>";
    gantt.locale.labels.column_start_date  = "<?php echo $lang->roadmap->begin;?>";
    gantt.locale.labels.column_end_date    = "<?php echo $lang->roadmap->end;?>";
    gantt.locale.labels.column_requirements= "<?php echo $lang->roadmap->requirments;?>";
    if(vision == 'or') gantt.locale.labels.column_actions = "<?php echo $lang->roadmap->actions;?>";
    if(productType != 'normal') gantt.locale.labels.column_branch = "<?php echo sprintf($lang->roadmap->branch, $lang->product->branchName[$product->type]);?>";

    var date2Str  = gantt.date.date_to_str(gantt.config.task_date);
    var today     = new Date();
    var todayTips = "<?php echo $lang->programplan->today;?>";
    gantt.addMarker({
        start_date: today,
        css: "today",
        text: todayTips,
        title: todayTips + ": " + date2Str(today)
    });

    gantt.templates.task_class     = function(start, end, task){return 'pri-' + (task.pri || 0);};
    gantt.templates.rightside_text = function(start, end, task)
    {
        if(typeof task.owner_id == 'undefined') return;
        return getByIdForGantt(gantt.serverList('userList'), task.owner_id);
    };
    gantt.templates.grid_row_class = function (start, end, task)
    {
        if(task.type == 'task') return 'task-item';
    };
    gantt.templates.link_class = function(link)
    {
        var types = gantt.config.links;
        if(link.type == types.finish_to_start)  return 'finish_to_start';
        if(link.type == types.start_to_start)   return 'start_to_start';
        if(link.type == types.finish_to_finish) return 'finish_to_finish';
        if(link.type == types.start_to_finish)  return 'start_to_finish';
    };
    gantt.templates.tooltip_text = function (start, end, task)
    {
        return '';
    };

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
    gantt.showDate(new Date());

    // Show task in modal on click task
    gantt.attachEvent('onTaskClick', function(id, e)
    {
        if($(e.srcElement).hasClass('icon-magic')) return false;
        if($(e.srcElement).hasClass('icon-trash')) return false;

        if($(e.srcElement).find('a').length > 0) return false;
        if(e.target.tagName == 'I' || e.target.tagName == 'A') return false;
        if($(e.srcElement).hasClass('gantt_close') || $(e.srcElement).hasClass('gantt_open')) return false;

        /* The id of task item is like executionID-taskID. e.g. 1507-37829, 37829 is task id. */
        var mapID = id;

        if(!isNaN(mapID) && mapID > 0) location.href = createLink('roadmap', 'view', 'mapID=' + mapID, 'html');
    });

    // Make folder can open or close by click
    $('#ganttView').on('click', '.gantt_close,.gantt_open', function()
    {
        var $task = $(this).closest('.gantt_row_task');
        var task  = gantt.getTask($task.attr('task_id'));
        if(kask) gantt[task.$open ? 'close' : 'open'](task.id);
    });

    $(".example .checkbox-primary").on('click', function()
    {
        var stageCustom = [];
        $("input[name='stageCustom[]']:checked").each(function()
        {
            var custom = $(this).val();
            stageCustom.push(custom);
        });

        if(stageCustom.length == 0) stageCustom = 0;
        $.ajax({
            url: customUrl,
            dataType: "json",
            data: {stageCustom: stageCustom},
            type: "post",
            success: function(result)
            {
                window.location.reload();
            }
        });
    });

    $('#ganttContainer').mouseleave(function()
    {
        setTimeout(function(){$('.gantt_tooltip').remove()}, 100);
    });

    $('#ganttContainer').on('click', '.iframe', function()
    {
        new $.zui.ModalTrigger({iframe : $(this).attr('href'), width: '60%'}).show();
        return false;
    })
});
</script>
