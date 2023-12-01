<?php
include "./database.php";

// Function declarations should be outside of any conditional blocks
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

function isUsernameUnique($conn, $username) {
    // Check if the username already exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if($result->num_rows===0){
        return true;
    }
    return false; // If no rows are returned, the username is unique
}

function insertUser($conn, $username, $password) {
    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user into the database with hashed password
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    return $conn->query($sql);
}

function isValidLogin($conn, $username, $password) {
    // Retrieve hashed password from the database
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the entered password with the hashed password
        if (password_verify($password, $hashedPassword)) {
            return true; // Passwords match, login is successful
        }
    }
    return false; // Invalid username or password
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["loginBtn"])) {
       
        $username = sanitizeInput($_POST["username"]);
        $password = sanitizeInput($_POST["password"]);

        if (isValidLogin($conn, $username, $password)) {
            session_start();
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $_SESSION["id"]=$id;
    }
            $_SESSION["uname"]=$username;
            echo '<script>
            alert("Login successful!");
            setTimeout(function() {
                window.location.href = "./profile1.php";}, 30);
          </script>';
        exit();
        } else {
            echo '<script>
            alert("Invalid username or password for login.");
            setTimeout(function() {
                window.location.href = "./home.html";}, 30);
          </script>';
        exit();
        }
    } elseif (isset($_POST["signupBtn"])) {
    
        $username = sanitizeInput($_POST["username"]);
        $password = sanitizeInput($_POST["password"]);

        if(isUsernameUnique($conn,$username)){
            if (insertUser($conn, $username, $password)) {
                echo '<script>
                alert("Signup successful! Please login with your credentials.");
                setTimeout(function() {
                    window.location.href = "./home.html";}, 30);
              </script>';
            exit();
            } else {
                echo "Error during signup. Please try again.";
            }
        } else {
            echo '<script>
            alert("Username already exists. Please try with another username");
            setTimeout(function() {
                window.location.href = "./home.html";}, 30);
          </script>';
        exit();
        }   
    }
}
?>
