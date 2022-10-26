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
include_once '../objects/utils.php';



// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$user = new User($db);
$utils = new Utils();

$status = "";

if($_POST && isset($_GET['access_code'])){
 
        // check if username and password are in the database
        $pass1=$_POST['password1'];
        $pass2=$_POST['password2'];
        $user->access_code=$_GET['access_code'];
         // get given access code
   
        if(($pass1!=$pass2)&&(!$user->accessCodeExists())){
 
           $status = "<p>Passwords don't match or invalid access code</p>";
        
        }
            
        
            // message if unable to update access code
            else{
                
                // set values to object properties
                $user->password=$_POST['password1'];
                $user->access_code=$_GET['access_code'];
                // reset password
                if($user->updateUserPassword()){
                    $status = "<p>Password was reset. Please <a href='{$home_url}/auth/login.php'>login.</a></p>";
                }
            
                else{
                    $status = "<p'>Unable to reset password.</p>";
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
			<small>You need to set a new password</small>
			
		</div>
		<div class="form">
			<form action="reset_password.php?access_code=<?php echo $_GET['access_code']?>" method="post">
			<h2>Reset Password</h2>
            <?php echo $status; ?>
			<br>
            <div>
                <label for="password">New Password</label>
                <input type="password" name="password1">
            </div>

            <div>
                <label for="password">Confirm Password</label>
                <input type="password" name="password2">
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
