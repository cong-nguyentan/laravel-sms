<?php

namespace App;

class AclFilters extends QueryFilter
{

    public function search($filter)
    {
        return $this->builder->whereHas('permission', function($q) use($filter) {
            $q->where("name", "LIKE", "%" . $filter . "%");
        })->orWhere("controller", "LIKE", "%" . $filter . "%")
          ->orWhere("action", "LIKE", "%" . $filter . "%");
    }

    public function showInMenu($showInMenu)
    {
        return $this->builder->where('show_in_menu', "=", $showInMenu);
    }

}