<?php
    namespace App\Model;

use App\Db\Db;

    class TableModel {

        protected $db;
        protected $data;

        public function __construct()
        {
            $this->db = new Db();
        }

        public function getData() {
            $this->data = $this->db->getTable('calculadora');

            return $this->data;
        }

    }