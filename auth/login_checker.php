<?php

if(isset($_SESSION['access_level']) && $_SESSION['access_level']== 0){
	header("Location: {$home_url}modules/admin/dashboard.php?action=logged_in_as_admin");
}


elseif (isset($_SESSION['access_level']) && $_SESSION['access_level']== 1) {
	header("Location: {$home_url}modules/staff/dashboard.php?action=logged_in_as_staff");
}

elseif (isset($_SESSION['access_level']) && $_SESSION['access_level']== 2) {
	header("Location: {$home_url}modules/farmer/dashboard.php?action=logged_in_as_farmer");
}

// if it is the 'edit profile' or 'orders' or 'place order' page, require a login
// else if(isset($page_title) && ($page_title=="Edit Profile" || $page_title=="Orders" || $page_title=="Place Order")){
	
// 	// if user not yet logged in, redirect to login page
// 	if(!isset($_SESSION['access_level'])){
// 		header("Location: {$home_url}login.php?action=please_login");
// 	}
// }

// if it was the 'login'  page but the user was already logged in
else if(isset($page_title) && ($page_title=="Login")){
	// if user not yet logged in, redirect to login page
	if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="Customer"){
		header("Location: {$home_url}products.php?action=already_logged_in");
	}
}

else{
	// no problem, stay on current page
}
?>