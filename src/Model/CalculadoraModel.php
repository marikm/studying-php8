<?php
    namespace App\Model;

use App\Controller\CalculadoraController;
use App\Db\Db;

    class CalculadoraModel {

        protected $db;
        public function __construct()
        {
            $this->db = new Db();
        
        }

        public function fieldsCalculadora(array $data) : array {
            $columns = array();
            $values = array();

            foreach ($data as $column => $value) {
                array_push($columns, $column);
                array_push($values, $value);
            }
           
            
            return [$columns, $values];
        }

        public function columnsAndValuesTableToString(array $data) : array {

            $columns = $this->fieldsCalculadora($data)[0];
            $values = $this->fieldsCalculadora($data)[1];

            $fields = "";
            $results = "";

            for($i = 2; $i < sizeof($columns)-1; $i++) {
                $fields .= $columns[$i] . ',';
            }
            
            $fields .= $columns[sizeof($columns) -1];

            for($i = 2; $i < sizeof($values)-1; $i++) {
                $results .= $values[$i] . ',';
            }
            $results .= $values[sizeof($values) -1];

            return [$fields, $results];
        }

        public function insertCalculadoraResults(array $data) {
            
            $fields = $this->columnsAndValuesTableToString($data)[0];
            $results = $this->columnsAndValuesTableToString($data)[1];

            $this->db->insert($fields, $results ,"calculadora");
           
        }
    }
