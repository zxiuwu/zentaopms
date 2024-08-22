$(function()
{
    $('#point').change(function()
    {
        var type = $(this).val();
        var text = reviewText + $('#pickerDropMenu-pk_point').find("a[data-value=" + type + "]").find('.picker-option-text').text();

        $('#title').val(text);

        var link = createLink('review', 'ajaxGetNodes', "project=" + projectID + '&object=' + type);
        $('#reviewerBox').load(link, function(){$(this).find('select').chosen()});

        if(type == 'other')
        {
            $('#template').closest('tr').removeClass('hidden');
            $('#contenttemplate').closest('tr').removeClass('hidden');
            $('#doclib').closest('tr').removeClass('hidden');
            $('#object').closest('td').removeClass('hidden');
        }
        else
        {
            $('#template').closest('tr').addClass('hidden');
            $('#contenttemplate').closest('tr').addClass('hidden');
            $('#doclib').closest('tr').addClass('hidden');
            $('#object').closest('td').addClass('hidden');
            $('#object').closest('tbody').find('tr').removeClass('hide');
        }
    })

    if(typeof(reviewedPoints) != 'undefined')
    {
        $('#point option').each(function() {
            var $value = $(this).val();
            if($value == 'other' || $value == '') return;

            var stagePoints = reviewedPoints[$value];
            if(stagePoints.disabled === false) return;
            if($value in reviewedPoints) $(this).prop('disabled', true);
        });
    }

    $('#point').picker({
        maxDropHeight: 500
    });
})
