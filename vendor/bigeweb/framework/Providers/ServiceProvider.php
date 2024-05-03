<?php

namespace illuminate\Support\Providers;

class ServiceProvider
{
    protected $bindings = [];
    protected $app;

    public function __construct()
    {
        $this->app = $this;
    }

    // Bind a class or interface to a concrete implementation
    public function bind($abstract, $concrete) {
        $this->bindings[$abstract] = $concrete;
        return $this->make($abstract);
    }

    // Resolve an instance from the container
    public function make($abstract) {
        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
            return new $concrete();
        }

        throw new \Exception("Binding not found for {$abstract}");
    }
}