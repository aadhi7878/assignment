<?php
include "./database.php";
// session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Navbar with Username, Friends, and Logout</title>
    <style>
        li>.friends{
            background-color:green;
        }
    </style>
</head>
<body>


<?php
include "./navbar.php";
?>
<div class="container mt-5"  >
    <div class="row">
        <div class="col">
            <!-- Content for the first column -->
            <div class="p-3">
               
                <p>
                <?php

$currentUsername = $_SESSION['uname'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friendUsername = $_POST['friendUsername'];
    $action = $_POST['action'];

    if ($action == 'accept') {
        // Accept friend request - insert into friends table
        $sqlCheckExistence = "SELECT * FROM friends WHERE (friend1 = '$currentUsername' AND friend2 = '$friendUsername') OR (friend1 = '$friendUsername' AND friend2 = '$currentUsername')";
        $resultExistence = $conn->query($sqlCheckExistence);

    if ($resultExistence->num_rows == 0) {
        $sqlInsert = "INSERT INTO friends (friend1, friend2) VALUES ('$currentUsername', '$friendUsername')";
        $conn->query($sqlInsert);
        $sqlDelete = "DELETE FROM friend_requests WHERE user = '$friendUsername' AND requestedTo = '$currentUsername'";
        $conn->query($sqlDelete);
        }
    } elseif ($action == 'reject') {
        // Reject friend request - delete from friend_requests table
        $sqlDelete = "DELETE FROM friend_requests WHERE user = '$friendUsername' AND requestedTo = '$currentUsername'";
        $conn->query($sqlDelete);
    }
}

$sql = "SELECT user FROM friend_requests WHERE requestedTo = '$currentUsername'";
$result = $conn->query($sql);

echo "<table >";
echo "<h2>Friend Requests</h2>";

while ($row = $result->fetch_assoc()) {
    $friendUsername = $row['user'];
    echo "<tr><td >$friendUsername</td>";
    echo "<td><form method='post'>";
    echo "<input  type='hidden' name='friendUsername' value='$friendUsername'>";
    echo "<button style='margin-right: 2rem;' style='margin-left: 2rem;'type='submit' name='action' value='accept'class='btn btn-primary btn-sm'>Accept</button>";
    echo "<button type='submit' name='action' value='reject'class='btn btn-primary btn-sm'>Reject</button>";
    echo "</form></td></tr>";
}

echo "</table>";

?>

                </p>
            </div>
        </div>
        <div class="col">
            <!-- Content for the second column -->
            <div class=" p-3">
                
                <p>
                <?php
                    
                    
                    $sql = "SELECT friend1, friend2 FROM friends WHERE friend1 = '$currentUsername' OR friend2 = '$currentUsername'";
                    $result = $conn->query($sql);
                    
                    echo "<table >";
                    echo "<h2>Friends</h2>";
                    
                    while ($row = $result->fetch_assoc()) {
                        // Check if friend1 is the current user, if not, use friend1, otherwise, use friend2
                        $friendUsername = ($row['friend1'] != $currentUsername) ? $row['friend1'] : $row['friend2'];
                    
                        echo "<tr><td>$friendUsername</td></tr>";
                    }
                    
                    echo "</table>";
                    


                ?>
                </p>
            </div>
        </div>
        <div class="col">
            <!-- Content for the third column -->
            <div class=" p-3">
        
                <p>
                <?php
   function getNonFriends($conn, $username)
   {
       $query = "SELECT username FROM users WHERE username <> '$username' AND username NOT IN (SELECT friend1 FROM friends WHERE friend2 = '$username' UNION SELECT friend2 FROM friends WHERE friend1 = '$username')";
   
       $result = $conn->query($query);
   
       if ($result->num_rows > 0) {
           while ($row = $result->fetch_assoc()) {
               $users[] = $row['username'];
           }
           return $users;
       } else {
           return [];
       }
   }
   
  
   $currentUsername = $_SESSION["uname"]; 
   $nonFriends = getNonFriends($conn, $currentUsername);
   
   // Output the list of non-friends with plus button
   echo "<h2>All Users</h2>";
   echo "<table>";
   echo "<br>";
   foreach ($nonFriends as $username) {
       echo "<tr>";
       echo "<td  style='margin-right: 2rem;' >{$username}</td>";
       echo "<td><button class='btn btn-primary btn-sm' style='margin-left: 2rem;' onclick=\"sendFriendRequest('$currentUsername', '$username')\">+</button></td>";
       echo "</tr>";
   }
   echo "</table>";
   
   
   
   $conn->close();
   
   ?>
   <script>
       // JavaScript function to send friend request asynchronously
       function sendFriendRequest(fromUser, toUser) {
           
           var confirmation = confirm("Send friend request to " + toUser + "?");
           if (confirmation) {
               alert("Friend request sent to " + toUser);
                      }
           var xhr = new XMLHttpRequest();
        xhr.open("POST", "process_friend_request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            var data = "fromUser=" + encodeURIComponent(fromUser) + "&toUser=" + encodeURIComponent(toUser);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response from PHP (if needed)
                console.log(xhr.responseText);
            }
        };

        // Send the request with the data
        xhr.send(data);
       }
   </script>

                </p>
            </div>
        </div>
    </div>
</div>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>
