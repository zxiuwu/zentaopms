#!/usr/bin/env php
<?php
/**

title=count_of_annual_closed_story_in_product
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('story')->config('story_status', true, 4)->gen(1000);
zdTable('product')->config('product', true, 4)->gen(10);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r(count($calc->getResult()))                                     && p('')        && e('47'); // 测试分组数。
r($calc->getResult(array('product' => '1',  'year' => '2012')))  && p('0:value') && e('2');  // 测试2012年产品1关闭的研发需求数。
r($calc->getResult(array('product' => '1',  'year' => '2019')))  && p('0:value') && e('1');  // 测试2019年产品1关闭的研发需求数。
r($calc->getResult(array('product' => '2',  'year' => '2019')))  && p('0:value') && e('0');  // 测试已删除产品2研发需求数。
r($calc->getResult(array('product' => '999', 'year' => '2021'))) && p('')        && e('0');  // 测试不存在的产品。
