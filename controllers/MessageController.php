<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST['title'];
        $recipient = $_POST['recipient'];
        $message = $_POST['message'];

        $attachment = $_FILES['user_file'];

        // TODO: validasi tipe file
        // TODO: simpen file nya di server

    }


?>