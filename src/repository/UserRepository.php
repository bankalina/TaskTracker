<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['password'],
            $user['salt'] ?? null
        );
    }

    public function addUser(string $fullname, string $email, string $password): array
    {
        try {
            $salt = bin2hex(random_bytes(32));
            
            $hashedPassword = hash('sha256', $password . $salt);
            
            $stmt = $this->database->connect()->prepare('
                INSERT INTO public.users (username, email, password, salt, enabled) 
                VALUES (:username, :email, :password, :salt, :enabled)
            ');
            $stmt->bindParam(':username', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':salt', $salt, PDO::PARAM_STR);
            
            // Set enabled to 0 (false) by default
            $enabled = 0;
            $stmt->bindParam(':enabled', $enabled, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            
            if ($result) {
                return ['success' => true, 'message' => 'User created successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to execute database query'];
            }
            
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            error_log("Error adding user: " . $errorMessage);
            
            if (strpos($errorMessage, 'duplicate key') !== false || strpos($errorMessage, 'unique constraint') !== false) {
                return ['success' => false, 'message' => 'User with this email already exists'];
            } elseif (strpos($errorMessage, 'not null') !== false) {
                return ['success' => false, 'message' => 'Required fields are missing'];
            } elseif (strpos($errorMessage, 'connection') !== false) {
                return ['success' => false, 'message' => 'Database connection failed'];
            } else {
                return ['success' => false, 'message' => 'Database error: ' . $errorMessage];
            }
        }
    }
}