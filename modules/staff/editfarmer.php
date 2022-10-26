<?php include_once'layout_header.php';?>

<?php 

// include classes
include_once "../../config/database.php";
include_once '../../objects/user.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$user = new User($db);

$user->id = isset($_GET["userid"]) ? $_GET['userid'] : exit;
$user->readOneUser();




if($_POST){
  
  if(isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['status']) && isset($_POST['route'])){
    
    $user->name = $_POST['username'];
    $user->phone = $_POST['phone'];
    $user->email = $_POST['email'];
    $user->status = $_POST['status'];
    $user->route = ($_POST['route'] == "N.A") ? "" : $_POST['route'];
    $user->id = isset($_GET["userid"]) ? $_GET['userid'] : exit;

    if($user->updateUserDetails()){
      echo "Records updated successfuly";

    }else{
      echo "An error occurred while updating record. Please trying again";
    }


    
  }
}


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
          <a class="nav-link text-white  active bg-gradient-primary" href="./farmers.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">supervised_user_circle</i>
            </div>
            <span class="nav-link-text ms-1">Farmers</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="./deliveries.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
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


      <div class="row mb-4">
        
        <div class="col-8 mx-auto mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Edit</p>
                <h4 class="mb-0">User</h4>
              </div>
            </div>
            <div class="row p-4">
                <div class="col-10">
               
                  <form action="editfarmer.php?userid= <?php echo $_GET['userid']; ?>" method="post">

                  <div class="input-group input-group-outline m-4">
                    <label class="m-3">Name</label>
                    <input type="text" class="form-control"  value="<?php echo $user->name; ?>" name="username" required>
                  </div>

                  <div class="input-group input-group-outline m-4">
                    <label class="m-3">Email</label>
                    <input type="email" class="form-control" value="<?php echo $user->email; ?>" name="email" required>
                  </div>


                  <div class="input-group input-group-outline m-4">
                    <label class="m-3">Phone</label>
                    <input type="phone" class="form-control" value="<?php echo $user->phone; ?>" name="phone" required>
                  </div>

                  <div class="input-group input-group-outline m-4">
                    <label class="m-3">Route</label>
                    <input type="text" class="form-control"  value="<?php echo isset($user->route) ? $user->route : "N.A"; ?>" name="route" required>
                  </div>

                  <div class="input-group input-group-outline m-4">
                    <label class="m-3">Status</label>
                    <select name="status" class="form-control" required>
                      <option value="1">Active</option>
                      <option value="0">Suspended</option>
                    </select>
                  </div>
                  

                  <button class="btn bg-gradient-dark m-4" type="submit">Save</button>
                  
                  </form>
                </div>
            </div>
           
          </div>
        </div>

        
        
       
      </div>


      
 
<?php include_once'layout_footer.php'; ?>
  