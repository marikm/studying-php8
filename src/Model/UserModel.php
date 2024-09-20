<?php
    namespace App\Model;

    use App\Db\Db;
    use TypeError;

    class UserModel {

        public function __construct() {
            
        }

        
        public function addQuotes($b) {
            return "'".$b."'";
        }
        
        public function insertUser(array $data, Db $db) {
            $fields = "nome,email,senha";
            $arrayWithQuotes = array_map(array($this,'addQuotes'), $data);
            $values = implode(",", $arrayWithQuotes);
            
            $db->insert($fields, $values, "usuarios");
        }

        public function checkUserExists(string $nome, Db $db) : bool {
            try {
                if (is_array($db->getOneUser($nome, "usuarios"))){
                    return true;
                }  
            } 
            catch (TypeError $e) {
                return false;
            }
        
        }

        public function checkPassword(string $nome, string $senha, Db $db) : bool {
            $userData = $db->getOneUser($nome, "usuarios");
            $senhaDb = $userData['senha'];
            if(md5($senha) == $senhaDb){
                return true;
            }
            return false;
        }
        
        public function getErrorMessage(string $nome, string $senha, Db $db) : string {
            $userVerify = $this->checkUserExists($nome, $db);
            if(!$userVerify) {
                return "Usuario não cadastrado";
            }

            $passVerify = $this->checkPassword($nome, $senha, $db);
            if(!$passVerify){
                return "Senha incorreta.";  
            }      
        }
        
        public function getUserNameEmail($db, $nome) : array {
            $userData = $db->getOneUser($nome, "usuarios");
            $userData = ['nome'=> $userData['nome'], 'email' => $userData['email']];
            
            return $userData;
        }
    }