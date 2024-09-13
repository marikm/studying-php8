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
            $this->checkLogin();

        }

        public function checkLogin() {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                // setar apenas as variaveis baseadas no metodo post na construcao do controller
                if(isset($_POST['nome']) && isset($_POST['senha'])) {
                    $login = new UserModel();
                    $nome = (string)$_POST['nome'];
                    $senha = (string)$_POST['senha'];
                    $msg = $login->getNameOrErrorMessage($nome, $senha, $this->db);
                    
                    if(!$login->checkUserExists($nome, $this->db) || !$login->checkPassword($nome,$senha,$this->db)) {
                        $_SESSION['autenticado'] = false;
                        $this->data['error'] = $msg;
                        return $this->data['error']; 
                    }
                    
                    $_SESSION['nomeUsuario'] = $msg;
                    $_SESSION['autenticado'] = true;
                    $this->data['greeting'] = "Bem vindo(a) " . $_SESSION['nomeUsuario'];
                    return $this->data['greeting'];

                    
                }
                
            }
        }

        public function index() {
            return $this->data;
        }

    }