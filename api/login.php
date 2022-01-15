<?php
session_start();
include_once('config.php');

if($_SERVER['REQUEST_METHOD']=="POST"){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //DATABASE
    $SERVER = "localhost";
    $USER = "root";
    $PASS = "";
    $DB = "saic";

    //Connect Database
    $mysqli = new mysqli($SERVER, $USER, $PASS, $DB);

    //Check Connection
    if($mysqli->connect_errno){
        $_SESSION['error_message'] = $mysqli->connect_error;
        header('location: ../');
        exit();
    }

    //SQL Query
    $SQL = "SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'";

    //Perform Query
    if ($result = $mysqli -> query($SQL)) {
        
        if($result->num_rows==1){

            // $active = 

            $row = $result->fetch_assoc();
            
            if($row['active']==1){
                $_SESSION['username'] = $username;
                header("location: ../dashboard");
            } else {
                $_SESSION['error_message'] = "Your account is inactive";
                header("location: ../");
            }
            

            

        } else {
            $_SESSION['error_message'] = "Username or Password Error!";
            header('location: ../');
        }
        
      } else {
          $_SESSION['error_message'] = $mysqli -> error;
          header('location: ../');
      }

    

} else {
    header("location: ..");
}
