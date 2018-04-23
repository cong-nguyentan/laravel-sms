<?php

namespace App;

class GroupContactFilters extends QueryFilter
{

    public function search($filter)
    {
        return $this->builder->where("name", "LIKE", "%" . $filter . "%");
    }

}