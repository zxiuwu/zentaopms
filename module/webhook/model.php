<?php
/**
 * The model file of webhook module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2017 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     webhook
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class webhookModel extends model
{
    /**
     * Get a webhook by id.
     *
     * @param  int    $id
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_WEBHOOK)->where('id')->eq($id)->fetch();
    }

    /**
     * Get a webhook by type.
     *
     * @param  string $type
     * @access public
     * @return object
     */
    public function getByType($type)
    {
        return $this->dao->select('*')->from(TABLE_WEBHOOK)->where('type')->eq($type)->andWhere('deleted')->eq('0')->fetch();
    }

    /**
     * Get a webhook by type.
     *
     * @param  int    $webhookID
     * @param  string $webhookType
     * @param  string $openID
     * @access public
     * @return object
     */
    public function getBindAccount($webhookID, $webhookType, $openID)
    {
        return $this->dao->select('account')->from(TABLE_OAUTH)->where('providerID')->eq($webhookID)->andWhere('providerType')->eq($webhookType)->andWhere('openID')->eq($openID)->fetch('account');
    }

    /**
     * Get webhook list.
     *
     * @param  string $orderBy
     * @param  object $pager
     * @param  bool   $decode
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null, $decode = true)
    {
        return $this->dao->select('*')->from(TABLE_WEBHOOK)
            ->where('deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * Get log list of a webhook.
     *
     * @param  int    $id
     * @param  string $orderBy
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getLogList($id, $orderBy = 'date_desc', $pager = null)
    {
        $logs = $this->dao->select('*')->from(TABLE_LOG)
            ->where('objectType')->eq('webhook')
            ->andWhere('objectID')->eq($id)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        $actions = array();
        foreach($logs as $log) $actions[] = $log->action;

        $this->loadModel('action');
        $actions = $this->dao->select('*')->from(TABLE_ACTION)->where('id')->in($actions)->fetchAll('id');

        $users   = $this->loadModel('user')->getPairs('noletter');
        foreach($logs as $log)
        {
            if(!isset($actions[$log->action]))
            {
                $log->action = '';
                continue;
            }

            $action = $actions[$log->action];
            $data   = json_decode($log->data);
            $object = $this->dao->select('*')->from($this->config->objectTables[$action->objectType])->where('id')->eq($action->objectID)->fetch();
            $field  = zget($this->config->action->objectNameFields, $action->objectType, $action->objectType);

            if(!is_object($object))
            {
                $object = new stdclass;
                $object->$field = '';
            }

            $text = '';
            if(isset($data->markdown->text))
            {
                $text = substr($data->markdown->text, 0, strpos($data->markdown->text, '(http'));
            }
            elseif(isset($data->markdown->content))
            {
                $text = substr($data->markdown->content, 0, strpos($data->markdown->content, '(http'));
            }
            elseif(isset($data->text->content))
            {
                $text = substr($data->text->content, 0, strpos($data->text->content, '(http'));
            }
            elseif(isset($data->content))
            {
                $text = $data->content->text;
                $text = substr($text, 0, strpos($text, '(http')) ? substr($text, 0, strpos($text, '(http')) : zget($users, $data->user, $this->app->user->realname) . $this->lang->action->label->{$action->action} . $this->lang->action->objectTypes[$action->objectType] . "[#{$action->objectID}::{$object->$field}]";
            }
            else
            {
                $text = substr($data->text, 0, strpos($data->text, '(http')) ? substr($data->text, 0, strpos($data->text, '(http')) : zget($users, $data->user, $this->app->user->realname) . $this->lang->action->label->{$action->action} . $this->lang->action->objectTypes[$action->objectType] . "[#{$action->objectID}::{$object->$field}]";
            }

            $log->action    = $text;
            $log->actionURL = $this->getViewLink($action->objectType, $action->objectID);
            $log->module    = $action->objectType;
            $log->moduleID  = $action->objectID;
            $log->dialog    = $action->objectType == 'todo' ? 1 : 0;
        }
        return $logs;
    }

    /**
     * Get saved data list.
     *
     * @access public
     * @return array
     */
    public function getDataList()
    {
        $dataList  = $this->dao->select('*')->from(TABLE_NOTIFY)->where('status')->eq('wait')->andWhere('objectType')->eq('webhook')->orderBy('id')->fetchAll('id');
        $dataList += $this->dao->select('*')->from(TABLE_NOTIFY)->where('status')->eq('senting')->andWhere('objectType')->eq('webhook')->orderBy('id')->fetchAll('id');
        return $dataList;
    }

    /**
     * Get bind users.
     *
     * @param  int    $webhookID
     * @param  array  $users
     * @access public
     * @return array
     */
    public function getBoundUsers($webhookID, $users = array())
    {
        return $this->dao->select('*')->from(TABLE_OAUTH)->where('providerType')->eq('webhook')
            ->andWhere('providerID')->eq($webhookID)
            ->beginIF($users)->andWhere('account')->in($users)->fi()
            ->fetchPairs('account', 'openID');
    }

    /**
     * Create a webhook.
     *
     * @access public
     * @return bool
     */
    public function create()
    {
        $webhook = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->join('products', ',')
            ->join('executions', ',')
            ->skipSpecial('url')
            ->trim('agentId,appKey,appSecret,wechatAgentId,wechatCorpId,wechatCorpSecret,feishuAppId,feishuAppSecret')
            ->remove('allParams, allActions')
            ->get();
        $webhook->domain = trim($webhook->domain, '/');
        $webhook->params = $this->post->params ? implode(',', $this->post->params) . ',text' : 'text';

        if($webhook->type == 'dinguser')
        {
            $webhook->secret = array();
            $webhook->secret['agentId']   = $webhook->agentId;
            $webhook->secret['appKey']    = $webhook->appKey;
            $webhook->secret['appSecret'] = $webhook->appSecret;

            if(empty($webhook->agentId))   dao::$errors['agentId']   = sprintf($this->lang->error->notempty, $this->lang->webhook->dingAgentId);
            if(empty($webhook->appKey))    dao::$errors['appKey']    = sprintf($this->lang->error->notempty, $this->lang->webhook->dingAppKey);
            if(empty($webhook->appSecret)) dao::$errors['appSecret'] = sprintf($this->lang->error->notempty, $this->lang->webhook->dingAppSecret);
            if(dao::isError()) return false;

            $webhook->secret = json_encode($webhook->secret);
            $webhook->url    = $this->config->webhook->dingapiUrl;
        }
        elseif($webhook->type == 'wechatuser')
        {
            $webhook->secret = array();
            $webhook->secret['agentId']   = $webhook->wechatAgentId;
            $webhook->secret['appKey']    = $webhook->wechatCorpId;
            $webhook->secret['appSecret'] = $webhook->wechatCorpSecret;

            if(empty($webhook->wechatCorpId))     dao::$errors['wechatCorpId']     = sprintf($this->lang->error->notempty, $this->lang->webhook->wechatCorpId);
            if(empty($webhook->wechatCorpSecret)) dao::$errors['wechatCorpSecret'] = sprintf($this->lang->error->notempty, $this->lang->webhook->wechatCorpSecret);
            if(empty($webhook->wechatAgentId))    dao::$errors['wechatAgentId']    = sprintf($this->lang->error->notempty, $this->lang->webhook->wechatAgentId);
            if(dao::isError()) return false;

            $webhook->secret = json_encode($webhook->secret);
            $webhook->url    = $this->config->webhook->wechatApiUrl;
        }
        elseif($webhook->type == 'feishuuser')
        {
            $webhook->secret = array();
            $webhook->secret['appId']     = $webhook->feishuAppId;
            $webhook->secret['appSecret'] = $webhook->feishuAppSecret;

            if(empty($webhook->feishuAppId))     dao::$errors['feishuAppId']     = sprintf($this->lang->error->notempty, $this->lang->webhook->feishuAppId);
            if(empty($webhook->feishuAppSecret)) dao::$errors['feishuAppSecret'] = sprintf($this->lang->error->notempty, $this->lang->webhook->feishuAppSecret);
            if(dao::isError()) return false;

            $webhook->secret = json_encode($webhook->secret);
            $webhook->url    = $this->config->webhook->feishuApiUrl;
        }

        $this->dao->insert(TABLE_WEBHOOK)->data($webhook, 'agentId,appKey,appSecret,wechatCorpId,wechatCorpSecret,wechatAgentId,feishuAppId,feishuAppSecret')
            ->batchCheck($this->config->webhook->create->requiredFields, 'notempty')
            ->autoCheck()
            ->exec();
        return $this->dao->lastInsertId();
    }

    /**
     * Update a webhook.
     *
     * @param  int    $id
     * @access public
     * @return bool
     */
    public function update($id)
    {
        $webhook = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->setDefault('products', '')
            ->setDefault('executions', '')
            ->join('products', ',')
            ->join('executions', ',')
            ->skipSpecial('url')
            ->trim('agentId,appKey,appSecret,wechatAgentId,wechatCorpId,wechatCorpSecret,feishuAppId,feishuAppSecret')
            ->remove('allParams, allActions')
            ->get();
        $webhook->domain = trim($webhook->domain, '/');
        $webhook->params = $this->post->params ? implode(',', $this->post->params) . ',text' : 'text';

        if($webhook->type == 'dinguser')
        {
            $webhook->secret = array();
            $webhook->secret['agentId']   = $webhook->agentId;
            $webhook->secret['appKey']    = $webhook->appKey;
            $webhook->secret['appSecret'] = $webhook->appSecret;

            if(empty($webhook->agentId))   dao::$errors['agentId']   = sprintf($this->lang->error->notempty, $this->lang->webhook->dingAgentId);
            if(empty($webhook->appKey))    dao::$errors['appKey']    = sprintf($this->lang->error->notempty, $this->lang->webhook->dingAppKey);
            if(empty($webhook->appSecret)) dao::$errors['appSecret'] = sprintf($this->lang->error->notempty, $this->lang->webhook->dingAppSecret);
            if(dao::isError()) return false;

            $webhook->secret = json_encode($webhook->secret);
        }
        elseif($webhook->type == 'wechatuser')
        {
            $webhook->secret = array();
            $webhook->secret['agentId']   = $webhook->wechatAgentId;
            $webhook->secret['appKey']    = $webhook->wechatCorpId;
            $webhook->secret['appSecret'] = $webhook->wechatCorpSecret;

            if(empty($webhook->wechatCorpId))     dao::$errors['wechatCorpId']     = sprintf($this->lang->error->notempty, $this->lang->webhook->wechatCorpId);
            if(empty($webhook->wechatCorpSecret)) dao::$errors['wechatCorpSecret'] = sprintf($this->lang->error->notempty, $this->lang->webhook->wechatCorpSecret);
            if(empty($webhook->wechatAgentId))    dao::$errors['wechatAgentId']    = sprintf($this->lang->error->notempty, $this->lang->webhook->wechatAgentId);
            if(dao::isError()) return false;

            $webhook->secret = json_encode($webhook->secret);
        }
        elseif($webhook->type == 'feishuuser')
        {
            $webhook->secret = array();
            $webhook->secret['appId']     = $webhook->feishuAppId;
            $webhook->secret['appSecret'] = $webhook->feishuAppSecret;

            if(empty($webhook->feishuAppId))     dao::$errors['feishuAppId']     = sprintf($this->lang->error->notempty, $this->lang->webhook->feishuAppId);
            if(empty($webhook->feishuAppSecret)) dao::$errors['feishuAppSecret'] = sprintf($this->lang->error->notempty, $this->lang->webhook->feishuAppSecret);
            if(dao::isError()) return false;

            $webhook->secret = json_encode($webhook->secret);
        }

        $this->dao->update(TABLE_WEBHOOK)->data($webhook, 'agentId,appKey,appSecret,wechatCorpId,wechatCorpSecret,wechatAgentId,feishuAppId,feishuAppSecret')
            ->batchCheck($this->config->webhook->edit->requiredFields, 'notempty')
            ->autoCheck()
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Bind ding openID.
     *
     * @param  int    $webhookID
     * @access public
     * @return bool
     */
    public function bind($webhookID)
    {
        $data = fixer::input('post')->get();

        $this->dao->delete()->from(TABLE_OAUTH)
            ->where('providerType')->eq('webhook')
            ->andWhere('providerID')->eq($webhookID)
            ->andWhere('account')->in(array_keys($data->userid))
            ->exec();
        foreach($data->userid as $account => $userid)
        {
            if(empty($userid)) continue;

            $oauth = new stdclass();
            $oauth->account      = $account;
            $oauth->openID       = $userid;
            $oauth->providerType = 'webhook';
            $oauth->providerID   = $webhookID;
            $this->dao->insert(TABLE_OAUTH)->data($oauth)->exec();
        }
        return !dao::isError();
    }

    /**
     * Send data.
     *
     * @param  string $objectType
     * @param  int    $objectID
     * @param  string $actionType
     * @param  int    $actionID
     * @param  string $actor
     * @access public
     * @return bool
     */
    public function send($objectType, $objectID, $actionType, $actionID, $actor = '')
    {
        static $webhooks = array();
        if(!$webhooks) $webhooks = $this->getList();
        if(!$webhooks) return true;

        foreach($webhooks as $id => $webhook)
        {
            $postData = $this->buildData($objectType, $objectID, $actionType, $actionID, $webhook);
            if(!$postData) continue;

            if($webhook->sendType == 'async')
            {
                if($webhook->type == 'dinguser')
                {
                    $openIdList = $this->getOpenIdList($webhook->id, $actionID);
                    if(empty($openIdList)) continue;
                }

                $this->saveData($id, $actionID, $postData, $actor);
                continue;
            }

            $result = $this->fetchHook($webhook, $postData, $actionID);
            if(!empty($result)) $this->saveLog($webhook, $actionID, $postData, $result);
        }
        return !dao::isError();
    }

    /**
     * Build data.
     *
     * @param  string $objectType
     * @param  int    $objectID
     * @param  string $actionType
     * @param  int    $actionID
     * @param  object $webhook
     * @access public
     * @return string
     */
    public function buildData($objectType, $objectID, $actionType, $actionID, $webhook)
    {
        /* Validate data. */
        if(!isset($this->lang->action->label)) $this->loadModel('action');
        if(!isset($this->lang->action->label->$actionType)) return false;
        if(empty($this->config->objectTables[$objectType])) return false;
        $action = $this->dao->select('*')->from(TABLE_ACTION)->where('id')->eq($actionID)->fetch();

        if($webhook->products)
        {
            $webhookProducts = explode(',', trim($webhook->products, ','));
            $actionProduct   = explode(',', trim($action->product, ','));
            $intersect       = array_intersect($webhookProducts, $actionProduct);
            if(!$intersect) return false;
        }
        if($webhook->executions)
        {
            if(strpos(",$webhook->executions,", ",$action->execution,") === false) return false;
        }

        static $users = array();
        if(empty($users)) $users = $this->loadModel('user')->getList();

        $object         = $this->dao->select('*')->from($this->config->objectTables[$objectType])->where('id')->eq($objectID)->fetch();
        $field          = $this->config->action->objectNameFields[$objectType];
        $host           = empty($webhook->domain) ? common::getSysURL() : $webhook->domain;
        $viewLink       = $this->getViewLink($objectType == 'kanbancard' ? 'kanban' : $objectType, $objectType == 'kanbancard' ? $object->kanban : $objectID);
        $objectTypeName = ($objectType == 'story' and $object->type == 'requirement') ? $this->lang->action->objectTypes['requirement'] : $this->lang->action->objectTypes[$objectType];
        $title          = $this->app->user->realname . $this->lang->action->label->$actionType . $objectTypeName;
        $host           = (defined('RUN_MODE') and RUN_MODE == 'api') ? '' : $host;
        $text           = $title . ' ' . "[#{$objectID}::{$object->$field}](" . $host . $viewLink . ")";

        $mobile = '';
        $email  = '';
        if(in_array($objectType, $this->config->webhook->needAssignTypes) && !empty($object->assignedTo))
        {
            foreach($users as $user)
            {
                if($user->account == $object->assignedTo)
                {
                    $mobile = $user->mobile;
                    $email  = $user->email;
                    break;
                }
            }
        }
        $action->text = $text;

        if($webhook->type == 'dinggroup' or $webhook->type == 'dinguser')
        {
            $data = $this->getDingdingData($title, $text, $webhook->type == 'dinguser' ? '' : $mobile);
        }
        elseif($webhook->type == 'bearychat')
        {
            $data = $this->getBearychatData($text, $mobile, $email, $objectType, $objectID);
        }
        elseif($webhook->type == 'wechatgroup' or $webhook->type == 'wechatuser')
        {
            $data = $this->getWeixinData($title, $text, $mobile);
        }
        elseif($webhook->type == 'feishuuser' or $webhook->type == 'feishugroup')
        {
            $data = $this->getFeishuData($title, $text);
        }
        else
        {
            $data = new stdclass();
            foreach(explode(',', $webhook->params) as $param) $data->$param = $action->$param;
        }

        return json_encode($data);
    }

    /**
     * Get view link.
     *
     * @param  string $objectType
     * @param  int    $objectID
     * @access public
     * @return string
     */
    public function getViewLink($objectType, $objectID)
    {
        $oldOnlyBody = '';
        $tab         = '';
        if(isset($_GET['onlybody']) and $_GET['onlybody'] == 'yes')
        {
            $oldOnlyBody = 'yes';
            unset($_GET['onlybody']);
        }
        if($objectType == 'case') $objectType = 'testcase';
        if($objectType == 'meeting')
        {
            $meeting = $this->dao->findById($objectID)->from(TABLE_MEETING)->fetch();
            $tab     = $meeting->project ? '#app=project' : '#app=my';
        }

        $viewLink = helper::createLink($objectType, 'view', "id=$objectID", 'html') . $tab;
        if($oldOnlyBody) $_GET['onlybody'] = $oldOnlyBody;

        return $viewLink;
    }

    /**
     * Get hook data for dingding.
     *
     * @param  string $title
     * @param  string $text
     * @param  string $mobile
     * @access public
     * @return object
     */
    public function getDingdingData($title, $text, $mobile)
    {
        if($mobile) $text .= " @{$mobile}";

        $markdown = new stdclass();
        $markdown->title = $title;
        $markdown->text  = $text;

        $data = new stdclass();
        $data->msgtype  = 'markdown';
        $data->markdown = $markdown;

        if($mobile)
        {
            $at = new stdclass();
            $at->atMobiles = array($mobile);
            $at->isAtAll   = false;

            $data->at = $at;
        }

        return $data;
    }

    /**
     * Get hook data for bearychat.
     *
     * @param  string $text
     * @param  string $mobile
     * @param  string $email
     * @param  string $objectType
     * @param  int    $objectID
     * @access public
     * @return object
     */
    public function getBearychatData($text, $mobile, $email, $objectType, $objectID)
    {
        $data = new stdclass();
        $data->text     = $text;
        $data->markdown = 'true';
        $data->user     = $mobile ? $mobile : ($email ? $email : $this->app->user->account);

        if(!empty($_FILES['files']['name'][0]))
        {
            $this->loadModel('file');
            $files = $this->dao->select('*')->from(TABLE_FILE)->where('objectType')->eq($objectType)->andWhere('objectID')->eq($objectID)->orderBy('addedDate_desc,id_desc')->limit(count($_FILES['files']['name']))->fetchAll();
            if($files)
            {
                foreach($files as $file)
                {
                    $attachment = array();
                    $attachment['title'] = $file->title;
                    $attachment['images'][]['url'] = common::getSysURL() . $this->file->webPath . $file->pathname;
                    $data->attachments[] = $attachment;
                }
            }
        }

        return $data;
    }

    /**
     * Get weixin send data.
     *
     * @param  string $title
     * @param  string $text
     * @param  string $mobile
     * @access public
     * @return object
     */
    public function getWeixinData($title, $text, $mobile = '')
    {
        $data = new stdclass();
        $data->msgtype = 'markdown';

        $markdown = new stdclass();
        $markdown->content = $text;

        if($mobile)
        {
            $data->msgtype = 'text';
            $markdown->mentioned_mobile_list = array($mobile);
        }

        $data->{$data->msgtype} = $markdown;

        return $data;
    }

    /**
     * Get feishu send data.
     *
     * @param  string $title
     * @param  string $text
     * @access public
     * @return object
     */
    public function getFeishuData($title, $text)
    {
        $data = new stdclass();
        $data->msg_type = 'interactive';

        $data->card = array();
        $data->card['header']   = array();
        $data->card['elements'] = array();

        $data->card['elements'][]         = array('tag' => 'markdown', 'content' => $text);
        $data->card['header']['title']    = array('tag' => 'plain_text', 'content' => $title);
        $data->card['header']['template'] = 'blue';

        return $data;
    }

    /**
     * Get openID list.
     *
     * @param  int    $webhookID
     * @param  int    $actionID
     * @param  string $toList
     * @access public
     * @return string
     */
    public function getOpenIdList($webhookID, $actionID, $toList = '')
    {
        if($toList)
        {
            $openIdList = $this->getBoundUsers($webhookID, $toList);
            $openIdList = join(',', $openIdList);
            return $openIdList;
        }

        if(empty($actionID)) return false;

        $action = $this->dao->select('*')->from(TABLE_ACTION)->where('id')->eq($actionID)->fetch();
        $table  = zget($this->config->objectTables, $action->objectType, '');
        if(empty($table)) return false;

        $object = $this->dao->select('*')->from($table)->where('id')->eq($action->objectID)->fetch();
        $toList = $this->loadModel('message')->getToList($object, $action->objectType, $actionID);
        if(!empty($object->mailto)) $toList .= ',' . $object->mailto;
        if(empty($toList)) return false;

        /* Remove duplicate people. */
        if($action->objectType == 'release')
        {
            $toList = array_unique(explode(',', $toList));
            $toList = implode(',', $toList);
        }

        $toList = str_replace(",{$this->app->user->account},", ',', ",$toList,");

        $openIdList = $this->getBoundUsers($webhookID, $toList);
        $openIdList = join(',', $openIdList);
        return $openIdList;
    }

    /**
     * Post hook data.
     *
     * @param  object $webhook
     * @param  string $sendData
     * @param  int    $actionID
     * @param  string $appendUser
     * @access public
     * @return int
     */
    public function fetchHook($webhook, $sendData, $actionID = 0, $appendUser = '')
    {
        if(!extension_loaded('curl')) return print(helper::jsonEncode($this->lang->webhook->error->curl));

        if($webhook->type == 'dinguser' || $webhook->type == 'wechatuser' || $webhook->type == 'feishuuser')
        {
            if(is_string($webhook->secret)) $webhook->secret = json_decode($webhook->secret);

            $openIdList = $this->getOpenIdList($webhook->id, $actionID, $appendUser);
            if(empty($openIdList)) return false;
            if($webhook->type == 'dinguser')
            {
                $this->app->loadClass('dingapi', true);
                $dingapi = new dingapi($webhook->secret->appKey, $webhook->secret->appSecret, $webhook->secret->agentId);
                $result  = $dingapi->send($openIdList, $sendData);
                return json_encode($result);
            }
            elseif($webhook->type == 'wechatuser')
            {
                $this->app->loadClass('wechatapi', true);
                $wechatapi = new wechatapi($webhook->secret->appKey, $webhook->secret->appSecret, $webhook->secret->agentId);
                $result  = $wechatapi->send($openIdList, $sendData);
                return json_encode($result);
            }
            elseif($webhook->type == 'feishuuser')
            {
                $this->app->loadClass('feishuapi', true);
                $feishuapi = new feishuapi($webhook->secret->appId, $webhook->secret->appSecret);
                $result  = $feishuapi->send($openIdList, $sendData);
                return json_encode($result);
            }
        }

        $contentType = "Content-Type: {$webhook->contentType};charset=utf-8";
        if($webhook->type == 'dinggroup' or $webhook->type == 'wechatgroup' or $webhook->type == 'feishugroup') $contentType = "Content-Type: application/json";
        $header[] = $contentType;

        $url = $webhook->url;
        if($webhook->type == 'dinggroup' and $webhook->secret)
        {
            $timestamp = time() * 1000;
            $sign = $timestamp . "\n" . $webhook->secret;
            $sign = urlencode(base64_encode(hash_hmac('sha256', $sign, $webhook->secret, true)));
            $url .= "&timestamp={$timestamp}&sign={$sign}";
        }
        if($webhook->type == 'feishugroup' and $webhook->secret)
        {
            $timestamp = time();
            $sign = $timestamp . "\n" . $webhook->secret;
            $sign = base64_encode(hash_hmac('sha256', '', $sign, true));

            $content = json_decode($sendData);
            $content->timestamp = $timestamp;
            $content->sign      = $sign;
            $sendData = json_encode($content);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result   = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if($error)  return $error;
        if($result) return $result;
        return $httpCode;
    }

    /**
     * Save datas.
     *
     * @param  int    $webhookID
     * @param  int    $actionID
     * @param  string $data
     * @param  string $actor
     * @access public
     * @return bool
     */
    public function saveData($webhookID, $actionID, $data, $actor = '')
    {
        if(empty($actor)) $actor = $this->app->user->account;

        $webhookData = new stdclass();
        $webhookData->objectType  = 'webhook';
        $webhookData->objectID    = $webhookID;
        $webhookData->action      = $actionID;
        $webhookData->data        = $data;
        $webhookData->createdBy   = $actor;
        $webhookData->createdDate = helper::now();

        $this->dao->insert(TABLE_NOTIFY)->data($webhookData)->exec();
        return !dao::isError();
    }

    /**
     * Save log.
     *
     * @param  object $webhook
     * @param  int    $actionID
     * @param  string $data
     * @param  string $result
     * @access public
     * @return bool
     */
    public function saveLog($webhook, $actionID, $data, $result)
    {
        $log = new stdclass();
        $log->objectType  = 'webhook';
        $log->objectID    = $webhook->id;
        $log->action      = $actionID;
        $log->date        = helper::now();
        $log->url         = $webhook->url;
        $log->contentType = $webhook->contentType;
        $log->data        = $data;
        $log->result      = (string)$result;

        $this->dao->insert(TABLE_LOG)->data($log)->exec();
        return !dao::isError();
    }

    /**
     * Set sent status.
     *
     * @param  array  $idList
     * @param  string $status
     * @param  string $time
     * @access public
     * @return void
     */
    public function setSentStatus($idList, $status, $time = '')
    {
        if(empty($time)) $time = helper::now();
        $this->dao->update(TABLE_NOTIFY)->set('status')->eq($status)->set('sendTime')->eq($time)->where('id')->in($idList)->exec();
    }
}
