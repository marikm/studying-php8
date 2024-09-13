<?php
    namespace App\Controller;

    use App\Model\TableModel;

    class TableController {

        public $data;

        public function __construct()
        {
            session_start();
            if(!isset($SESSION['autenticado']) || !$_SESSION['autenticado'] == true) {
                header("Location: home");
                die();
            }
            $this->data = (new TableModel())->getData();

        }

        public function index() {
            return $this->data;
        }

    }