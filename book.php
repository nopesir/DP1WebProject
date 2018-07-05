<?php	/** --- book.php --- **/
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

        <title>SH Book</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="library/css/bootstrap.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/pagestyle.css">
        <link rel="stylesheet" href="css/loginmodal.css">

    </head>

    <body>
        <!-- The entire document -->
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <!-- Sidebar header -->
                <div class="sidebar-header">
                    <h3>Shuttle's Reservations</h3>
                </div>
                <!-- Sidebar links -->
                <ul class="list-unstyled components">
                    <li>
                        <a href="myarea.php">
                            <i class="glyphicon glyphicon-user"></i>
                            MyArea
                        </a>
                    </li>
                    <li class="active">
                        <a href="book.php">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Book
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Page Content -->
            <div id="content">
                <?php require_once 'php/noscript.php'; ?>
                <!-- Navbar on top -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Navbar header on top -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">Home</a>
                        </div>
                        <!-- Navbar content on top -->
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="myarea.php">MyArea</a>
                            </li>
                            <li>
                                <a href="signup.php">Sign-up</a>
                            </li>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                            <button onclick="logout();" class="btn btn-primary navbar-btn">Logout</button>
                        </ul>
                    </div>
                </nav>  
                            
                <?php 
                $conn = connectToDB($db_host, $db_user, $db_pass, $db_name);
                if ($conn==false) {
                    echo "error on connecting to database..";
                    echo "<script>location.href = 'index.php';</script";
                }
                ?>
                <?php if (!$loggedIn) : ?>
                <script type="text/javascript">
                    window.alert("You are not logged in, please log-in first!");
                    location.href = "index.php";
                </script>
                <?php elseif (!validUserName($conn, 'reservations', $username)) : mysqli_close($conn); ?>
                
                <script type="text/javascript">
                    window.alert("You have already booked a ride, to change delete it first from your personal area!");
                    window.location.href = "myarea.php";
                </script>';
                <?php else : mysqli_close($conn); ?>
                <!-- Navbar content -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <h3 class="text-center">Book a ride</h3>
                        <?php echo "<div class='text-center'> logged as <strong class='greenalert'>$username</strong></div>" ?> 
                        <br></br>
                        <div class="line"></div>
                        <p>Book a reservation. For departure and destination, typer yours or choose between the ones already booked by others.</p>
                        <div class="row">
                            <div class="col-md-12" style="margin:0 auto;">
                                <!-- Form -->
                                <form role="form" method="POST" id="BookData" onsubmit="return confirm('Are you sure if you want to send the request?')" action="php/reservation.php">        
                                    <div class="form-group col-md-5" oninput="return checkDest()">
                                        <label for="dep">Departure</label>
                                        <input type="text" class="form-control" id="TextDep" name="dep" list="departure_list" placeholder="Type a departure">
                                        <datalist id="departure_list">
                                            <?php include 'php/takestops.php' ?>
                                        </datalist>
                                    </div>

                                    <div class="form-group col-md-5" oninput="return checkDest()">
                                        <label for="dest">Destination</label>
                                        <input type="text" class="form-control" id="TextDest" name="dest" list="departure_list" placeholder="Type a destination">
                                    </div>

                                    <div class="form-group col-md-2" oninput="return checkNPass(<?php echo MAXPASSENGERS ?>)">
                                        <label for="sel1">Number of seats</label>
                                        <input type="number" class="form-control" id="TextNPass" name="n" placeholder="Type seats">
                                    </div>

                                    <div class="form-group col-md-10 text-right">
                                        <p id="textpwd-3" style="visibility: hidden;"></p>
                                    </div>

                                    <div class="form-group col-md-2 text-right">
                                        <p id="textpwd-2" style="visibility: hidden;"></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12 text-left">
                                            <button type="submit" class="btn btn-primary" onclick="return (checkDest() && checkNPass(<?php echo MAXPASSENGERS ?>))">
                                                Book
                                            </button>
                                            <button type="reset" class="btn btn-primary" onclick="resetBook()">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php endif ?>
                        </div>
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
            // Reset the form
            function resetBook() {
                document.getElementById('BookData').reset();
                document.getElementById("textpwd-2").style.visibility = "hidden";
                document.getElementById("textpwd-3").style.visibility = "hidden";
            }
            function logout() {
                if(confirm("Are you sure if you want to logout?")) {
                    location.href="php/logout.php";
                }
            }
        </script>                                

        </body>
</html>