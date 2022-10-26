<?php include_once'layout_header.php';?>

<?php 

// include classes
include_once "../../config/database.php";
include_once '../../objects/user.php';
include_once '../../objects/utils.php';

// make it work in PHP 5.4
include_once "../../libs/zgpwhwzn/passwordLib.php";



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$user = new User($db);
$utils = new Utils();

$status = "";

if($_POST){
  if(isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])){
    
    $user->name = $_POST['username'];
    $user->password = $_POST['password'];
    $user->phone = $_POST['phone'];
    $user->email = $_POST['email'];
    $user->access_right = 1;
    // update access code for user
    $access_code=$utils->getToken();
    $user->access_code=$access_code;
    $user_added = $user->addUser();

    if($user_added){
        // send reset link
        $message="Hello {$user->name}.<br /><br />";
        $message.="Your account with Muruaki Farmers Cooperative was created successfuly. Your temporary password is <b>{$_POST['password']}</b>. <br>Change the password to a more secure one for security purposes. Use this  <a href='{$home_url}auth/reset_password.php?access_code={$access_code}'>Link</a> to change your password.";
        $subj="Account Creation";
        $send_to_email=$_POST['email'];

            // send reset link
        $mailTo=   $send_to_email;
        $nameTo = 'User';
        $subject =  $subj;
        $body =  $message;
        
        include_once "./mail.php";
        if($mail->send()){
            $status = "<p>Account created successfully </p>";
        }
        // status if unable to send email for password reset link
        else{
              $status = "<p>ERROR: Unable to send email.</p>";
          }
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
          <a class="nav-link text-white active bg-gradient-primary" href="./users.php">
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
          <a class="nav-link text-white" href="./reports.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">list_alt</i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="./settings.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Users</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Users</h6>
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
                <p class="text-sm mb-0 text-capitalize">Add New</p>
                <h4 class="mb-0">Staff</h4>
              </div>
            </div>
            <div class="row p-4">
                <div class="col-10">
               
                  <form action="users.php" method="post">
                  <?php echo $status; ?>
                  <div class="input-group input-group-outline m-4">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control"  name="username" required>
                  </div>

                  <div class="input-group input-group-outline m-4">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>
                  <small class="text-danger error-msg error-msg-email">The email has already been used.</small>

                  <div class="input-group input-group-outline m-4">
                    <label class="form-label">Phone</label>
                    <input type="phone" class="form-control" name="phone" id="phone" required>
                  </div>
                  <small class="text-danger error-msg error-msg-phone">The phone number has already been used.</small>

                  <div class="input-group input-group-outline m-4">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                  </div>

                  <button class="btn bg-gradient-dark m-4" id="add-user" type="submit">Save</button>
                  
                  </form>
                </div>
            </div>
           
          </div>
        </div>

        
        
       
      </div>


      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Users table</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Added</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    
                      <?php
                      $stmt = $user->readAllUsers();

                      $num = $stmt->rowCount();

                      if($num > 0){
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                          extract($row);
                          $access = "";
                          switch($access_right){
                            case 0:
                              $access = "Admin";
                              break;

                            case 1:
                              $access = "Staff";
                              break;

                            case 2:
                              $access = "Farmer";
                              break;

                          }

                          $user_status = $status == 1 ? "<span class='badge badge-sm bg-gradient-success'>Active</span>" : "<span class='badge badge-sm bg-gradient-secondary'>Suspended</span>";

                          echo "
                          <tr>
                          <td>
                          <div class='d-flex px-2 py-1'>
                            <div class='d-flex flex-column justify-content-center'>
                              <h6 class='mb-0 text-sm'>{$name} </h6>
                              <p class='text-xs text-secondary mb-0'>{$email}</p>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class='text-xs font-weight-bold mb-0'>{$access}</p>
                          <p class='text-xs text-secondary mb-0'></p>
                        </td>
                        <td class='align-middle text-center text-sm'>
                          {$user_status}
                        </td>
                        <td class='align-middle text-center'>
                          <span class='text-secondary text-xs font-weight-bold'>{$date}</span>
                        </td>
                        <td class='align-middle'>
                          <a href='./edituser.php?userid={$id}' class='text-secondary fixed-plugin-button font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
                            Edit
                          </a>
                        </td>
                          
                        </tr>
                          
                         ";


                        }

                      }else{
                        echo "<p>No records found</p>";
                      }
                      
                      
                      
                      ?>

                   
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

 
<?php include_once'layout_footer.php'; ?>
  