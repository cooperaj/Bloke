<?php namespace NetworkPie\Bloke;

use NetworkPie\Bloke\Exception\DependencyBindingException;
use NetworkPie\Bloke\Exception\ServiceLocatorException;

class ServiceLocator
{
    const INSTANCE = true;

    private $_services = [];

    private $_instances = [];

    public function add($name, $service, $instance = false)
    {
        $this->_services[$name] = $service;
        $this->_instances[$name] = $instance;
    }

    public function get($name)
    {
        if ( ! isset($this->_services[$name]))
            throw new ServiceLocatorException("Service '$name' not available to the service locator");

        $instance = $this->_services[$name];

        if (is_object($instance) && ! is_callable($instance))
            return $instance;

        return $this->instantiate($name);
    }

    /* Overloading methods */
    public function __get($nm)
    {
        return $this->get($nm);
    }

    public function __set($nm, $service)
    {
        $this->add($nm, $service);
    }

    public function __isset($nm)
    {
        return isset($this->_services[$nm]);
    }

    public function __unset($nm)
    {
        unset($this->_services[$nm]);
    }

    /**
     * @param $class string The class name of a class to attempt to instantiate.
     * @throws DependencyBindingException
     * @return object The instance with all dependencies created if possible.
     */
    public function make($class, array $args = [])
    {
        $class_reflection = new \ReflectionClass($class);

        // Can we even create an instance of the class?
        if ($class_reflection->IsInstantiable()) {

            // If the class has a constructor then we need to figure out if we auto-instantiate
            // the dependencies.
            $constructor = $class_reflection->getConstructor();
            if ($constructor !== null) {

                // Iterate the parameters and recursively call this function to instantiate them.
                $params = $args;
                if (empty($params)) {
                    foreach ($constructor->getParameters() as $param) {
                        $param_class = $param->getClass();

                        if ($param_class === null ||  ! $param_class->IsInstantiable())
                            throw new DependencyBindingException("Unable to bind parameters for class '$param_class->name'");

                        // only ever one service locator, this one
                        if ($param_class->name === __CLASS__) 
                            $params[] = $this;

                        $params[] = $this->make($param_class->name);
                    }
                }

                return $class_reflection->newInstanceArgs($params);
            }

            return new $class;
        }
    }

    private function instantiate($name)
    {
        $service = $this->_services[$name];

        // If a closure has been stored against this name call it and pass in this container.
        if (is_callable($service)) {
            $instance = $service($this);
        } else {
            $instance = $this->make($service);
        }

        // Store the instance as a singleton if requested.
        if ($this->_instances[$name] === true)
            $this->_services[$name] = $instance;

        return $instance;
    }

}
