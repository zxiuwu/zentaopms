<?php
/**
 * The testsuite module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禪道軟件（青島）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     testsuite
 * @version     $Id: zh-tw.php 4490 2013-02-27 03:27:05Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->testsuite->create           = "建套件";
$lang->testsuite->delete           = "刪除套件";
$lang->testsuite->view             = "概況";
$lang->testsuite->edit             = "編輯套件";
$lang->testsuite->browse           = "套件列表";
$lang->testsuite->linkCase         = "關聯用例";
$lang->testsuite->linkVersion      = "版本";
$lang->testsuite->unlinkCase       = "移除";
$lang->testsuite->unlinkCaseAction = "移除用例";
$lang->testsuite->batchUnlinkCases = "批量移除用例";
$lang->testsuite->deleted          = '已刪除';
$lang->testsuite->successSaved     = '保存成功';

$lang->testsuite->id             = '編號';
$lang->testsuite->pri            = '優先順序';
$lang->testsuite->common         = '套件';
$lang->testsuite->project        = '所屬' . $lang->projectCommon;
$lang->testsuite->product        = '所屬' . $lang->productCommon;
$lang->testsuite->name           = '名稱';
$lang->testsuite->type           = '類型';
$lang->testsuite->desc           = '描述';
$lang->testsuite->mailto         = '抄送給';
$lang->testsuite->author         = '訪問權限';
$lang->testsuite->addedBy        = '由誰創建';
$lang->testsuite->addedDate      = '創建時間';
$lang->testsuite->lastEditedBy   = '最後編輯人';
$lang->testsuite->lastEditedDate = '最後編輯時間';

$lang->testsuite->legendDesc      = '描述';
$lang->testsuite->legendBasicInfo = '基本信息';

$lang->testsuite->unlinkedCases = '未關聯';

$lang->testsuite->confirmDelete     = '您確認要刪除該套件嗎？';
$lang->testsuite->confirmUnlinkCase = '您確認要移除該用例嗎？';
$lang->testsuite->noticeNone        = '您還沒有創建套件';
$lang->testsuite->noModule          = '<div>您現在還沒有模組信息</div><div>請維護用例庫模組</div>';
$lang->testsuite->noTestsuite       = '暫時沒有套件。';
$lang->testsuite->summary           = "本頁共 <strong>%total%</strong> 個套件，公開 <strong>%public%</strong> 個，私有 <strong>%private%</strong> 個。";

$lang->testsuite->lblCases      = '用例列表';
$lang->testsuite->lblUnlinkCase = '移除用例';

$lang->testsuite->authorList['private'] = '私有';
$lang->testsuite->authorList['public']  = '公開';

$lang->testsuite->featureBar['browse']['all'] = '套件列表';
