<?php
public function create($metric)
{
    return $this->loadExtension('zentaobiz')->create($metric);
}

public function update($id, $metric)
{
    return $this->loadExtension('zentaobiz')->update($id, $metric);
}

public function getMetricPHPTemplate($metricID)
{
    return $this->loadExtension('zentaobiz')->getMetricPHPTemplate($metricID);
}

public function updateMetric($metric)
{
    return $this->loadExtension('zentaobiz')->updateMetric($metric);
}
