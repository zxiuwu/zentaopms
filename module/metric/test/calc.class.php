<?php
class metricTest
{
    public function __construct()
    {
        global $tester;
        $this->objectModel = $tester->loadModel('metric');
        $this->tester = $tester;
    }

    /**
     * 测试根据code获取度量项数据方法。
     * Test get metric by code.
     *
     * @param  string     $code
     * @param  array|null $options
     * @access public
     * @return void
     */
    public function getMetricByCode($code, $options = null)
    {
        return $this->objectModel->getResultByCode($code, $options);
    }

    /**
     * 获取度量项基类文件的路径。
     * Get path of base calculator class.
     *
     * @access private
     * @return string
     */
    private function getBaseCalcPath()
    {
        global $tester;
        return $tester->app->getModuleRoot() . 'metric' . DS . 'calc.class.php';
    }

    /**
     * 计算度量项，并返回计算后的度量项对象。
     * Calculate metric.
     *
     * @param  string $file
     * @access public
     * @return object
     */
    public function calcMetric($file)
    {
        $code    = pathinfo($file, PATHINFO_FILENAME);
        $purpose = basename(dirname($file));
        $scope   = basename(dirname($file, 2));

        include_once $this->getBaseCalcPath();
        include_once $this->objectModel->getCalcRoot() . $scope . DS . $purpose . DS . $code . '.php';

        $calc = new $code;
        $rows = $this->prepareDataset($calc)->fetchAll();

        foreach($rows as $row)
        {
            $calc->calculate((object)$row);
        }

        return $calc;
    }

    /**
     * 准备计算度量项所需要的数据源。
     * Prepare dataset object for calc.
     *
     * @param  object    $calc
     * @access public
     * @return void
     */
    public function prepareDataset($calc)
    {
        global $tester;
        $dataSource = $calc->dataset;

        if(!isset($calc->dataset))
        {
            $calc->setDAO($tester->dao);
            return $calc->getStatement();
        }

        $dataset   = $this->objectModel->getDataset($tester->dao);
        $fieldList = implode(',', array_unique($calc->fieldList));

        return $dataset->$dataSource($fieldList);
    }
}
