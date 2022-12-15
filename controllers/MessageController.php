<?php
    session_start();
    require_once(__DIR__ . '/connection.php');

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['send_message'])) {
            // handle user wants to send message
            $title = $_POST['title'];
            $recipient_id = $_POST['recipient'];
            $message = $_POST['message'];

            $recipient_options = ["1", "2", "3", "4"];
            $has_error = false;

            // validation: title should not be empty, title length should be between 4 and 64
            if ($title === "") {
                $_SESSION['error'][] = "Title should not be empty!";
                
                // or, alternatively:
                // array_push($_SESSION['error'], "Title should not be empty!");

                $has_error = true;
            }
            else if (strlen($title) < 4 || strlen($title) > 64) {
                $_SESSION['error'][] = "Title length should be between 4 and 64 characters long";
                $has_error = true;
            }

            // validation: recipient_id should be either 1, 2, 3, or 4
            // if ($recipient_id != "1" && $recipient_id != "2" && $recipient_id != 3 && $recipient_id != "4") {
            //     $_SESSION['error'] = "Please enter a valid recipient!";
            // }
            if (!in_array($recipient_id, $recipient_options)) {
                $_SESSION['error'][] = "Please enter a valid recipient!";
                $has_error = true;
            }

            // validation: message should not be empty, message length should be between 4 and 512
            if ($message === "") {
                $_SESSION['error'][] = "Message should not be empty!";
                $has_error = true;
            }
            else if (strlen($message) < 4 || strlen($message) > 512) {
                $_SESSION['error'][] = "Message length should be between 4 and 512 characters long";
                $has_error = true;
            }

            if ($has_error) {
                header("Location: ../send.php");
                die;
            }

            // code runs here
            // (`id`, `sender_id`, `recipient_id`, `title`, `message`, `send_at`)
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO communications VALUES(NULL, $user_id, $recipient_id, '$title', '$message', NOW());";

            $connection->query($query);

            header("Location: ../send.php");

        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === "GET") {

    }