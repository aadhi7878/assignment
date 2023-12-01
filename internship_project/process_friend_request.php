<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JavaScript variables from the AJAX request
    $fromUser = $_POST['fromUser'];
    $toUser = $_POST['toUser'];

   include "./database.php";
    // SQL query to insert data into the friend_requests table
    $sql = "INSERT INTO friend_requests (user, requestedTo) VALUES ('$fromUser', '$toUser')";

    if ($conn->query($sql) === TRUE) {
        echo "Friend request stored successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
