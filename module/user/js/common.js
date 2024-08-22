/**
 * Switch account
 *
 * @param  string $account
 * @param  string $method
 * @access public
 * @return void
 */
$(document).ready(function()
{
    var verifyEncrypted = false;
    $('#verifyPassword').change(function(){verifyEncrypted = false})
    $('#verifyPassword').closest('form').find('#submit').click(function()
    {
        var password = $('input#verifyPassword').val().trim();
        var rand = $('input#verifyRand').val();
        if(!verifyEncrypted && password) $('input#verifyPassword').val(md5(md5(password) + rand));
        verifyEncrypted = true;
    });
});

function switchAccount(account, method)
{
    if(method == 'dynamic')
    {
        link = createLink('user', method, 'account=' + account + '&period=' + period);
    }
    else if(method == 'todo')
    {
        link = createLink('user', method, 'account=' + account + '&type=' + type);
    }
    else
    {
        link = createLink('user', method, 'account=' + account);
    }
    location.href=link;
}

var mailsuffix = '';
var account    = [];
function setDefaultEmail(num)
{
    var mailValue = $('.email_' + num).val();
    if(mailValue.indexOf('@') <= 0) return;
    if(mailValue.indexOf('@') > 0) mailValue = mailValue.substr(mailValue.indexOf('@'));
    mailsuffix = mailValue;
}

function changeEmail(num)
{
    var mailValue = $('.email_' + num).val();
    if(mailsuffix != '' && (mailValue == '' || mailValue == account[num] + mailsuffix)) $('.email_' + num).val($('.account_' + num).val() + mailsuffix);
    account[num] = $('.account_' + num).val();
}

function checkPassword(password)
{
    $('#passwordStrength').html(password == '' ? '' : passwordStrengthList[computePasswordStrength(password)]);
    $('#passwordStrength').css('display', password == '' ? 'none' : 'table-cell');
}
