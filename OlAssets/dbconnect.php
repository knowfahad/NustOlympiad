<?php
    $servername = "localhost";
    $dbusername = "root";
    $password_db = "";
    $dbname = "olympiad";

    $conn = new mysqli($servername, $dbusername, $password_db, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    $mpdo = new PDO("mysql:host=localhost;port=3306;dbname=$dbname", $dbusername, $password_db);
    $mpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mpdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>
