<?php
    namespace App\Controller;

    class ErrorController {

        public $data;

        public function __construct()
        {
            $this->data = [
                'title' => '404 not found',
                'message' => 'Página não encontrada',
            ];
        }

        public function index() {
            return $this->data;
        }

    }