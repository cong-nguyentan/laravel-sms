<?php

// App/QueryFilter.php
namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;

    protected $builder;

    private $_queryString;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $value = trim($value);
            $name = $this->_convertFilterVarToFilterFunction($name);
            if (method_exists($this, $name) && !empty($value)) {
                call_user_func_array([$this, $name], [$value]);
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }

    public function buildQueryString()
    {
        $this->_queryString = array();
        foreach ($this->filters() as $name => $value) {
            $value = trim($value);
            if (!empty($value)) {
                $this->_queryString[$name] = $value;
            }
        }

        return $this->_queryString;
    }

    private function _convertFilterVarToFilterFunction($var)
    {
        $var = trim($var);
        if (empty($var)) {
            return "";
        }

        $parses = explode("_", $var);

        $function = array(strtolower($parses[0]));
        for ($i = 1; $i < count($parses); $i++) {
            $function[] = ucwords($parses[$i]);
        }

        return implode("", $function);
    }
}