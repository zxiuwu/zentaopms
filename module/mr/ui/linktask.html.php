<?php
declare(strict_types=1);
/**
 * The linktask file of mr module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Ke Zhao <zhaoke@easycorp.ltd>
 * @package     mr
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('orderBy',  $orderBy);
jsVar('sortLink', createLink('mr', 'linkTask', "MRID=$MRID&productID=$product->id&browseType=$browseType&param=$param&orderBy={orderBy}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}"));

detailHeader
(
    to::prefix(''),
    to::title
    (
        $lang->repo->linkTask,
    )
);

$footToolbar = array('items' => array
(
    array('text' => $lang->repo->linkTask, 'className' => 'batch-btn ajax-btn', 'data-url' => helper::createLink('mr', 'linkTask', "MRID=$MRID&productID=$product->id&browseType=$browseType&param=$param&orderBy=$orderBy"))
), 'btnProps' => array('size' => 'sm', 'btnType' => 'secondary', 'data-type' => 'tasks'));

div(setID('searchFormPanel'), set('data-module', 'task'), searchToggle(set::open(true), set::module('task')));

div
(
    set('class', 'mr-linkstory-title'),
    icon('unlink'),
    span
    (
        set('class', 'font-semibold ml-2'),
        $lang->repo->unlinkedTasks . "({$pager->recTotal})"
    )
);
$allTasks = initTableData($allTasks, $config->repo->taskDtable->fieldList);
$data = array_values($allTasks);
dtable
(
    set::userMap($users),
    set::data($data),
    set::cols($config->repo->taskDtable->fieldList),
    set::checkable(true),
    set::footToolbar($footToolbar),
    set::sortLink(jsRaw('createSortLink')),
    set::footer(array('checkbox', 'toolbar', array('html' => html::a(inlink('link', "MRID=$MRID&type=task"), $lang->goback, '', "class='btn size-sm'")), 'flex', 'pager')),
    set::footPager(usePager()),
);

render();
