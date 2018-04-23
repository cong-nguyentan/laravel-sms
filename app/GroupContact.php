<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupContact extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_contacts';

    /**
     * Get the user created group
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the contacts
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Contact', 'group_contact_relations', 'group_id', 'contact_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getListFiltered($request)
    {
        $userLogged = getCurrentUser();
        $filter = new GroupContactFilters($request);
        $queryString = array();
        $list = array();

        $queryString = $filter->buildQueryString();
        $list = $this->filter($filter);
        if (!$userLogged->checkIsSuperAdmin()) {
            $list = $list->whereHas('creator', function($q) use($userLogged) {
                $q->where('id', $userLogged->id);
            });
        }
        $list = $list->orderby('name');

        return array('list' => $list, 'query_string' => $queryString);
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (GroupContact $groupContact) {
            $groupContact->contacts()->detach();
        });
    }
}
