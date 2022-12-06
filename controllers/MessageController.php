<?php
    require_once('connection.php');
    session_start();
    $recipient_options = ["1", "2", "3", "4"];

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $title = $_POST['title'];
        $recipient_id = $_POST['recipient'];
        $message = $_POST['message'];

        $has_error = false;

        // validation: title should not be empty, length of the title should be between 5 and 32 chars
        if ($title == "") {
            $_SESSION['error'][] = "Title should not be empty!";
            $has_error = true;
        }
        else if (strlen($title) < 5 || strlen($title) > 32) {
            $_SESSION['error'][] = "Title length should be between 5 and 32 characters";
            $has_error = true;
        }

        // validation: recipient_id should be between 1-4
        // if ($recipient_id != 1 || $recipient_id != 2 || $recipient_id != 3 || $recipient_id != 4) {
        //     $_SESSION['error'][] = "Please pick a valid recipient!";
        // }
        if (!in_array((string)$recipient_id, $recipient_options)) {
            $_SESSION['error'][] = "Please pick a valid recipient!";
            $has_error = true;
        }

        // validation: message should not be empty, length of the message should be between 5-256 chars
        if ($message == "") {
            $_SESSION['error'][] = "Message should not be empty!";
            $has_error = true;
        }
        else if (strlen($message) < 5 || strlen($message) > 256) {
            $_SESSION['error'][] = "Message length should be between 5 and 256 characters";
            $has_error = true;
        }

        if ($has_error) {
            header("Location: ../send.php");
            die;
        }
        else {
            $user_id = $_SESSION['user_id'];
            
            // (`id`, `sender_id`, `recipient_id`, `title`, `message`, `send_at`)
            $query = "INSERT INTO communications VALUES(NULL, $user_id, $recipient_id, '$title', '$message');";
            if ($connection->query($sql) === TRUE) {
                $_SESSION['success'][] = "Message has been sent!";
            } else {
                $_SESSION['error'][] = "Error: " . $sql . " | " . $conn->error;
            }
            
            header("Location: ../send.php");
            $connection->close();
        }
    }