<?php

namespace App;

class PermissionFilters extends QueryFilter
{

    public function search($filter)
    {
        return $this->builder->where("name", "LIKE", "%" . $filter . "%");
    }

}