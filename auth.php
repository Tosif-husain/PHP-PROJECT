<?php
session_start(); 

function getDatabaseConnection() {
    try {
        $db = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}

function loginUser($username, $password) {
    $db = getDatabaseConnection(); 

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'] 
            ];
            return $user; 
        }
        
        return false; 
    } catch (PDOException $e) {
        
        die("Database query failed: " . $e->getMessage());
    }
}
