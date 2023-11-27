<?php
    session_start();

    function generateCsrfToken() {
        $token = sha1(uniqid());
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $token;
        }
        return $token;
    }

    function verifyCsrfToken() {
        // TODO: implement csrf token mechanism
        // Assigned to Group 4
    }