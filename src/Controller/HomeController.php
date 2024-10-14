<?php
    namespace App\Controller;
    

use App\Db\Db;
use App\Model\UserModel;

    class HomeController {
        // efetuar login
        public $db;

        public $data;
        public $nome;

        public function __construct()
        {
            session_start();
            $this->data = [
                'title' => 'Pagina Inicial',
                'message' => 'Seja bem-vindo ao site Liberdade Financeira',
            ]; 

            $this->db = new Db();

        }

        public function index() {
            if(!isset( $_SESSION['logged'])){
                $_SESSION['logged'] = false;
            }
            
            if($_SESSION['logged'] == true) {
                $this->data['greeting'] = "Bem vindo(a) " . $_SESSION['name'];
            }
            $this->data['logged'] = $_SESSION['logged'];
            // var_dump($this->data['logged']);

            return $this->data;
        }

    }