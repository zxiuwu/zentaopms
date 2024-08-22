<?php
public function getPairsByRole($role)
{
    return $this->loadExtension('cmmi')->getPairsByRole($role);
}

/**
 * Get all members for project/execution.
 *
 * @param int $objectID
 * @access public
 * @return array
 */
public function getAllMembers($objectID)
{
    if(defined('TUTORIAL')) return $this->loadModel('tutorial')->getTeamMembersPairs();

    $teams = $this->loadModel('project')->getTeamMemberPairs($objectID);

    $stakeholders = $this->dao->select('t1.user, t2.realname')->from(TABLE_STAKEHOLDER)->alias('t1')
        ->leftJoin(TABLE_USER)->alias('t2')->on('t1.user=t2.account')
        ->where('t1.deleted')->eq('0')
        ->andWhere('t1.objectID')->eq($objectID)
        ->orderBy('t1.id_desc')
        ->fetchPairs();

    $whitelist = $this->dao->select('t1.*, t2.realname')->from(TABLE_ACL)->alias('t1')
        ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account=t2.account')
        ->where('t1.objectID')->eq($objectID)
        ->andWhere('t1.objectType')->eq('project,sprint')
        ->andWhere('t1.type')->eq('whitelist')
        ->fetchPairs();
    $users = array_merge($teams, $stakeholders, $whitelist);

    if(empty($users)) return array('' => '');

    return array('' => '') + $users;
}
