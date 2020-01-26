<?php namespace NetworkPie\Bloke;


class Response
{
    private $_headers;

    private $_content;

    public function __construct()
    {

    }

    public function setBody($content)
    {
        $this->_content = $content;
    }

    public function send()
    {
        echo $this->_content;
    }

}
