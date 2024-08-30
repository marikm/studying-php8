<?php

namespace App\Model;

use App\Db\Db;

class RoutesModel {

    protected $db;
    protected $routes;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getRoutes() {
        
        $this->routes = $this->db->getAll('routes');

        //return json_decode(file_get_contents(__DIR__.'/JsonFiles/Routes.json'), true);
        return $this->routes;
    }
}