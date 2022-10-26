<?php


// include classes
include_once "../../config/database.php";
include_once '../../objects/rate.php';




// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$milkrate = new MilkRate($db);

if($_POST){

  $milkrate->rate = $_POST['milkrate'];
  $success = $milkrate->setRate();

  if($success){
      echo "Milk rate set successfully";
  }else{
      echo "An error occurred ";
  }
}






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
          <a class="nav-link text-white " href="./users.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">supervised_user_circle</i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="./inputs.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">agriculture</i>
            </div>
            <span class="nav-link-text ms-1">Farm Inputs</span>
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
          <a class="nav-link text-white " href="./reports.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">list_alt</i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="./settings.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">settings</i>
            </div>
            <span class="nav-link-text ms-1">Milk Price</span>
          </a>
        </li>
        <hr>
        
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Current Milk rate</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Current milk rate</h6>
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Current Milk Rate</p>
                <h4 class="mb-0 mt-4">
                    <?php 
                        $currentrate = $milkrate->readMilkRate();
                        echo $currentrate == 0 ? "The milk rate is not set.": "KES. {$currentrate} per Litre.";
                    ?>
                </h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-1">
            <button class="btn btn-link text-success" data-toggle="modal" data-target="#editMilkRateModal"><i class="material-icons text-sm me-2">edit</i>Change Rate</button>
            </div>
          </div>
        </div>
        
      
      </div>


      

<!-- edit milk rate modal -->
<div class="modal fade" id="editMilkRateModal" tabindex="-1" role="dialog"  aria-hidden="true">
  
  <div class="modal-dialog card" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Milk Rate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">         
         <form action="settings.php" method="post">
                  <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Milk Rate(KES./Litre)</label>
                    <input type="number" min="1"class="form-control"  name="milkrate" required>
                  </div>

                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="editRate" class="btn btn-primary">Set Rate</button> </form>
      </div>
    </div>
  </div>
</div>
      
 
<?php include_once'layout_footer.php'; ?>
  