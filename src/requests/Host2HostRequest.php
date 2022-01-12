<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 28.12.2021
 * Time: 17:56
 */

namespace sbank\requests;


class Host2HostRequest extends InitRequest
{
    public $cvc;
    public $expire_month;
    public $expire_year;
    public $pan;
}
