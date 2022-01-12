<?php
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
}
