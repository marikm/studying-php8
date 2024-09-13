<?php
    namespace App\Controller;
    use App\Db\Db;

    use App\Model\UserModel;

    class UserController {
        public $db;
        public $data;
        public $userModel;
        
        private $nome;
        private $email;
        private $senha;

        public function __construct() {
            $this->db = new Db();
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['nome'])) {
                    $this->nome = (string)$_POST['nome'];
                }
                if(isset($_POST['email'])) {
                    $this->email = (string)$_POST['email'];
                }
                if(isset($_POST['senha'])) {
                    $this->senha = md5((string)$_POST['senha']);
                }
            }
        }

        public function index() {
            $this->data = [
                'nome' => $this->nome,
                'email' => $this->email,
                'senha' => $this->senha,
            ];

            if(isset($_POST) and !empty($_POST)) {
                $this->userModel = (new UserModel())->insertUser($this->data, $this->db);
            }


            return $this->data;
        }
    }