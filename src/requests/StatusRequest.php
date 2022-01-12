<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 29.12.2021
 * Time: 4:24
 */

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

    protected function getPayload($data)
    {
        return [
            "PATH" => $this->getAddress(),
            $this->getMethod() => $data
        ];
    }
}
