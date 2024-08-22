<?php
public function checkBizUserLimit($type = 'user')
{
    return $this->loadExtension('zentaobiz')->checkBizUserLimit($type);
}

public function getBizUserLimit($type = 'user')
{
    return $this->loadExtension('zentaobiz')->getBizUserLimit($type);
}

public function getByQuery($browseType = 'inside', $query = '', $pager = null, $orderBy = 'id')
{
    return $this->loadExtension('zentaobiz')->getByQuery($browseType, $query, $pager, $orderBy);
}

public function getAddUserWarning($limit)
{
    return $this->loadExtension('zentaobiz')->getAddUserWarning($limit);
}
