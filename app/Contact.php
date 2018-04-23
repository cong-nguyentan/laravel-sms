<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Get the user created contact
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the groups contact
     */
    public function groups()
    {
        return $this->belongsToMany('App\GroupContact', 'group_contact_relations', 'contact_id', 'group_id');
    }

    /**
     * Get the file imported contact
     */
    public function file_imported()
    {
        return $this->belongsTo('App\ContactImport');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getListFiltered($request)
    {
        $userLogged = getCurrentUser();
        $filter = new ContactFilters($request);
        $queryString = array();
        $list = array();

        $queryString = $filter->buildQueryString();
        $list = $this->filter($filter);
        if (!$userLogged->checkIsSuperAdmin()) {
            $list = $list->whereHas('creator', function($q) use($userLogged) {
                $q->where('id', $userLogged->id);
            });
        }
        $list = $list->orderby('name')->orderby('phone');

        return array('list' => $list, 'query_string' => $queryString);
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Contact $contact) {
            $contact->groups()->detach();
        });
    }
}
