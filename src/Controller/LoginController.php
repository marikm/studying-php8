<?php
    namespace App\Controller;

use App\Db\Db;
use App\Model\UserModel;

    class LoginController {
        // efetuar login
        public $db;

        public $data;
        public $nome;

        public function __construct()
        {
            session_start();
            $this->data = [
                'title' => 'Pagina de Login ',
                'message' => 'Por favor faça seu login',
            ];
            $this->db = new Db();
        }

        public function index() {

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                // setar apenas as variaveis baseadas no metodo post na construcao do controller
                if(isset($_POST['name']) && isset($_POST['pass'])) {
                    $login = new UserModel();
                    $name = (string)$_POST['name'];
                    $pass = (string)$_POST['pass'];
                    
                    if(!$login->checkUserExists($name, $this->db) || !$login->checkPassword($name,$pass,$this->db)) {
                        $this->data['logged'] = false;
                        $this->data['error'] = $login->getErrorMessage($name, $pass, $this->db);
                        return $this->data;
                    }
                    
                    $email = $login->getUserNameEmail($this->db, $name)['email'];
                    $session = new SessionController();
                    $session->setLogged($name, $email);
                    
                    $this->data = [
                        'name' => $_SESSION['name'],
                        'email' => $_SESSION['email'],
                        'logged' => true,
                    ];
                }
                return $this->data;
            }
        }

    }
