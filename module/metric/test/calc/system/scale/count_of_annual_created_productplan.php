#!/usr/bin/env php
<?php
/**

title=count_of_annual_created_productplan
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('product')->config('product', true, 4)->gen(10);
zdTable('productplan')->config('productplan', true, 4)->gen(1000);

$metric = new metricTest();
$calc = $metric->calcMetric(__FILE__);

r(count($calc->getResult())) && p('') && e('11');                        // 测试年度创建产品计划分组数。
r($calc->getResult(array('year' => '2017'))) && p('0:value') && e('19'); // 测试2017年创建产品计划数
r($calc->getResult(array('year' => '2019'))) && p('0:value') && e('18'); // 测试2019年创建产品计划数
r($calc->getResult(array('year' => '2023'))) && p('0:value') && e('0');  // 测试2023年创建产品计划数
