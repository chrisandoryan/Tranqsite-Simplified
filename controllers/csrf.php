<?php
    sesssion_start();
    function generateCsrfToken() {
        $token = sha1(uniqid());
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $token;
        }
    }

    function verifyCsrfToken($token) {

    }