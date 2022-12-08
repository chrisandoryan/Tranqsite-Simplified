<?php
    session_start();
    require_once("connection.php");

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['send_message'])) {
            // user wants to create a new message
            $title = $_POST['title'];
            $recipient_id = $_POST['recipient'];
            $message = $_POST['message'];

            $recipient_options = ["1", "2", "3", "4", "99", "12"];
            $has_error = false;

            // validation sequences
            // validation: title should not be empty and title length should be between 4 and 64 characters
            if (empty($title)) {
                $_SESSION['error'] = "Title should not be empty!";
                $has_error = true;
            }
            else if (strlen($title) < 4 || strlen($title) > 64) {
                $_SESSION['error'] = "Title length should be between 4 and 64 characters";
                $has_error = true;
            }

            // validation: recipient_id should be either 1, 2, 3, 99, 12, 32, 5
            if (!in_array($recipient_id, $recipient_options)) {
                $_SESSION['error'] = "Please input a valid recipient!";
                $has_error = true;
            }

            // or, alternatively:
            // if ($recipient_id != "1" && $recipient_id != "2" && $recipient_id != "3" && $recipient_id != "4") {
            //     $_SESSION['error'] = "Please input a valid recipient!";
            // }

            // validation: message should not be empty and message should be between 4 and 512 characters
            if (empty($message)) {
                $_SESSION['error'] = "Message should not be empty!";
                $has_error = true;
            }
            else if (strlen($message) < 4 || strlen($message) > 512) {
                $_SESSION['error'] = "Message length should be between 4 and 512 characters";
                $has_error = true;
            }

            if ($has_error) {
                header("Location: ../send.php");
                die;
            }

            // continue with data insertion
            // (`id`, `sender_id`, `recipient_id`, `title`, `message`, `send_at`)
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO communications VALUES(NULL, $user_id, $recipient_id, '$title', '$message', NOW());";

            $result = $connection->query($query);
            header("Location: ../send.php");
            
        }
        else if (isset($_POST['update_message'])) {
            // user wants to update a message
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === "GET") {

    }