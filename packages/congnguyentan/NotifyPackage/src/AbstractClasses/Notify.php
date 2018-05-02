<?php

namespace congnguyentan\NotifyPackage\AbstractClasses;

abstract class Notify {
    protected function localizeString($key)
    {
        return Lang::has($key) ? __($key) : __("notify::" . $key);
    }
}