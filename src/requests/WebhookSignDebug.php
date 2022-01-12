<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 29.12.2021
 * Time: 10:50
 */

namespace sbank\requests;


use sbank\common\Request;

class WebhookSignDebug extends Request
{
    public $merchant_id;
    public $webhook_id;
    public $api_secret;

    public function getMethod()
    {
        return 'GET';
    }

    public function getAddress()
    {
        return '/webhook_sign_debug';
    }

    protected function getPayload($data)
    {
        return [
            "PATH" => $this->getAddress(),
            $this->getMethod() => $data
        ];
    }
}
