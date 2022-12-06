<?php
    require_once('connection.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'][] = "Please enter a valid email address!";
                header('Location: ../login.php');
                die;
            }
            $password = $_POST['password'];
    
            $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
            $result = $connection->query($query);
            $connection->close();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['is_login'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
    
                header('Location: ../messages.php');
            }
            else {
                $_SESSION['error'][] = "Incorrect username or password, please check your input.";
                header('Location: ../login.php');
                die;
            }
        }
        else {
            $_SESSION['error'][] = "Unknown operation.";
            header('Location: ../login.php');
            die;
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET['logout'])) {
            unset($_SESSION);
            session_regenerate_id();
            header('Location: ../login.php');
        }
    }
