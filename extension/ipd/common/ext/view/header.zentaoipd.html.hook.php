<?php if(strpos($config->version, 'ipd') === 0):?>
<script>
$(function()
{
    $('#globalBarLogo a').eq(1).attr('title', '<?php echo ($config->inQuickon ? $lang->devopsPrefix : '') . str_replace('ipd', $lang->ipdName . ' ', $config->version);?>');
    $('#globalBarLogo a .version').html('<?php echo ' ' . ($config->inQuickon ? $lang->devopsPrefix : '') . str_replace('ipd', $lang->ipdName . ' ', $config->version);?>');
    $('#globalBarLogo a .upgrade').html('<?php echo $lang->upgrade->common;?>');
})
</script>
<?php endif;?>
