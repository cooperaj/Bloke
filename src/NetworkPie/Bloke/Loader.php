<?php namespace NetworkPie\Bloke;


class Loader
{

    private $src_dir;

    public function __construct($src_dir)
    {
        $this->src_dir = $src_dir;

        $this->init();
    }

    public function init()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function loadClass($class)
    {
        $name = $this->src_dir . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        if (file_exists($name)) {
            require($name);
            return true;
        }

        return false;
    }

}
