<?php	/** --- myarea.php --- **/
	require_once 'php/sessionMandatory.php';
	require_once 'php/intro.php';
	require_once 'php/util.php';
?>

<!DOCTYPE html>


<html>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>SR MyArea</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="library/css/bootstrap.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/pagestyle.css">
        <link rel="stylesheet" href="css/loginmodal.css">

    </head>

    <body>
    <?php require_once 'php/noscript.php';	?>
        <!-- The entire document -->
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Shuttle's Reservations</h3>
                </div>
                <!-- Sidebar links -->
                <ul class="list-unstyled components">
                    <li  class="active">
                        <a href="myarea.php" >
                            <i class="glyphicon glyphicon-user"></i>
                            MyArea
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Page Content -->
            <div id="content">
                <!-- Navbar on top -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Navbar on top header -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">Home</a>
                        </div>
                        <!-- Navbar on top content -->
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="signup.php">Sign-up</a>
                            </li>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                            <button onclick="logout()" class="btn btn-primary navbar-btn">Logout</button>
                        </ul>
                    </div>
                </nav>

                <!-- Navbar content -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <?php require_once 'php/noscript.php';	?>
                        <?php 
                        $conn = connectToDB($db_host, $db_user, $db_pass, $db_name);
                        if ($conn==false) {
                            echo "error on connecting to database..";
                            echo "<script>location.href = 'index.php';</script";
                        }
                        ?>
                        <?php if(!$loggedIn): ?>
                        <script type="text/javascript">
                            window.alert("You are not logged in, please log-in first!");

                            location.href = "index.php";
                        </script>
                        <?php else: ?>
                        <div id="#mypage">
                            <h3 class="text-center">Personal page</h3>
                                <?php echo "<div class='text-center'> logged as <strong>$username</strong></div>"?>
                            <div class="line"></div>
                            <p>Welcome back! Here you can check the itinerary in details. Your book, if reserved, is showed in red.</p>
                            <br>
                            <?php if (!validUserName($conn, 'reservations', $username)) : mysqli_close($conn); ?>
                            <button onclick="cancel()" class="btn btn-primary navbar-btn">Cancel reservation</button>
                            <?php else: mysqli_close($conn); ?>
                            <button onclick='location.href="book.php";' class="btn btn-success navbar-btn">Book a reservation</button>
                            <?php endif ?>
                            <br></br>
                        </div>
                        <?php endif ?>
                        
                        <?php require_once 'php/printRouteMyArea.php';?>
                    </div>
                </nav>
            </div>
        </div>

        <!-- jQuery -->
        <script src="library/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="library/js/bootstrap.js"></script>

        <script src="js/checks.js"></script>
        <script type="text/javascript">
            function resetForm() {
                document.getElementById('UserData').reset();
                document.getElementById("textpwd").innerHTML = "";
            }
            function logout() {
                if(confirm("Are you sure if you want to logout?")) {
                location.href="php/logout.php";
                }
            }
            function cancel() {
                if(confirm("Are you sure if you want to delete?")) {
                location.href="php/cancel.php";
                }
            }
        </script>
    </body>
</html>