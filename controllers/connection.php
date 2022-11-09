<?php
    require_once('../config/database.php');

    $connection = new mysqli(
        $config['server'],
        $config['username'],
        $config['password'],
        $config['database']
    );
