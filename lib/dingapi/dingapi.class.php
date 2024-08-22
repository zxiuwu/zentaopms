<?php
class dingapi
{
    public $apiUrl = 'https://oapi.dingtalk.com/';
    private $appKey;
    private $appSecret;
    private $token;
    private $expires;
    private $errors = array();

    /**
     * Construct
     *
     * @param  string $appKey
     * @param  string $appSecret
     * @param  string $agentId
     * @param  string $apiUrl
     * @access public
     * @return void
     */
    public function __construct($appKey, $appSecret, $agentId, $apiUrl = '')
    {
        $this->appKey    = $appKey;
        $this->appSecret = $appSecret;
        $this->agentId   = $agentId;
        if($apiUrl) $this->apiUrl = rtrim($apiUrl, '/') . '/';

        if(!$this->getToken()) return array('result' => 'fail', 'message' => $this->errors);
    }

    /**
     * Get token.
     *
     * @access public
     * @return string
     */
    public function getToken()
    {
        if($this->token and (time() - $this->expires) >= 0) return $this->token;

        $response = $this->queryAPI($this->apiUrl . "gettoken?appkey={$this->appKey}&appsecret={$this->appSecret}");
        if($this->isError()) return false;

        $this->token   = $response->access_token;
        $this->expires = time() + $response->expires_in;
        return $this->token;
    }

    /**
     * Get users.
     *
     * @param  string $selectedDepts
     * @access public
     * @return array
     */
    public function getUsers($selectedDepts = '')
    {
        $depts = trim($selectedDepts);
        if(empty($depts)) return array('result' => 'fail', 'message' => 'nodept');

        set_time_limit(0);
        $users = array();
        foreach(explode(',', $depts) as $deptID)
        {
            if(empty($deptID)) continue;

            $response = $this->queryAPI($this->apiUrl . "user/simplelist?access_token={$this->token}&department_id={$deptID}");
            if($this->isError())
            {
                $this->getErrors();
                continue;
            }

            foreach($response->userlist as $user) $users[$user->name] = $user->userid;
        }

        $response = $this->queryAPI($this->apiUrl . "auth/scopes?access_token={$this->token}");
        if(!empty($response->auth_org_scopes->authed_user))
        {
            foreach($response->auth_org_scopes->authed_user as $userid)
            {
                $user = $this->queryAPI($this->apiUrl . "user/get?access_token={$this->token}&userid={$userid}");
                if($this->isError())
                {
                    $this->getErrors();
                    continue;
                }

                $users[$user->name] = $user->userid;
            }
        }

        return array('result' => 'success', 'data' => $users);
    }

    /**
     * Get dept tree.
     *
     * @access public
     * @return array
     */
    public function getDeptTree()
    {
        $response = $this->queryAPI($this->apiUrl . "auth/scopes?access_token={$this->token}");
        if(isset($response->auth_org_scopes->authed_dept) and $response->auth_org_scopes->authed_dept[0] != 1)
        {
            $selectedDepts = array();
            foreach($response->auth_org_scopes->authed_dept as $deptID)
            {
                $selectedDepts[$deptID] = $deptID;

                $response = $this->queryAPI($this->apiUrl . "department/list?access_token={$this->token}&id=$deptID");
                foreach($response->department as $dept) $selectedDepts[$dept->id] = $dept->id;
            }
            return array('result' => 'selected', 'data' => $selectedDepts);
        }
        else
        {
            $response = $this->queryAPI($this->apiUrl . "department/list?access_token={$this->token}");
            if($this->isError()) return array('result' => 'fail', 'message' => $this->errors);

            $parentDepts = array();
            foreach($response->department as $dept)
            {
                $parentID = isset($dept->parentid) ? $dept->parentid : 0;
                $parentDepts[$parentID][$dept->id] = $dept->name;
            }
        }

        $tree = array();
        foreach($parentDepts as $parentID => $depts)
        {
            foreach($depts as $deptID => $deptName)
            {
                $node = array();
                $node['id']   = $deptID;
                $node['pId']  = $parentID;
                $node['name'] = $deptName;
                $node['open'] = true;

                $tree[] = $node;
            }
        }

        return array('result' => 'success', 'data' => $tree);
    }

    /**
     * Send message
     *
     * @param  string $userList
     * @param  string $message
     * @access public
     * @return array
     */
    public function send($userList, $message)
    {
        $postData = array();
        $postData['agent_id']    = $this->agentId;
        $postData['userid_list'] = $userList;
        $postData['msg']         = $message;

        $url = $this->apiUrl . 'topapi/message/corpconversation/asyncsend_v2?access_token=' . $this->token;
        $response = common::http($url, $postData);
        $errors   = commonModel::$requestErrors;

        $response = json_decode($response);
        if(isset($response->errcode) and $response->errcode == 0) return array('result' => 'success');

        if(empty($response)) $this->errors = $errors;
        if(isset($response->errcode)) $this->errors[$response->errcode] = "Errcode:{$response->errcode}, Errmsg:{$response->errmsg}";
        return array('result' => 'fail', 'message' => $this->errors);
    }

    /**
     * Query API.
     *
     * @param  string $url
     * @access public
     * @return string
     */
    public function queryAPI($url)
    {
        $response = common::http($url);
        $errors   = commonModel::$requestErrors;

        $response = json_decode($response);
        if(isset($response->errcode) and $response->errcode == 0) return $response;

        if(empty($response)) $this->errors = $errors;
        if(isset($response->result) and $response->result == 'fail') $this->errors['curl'] = $response->message;
        if(isset($response->errcode)) $this->errors[$response->errcode] = "Errcode:{$response->errcode}, Errmsg:{$response->errmsg}";
        return false;
    }

    /**
     * Check for errors.
     *
     * @access public
     * @return bool
     */
    public function isError()
    {
        return !empty($this->errors);
    }

    /**
     * Get errors.
     *
     * @access public
     * @return array
     */
    public function getErrors()
    {
        $errors = $this->errors;
        $this->errors = array();

        return $errors;
    }
}
