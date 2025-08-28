<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController 
{
    public function login()
    {
        # docelowo bedziemy pobierac uzytkownikow z bazy
        $user = new User("jsnow@pk.edu.pl", 'admin', 'John', 'Snow');

        if($this->isPost()) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            if ($user->getEmail() !== $email) {
                return $this->render('login', ['messages' => ['User with this email doesnt exist!!!']]);
            }

            if ($user->getPassword() !== $password) {
                return $this->render('login', ['messages' => ['Wrong password!']]);
            }

            return $this->render('tasks');
        }

        return $this->render('login');
    }

    public function createAccount()
    {
        if($this->isPost()) {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirmPassword"];

            // Podstawowa walidacja
            if (empty($fullname) || empty($email) || empty($password)) {
                return $this->render('createAccount', ['messages' => ['All fields are required!']]);
            }

            if ($password !== $confirmPassword) {
                return $this->render('createAccount', ['messages' => ['Passwords do not match!']]);
            }

            if (strlen($password) < 6) {
                return $this->render('createAccount', ['messages' => ['Password must be at least 6 characters long!']]);
            }

            // Tutaj docelowo będzie zapis do bazy danych
            // Na razie przekierowujemy na stronę logowania z komunikatem o sukcesie
            return $this->render('login', ['messages' => ['Account created successfully! Please log in.']]);
        }

        return $this->render('createAccount');
    }
}