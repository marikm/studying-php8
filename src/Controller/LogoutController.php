<?php
    namespace App\Controller;

    class LogoutController {

        public $logout;

        public function index() {
            $this->logout = new SessionController();
            $this->logout->logout();
            
        }
    }