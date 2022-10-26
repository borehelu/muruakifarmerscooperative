<?php include_once'layout_header.php';?>


<?php 

// include classes
include_once "../../config/database.php";
include_once '../../objects/delivery.php';
include_once "../../objects/accounts.php";
include_once "../../objects/rate.php";
include_once "../../objects/orders.php";
include_once "../../objects/farmer.php";
include_once "../../objects/orderedinputs.php";
include_once '../../objects/input.php';


// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$delivery = new Delivery($db);
$account = new Account($db);
$milkrate = new MilkRate($db);
$farmer = new Farmer($db);
$ordered_inputs = new OrderedInput($db);
$order = new Order($db);
$farminput = new FarmInput($db);


$rate = $milkrate->readMilkRate();

$deliveries = $delivery->readCumulativeDeliveries();

if($deliveries->rowCount() > 0){
  extract($row = $deliveries->fetch(PDO::FETCH_ASSOC));
}

$farmers = $farmer->readAllFarmers();

$registered_farmers = $farmers->rowCount();


$total_inputs = $ordered_inputs->readAllDeliveredOrderedInputs();


?>


<?php 
          
          if($_POST){

            if(isset($_GET['id']) && isset($_POST['updateorder-btn'])){
              
              $order->id = $_GET['id'];
              $order->status = $_POST['status'];
              $ordered_inputs->order_id = $_GET['id'];
              $ordered_inputs->status = $_POST['status'];
              $status_updated = $order->changeOrderStatus();
              $status_updated_input = $ordered_inputs->changeOrderStatus();

              if($_POST['status'] == 3){

                $order->farmer_id  = $_GET['farmer_id'];

                $order_details = $order->readSingleOrderByUser();
        
                if($order_details->rowCount() > 0){
                    extract($order_details->fetch(PDO::FETCH_ASSOC));
                    $account->farmer_id =  $_GET['farmer_id'];
                    $accounts_updated = $account->updateAccountDetailsOnCancelOrder($total);
        
                    if($accounts_updated){
                        $ordercancelled = $order->changeOrderStatus();
                        $inputs_ordered = $ordered_inputs->readAllOrderedInputsByFarmer();
        
                        if($inputs_ordered->rowCount() > 0){
                            
                            while($row = $inputs_ordered->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                $farminput->id = $input_id;
                                $farminput->sold = $quantity;
                                $updated_inputs = $farminput->updateQuantityOnCancelOrder();
        
                            }
                        }
                        $orderedinputscancelled = $ordered_inputs->cancelOrder();
                        if($ordercancelled && $orderedinputscancelled){
                            echo "success";

                        } else{
                            echo "failed";
                            
                        }
                    }
                  }
                 

              } //cancelling order
       
              

              if($status_updated){
                echo "Success";
              }else{
                echo "An error occured.";
              }

            } //btn

          } //post
      
      
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
          <a class="nav-link text-white" href="./farmers.php">
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
          <a class="nav-link text-white  active bg-gradient-primary" href="./orders.php">
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
    <div class="row">
    
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Litres delivered</p>
                <h4 class="mb-0"><?php echo $total_delivery;?> L</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Registered Farmers</p>
                <h4 class="mb-0"> <?php echo $registered_farmers;?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Inputs delivered</p>
                <h4 class="mb-0"><?php echo $total_inputs;?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Current Milk rate</p>
                <h4 class="mb-0">KES. <?php echo $rate;?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
             
            </div>
          </div>
        </div>
      </div>

      <div class="row my-4">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">
                  Orders</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Farmer ID</th>
                      <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Route</th> -->
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Modified</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      
                      $stmt = $order->readAllOrders();

                      if($stmt->rowCount() > 0){
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                          extract($row);
                          switch ($status) {
                            case 0:
                              $status_str = "<span class='badge badge-sm bg-gradient-secondary'>Pending</span>";
                              break;

                            case 1:
                              $status_str = "<span class='badge badge-sm bg-gradient-info'>Processed</span>";
                              break;

                            case 2:
                              $status_str = "<span class='badge badge-sm bg-gradient-success'>Completed</span>";
                              break;

                            case 3:
                              $status_str = "<span class='badge badge-sm bg-gradient-danger'>Cancelled</span>";
                              break;
                            
                          }
                          echo "
                            <tr>
                        
                            <td class='align-middle text-center'>
                            <span class='text-secondary text-xs font-weight-bold'>{$farmer_id}</span>
                          </td>
                       
                          <td class='align-middle text-center'>
                          <span class='text-secondary text-xs font-weight-bold'>{$id}</span>
                        </td>
                          <td class='align-middle text-center'>
                            <span class='text-secondary text-xs font-weight-bold'>KES. {$total}</span>
                          </td>
                          <td class='align-middle text-center'>
                             <span class='text-secondary text-xs font-weight-bold'>{$status_str}</span>
                           </td>
                              <td class='align-middle text-center'>
                                <span class='text-secondary text-xs font-weight-bold'>{$created}</span>
                              </td>
                              <td class='align-middle text-center'>
                                <span class='text-secondary text-xs font-weight-bold'>{$modified}</span>
                              </td>
                              <td class='align-middle'>
                                <a href='./vieworder.php?orderid={$id}' class='text-secondary fixed-plugin-button font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
                                  View
                                </a>
                               
                                ";
                                if($status != 3){
                                  echo "
                                  <button type='button' data-farmer-id='{$farmer_id}' id='{$id}' style='display: inline-block; background: none; border: none;' class='text-success fixed-plugin-button font-weight-bold text-xs update-order'>
                                  Process
                                 </button>
                                    ";
                                }
                               echo "

                              </td>
                            
                          </tr>

                            ";
                        }

                      }else{
                        echo "<p class='mx-4'>No records found</p>";
                      }

                    
                    
                    ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


      

 <!-- category modal -->
<div class="modal fade" id="updateOrder" tabindex="-1" role="dialog"  aria-hidden="true">
  
  <div class="modal-dialog card" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">         
         <form action="orders.php" id="update_order_form" method="post">

                  <div class="input-group input-group-outline">
                    <label class="m-3">Status</label>
                    <select name="status" class="form-control" required>
                      <option value="1">Processed</option>
                      <option value="2">Delivered</option>
                      <option value="3">Cancelled</option>
                    </select>
                  </div>

          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-update-modal" >Close</button>
        <button type="submit" name="updateorder-btn" class="btn btn-primary">Update Order</button> </form>
      </div>
    </div>
  </div>
</div>

 
      
 
<?php include_once'layout_footer.php'; ?>
  