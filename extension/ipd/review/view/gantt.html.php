<?php include $app->getModuleRoot() . 'common/view/gantt.html.php';?>
<style>
#mainContent:before {background: #fff;}
#ganttView .gantt_layout_cell {min-width: 560px!important;}
.gantt-fullscreen #header,
.gantt-fullscreen #mainMenu,
.gantt-fullscreen #footer {display: none!important;}
.gantt-fullscreen #mainContent {position: fixed; top: 0; right: 0; bottom: 0; left: 0}
.gantt_task_content{display: none;}
</style>

<div id='mainContent' class='main-content load-indicator' data-loading='<?php echo $lang->review->exporting;?>'>
  <div id='ganttContainer'>
    <div class='gantt' id='ganttView'></div>
  </div>
</div>
<script>
var scriptLoadedMap = {};
var loadingPrefixText = '<?php echo $lang->review->exporting;?>';
function getRemoteScript(url, sucessCallback, errorCallback)
{
    if(scriptLoadedMap[url]) return sucessCallback && sucessCallback();
    $.getScript(url, function()
    {
        scriptLoadedMap[url] = true;
        if(sucessCallback) sucessCallback();
    }).fail(function()
    {
        if(errorCallback) errorCallback('Cannot load "' + url + '".');
    });
}
function updateProgress(progress)
{
    var progressText = loadingPrefixText;
    if(progress < 1) progressText += Math.floor(progress * 100) + '%';
    $('#mainContent').attr('data-loading', progressText);
}
function drawGanttToCanvas(exportType, sucessCallback, errorCallback)
{
    updateProgress(0);
    exportType = exportType || 'image';
    var $ganttView = $('#ganttView');
    var oldHeight = $ganttView.css('height');
    var $ganttContainer = $('#ganttContainer');
    var $ganttDataArea = $ganttView.find('.gantt_data_area');
    var $ganttDridData = $ganttView.find('.gantt_grid_data');
    var ganttHeight = $ganttView.find('.gantt_task_bg').outerHeight() + $ganttView.find('.gantt_grid_scale').outerHeight() + 1;
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
            if(canvas) canvas.remove();
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
                        pdf.save('gantt-export-<?php echo $review->project;?>.pdf');
                        if(sucessCallback) sucessCallback(pdf);
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
                            navigator.msSaveOrOpenBlob(blob, 'gantt.png');
                        }
                        else
                        {
                            $('#ganttDownload').attr({href: imageUrl})[0].click();
                        }
                        if(sucessCallback) sucessCallback(imageUrl);
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

function getByIdForGantt(list, id)
{
    for (var i = 0; i < list.length; i++)
    {
        if (list[i].key == id) return list[i].label || "";
    }
    return "";
}

function zoomTasks(node)
{
    switch(node.value)
    {
        case "day":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: 'day', step: 1, format: '%m-%d'}];
            gantt.config.scale_height = 35;
        break;
        case "week":
            gantt.config.min_column_width = 70;
            gantt.config.scales = [{unit: 'week', step: 1, format: "<?php echo $lang->execution->gantt->zooming['week'];?> #%W"}, {unit:"day", step:1, date:"%D"}]
            gantt.config.scale_height = 60;
        break;
        case "month":
            gantt.config.min_column_width = 70;
            gantt.config.scale_height = 60;
            gantt.config.scales = [{unit: 'month', step: 1, format: '%M'}, {unit:"week", step:1, date:"<?php echo $lang->execution->gantt->zooming['week'];?> #%W"}];
        break;
    }
    gantt.render();
}

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

function exitHandler()
{
    if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
        location.reload();
    }
}

$(function()
{
    document.addEventListener('fullscreenchange', exitHandler);
    var layout = '';

    // Set gantt view height
    var resizeGanttView = function()
    {
        if(gantt.getState().fullscreen) return false;
        $('#ganttView').css('height', Math.max(200, Math.floor($(window).height() - $('#footer').outerHeight() - $('#header').outerHeight() - $('#mainMenu').outerHeight() - 100)));
    };

    var ganttData = $.parseJSON(<?php echo json_encode(json_encode($plans));?>);
    if(!ganttData.data) ganttData.data = [];

    gantt.config.readonly          = true;
    gantt.config.row_height        = 25;
    gantt.config.min_column_width  = 40;
    gantt.config.details_on_create = false;
    gantt.config.scales            = [{unit: 'day', step: 1, format: '%m-%d'}];
    gantt.config.duration_unit     = "day";

    gantt.config.columns = [
    {name: 'text', width: '*', tree: true, resize: true, width:200},
    {name: 'start_date', align: 'center', resize: true, width: 80},
    {name: 'deadline', align: 'center', resize: true, width: 80},
    {name: 'duration', align: 'center', resize: true, width: 60},
    {name: 'percent', align: 'center', resize: true, width:70, template: function(plan)
        {
            if(plan.percent) return Math.round(plan.percent) + '%';
        }
    },
    {name: 'taskProgress', align: 'center', resize: true, width: 60},
    {name: 'realStarted', align: 'center', resize: true, width: 80},
    {name: 'realFinished', align: 'center', width: 80}
    ];

    layout = gantt.config.layout;

    gantt.config.layout = {
    css: "gantt_container",
        cols: [
            {
                rows:[
                    {view: "grid", scrollX: "gridScroll", scrollable: true, scrollY: "scrollVer"},
                    {view: "scrollbar", id: "gridScroll", group:"horizontal"}
                ]
            }
        ]
    };

    gantt.locale.labels.column_text         = "<?php echo $lang->programplan->name;?>";
    gantt.locale.labels.column_percent      = "<?php echo $lang->programplan->percentAB;?>";
    gantt.locale.labels.column_taskProgress = "<?php echo $lang->programplan->taskProgress;?>";
    gantt.locale.labels.column_start_date   = "<?php echo $lang->programplan->begin;?>";
    gantt.locale.labels.column_deadline     = "<?php echo $lang->programplan->end;?>";
    gantt.locale.labels.column_realStarted  = "<?php echo $lang->programplan->realBegan;?>";
    gantt.locale.labels.column_realFinished = "<?php echo $lang->programplan->realEnd;?>";
    gantt.locale.labels.column_duration     = "<?php echo $lang->programplan->duration;?>";

    var date2Str  = gantt.date.date_to_str(gantt.config.task_date);
    var today     = new Date();
    var todayTips = "<?php echo $lang->programplan->today;?>";
    gantt.addMarker({
    start_date: today,
        css: "today",
        text: todayTips,
        title: todayTips + ": " + date2Str(today)
    });

    gantt.templates.scale_cell_class = function(date)
    {
        if(date.getDay() == 0 || date.getDay() == 6) return 'weekend';
    };
    gantt.templates.timeline_cell_class = function(item, date)
    {
        if(date.getDay() == 0 || date.getDay() == 6) return 'weekend';
    };
    gantt.attachEvent('onTemplatesReady', function()
    {
        $('#fullScreenBtn').click(function()
        {
            gantt.config.layout = layout;
            gantt.init('ganttView');
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
            $('#ganttView').css('height', $(window).height() - 40);
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
    var taskModalTrigger = new $.zui.ModalTrigger({type: 'iframe', width: '80%'});
    gantt.attachEvent('onTaskClick', function(id, e)
    {
        if($(e.srcElement).hasClass('gantt_close') || $(e.srcElement).hasClass('gantt_open')) return false;

        if(typeof id === 'string') id = parseInt(id);
        if(!isNaN(id) && id > 0)
        {
            //taskModalTrigger.show({url: createLink('task', 'view', 'taskID=' + id, 'html', true)});
        }
    });

    // Make folder can open or close by click
    $('#ganttView').on('click', '.gantt_close,.gantt_open', function()
    {
        var $task = $(this).closest('.gantt_row_task');
        var task  = gantt.getTask($task.attr('task_id'));
        if(task) gantt[task.$open ? 'close' : 'open'](task.id);
    });
});
</script>
