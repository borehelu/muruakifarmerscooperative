<?php

// include classes
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once '../../objects/category.php';
include_once '../../objects/input.php';
include_once '../../objects/manufacturer.php';
include_once '../../objects/cart.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$category = new Category($db);
$manufacturer = new Manufacturer($db);
$farminput = new FarmInput($db);
$cart = new CartItem($db);

$cart->farmer_id = $_SESSION['user_id'];


?>



<?php include_once'layout_header.php';?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>  
  <p class="text-white text-bold mt-4 px-4">Muruaki Cooperative</p>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="./dashboard.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  active bg-gradient-primary" href="./inputs.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">agriculture</i>
            </div>
            <span class="nav-link-text ms-1">Farm Inputs</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="./cart.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">shopping_cart</i>
            </div>
            <span class="nav-link-text ms-1">Cart</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white " href="./orders.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">pending_actions</i>
            </div>
            <span class="nav-link-text ms-1">Orders</span>
          </a>
        </li>

   
        <li class="nav-item">
          <a class="nav-link text-white " href="../../auth/logout.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>

        <hr>
        <li class="nav-item">
          <a class="nav-link text-white " href="../../auth/reset_password_initial.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">lock</i>
            </div>
            <span class="nav-link-text ms-1">Reset password</span>
          </a>
        </li>
        
      </ul>
    </div>
  
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Farm Inputs</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Farm inputs</h6>
        </nav>
        <div class="collapse justify-content-end navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav  justify-content-end">
          <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?php echo $_SESSION['name']; ?></span>
              </a>
            </li>


            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">


      <div class="row mt-4">

      <?php
        $stmt = $farminput->readAllFarmInputs();

        if($stmt->rowCount() > 0){
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $cart->input_id = $id;
            $exists = $cart->inputExistsInCart();
            $remaining = $quantity - $sold;

            $photo = ($photo == "" ) ? "default-product-image.png" : $photo;

            echo "
                  <div class='col-lg-3 col-md-4 mt-4 mb-4'>
                  <div class='card z-index-2 '>
                    <div class='card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent'>
                      <div class='shadow-dark border-radius-lg product-img'>
                        
                          <!-- image -->
                          <img src='../../assets/uploads/{$photo}' alt='{$photo}'>
                      
                      </div>
                    </div>
                    <div class='card-body'>
                      <h6 class='mb-0 '>{$name} - {$unit_of_measure}</h6>
                      <p class='text-sm '>{$description}</p>
                      <p class='text-sm text-primary'>KES. {$price}</p>
                      <hr class='dark horizontal'>
                      <div class='product-footer'>
                        <p class='text-sm'> {$remaining} left</p>
                        ";
                        if($exists){
                          echo "<p class='text-sm' > Added to Cart</p>";

                        }else{
                          echo "<button type='button' id='{$id}' class='btn btn-sm ml-4 btn-success add-to-cart-btn'>
                                Add to cart
                                </button>";

                        }
                        echo " 
                        
                      </div>
                    </div>
                  </div>
                </div>
                  ";
          }
        }
      
      
      
      
      ?>

       
      </div>
      
 
<?php include_once'layout_footer.php'; ?>
  