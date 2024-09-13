<?php
    namespace App\Controller;

use App\Model\EditModel;

    class EditVariablesController {
        public $data;
        public $id;

        public function __construct() {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $this->id = $_POST['idLinha'];
                $this->data = (new EditModel())->getValuesFromId($this->id);
                // echo '<pre>';
                // var_dump($this->data);
                // echo '</pre>';
                // die;
            }
        }
        
        public function index() {
            $this->data;
        }
    }
