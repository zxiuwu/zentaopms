<?php
/**
 * The create client view file of setting module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Sun Hao <sunhao@cnezsoft.com>
 * @package     client
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php $viewId = 'clientView-' . $client->id; ?>
<?php js::set('client_' . $client->id, $client)?>
<div id='<?php echo $viewId;?>' class='article-content'>
</div>
<style>#<?php echo $viewId;?>{padding: 0}</style>
<script>
$(function()
{
    $('#<?php echo $viewId;?>').html(window.marked(v['client_<?php echo $client->id;?>'].changeLog));
});
</script>
<?php include '../../common/view/footer.modal.html.php';?>
