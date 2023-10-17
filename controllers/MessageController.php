<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST['title'];
        $recipient = $_POST['recipient'];
        $message = $_POST['message'];

        $attachment = $_FILES['user_file'];

        // TODO: save message to database, into table communications.
        
    }


?>