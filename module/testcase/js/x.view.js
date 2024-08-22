$(function()
{
    $('.main-actions-holder').css('height', '0px');
    var xuanAction = "<div class='xuancard-actions fixed'>";
    $('.main-col div.main-actions .btn-toolbar a').each(function(){
        var $that    = $(this);

        if($that.attr('id') == 'back') return true;

        var href     = $that.attr('href');
        var title    = $that.attr('title') == undefined ? '' : " title='" + $that.attr('title') + "'";
        var btnClass = " class='" + $that.attr('class') + "'";
        btnClass = btnClass.replace(/results/, '');
        btnClass = btnClass.replace(/runCase/, '');
        var action   = $that.html();

        if(href.indexOf('create') >= 0 || href.indexOf('delete') >= 0) return true;

        if($that.hasClass('iframe'))
        {
            url = href;
            target = '';
        }
        else
        {
           url = 'xxc:openUrlInDialog/' + encodeURIComponent(sysurl + href);
           target = " target='_blank'";
        }

        xuanAction += "<a href='" + url + "'" + title + target + btnClass + '>' + action + "</a>";
    });

    xuanAction += '</div>';
    $('body').append(xuanAction);
    $('.xuancard-actions a.iframe').modalTrigger();
})
