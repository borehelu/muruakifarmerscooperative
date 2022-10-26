<?php
// core configuration
include_once "../config/core.php";

// make it work in PHP 5.4
// include_once "../libs/pw-hashing/passwordLib.php";


// set page title
$page_title = "Login";

// include login checker
// include_once "login_checker.php";

// include classes
include_once "../config/database.php";
include_once '../objects/user.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$user = new User($db);



// if the login form was submitted
if($_POST && isset($_POST['password'])){

	$user->access_code = $_SESSION['access_code'];
	$user->password = $_POST['password'];
	$password_updated = $user->updateUserPassword();

	
	if($password_updated){
		if($_SESSION['access_level'] == 1){
			header("Location: {$home_url}modules/staff/dashboard.php?action=login_success");
		}
		// else, redirect only to farmer section
		elseif($_SESSION['access_level'] == 2){
			header("Location: {$home_url}modules/farmer/dashboard.php?action=login_success");
		}
		elseif($_SESSION['access_level'] == 0){

			header("Location: {$home_url}modules/admin/dashboard.php?action=login_success");
		}

	}
	

	}


// include page header HTML
include_once "layout_header.php";



?>


	<!-- actual HTML login form -->
	<div class="container">
		<div class="image-banner">
			<img src="../assets/img/logo-ct-dark.png" alt="">
			<h1>Muruaki Farmers Cooperative</h1>
			<h2>Set a new password</h2>
			
		</div>
		<div class="form">
			<form action="reset_password_initial.php" method="post">
			<br>
			<div>
				<label for="password">New Password</label>
				<input type="password" placeholder="new password" required name="password">
			</div>
			

			<button type="submit">reset</button>

			</form>
		</div>
		<div class="footer">
			<p><small>Muruaki farmers cooperative checkout system</small></p>
			<p><small>System by Joseph</small></p>
		</div>
	
	</div>

<?php
// footer HTML and JavaScript codes
include_once "layout_footer.php";
?>
