<?php

	ob_start();
	include 'includes/header.php'; 

	$buffer=ob_get_contents();
	ob_end_clean();

	$title = "Chairman's Bestfriend - Login";
	$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

	echo $buffer;  

	if ((isset($_POST['submit'])) && ($_SESSION['logged_in'] == false)) {

		$username= mysql_real_escape_string($_POST['username']);
		$password= mysql_real_escape_string($_POST['password']);
		$sha_password = sha1($password);		

		$login_query =  "SELECT * FROM users WHERE username= '" . $username . "'AND password= '" . $sha_password . "'LIMIT 1";

		$login_result = $connection->query($login_query);

		if ($connection->error) {
			print "Query error. Message: " . $connection->error;
		}

		if ($login_result->num_rows == 1) {

			$_SESSION['logged_in'] = true;
			$_SESSION['login_username'] = $row->username;

			print "<h3>You are now logged in " . $username . ". You will be redirected to the homepage in 5 seconds.</h3>";

			header("Refresh:5; url=home.php");

		}
	}

?>

<!-- Body -->
		<div class="container" id="content">
			<div class="row">
				<div class='row login-container'>
<?php

				if ($_SESSION['logged_in'] == true) {

					print ("

							<div class='one-half column'>
								<h2>Log Out</h2>
								<p>You are logged in, " . $username . ". To logout: </p>
								<a href='logout.php'><input class='button-primary create-account-button' type='submit' value='Logout'></a>								
							</div>						

					");					

				} else if ($_SESSION['logged_in'] == false) {

					print ("

							<div class='one-half column'>
								<h2>Log In</h2>
								<form name='login' action='login.php' method='POST'>
									<b>Username: </b><input class='u-full-width' type='text' name='username'><br/>
									<b>Password: </b><input class='u-full-width' type='password' name='password'><br/>
									<input id='button' class='button-primary' name='submit' id='submit' type='submit' value='Login'>
								</form>
							</div>	
					");					

				}
?>
					<div class='one-half column u-pull-right'>
						<h2>Create Account</h2>
							<p>Don't have an account? Create one here!</p>
							<a href='create_account.php'><input class='button-primary create-account-button' type='submit' value='Create Account'></a>
					</div>
				</div>
			 </div>
		</div>
<!-- /Body -->
		
<?php include 'includes/footer.php'; ?>