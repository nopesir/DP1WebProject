<?php	/** --- cancel.php --- **/

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
			header('Location:../index.php?msg=SessionTimeOutExpired');
			echo '<script type="text/javascript">window.alert("Please, click OK and compile the registration form!");window.location.href = "signup.php";</script>';
			exit;
		}
	}

	$_SESSION['time254300'] = time();
	$loggedIn = true;
} else
	$loggedIn = false;


require_once 'intro.php';
require_once 'util.php';
require_once 'noscript.php';?>
    			<?php
if (isset($loggedIn) && ($loggedIn)) {

    /** @var mysqli $conn */
    $conn = connectToDB($db_host, $db_user, $db_pass, $db_name);
    if ($conn !== false) {
        try { //in other case it's also possible to use the LOCK but we don't have administrator's privilege

            if (validUserName($conn, 'reservations', $username)) {
                echo '<script type="text/javascript">window.alert("There is no reservation for user: ' . $username . '! Type OK and book it");window.location.href = "../book.php";</script>';
                exit();
            } else {
                if (!mysqli_autocommit($conn, false)) {
                    throw new Exception("DEBUG - Impossible to set autocommit to FALSE");
                }

                $res = mysqli_query($conn, "SELECT * FROM reservations FOR UPDATE");
                if (!$res) /* LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access */ {
                    throw new Exception("DEBUG - Query 1 (for update) failed!");
                }

                $res = mysqli_query($conn, "SELECT * FROM stops FOR UPDATE");
                if (!$res) /* LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access */ {
                    throw new Exception("DEBUG - Query 2 (for update) failed!");
                }

                $res = mysqli_query($conn, "DELETE FROM reservations WHERE reservations.email='$username'");
                if (!$res) {
                    throw new Exception("<p style='color:red'>Insertion avoided!</p>");
                }

                $res = mysqli_query($conn, "DELETE FROM stops WHERE NOT EXISTS (SELECT dep,dest FROM reservations WHERE dep=stops.name OR dest=stops.name)");
                if (!$res) {
                    throw new Exception("<p style='color:red'>Insertion avoided!</p>");
                }

                if (!mysqli_commit($conn)) {
                    throw new Exception("<p style='color:red'>Impossible to commit the operation!</p>");
                }

                if (!mysqli_autocommit($conn, true)) {
                    throw new Exception("DEBUG - Impossible to set autocommit to TRUE");
                }

                echo '<script type="text/javascript">window.alert("Successfully Cancelled!");</script>';

            }

        } catch (Exception $e) {
            mysqli_rollback($conn);
            mysqli_autocommit($conn, true);
            echo $e->getMessage();
        }

        mysqli_close($conn);
        echo '<script type="text/javascript">window.location.href = "../myarea.php";</script>';
    }
    else {
        
    }
}

?>