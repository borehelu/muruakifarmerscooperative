<?php
// core configuration
include_once "../config/core.php";

// make it work in PHP 5.4
// include_once "../libs/pw-hashing/passwordLib.php";


// set page title
$page_title = "Forgot Password";

// include login checker
include_once "login_checker.php";

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


// if the login form was submitted
if($_POST){

	
	// check if email and password are in the database
	$user->email=$_POST['email'];

	// check if email exists, also get user details using this emailExists() method
	$email_exists = $user->emailExists();

	// validate login
	if($email_exists && $user->status==1){

		 // update access code for user
         $access_code=$utils->getToken();
         $user->access_code=$access_code;

         if($user->updateAccessCode()){

             // send reset link
             $message="Hi there.<br /><br />";
             $message.="Please click the following link to reset your password: <a href='{$home_url}auth/reset_password.php?access_code={$access_code}'>Link</a>";
             $subj="Reset Password";
             $send_to_email=$_POST['email'];

                 // send reset link
             $mailTo=   $send_to_email;
             $nameTo = 'User';
             $subject =  $subj;
             $body =  $message;
             
             include_once "./mail.php";
             if($mail->send()){
                 $status = "<p>Password reset link was sent to your email. Click that link to reset your password. </p>";
             }
              // status if unable to send email for password reset link
              else{
                   $status = "<p>ERROR: Unable to send reset link.</p>";
                }

         	}

	}  //if username does not exist or password is wrong
	else{
        $status = "<p>The email you provided does not exist in our database.</p>";
		
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
            <p>Provide email address</p>
			<br>
			<?php echo $status;?>
		</div>
		<div class="form">
			<form action="forgot_password.php" method="post">
				<div>
					<label for="email">Email</label>
					<input type="email" placeholder="email@mail.com" required name="email" id="email">
				</div>
			
				<button type="submit">Send Reset Link</button>

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
