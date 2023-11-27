<?php
    session_start();

    function generateCsrfToken() {
        $token = sha1(uniqid());
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $token;
        }
        
        return $token;
    }

    function validateCsrfToken($csrf_token) {
        if ($_SESSION['csrf_token'] === $csrf_token) {
            return true;
        }
        return false;
    }

