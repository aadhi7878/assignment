<?php
$servername="localhost";
$username="root";
$password="";
$database="social";
$conn =mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("connection failed:".mysqli_connect_errno());
}
?>