<?php


// core configuration
include_once "../config/core.php";




// make it work in PHP 5.4
include_once "../libs/zgpwhwzn/passwordLib.php";


// set page title
$page_title = "Login";

// include login checker
include_once "login_checker.php";

// include classes
include_once "../config/database.php";
include_once '../objects/user.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$user = new User($db);


// default to false
$access_denied=false;
$css = 'display: none;';

// if the login form was submitted
if($_POST){

	
	// check if email and password are in the database
	$user->email=$_POST['email'];

	// check if email exists, also get user details using this emailExists() method
	$email_exists = $user->emailExists();




	// validate login
	if($email_exists && password_verify($_POST['password'], $user->password) && $user->status==1){

		// set retrieved user_id to cookie user_id
		setcookie("user_id", $user->id);

		// set the session value to true
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user->id;
		$_SESSION['access_level'] = $user->access_right;
		$_SESSION['access_code'] = $user->access_code;
		$_SESSION['name'] = $user->name;
		$_SESSION['password'] = $user->password_updated;

	

		// if access level is 'Admin', redirect to admin section
		if($user->access_right == 0){

			header("Location: {$home_url}modules/admin/dashboard.php?action=login_success");
		}

		elseif($user->access_right == 1){

			header("Location: {$home_url}modules/staff/dashboard.php?action=login_success");
		}
		// else, redirect only to farmer section
		elseif($user->access_right == 2 ){

			header("Location: {$home_url}modules/farmer/dashboard.php?action=login_success");
		}


	}

	// if username does not exist or password is wrong
	else{
		$access_denied=true;
	}
}

// include page header HTML
include_once "layout_header.php";

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

?>




<?php
// get 'action' value in url parameter to display corresponding prompt messages
$action=isset($_GET['action']) ? $_GET['action'] : "";

// tell the user he is not yet logged in
if($action =='not_yet_logged_in'){
	echo "You are yet to login";
	
}

// tell the user to login
else if($action=='please_login'){
	echo "Please Login";	

}

// tell the user if access denied
if($access_denied){
	
	 $css = "display: block; color: red";
}
?>

	<!-- actual HTML login form -->
	<div class="container">
		<div class="image-banner">
			<img src="../assets/img/logo-ct-dark.png" alt="">
			<h1>Muruaki Farmers Cooperative</h1>
			<?php echo "<small style = '{$css}'>Invalid user credentials!</small>";?>
		</div>
		<div class="form">
			<form action="login.php" method="post">
				<div>
					<label for="email">Email</label>
					<input type="email" placeholder="email@mail.com" required name="email" id="email">
				</div>

				<div>
					<label for="password">Password</label>
					<input type="password" placeholder="password" required name="password">
				</div>
			
				<a class="forgot-password" href="forgot_password.php">forgot password</a>
			
				<button type="submit">Login</button>

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
