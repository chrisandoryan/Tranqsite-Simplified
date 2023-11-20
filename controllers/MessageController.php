<?php
    session_start();
    require("./connection.php");
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    function checkLength($string, $max_length) {
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
        // length < 32
        // cannot be empty
        // must be robust against xss & html injection

        // TODO: sanitize and validate $message input
        // length < 255
        // cannot be empty
        // must be robust against xss & html injection
        // word count >= 5
        // cannot contain swear words

        // TODO: sanitize and validate $recipient input
        // recipient must be between 1 to 4 (inclusive)
        // recipient must be a digit
        // (optional) if recipient is exists on the database

        // TODO: sanitize and validate $attachment file
        // extension must be: .pdf, .png, .jpeg, .docx, .xlsx, .mp4, .zip, .7z, .txt, .rar, .pptx
        // size must be < 10MB
        // size must be > 0B
        // filename must be randomized
        // filename must not contain path 
        // filename must not contain certain special character (., /, \)

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