window.setUserEmail = function()
{
    let   email   = '';
    const account = $(this).val();
    if(account && zentaoUsers[account]) email = zentaoUsers[account].email;

    $(this).closest('.dtable-cell').prev().find('.dtable-cell-content').text(email);
}

window.renderGitlabUser = function(result, {row})
{
    const gogsID = row.data.gogsID;
    result.push({html: `<input type="hidden" name='gogsUserNames[]' value='${gogsID}'>`});

    return result;
}

window.bindUser = function()
{
    const myDTable = $('#table-gogs-binduser').zui('dtable');
    const formData = myDTable.$.getFormData();

    var bindData = $('#table-gogs-binduser').zui('dtable').$.props.data;
    var postData = {};
    postData['gogsUserNames[]'] = [];
    for(i in bindData)
    {
        postData['gogsUserNames[]'].push(bindData[i].gogsID);
        postData['zentaoUsers[' + bindData[i].gogsID + ']'] = formData['zentaoUsers[' + bindData[i].gogsID + ']'];
    }

    $.ajaxSubmit({
        url: $.createLink('gogs', 'bindUser', 'gogsID=' + gogsID + '&type=' + type),
        data: postData
    });
}
