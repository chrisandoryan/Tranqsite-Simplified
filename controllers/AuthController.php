<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === "admin" && $password === "admin") {
            echo "Login Success";
            
            $_SESSION['is_login'] = true;
            $_SESSION['username'] = $username;

            header("Location: ../messages.php");
        }
        else {
            echo "Login Failed";

            header("Location: ../login.php");
        }

        

        

    }
