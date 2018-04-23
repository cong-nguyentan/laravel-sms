<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Acl extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions_map_controller_action';

    /**
     * Get the permission associated with the controller and action
     */
    public function permission()
    {
        return $this->belongsTo('App\Permission');
    }

    /**
     * Get the child items
     */
    public function childs()
    {
        return $this->hasMany('App\Acl', 'parent_id');
    }

    /**
     * Get the parent item
     */
    public function parent()
    {
        return $this->belongsTo('App\Acl', 'parent_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getListFiltered($request)
    {
        $filter = new AclFilters($request);
        $queryString = array();
        $list = array();

        $queryString = $filter->buildQueryString();
        $list = $this->filter($filter);
        $list = $list->orderby('controller')->orderby('action');

        return array('list' => $list, 'query_string' => $queryString);
    }

    public function getDesignedMenu($authorize = false)
    {
        $arrDesignedMenu = array();
        $currentUser = getCurrentUser();
        $parentMenus = $this->whereNull('parent_id')->where('show_in_menu', 1)->with(array('childs' => function ($q) {
            $q->with(array('permission'))->orderby('menu_order');
        }, 'permission'))->orderby('menu_order')->get()->toArray();

        if (!empty($parentMenus)) {
            foreach ($parentMenus as $parentMenu) {
                if ($authorize) {
                    if (empty($currentUser) || (!$currentUser->checkIsSuperAdmin() && !$currentUser->checkHasPermission($parentMenu['permission']['name']))) {
                        continue;
                    }
                }
                $childs = $parentMenu['childs'];
                $arrDesignedMenu[$parentMenu['id']] = array(
                    'id' => $parentMenu['id'],
                    'name' => $parentMenu['permission']['name'],
                    'controller' => $parentMenu['controller'],
                    'action' => $parentMenu['action'],
                    'childs' => array()
                );
                if (!empty($childs)) {
                    $arrChilds = array();
                    foreach ($childs as $child) {
                        if ($authorize) {
                            if (empty($currentUser) || (!$currentUser->checkIsSuperAdmin() && !$currentUser->checkHasPermission($child['permission']['name']))) {
                                continue;
                            }
                        }
                        $arrChilds[$child['id']] = array(
                            'id' => $child['id'],
                            'name' => $child['permission']['name'],
                            'controller' => $child['controller'],
                            'action' => $child['action']
                        );
                    }
                    $arrDesignedMenu[$parentMenu['id']]['childs'] = $arrChilds;
                }
            }
        }

        return $arrDesignedMenu;
    }

    public function saveDesignedMenu($menus)
    {
        $return = array(
            'status' => 'fail',
            'error' => __('acl.save_designed_menu_fail')
        );

        try {
            DB::beginTransaction();

            $affected = DB::update('UPDATE permissions_map_controller_action SET parent_id = NULL, menu_order = 1');
            $errorFound = false;

            if (!empty($menus)) {
                foreach ($menus as $key => $menu) {
                    if ($errorFound) {
                        break;
                    }
                    $objMenu = $this->where("id", $menu['id'])->first();
                    if (empty($objMenu)) {
                        $errorFound = true;
                        break;
                    }
                    $objMenu->menu_order = $key + 1;
                    $objMenu->save();

                    $parent = $menu['id'];
                    if (!empty($menu['children'])) {
                        foreach ($menu['children'] as $childKey => $child) {
                            $objChildMenu = $this->where("id", $child['id'])->first();
                            if (empty($objChildMenu)) {
                                $errorFound = true;
                                break;
                            }
                            $objChildMenu->menu_order = $childKey + 1;
                            $objChildMenu->parent_id = $parent;
                            $objChildMenu->save();
                        }
                    }
                }
            }

            if ($errorFound) {
                DB::rollBack();
            } else {
                $return = array(
                    'status' => 'ok',
                    'error' => ''
                );

                DB::commit();
            }

        } catch (\Exception $e) {
            $return['error'] = formatHandleErrorMessage($return['error'], $e);
            DB::rollBack();
        }

        return $return;
    }
}
