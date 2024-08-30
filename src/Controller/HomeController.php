<?php
    namespace App\Controller;

    class HomeController {

        public $data;

        public function __construct()
        {
            $this->data = [
                'title' => 'Pagina Inicial',
                'message' => 'Seja bem-vindo ao site Liberdade Financeira',
            ];
        }

        public function index() {
            return $this->data;
        }

    }