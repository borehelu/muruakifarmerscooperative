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



$farminput->id = isset($_GET["inputid"]) ? $_GET['inputid'] : exit;
$farminput->readOneFarmInput();

if($_POST){

  $farminput->name = $_POST['input_name'];
  $farminput->description = $_POST['input_description'];
  $farminput->category_id = $_POST['input_category'];
  $farminput->manufacturer_id = $_POST['input_manufacturer'];
  $farminput->price = $_POST["input_price"];
  $farminput->unit_of_measure = $_POST["input_unitofmeasure"];
  $farminput->quantity = $_POST["input_quantity"];
  $farminput->id = isset($_GET["inputid"]) ? $_GET['inputid'] : exit;

  if($farminput->updateFarmInput()){
    echo "Farm Input updated successfully.";
  } else{
    echo "Unable to update records.";
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

          
      <div class="col-8 mx-auto mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Edit</p>
                <h4 class="mb-0">Farm Input</h4>
              </div>
            </div>
            <div class="row p-4">
                <div class="col-10">
               
                  <form action="editinput.php?inputid= <?php echo $_GET['inputid']; ?>" method="post">

                  <div class="input-group input-group-outline mb-4">
              <label class="m-3">Input name</label>
              <input type="text" class="form-control" value="<?php echo $farminput->name; ?>" name="input_name" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="m-3">Description</label>
              <input type="text" class="form-control" value="<?php echo $farminput->description; ?>" name="input_description" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="m-3">Category</label>
              <select class="form-control"  name="input_category" required>
                <option value="">Select category</option>
                <?php
                 $stmt = $category->readAllCategories();

                 if($stmt->rowCount() > 0){
                   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                     extract($row);
                     $selected_category = ($id == $farminput->category_id) ? 'selected="selected"' : '';
                     echo " <option value='{$id}' {$selected_category} >{$name}</option>";
                   }
                 }else{
                   echo "No categories found";
                 }
                

                ?>
              </select>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="m-3">Manufacturer</label>
              <select class="form-control"  name="input_manufacturer" required>
                <option value="">Select manufacturer</option>
                <?php
                 $stmt = $manufacturer->readAllManufacturers();

                 if($stmt->rowCount() > 0){
                   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                     extract($row);
                     $selected_manufacturer = ($id == $farminput->manufacturer_id) ? 'selected="selected"' : '';
                     echo " <option value='{$id}'  {$selected_manufacturer} >{$name}</option>";
                   }
                 }else{
                   echo "No manufacturers found";
                 }

                ?>
              </select>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="m-3">Price</label>
              <input type="number" class="form-control" value="<?php echo $farminput->price; ?>" min="1" name="input_price" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="m-3">Unit of measure</label>
              <input type="text" class="form-control" value="<?php echo $farminput->unit_of_measure; ?>" name="input_unitofmeasure" required>
            </div>

            <div class="input-group input-group-outline mb-4">
              <label class="m-3">Quantity</label>
              <input type="number" class="form-control" value="<?php echo $farminput->quantity; ?>" min="1" name="input_quantity" required>
            </div>
                  

                  <button class="btn bg-gradient-dark m-4" type="submit">Save</button>
                  
                  </form>
                </div>
            </div>
           
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
        <form action="inputs.php" method="post">
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
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addfarminputbtn" class="btn btn-primary">Add Farm Input</button> </form>
      </div>
    </div>
  </div>
</div>
      
 
<?php include_once'layout_footer.php'; ?>

