<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index() {
        $this->render('login');
    }

    public function tasks() {
        $this->render('tasks');
    }

    public function addTask() {
        $this->render('addTask');
    }

    public function taskDetails() {
        $this->render('taskDetails');
    }

    public function createAccount() {
        $this->render('createAccount');
    }
}