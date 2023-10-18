<?php
    session_start();
    require "./connection.php";

    function doLogin($username, $password) {
        global $conn;

        // ini cara yang unsafe.
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password';";

        $result = $conn->query($query);

        return $result;
    }


    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_result = doLogin($username, $password);

        if ($login_result->num_rows == 1) {
            $data = $login_result->fetch_assoc();

           $_SESSION["success_message"] = "Welcome, $username";

           $_SESSION['is_login'] = true;
           $_SESSION['username'] = $data["username"];
           $_SESSION["role"] = $data["role"];
           $_SESSION["fullname"] = $data["fullname"];



           header("Location: ../messages.php");

        }
        else {
            $_SESSION["error_message"] = "Login Failed.";

            header("Location: ../login.php?error=1");
        }

    }
