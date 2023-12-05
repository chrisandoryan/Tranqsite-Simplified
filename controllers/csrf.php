<?php
    session_start();
    function generateCsrfToken() {
        $token = sha1(uniqid());
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $token;
        }
    }

    function verifyCsrfToken($token) {
        if (isset($token)) {
            return hash_equals($_SESSION['csrf_token'], $token);
        }
        return false;
    }