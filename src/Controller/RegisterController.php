<?php
    namespace App\Controller;
    use App\Db\Db;

    use App\Model\UserModel;

    class RegisterController {
        public $db;
        public $data;
        public $userModel;
        
        private $name;
        private $email;
        private $pass;

        public function __construct() {
            $this->db = new Db();
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['name'])) {
                    $this->name = (string)$_POST['name'];
                }
                if(isset($_POST['email'])) {
                    $this->email = (string)$_POST['email'];
                }
                if(isset($_POST['pass'])) {
                    $this->pass = md5((string)$_POST['pass']);
                }
            }
        }

        public function index() {
            $this->data = [
                'name' => $this->name,
                'email' => $this->email,
                'pass' => $this->pass,
            ];

            if(isset($_POST) and !empty($_POST)) {
                $this->userModel = (new UserModel())->insertUser($this->data, $this->db);
            }


            return $this->data;
        }
    }