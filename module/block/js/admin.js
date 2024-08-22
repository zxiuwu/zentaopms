$(function()
{
    var blockTitle = '';
    var preValue   = '';
    var $titleInput;
    $(document).on('change', '#blockParams #paramstype', function()
    {
        $titleInput = $('#blockParams').find('#title');
        var title = $titleInput.val();
        var value = $(this).find('option:selected').text();

        if($blocksList.find('#moduleBlock').val() == 'scrumtest' && $('#paramstype').val() != 'all')
        {
            $titleInput.val(value);
        }
        else
        {
            var lang   = config.clientLang;
            blockTitle = $blockParams.find('#title').val();
            if(lang.indexOf('zh') >= 0)
            {
                if(blockTitle.indexOf(preValue) >= 0)
                {
                    blockTitle = blockTitle.replace(preValue, value);
                }
                else
                {
                    if(blockTitle.indexOf(preValue) < 0)  blockTitle = value + of + title;;
                }
                $titleInput.val(blockTitle);
            }
            else
            {
                var preIndex = blockTitle.indexOf(of + preValue);
                if(preIndex >= 0) blockTitle = blockTitle.substring(0, preIndex);
                $titleInput.val(blockTitle + of + value);
            }
        }

        preValue = value;
    });

    var $form = $('#blockAdminForm');
    $form.find('.chosen').chosen();

    // Used to dynamically load block list and set parameters.
    var $blocksList = $('#blocksList');
    var $blockParams = $('#blockParams');

    var updateParams = function(data)
    {
        $blockParams.html(data);
        $blockParams.find('.chosen').chosen();
        $.zui.ajustModalPosition();
        $form.removeClass('loading');
        $form.addClass('form-inited');
        $blockParams.find('input:first').focus();
        if($blockParams.find('#actionLink').size() > 0) $form.attr('action', $blockParams.find('#actionLink').val());

        $titleInput = $blockParams.find('#title');
        if($titleInput.length && $('#paramstype').length)
        {
            blockTitle   = $titleInput.val();
            preValue     = $('#paramstype').find('option:selected').text();

            var preIndex = blockTitle.indexOf(' - ' + preValue);
            if(preIndex >= 0) blockTitle = blockTitle.substring(0, preIndex);

            if($blocksList.find('#moduleBlock').val() == 'scrumtest')
            {
                $titleInput.val(preValue);
            }
            else
            {
                var lang = config.clientLang;
                if(!title && blockTitle.indexOf(of) < 0) lang.indexOf('zh') >= 0 ? $titleInput.val(preValue + of + blockTitle) : $titleInput.val(blockTitle + of + preValue);
            }
        }
    };

    // Get parameters for html and rss.
    var getNotSourceParams = function(type, blockID)
    {
        if (blockID === undefined) blockID = 0;

        $blockParams.empty();
        $form.removeClass('form-inited');

        $.get(createLink('block', 'set', 'id=' + blockID + '&type=' + type), function(data)
        {
            updateParams(data);
            if(type === 'welcome') $blockParams.find('#title').closest('.form-group').hide();
        });
    };

    // Set parameters to get the specified block.
    var getBlockParams = function(type, moduleID)
    {
        $blockParams.empty();
        $form.removeClass('form-inited');

        if(type == '') return;
        $form.addClass('loading');
        $.get(createLink('block', 'set', 'id=' + blockID + '&type=' + type + '&source=' + moduleID), updateParams);
    };

    // Get all available blocks under the specified module.
    var getBlocks = function(moduleID)
    {
        $blocksList.data('module', moduleID).empty();
        $form.removeClass('form-inited');
        $blockParams.empty();
        if(!moduleID) return;

        $form.addClass('loading');

        var onFinish = function()
        {
            $form.removeClass('loading');
            if($blocksList.find('#moduleBlock').val() != '') getBlockParams($blocksList.find('#moduleBlock').val(), $blocksList.data('module'));
        };

        if(moduleID.indexOf('hiddenBlock') != -1)
        {
            getNotSourceParams('html', moduleID.replace('hiddenBlock', ''), onFinish);
            return true;
        }

        if(moduleID == 'html' || moduleID == 'dynamic' || moduleID == 'guide' || moduleID == 'assigntome' || moduleID == 'welcome' || moduleID == 'contribute')
        {
            getNotSourceParams(moduleID, blockID, onFinish);
            return true;
        }

        $.get(createLink('block', 'main', 'module=' + moduleID + '&id=' + blockID), {mode:'getblocklist'}, function(data)
        {
            $blocksList.html(data);
            $blocksList.find('.chosen').chosen();
            onFinish();
            $.zui.ajustModalPosition();
        });
    };

    // Refresh parameter list when module selection changes.
    $('#modules').on('change', function()
    {
        getBlocks($(this).val());
    });

    $blocksList.on('change', '#moduleBlock', function()
    {
        getBlockParams($(this).val(), $blocksList.data('module'));
    });

    if(blockID) setTimeout(function(){getBlocks($('#modules').val());}, 200);
    if(module) $blocksList.data('module', module);
});
