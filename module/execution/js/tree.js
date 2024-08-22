/**
 * Expand or collapse text.
 *
 * @access public
 * @return void
 */
function limitText()
{
    var fullText;
    var limitText;
    var $text   = $(this);
    var options = $.extend({limitSize: 40, suffix: '…'}, $text.data());
    var text    = $text.text();
    if(text.length > options.limitSize)
    {
        fullText  = $text.html();
        limitText = text.substring(0, options.limitSize) + options.suffix;
        $text.text(limitText).addClass('limit-text-on');

        var $toggleBtn = options.toggleBtn ? $(options.toggleBtn) : $text.next('.text-limit-toggle');
        $toggleBtn.text($toggleBtn.data('textExpand'));
        $toggleBtn.on('click', function()
        {
            var isLimitOn = $text.toggleClass('limit-text-on').hasClass('limit-text-on');
            if(isLimitOn) $text.text(limitText);
            else $text.html(fullText);
            $toggleBtn.text($toggleBtn.data(isLimitOn ? 'textExpand' : 'textCollapse'));
        });
    }
    else
    {
        (options.toggleBtn ? $(options.toggleBtn) : $text.next('.text-limit-toggle')).hide();
    }
    $text.removeClass('hidden');
};
$.fn.textLimit = function(){return this.each(limitText);};

$(function()
{
    var $taskTree = $('#taskTree').tree(
    {
        name: 'taskTree',
        initialState: 'preserve'
    });

    var taskTree = $taskTree.data('zui.tree');
    if(!taskTree) return;

    var sortItems = function($items)
    {
        var items = $items.toArray();
        for(i = 0; i < items.length; i++)
        {
            for(j = 0; j < items.length - 1 - i; j++)
            {
                if($(items[j + 1]).data('id').toString() > $(items[j]).data('id').toString())
                {
                    var tmp = items[j + 1];
                    items[j + 1] = items[j];
                    items[j] = tmp;
                }
            }
        }
        return items;
    }

    /* Expand the tree list according to the list config.*/
    var showTreeLevel = function(level)
    {
        if(level === 'task' || level === 'story') $('.btn-tree-view').removeClass('btn-active-text');
        $('#taskTree li.item-product').removeClass('hidden');
        $('#taskTree li.item-module').removeClass('hidden');
        $('#taskTree li.item-story').removeClass('hidden');
        $('#taskTree li.item-task').removeClass('hidden');

        if((level === 'root' && collapse == false) || (level === 'task' && collapse == true) || (level === 'story' && collapse == true))
        {
            taskTree.collapse();
            collapse = true;
            if(level === 'task')  type = 'task';
            if(level === 'story') type = 'story';
            $('[data-type=' + type + ']').addClass('btn-active-text');
        }
        else if((level === 'all' && type === 'task') || level === 'task')
        {
            type = 'task';
            collapse = false;
            $('[data-type=task]').addClass('btn-active-text');
            taskTree.collapse();
            taskTree.expand($taskTree.find('li.has-list'), true);
        }
        else if((level === 'all' && type === 'story') || level === 'story')
        {
            type = 'story';
            collapse = false;
            $('[data-type=story]').addClass('btn-active-text');
            taskTree.collapse();
            taskTree.show($taskTree.find('li.item-story').parent().parent(), true);

            $('#taskTree li.item-task').addClass('hidden');
            var $moduleItems = $('#taskTree li.item-module');
            moduleItems = sortItems($moduleItems);
            for(i = 0; i < moduleItems.length; i++)
            {
                var items = $(moduleItems[i]).find('ul li:not(.hidden)').length;
                if(items == 0) $(moduleItems[i]).addClass('hidden');
            }
            var $productItems = $('#taskTree li.item-product');
            $productItems.each(function()
            {
                var items = $(this).find('ul li:not(.hidden)').length;
                if(items == 0) $(this).addClass('hidden');
            });
        }
        $('#main').toggleClass('tree-show-root', collapse);
    };

    $(document).on('click', '.btn-tree-view', function()
    {
        showTreeLevel($(this).data('type'));
        return false;
    });

    /* Expand the all nodes of tree when first visit.*/
    showTreeLevel(type);

    /* Show the content of story or task on right area.*/
    var $itemContent = $('#itemContent');
    var $mainContent = $('#mainContent');
    var isItemLoading = false, lastAjaxRequest;
    var adjustSidePosition = function()
    {
        if($mainContent.hasClass('hide-side')) return;
        var scrollTop = $(document).scrollTop();
        var $cell = $itemContent.closest('.cell');
        var bounding = $cell.parent()[0].getBoundingClientRect();
        $cell.css(
        {
            left: bounding.left + 20,
            top: Math.max(20, 150 - scrollTop),
            bottom: 60,
        });
    };
    var showItem = function(url, loadingText)
    {
        $.zui.messager.hide();
        $mainContent.toggleClass('hide-side', !url);
        if (!url)
        {
            $taskTree.find('li.selected').removeClass('selected');
            isItemLoading = false;
            $.zui.store.set('project/tree/showItem', false);
            return;
        }
        adjustSidePosition();
        if (lastAjaxRequest) lastAjaxRequest.abort();
        $itemContent.empty().addClass('loading').attr('data-loading', loadingText || '');
        isItemLoading = true;
        lastAjaxRequest = $.ajax(
        {
            url: url,
            success: function(data)
            {
                if (!isItemLoading) return;
                $itemContent.html(data).removeClass('loading');
                lastAjaxRequest = null;
                isItemLoading = false;
                $itemContent.find('.text-limit').textLimit();
                $itemContent.find('.histories').histories();
                $itemContent.find('.iframe').modalTrigger();
                $.zui.store.set('project/tree/showItem', url);
                adjustSidePosition();
                setTimeout(adjustSidePosition, 300);
            },
            error: function()
            {
                $mainContent.addClass('hide-side');
                isItemLoading = false;
                $.zui.messager.danger(window.lang.timeout);
            }
        });
    };

    var stopPropagation = function(e) {e.stopPropagation();};
    $taskTree.on('click', '.tree-link', function(e)
    {
        var $link = $(this);
        $.zui.store.set('project/tree/parentLi', $link.closest('li').attr('data-id').length > 0 ? $link.closest('li').attr('data-id') : '')
        showItem($link.attr('href'), $link.find('.title').text());
        $taskTree.find('li.selected').removeClass('selected');
        $link.closest('li').addClass('selected');
        e.preventDefault();
        stopPropagation(e);
    });

    $itemContent.on('click', function(event)
    {
        if(!$(event.target).closest('a[data-app]').length || $(event.target).closest('a').hasClass('iframe')) event.stopPropagation();
    });
    $taskTree.on('click', stopPropagation);
    $(window).on('resize scroll', adjustSidePosition);

    $(document).on('click', function()
    {
        showItem(false);
    }).on('ready', function()
    {
        var lastUrl = $.zui.store.get('project/tree/showItem');
        var lastLi  = $.zui.store.get('project/tree/parentLi');
        if(lastUrl)
        {
            showItem(lastUrl);
            $taskTree.find('li[data-id="' + lastLi + '"]').find('.tree-link[href="' + lastUrl + '"]').closest('li').addClass('selected');
        }
    });
});
