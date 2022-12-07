<?php
    session_start();
    require_once('connection.php');

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password';";
            
            $result = $connection->query($query);
            
            if ($result->num_rows > 0) {
                // Data ditemukan
                $row = $result->fetch_assoc();
                
                $full_name = $row['fullname'];
                $email = $row['email'];
                $username = $row['username'];
                
                $_SESSION['is_login'] = true;
                $_SESSION['fullname'] = $full_name;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id'];

                header('Location: ../messages.php');
            }
            else {
                // Data tidak ada
                var_dump("Username atau password salah coy.");
                die;
            }



        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === "GET") {

    }