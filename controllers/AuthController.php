<?php
    session_start();
    require_once('./connection.php');

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        // Handle POST request

        if (isset($_POST['username']) && isset($_POST['password'])) {
            // User wants to login
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password';";

            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                // Data valid
                $row = $result->fetch_assoc();
                
                $_SESSION['is_login'] = true;
                $_SESSION['full_name'] = $row['fullname'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];

                header('Location: ../messages.php');
            }
            else {
                // Data tidak valid
                var_dump("Username or password is invalid.");
                die;
            }







        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === "GET") {
        // Handle GET request
    }

