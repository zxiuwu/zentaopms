#!/usr/bin/env php
<?php
/**

title=count_of_finished_task_in_project
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('project')->config('project_status', true, 4)->gen(10);
zdTable('project')->config('execution', true, 4)->gen(20, false);
zdTable('task')->config('task', true, 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('15'); // 测试分组数。
r($calc->getResult(array('project' => 13))) && p('0:value') && e('3'); // 测试项目11的已完成任务数
r($calc->getResult(array('project' => 25))) && p('0:value') && e('3'); // 测试项目23的已完成任务数
r($calc->getResult(array('project' => 37))) && p('0:value') && e('3'); // 测试项目35的已完成任务数
