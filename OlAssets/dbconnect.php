<?php
    $servername = "localhost";
    $dbusername = "homestead";
    $password_db = "secret";
    $dbname = "olympiad";

    $conn = new mysqli($servername, $dbusername, $password_db, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }



?>
