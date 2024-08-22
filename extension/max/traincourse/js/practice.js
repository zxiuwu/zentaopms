$(function()
{
    $.get(createLink('traincourse', 'ajaxupdatepractice'));

    $(".update-practice").click(function()
    {
        if(confirm(updatePracticeTip))
        {
            $.get(createLink('traincourse', 'updatepractice'), function(response)
            {
                if(JSON.parse(response).result === 'success') location.reload();
            });
        }
    });
});
