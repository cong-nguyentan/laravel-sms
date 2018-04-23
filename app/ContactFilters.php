<?php

namespace App;

class ContactFilters extends QueryFilter
{

    public function search($filter)
    {
        return $this->builder->where("name", "LIKE", "%" . $filter . "%")->orWhere('phone', 'LIKE', "%" . $filter . "%");
    }

    public function group($group)
    {
        return $this->builder->whereHas('groups', function ($q) use($group) {
            $q->where('group_id', $group);
        });
    }

}