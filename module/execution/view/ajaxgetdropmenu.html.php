<?php
/**
 * 获取项目所属分组。
 * Get execution group.
 *
 * @param object $execution
 * @return string
 */
$getExecutionGroup = function($execution)
{
    global $app;
    if($execution->status != 'done' and $execution->status != 'closed' and ($execution->PM == $app->user->account or isset($execution->teams[$app->user->account]))) return 'my';
    if($execution->status != 'done' and $execution->status != 'closed' and $execution->PM != $app->user->account and !isset($execution->teams[$app->user->account])) return 'other';
    if($execution->status == 'done' or $execution->status == 'closed') return 'closed';
};

/**
 * 定义每个分组下的选项数据列表。
 * Define the grouped data list.
 */
$data = array('my' => array(), 'other' => array(), 'closed' => array());

/* 处理分组数据。Process grouped data. */
foreach($projectExecutions as $projectID => $executions)
{
    $projectItem = array($projectID, zget($projects, $projectID), '', 'project', array());

    foreach($executions as $index => $execution)
    {
        $group = $onlyClosed ? 'closed' : $getExecutionGroup($execution);

        $item = array($execution->id, $execution->name, zget($namePinyinList, $execution->name, ''));

        if(!isset($data[$group][$projectID])) $data[$group][$projectID] = $projectItem;
        $data[$group][$projectID][4][] = $item;
    }
}

/* 将分组数据转换为索引数组。Format grouped data to indexed array. */
foreach ($data as $key => $value) $data[$key] = array_values($value);

if($onlyClosed)
{
    echo json_encode($data['closed']);
}
else
{
    /**
     * 定义每个分组名称信息，包括可展开的已关闭分组。
     * Define every group name, include expanded group.
     */
    $tabs = array();
    $tabs[] = array('name' => 'my',     'text' => $lang->execution->involved);
    $tabs[] = array('name' => 'other',  'text' => $lang->execution->other);
    $tabs[] = array('name' => 'closed', 'text' => $lang->execution->closedExecution);

    /**
     * 定义最终的 JSON 数据。
     * Define the final json data.
     */
    $json = array();
    $json['data']       = $data;
    $json['selected']   = (int)$executionID;
    $json['tabs']       = $tabs;
    $json['searchHint'] = $lang->searchAB;
    $json['link']       = array('execution' => sprintf($link, '{id}'));
    $json['labelMap']   = array('project' => $lang->project->common);
    $json['expandName'] = 'closed';
    $json['itemType']   = 'execution';
    $json['expandUrl']  = helper::createLink('execution', 'ajaxGetDropMenu', "executionID=$executionID&module=$module&method=$method&extra=$extra&type=closed");

    /**
     * 渲染 JSON 字符串并发送到客户端。
     * Render json data to string and send to client.
     */
    echo json_encode($json);
}
