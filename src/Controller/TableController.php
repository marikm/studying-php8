<?php
    namespace App\Controller;

use App\Model\TableModel;

    class TableController {

        public $data;

        public function __construct()
        {
            $this->data = (new TableModel())->getData();

        }

        public function index() {
            return $this->data;
        }

    }