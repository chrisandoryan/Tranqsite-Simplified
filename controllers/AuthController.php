<?php
    session_start();
    require_once('./connection.php');

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        // Handle POST requests
        if (isset($_POST['username']) && isset($_POST['password'])) {
            // User wants to login.
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password';";

            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                // Username or password is valid.
                
                $row = $result->fetch_assoc();
                
                $_SESSION['is_login'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['full_name'] = $row['fullname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];

                header('Location: ../messages.php');
            }
            else {
                // Username or password is invalid.
                var_dump("Username/Password is invalid.");
            }







        }
        
    }
    else if ($_SERVER['REQUEST_METHOD'] === "GET") {
        // Handle GET requests
    }
