<?php

namespace congnguyentan\NotifyPackage\AbstractClasses;

abstract class SMS extends Notify {
    protected $_phone = "";

    protected $_from = "";

    protected $_message = "";

    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    public function setFrom($from)
    {
        $this->_from = $from;
    }

    public function setMessage($message)
    {
        $this->_message = $message;
    }

    abstract public function send($phone, $from, $message);
}