<?php	/** --- logout.php --- **/
require_once 'sessionMandatory.php';
require_once 'intro.php';

if (!isset($loggedIn) || (!$loggedIn)) {
	echo '<script type="text/javascript">window.alert("You are not logged in!");window.location.href = "index.php";</script>';
	if (isset($TimeoutExpired) && ($TimeoutExpired))
		echo '<script type="text/javascript">alert("Timeout expired! You have not interacted with our server for too much time!"); window.location.href = "../index.php";</script>';
} else {
	destroySession();
	$goodbye = true;
	echo '<script type="text/javascript">window.location.href = "../index.php";</script>';
}

$loggedIn = false;

?>