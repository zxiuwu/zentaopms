#!/usr/bin/env php
<?php
/**

title=day_of_invested_in_project
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('project')->config('project', true, 4)->gen(10);
zdTable('project')->config('sprint', true, 4)->gen(40, false);
zdTable('effort')->config('effort', true, 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('5'); // 测试分组数。

r($calc->getResult(array('project' => '7'))) && p('0:value') && e('18.47'); // 测试项目7。
