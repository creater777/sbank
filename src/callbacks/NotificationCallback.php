<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 29.12.2021
 * Time: 4:13
 */

namespace sbank\callbacks;


use sbank\common\Callback;

class NotificationCallback extends Callback
{
    public $webhook_type;
    public $customer_fee;
    public $status;
    public $webhook_id;
    public $payment_error_code;
    public $payment_error;
}
