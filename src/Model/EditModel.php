<?php

    namespace App\Model;
    use App\Db\Db;

    class EditModel {

        protected Db $db;

        public function __construct() {
            $this->db = new Db();
        }

        public function getValuesFromId(int $id) {
           return $this->db->getOne($id, 'calculadora');
        }        
    }