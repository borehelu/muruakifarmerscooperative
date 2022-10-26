<?php


// include classes
include_once "../../config/database.php";
include_once '../../objects/category.php';
include_once '../../objects/input.php';
include_once '../../objects/manufacturer.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$category = new Category($db);
$manufacturer = new Manufacturer($db);
$farminput = new FarmInput($db);

if($_POST){

  if(isset($_POST["addcategorybtn"])){
    $category->name = $_POST['category_name'];
    $category->description = $_POST['category_description'];
    if ($category->addCategory()) {
      echo "Success";
    }else{
      echo "Unable to add category";
    }

  } 
  
  elseif (isset($_POST["addmanufacturerbtn"])) {
    $manufacturer->name = $_POST['manufacturer_name'];

    if($manufacturer->addManufacturer()){
      echo "Success";
    }else{
      echo "Unable to add manufacturer";
    }
    

  } 
  
  elseif (isset($_POST["addfarminputbtn"])) {
     
    $farminput->name = $_POST['input_name'];
    $farminput->description = $_POST['input_description'];
    $farminput->category_id = $_POST['input_category'];
    $farminput->manufacturer_id = $_POST['input_manufacturer'];
    $farminput->price = $_POST["input_price"];
    $farminput->unit_of_measure = $_POST["input_unitofmeasure"];
    $farminput->quantity = $_POST["input_quantity"];

    if($farminput->addFarmInput()){
      echo "Farm Input added successfully.";
    } else{
      echo "Unable to add farm input.";
    }
    
    

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
          <a class="nav-link active bg-gradient-primary text-white " href="./inputs.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Farm Inputs</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Farm Inputs</h6>
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="pt-1 mx-6 mt-4">
                <p class="mb-0 text-capitalize">Categories</p>
                <h4 class="mb-0"><?php echo $category->getNumberOfCategories(); ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3 d-flex justify-content-end">
              <button class="btn btn-link text-success" data-toggle="modal" data-target="#addCategoryModal"><i class="material-icons text-sm me-2">add</i>New category</button>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="pt-1 mx-6 mt-4">
                <p class="mb-0 text-capitalize">Manufacturers</p>
                <h4 class="mb-0"><?php echo $manufacturer->getNumberOfManufacturers(); ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3 d-flex justify-content-end">
              <button class="btn btn-link text-success" data-toggle="modal" data-target="#addManufacturerModal"><i class="material-icons text-sm me-2">add</i>New Manufacturer</button>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="pt-1 mx-6 mt-4">
                <p class="mb-0 text-capitalize">Farm Inputs</p>
                <h4 class="mb-0"><?php echo $farminput->getNumberOfInputs(); ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3 d-flex justify-content-end">
              <button class="btn btn-link text-success" data-toggle="modal" data-target="#addFarmInputModal"><i class="material-icons text-sm me-2">add</i>New Farm inputs</button>
            </div>
          </div>
        </div>

       
      
      </div>



      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Farm Inputs</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Manufacturer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit of measure</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sold</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Added</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Modified</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $stmt = $farminput->readAllFarmInputs();

                      if($stmt->rowCount() > 0){
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                          extract($row);

                          $remaining = $quantity - $sold;
                          echo "
                            <tr>
                        
                              <td>
                                <p class='text-xs font-weight-bold mb-0'>{$name}</p>
                              </td>
                              <td class='align-middle text-center text-sm'>
                                {$category_name}
                              </td>
                              <td class='align-middle text-center text-sm'>
                                {$manufacturer_name}
                              </td>
                              <td class='align-middle text-center text-sm'>
                                KES. {$price}
                              </td>
                              <td class='align-middle text-center text-sm'>
                                {$unit_of_measure}
                              </td>
                              <td class='align-middle text-center text-sm'>
                                {$quantity}
                              </td>
                              <td class='align-middle text-center text-sm'>
                                {$sold}
                              </td>
                              <td class='align-middle text-center text-sm'>
                                {$remaining}
                              </td>
                              <td class='align-middle text-center'>
                                <span class='text-secondary text-xs font-weight-bold'>{$date}</span>
                              </td>
                              <td class='align-middle text-center'>
                                <span class='text-secondary text-xs font-weight-bold'>{$modified}</span>
                              </td>
                              <td class='align-middle text-center'>
                                <a href='./editinput.php?inputid={$id}' class='text-secondary fixed-plugin-button font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
                                  Edit
                                </a>
                              </td>
                            
                          </tr>

                            ";
                        }

                      }else{
                        echo "No records found";
                      }

                    
                    
                    ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

     


<!-- Modals -->

<!-- category modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"  aria-hidden="true">
  
  <div class="modal-dialog card" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">         
         <form action="inputs.php" method="post">
                  <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control"  name="category_name" required>
                  </div>

                  <div class="input-group input-group-outline">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control" name="category_description" required>
                  </div>

          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addcategorybtn" class="btn btn-primary">Add Category</button> </form>
      </div>
    </div>
  </div>
</div>


<!-- manufacturer modal -->
<div class="modal fade" id="addManufacturerModal" tabindex="-1" role="dialog"  aria-hidden="true">
  
  <div class="modal-dialog card" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Manufacturer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="inputs.php" method="post">
            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Name</label>
              <input type="text" class="form-control"  name="manufacturer_name" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addmanufacturerbtn" class="btn btn-primary">Add Manufacturer</button> </form>
      </div>
    </div>
  </div>
</div>

<!-- input modal -->
<div class="modal fade" id="addFarmInputModal" tabindex="-1" role="dialog"  aria-hidden="true">
  
  <div class="modal-dialog card" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Farm Input</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="inputs.php" enctype="multipart/form-data" method="post">
            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Name</label>
              <input type="text" class="form-control"  name="input_name" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Description</label>
              <input type="text" class="form-control"  name="input_description" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <select class="form-control"  name="input_category" required>
                <option value="">Select category</option>
                <?php
                 $stmt = $category->readAllCategories();

                 if($stmt->rowCount() > 0){
                   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                     extract($row);
                     echo " <option value='{$id}'>{$name}</option>";
                   }
                 }else{
                   echo "No categories found";
                 }
                

                ?>
              </select>
            </div>

            <div class="input-group input-group-outline mb-4">
              <select class="form-control"  name="input_manufacturer" required>
                <option value="">Select manufacturer</option>
                <?php
                 $stmt = $manufacturer->readAllManufacturers();

                 if($stmt->rowCount() > 0){
                   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                     extract($row);
                     echo " <option value='{$id}'>{$name}</option>";
                   }
                 }else{
                   echo "No manufacturers found";
                 }

                ?>
              </select>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Price</label>
              <input type="number" class="form-control" min="1" name="input_price" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Unit of measure</label>
              <input type="text" class="form-control"  name="input_unitofmeasure" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" min="1" name="input_quantity" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <input type="file" name="input_image[]" class="form-control" required>
            </div>


        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addfarminputbtn" class="btn btn-primary">Add Farm Input</button> </form>
      </div>
    </div>
  </div>
</div>
      
 
<?php include_once'layout_footer.php'; ?>

