<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController 
{
    public function login()
    {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        // Start session and store user ID
        session_start();
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail();
        $_SESSION['user_username'] = $user->getUsername();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/tasks");
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

            // TODO: Add user to database
            return $this->render('login', ['messages' => ['Account created successfully! Please log in.']]);
        }

        return $this->render('createAccount');
    }

    public function logout() {
        session_start();
        session_destroy();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
    }
}