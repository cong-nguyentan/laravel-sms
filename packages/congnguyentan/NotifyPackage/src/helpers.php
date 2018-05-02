<?php

if (!function_exists('sms_send')) {
    function sms_send($phone, $from, $message)
    {
        $smsLibUsing = config("notify.sms");
        if (!empty($smsLibUsing)) {
            $classSmsLibUsing = ucfirst($smsLibUsing) . "SMS";
            $classSmsLibUsing = "congnguyentan\\NotifyPackage\\Classes\\" . $classSmsLibUsing;
            if (class_exists($classSmsLibUsing)) {
                try {
                    $obj = $classSmsLibUsing::getInstance();
                    return $obj->send($phone, $from, $message);
                } catch (\Exception $e) {

                }
            }
        }

        return false;
    }
}