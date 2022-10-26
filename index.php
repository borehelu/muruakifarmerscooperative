<?php

// include classes
include_once "config/database.php";
include_once 'objects/user.php';


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "muruaki";


$currentIndex = 16;
  

for ($i=1; $i <=3 ; $i++) { 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE users SET id=$currentIndex WHERE id = $i";

    if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
    } else {
    echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    $currentIndex +=1;
 
}
?>