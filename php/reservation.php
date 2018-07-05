<?php	/** --- reservation.php --- **/
require_once 'sessionMandatory.php';
require_once 'intro.php';
require_once 'util.php';
require_once 'noscript.php'; ?>

<?php

if (count($_POST) === 0) {
    echo '<script type="text/javascript">window.alert("Please, click OK and redo the booking form!");window.location.href = "../book.php";</script>';

} elseif (!validReservationValues()) {
    echo '<script type="text/javascript">window.location.href = "../book.php";</script>';
} else {
    /** @var mysqli $conn */
    $conn = connectToDB($db_host, $db_user, $db_pass, $db_name);
    if ($conn !== false) {
        $dep = sanitizeString($conn, $_POST['dep']);
        $dest = sanitizeString($conn, $_POST['dest']);
        $npass = sanitizeString($conn, $_POST['n']);


        try { 
            if (!mysqli_autocommit($conn, false)) {
                throw new Exception("DEBUG - Impossible to set autocommit to FALSE");
            }

            $res = mysqli_query($conn, "SELECT * FROM reservations FOR UPDATE");
            if (!$res) /* LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access */ {
                throw new Exception("DEBUG - Query 1 failed!");
            }

            $res = mysqli_query($conn, "SELECT * FROM stops FOR UPDATE");
            if (!$res) /* LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access */ {
                throw new Exception("DEBUG - Query 2 failed!");
            }

            $res = mysqli_query($conn, "SELECT * FROM users FOR UPDATE");
            if (!$res) /* LOCK in SHARE MODE - lock while the table in write mode for preventing a concurrency access */ {
                throw new Exception("DEBUG - Query 3 failed!");
            }

            $res = mysqli_query($conn, "SELECT * FROM stops WHERE stops.name='$dep'");
            if (!$res) {
                throw new Exception("<p style='color:red'>Insertion avoided!</p>");
            }
            $num_dep = $res->num_rows;

            $res = mysqli_query($conn, "SELECT * FROM stops WHERE stops.name='$dest'");
            if (!$res) {
                throw new Exception("<p style='color:red'>Insertion avoided!</p>");
            }
            $num_dest = $res->num_rows;


            $res = mysqli_query($conn, "SELECT * FROM stops WHERE stops.name>='$dep' AND stops.name<='$dest' ORDER BY name");
            if (!$res) {
                throw new Exception("<p style='color:red'>Insertion avoided!</p>");
            }
            $num = $res->num_rows;
            $stops = mysqli_fetch_all($res,MYSQLI_ASSOC);

            $query = "SELECT stop1 AS st1,stop2 AS st2, SUM(n) AS npass FROM (SELECT s1.name AS stop1, s2.name AS stop2, u.email AS email, t.number AS n
            FROM stops s1, stops s2, reservations t, users u
            WHERE   u.email = t.email
            AND s2.name = (SELECT MIN(name) FROM stops s3 where s3.name > s1.name)
            AND (   (     t.dep <=s1.name
            AND  t.dep < s2.name)
            AND (     t.dest > s1.name
            AND t.dest >=s2.name))
            UNION
            SELECT s1.name, s2.name, u.email, 0
            FROM stops s1, stops s2, reservations t, users u
            WHERE u.email = t.email
            AND s2.name = (SELECT MIN(name) FROM stops s3 where name > s1.name)
            AND ( t.dep = s1.name OR   t.dep = s2.name OR t.dest = s1.name OR t.dest=s2.name)
            ORDER BY 1 asc,4 DESC) AS temp
            GROUP BY st1,st2;";

            $res = mysqli_query($conn, $query);
            if (!$res) {
                throw new Exception("<p style='color:red'>Insertion avoided!</p>");
            }

            $reserv = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $toomany = false;
            for ($i = 0; $i < sizeof($reserv); $i++) {
                for ($j = 0; $j < $num; $j++) {
                    if ($reserv[$i]["st1"] == $stops[$j]["name"]) {
                        if ($reserv[$i]["npass"] + $npass > MAXPASSENGERS) {
                            $toomany = true;
                        }
                    }
                    if ($reserv[$i]["st2"] == $stops[$j]["name"]) {
                        if ($reserv[$i]["npass"] + $npass > MAXPASSENGERS) {
                            $toomany = true;
                        }
                    }
                }
            }

            if (!$toomany) {
                $res = mysqli_query($conn, "INSERT INTO reservations (email, dep, dest, number) VALUES ('$username', '$dep','$dest','$npass')");

                if (!$res) {
                    throw new Exception("<p style='color:red'>Insertion avoided!</p>");
                }


                if ($num_dep == 0) {
                    $res = mysqli_query($conn, "INSERT INTO stops (name) VALUES ('$dep')");
                    if (!$res) {
                        throw new Exception("<p style='color:red'>Insertion avoided!</p>");
                    }
                }

                if ($num_dest == 0) {
                    $res = mysqli_query($conn, "INSERT INTO stops (name) VALUES ('$dest')");
                    if (!$res) {
                        throw new Exception("<p style='color:red'>Insertion avoided!</p>");
                    }
                }

                // All done, commit changes to the DB
                if (!mysqli_commit($conn)) {
                    throw new Exception("<p style='color:red'>Impossible to commit the operation!</p>");
                }


                if (!mysqli_autocommit($conn, true)) {
                    throw new Exception("DEBUG - Impossible to set autocommit to TRUE");
                }
                echo '<script type="text/javascript">window.alert("Successfully booked!");</script>';
            } else {
                mysqli_rollback($conn);
                mysqli_autocommit($conn, true);
                echo '<script type="text/javascript">window.alert("Error! Too many passengers, redo and choose less seats!");window.location.href = "../book.php";</script>';
            }



        } catch (Exception $e) {
            mysqli_rollback($conn);
            mysqli_autocommit($conn, true);
            echo $e->getMessage();
        }
        mysqli_close($conn);
        echo '<script type="text/javascript">window.location.href = "../myarea.php";</script>';
    }
}

?>