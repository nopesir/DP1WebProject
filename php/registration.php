<?php	/** --- registration.php --- **/
require_once 'sessionMandatory.php';
require_once 'intro.php';
require_once 'util.php';
require_once 'noscript.php';?>
    			<?php
if (count($_POST) === 0) {
    if (isset($loggedIn) && ($loggedIn)) {
        echo '<script type="text/javascript">window.alert("You are already logged in!");window.location.href = "../index.php";</script>';
    } else {
        echo '<script type="text/javascript">window.alert("Please, click OK and compile the registration form!");window.location.href = "../signup.php";</script>';
    }

} elseif (!validRegistrationValues()) {
    echo '<script type="text/javascript">window.alert("Invalid values, please retype!");window.location.href = "../signup.php";</script>';
} else {
    /** @var mysqli $conn */
    $conn = connectToDB($db_host, $db_user, $db_pass, $db_name);
    if ($conn !== false) {
        $user = sanitizeString($conn, $_POST['email']);
        $pass = hash('sha512', $_POST['password']); /* sha512 create the hash of the password, no sanitize needed */
        $confpass = hash('sha512', $_POST['confirmpwd']); /* sha512 create the hash of the confirm password, no sanitize needed */
        try {

            if (!validUserName($conn, 'users', $user)) {
                echo $user;
                echo '<script type="text/javascript">window.alert("The chosen username is already in use, please click OK a go to LOGIN!");window.location.href = "../index.php";</script>';
                exit();
            }

            if (!mysqli_autocommit($conn, false)) {
                throw new Exception("DEBUG - Impossible to set autocommit to FALSE");
            }

            $res = mysqli_query($conn, "SELECT * FROM users FOR UPDATE");
            if (!$res) /* LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access */ {
                throw new Exception("DEBUG - Query 1 (lock table) failed!");
            }

            mysqli_free_result($res);
            $res = mysqli_query($conn, "INSERT INTO users (email, password) VALUES ('$user', '$pass')");
            if (!$res) {
                throw new Exception("<p style='color:red'>Insertion avoided!</p>");
            }

            if (!mysqli_commit($conn)) {
                throw new Exception("<p style='color:red'>Impossible to commit the operation!</p>");
            }

            if (!mysqli_autocommit($conn, true)) {
                throw new Exception("DEBUG - Impossible to set autocommit to TRUE");
            }

        } catch (Exception $e) {
            mysqli_rollback($conn);
            mysqli_autocommit($conn, true);
            echo $e->getMessage();
        }
        mysqli_close($conn);
        echo '<script type="text/javascript">window.alert(' . '"' . $user . ' successfully registered!");window.location.href = "../index.php";</script>';
    }
}

?>