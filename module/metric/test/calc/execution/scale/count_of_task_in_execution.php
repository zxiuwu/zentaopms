#!/usr/bin/env php
<?php
/**

title=count_of_task_in_execution
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

r(count($calc->getResult())) && p('') && e('10'); // 测试分组数。
r($calc->getResult(array('execution' => 11))) && p('0:value') && e('30'); // 测试执行11的任务数。
r($calc->getResult(array('execution' => 12))) && p('0:value') && e('30'); // 测试执行12的任务数。
r($calc->getResult(array('execution' => 13))) && p('0:value') && e('30'); // 测试执行13的任务数。
r($calc->getResult(array('execution' => 110))) && p('') && e('0');        // 测试不存在执行的任务数。

