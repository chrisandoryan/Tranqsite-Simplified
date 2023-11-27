<?php
    session_start();
    require "./connection.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // without prepared statement
        // $query = "SELECT * FROM users WHERE username='$username' AND password='$password';";

        // with prepared statement
        $query = "SELECT * FROM users WHERE username=? AND password=?;";
        $statement = $db->prepare($query);
        $statement->bind_param("ss", $username, $password);
        // s - string
        // i - integer
        // b - blob
        // d - double
        
        // without prepared statement
        // $result = $db->query($query);

        // with prepared statement
        $statement->execute();
        $result = $statement->get_result();

        $db->close();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            $_SESSION["success_message"] = "Login Success";
            $_SESSION["id"] = $row['id'];
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
