<?php

// include classes
include_once "../../config/database.php";
include_once '../../objects/user.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$user = new User($db);



if (isset($_POST['email'])) {

    $search_criteria = $_POST['email'];
    
    if ($user->validateEmailandPhone($search_criteria)) {
        
        echo json_encode(array("exists"=>true));
      
    }else{
      echo json_encode(array("exists"=>false));
    }
    exit();

  } else if (isset($_POST['phone'])) {

    $search_criteria = $_POST['phone'];
   
    if ($user->validateEmailandPhone($search_criteria)) {
        
        echo json_encode(array("exists"=>true));
      
    }else{
      echo json_encode(array("exists"=>false));
    }
    exit();
  }
  



?>