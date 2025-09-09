<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            // User is logged in, redirect to tasks
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tasks");
            exit();
        } else {
            // User is not logged in, show login page
            $this->render('login');
        }
    }
}