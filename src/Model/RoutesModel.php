<?php

namespace App\Model;

class RoutesModel {

    public function getRoutes() {
        return json_decode(file_get_contents(__DIR__.'/JsonFiles/Routes.json'), true);
    }
}