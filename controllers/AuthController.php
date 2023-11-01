<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    require "./connection.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username=? AND password=?;";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        // s -> string
        // i -> integer
        // d -> double
        // b -> blob

        $stmt->execute();
        $result = $stmt->get_result();

        // $result = $db->query($query);
        
        $db->close();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            $_SESSION["success_message"] = "Login Success";
            $_SESSION["id"] = $row['id'];
            $_SESSION['is_login'] = true;
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
