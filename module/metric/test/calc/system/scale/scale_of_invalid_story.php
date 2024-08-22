#!/usr/bin/env php
<?php
/**

title=scale_of_invalid_story
timeout=0
cid=1

*/
include dirname(__FILE__, 7) . '/test/lib/init.php';
include dirname(__FILE__, 4) . '/calc.class.php';

zdTable('story')->config('story_stage_closedreason', true, 4)->gen(140);
zdTable('product')->config('product', true, 4)->gen(10);

$metric = new metricTest();
$calc   = $metric->calcMetric(__FILE__);

r($calc->getResult()) && p('') && e('140'); // 测试按全局统计的无效研发需求规模数
