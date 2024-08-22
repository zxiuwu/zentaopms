var iframeHeight  = 0;
var sidebarHeight = 0;
var tabTemp;
var parentTree = [];

/* Close tab. */
$('#monacoTabs').on('click', '.monaco-close', function()
{
    var eleId    = $(this).parent().attr('href');
    var tabsEle  = $(this).parent().parent().parent();
    var isActive = $(this).parent().hasClass('active');

    $(this).parent().parent().remove();
    $(eleId).remove();
    $('#' + eleId.substring(5)).parent().removeClass('selected');
    if(isActive) tabsEle.children().last().find('a').trigger('click');
    if(!tabsEle.children().length) $('.monaco-dropmenu').addClass('hidden');

    arrowTabs('monacoTabs', -1);
});

window.afterPageUpdate = function()
{
    setTimeout(function()
    {
        var fileAsId = file.replace(/=/g, '-');
        /* Resize moaco height. */
        $('#monacoTree').css('height', getSidebarHeight() - 8 + 'px');
        /* Init tab template. */
        if(!tabTemp) tabTemp = $('#monacoTabs ul li').first().clone();

        /* Load default tab content. */
        var height = getIframeHeight();
        $.cookie.set('repoCodePath', file);
        $('#tab-' + fileAsId).html("<iframe class='repo-iframe' src='" + $.createLink('repo', 'ajaxGetEditorContent', urlParams.replace('%s', '')) + "' width='100%' height='" + height + "' scrolling='no'></iframe>")

        /* Select default tree item. */
        const currentElement = findItemInTreeItems(tree, fileAsId, 0);
        if(currentElement != undefined) $('#' + currentElement.id).parent().addClass('selected');

        if(['Git', 'Gitlab', 'Gogs', 'Gitea'].indexOf(repo.SCM) == -1)
        {
            $('#sourceSwapper').hide();
        }
        expandTree();

        $('.btn-left').on('click', function()  {arrowTabs('monacoTabs', 1);});
        $('.btn-right').on('click', function() {arrowTabs('monacoTabs', -2);});

        /* Reload current page when click dropmeu. */
        $('body').on('click', '.dropmenu-tree .dropmenu-item', function()
        {
            var branchOrTag = $(this).attr('title');
            var url         = $(this).data('url');

            if(url != 'javascript:;') return;

            if(branchOrTag != $.cookie.get('repoBranch')) $.cookie.set('repoBranch', branchOrTag);

            openUrl(currentLink);
        })

        $('.repoDropDownMenu').on('click', function()
        {
            var url            = $(this).data('link');
            var activeFilePath = $('#monacoTabs .nav-item .active').attr('href').substring(5).replace(/-/g, '=');
            if(url.indexOf('blame') >=0 && url.indexOf('download') == -1)
            {
                openUrl(url.replace('{path}', activeFilePath));
            }
            else
            {
                window.open(url.replace('{path}', activeFilePath));
            }
            return;
        })
    }, 200);
};

/**
 * 点击左侧菜单打开详情tab。
 * Open new tab when click tree item.
 *
 * @access public
 * @return void
 */
window.treeClick = function(info)
{
    if (info.item.items && info.item.items.length > 0) return;
    $('#' + info.item.id).parent().addClass('selected');
    openTab(info.item.key, info.item.text);
    arrowTabs('monacoTabs', -2);
}

/**
 * 打开新tab。
 * Open new tab.
 *
 * @access public
 * @return void
 */
function openTab(entry, name)
{
    var eleId   = 'tab-' + entry.replace(/=/g, '-');
    var element = document.getElementById(eleId);
    if (element)
    {
        $("a[href='" + '#' + eleId + "']").trigger('click');
        return;
    }

    var newTab = tabTemp.clone();
    newTab.find('a').attr('href', '#' + eleId);
    newTab.find('span').text(name);
    $('#monacoTabs .nav-tabs').append(newTab);

    var height = getIframeHeight();
    $.cookie.set('repoCodePath', entry);
    $('#monacoTabs .tab-content').append("<div id='" + eleId + "' class='tab-pane active in'><iframe class='repo-iframe' src='" + $.createLink('repo', 'ajaxGetEditorContent', urlParams.replace('%s', '')) + "' width='100%' height='" + height + "' scrolling='no'></iframe></div>")

    if($('.monaco-dropmenu').attr('class').indexOf('hidden')) $('.monaco-dropmenu').removeClass('hidden');
    setTimeout(() => {
        $("a[href='" + '#' + eleId + "']").trigger('click');
    }, 100);
}

/**
 * 在当前页面用modal加载链接。
 * Load link object page.
 *
 * @param  string $link
 * @access public
 * @return void
 */
window.loadLinkPage = function(link)
{
    $('#linkObject').attr('href', link);
    $('#linkObject').trigger('click');
}
