<?php   /** --- takestops.php --- **/
require_once 'util.php';

$con = connectToDB($db_host, $db_user, $db_pass, $db_name);

$query = "SELECT * FROM stops";

if ($result = mysqli_query($con, $query)) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option>' . $row["name"] . '</option>';
    }

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($link);
?>