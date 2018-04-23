<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the contacts that had been created by user
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact', 'user_id');
    }

    /**
     * Get the group contacts that had been created by user
     */
    public function group_contacts()
    {
        return $this->hasMany('App\GroupContact', 'user_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function checkIsSuperAdmin()
    {
        return $this->super_admin == 1;
    }

    public function checkHasRole($role)
    {
        return $this->hasRole($role);
    }

    public function checkHasAnyRoles($roles)
    {
        return $this->hasAnyRole($roles);
    }

    public function checkHasPermission($perm)
    {
        return $this->checkIsSuperAdmin() ? true : $this->hasPermissionTo($perm);
    }

    public function getListManageUsers($applyRequestFilter = false, $request = false)
    {
        $queryString = array();
        $list = array();

        if ($applyRequestFilter) {
            $filter = new UserFilters($request);
            $queryString = $filter->buildQueryString();
            $list = $this->filter($filter);
        } else {
            $list = new User();
        }
        $list = $list->with(array('roles'));

        $list = $list->where("super_admin", "<>", 1);
        if (!$this->checkIsSuperAdmin()) {
            $userRoleWeight = $this->roles()->first()->weight;
            $list = $list->whereHas('roles', function ($q) use($userRoleWeight) {
                $q->where("weight", ">", $userRoleWeight);
            });
        }
        $list = $list->orderby('name');

        return array('list' => $list, 'query_string' => $queryString);
    }

    public function getListManageRoles()
    {
        $roles = new Role();
        if (!$this->checkIsSuperAdmin()) {
            $userRoleWeight = $this->roles()->first()->weight;
            $roles = $roles->where("weight", ">", $userRoleWeight);
        }
        $roles = $roles->orderby('name')->get();

        return $roles;
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (User $user) {
            $user->permissions()->detach();
            $user->roles()->detach();
        });
    }
}
