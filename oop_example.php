<?php

abstract class Send {
	protected $_error = "";
	
	abstract public function send();
}

abstract class SMS extends Send {
	protected $_phone = "";
	
	protected $_from = "";
	
	protected $_message = "";
	
	protected function setData($phone, $from, $message)
	{
		$this->_phone = $phone;
		$this->_from = $from;
		$this->_message = $message;
	}
}

class NexmoSMS extends SMS {
	private $_basic = null;
	
	private $_client = null;
	
	public function __construct($phone, $from, $message)
	{
		$this->_basic = true;
		$this->_client = true;
		
		$this->setData($phone, $from, $message);
	}
	
	public function send()
	{
		return array('phone' => $this->_phone, 'from' => $this->_from, 'message' => $this->_message);
	}
}

$obj = new NexmoSMS("1", "2", "3");
var_dump($obj->send());