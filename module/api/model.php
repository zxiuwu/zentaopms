<?php
/**
 * The model file of api module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     api
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class apiModel extends model
{
    /* Status. */
    const STATUS_DOING  = 'doing';
    const STATUS_DONE   = 'done';
    const STATUS_HIDDEN = 'hidden';

    /* Scope. */
    const SCOPE_QUERY     = 'query';
    const SCOPE_FORM_DATA = 'formData';
    const SCOPE_PATH      = 'path';
    const SCOPE_BODY      = 'body';
    const SCOPE_HEADER    = 'header';
    const SCOPE_COOKIE    = 'cookie';

    /* Params. */
    const PARAMS_TYPE_CUSTOM = 'custom';

    /**
     * Create release.
     *
     * @param  object $data
     * @access public
     * @return int
     */
    public function publishLib($data)
    {
        /* Get lib modules list. */
        $modules = $this->dao->select('*')->from(TABLE_MODULE)
            ->where('root')->eq((int)$data->lib)
            ->andWhere('type')->eq('api')
            ->andWhere('deleted')->eq(0)
            ->orderBy('grade desc, `order`')
            ->fetchAll();

        /* Get all api list. */
        $apis = $this->dao->select('id,version')->from(TABLE_API)
            ->where('lib')->eq($data->lib)
            ->andWhere('deleted')->eq(0)
            ->fetchAll();

        /* Get all struct list. */
        $structs = $this->dao->select('id,version')->from(TABLE_APISTRUCT)
            ->where('lib')->eq($data->lib)
            ->andWhere('deleted')->eq(0)
            ->fetchAll();

        $snap = array('modules' => $modules, 'apis' => $apis, 'structs' => $structs);

        $data->snap = json_encode($snap);
        $this->dao->insert(TABLE_API_LIB_RELEASE)->data($data)
            ->autoCheck()
            ->batchCheck($this->config->api->createrelease->requiredFields, 'notempty')
            ->exec();

        return dao::isError() ? false : $this->dao->lastInsertID();
    }

    /**
     * Delete a lib publish.
     *
     * @param  int    $id
     * @access public
     * @return void
     */
    public function deleteRelease($id)
    {
        $this->dao->delete()->from(TABLE_API_LIB_RELEASE)
            ->where('id')->eq($id)
            ->exec();
    }

    /**
     * Create an api doc.
     *
     * @access public
     * @return object | bool
     */
    public function create()
    {
        $now  = helper::now();
        $data = fixer::input('post')
            ->trim('title,path')
            ->remove('type')
            ->skipSpecial('params,response')
            ->add('addedBy', $this->app->user->account)
            ->add('addedDate', $now)
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->add('version', 1)
            ->setDefault('product,module', 0)
            ->get();

        $this->dao->insert(TABLE_API)->data($data)
            ->autoCheck()
            ->batchCheck($this->config->api->create->requiredFields, 'notempty')
            ->check('title', 'unique', "lib = $data->lib AND module = $data->module")
            ->check('path', 'unique', "lib = $data->lib AND module = $data->module AND method = '$data->method'")
            ->exec();

        if(dao::isError()) return false;

        $data->id = $this->dao->lastInsertID();

        $apiSpec = $this->getApiSpecByData($data);
        $this->dao->replace(TABLE_API_SPEC)->data($apiSpec)->exec();

        return $data;
    }

    /**
     * Create a global struct.
     *
     * @param  object $data
     * @access public
     * @return int
     */
    public function createStruct($data)
    {
        $data->version = 1;
        $this->dao->insert(TABLE_APISTRUCT)->data($data)
            ->autoCheck()
            ->batchCheck($this->config->api->struct->requiredFields, 'notempty')
            ->exec();

        if(dao::isError()) return false;

        $id = $this->dao->lastInsertID();

        /* Create a struct version. */
        $version = array(
            'name'      => $data->name,
            'type'      => $data->type,
            'desc'      => $data->desc,
            'version'   => $data->version,
            'attribute' => $data->attribute,
            'addedBy'   => $data->addedBy,
            'addedDate' => $data->addedDate
        );
        $this->dao->insert(TABLE_APISTRUCT_SPEC)->data($version)->exec();

        if(dao::isError()) return false;

        return $id;
    }

    /**
     * Update a struct.
     *
     * @param  int    $id
     * @access public
     * @return array
     */
    public function updateStruct($id)
    {
        $old = $this->dao->findByID($id)->from(TABLE_APISTRUCT)->fetch();

        $now  = helper::now();
        $data = fixer::input('post')
            ->trim('name')
            ->skipSpecial('attribute')
            ->add('lib', $old->lib)
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->get();

        unset($data->addedBy);
        unset($data->addedDate);

        $data->version = $old->version + 1;

        $this->dao->update(TABLE_APISTRUCT)
            ->data($data)->autoCheck()
            ->batchCheck($this->config->api->struct->requiredFields, 'notempty')
            ->where('id')->eq($id)
            ->exec();

        if(dao::isError()) return false;

        /* Create a struct version */
        $version = array(
            'name'      => $data->name,
            'type'      => $data->type,
            'desc'      => $data->desc,
            'version'   => $data->version,
            'attribute' => $data->attribute,
            'addedBy'   => $data->editedBy,
            'addedDate' => $data->editedDate
        );
        $this->dao->insert(TABLE_APISTRUCT_SPEC)->data($version)->exec();

        return common::createChanges($old, $data);
    }

    /**
     * Update an api doc.
     *
     * @param  int $apiID
     * @access public
     * @return bool|array
     */
    public function update($apiID)
    {
        $oldApi = $this->dao->findByID($apiID)->from(TABLE_API)->fetch();

        if(!empty($_POST['editedDate']) and $oldApi->editedDate != $this->post->editedDate)
        {
            dao::$errors[] = $this->lang->error->editedByOther;
            return false;
        }

        $now  = helper::now();
        $data = fixer::input('post')
            ->skipSpecial('params,response')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->add('version', $oldApi->version)
            ->setDefault('product,module', 0)
            ->remove('type')
            ->get();

        $changes = common::createChanges($oldApi, $data);
        if(!empty($changes)) $data->version = $oldApi->version + 1;

        $this->dao->update(TABLE_API)
            ->data($data)
            ->autoCheck()
            ->batchCheck($this->config->api->edit->requiredFields, 'notempty')
            ->where('id')->eq($apiID)
            ->exec();

        $data->id = $apiID;
        $apiSpec  = $this->getApiSpecByData($data);
        $this->dao->replace(TABLE_API_SPEC)->data($apiSpec)->exec();

        return $changes;
    }

    /**
     * Get struct list by api doc id.
     *
     * @param int $id
     * @access public
     * @return array
     */
    public function getStructListByLibID($id)
    {
        $res = $this->dao->select('*')
            ->from(TABLE_APISTRUCT)
            ->where('lib')->eq($id)
            ->fetchAll();

        array_map(function ($item) {
            $item->attribute = json_decode($item->attribute, true);
            return $item;
        }, $res);
        return $res;
    }

    /**
     * Get a struct info.
     *
     * @param int $id
     * @access public
     * @return object
     */
    public function getStructByID($id)
    {
        $model = $this->dao->select('*')
            ->from(TABLE_APISTRUCT)
            ->where('id')->eq($id)
            ->fetch();

        if($model) $model->attribute = json_decode($model->attribute, true);

        return $model;
    }

    /**
     * Get release.
     *
     * @param  int    $libID
     * @param  string $type
     * @param  int    $param
     * @access public
     * @return object
     */
    public function getRelease($libID = 0, $type = '', $param = 0)
    {
        $model = $this->dao->select('*')->from(TABLE_API_LIB_RELEASE)
            ->where('1 = 1')
            ->beginIF($libID)->andWhere('lib')->eq($libID)->fi()
            ->beginIF($type == 'byVersion')->andWhere('version')->eq($param)->fi()
            ->beginIF($type == 'byId')->andWhere('id')->eq($param)->fi()
            ->fetch();
        if($model) $model->snap = json_decode($model->snap, true);
        return $model;
    }

    /**
     * Get Versions by api id
     *
     * @param int $libID
     * @access public
     * @return array
     */
    public function getReleaseListByApi($libID)
    {
        return $this->dao->select('*')->from(TABLE_API_LIB_RELEASE)->where('lib')->eq($libID)->fetchAll('id');
    }


    /**
     * Get api doc by id.
     *
     * @param int $id
     * @param int $version
     * @param int $release
     * @access public
     * @return object
     */
    public function getLibById($id, $version = 0, $release = 0)
    {
        if($release)
        {
            $rel = $this->getRelease(0, 'byId', $release);
            foreach($rel->snap['apis'] as $api)
            {
                if($api['id'] == $id) $version = $api['version'];
            }
        }
        if($version)
        {
            $fields = 'spec.*,api.id,api.product,api.lib,api.version,doc.name as libName,module.name as moduleName,api.editedBy,api.editedDate';
        }
        else
        {
            $fields = 'api.*,doc.name as libName,module.name as moduleName';
        }

        $model = $this->dao->select($fields)->from(TABLE_API)->alias('api')
            ->beginIF($version)->leftJoin(TABLE_API_SPEC)->alias('spec')->on('api.id = spec.doc')->fi()
            ->leftJoin(TABLE_DOCLIB)->alias('doc')->on('api.lib = doc.id')
            ->leftJoin(TABLE_MODULE)->alias('module')->on('api.module = module.id')
            ->where('api.id')->eq($id)
            ->beginIF($version)->andWhere('spec.version')->eq($version)->fi()
            ->fetch();

        if($model)
        {
            $model->params   = json_decode($model->params, true);
            $model->response = json_decode($model->response, true);
        }
        return $model;
    }

    /**
     * Get api list by release.
     *
     * @param  object $release
     * @param  string $where
     * @access public
     * @return array
     */
    public function getApiListByRelease($release, $where = '1 = 1 ')
    {
        $strJoin = array();
        if(isset($release->snap['apis']))
        {
            foreach($release->snap['apis'] as $api)
            {
                $strJoin[] = "(spec.doc = {$api['id']} and spec.version = {$api['version']} )";
            }
        }

        if($strJoin) $where .= 'and (' . implode(' or ', $strJoin) . ')';
        $list = $this->dao->select('api.lib,spec.*,api.id')->from(TABLE_API)->alias('api')
            ->leftJoin(TABLE_API_SPEC)->alias('spec')->on('api.id = spec.doc')
            ->where($where)
            ->fetchAll();
        return $list;
    }

    /**
     * Get api doc list by module id.
     *
     * @param  int    $libID
     * @param  int    $moduleID
     * @param  int    $release
     * @param  object $pager
     * @return array $list
     */
    public function getListByModuleId($libID = 0, $moduleID = 0, $release = 0, $pager = null)
    {
        /* Get release info. */
        if($release > 0)
        {
            $rel = $this->getRelease(0, 'byId', $release);

            $where = "1=1 and lib = $libID ";
            if($moduleID > 0 and isset($rel->snap['modules']))
            {
                $sub = array();
                foreach($rel->snap['modules'] as $module)
                {
                    $tmp = explode(',', $module['path']);
                    if(in_array($moduleID, $tmp)) $sub[] = $module['id'];
                }
                if($sub) $where .= 'and module in (' . implode(',', $sub) . ')';
            }
            $list = $this->getApiListByRelease($rel, $where);
        }
        else
        {
            if($moduleID > 0)
            {
                $sub   = $this->dao->select('id')->from(TABLE_MODULE)->where('FIND_IN_SET(' . $moduleID . ', path)')->processSQL();
                $where = 'module in (' . $sub . ')';
            }
            else
            {
                $where = 'lib = ' . $libID;
            }
            $list = $this->dao->select('*')->from(TABLE_API)->where($where)
                ->andWhere('deleted')->eq(0)
                ->page($pager)
                ->fetchAll();
        }
        array_map(function ($item) {
            $item->params   = json_decode($item->params, true);
            $item->response = json_decode($item->response, true);
            return $item;
        }, $list);
        return $list;
    }

    /**
     * Get status text by status.
     *
     * @param string $status
     * @access public
     * @return string
     */
    public static function getApiStatusText($status)
    {
        global $lang;
        switch($status)
        {
            case static::STATUS_DOING:
            {
                return $lang->api->doing;
            }
            case static::STATUS_DONE:
            {
                return $lang->api->done;
            }
        }
    }

    /**
     * @param int $libID
     * @param string $pager
     * @param string $orderBy
     * @access public
     * @return array
     */
    public function getStructByQuery($libID, $pager = '', $orderBy = '')
    {
        return $this->dao->select('t1.*,t2.realname as addedName')->from(TABLE_APISTRUCT)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t2.account = t1.addedBy')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.lib')->eq($libID)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get struct list by release.
     *
     * @param  object $release
     * @param  string $where
     * @param  string $orderBy
     * @access public
     * @return array
     */
    public function getStructListByRelease($release, $where = '1 = 1 ', $orderBy = 'id')
    {
        $strJoin = array();
        if(isset($release->snap['structs']))
        {
            foreach($release->snap['structs'] as $struct)
            {
                $strJoin[] = "(object.id = {$struct['id']} and spec.version = {$struct['version']} )";
            }
        }

        if($strJoin) $where .= 'and (' . implode(' or ', $strJoin) . ')';
        $list = $this->dao->select('object.lib,spec.name,spec.type,spec.desc,spec.attribute,spec.version,spec.addedBy,spec.addedDate,object.id,user.realname as addedName')->from(TABLE_APISTRUCT)->alias('object')
            ->leftJoin(TABLE_APISTRUCT_SPEC)->alias('spec')->on('object.name = spec.name')
            ->leftJoin(TABLE_USER)->alias('user')->on('user.account = spec.addedBy')
            ->where($where)
            ->orderBy($orderBy)
            ->fetchAll();
        return $list;
    }

    /**
     * @param int $libID
     * @param string $pager
     * @param string $orderBy
     * @access public
     * @return array
     */
    public function getReleaseByQuery($libID, $pager = '', $orderBy = '')
    {
        return $this->dao->select('*')->from(TABLE_API_LIB_RELEASE)
            ->where('lib')->in($libID)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get struct tree by lib id
     *
     * @param int $libID
     * @param int $structID
     * @access public
     * @return string
     */
    public function getStructTreeByLib($libID = 0, $structID = 0)
    {
        $list = $this->getStructListByLibID($libID);

        $html = "<ul id='modules' class='tree' data-ride='tree' data-name='tree-lib'>";
        foreach($list as $item)
        {
            $class = array('catalog');
            if($structID && $structID == $item->id)
            {
                $class[] = 'active';
            }
            else
            {
                $class[] = 'doc';
            }

            $html .= '<li class="' . implode(' ', $class) . '">';
            $html .= html::a(helper::createLink('api', 'struct', "libID=$libID&structID=$item->id"), "<i class='icon icon-file-text text-muted'></i> &nbsp;" . $item->name, '', "data-app='{$this->app->tab}' class='doc-title' title='{$item->name}'");
            $html .= "</li>";
        }
        $html .= "</ul>";

        return $html;
    }

    /**
     * Get the details of the method by file path.
     *
     * @param string $filePath
     * @param string $ext
     * @access public
     * @return object
     */
    public function getMethod($filePath, $ext = '')
    {
        $fileName  = dirname($filePath);
        $className = basename(dirname(dirname($filePath)));
        if(!class_exists($className)) helper::import($fileName);
        $methodName = basename($filePath);

        $method           = new ReflectionMethod($className . $ext, $methodName);
        $data             = new stdClass();
        $data->startLine  = $method->getStartLine();
        $data->endLine    = $method->getEndLine();
        $data->comment    = $method->getDocComment();
        $data->parameters = $method->getParameters();
        $data->className  = $className;
        $data->methodName = $methodName;
        $data->fileName   = $fileName;
        $data->post       = false;

        $file = file($fileName);
        for($i = $data->startLine - 1; $i <= $data->endLine; $i++)
        {
            if(strpos($file[$i], '$this->post') or strpos($file[$i], 'fixer::input') or strpos($file[$i], '$_POST'))
            {
                $data->post = true;
            }
        }
        return $data;
    }

    /**
     * Request the api.
     *
     * @param string $moduleName
     * @param string $methodName
     * @param string $action
     * @access public
     * @return array
     */
    public function request($moduleName, $methodName, $action)
    {
        $host  = common::getSysURL();
        $param = '';
        if($action == 'extendModel')
        {
            if(!isset($_POST['noparam']))
            {
                foreach($_POST as $key => $value) $param .= ',' . $key . '=' . $value;
                $param = ltrim($param, ',');
            }
            $url  = rtrim($host, '/') . inlink('getModel',  "moduleName=$moduleName&methodName=$methodName&params=$param", 'json');
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= $this->config->sessionVar . '=' . session_id();
        }
        else
        {
            if(!isset($_POST['noparam']))
            {
                foreach($_POST as $key => $value) $param .= '&' . $key . '=' . $value;
                $param = ltrim($param, '&');
            }
            $url  = rtrim($host, '/') . helper::createLink($moduleName, $methodName, $param, 'json');
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= $this->config->sessionVar . '=' . session_id();
        }

        /* Unlock session. After new request, restart session. */
        session_write_close();
        $content = file_get_contents($url);
        session_start();

        return array('url' => $url, 'content' => $content);
    }

    /**
     * Query sql.
     *
     * @param string $sql
     * @param string $keyField
     * @access public
     * @return array
     */
    public function sql($sql, $keyField = '')
    {
        if(!$this->config->features->apiSQL) return sprintf($this->lang->api->error->disabled, '$config->features->apiSQL');

        $sql = trim($sql);
        if(strpos($sql, ';') !== false) $sql = substr($sql, 0, strpos($sql, ';'));

        $result            = array();
        $result['status']  = 'fail';
        $result['message'] = '';

        if(empty($sql)) return $result;

        if(stripos($sql, 'select ') !== 0)
        {
            $result['message'] = $this->lang->api->error->onlySelect;
            return $result;
        }

        try
        {
            $stmt = $this->dbh->query($sql);

            $rows = array();
            if(empty($keyField))
            {
                $rows = $stmt->fetchAll();
            }
            else
            {
                while($row = $stmt->fetch()) $rows[$row->$keyField] = $row;
            }

            $result['status'] = 'success';
            $result['data']   = $rows;
        }
        catch(PDOException $e)
        {
            $result['status']  = 'fail';
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Get spec of api.
     *
     * @param object $data
     * @access private
     * @return array
     */
    private function getApiSpecByData($data)
    {
        return array(
            'doc'             => $data->id,
            'module'          => $data->module,
            'title'           => $data->title,
            'path'            => $data->path,
            'protocol'        => $data->protocol,
            'method'          => $data->method,
            'requestType'     => $data->requestType,
            'responseType'    => isset($data->responseType) ? $data->responseType : '',
            'status'          => $data->status,
            'owner'           => $data->owner,
            'desc'            => $data->desc,
            'version'         => $data->version,
            'params'          => $data->params,
            'paramsExample'   => $data->paramsExample,
            'responseExample' => $data->responseExample,
            'response'        => $data->response,
            'addedBy'         => $this->app->user->account,
            'addedDate'       => helper::now(),
        );
    }

    /**
     * Get Type list.
     *
     * @param  int   $libID
     * @access public
     * @return void
     */
    public function getTypeList($libID)
    {
        $typeList = array();
        foreach($this->lang->api->paramsTypeOptions as $key => $item)
        {
            $typeList[$key] = $item;
        }

        /* Get all struct by libID. */
        $structs = $this->getStructListByLibID($libID);
        foreach($structs as $struct)
        {
            $typeList[$struct->id] = $struct->name;
        }

        return $typeList;
    }

    /**
     * Create demo data.
     *
     * @param  string  $name
     * @param  string  $baseUrl
     * @param  string  $version
     * @access public
     * @return int
     */
    public function createDemoData($name, $baseUrl, $version = '16.0')
    {
        /* Replace the doc lib name to api lib name. */
        $this->app->loadLang('doc');
        $this->lang->doclib->name = $this->lang->doclib->apiLibName;

        $firstAccount   = $this->dao->select('account')->from(TABLE_USER)->orderBy('id_asc')->limit(1)->fetch('account');
        $currentAccount = isset($this->app->user->account) ? $this->app->user->account : $firstAccount;

        /* Insert doclib. */
        $lib = new stdclass();
        $lib->type      = 'api';
        $lib->name      = $name;
        $lib->baseUrl   = $baseUrl;
        $lib->acl       = 'open';
        $lib->users     = ',' . $currentAccount . ',';
        $this->dao->insert(TABLE_DOCLIB)->data($lib)->autoCheck()
            ->batchCheck($this->config->api->createlib->requiredFields, 'notempty')
            ->check('name', 'unique', "`type` = 'api'")
            ->exec();

        $libID = $this->dao->lastInsertID();

        /* Insert struct. */
        $structMap = array();
        $structs   = $this->getDemoData('apistruct', $version);
        foreach($structs as $struct)
        {
            $oldID = $struct->id;
            unset($struct->id);

            $struct->lib        = $libID;
            $struct->addedBy    = $currentAccount;
            $struct->addedDate  = helper::now();
            $struct->editedBy   = $currentAccount;
            $struct->editedDate = helper::now();

            $this->dao->insert(TABLE_APISTRUCT)->data($struct)->exec();
            $newID = $this->dao->lastInsertID();

            $structMap[$oldID] = $newID;
        }

        /* Insert struct spec. */
        $specs = $this->getDemoData('apistruct_spec', $version);
        foreach($specs as $spec)
        {
            unset($spec->id);

            $spec->addedBy   = $currentAccount;
            $spec->addedDate = helper::now();

            $this->dao->insert(TABLE_APISTRUCT_SPEC)->data($spec)->exec();
        }

        /* Insert module. */
        $modules = $this->getDemoData('module', $version);
        foreach($modules as $module)
        {
            if($module->type != 'api') continue;

            $oldID = $module->id;
            unset($module->id);

            $module->root = $libID;

            $this->dao->insert(TABLE_MODULE)->data($module)->exec();
            $newID = $this->dao->lastInsertID();
            $this->dao->update(TABLE_MODULE)->set('path')->eq(",$newID,")->where('id')->eq($newID)->exec();

            $moduleMap[$oldID] = $newID;
        }

        /* Insert api. */
        $this->loadModel('action');
        $apiMap = array();
        $apis   = $this->getDemoData('api', $version);
        foreach($apis as $api)
        {
            $oldID = $api->id;
            unset($api->id);

            $api->lib        = $libID;
            $api->module     = $moduleMap[$api->module];
            $api->addedBy    = $currentAccount;
            $api->addedDate  = helper::now();
            $api->editedBy   = $currentAccount;
            $api->editedDate = helper::now();

            $this->dao->insert(TABLE_API)->data($api)->exec();
            $newID = $this->dao->lastInsertID();

            $this->action->create('api', $newID, 'Created', '', '', $currentAccount);

            $apiMap[$oldID] = $newID;
        }

        /* Insert api spec. */
        $specs = $this->getDemoData('apispec', $version);
        foreach($specs as $spec)
        {
            unset($spec->id);

            $spec->doc       = $apiMap[$spec->doc];
            $spec->module    = zget($moduleMap, $spec->module, 0);
            $spec->owner     = $currentAccount;
            $spec->addedBy   = $currentAccount;
            $spec->addedDate = helper::now();

            $this->dao->insert(TABLE_API_SPEC)->data($spec)->exec();
        }

        return $libID;
    }

    /**
     * Get demo data.
     *
     * @param  string   $table
     * @param  stirng   $version
     * @access public
     * @return array
     */
    public function getDemoData($table, $version)
    {
        $file = $this->app->getAppRoot() . 'db' . DS . 'api' . DS . $version . DS . $table;
        return unserialize(preg_replace_callback('#s:(\d+):"(.*?)";#s', function($match){return 's:'.strlen($match[2]).':"'.$match[2].'";';}, file_get_contents($file)));
    }

     /**
     * Build search form.
     *
     * @param  object $lib
     * @param  string $queryID
     * @param  string $actionURL
     * @param  array  $libs
     * @param  string $type product|project
     * @access public
     * @return void
     */
    public function buildSearchForm($lib, $queryID, $actionURL, $libs = array(), $type = '')
    {
        if(empty($lib)) return;
        $libPairs = array('' => '', $lib->id => $lib->name);
        $this->config->api->search['module'] = 'api';
        if(!empty($libs))
        {
            foreach($libs as $lib)
            {
                if(empty($lib)) continue;
                if($lib->type != 'api') continue;
                $libPairs[$lib->id] = $lib->name;
            }
            $this->config->api->search['module'] = !empty($type) ? $type . 'apiDoc' : 'api';
        }

        $this->config->api->search['queryID']                 = $queryID;
        $this->config->api->search['actionURL']               = $actionURL;
        $this->config->api->search['params']['lib']['values'] = $libPairs + array('all' => $this->lang->api->allLibs);

        $this->loadModel('search')->setSearchParams($this->config->api->search);
    }

    /**
     * Get api by search.
     *
     * @param  string $libID
     * @param  int    $queryID
     * @param  string $objectType product|project
     * @param  array  $libs
     * @access public
     * @return array
     */
    public function getApiListBySearch($libID, $queryID, $objectType = '', $libs = array())
    {
        $queryName = $objectType ? $objectType . 'apiDocQuery' : 'apiQuery';
        $queryForm = $objectType ? $objectType . 'apiDocForm' : 'apiForm';
        if($queryID)
        {
            $query = $this->loadModel('search')->getQuery($queryID);
            if($query)
            {
                $this->session->set($queryName, $query->sql);
                $this->session->set($queryForm, $query->form);
            }
            else
            {
                $this->session->set($queryName, ' 1 = 1');
            }
        }
        else
        {
            if($this->session->$queryName == false) $this->session->set($queryName, ' 1 = 1');
        }

        $apiQuery = $this->session->$queryName;
        if(strpos($apiQuery, "`lib` = 'all'") !== false) $apiQuery = str_replace("`lib` = 'all'", '1', $apiQuery);

        $list = $this->dao->select('*')
            ->from(TABLE_API)
            ->where('deleted')->eq(0)
            ->andWhere($apiQuery)
            ->beginIF(!empty($libs))->andWhere('`lib`')->in($libs)->fi()
            ->fetchAll();

        return $list;
    }

    /**
     * Get ordered objects for dic.
     *
     * @access public
     * @return array
     */
    public function getOrderedObjects()
    {
        $normalObjects = $closedObjects = array();

        $libs     = $this->loadModel('doc')->getApiLibs();
        $products = $this->dao->select('t1.id, t1.order, t1.name, t1.status')->from(TABLE_PRODUCT)->alias('t1')
            ->leftjoin(TABLE_DOCLIB)->alias('t2')->on('t2.product=t1.id')
            ->where('t2.id')->gt(0)
            ->andWhere('t1.vision')->eq($this->config->vision)
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t2.id')->in(array_keys($libs))
            ->orderBy('order_asc')
            ->fetchAll('id');

        foreach($products as $id => $product)
        {
            if($product->status == 'normal')
            {
                $normalObjects['product'][$id] = $product->name;
            }
            elseif($product->status == 'closed')
            {
                $closedObjects['product'][$id] = $product->name;
            }
        }

        $projects = $this->dao->select('t1.id, t1.order, t1.name, t1.status')->from(TABLE_PROJECT)->alias('t1')
            ->leftjoin(TABLE_DOCLIB)->alias('t2')->on('t2.project=t1.id')
            ->where('t2.id')->gt(0)
            ->andWhere('t1.vision')->eq($this->config->vision)
            ->andWhere('t1.deleted')->eq(0)
            ->beginIF(!$this->app->user->admin)->andWhere('t1.id')->in($this->app->user->view->projects)->fi()
            ->andWhere('t2.id')->in(array_keys($libs))
            ->orderBy('t1.hasProduct_asc, order_asc')
            ->fetchAll('id');

        foreach($projects as $id => $project)
        {
            if($project->status != 'done' and $project->status != 'closed')
            {
                $normalObjects['project'][$id] = $project->name;
            }
            else if($project->status == 'done' or $project->status == 'closed')
            {
                $closedObjects['project'][$id] = $project->name;
            }
        }

        return array($normalObjects, $closedObjects);
    }

    /**
     * Get priv Apis..
     *
     * @param  string $mode all
     * @access public
     * @return array
     */
    public function getPrivApis($mode = '')
    {
        $libs = $this->dao->select('*')->from(TABLE_DOCLIB)
            ->where('type')->eq('api')
            ->andWhere('vision')->eq($this->config->vision)
            ->fetchAll('id');

        $this->loadModel('doc');
        foreach($libs as $libID => $lib)
        {
            if(!$this->doc->checkPrivLib($lib)) unset($libs[$libID]);
        }

        return $this->dao->select('id')->from(TABLE_API)
            ->where('lib')->in(array_keys($libs))
            ->beginIF($mode != 'all')->andWhere('deleted')->eq(0)->fi()
            ->fetchAll('id');
    }
}
