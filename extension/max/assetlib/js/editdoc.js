$(function()
{
    $('input[name="type"]').change(function()
    {   
        var type = $(this).val();
        if(type == 'text')
        {   
            $('#contentBox').removeClass('hidden');
            $('#urlBox').addClass('hidden');
        }   
        else if(type == 'url')
        {   
            $('#contentBox').addClass('hidden');
            $('#urlBox').removeClass('hidden');
        }   
    }); 
})
