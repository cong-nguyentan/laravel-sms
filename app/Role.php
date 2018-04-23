<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getListFiltered($request)
    {
        $filter = new RoleFilters($request);
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

        self::deleting(function (Role $role) {
            $role->permissions()->detach();
            $role->users()->detach();
        });
    }
}
