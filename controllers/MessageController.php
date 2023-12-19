<?php
    
    function checkValueLength($string, $max_length) {
        if (empty($string) || $string == "" || $string == null || strlen($string) > $max_length) {
            return false;
        }

        return true;
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['send'])) {
            $title = $_POST['title'];
            $recipient = $_POST['recipient'];
            $message = $_POST['message'];
            $user_attachment = $_FILES['user_attachment'];

            // TODO: validate and sanitize $title input
            // title must not be empty
            // title length < 30 chars
            // title should be robust against xss and html injection
            // Group 1
            if(checkValueLength($title,30) == TRUE){
                $title = htmlspecialchars("$title", ENT_QUOTES);
            }
            else{
                echo "Wrong Title";
                return false;
            }

            // TODO: validate and sanitize $message input
            // message must not be empty
            // message must be robust against xss and html injection
            // message length < 200
            // message must be at least 5 words
            // message must not contain trailing spaces
            // Group 2
            if (!checkValueLength($message, 200)){
                echo "invalid message input";
            } 

            if (str_word_count($message) < 5) {
                
                echo "Message must at least 5 word!";
            }

            if (trim($message) !== $message) {
                echo "Message must not contain trailling space!";
            }
            if(!(ctype_digit($recipient)&& $recipient >= 1 && $recipient <=4)){
                echo "Invalid Recipient";
            }
            $recipient = intval($recipient);

            $message = htmlspecialchars($message);
            // TODO: validate and sanitize $recipient
            // recipient must be between 1-4 (inclusive)
            // recipient must be a digit
            // Group 2

            // TODO: validate and sanitize $attachment
            // file size < 25MB
            // file extension must be either: .png, .jpeg, .gif, .jpg, .pdf, .txt, .docx, .zip, .xlsx, .rar, .7z, .mp3, .mp4, .mkv, .mov
            // file size cannot be < 1B
            // file must be renamed into something random to prevent duplicate
            // file name must not contain path element (./, ../)
            // Group 4 & Group 5
            if(isset($_FILES['user_attachment'])){
                $file = $_FILES['user_attachment'];
                $allowedExtention = ['png','jpg','jpeg','gif','pdf','txt',
                'docx','zip','xlsx','rar','7z','mp3','mp4','mkv','mov'];
                
                $maxFileSize = 25 * 1024 * 1024 ;
                $minFileSize = 1;

                    if($file['size']>= $maxFileSize || $file['size'] < $minFileSize){
                        echo "invalid file size!!!!!!!";
                        exit;

                    }

                    $fileInfo = pathinfo($file['name']);
                    $fileExtention = strtolower($fileInfo['extension']);

                    if(!in_array($fileExtention,$allowedExtention)){
                        echo "error, invalid file type";
                    }
                    
            }
            

            $target_directory = "../storage/";
            // <random_code>_<filename>.<ext>
            // 123duq8_ktp.jpeg
            $new_file_name = uniqid() . "_" . $user_attachment['name'];

            echo $target_directory . $new_file_name;

            if (move_uploaded_file($user_attachment['tmp_name'], $target_directory . $new_file_name)) {
                echo "Upload Success!";
            }
            else {
                echo "Upload Failed.";
            }

            if ($user_attachment['size'] > 20 * 1000 * 1000) {
                echo "File is too big!";
                $_SESSION['error_message'] = "File is too big!";
            }

            // TODO: store message data to table 'communications'

            // TODO: display data into user's page
        }
        else if (isset($_POST['delete'])) {

        }
    }



?>