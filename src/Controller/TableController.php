<?php
    namespace App\Controller;

    class TableController {

        public $data;

        public function __construct()
        {
            $this->data =  (new CalculadoraController())->index();

        }

        public function index() {
            return $this->data;
        }

    }