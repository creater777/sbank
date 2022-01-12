<?php
namespace sbank\requests;


use sbank\common\Request;

class StatusRequest extends Request
{
    public $merchant_id;
    public $order;
    public $product_id;

    public function getMethod()
    {
        return 'GET';
    }

    public function getAddress()
    {
        return '/status';
    }
}
