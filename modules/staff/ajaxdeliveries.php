<?php

// include classes
include_once "../../config/database.php";
include_once '../../objects/farmer.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$farmer = new Farmer($db);



if (isset($_POST['search'])) {

  $search_criteria = $_POST['search'];
  $stmt = $farmer->searchFarmer($search_criteria);
  $row = $stmt->rowCount();

  if ($row > 0) {
      $details = $stmt->fetch(PDO::FETCH_ASSOC);
      extract($details);
      $farmerinfo = array();

      $farmerinfo['success'] = true;
      $farmerinfo['farmerid'] = $id;
      $farmerinfo['name'] = $name;
      $farmerinfo['phone'] = $phone;
      $farmerinfo['email'] = $email;
      $farmerinfo['route'] = $route;
      
      echo json_encode($farmerinfo);
    
  }else{
    echo json_encode(array("success"=>false));
  }
  exit();
}






?>