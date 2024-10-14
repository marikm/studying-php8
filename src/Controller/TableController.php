<?php
    namespace App\Controller;

    use App\Model\TableModel;
    use App\Controller\SessionController;

    class TableController {

        public $data;
      
        public function index() {
            $session = new SessionController();
            $this->data['logged'] = $session->getLogged();
            
            if (!$this->data['logged']) {
                header('Location: /home');
                exit();
            }
            
            $this->data = [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'logged' => $session->getLogged(),
                'table' =>  (new TableModel())->getData()
            ];
            
          
            return $this->data;
        }

    }