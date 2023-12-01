<?php
include "./database.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $username = $_SESSION["uname"];
    $update = $_POST["postContent"];

    $sqlInsert = "INSERT INTO updates (user, updates) VALUES ('$username', '$update')";
    $result = $conn->query($sqlInsert);

    
}
?>