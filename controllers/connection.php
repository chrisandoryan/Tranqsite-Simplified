<?php
    require_once(__DIR__ . '/../config/database.php');
    
    $db = new mysqli(
        $config["server"],
        $config["username"],
        $config["password"],
        $config["database"]
    );
