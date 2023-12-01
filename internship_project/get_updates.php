<?php
session_start();
include "./database.php";


// Assuming your friends table has columns friend1 and friend2
$sessionUser = $_SESSION["uname"];

$sqlFriends = "SELECT friend1, friend2 FROM friends WHERE friend1 = '$sessionUser' OR friend2 = '$sessionUser'";
$resultFriends = $conn->query($sqlFriends);

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Updates from Friends</title>
</head>
<body>
  <div class="container mt-3">
    <h2 style="margin-top: 3rem";>Updates from Friends</h2>';
if($resultFriends->fetch_assoc()<1){
    echo'There is no updates from your friends';
}
$updatesFound = false;
while ($rowFriends = $resultFriends->fetch_assoc()) {
    global $friendWithNoUpdate;
    $friendUsername = ($rowFriends['friend1'] != $sessionUser) ? $rowFriends['friend1'] : $rowFriends['friend2'];

    $sql = "SELECT user, updates FROM updates WHERE user = '$friendUsername'";
    $result = $conn->query($sql);
    
    // Display data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uName = $row['user'];
        $updatesFound = true;
        echo '<div class="card mt-3">';
        echo '<div class="card-body">';
        echo "<h4 class='card-title'>$uName's update</h4>";
        echo "<p class='card-text'>$row[updates]</p>";
        echo '</div>';
        echo '</div>';
        echo '<br>';
     

    }
   
}
if (!$updatesFound) {
    echo '<p>There are no updates from your friends.</p>';
}

echo '
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';

$conn->close();
?>
