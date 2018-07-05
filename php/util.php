<?php	/** --- util.php --- **/

/**
 * This function sanitize the string from possible problems.
 * @param $conn
 * @param $var
 * @return string
 */
function sanitizeString($conn, $var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	$var = mysqli_real_escape_string($conn, $var);
	return $var;
}

?>

<?php

/**
 * This function checks if all the values necessary for the registration of a new user are set in $_POST variable.<BR>
 * This function prints also on the client screen all the missing values.
 * @return bool - True if all the values are not empty, false otherwise.
 */
function validRegistrationValues()
{

	$toReturn = true;
	if (empty($_POST['email'])) {
		echo "<script>The username is not set!</p>";
		$toReturn = false;
	}
	if (empty($_POST['password'])) {
		echo "<p>The password is not set!</p>";
		$toReturn = false;
	}
	if (empty($_POST['conf_password'])) {
		echo "<p>You don't fill the field of confirmation password!</p>";
		$toReturn = false;
	}
	if ($_POST['conf_password'] !== $_POST['password']) {
		echo "<p> The 2 password must be equal!</p>";
		$toReturn = false;
	}
	return $toReturn;
}

/**
 * This function checks if all the values necessary for the reservation of new seats are set in $_POST variable.<BR>
 * Furthermore it checks the correctness of departure and destination.
 * @return bool - True if all the values are not empty and dep and dest correct, false otherwise.
 */
function validReservationValues()
{

	$toReturn = true;
	if (empty($_POST['dep'])) {
		$toReturn = false;
	}
	if (empty($_POST['dest'])) {
		$toReturn = false;
	}
	if (empty($_POST['n'])) {
		$toReturn = false;
	}
	if (strcmp($_POST['dep'], $_POST['dest'])> 0) {
		echo '<script type="text/javascript">window.alert("Invalid destinations order, please retype!");</script>';
		$toReturn = false;
	}


	return $toReturn;
}


/**
 * This function checks if all the values necessary for the login are set in $_POST variable.<BR>
 * @return bool - True if all the values are not empty, false otherwise.
 */
function validLoginValues()
{
	$toReturn = true;
	if (empty($_POST['email'])) {
		$toReturn = false;
	}
	if (empty($_POST['password'])) {
		$toReturn = false;
	}
	return $toReturn;
}
/**
 * This function checks if a username is already present in the database or not.
 * @param $conn - The connection to the database.
 * @param $table - The name of the table in which the check will be performed.
 * @param $username - The inserted username.
 * @return bool - True if the username doesn't exist, false otherwise.
 */
function validUserName($conn, $table, $username)
{
	$toReturn = false;
	$res = mysqli_query($conn, "SELECT * FROM $table WHERE email='$username'");
	if (!$res)
		echo "<p>Error during username checking!</p>";
	else {
		$row = mysqli_fetch_array($res);
		if (empty($row['email']))
			$toReturn = true;
	}
	mysqli_free_result($res);
	return $toReturn;
}
/**
 * This function checks if there is a user with the inserted Username and Password
 * @param $conn - The connection to the database.
 * @param $table - The name of the table in which the check will be performed.
 * @param $username - The inserted username.
 * @param $password - The inserted password.
 * @return bool - True if the username doesn't exist, false otherwise.
 */
function validLogin($conn, $table, $username, $password)
{
	$toReturn = true;
	$res = mysqli_query($conn, "SELECT * FROM $table WHERE email='$username' AND password='$password'");
	if ($res == false) {
		echo "<p>Error during username checking!</p>";
		$toReturn = false;
	} else {
		$row = mysqli_fetch_array($res);
		if ((empty($row['email'])) || (empty($row['password'])))
			$toReturn = false;
		if (($username != $row['email']) || ($password != $row['password']))
			$toReturn = false;
		mysqli_free_result($res);
	}
	return $toReturn;
}

/**
 * This function create a link to database, if it's impossible to create the connection or it's impossible to set the charset utf-8 the method return false.
 * Otherwise the method return the link to the connection
 * @param string $server
 * @param string $user
 * @param string $pass
 * @param string $database
 * @return boolean|object Returns an object that represent a link to the database, false if something wrong happens.
 */
function connectToDB($server, $user, $pass, $database)
{
	$conn = mysqli_connect($server, $user, $pass, $database);
	if ($conn == false) {
		echo "Connection Error (" . mysqli_connect_errno() . ")" . mysqli_connect_error();
		return false;
	}
	if (!mysqli_set_charset($conn, "utf8")) {
		echo "Error loading set utf8:" . mysqli_error($conn);
		mysqli_close($conn);
		return false;
	}

	return $conn;
}
?>
