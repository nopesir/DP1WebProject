<?php	/** --- logon.php --- **/
require_once 'sessionMandatory.php';
require_once 'intro.php';
require_once 'util.php';

if (isset($loggedIn) && ($loggedIn)) :
	echo '<script type="text/javascript">window.alert("You are already logged in!");window.location.href = "../index.php";</script>';
else :
	if (count($_POST) == 0)
	echo '<script type="text/javascript">window.alert("Please, click OK and Login!");window.location.href = "../index.php";</script>';
elseif (!validLoginValues())
	echo '<script type="text/javascript">window.alert("Data is missing, please click OK and Login!");window.location.href = "../index.php";</script>';
else {
	$conn = connectToDB($db_host, $db_user, $db_pass, $db_name);
	if ($conn != false) {
		$user = sanitizeString($conn, $_POST['email']);
		$pass = hash('sha512', $_POST['password']);	/* sha512 create the hash of the password */

		if (validLogin($conn, "users", $user, $pass)) {
			echo '<script type="text/javascript">alert("You have been successfully logged in, we will redirect you to your personal page!");</script>';
			$_SESSION['user254300'] = $user;
			$username = $user;
			$_SESSION['pass254300'] = $pass;
			$_SESSION['time254300'] = time();
			$loggedIn = true;
			echo '<script type="text/javascript">window.location.href = "../myarea.php";</script>';
		} else {
			echo '<script type="text/javascript">window.alert("Invalid username or password, please click OK and retry!");window.location.href = "../index.php";</script>';
		}

		mysqli_close($conn);
	}
}
endif;
?>

