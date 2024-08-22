<?php
/**
 * Adjust the action clickable.
 *
 * @param  object $story
 * @param  string $action
 * @access public
 * @return void
 */
public static function isClickable($story, $action)
{
    global $app, $config;
    $action = strtolower($action);

    if($action == 'recall')     return strpos('reviewing,changing', $story->status) !== false;
    if($action == 'close')      return $story->status != 'closed';
    if($action == 'activate')   return $story->status == 'closed';
    if($action == 'assignto')   return $story->status != 'closed';
    if($action == 'batchcreate' and $story->parent > 0) return false;
    if($action == 'batchcreate' and !empty($story->twins)) return false;
    if($action == 'batchcreate' and $story->type == 'requirement' and $story->status != 'closed') return strpos('draft,reviewing,changing', $story->status) === false;
    if($action == 'submitreview' and strpos('draft,changing', $story->status) === false) return false;

    static $shadowProducts = array();
    static $hasShadow      = true;
    if($hasShadow and empty($shadowProducts[$story->product]))
    {
        global $dbh;
        $stmt = $dbh->query('SELECT id FROM ' . TABLE_PRODUCT . " WHERE shadow = 1")->fetchAll();
        if(empty($stmt)) $hasShadow = false;
        foreach($stmt as $row) $shadowProducts[$row->id] = $row->id;
    }

    if($story->parent < 0 and strpos($config->story->list->actionsOpratedParentStory, ",$action,") === false) return false;

    if($action == 'batchcreate' and $config->vision == 'lite' and ($story->status == 'active' and ($story->stage == 'wait' or $story->stage == 'projected'))) return true;
    /* Adjust code, hide split entry. */
    if($action == 'batchcreate' and ($story->status != 'active' or (isset($shadowProducts[$story->product])) or (!isset($shadowProducts[$story->product]) && $story->stage != 'wait') or !empty($story->plan))) return false;

    $story->reviewer  = isset($story->reviewer)  ? $story->reviewer  : array();
    $story->notReview = isset($story->notReview) ? $story->notReview : array();
    $isSuperReviewer = strpos(',' . trim(zget($config->story, 'superReviewers', ''), ',') . ',', ',' . $app->user->account . ',');

    if($action == 'change')     return (($isSuperReviewer !== false or count($story->reviewer) == 0 or count($story->notReview) == 0) and ($story->type == 'story' ? $story->status == 'active' : ($story->status == 'launched' or $story->status == 'developing')));
    if($action == 'review')     return (($isSuperReviewer !== false or in_array($app->user->account, $story->notReview)) and $story->status == 'reviewing');

    return true;
}


/**
 * Build operate menu.
 *
 * @param  object $story
 * @param  string $type
 * @param  object $execution
 * @param  string $storyType story|requirement
 * @access public
 * @return string
 */
public function buildOperateMenu($story, $type = 'view', $execution = '', $storyType = 'story')
{
    $this->lang->story->changeTip = $storyType == 'story' ? $this->lang->story->changeTip : $this->lang->story->URChangeTip;

    return parent::buildOperateMenu($story, $type, $execution, $storyType);
}
