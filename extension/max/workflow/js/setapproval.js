$(function()
{
    $('input[name=approval]').change(function()
    {
        var approval = $(this).val();
        $('.approval-select').toggle(approval == 'enabled');
        $('.submit-box').toggle(approval != 'enabled' || window.approvalCount != 0);
    })
    $('input[name=approval][checked=checked]').change();

    $.setAjaxForm('#setForm', function(response)
    {
        if(response.result == 'fail')
        {
            if(response.coverMessage)
            {
                $('#coverContent').html(response.coverMessage);
                $('#coverModal').modal();
                $('#coverButton').click(function()
                {
                    $('#setForm').append("<input value='1' name='cover' class='hide'>");
                    $('#setForm #submit').click();
                })
            }
            else
            {
                setTimeout(function(){location.reload();}, 1200);
            }
        }
        else
        {
            if(response.locate == 'reload')
            {
                setTimeout(function(){location.reload();}, 1200);
            }
            else
            {
                setTimeout(function(){location.href = response.locate;}, 1200);
            }
        }
        $('input[name=cover]').remove();
    });
})
