<?php include_once'layout_header.php';?>


<?php 

// include classes
include_once "../../config/database.php";
include_once '../../objects/delivery.php';
include_once "../../objects/accounts.php";
include_once "../../objects/rate.php";



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$delivery = new Delivery($db);
$account = new Account($db);
$milkrate = new MilkRate($db);
$rate = $milkrate->readMilkRate();


?>

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
          <a class="nav-link text-white " href="./farmers.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">supervised_user_circle</i>
            </div>
            <span class="nav-link-text ms-1">Farmers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white  active bg-gradient-primary" href="./deliveries.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">inventory_2</i>
            </div>
            <span class="nav-link-text ms-1">Deliveries</span>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Deliveries</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Daily Deliveries</h6>
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
      <div class="row">

      <?php

        if($_POST && isset($_POST['litres-delivered'])){

          $delivery->farmer_id = isset($_GET["id"]) ? $_GET['id'] : exit;
          $delivery->litres_delivered = $_POST['litres-delivered'];

          $delivery_captured = $delivery->addDelivery();

          $account->farmer_id =  isset($_GET["id"]) ? $_GET['id'] : exit;

          $updated_account = $account->updateAccountDetailsOnDelivery($_POST['litres-delivered'], $rate);

          if($delivery_captured && $updated_account){
            // echo "<div class='col-8'>";
            // echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
            // echo "Successfuly added milk delivery details";
            // echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            // echo "<span aria-hidden='true'>&times;</span>";
            // echo "</button>";
            // echo "</div>";
            // echo "</div>";

          }else{
            echo "<div class='col-8'>";
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
            echo "Some error occurred.";
            echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "</div>";
            echo "</div>";
            
          }

        }


        ?>


        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">delivery_dining</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Litres delivered</p>
                <h4 class="mb-0">
                  <?php 
                      $stmt = $delivery->readDailyDeliveries();
                      if($stmt->rowCount() > 0){
                        extract($stmt->fetch(PDO::FETCH_ASSOC));
                        echo $total_daily_delivery;

                      }else{
                        echo "0 Litres";
                      }
                  ?>
                </h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              
            </div>
          </div>
        </div>
     
       
      </div>

      <div class="row mt-4">
         <div class="col-md-7 mt-4">
              <div class="card">
                  <div class="card-header pb-0 px-3">
                    <div class="row">
                      <div class="col-8">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Search farmer(Name, Phone or Email)</label>
                        <input type="text" id="search-farmer" class="form-control">
                      </div>

                      </div>
                      <div class="col-4">
                      <button class="btn bg-gradient-dark text-light px-3 mb-0" id="search-farmer-btn">
                      <i class="material-icons opacity-10">search</i>
                        Search
                      </button>

                      </div>
                    </div>
                      
                      
                </div>
                <div class="card-body pt-4 p-3">
                  <ul class="list-group">

                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" id="search-results">
                      <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm" id="farmer-name"></h6>
                        <span class="mb-2 text-xs">Email Address: <span class="text-dark font-weight-bold ms-sm-2"  id="farmer-email"></span></span>
                        <span class="mb-2 text-xs">Phone: <span class="text-dark ms-sm-2 font-weight-bold" id="farmer-phone"></span></span>
                        <span class="text-xs">Route: <span class="text-dark ms-sm-2 font-weight-bold" id="farmer-route"></span></span>
                      </div>
                      <div class="ms-auto text-end">
                        <button class="btn btn-link text-dark px-3 mb-0" data-toggle="modal" id="launchDeliveriesModal" data-target="#addDeliveryModal"><i class="material-icons text-sm me-2">edit</i>Edit</button>
                      </div>
                    </li>
                    
                  </ul>
                </div>
              </div>
            </div>

      </div>


  

<!-- deliveries modal -->
<div class="modal fade" id="addDeliveryModal" tabindex="-1" role="dialog"  aria-hidden="true">
  
  <div class="modal-dialog card" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">         
         <form action="deliveries.php" id="addDeliveryForm" method="post">

             <div class="input-group input-group-outline mb-4">
                <label class="form-label">Litres delivered</label>
                <input type="number" min="0" max="2000" class="form-control"  name="litres-delivered" required>
              </div>

                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="deliverybtn" class="btn btn-primary">Save</button> </form>
      </div>
    </div>
  </div>
</div>

   
      
 
<?php include_once'layout_footer.php'; ?>