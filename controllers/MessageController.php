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