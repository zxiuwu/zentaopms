function changeParams(obj)
{
    var begin = $('#conditions').find('#begin').val();
    var end   = $('#conditions').find('#end').val();
    var dept  = $('#conditions').find('#dept').val();
    if(begin.indexOf('-') != -1)
    {
        var beginarray = begin.split("-");
        var begin = '';
        for(i=0 ; i < beginarray.length ; i++)
        {
            begin = begin + beginarray[i];
        }
    }
    if(end.indexOf('-') != -1)
    {
        var endarray = end.split("-");
        var end = '';
        for(i=0 ; i < endarray.length ; i++)
        {
            end = end + endarray[i];
        }
    }

    var params = window.btoa('begin=' + begin + '&end=' + end + '&dept=' + dept);
    var link = createLink('pivot', 'preview', 'dimension=' + dimension + '&group=' + groupID + '&module=pivot&method=worksummary&params=' + params);
    location.href = link;
}
