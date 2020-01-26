<?php namespace NetworkPie\Bloke;


class Request
{
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    private $_props = [];

    public $_url;
    public $_method;

    public function __construct()
    {
        foreach($_REQUEST as $k => $v) {
            $this->{$k} = $v;
        }

        $this->_url = $_SERVER['REQUEST_URI'];
        $this->_method = $_SERVER['REQUEST_METHOD'];
    }

    /* Overloading methods */
    public function __get($nm)
    {
        if (isset($this->_props[$nm])) {
            return $this->_props[$nm];
        }
    }

    public function __set($nm, $val)
    {
        $this->_props[$nm] = $val;
    }

    public function __isset($nm)
    {
        return isset($this->_props[$nm]);
    }

    public function __unset($nm)
    {
        unset($this->_props[$nm]);
    }

}
