<?php js::set('objectType', isset($objectType) ? $objectType : '');?>
<?php if(isset($feedbackID)):?>
<?php $feedback  = $this->loadModel('feedback')->getByID($feedbackID);?>
<?php $inputHtml = html::hidden('feedback', (int)$feedbackID);?>
<?php js::set('storyType', $type);?>
<?php
$replaceHtml  = "<tr id='feedbackBox'>";
$replaceHtml .= "<th>{$lang->story->feedbackBy}</th>";
$replaceHtml .= "<td colspan='2'>";
$replaceHtml .= html::input('feedbackBy', $feedback->feedbackBy, "class='form-control' readonly");
$replaceHtml .= "</td>";
$replaceHtml .= '<td colspan="2" class="sourceTd">';
$replaceHtml .= '<div class="input-group">';
$replaceHtml .= "<div class='input-group-addon'>{$lang->story->notifyEmail}</div>";
$replaceHtml .= html::input('notifyEmail', $feedback->notifyEmail, "class='form-control' readonly");
$replaceHtml .= '</div>';
$replaceHtml .= '</td>';
$replaceHtml .= '</tr>';
?>
<script language='Javascript'>
$(function()
{
    $('#dataform').children('table').find('tr:last').children('td:last').append(<?php echo json_encode($inputHtml)?>);
    $("#navbar .nav li[data-id='browse']").addClass('active');
    $('#feedbackBox').replaceWith(<?php echo json_encode($replaceHtml);?>);

    if(storyType == 'story')
    {
        $('#source').on('change', function()
        {
            $('#source').closest('td').attr('colspan', 1);
            $('#sourceNote').closest('td').attr('colspan', 1);
        });
        $('#source').change();
    }
})
</script>
<?php endif;?>

<?php if(isset($ticketID)):?>
<?php $inputHtml = html::hidden('ticket', $ticketID);?>
<script language='Javascript'>
$(function()
{
    $("#navbar .nav li[data-id=" + objectType + "]").addClass('active');
    $('#dataform').children('table').find('tr:last').children('td:last').append(<?php echo json_encode($inputHtml)?>);
})

</script>
<?php endif;?>
