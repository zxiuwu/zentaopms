<?php
/**
 * 用对象数据创建度量。
 * Create a metric.
 *
 * @param  object $metric
 * @access public
 * @return int|false
 */
public function create($metric)
{
    $this->dao->insert(TABLE_METRIC)->data($metric)
        ->autoCheck()
        ->checkIF(!empty($metric->name), 'name', 'unique', "`deleted` = '0'")
        ->checkIF(!empty($metric->code), 'code', 'unique', "`deleted` = '0'")
        ->exec();
    if(dao::isError()) return false;
    $metricID = $this->dao->lastInsertID();

    $this->loadModel('action')->create('metric', $metricID, 'opened', '', '', $this->app->user->account);

    return $metricID;
}

/**
 * 更新度量项。
 * Update a metric.
 *
 * @param  int    $id
 * @param  object $metric
 * @access public
 * @return int|false
 */
public function update($id, $metric)
{
    $oldMetric = $this->getByID($id);

    $this->dao->update(TABLE_METRIC)->data($metric)
        ->autoCheck()
        ->checkIF(!empty($metric->name) && $metric->name != $oldMetric->name, 'name', 'unique', "`deleted` = '0'")
        ->checkIF(!empty($metric->code) && $metric->code != $oldMetric->code, 'code', 'unique', "`deleted` = '0'")
        ->where('id')->eq($id)
        ->exec();

    if(dao::isError()) return false;

    $changes = common::createChanges($oldMetric, $metric);
    if($changes)
    {
        $actionID = $this->loadModel('action')->create('metric', $id, 'edited', '', '', $this->app->user->account);
        $this->action->logHistory($actionID, $changes);
    }

    return $changes;
}

/**
 * 根据度量项信息生成度量项php模板内容。
 * Generante php template content from metric information.
 *
 * @param  int    $metricID
 * @access public
 * @return array
 */
public function getMetricPHPTemplate(int $metricID): array
{
    $metric = $this->getByID($metricID);

    $metric->nameEN  = ucfirst(str_replace('_', ' ', $metric->code));
    $metric->scope   = $this->lang->metric->scopeList[$metric->scope];
    $metric->object  = $this->lang->metric->objectList[$metric->object];
    $metric->purpose = $this->lang->metric->purposeList[$metric->purpose];

    $replaceFields = array('name', 'nameEN', 'code', 'scope', 'object', 'purpose', 'unit', 'desc', 'definition');

    $content = file_get_contents($this->app->getModuleRoot() . DS . 'metric' . DS . 'template' . DS . 'metric.php.tmp');

    foreach($replaceFields as $replaceField)
    {
        $replaceContent = $this->metricTao->replaceCRLF($metric->$replaceField);
        $content = str_replace("{{{$replaceField}}}", $replaceContent, $content);
    }

    return array("{$metric->code}.php", $content);
}

/**
 * 更新度量项。
 * Updata metric.
 *
 * @param  object $metric
 * @access public
 * @return void
 */
public function updateMetric(object $metric)
{
    $this->dao->update(TABLE_METRIC)->data($metric)
        ->where('id')->eq($metric->id)
        ->exec();
}
