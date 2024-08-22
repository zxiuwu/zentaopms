window.saveModule = function()
{
    const name = $(this).val();
    if(!name) return $(this).closest('.tree-item').remove();

    const {id, type, lib, module} = $(this).data();
    const parentID = $(this).data('parent');

    const $element = $(`div[data-id='${id}']`);
    $.ajaxSubmit({
        url:  $.createLink('tree', 'ajaxCreateModule'),
        data: {
            name       : name,
            libID      : lib,
            parentID   : type == 'child' ? id : parentID,
            objectID   : id,
            moduleType : module,
            isUpdate   : false,
            createType : type,
        },
        onSuccess: () =>
        {
            $(this).val('');
        }
    });
}

window.addModule = function(id, addType)
{
    const $element = $(`div[data-id='${id}']`);
    const {lib, type, module} = $element.data();

    let parentID = ['docLib', 'apiLib'].includes(type) ? '0' : $element.data('parent');
    if(addType == 'child') parentID = id;

    const level = addType == 'same' ? $element.data('level') : $element.data('level') + 1;
    const style = `style="margin-left: calc(${level} * var(--tree-indent, 20px))"`;

    let inputTpl  = '<li class="tree-item">';
    inputTpl     += `<div class="tree-item-content" ${style}>`;
    inputTpl     += `<input id="moduleName" class="form-control" data-id="${id}" data-parent="${parentID}" data-type="${addType}" data-lib="${lib}" data-module="${module}">`;
    inputTpl     += '</div></li>';

    if(addType == 'same')
    {
        $(`div[data-id='${id}']`).before(inputTpl);
    }
    else
    {
        if(!$element.parent().hasClass('show')) $element.find('.tree-toggle-icon').trigger('click');

        setTimeout(function()
        {
            if($element.next('.tree').length == 0) $element.after(`<menu class="tree" level="${level}" data-level="${level}"></menu>`);

            $(`div[data-id='${id}']`).next('.tree').prepend(inputTpl);
        }, 1);
    }

    setTimeout(function()
    {
        $('#moduleName').trigger('focus');
        document.getElementById("moduleName").addEventListener('blur', saveModule);
        document.getElementById("moduleName").addEventListener('keydown', function(e)
        {
            if(e.keyCode == 13) saveModule.call(this);
        });
    }, 1);
}
