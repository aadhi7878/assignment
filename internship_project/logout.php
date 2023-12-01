<?php
  session_start();
  unset($_SESSION['uname']);
  unset($_SESSION['id']);
  // session_unset(); 
  

  header("location:./home.html");
?>  