<?php
    session_start();

    $is_login = false;

    var_dump($is_login == 0);
    var_dump($is_login === 0);

    $usernames = [
      "admin",
      "dalgona",
      "parg29",
      "matchalover",
      "aseng",
      "subwayodading"
    ];

    $passwords = [
        "admin",
        "tidakbikinkembung",
        "supershy",
        "greentea",
        "sepuh",
        "$ugwey"
    ];

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        // var_dump($username);
        // var_dump($password);

        for ($i = 0; $i < count($usernames); $i++) {
            if ($username === $usernames[$i] && $password === $passwords[$i]) {
                $is_login = true;
                break;
            }
        }

        if ($is_login) {
           $_SESSION["success_message"] = "Welcome, $username";

           $_SESSION['is_login'] = true;
           $_SESSION['username'] = $username;

           header("Location: ../messages.php");

        }
        else {
            $_SESSION["error_message"] = "Login Failed.";


            header("Location: ../login.php");
        }

    }
