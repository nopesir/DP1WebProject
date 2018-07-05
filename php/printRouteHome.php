<?php

if(isset($db_host) && isset($db_user) && isset($db_pass) && isset($db_name)) {

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
// Check if there are rows
if ($result->num_rows > 0) {
    // Take all the result
    $res_array = $result->fetch_all(MYSQLI_ASSOC);
    $unset = 0;
    for ($i = 0; $i < $result->num_rows - 1; $i++) {

        if ($res_array[$i]["stop1"] == $res_array[$i + 1]["stop1"]) {
            if ($res_array[$i]["stop2"] == $res_array[$i + 1]["stop2"]) {
                $res_array[$i + 1]["n"] = $res_array[$i + 1]["n"] + $res_array[$i]["n"];

                unset($res_array[$i]);

                $unset = $unset + 1;
            }
        }
    }
    // Reorder the array without NULL values removed by the previous for-statement
    $res_array = array_values($res_array);
    echo '<div class="panel-group">';

    for ($j = 0; $j < $i + 1 - $unset; $j++) {
        if ($res_array[$j]["n"] != 0) {
            echo '<div class="panel panel-primary"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . $res_array[$j]["stop2"] . '</div>
        <div class="panel-body">There are ' . $res_array[$j]["n"] . ' on ' . MAXPASSENGERS . ' passengers</div> </div>';
        } else if (($j < $i - $unset) && $j != 0) {
            echo '<div class="panel panel-primary"><div class="panel-heading">' . $res_array[$j]["stop1"] . ' -> ' . $res_array[$j]["stop2"] . '</div>
        <div class="panel-body">There are no passengers</div> </div>';
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
}
else {
    echo "<script>window.location.href = '../index.php';</script>";
}
