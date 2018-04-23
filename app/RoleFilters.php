<?php

namespace App;

class RoleFilters extends QueryFilter
{

    public function search($filter)
    {
        return $this->builder->where("name", "LIKE", "%" . $filter . "%");
    }

}