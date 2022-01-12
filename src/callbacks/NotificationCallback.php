<?php
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
