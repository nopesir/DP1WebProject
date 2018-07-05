<?php	/** --- index.php --- **/
require_once 'php/session.php';
require_once 'php/intro.php';
require_once 'php/util.php';
?>

<!DOCTYPE html>

<html>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SR Home</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="library/css/bootstrap.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="css/pagestyle.css">
        <link rel="stylesheet" type="text/css" href="css/loginmodal.css">

    </head>

    <body>
    <?php require_once 'php/noscript.php';?>
        
        <!-- The entire document -->
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Header -->
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
                    <li>
                        <a href="book.php">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Book
                        </a>
                    </li>
                    <li>
                        <a href='about.php'>
                            <i class="glyphicon glyphicon-info-sign"></i>
                            About
                        </a>
                    </li>
                </ul>
                <!-- Insert the login button if not logged in -->
                <?php if(!$loggedIn): ?>
                <ul class="list-unstyled CTAs">
                    <li>
                        <a  href="#" class="login">Login</a>
                    </li>
                </ul>
                <?php endif?>
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
                                <a href="myarea.php">MyArea</a>
                            </li>
                            <li>
                                <a href="signup.php">Sign-up</a>
                            </li>
                            <?php if(!$loggedIn): ?>
                            <li>
                                <a href="#" class="login">Login</a>
                            </li>
                            <?php endif ?>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                            <?php if($loggedIn): ?>
                            <button onclick="logout()" class="btn btn-primary navbar-btn">Logout</button>
                            <?php endif?>
                        </ul>
                    </div>
                </nav> <!-- End navbar on top content -->

                <!-- Login modal -->
                <div class="modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div id="#homepage" class="modal-dialog">
                        <div class="loginmodal-container">
                            <h1>Login</h1>
                            <br>
                            <form method="post" action="php/logon.php">
                                <input type="email" name="email" id="Username" placeholder="Email">
                                <input type="password" name="password" id="LoginPassword" placeholder="Password">
                                <input type="submit" name="login" class="btn btn-primary btn-lg" onclick="return checkLoginValues()" value="Login">
                            </form>

                            <div class="login-help">
                                <a href="signup.php">Register</a>
                            </div>
                        </div>
                    </div>
                </div><!-- End login modal -->

                <!-- Navbar content -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <h3 class="text-center">Shuttle's itinerary</h3>
                        <div class="line"></div>
                        <p> Here you can check the actual state of the itinerary. In order to book please go into your personal
                            Area, or sign-up by clicking on the proper button.</p>
                        <br></br>
                                    
                        <?php require_once 'php/printRouteHome.php';?>
                            
                        <?php
                            // Check for the timeout expiring
                            if( (isset($_GET["msg"])) && ($_GET["msg"]=="SessionTimeOutExpired") ) {
                                echo '<script type="text/javascript">window.alert("Session expired! You have not interacted for too much time!");</script>';
                            }
                        ?>
                    </div>
                </nav> <!-- End navbar content -->
            </div> <!-- End page content -->
        </div> <!-- End entire document -->

        <!-- jQuery -->
        <script src="library/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="library/js/bootstrap.js"></script>
        <script src="js/checks.js"></script>
        <script type="text/javascript">
            
            // Toggle the login
            $(".login").on('click',function () {
                $('#login-modal').modal('show');
            })
            
            // On logout click
            function logout() {
                if(confirm("Are you sure if you want to logout?")) {
                    location.href="php/logout.php";
                }
            }
        </script>
    </body>

</html>