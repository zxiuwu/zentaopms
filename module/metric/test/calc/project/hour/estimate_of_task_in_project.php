#!/usr/bin/env php
<?php
/**

title=estimate_of_task_in_project
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

r(count($calc->getResult())) && p('') && e('90'); // 测试分组数。
r($calc->getResult(array('project' => 11))) && p('0:value') && e('5'); // 测试项目11的任务预计工时数。
r($calc->getResult(array('project' => 12))) && p('0:value') && e('5'); // 测试项目12的任务预计工时数。
r($calc->getResult(array('project' => 13))) && p('0:value') && e('5'); // 测试项目13的任务预计工时数。
r($calc->getResult(array('project' => 110))) && p('') && e('0');       // 测试不存在项目的任务预计工时数。
