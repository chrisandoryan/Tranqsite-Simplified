<?php
    session_start();
    require("./connection.php");
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    function checkInputLength($string, $max_length) {
        if (empty($string) || $string == "" || strlen($string) > $max_length) {
            return false;
        }
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST['title'];
        $recipient = $_POST['recipient'];
        $message = $_POST['message'];
        $sender_id = $_SESSION['id'];

        // TODO: sanitize and validate $title input 
        // Assigned to: Group 1
        // title must not be empty
        // title < 20 chars
        // title must be robust against xss and html injection. any html tags must be stripped.

        // TODO: validate and sanitize $message input
        // Assigned to: Group 2

        // message < 100
        // message cannot be empty
        // message > 5 words
        // message must be robust against xss and html injection. any html tags must be escaped.

        // TODO: sanitize and validate $recipient input
        // Assigned to: Group 3

        // recipient must not be empty
        // recipient must be between 1 - 4 (inclusive)
        // recipient must be a digit

        // TODO: validate and sanitize file input
        // Assigned to: Group 4 & Group 5
        
        // file extension must be: .pdf, .jpeg, .docx, .txt, .xlsx, .csv, .png, .mp3, .mp4, .pptx, .mkv
        // file size <= 25MB
        // file size > 0
        // file name length < 50
        // file name must not contain path element (./, ../, etc.)
        

        $attachment = $_FILES['user_file'];

        $fileinfo = pathinfo($attachment['name']);
        $filename = $fileinfo['filename'];

        $target_directory = "../storage/";
        $new_file_path = $target_directory . $filename;
        
        if (move_uploaded_file($attachment['tmp_name'],$new_file_path)) {
            echo "File uploaded successfully!";
        }
        else {
            echo "File upload failed miserably.";
        }

        $query = "insert into communications(title,recipient_id,message,
        attachment,sender_id) values('$title','$recipient','$message',
        '$new_file_path','$sender_id')";

        $result = $db->query($query);
        $db->close();

    }


?>