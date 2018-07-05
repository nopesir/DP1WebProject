<?php
require_once 'sessionMandatory.php';
require_once 'intro.php';
require_once 'util.php';

if ($loggedIn) {
    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
// Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql = "SELECT s1.name AS stop1, s2.name AS stop2, u.email AS email, t.number AS n
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
ORDER BY 1 ASC, 4 DESC
";

    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) {
    // Take all the result
        $res_array = $result->fetch_all(MYSQLI_ASSOC);
        $unset = 0;
        $npass = array_column($res_array, "n");
        $emails = array_column($res_array, "email");
        for ($i = 0; $i < sizeof($res_array) - 1; $i++) {

            if ($res_array[$i + 1]["email"] == $username) {
                $res_array[$i + 1]["email"] = '<div style="color:red;">' . $res_array[$i + 1]["email"] . '</div>';
            }
            if ($res_array[$i]["email"] == $username) {
                $res_array[$i]["email"] = '<div style="color:red;">' . $res_array[$i]["email"] . '</div>';
            } else {
                if (strpos($res_array[$i]["email"], $username) == false) {
                    $res_array[$i]["email"] = '<div >' . $res_array[$i]["email"] . '</div>';
                }
            }

            if (strpos($res_array[$i]["email"], "passengers:") == false) {
                $res_array[$i]["email"] = $res_array[$i]["email"] . '<div style="font-size: small;">' . '&nbsp;passengers: ' . $res_array[$i]["n"] . '</div>';
            }
            if (strpos($res_array[$i + 1]["email"], "passengers:") == false) {

                $res_array[$i + 1]["email"] = $res_array[$i + 1]["email"] . '<div style="font-size: small;">' . '&nbsp;passengers: ' . $res_array[$i + 1]["n"] . '</div>';
            }

            if ($res_array[$i]["stop1"] == $res_array[$i + 1]["stop1"]) {

                if (($res_array[$i]["stop2"] == $res_array[$i + 1]["stop2"])) {
                    if ($res_array[$i + 1]["n"] == 0) {
                        unset($res_array[$i + 1]);
                        $res_array = array_values($res_array);
                        $i = $i - 1;
                    } else {
                        $res_array[$i]["n"] = $res_array[$i]["n"] + $res_array[$i + 1]["n"];

                        $res_array[$i]["email"] = $res_array[$i]["email"] . $res_array[$i + 1]["email"];
                        unset($res_array[$i + 1]);
                        $res_array = array_values($res_array);
                        $i = $i - 1;

                    }
                }
            }
        }

        $res_array = array_values($res_array);
        for ($i = 0; $i < sizeof($res_array) - 1; $i++) {
            if (($res_array[$i]["stop1"] == $res_array[$i + 1]["stop1"])) {

                unset($res_array[$i + 1]);
                $res_array = array_values($res_array);
                $i = $i - 1;

            }
        }

    // Reorder the array without NULL values removed by the previous for-statement
        $res_array = array_values($res_array);

        echo '<div class="panel-group">';
        $check = false;
        for ($j = 0; $j < sizeof($res_array); $j++) {

            if ($res_array[$j]["n"] != 0) {
                if (strpos($res_array[$j]["email"], $username) !== false) {
                    if ($j == sizeof($res_array) - 1) {
                        if ((strpos($res_array[$j - 1]["email"], $username) !== false) && $res_array[$j - 1]["n"] != 0) {
                            echo '<div class="panel panel-warning"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop2"] . '</p>' . ' total: ' . $res_array[$j]["n"] . '</div>
                        <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                        } elseif ((strpos($res_array[$j - 1]["email"], $username) !== false && $res_array[$j - 1]["n"] == 0) || (strpos($res_array[$j - 1]["email"], $username) == false)) {
                            echo '<div class="panel panel-warning"><div class="panel-heading">' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop1"] . '</p>' . ' -> ' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop2"] . '</p>' . ' total: ' . $res_array[$j]["n"] . '</div>
                        <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                        } else {
                            echo '<div class="panel panel-default"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . $res_array[$j]["stop2"] . ' total: ' . $res_array[$j]["n"] . '</div>
                        <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                        }

                    } else if ($j == 0 && (strpos($res_array[$j + 1]["email"], $username) == false || $res_array[$j + 1]["n"] == 0)) {
                        echo '<div class="panel panel-warning"><div class="panel-heading">' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop1"] . '</p>' . ' -> ' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop2"] . '</p>' . ' total: ' . $res_array[$j]["n"] . '</div>
                    <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';

                    } else if (((strpos($res_array[$j + 1]["email"], $username) !== false) && !$check)) {
                        $check = true;
                        echo '<div class="panel panel-warning"><div class="panel-heading">' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop1"] . '</p>' . ' -> ' . $res_array[$j]["stop2"] . ' total: ' . $res_array[$j]["n"] . '</div>
                    <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                    } else {
                        if (strpos($res_array[$j + 1]["email"], $username) == false && strpos($res_array[$j - 1]["email"], $username) == false) {
                            echo '<div class="panel panel-warning"><div class="panel-heading">' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop1"] . '</p>' . ' -> ' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop2"] . '</p>' . ' total: ' . $res_array[$j]["n"] . '</div>
                        <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                        } elseif (strpos($res_array[$j + 1]["email"], $username) == false || $res_array[$j + 1]["n"] == 0) {
                            echo '<div class="panel panel-warning"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . '<p style="color:red;display:inline;">' . $res_array[$j]["stop2"] . '</p>' . ' total: ' . $res_array[$j]["n"] . '</div>
                    <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';

                        } else {
                            echo '<div class="panel panel-warning"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . $res_array[$j]["stop2"] . ' total: ' . $res_array[$j]["n"] . '</div>
                        <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                        }
                    }
                } else {
                    echo '<div class="panel panel-default"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . $res_array[$j]["stop2"] . ' total: ' . $res_array[$j]["n"] . '</div>
                <div class="panel-body">' . $res_array[$j]["email"] . '</div></div>';
                }
            } else if (($j < sizeof($res_array) - 1) && $j != 0) {
                echo '<div class="panel panel-default"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . $res_array[$j]["stop2"] . '</div>
        <div class="panel-body">There are no passengers</div></div>';
            }
        }
        echo '</div>';
    } else {
        echo "0 results";
    }

    unset($res_array);

// Free result set
    mysqli_free_result($result);

    mysqli_close($con);
} else {
    echo '<script type="text/javascript">window.alert("You are not logged in!");window.location.href = "../index.php";</script>';
}
