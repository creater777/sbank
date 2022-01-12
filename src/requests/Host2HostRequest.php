<?php
namespace sbank\requests;


class Host2HostRequest extends InitRequest
{
    public $cvc;
    public $expire_month;
    public $expire_year;
    public $pan;
}
