<?php
    $is_login = false;

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === "admin" && $password === "admin") {
            echo "Login Success";
        }
        else {
            echo "Login Failed";
        }

        

        

    }
