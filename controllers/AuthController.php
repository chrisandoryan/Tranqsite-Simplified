<?php
    session_start();
    require "./connection.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password';";

        $result = $db->query($query);
        $db->close();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            $_SESSION["success_message"] = "Login Success";

            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['fullname'] = $row['fullname'];

            header("Location: ../messages.php");
        }
        else {
            $_SESSION["error_message"] = "Login Failed";

            header("Location: ../login.php");
        }

    }
