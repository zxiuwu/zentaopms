#!/usr/bin/env php
<?php
/**

title=count_of_release_in_product
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('product')->config('product', true, 4)->gen(10);
zdTable('release')->config('release', true, 4)->gen(1000);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r($calc->getResult(array('product' => '1')))   && p('0:value') && e('50'); // 测试产品1的发布数。
r($calc->getResult(array('product' => '3')))   && p('0:value') && e('50'); // 测试产品3的发布数。
r($calc->getResult(array('product' => '4')))   && p('0:value') && e('0');  // 测试已删除产品4的发布数。
r($calc->getResult(array('product' => '999'))) && p('')        && e('0');  // 测试不存在的产品的发布数。
