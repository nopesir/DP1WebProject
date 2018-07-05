<?php	/** --- sessionMandatory.php --- **/
session_start();
$SessionTime = 120;	#time in seconds (the requirement is 2 minutes)

require_once 'destroySession.php';

/** Check if the user is already loggedIn, if the timeout was expired the session is destroyed and the user will be redirect to the home page **/
if (isset($_SESSION['user254300'])) {
	$username = $_SESSION['user254300'];

	if (isset($_SESSION['time254300'])) {
		$diff = time() - $_SESSION['time254300'];	#difference between actual time and last interaction time
		if ($diff > $SessionTime) {
			$loggedIn = false;
			destroySession();
			header('HTTP/1.1 307 temporary redirect');	#redirect client to login page
			header('Location:index.php?msg=SessionTimeOutExpired');
			echo '<script type="text/javascript">window.alert("Please, click OK and compile the registration form!");window.location.href = "signup.php";</script>';
			exit;
		}
	}

	$_SESSION['time254300'] = time();
	$loggedIn = true;
} else
	$loggedIn = false;
?>