<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission as SpatiePermission;

use DB;

class Permission extends SpatiePermission
{
    /**
     * Get the controller and action associated with the permission
     */
    public function acls()
    {
        return $this->hasMany('App\Acl');
    }

    /**
     * Get the child of group
     */
    public function group_childs()
    {
        return $this->hasMany('App\Permission', 'group_master');
    }

    /**
     * Get the group master
     */
    public function group_master()
    {
        return $this->belongsTo('App\Permission', 'group_master');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getListFiltered($request)
    {
        $filter = new PermissionFilters($request);
        $queryString = array();
        $list = array();

        $queryString = $filter->buildQueryString();
        $list = $this->filter($filter);
        $list = $list->orderby('name');

        return array('list' => $list, 'query_string' => $queryString);
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Permission $permission) {
            if (!empty($permission->group_childs)) {
                foreach ($permission->group_childs as $groupChild) {
                    $groupChild->group_master = null;
                    $groupChild->group_order = 1;
                    $groupChild->save();
                }
            }
            $permission->acls()->delete();
            $permission->roles()->detach();
            $permission->users()->detach();
        });
    }

    public function getDesignedGroup()
    {
        $arrDesignedGroup = array();
        $parentGroups = $this->whereNull('group_master')->with(array('group_childs' => function ($q) {
            $q->orderby('group_order');
        }))->orderby('group_order')->get()->toArray();

        if (!empty($parentGroups)) {
            foreach ($parentGroups as $parentGroup) {
                $childs = $parentGroup['group_childs'];
                $arrDesignedGroup[$parentGroup['id']] = array(
                    'id' => $parentGroup['id'],
                    'name' => $parentGroup['name'],
                    'childs' => array()
                );
                if (!empty($childs)) {
                    $arrChilds = array();
                    foreach ($childs as $child) {
                        $arrChilds[$child['id']] = array(
                            'id' => $child['id'],
                            'name' => $child['name'],
                        );
                    }
                    $arrDesignedGroup[$parentGroup['id']]['childs'] = $arrChilds;
                }
            }
        }

        return $arrDesignedGroup;
    }

    public function saveDesignedGroup($groups)
    {
        $return = array(
            'status' => 'fail',
            'error' => __('permission.save_designed_group_fail')
        );

        try {
            DB::beginTransaction();

            $affected = DB::update('UPDATE permissions SET group_master = NULL, group_order = 1');
            $errorFound = false;

            if (!empty($groups)) {
                foreach ($groups as $key => $group) {
                    if ($errorFound) {
                        break;
                    }
                    $objMenu = $this->where("id", $group['id'])->first();
                    if (empty($objMenu)) {
                        $errorFound = true;
                        break;
                    }
                    $objMenu->group_order = $key + 1;
                    $objMenu->save();

                    $master = $group['id'];
                    if (!empty($group['children'])) {
                        foreach ($group['children'] as $childKey => $child) {
                            $objChildMenu = $this->where("id", $child['id'])->first();
                            if (empty($objChildMenu)) {
                                $errorFound = true;
                                break;
                            }
                            $objChildMenu->group_order = $childKey + 1;
                            $objChildMenu->group_master = $master;
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
