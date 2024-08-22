/* Remove 'ditto' in first row and control task name width and tips for tasks that consume. */
$(function()
{
    removeDitto();
    $name = $('th.c-name');
    if($name.width() < 165) $name.width(165);
    if(taskConsumed > 0) bootbox.alert(addChildTask);
    $('#customField').on('click', function(){$('#tableBody .chosen-with-drop').removeClass('chosen-with-drop chosen-container-active')});

    $('#customField').click(function()
    {
        hiddenRequireFields();
    });

    /* Implement a custom form without feeling refresh. */
    $('#formSettingForm .btn-primary').click(function()
    {
        saveCustomFields('batchCreateFields', 9, $name, 165);
        return false;
    });
});

$(document).on('change', "[name^='estStarted'], [name^='deadline']", function()
{
    toggleCheck($(this));
})

/**
 * Toggle checkbox.
 *
 * @param  object $obj
 * @access public
 * @return void
 */
function toggleCheck(obj)
{
    var $this  = $(obj);
    var date   = $this.val();
    var $ditto = $this.closest('div').find("input[type='checkBox']");
    if(date == '')
    {
        $ditto.attr('checked', true);
        $ditto.closest('.input-group-addon').show();
    }
    else
    {
        $ditto.removeAttr('checked');
        $ditto.closest('.input-group-addon').hide();
    }
}

/* Get select of stories.*/
function setStories(moduleID, executionID, num)
{
    link = createLink('story', 'ajaxGetExecutionStories', 'executionID=' + executionID + '&productID=0&branch=all&moduleID=' + moduleID + '&storyID=0&num=' + num + '&type=short');
    $.get(link, function(stories)
    {
        var storyID = $('#story' + num).val();
        if(!stories) stories = '<select id="story' + num + '" name="story[' + num + ']" class="form-control"></select>';
        $('#story' + num).replaceWith(stories);
        if(num != 0 && (moduleID == 0 || moduleID == 'ditto')) $('#story' + num).append("<option value='ditto'>" + ditto + "</option>");
        $('#story' + num).val(storyID);
        if($('#zeroTaskStory').hasClass('checked'))
        {
            $('#story' + num).find('option').each(function()
            {
                value = $(this).attr('value');
                if(value != 'ditto' && storyTasks[value] > 0)
                {
                    $(this).hide();
                    if(storyID == value) $('#story' + num).val('');
                }
            })
        }
        var chosenWidth = $("#story" + num + "_chosen").css('max-width');
        $("#story" + num + "_chosen").remove();
        $("#story" + num).next('.picker').remove();
        $("#story" + num).chosen();
        $("#story" + num + "_chosen").width(chosenWidth).css('max-width', chosenWidth);
    });
}

/* Copy story title as task title. */
function copyStoryTitle(num)
{
    var storyTitle = $('#story' + num).find('option:selected').text();
    var storyValue = $('#story' + num).find('option:selected').val();

    if(storyValue === 'ditto')
    {
        for(var i = num; i <= num && i >= 1; i--)
        {
            var selectedValue = $('select[id="story' + i +'"]').val();
            var selectedTitle = $('select[id="story' + i +'"]').find('option:selected').text();
            if(selectedValue !== 'ditto')
            {
                storyTitle = selectedTitle;
                break;
            }
        }
    }

    startPosition  = storyTitle.indexOf(':') + 1;
    endPosition    = storyTitle.lastIndexOf('[');
    storyTitle     = storyTitle.substr(startPosition, endPosition - startPosition);

    $('#name' + num).val(storyTitle);
    $('#estimate' + num).val($('#storyEstimate' + num).val());
    $('#desc' + num).val(($('#storyDesc' + num).val()).replace(/<[^>]+>/g,'').replace(/(\n)+\n/g, "\n").replace(/^\n/g, '').replace(/\t/g, ''));

    var storyPri = $('#storyPri' + num).val();
    if(storyPri == 0) $('#pri' + num ).val('3');
    if(storyPri != 0) $('#pri' + num ).val(storyPri);
}

/* Set the story module. */
function setStoryRelated(num)
{
    setPreview(num);
}

/**
 * Set preview.
 *
 * @param  int $num
 * @access public
 * @return void
 */
function setPreview(num)
{
    var storyID   = $('#story' + num).val();
    var storyLink = '#';
    if(storyID != 0  && storyID != 'ditto')
    {
        var link = createLink('story', 'ajaxGetInfo', 'storyID=' + storyID);
        $.getJSON(link, function(storyInfo)
        {
            $('#module' + num).val(parseInt(storyInfo.moduleID));
            $('#module' + num).trigger("chosen:updated");

            $('#storyEstimate' + num).val(storyInfo.estimate);
            $('#storyPri'      + num).val(storyInfo.pri);
            $('#storyDesc'     + num).val(storyInfo.spec);
        });

        storyLink  = createLink('story', 'view', "storyID=" + storyID);
        if(!isonlybody)
        {
            var concat = storyLink.indexOf('?') >= 0 ? '&' : '?';
            storyLink  = storyLink + concat + 'onlybody=yes';
        }

        $('#preview' + num).removeAttr('disabled');
        $('#preview' + num).modalTrigger({type:'iframe'});
        $('#preview' + num).css('pointer-events', 'auto');
        $('#preview' + num).attr('href', storyLink);
    }
    else
    {
        $('#preview' + num).attr('disabled', true);
        $('#preview' + num).css('pointer-events', 'none');
        $('#preview' + num).attr('href', storyLink);
    }
}

/* Toggle zero task story. */
function toggleZeroTaskStory()
{
    var $toggle = $('#zeroTaskStory').toggleClass('checked');
    var zeroTask = $toggle.hasClass('checked');
    $.cookie('zeroTask', zeroTask, {expires:config.cookieLife, path:config.webRoot});
    $('select[name^="story"]').each(function()
    {
        var $select = $(this);
        var selectVal = $select.val();
        $select.find('option').each(function()
        {
            var $option = $(this);
            var value = $option.attr('value');
            $option.show();
            if(value != 'ditto' && storyTasks[value] > 0 && zeroTask)
            {
                $option.hide();
                if(selectVal == value) selectVal = '';
            }
        })
        $select.val(selectVal).trigger("chosen:updated");
    });
}

// see http://pms.zentao.net/task-view-5086.html
function markStoryTask()
{
    $('select[name^="story"]').each(function()
    {
        var $select = $(this);
        $select.find('option').each(function()
        {
            var $option = $(this);
            var value = $option.attr('value');
            var tasksCount = storyTasks[value];
            $option.attr('data-data', value).toggleClass('has-task', !!(tasksCount && tasksCount !== '0'));
        });
        $select.trigger("chosen:updated");
    });

    var getStoriesHasTask = function()
    {
        var storiesHasTask = {};
        $('#tableBody tbody>tr').each(function()
        {
            var $tr = $(this);
            if ($tr.find('input[name^="name"]').val())
            {
                storiesHasTask[$tr.find('select[name^="story"]').val()] = true;
            }
        });
        return storiesHasTask;
    };

    $('#batchCreateForm').on('chosen:showing_dropdown', 'select[name^="story"],.chosen-with-drop', function()
    {
        var storiesHasTask = getStoriesHasTask();
        var $container     = $(this).closest('td').find('.chosen-container');
        setTimeout(function()
        {
            $container.find('.chosen-results>li').each(function()
            {
                var $li = $(this);
                $li.toggleClass('has-new-task', !!storiesHasTask[$li.data('data')]);
            });
        }, 100);
    });
}

/**
 * Set lane.
 *
 * @param  int $regionID
 * @param  int $num
 * @access public
 * @return void
 */
function setLane(regionID, num)
{
    laneLink = createLink('kanban', 'ajaxGetLanes', 'regionID=' + regionID + '&type=task&field=lanes&i=' + num);
    $.get(laneLink, function(lanes)
    {
        if(!lanes) lanes = '<select id="lanes' + num + '" name="lanes[' + num + ']" class="form-control"></select>';
        $('#lanes' + num).replaceWith(lanes);
        $("#lanes" + num + "_chosen").remove();
        $("#lanes" + num).next('.picker').remove();
        $("#lanes" + num).chosen();
    });
}

$(document).on('chosen:showing_dropdown', 'select[name^="story"],.chosen-with-drop', function()
{
    var select = $(this).closest('td').find('select');
    if($(select).val() == 'ditto')
    {
        var index = $(select).closest('td').index();
        var row   = $(select).closest('tr').index();
        var table = $(select).closest('tr').parent();
        var value = '';
        for(i = row - 1; i >= 0; i--)
        {
            value = $(table).find('tr').eq(i).find('td').eq(index).find('select').val();
            if(value != 'ditto') break;
        }
        $(select).val(value);
        $(select).trigger("chosen:updated");
        $(select).trigger("change");
    }
})

$(document).on('mousedown', 'select', function()
{
    if($(this).val() == 'ditto')
    {
        var index = $(this).closest('td').index();
        var row   = $(this).closest('tr').index();
        var table = $(this).closest('tr').parent();
        var value = '';
        for(i = row - 1; i >= 0; i--)
        {
            value = $(table).find('tr').eq(i).find('td').eq(index).find('select').val();
            if(value != 'ditto') break;
        }
        $(this).val(value);
    }
})

$(function()
{
    $('.chosen-container[id^=module]').width(chosenWidth);
    $('.chosen-container[id^=module]').css('max-width', chosenWidth);

    var chosenWidth = $('#story1_chosen').width();
    $('.chosen-container[id^=story]').width(chosenWidth);
    $('.chosen-container[id^=story]').css('max-width', chosenWidth);

    if($.cookie('zeroTask') == 'true') toggleZeroTaskStory();
    markStoryTask();

    if(storyID != 0) setStoryRelated($('#batchCreateForm table tbody tr:first [id^=story]:first').attr('id').replace('story', ''));

    $(document).keydown(function(event)
    {
        if(event.ctrlKey && event.keyCode == 38)
        {
            event.stopPropagation();
            event.preventDefault();
            selectFocusJump('up');
        }
        else if(event.ctrlKey && event.keyCode == 40)
        {
            event.stopPropagation();
            event.preventDefault();
            selectFocusJump('down');
        }
        else if(event.keyCode == 38)
        {
            inputFocusJump('up');
        }
        else if(event.keyCode == 40)
        {
            inputFocusJump('down');
        }
    });
});
