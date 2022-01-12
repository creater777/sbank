<?php
namespace sbank\common;


/**
 * Class BaseObject
 * @package sbank\common
 *
 */
class BaseObject
{
    public function __construct(array $params)
    {
        foreach ($params as $key => $value){
            $this->$key = $value;
        }
    }

    public function __set($name, $value)
    {
        if (method_exists($this, "set".ucfirst($name))){
            $this->{"set".ucfirst($name)}($value);
            return;
        }
        $this->$name = $value;
    }

    public function getAsArray(): array
    {
        $params = [];
        foreach(get_class_vars(get_class($this)) as $param => $value){
            if (!empty($this->{$param})){
                $params[$param] = $this->$param;
            }
        }
        return $params;
    }
}
