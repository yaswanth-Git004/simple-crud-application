<?php 
    try {
        $DSN = 'mysql:host=localhost;dbname=blog';
        $conn = new PDO($DSN, "root", "");
    } catch (Exception $e) {
        echo "Exception is :: ".$e;
    }
?>