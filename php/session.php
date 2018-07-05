<?php	/** --- session.php --- **/
session_start();
$SessionTime = 120;	#time in seconds (the requirement is 2 minutes)

require_once 'destroySession.php';

/** Check if the user is already loggedIn, if the timeout was expired the session is destroyed **/
if (isset($_SESSION['user254300'])) {
	$username = $_SESSION['user254300'];
	$loggedIn = true;

	if (isset($_SESSION['time254300'])) {
		$diff = time() - $_SESSION['time254300'];	#difference between actual time and last interaction time
		if ($diff > $SessionTime) {
			$loggedIn = false;
			destroySession();
			$TimeoutExpired = true;
		} else
			$_SESSION['time254300'] = time();
	} else
		$_SESSION['time254300'] = time();
} else
	$loggedIn = false;
?>