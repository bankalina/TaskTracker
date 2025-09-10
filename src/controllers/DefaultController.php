<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tasks");
            exit();
        } else {
            $this->render('login');
        }
    }
}