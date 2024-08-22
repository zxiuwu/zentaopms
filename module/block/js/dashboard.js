/**
 * Delete block.
 *
 * @param  int    $index
 * @access public
 * @return void
 */
function deleteBlock(index)
{
    if(confirm(config.confirmRemoveBlock))
    {
        $.getJSON(createLink('block', 'delete', 'index=' + index + '&module=' + module), function(data)
        {
            if(data.result != 'success')
            {
                alert(data.message);
                return false;
            }
            else
            {
                window.location.reload(true);
            }
        });
    }
}

/**
 * Sort blocks.
 *
 * @param  array $orders  format is {'blockid' : 1, 'block1' : 2}
 * @param  function $callback
 * @access public
 * @return void
 */
function sortBlocks(newOrders, callback)
{
    $.getJSON(createLink('block', 'sort', 'orders=' + newOrders.join(',') + '&module=' + module), callback);
}

/**
 * Resize block
 * @param  string $blockId
 * @param  function $callback
 * @access public
 * @return void
 */
function resizeBlock(blockID, width, callback)
{
    $.getJSON(createLink('block', 'resize', 'id=' + blockID + '&type=horizontal&data=' + width), function(data)
    {
        callback && callback();
        refreshBlock($('#block' + blockID));
    });
}

/**
 * refreshBlock
 *
 * @param  object   $panel
 * @param  function afterRefresh
 * @param  number   forceRefresh
 * @access public
 * @return void
 */
function refreshBlock($panel, afterRefresh, forceRefresh = 0)
{
    var url = $panel.data('url');
    var headers = {};
    if(forceRefresh) headers['X-Zt-Refresh'] = forceRefresh;
    $panel.addClass('load-indicator loading');
    $.ajax({url: url, dataType: 'html', headers: headers}).done(function(data)
    {
        var $data = $(data);
        if($data.hasClass('panel')) $panel.empty().append($data.children());
        else if($panel.find('#assigntomeBlock').length) $panel.find('#assigntomeBlock').empty().append($data.children());
        else
        {
            $panel.children('.panel-move-handler,style,script').remove();
            $panel.find('.panel-body,.empty-tip').first().replaceWith($data);
            $panel.find('.iframe').initIframeModal();
        }
        $panel.find('.progress-pie').progressPie();
        if($.isFunction(afterRefresh))
        {
            afterRefresh.call(this,
            {
                result: true,
                data: data,
                $panel: $panel
            });
        }
        $panel.find('.tablesorter').sortTable();
        $panel.find('.chosen').chosen();
        $panel.children('.table-header-fixed').remove();
        initTableHeader($panel);
        $(".sparkline").sparkline();
    }).fail(function()
    {
        $panel.addClass('panel-error');
        if($.isFunction(afterRefresh))
        {
            afterRefresh.call(this,
            {
                result: false,
                $panel: $panel
            });
        }
    }).always(function()
    {
        $panel.removeClass('load-indicator loading');
    });
}

/**
 * Init table header
 * @access public
 * @return void
 */
function initTableHeader($wrapper)
{
    ($wrapper || $('#dashboard')).find('.panel-body > table.table-fixed-head').each(function()
    {
        var $table = $(this);
        var $tabPane = $table.closest('.tab-pane');
        if ($tabPane.length && !$tabPane.hasClass('active'))
        {
            $('[data-tab][href="#' + $tabPane.attr('id') + '"]').one('shown.zui.tab', function()
            {
                initTableHeader($tabPane);
            });
            return;
        }

        var $panel = $tabPane.length ? $tabPane : $table.closest('.panel');

        if(!$table.length || !$table.children('thead').length || ($panel.find('#assigntomeBlock').length && $panel.find('#assigntomeBlock > div').length > 1)) return;
        var isFixed = $panel.find('.panel-body').height() < $table.outerHeight();

        $panel.toggleClass('with-fixed-header', isFixed);
        var $header = $panel.children('.table-header-fixed').toggle(isFixed);
        if(!isFixed)
        {
            $table.find('thead').css('visibility', 'visible');
            return;
        }
        var tableWidth = $table.width();
        var $oldTableHead = $table.find('thead');
        var updateTh = function()
        {
            $header.find('thead').empty().append($oldTableHead.find('tr').clone());
        };
        if(!$header.length)
        {
            $header = $('<div class="table-header-fixed" style="position: absolute; left: 10px; top: 0; right: 0; padding: 0 10px 0 0; background: #fff;"><table class="table table-fixed no-margin"></table></div>').css('right', $panel.width() - tableWidth - 20);
            $oldTableHead.find('th').each(function(idx)
            {
                $(this).attr('data-idx', idx);
            });
            $header.find('.table').addClass($table.attr('class')).append($oldTableHead.css('visibility', 'hidden').clone().css('visibility', 'visible'));
            $panel.addClass('with-fixed-header').append($header);
            var $heading = $panel.children('.panel-heading');
            if($heading.length) $header.css('top', $heading.outerHeight());
            if($table.hasClass('tablesorter'))
            {
                $header.on('mousedown mouseup', 'th[data-idx]', function(e)
                {
                    var $th = $(this);
                    $oldTableHead.find('th[data-idx="' + $th.data('idx') + '"]').trigger(e);
                    if(e.type === 'mouseup')
                    {
                        setTimeout(updateTh, 10);
                        setTimeout(updateTh, 200);
                    }
                });
            }
        }
        else
        {
            updateTh();
        }

        var timeoutCall = null;
        $table.parent().off('scroll.initTableHeader').on('scroll.initTableHeader', function()
        {
            clearTimeout(timeoutCall);
            var $tableContainer = $(this);
            timeoutCall = setTimeout(function() {
                $panel.toggleClass('table-scrolled', $tableContainer.scrollTop() > 0);
            }, 200);
        });
    });
}

/**
 * Check refresh progress
 * @param  object $dashboard
 * @access public
 * @return void
 */
function checkRefreshProgress($dashboard, doneCallback)
{
    if($dashboard.find('.panel-loading').length) setTimeout(function() {checkRefreshProgress($dashboard, doneCallback);}, 500);
    else doneCallback();
}
/**
 * Hidden block.
 *
 * @param  index $index
 * @access public
 * @return void
 */
function hiddenBlock(index)
{
    $.getJSON(createLink('block', 'delete', 'index=' + index + '&module=' + module + '&type=hidden'), function(data)
    {
        if(data.result != 'success')
        {
            alert(data.message);
            return false;
        }

        $('#dashboard #block' + index).addClass('hidden');
    })
}

/**
 * Block initialization.
 *
 * @access public
 * @return void
 */
$(function()
{
    initTableHeader();
    $(window).on('resize', function()
    {
        initTableHeader();
    });

    // Init dashboard
    var sortMessager = new $.zui.Messager({close: false});
    $('#dashboard').sortable(
    {
        selector: '.panel',
        trigger: '.panel-heading:not(.not-move-handler),.panel-move-handler',
        containerSelector: '.col-main,.col-side',
        canMoveHere: function($ele, $target)
        {
            var fixedCol   = $ele.data('fixed');
            var $targetCol = $target.closest('.col-main,.col-side');
            var targetCol  = $targetCol.hasClass('col-main') ? 'main' : 'side';
            if($ele.hasClass('block-guide') && targetCol != 'main') return false;
            if(fixedCol)
            {
                if(targetCol !== fixedCol)
                {
                    !sortMessager.isShow && sortMessager.show(fixedCol === 'main' ? config.cannotPlaceInRight : config.cannotPlaceInRight);
                    return false;
                }
                else
                {
                    sortMessager.isShow && sortMessager.hide();
                }
                return true;
            }
        },
        start: function()
        {
            $('body').css('overflow', 'hidden');
        },
        finish: function(e)
        {
            $('body').css('overflow', 'auto');
            var newOrders = [];
            var isSideCol = e.element.parent().is('.col-side');
            e.list.each(function(index, data)
            {
                newOrders.push(data.item.data('id'));
            });
            sortBlocks(newOrders, function()
            {
                resizeBlock(e.element.data('id'), isSideCol ? 4 : 8);
            });

            e.element.toggleClass('block-sm', isSideCol);
        },
        always: function(){sortMessager.isShow && sortMessager.hide();}
    }).on('click', '.refresh-panel', function()
    {
        refreshBlock($(this).closest('.panel'), null, 1);
    });
});

/**
 * Reload roadmap.
 *
 * @param  int    productID
 * @param  int    roadMapID
 * @access public
 * @return void
 */
function reloadRoadmap(productID, roadMapID)
{
    $.ajax(
    {
        url: createLink('block', 'printScrumroadmapBlock', 'productID=' + productID + '&roadMapID=' + roadMapID),
        dataType: "html",
        async: false,
        data: {productID: productID, roadMapID: roadMapID},
        type: 'post',
        success: function(data)
        {
            $("#roadMap" + roadMapID).html(data);
            $("#" + roadMapID).chosen();
        }
    })
}
