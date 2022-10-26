<?php 

// core configuration
include_once "../../config/core.php"; 

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Muruaki Cooperative Checkoff
  </title>

  <!--Fonts and icons-->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  
  <!-- Nucleo Icons -->
  <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
 
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <!-- Material Icons -->
  <link href="../../assets/css/material-icons.css" rel="stylesheet" />
  
  <!-- CSS Files -->
  <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />

  <style>
    .product-img{
      padding: 0;
      border-radius: 16px;
      width: 200px;
      height: 200px;


    }

    .product-img img{
      width: 200px;
      height: 200px;
      border-radius: 16px;
     
    }
    .product-footer{
      display: flex;
      justify-content: space-between;
    }
    .product-footer div{
      display: flex;
      padding: 8px;
    }
    .product-footer div span{
      margin-right: 8px;
      font-size: 1.3em;
    }

    .product-footer div span.increase, .product-footer div span.decrease{
      display: inline-flex;
      justify-content: center;
      align-items: center;
      width: 30px;
      height: 30px;
      border-radius: 20px;
      background: #dedede;
      cursor: pointer;
      
    }
    .product-footer div .quantity{
      /* max-width: 40px; */
      /* margin: 0 8px; */
      
    }
    
  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
  