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

        if (!isset($title)){ //gunanya agar tidak empty, soalnya kalo empty bakal dikasi echo itu ngasitau
            echo "Title must not be empty";
            //kasi semacam break disini biar ga jalan
        }
        if (strlen($title) > 20){ //strlen buat baca jumlah character dari $title
            echo "Title must not exceed 20 characters";
            //kasi semacam break disini biar ga jalan
        }
        $safeTitle = trim($title);
        //buat ngilangin spasi atau whitespace di akhir dan di awal

        $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $safeTitle = strip_tags($safeTitle);
        //$safeTitle menggantikan $title, sebenernya bisa sih dipake $title lagi tapi ini untuk memperjelas saja

        //mungkin bawahnya ditambahkan prep statement agar lebih aman lagi
        
        // TODO: validate and sanitize $message input
        // Assigned to: Group 2

        if(isset($message))
        {
            $sanitize = mysqli_real_escape_string($db,$message);
            $message = htmlspecialchars($sanitize);
            if(!checkInputLength($message, 100))
            {
                echo"Tidak memenuhi syarat";
            }
                $string  = preg_replace("/\\s+/", " ", $message);

                //trim off beginning and end spaces;
                $string = trim($string);

                //get an array of the words
                $wordArray = explode(" ", $string);
                
                //get the word count
                $wordCount = sizeof($wordArray);

                //see if its too big
                if($wordCount < 5) echo "Please make a longer string";
        }

        // message < 100
        // message cannot be empty
        // message > 5 words
        // message must be robust against xss and html injection. any html tags must be escaped.

        // TODO: sanitize and validate $recipient input
        // Assigned to: Group 3

        // recipient must not be empty
        if(!isset($recipient)){
            echo "recipient must not be empty";
        }
        else{
            $recipient = strip_tags($recipient);
            $recipient = htmlspecialchars($recipient, ENT_QUOTES, 'UTF-8'); 
        }

        // recipient must be a digit

        $regex = '/[0-9]/';
        
        if(!preg_match($regex, $recipient)){ //is_numeric

            echo" recipient must be a digit";
        }

        // recipient must be between 1 - 4 (inclusive)
        $array = [1,2,3,4];
        if(!in_array($recipient, $array)){
            echo "recipient must be between 1 - 4 (inclusive)";
        }

        // TODO: validate and sanitize file input
        // Assigned to: Group 4 & Group 5
        
        // file extension must be: .pdf, .jpeg, .docx, .txt, .xlsx, .csv, .png, .mp3, .mp4, .pptx, .mkv 4
        // file size <= 25MB 5
        // file size > 0 5
        // file name length < 50 4
        // file name must not contain path element (./, ../, etc.) 5

        $attachment = $_FILES['user_file'];
        $fileinfo = pathinfo($attachment['name']);
        $filename = trim($fileinfo['filename']);
        $filesize = $attachment['size'];

        if(!$filesize < 1 || !$filesize > 25000000){
            $extension = $fileinfo['extension'];
            $allowed_extension = ['pdf', 'jpeg', 'docx', 'txt', 'xlsx', 'csv', 'png', 'mp3', 'mp4', 'pptx', 'mkv'];

            if(!in_array(strtolower($extension), $allowed_extension)){
                echo "Invalid Extension File";
                exit();
            }

            $allowedname = '/^[a-zA-Z0-9_ ]+$/';
            if(!preg_match($allowedname,$filename)){
                echo "File name can only alphabet, number, space and underscore";
            }

            // TODO: implement csrf token validation
            // Assigned to: Group 6 & 7

            if(strlen($filename) > 50){
                echo "File name should not be more than 50 characters";
                exit();
            }


        }

        $target_directory = "../storage/";
        $new_file_path = $target_directory . $filename;
        
        if (move_uploaded_file($attachment['tmp_name'],$new_file_path)) {
            echo "File uploaded successfully!";
        }
        else {
            echo "File upload failed miserably.";
        }

        $query = "insert into communications(title,recipient_id,message,
        attachment,sender_id) values('$safeTitle','$recipient','$message',
        '$new_file_path','$sender_id')";

        $result = $db->query($query);
        $db->close();

    }


?>