<?php
    namespace App\Model;

    class CalculatorModel {

        
        public function __construct()
        {
        
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

            for($i = 0; $i < sizeof($columns)-1; $i++) {
                $fields .= $columns[$i] . ',';
            }
            
            $fields .= $columns[sizeof($columns) -1];

            for($i = 0; $i < sizeof($values)-1; $i++) {
                $results .= $values[$i] . ',';
            }
            $results .= $values[sizeof($values) -1];

            return [$fields, $results];
        }

        public function insertCalculadoraResults(array $data, $db) {
            
            $fields = $this->columnsAndValuesTableToString($data)[0];
            $results = $this->columnsAndValuesTableToString($data)[1];
           
        }
    }
