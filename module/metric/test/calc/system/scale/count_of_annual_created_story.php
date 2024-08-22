#!/usr/bin/env php
<?php
/**

title=count_of_annual_created_story
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('product')->config('product', true, 4)->gen(10);
zdTable('story')->config('story_status', true, 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('11'); // 测试按产品的年度新增需求分组数。

r($calc->getResult(array('year' => '2019'))) && p('0:value') && e('20'); // 测试2019年新增的需求数。
r($calc->getResult(array('year' => '2020'))) && p('0:value') && e('16'); // 测试2020年新增的需求数。
r($calc->getResult(array('year' => '2021'))) && p('')        && e('0');  // 测试不存在的产品的需求数。
