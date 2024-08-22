<?php
/**
 * The story recall entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class storyRecallEntry extends entry
{
    /**
     * Delete method.
     *
     * @param  int    $storyID
     * @access public
     * @return string
     */
    public function delete($storyID)
    {
        $control = $this->loadController('story', 'recall');
        $control->recall($storyID);

        $this->getData();
        return $this->sendSuccess(200, 'success');
    }
}

