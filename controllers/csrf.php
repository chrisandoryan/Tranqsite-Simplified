<?php
    function generateCsrfToken() {
        $token = sha1(uniqid());
        $_SESSION['csrf_token'] = $token;
    }

    function verifyCsrfToken() {
        // group 6 & 7
        // verify csrf token when a post data is submitted
    }
