<?php	/** --- about.php --- **/
require_once 'php/session.php';
require_once 'php/intro.php';
require_once 'php/util.php';
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>SR About</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="library/css/bootstrap.css">
        <!-- Our Custom CSS -->
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
                    <li>
                        <a href="book.php">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Book
                        </a>
                    </li>
                    <li class="active">
                        <a href='about.php'>
                            <i class="glyphicon glyphicon-info-sign"></i>
                            About
                        </a>
                    </li>
                </ul>
                <?php if(!$loggedIn): ?>
                <ul class="list-unstyled CTAs">
                    <li>
                        <a href="#" class="login">Login</a>
                    </li>
                </ul>
                <?php endif?>
            </nav>

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
            </div> <!-- End login modal -->

            <!-- Page Content Holder -->
            <div id="content">
                <!-- Navbar Top Header -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">Home</a>
                        </div>
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
                            <button onclick="logout();" class="btn btn-primary navbar-btn">Logout</button>
                            <?php endif?>
                        </ul>
                    </div>
                </nav>

                <!-- Navbar content holder -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <h3 class="text-center">About</h3>
                        <div class="line"></div>
                        <p>This site is designed and developed by Luigi Ferrettino (s254300) as a final web assignement of the course of
                        Distributed Programming I a.a. 2017/18, offered at the Politenico di Torino in the first year of the Computer Engineering MSc.            
                        </p>
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
            // Toggle the login
            $(".login").on('click',function () {
                $('#login-modal').modal('show');
            })

            function logout() {
                // Ask for logout
                if(confirm("Are you sure if you want to logout?")) {
                    location.href="php/logout.php";
                }
            }
        </script>
    </body>
</html>