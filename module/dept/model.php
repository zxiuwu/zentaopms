<?php
/**
 * The model file of dept module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dept
 * @version     $Id: model.php 4210 2013-01-22 01:06:12Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class deptModel extends model
{
    /**
     * Get a department by id.
     *
     * @param  int    $deptID
     * @access public
     * @return object
     */
    public function getByID($deptID)
    {
        return $this->dao->findById($deptID)->from(TABLE_DEPT)->fetch();
    }

    /**
     * Get all department names.
     *
     * @param  int   $deptID
     * @access public
     * @return object
     */
    public function getDeptPairs($deptID = 0)
    {
        return $this->dao->select('id,name')->from(TABLE_DEPT)->fetchPairs();
    }

    /**
     * Build the query.
     *
     * @param  int    $rootDeptID
     * @access public
     * @return string
     */
    public function buildMenuQuery($rootDeptID)
    {
        $rootDept = $this->getByID($rootDeptID);
        if(!$rootDept)
        {
            $rootDept = new stdclass();
            $rootDept->path = '';
        }

        return $this->dao->select('*')->from(TABLE_DEPT)
            ->beginIF($rootDeptID > 0)->where('path')->like($rootDept->path . '%')->fi()
            ->orderBy('grade desc, `order`')
            ->get();
    }

    /**
     * Get option menu of departments.
     *
     * @param  int    $rootDeptID
     * @access public
     * @return array
     */
    public function getOptionMenu($rootDeptID = 0)
    {
        $deptMenu = array();
        $stmt = $this->app->dbQuery($this->buildMenuQuery($rootDeptID));
        $depts = array();
        while($dept = $stmt->fetch()) $depts[$dept->id] = $dept;

        foreach($depts as $dept)
        {
            $parentDepts = explode(',', $dept->path);
            $deptName = '/';
            foreach($parentDepts as $parentDeptID)
            {
                if(empty($parentDeptID)) continue;
                $deptName .= $depts[$parentDeptID]->name . '/';
            }
            $deptName = rtrim($deptName, '/');
            $deptName .= "|$dept->id\n";

            if(isset($deptMenu[$dept->id]) and !empty($deptMenu[$dept->id]))
            {
                if(isset($deptMenu[$dept->parent]))
                {
                    $deptMenu[$dept->parent] .= $deptName;
                }
                else
                {
                    $deptMenu[$dept->parent] = $deptName;;
                }
                $deptMenu[$dept->parent] .= $deptMenu[$dept->id];
            }
            else
            {
                if(isset($deptMenu[$dept->parent]) and !empty($deptMenu[$dept->parent]))
                {
                    $deptMenu[$dept->parent] .= $deptName;
                }
                else
                {
                    $deptMenu[$dept->parent] = $deptName;
                }
            }
        }

        krsort($deptMenu);
        $topMenu = array_pop($deptMenu);
        $topMenu = explode("\n", trim((string)$topMenu));

        $lastMenu[] = '/';
        foreach($topMenu as $menu)
        {
            if(!strpos($menu, '|')) continue;
            list($label, $deptID) = explode('|', $menu);
            $lastMenu[$deptID] = $label;
        }

        return $lastMenu;
    }

    /**
     * Get the treemenu of departments.
     *
     * @param  int        $rootDeptID
     * @param  string     $userFunc
     * @param  int        $param
     * @access public
     * @return string
     */
    public function getTreeMenu($rootDeptID = 0, $userFunc = '', $param = 0)
    {
        $deptMenu = array();
        $stmt = $this->app->dbQuery($this->buildMenuQuery($rootDeptID));
        while($dept = $stmt->fetch())
        {
            $linkHtml = call_user_func($userFunc, $dept, $param);

            if(isset($deptMenu[$dept->id]) and !empty($deptMenu[$dept->id]))
            {
                if(!isset($deptMenu[$dept->parent])) $deptMenu[$dept->parent] = '';
                $deptMenu[$dept->parent] .= "<li>$linkHtml";
                $deptMenu[$dept->parent] .= "<ul>".$deptMenu[$dept->id]."</ul>\n";
            }
            else
            {
                if(isset($deptMenu[$dept->parent]) and !empty($deptMenu[$dept->parent]))
                {
                    $deptMenu[$dept->parent] .= "<li>$linkHtml\n";
                }
                else
                {
                    $deptMenu[$dept->parent] = "<li>$linkHtml\n";
                }
            }
            $deptMenu[$dept->parent] .= "</li>\n";
        }

        krsort($deptMenu);
        $deptMenu = array_pop($deptMenu);
        $lastMenu = "<ul class='tree' data-ride='tree' data-name='tree-dept'>{$deptMenu}</ul>\n";
        return $lastMenu;
    }

    /**
     * Update dept.
     *
     * @param  int    $deptID
     * @access public
     * @return void
     */
    public function update($deptID)
    {
        $dept   = fixer::input('post')->get();
        $self   = $this->getById($deptID);
        $parent = $this->getById($this->post->parent);
        $childs = $this->getAllChildId($deptID);
        $dept->grade = $parent ? $parent->grade + 1 : 1;
        $dept->path  = $parent ? $parent->path . $deptID . ',' : ',' . $deptID . ',';
        $this->dao->update(TABLE_DEPT)->data($dept)->autoCheck()->check('name', 'notempty')->where('id')->eq($deptID)->exec();
        $this->dao->update(TABLE_DEPT)->set('grade = grade + 1')->where('id')->in($childs)->andWhere('id')->ne($deptID)->exec();
        $this->dao->update(TABLE_DEPT)->set('manager')->eq($this->post->manager)->where('id')->in($childs)->andWhere('manager')->eq('')->exec();
        $this->dao->update(TABLE_DEPT)->set('manager')->eq($this->post->manager)->where('id')->in($childs)->andWhere('manager')->eq($self->manager)->exec();
        $this->fixDeptPath();
    }

    /**
     * Create the manage link.
     *
     * @param  object    $dept
     * @access public
     * @return string
     */
    public function createManageLink($dept)
    {
        $linkHtml  = $dept->name;
        if(common::hasPriv('dept', 'edit')) $linkHtml .= ' ' . html::a(helper::createLink('dept', 'edit', "deptid={$dept->id}"), $this->lang->edit, '', 'data-toggle="modal" data-type="ajax"');
        if(common::hasPriv('dept', 'browse')) $linkHtml .= ' ' . html::a(helper::createLink('dept', 'browse', "deptid={$dept->id}"), $this->lang->dept->manageChild);
        if(common::hasPriv('dept', 'delete')) $linkHtml .= ' ' . html::a(helper::createLink('dept', 'delete', "deptid={$dept->id}"), $this->lang->delete, 'hiddenwin');
        if(common::hasPriv('dept', 'updateOrder')) $linkHtml .= ' ' . html::input("orders[$dept->id]", $dept->order, 'style="width:30px;text-align:center"');
        return $linkHtml;
    }

    /**
     * Create the member link.
     *
     * @param  int    $dept
     * @access public
     * @return string
     */
    public function createMemberLink($dept)
    {
        $linkHtml = html::a(helper::createLink('company', 'browse', "browseType=inside&dept={$dept->id}"), $dept->name, '_self', "id='dept{$dept->id}'");
        return $linkHtml;
    }

    /**
     * Create the traingoal member link.
     *
     * @param  int    $dept
     * @access public
     * @return string
     */
    public function traingoalMemberLink($dept, $planID)
    {
        $linkHtml = html::a(helper::createLink('traingoal', 'browse', "goalID={$planID}&type=company&dept={$dept->id}&"), $dept->name, '_self', "id='dept{$dept->id}'");
        return $linkHtml;
    }

    /**
     * Create the group manage members link.
     *
     * @param  int    $dept
     * @param  int    $groupID
     * @access public
     * @return string
     */
    public function createGroupManageMemberLink($dept, $groupID)
    {
        return html::a(helper::createLink('group', 'managemember', "groupID=$groupID&deptID={$dept->id}"), $dept->name, '_self', "id='dept{$dept->id}'");
    }

    /**
     * Create the group manage program admin link.
     *
     * @param  int    $dept
     * @param  int    $groupID
     * @access public
     * @return string
     */
    public function createManageProjectAdminLink($dept, $groupID)
    {
        return html::a(helper::createLink('group', 'manageProjectAdmin', "groupID=$groupID&deptID={$dept->id}"), $dept->name, '_self', "id='dept{$dept->id}'");
    }

    /**
     * Get sons of a department.
     *
     * @param  int    $deptID
     * @access public
     * @return array
     */
    public function getSons($deptID)
    {
        return $this->dao->select('*')->from(TABLE_DEPT)->where('parent')->eq($deptID)->orderBy('`order`')->fetchAll();
    }

    /**
     * Get all childs.
     *
     * @param  int    $deptID
     * @access public
     * @return array
     */
    public function getAllChildId($deptID)
    {
        if($deptID == 0) return array();

        $dept = $this->getById($deptID);
        if(empty($dept)) return array();

        $childs = $this->dao->select('id')->from(TABLE_DEPT)->where('path')->like($dept->path . '%')->fetchPairs();
        return array_keys($childs);
    }

    /**
     * Get parents.
     *
     * @param  int    $deptID
     * @access public
     * @return array
     */
    public function getParents($deptID)
    {
        if($deptID == 0) return array();
        $path = $this->dao->select('path')->from(TABLE_DEPT)->where('id')->eq($deptID)->fetch('path');
        $path = substr($path, 1, -1);
        if(empty($path)) return array();
        return $this->dao->select('*')->from(TABLE_DEPT)->where('id')->in($path)->orderBy('grade')->fetchAll();
    }

    /**
     * Update order.
     *
     * @param  int    $orders
     * @access public
     * @return void
     */
    public function updateOrder($orders)
    {
        foreach($orders as $deptID => $order) $this->dao->update(TABLE_DEPT)->set('`order`')->eq($order)->where('id')->eq($deptID)->exec();
    }

    /**
     * Manage childs.
     *
     * @param  int    $parentDeptID
     * @param  string $childs
     * @access public
     * @return array
     */
    public function manageChild($parentDeptID, $childs)
    {
        $parentDept = $this->getByID($parentDeptID);
        if($parentDept)
        {
            $grade      = $parentDept->grade + 1;
            $parentPath = $parentDept->path;
        }
        else
        {
            $grade      = 1;
            $parentPath = ',';
        }

        $i = 1;
        $deptIDList = array();
        foreach($childs as $deptID => $deptName)
        {
            if(empty($deptName)) continue;
            if(is_numeric($deptID))
            {
                $dept = new stdclass();
                $dept->name   = strip_tags($deptName);
                $dept->parent = $parentDeptID;
                $dept->grade  = $grade;
                $dept->order  = $this->post->maxOrder + $i * 10;
                $this->dao->insert(TABLE_DEPT)->data($dept)->exec();
                $deptID       = $this->dao->lastInsertID();
                $deptIDList[] = $deptID;
                $childPath    = $parentPath . "$deptID,";
                $this->dao->update(TABLE_DEPT)->set('path')->eq($childPath)->where('id')->eq($deptID)->exec();
                $i++;
            }
            else
            {
                $deptID = str_replace('id', '', $deptID);
                $this->dao->update(TABLE_DEPT)->set('name')->eq(strip_tags($deptName))->where('id')->eq($deptID)->exec();
            }
        }

        return $deptIDList;
    }

    /**
     * Get users of a deparment.
     *
     * @param  string  $browseType inside|outside|all
     * @param  int     $deptID
     * @param  object  $pager
     * @param  string  $orderBy
     * @access public
     * @return array
     */
    public function getUsers($browseType = 'inside', $deptID = 0, $pager = null, $orderBy = 'id')
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->beginIF($browseType == 'inside')->andWhere('type')->eq('inside')->fi()
            ->beginIF($browseType == 'outside')->andWhere('type')->eq('outside')->fi()
            ->beginIF($deptID)->andWhere('dept')->in($deptID)->fi()
            ->beginIF($this->config->vision)->andWhere("CONCAT(',', visions, ',')")->like("%,{$this->config->vision},%")->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get user pairs of a department.
     *
     * @param  int    $deptID
     * @param  string $key     id|account
     * @param  string $type    inside|outside
     * @param  string $params  all
     * @access public
     * @return array
     */
    public function getDeptUserPairs($deptID = 0, $key = 'account', $type = 'inside', $params = '')
    {
        $childDepts = $this->getAllChildID($deptID);
        $keyField   = $key == 'id' ? 'id' : 'account';
        $type       = $type == 'outside' ? 'outside' : 'inside';

        return $this->dao->select("$keyField, realname")->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->beginIF(strpos($params, 'all') === false)->andWhere('type')->eq($type)->fi()
            ->beginIF($childDepts)->andWhere('dept')->in($childDepts)->fi()
            ->beginIF($deptID === '0')->andWhere('dept')->eq($deptID)->fi()
            ->beginIF($this->config->vision)->andWhere("CONCAT(',', visions, ',')")->like("%,{$this->config->vision},%")->fi()
            ->orderBy('account')
            ->fetchPairs();
    }

    /**
     * Delete a department.
     *
     * @param  int    $deptID
     * @param  null   $null      compatible with that of model::delete()
     * @access public
     * @return void
     */
    public function delete($deptID, $null = null)
    {
        $this->dao->delete()->from(TABLE_DEPT)->where('id')->eq($deptID)->exec();
    }

    /**
     * Fix dept path.
     *
     * @access public
     * @return void
     */
    public function fixDeptPath()
    {
        /* Get all depts grouped by parent. */
        $groupDepts = $this->dao->select('id, parent')->from(TABLE_DEPT)->fetchGroup('parent', 'id');
        $depts      = array();

        /* Cycle the groupDepts until it has no item any more. */
        while(count($groupDepts) > 0)
        {
            $oldCounts = count($groupDepts);    // Record the counts before processing.
            foreach($groupDepts as $parentDeptID => $childDepts)
            {
                /* If the parentDept doesn't exsit in the depts, skip it. If exists, compute it's child depts. */
                if(!isset($depts[$parentDeptID]) and $parentDeptID != 0) continue;
                if($parentDeptID == 0)
                {
                    $parentDept = new stdclass();
                    $parentDept->grade = 0;
                    $parentDept->path  = ',';
                }
                else
                {
                    $parentDept = $depts[$parentDeptID];
                }

                /* Compute it's child depts. */
                foreach($childDepts as $childDeptID => $childDept)
                {
                    $childDept->grade = $parentDept->grade + 1;
                    $childDept->path  = $parentDept->path . $childDept->id . ',';
                    $depts[$childDeptID] = $childDept;    // Save child dept to depts, thus the child of child can compute it's grade and path.
                }
                unset($groupDepts[$parentDeptID]);    // Remove it from the groupDepts.
            }
            if(count($groupDepts) == $oldCounts) break;   // If after processing, no dept processed, break the cycle.
        }

        /* Save depts to database. */
        foreach($depts as $dept)
        {
            $this->dao->update(TABLE_DEPT)->data($dept)->where('id')->eq($dept->id)->exec();
        }
    }

    /**
     * Get data structure
     * @access public
     * @return array
     */
    public function getDataStructure()
    {
        $users      = $this->loadModel('user')->getPairs('noletter|noclosed|nodeleted|all');
        $treeGroups = $this->dao->select('*')->from(TABLE_DEPT)->orderBy('grade_desc,`order`')->fetchGroup('parent', 'id');
        $tree       = array();
        foreach($treeGroups as $parent => $groups)
        {
            foreach($groups as $deptID => $node)
            {
                $node->managerName = zget($users, $node->manager);
                if(isset($tree[$deptID]))
                {
                    $node->children = $tree[$deptID];
                    $node->actions = array('delete' => false);
                    unset($tree[$deptID]);
                }
                $tree[$node->parent][] = $node;
            }
        }

        krsort($tree);
        return array_pop($tree);
    }
}
