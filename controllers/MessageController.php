<?php

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['send'])) {
            $title = $_POST['title'];
            $recipient = $_POST['recipient'];
            $message = $_POST['message'];
            $user_attachment = $_FILES['user_attachment'];

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