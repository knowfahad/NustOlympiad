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
    $mpdo = new PDO("mysql:host=localhost;port=3306;dbname=olympiad", $dbusername, $password_db);


?>
