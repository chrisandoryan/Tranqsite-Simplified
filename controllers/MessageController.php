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
        $prohibited = false;
        // TODO: sanitize and validate $title input
        // Assigned to: Group 1

        // length < 32
        // cannot be empty
        // must be robust against xss & html injection

        if(strlen($title)>=32){
            $error_message = "Title length too long! must be less than 32 chars!";  
            echo $error_message;
        }
        $trimmed_title = trim($title);
        if (empty($title) || $title == '' || empty($trimmed_title)) {
            $error_message = "Title cannot be empty!";
            echo $error_message;
        }

        $chars = ['kasar', 'bjir', 'gemink', '"', '\'', '/'];
        $escaped = ['&amp;', '&lt;', '&gt;', '&quot;', '&#x27;', '&#x2f;'];

        for ($i=0; $i < count($chars); $i++) { 
            if (str_contains($title, $chars[$i])) {
                $title = str_replace($chars[$i], $escaped[$i], $title);
            }
        }
        echo $title;
        die();

        // TODO: sanitize and validate $message input
        // Assigned to: Group 11

        // length < 255
        if(strlen($message)>255){
            $_SESSION['error'] = 'Message length may not be longer than 255';
            $prohibited = true;
        }

        // cannot be empty
        if(empty($message)){
            $_SESSION['error']="Message should not be empty!";
            $prohibited = true;
        }
        // must be robust against xss & html injection
        $message = htmlspecialchars($message);
        // word count >= 5
        $wordcountmessage = explode(" ",$message);
        if(count($wordcountmessage)<5){
            $_SESSION["error"] = "Message length atleast must be more than 5 word";
            $prohibited = true;
        }
        // cannot contain swear words (f*, b*, s*, mony*)
        $kasar = explode(" ", $message);
        $messagelow = strtolower($message);
        $katakasar = array('dasar');
        if(strpos($messagelow,$katakasar[0]!== false){
            $_SESSION['error']="mengandung kata kasar!";
            $prohibited = true;
        });

        // TODO: sanitize and validate $recipient input
        // Assigned to: Group 2
        if($recipient < 1 || $recipient > 4 || !is_numeric($recipient) {
            echo "Recipient Unavailable";
            return;
        })
        // recipient must be between 1 to 4 (inclusive)
        // recipient must be a digit
        // (optional) if recipient is exists on the database


        // TODO: sanitize and validate $attachment file
        // Assigned to: Group 10 & Group 3

        // extension must be: .pdf, .png, .jpeg, .docx, .xlsx, .mp4, .zip, .7z, .txt, .rar, .pptx 10
        // size must be < 10MB 3
        // size must be > 0B 10
        // filename must be randomized 10
        // filename must not contain path 3
        // filename must not contain certain special character (., /, \) 10



        if($prohibited){
            header("location: ../send.php ");
            die;
        }
        $attachment = $_FILES['user_file'];

        $fileinfo = pathinfo($attachment['name']);
        $filename = $fileinfo['filename'];
        $fileExtension = strtolower($fileinfo['extension']);
        
        $maxsize = 10 * 1024 * 1024;
        if($attachment['size'] > $maxsize || $attachment['size'] <= 0){
            echo "filenya kegedean atau kekecilan";
            header("Location: ../send.php");
            exit;
        }

        //validate file
        $allowed_extension = array("jpeg", "pdf", "png", "docx", "xlsx", "mp4", "zip", "7z", "txt", "rar", "pptx");

        if(!in_array($fileExtension, $allowed_extension)){
            echo "Invalid Extension";
        }

        // randomize
        $filename = uniqid().'_'. basename($filename);
        if(preg_match('/[\/\\\\]+/', $filename) || substr_count($filename, '.') != 1){
            echo "ada special character dan titik lebih dari satu";
            exit;

        }


        // contain path


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