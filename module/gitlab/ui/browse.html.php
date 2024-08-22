<?php
declare(strict_types=1);
/**
 * The browse view file of gitlab module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Ke Zhao<zhaoke@easycorp.ltd>
 * @package     gitlab
 * @link        http://www.zentao.net
 */

namespace zin;

featureBar();

/* zin: Define the toolbar on main menu. */
$canCreate  = hasPriv('gitlab', 'create');
$createLink = $this->createLink('gitlab', 'create');
$createItem = array('text' => $lang->gitlab->create, 'url' => $createLink, 'class' => 'primary', 'icon' => 'plus');

$tableData = initTableData($gitlabList, $config->gitlab->dtable->fieldList, $this->gitlab);

toolbar
(
    $canCreate ? item(set($createItem)) : null,
);

jsVar('confirmDelete',    $lang->gitlab->confirmDelete);
jsVar('orderBy',          $orderBy);
jsVar('canBrowseProject', common::hasPriv('gitlab', 'browseProject'));
jsVar('sortLink',         helper::createLink('gitlab', 'browse', "orderBy={orderBy}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}"));

dtable
(
    set::cols(array_values($config->gitlab->dtable->fieldList)),
    set::data($tableData),
    set::sortLink(jsRaw('createSortLink')),
    set::onRenderCell(jsRaw('window.renderCell')),
    set::footPager(usePager()),
);

render();
