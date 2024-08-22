function showLink(productID, type, orderBy, param)
{
    if(type == 'story')     method = 'linkStory';
    else if(type == 'bug')  method = 'linkBug';
    else if(type == 'task') method = 'linkTask';

    loadURL(createLink('mr', method, 'MRID=' + MRID + '&productID=' + productID + (typeof(param) == 'undefined' ? '' : param) + (typeof(orderBy) == 'undefined' ? '' : "&orderBy=" + orderBy)), type);

    $('.actions').find("a[href*='" + type + "']").addClass('hidden');
}

/**
 * Load URL.
 *
 * @param  string $url
 * @param  string $type
 * @access public
 * @return void
 */
function loadURL(url, type)
{
    $.get(url, function(data)
    {
        var $pane = $(type == 'story' ? '#stories' : (type == 'bug' ? '#bugs' : '#tasks'));
        $pane.find('.main-table').hide();
        var $linkBox = $pane.find('.linkBox').html(data).removeClass('hidden');
        $linkBox.html(data).removeClass('hidden');
        $linkBox.find('[data-ride="table"]').table();
        $linkBox.find('[data-ride="pager"]').pager();
        $linkBox.find('[data-ride="pager"] li a.pager-item').click(function()
        {
            loadURL($(this).attr('href'), type);
            return false;
        });
        $linkBox.find('[data-ride="pager"] .pager-size-menu a[data-size]').off('click');
        $linkBox.find('[data-ride="pager"] .pager-size-menu a[data-size]').click(function()
        {
            line = $linkBox.find('[data-ride="pager"]').attr('data-link-creator');
            line = line.replace('{recPerPage}', $(this).attr('data-size')).replace('{page}', $linkBox.find('[data-ride="pager"]').attr('data-page'));
            $.cookie($linkBox.find('[data-ride="pager"]').attr('data-page-cookie'), $(this).attr('data-size'), {expires:config.cookieLife, path:config.webRoot});
            loadURL(line, type);
            return false;
        });
        $.toggleQueryBox(true, $linkBox.find('#queryBox'));
    });
}

$(function()
{
    if(link == 'true') showLink(productID, type, orderBy, param);
    var infoShowed = false;
    $('.nav.nav-tabs a[data-toggle="tab"]').on('shown.zui.tab', function(e)
    {
        var href = $(e.target).attr('href');
        var tabPane = $(href + '.tab-pane');
        if(tabPane.size() == 0) return;
        var formID = tabPane.find('.linkBox').find('form:last');
        if(formID.size() == 0) formID = tabPane.find('form:last');
        if(href == '#planInfo' && !infoShowed)
        {
            $('#planInfo img').each(function()
            {
                var $tr = $('#planInfo .detail-content .table-data tbody tr:first');
                width   = $tr.width() - $tr.find('th').width();
                if($(this).parent().prop('tagName').toLowerCase() == 'a') $(this).unwrap();
                setImageSize($(this), width, 0);
            });

            infoShowed = true;
        }
    });

    $('#storyList').on('sort.sortable', function(e, data)
    {
        var list = '';
        for(i = 0; i < data.list.length; i++) list += $(data.list[i].item).attr('data-id') + ',';
        $.post(createLink('productplan', 'ajaxStorySort', 'productID=' + productID), {'stories' : list, 'orderBy' : orderBy, 'pageID' : storyPageID, 'recPerPage' : storyRecPerPage, 'recTotal' : storyRecTotal}, function()
        {
            var $target = $(data.element[0]);
            $target.hide();
            $target.fadeIn(1000);
            order = 'order_asc';
            history.pushState({}, 0, createLink('productplan', 'view', "productID=" + productID + '&type=story&orderBy=' + order));
        });
    });
});
