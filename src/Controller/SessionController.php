<?php
    namespace App\Controller;
    use App\Db\Db;
    use App\Model\UserModel;

    class SessionController {
        

        public function __construct( ) {
            if (!isset($_SESSION)) {
                session_start();
            }
        }
        //setVariableSession -> metodo generico, recebe o nome do array e o valor que vai ser atribuido 
        public function setLogged($name, $email) : void {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['logged'] = true;
            header('Location: /');

        }

        public function logout() : void {
            $_SESSION['name'] = null;
            $_SESSION['email'] = null;
            $_SESSION['logged'] = false;
            header('Location: /');
        }

        public function getLogged(): bool {
            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                return true;
            }
            return false;
        }
    
    }