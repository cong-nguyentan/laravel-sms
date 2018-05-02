<?php

namespace congnguyentan\NotifyPackage\Classes;

use congnguyentan\NotifyPackage\AbstractClasses\SMS;

use Nexmo\Client\Credentials\Basic;
use Nexmo\Client;

class NexmoSMS extends SMS {
    private $_key = "";

    private $_secret = "";

    private $_basic = null;

    private $_client = null;

    private static $_instance = null;

    private function __construct()
    {
        $this->_key = config("notify.config.sms.nexmo.key");
        $this->_secret = config("notify.config.sms.nexmo.secret");

        try {
            $this->_basic  = new Basic($this->_key, $this->_secret);
            $this->_client = new Client($this->_basic);
        } catch (\Exception $e) {

        }
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new NexmoSMS();
        }

        return self::$_instance;
    }

    public function send($phone, $from, $message)
    {
        $result = array(
            'status' => false,
            'error' => ''
        );

        $this->setPhone($phone);
        $this->setFrom($from);
        $this->setMessage($message);

        try {
            $message = $this->_client->message()->send([
                'to' => $this->_phone,
                'from' => $this->_from,
                'text' => $this->_message
            ]);

            $response = $message->getResponseData();

            $result['status'] = !empty($response['message-count']);
            $result['error'] = $result['status'] ? "" : $this->localizeString("sms.send_fail");
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }
}