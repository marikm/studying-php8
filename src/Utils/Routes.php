<?php

    namespace App\Utils;
    use App\Model\RoutesModel;

    class Routes {
        
        public $routes;
        public $route;
        public $controller;
        public $path;
        public $template;

        public function __construct()
        {
            $this->routes = (new RoutesModel())->getRoutes();
            $this->route = $this->getRoute();
            $this->path = $this->getPath($this->route);
            $this->controller = $this->getController($this->path);
            $this->template = $this->getTemplate($this->path);
        }


        public function getRoute() {
            $this->route = $_SERVER['REQUEST_URI'];
            return $this->route;
        }

        public function getPath($route) {
            $routeSplit = explode('/', $route);
            $pathRoute = $routeSplit[3];
            if(empty($pathRoute)) {
                return 'home';
            }
            $pathRoute = $this->clearRoute($pathRoute);
            
            return $this->checkIfPathExists($pathRoute);
        }

        public function clearRoute($route) {
            return preg_replace("/[^a-zA-Z0-9]+/", "", $route);
        }

        public function checkIfPathExists($route) {
            if(array_key_exists($route, $this->routes)) {
                return $this->routes[$route]['name'];
            }
            return $this->routes['error']['name'];
        }

        public function getController($path) {
            return $this->routes[$path]['controller'];
        }

        public function getTemplate($path) { 
            return $this->routes[$path]['template'];
        }

    }
    