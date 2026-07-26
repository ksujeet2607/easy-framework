<?php

namespace Core;

use DI\Container;

class Loader
{
    protected $loadedControllers = [];
    protected $loadedEntities = [];
    protected $loadedHelpers = [];

    protected $loadedServices = [];

    public function __construct(private Container $container)
    {
    }

    public function controller(string $controller)
    {
        // Normalize the controller name to handle both `::class` and simple strings
        $controllerName = class_exists($controller) ? $controller : 'App\\Controllers\\' . $controller;

        // Generate the file path based on the normalized controller name
        $filePath = __DIR__ . '/../' . str_replace('\\', '/', $controllerName) . '.php';

        if (!isset($this->loadedControllers[$controllerName]) && file_exists($filePath)) {
            require_once $filePath;
            $this->loadedControllers[$controllerName] = $this->container->get($controllerName);
        }

        return $this->loadedControllers[$controllerName] ?? null;
    }


    public function entity($entity)
    {
        // Normalize the entity name to handle both `::class` and simple strings
        $entityName = class_exists($entity) ? $entity : 'App\\Entities\\' . $entity;

        // Generate the file path based on the normalized entity name
        $filePath = __DIR__ . '/../' . str_replace('\\', '/', $entityName) . '.php';

        if (!isset($this->loadedEntities[$entityName]) && file_exists($filePath)) {
            require_once $filePath;
            $this->loadedEntities[$entityName] = $this->container->get($entityName);
        }

        return $this->loadedEntities[$entityName] ?? null;

    }

    public function service($service)
    {
        // Normalize the service name to handle both `::class` and simple strings
        $serviceName = class_exists($service) ? $service : 'App\\Services\\' . $service;

        // Generate the file path based on the normalized service name
        $filePath = __DIR__ . '/../' . str_replace('\\', '/', $serviceName) . '.php';

        if (!isset($this->loadedServices[$serviceName]) && file_exists($filePath)) {
            require_once $filePath;
            $this->loadedServices[$serviceName] = $this->container->make($serviceName);
        }

        return $this->loadedServices[$serviceName] ?? null;

    }

    public function helper($helper)
    {
        // Normalize the helper name to handle both `::class` and simple strings
        $helperName = class_exists($helper) ? $helper : 'App\\Helpers\\' . $helper;

        // Generate the file path based on the normalized helper name
        $filePath = __DIR__ . '/../' . str_replace('\\', '/', $helperName) . '.php';

        if (!isset($this->loadedEntities[$helperName]) && file_exists($filePath)) {
            require_once $filePath;
            $this->loadedEntities[$helperName] = $this->container->get($helperName);
        }

    }



}
