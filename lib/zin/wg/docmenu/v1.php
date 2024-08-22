<?php
declare(strict_types=1);
namespace zin;

class docMenu extends wg
{
    private array $modules = array();

    private array $mineTypes = array('mine', 'view', 'collect', 'createdby', 'editedby');

    protected static array $defineProps = array(
        'modules: array',
        'activeKey?: int',
        'settingLink?: string',
        'menuLink: string',
        'title?: string',
        'linkParams?: string="%s"',
        'libID?: int=0',
        'moduleID?: int=0',
        'spaceType?: string',
        'objectType?: string',
        'objectID?: int=0',
        'hover?: bool=true',
    );

    public static function getPageCSS(): string|false
    {
        return file_get_contents(__DIR__ . DS . 'css' . DS . 'v1.css');
    }

    public static function getPageJS(): string|false
    {
        return file_get_contents(__DIR__ . DS . 'js' . DS . 'v1.js');
    }

    private function buildLink($item, $releaseID = 0): string
    {
        $url = $item->url;
        if(!empty($url)) return $url;
        if(in_array($item->type, array('apiLib', 'docLib')))
        {
            $this->libID    = $item->id;
            $this->moduleID = 0;
        }
        if($item->type == 'module') $this->moduleID = $item->id;

        $linkParams = sprintf($this->linkParams, "libID={$this->libID}&moduleID={$this->moduleID}");
        if(in_array($this->spaceType, array('product', 'project', 'custom'))) $linkParams = "objectID={$this->objectID}&{$linkParams}";

        $objectType = $this->objectType;

        $moduleName = $this->spaceType == 'api' ? 'api' : 'doc';
        $methodName = '';
        if($this->spaceType == 'api')
        {
            $methodName = 'index';
            $linkParams =  substr($linkParams, 1);
        }
        else if($item->type == 'annex')
        {
            $methodName = 'showFiles';
            $linkParams = "type={$objectType}&objectID={$item->objectID}";
        }
        else if(in_array($item->type, array('text', 'word', 'ppt', 'excel')))
        {
            $methodName = 'view';
            $linkParams = "docID={$this->moduleID}";
        }
        else if($objectType == 'execution')
        {
            $moduleName = 'execution';
            $methodName = 'doc';
        }
        else
        {
            $methodName = $this->spaceMethod[$objectType] ? $this->spaceMethod[$objectType] : 'teamSpace';
            if(in_array($objectType, $this->mineTypes))
            {
                $moduleID = $item->id;
                if(in_array($item->type, array('docLib', 'annex', 'api', 'execution'))) $moduleID = 0;

                $type       = in_array(strtolower($item->type), $this->mineTypes) ? strtolower($item->type) : 'mine';
                $linkParams = "type={$type}&libID={$this->libID}&moduleID={$moduleID}";
            }
            if($item->type == 'module' && $item->object == 'api')
            {
                $linkParams = str_replace(array('browseType=&', 'param=0'), array('browseType=byrelease&', "param={$this->release}"), $linkParams);
            }
        }

        if($releaseID)
        {
            if($this->currentModule == 'doc')
            {
                $linkParams = str_replace(array('browseType=&', 'param=0'), array('browseType=byrelease&', "param={$releaseID}"), $linkParams);
                if($this->rawMethod == 'view') $linkParams = "libID={$this->libID}&moduleID=0&browseType=byrelease&orderBy=&status,id_desc&param={$releaseID}";
            }
            else
            {
                $linkParams = "libID={$this->libID}&moduleID=0&apiID=0&version=0&release={$releaseID}";
            }
        }
        return helper::createLink($moduleName, $methodName, $linkParams);
    }

    private function buildMenuTree(array $items, int $parentID = 0): array
    {
        if(empty($items)) $items = $this->modules;
        if(empty($items)) return array();

        $activeKey   = $this->prop('activeKey');
        $parentItems = array();
        foreach($items as $setting)
        {
            if(!is_object($setting)) continue;

            $setting->parentID = $parentID;

            $itemID = 0;
            if(!in_array(strtolower($setting->type), $this->mineTypes)) $itemID = $setting->id ? $setting->id : $parentID;

            $item = array(
                'key'         => $itemID,
                'text'        => $setting->name,
                'icon'        => $this->getIcon($setting),
                'url'         => $this->buildLink($setting),
                'attrs'       => array('data-app' => $this->tab),
                'data-id'     => $itemID,
                'data-lib'    => in_array($setting->type, array('docLib', 'apiLib')) ? $itemID : $setting->libID,
                'data-type'   => $setting->type,
                'data-parent' => $setting->parentID,
                'data-module' => $this->currentModule,
                'active'      => zget($setting, 'active', $itemID == $activeKey),
                'actions'     => $this->getActions($setting)
            );

            $children = zget($setting, 'children', array());
            if(!empty($children))
            {
                $children = $this->buildMenuTree($children, $itemID);
                $item['items'] = $children;
            }

            $parentItems[] = $item;
        }
        return $parentItems;
    }

    private function setMenuTreeProps(): void
    {
        global $app, $lang;
        $this->lang          = $lang;
        $this->tab           = $app->tab;
        $this->rawModule     = $app->rawModule;
        $this->rawMethod     = $app->rawMethod;
        $this->currentModule = $app->moduleName;

        $this->release     = $this->prop('release', 0);
        $this->libID       = $this->prop('libID');
        $this->moduleID    = $this->prop('moduleID');
        $this->modules     = $this->prop('modules');
        $this->linkParams  = $this->prop('linkParams', '%s');
        $this->spaceType   = $this->prop('spaceType', '');
        $this->objectType  = $this->prop('objectType', '');
        $this->objectID    = $this->prop('objectID', 0);
        $this->spaceMethod = $this->prop('spaceMethod');

        if($this->rawModule == 'api' && $this->rawMethod == 'view') $this->spaceType = 'api';
        if(empty($this->modules['project']))
        {
            $this->setProp('items', $this->buildMenuTree(array(), $this->libID));
        }
        else
        {
            $items = array();
            $index = 0;
            foreach($this->modules as $treeType => $modules)
            {
                if($treeType == 'project')
                {
                    $treeTitle = $lang->projectCommon;
                    $treeIcon  = 'project';
                }
                elseif($treeType == 'execution')
                {
                    $treeTitle = $lang->execution->common;
                    $treeIcon  = 'run';
                }
                else
                {
                    $treeTitle = $lang->files;
                    $treeIcon  = 'paper-clip';
                }
                $items[] = array(
                    'text'  => $treeTitle,
                    'icon'  => $treeIcon,
                    'class' => 'project-tree-title ' . ($index > 0 ? 'border-t mt-2 pt-2' : ''),
                );

                $items = array_merge($items, $this->buildMenuTree($modules, $this->libID));
                $index ++;
            }
            $this->setProp('items', $items);
        }
    }

    private function getActions($item): array|null
    {
        $versionBtn = array();
        if(isset($item->versions) && $item->versions)
        {
            global $lang;
            $versionTitle = $lang->build->common;
            $versionBtn = array(
                'key'      => 'version',
                'text'     => $versionTitle,
                'type'     => 'dropdown',
                'dropdown' => array(
                    'placement' => 'bottom-end',
                    'items'     => array(),
                )
            );

            foreach($item->versions as $version)
            {
                if($version->id == $this->release) $versionBtn['text'] = $version->version;

                $versionBtn['dropdown']['items'][] = array(
                    'text'   => $version->version,
                    'href'   => $this->buildLink($item, $version->id),
                    'active' => $version->id == $this->release,
                );
            }
        }

        $moreBtn = array();
        if(!isset($item->hasAction) || $item->hasAction || in_array($item->type, array('mine', 'view', 'collect', 'createdBy', 'editedBy')))
        {
            $actions = $this->getOperateItems($item);
            if($actions)
            {
                $moreBtn = array(
                    'key'      => 'more',
                    'icon'     => 'ellipsis-v',
                    'type'     => 'dropdown',
                    'caret'    => false,
                    'dropdown' => array(
                        'placement' => 'bottom-end',
                        'items'     => $actions,
                    )
                );
            }
        }

        $actions = array();
        if($versionBtn) $actions[] = $versionBtn;
        if($moreBtn)    $actions[] = $moreBtn;
        return $actions ? $actions : null;
    }

    private function getOperateItems($item): array
    {
        $menus = array();
        if(in_array($item->type, array('docLib', 'apiLib')))
        {
            $itemID = $item->id ? $item->id : $item->parentID;
            if(hasPriv($this->currentModule, 'addCatalog'))
            {
                $menus[] = array(
                    'key'     => 'adddirectory',
                    'icon'    => 'add-directory',
                    'text'    => $this->lang->doc->libDropdown['addModule'],
                    'onClick' => jsRaw("() => addModule({$itemID}, 'child')")
                );
            }

            if(hasPriv($this->currentModule, 'editCatalog'))
            {
                $menus[] = array(
                    'key'         => 'editlib',
                    'icon'        => 'edit',
                    'text'        => $this->lang->doc->libDropdown['editLib'],
                    'data-toggle' => 'modal',
                    'data-url'    => createlink($this->currentModule, 'editlib', "libID={$itemID}"),
                );
            }

            if(hasPriv($this->currentModule, 'deleteCatalog'))
            {
                $menus[] = array(
                    'key'          => 'dellib',
                    'icon'         => 'trash',
                    'text'         => $this->lang->doc->libDropdown['deleteLib'],
                    'class'        => 'ajax-submit',
                    'data-url'     => createLink($this->currentModule, 'deleteLib', "libID={$itemID}"),
                    'data-confirm' => $this->lang->doc->confirmDeleteLib,
                );
            }
        }
        elseif($item->type == 'module')
        {
            if(hasPriv($this->currentModule, 'addCatalog'))
            {
                $menus[] = array(
                    'key'     => 'adddirectory',
                    'icon'    => 'add-directory',
                    'text'    => $this->lang->doc->libDropdown['addSameModule'],
                    'onClick' => jsRaw("() => addModule({$item->id}, 'same')")
                );
                $menus[] = array(
                    'key'     => 'addsubdirectory',
                    'icon'    => 'add-directory',
                    'text'    => $this->lang->doc->libDropdown['addSubModule'],
                    'onClick' => jsRaw("() => addModule({$item->id}, 'child')")
                );
            }

            if(hasPriv($this->currentModule, 'editCatalog'))
            {
                $menus[] = array(
                    'key'  => 'editmodule',
                    'icon' => 'edit',
                    'text' => $this->lang->doc->libDropdown['editModule'],
                    'link' => '',
                    'data-toggle' => 'modal',
                    'data-url'    => createlink($this->currentModule, 'editCatalog', "moduleID={$item->id}&type=" . ($this->rawModule == 'api' ? 'api' : 'doc')),
                );
            }

            if(hasPriv($this->currentModule, 'deleteCatalog'))
            {
                $menus[] = array(
                    'key'          => 'delmodule',
                    'icon'         => 'trash',
                    'text'         => $this->lang->doc->libDropdown['delModule'],
                    'class'        => 'ajax-submit',
                    'data-url'     => createLink($this->currentModule, 'deleteCatalog', "rootID={$item->parentID}&moduleID={$item->id}"),
                    'data-confirm' => $this->lang->api->confirmDeleteLib,
                );
            }
        }

        return $menus;
    }

    private function getIcon($item): string
    {
        $type = $item->type;
        if($type == 'apiLib')    return 'interface-lib';
        if($type == 'docLib')    return 'wiki-lib';
        if($type == 'annex')     return 'annex-lib';
        if($type == 'execution') return 'execution';
        if($type == 'text')      return 'file-text';
        if($type == 'word')      return 'file-word';
        if($type == 'ppt')       return 'file-powerpoint';
        if($type == 'excel')     return 'file-excel';
        return '';
    }

    private function getTitle(): string
    {
        global $lang;
        $activeKey = $this->prop('activeKey');

        if(empty($activeKey)) return $this->prop('title');

        foreach($this->modules as $module)
        {
            if($module->id == $activeKey) return $module->name;
        }

        return '';
    }

    private function buildBtns(): wg|null
    {
        $settingLink = $this->prop('settingLink');
        $settingText = $this->prop('settingText');
        if(!$settingLink) return null;

        global $app;
        $lang = $app->loadLang('datatable')->datatable;
        $currentModule = $app->rawModule;
        $currentMethod = $app->rawMethod;

        if(!$settingText) $settingText = $lang->moduleSetting;

        $datatableId = $app->moduleName . ucfirst($app->methodName);

        return div
        (
            setClass('col gap-2 py-3 px-7'),
            $settingLink
                ? a
                (
                    setClass('btn'),
                    setStyle('background', '#EEF5FF'),
                    setStyle('box-shadow', 'none'),
                    set('data-app', $app->tab),
                    set('data-size', 'sm'),
                    set('data-toggle', 'modal'),
                    set::href($settingLink),
                    $settingText
                )
                : null,
        );
    }

    protected function build(): wg
    {
        $this->setMenuTreeProps();
        $title    = $this->getTitle();
        $menuLink = $this->prop('menuLink', '');

        return div
            (
                $menuLink ? dropmenu
                (
                    set::id('docDropmenu'),
                    set::menuID('docDropmenuMenu'),
                    set::text($title),
                    set::url($menuLink),
                ) : null,
                div
                (
                    setClass('module-menu rounded shadow-sm bg-white col rounded-sm'),
                    $title && empty($menuLink) ? h::header
                    (
                        setClass('h-10 flex items-center pl-4 flex-none gap-3'),
                        span
                        (
                            setClass('module-title text-lg font-semibold'),
                            html($title)
                        ),
                    ) : null,
                    h::main
                    (
                        setClass($menuLink ? 'pt-3' : ''),
                        setClass('col flex-auto overflow-y-auto overflow-x-hidden pl-4 pr-1'),
                        zui::tree(set($this->props->pick(array('items', 'activeClass', 'activeIcon', 'activeKey', 'onClickItem', 'defaultNestedShow', 'changeActiveKey', 'isDropdownMenu', 'hover'))))
                    ),
                    $this->buildBtns()
                ),
        );
    }
}
