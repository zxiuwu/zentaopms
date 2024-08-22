#!/usr/bin/env php
<?php
/**

title=count_of_delayed_finished_execution_which_annual_finished
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('project')->config('project_close',     true, 4)->gen(10);
zdTable('project')->config('execution_delayed', true, 4)->gen(100, false);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('2'); // 测试分组数

r($calc->getResult(array('year' => '2011'))) && p('0:value') && e('8'); // 测试2011年完成执行中延期完成执行数
r($calc->getResult(array('year' => '2012'))) && p('0:value') && e('8'); // 测试2012年完成执行中延期完成执行数
