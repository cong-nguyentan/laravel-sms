<?php

namespace App;

class UserFilters extends QueryFilter
{

    public function search($filter)
    {
        return $this->builder->where(function ($query) use($filter) {
            $query->where("name", "LIKE", "%" . $filter . "%")
                  ->orWhere("email", "LIKE", "%" . $filter . "%");
        });
    }

    public function role($filter)
    {
        return $this->builder->whereHas('roles', function ($q) use($filter) {
            $q->where('id', $filter);
        });
    }

}