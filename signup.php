<?php	/** --- signup.php --- **/
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

        <title>SR Sign-up</title>

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
                    <li>
                        <a href="myarea.php">
                            <i class="glyphicon glyphicon-user"></i>
                            MyArea
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Book
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
                                <a href="myarea.php">MyArea</a>
                            </li>
                            <li>
                                <a href="signup.php">Sign-up</a>
                            </li>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <!-- Navbar content -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <?php if($loggedIn): ?>
                        <script type="text/javascript">
                            window.alert("You are already logged in, please logout first to sign-up!");
                            location.href = "index.php";
                        </script>
                        <?php else: ?>
                        <div class="row">
                            <div class="col-md-12" style="margin:0 auto;">
                                <!-- Form -->
                                <form role="form" method="POST" id="UserData" action="php/registration.php">
                                    <h3 class="text-center">Registration form</h3>

                                    <div class="line"></div>

                                    <div class="form-group col-md-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="Username" name="email" placeholder="Choose a valid email">
                                    </div>

                                    <div class="form-group col-md-6" oninput="return checkPassword()">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="PassSignin" name="password" placeholder="Choose a password">
                                    </div>

                                    <div class="form-group col-md-6" oninput="return checkPassword()">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="conf_password" id="ConfirmPassword" placeholder="Confirm password">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <p>NOTE: The password must contains at least one lower-case character
                                                and one number or one upper-case character</p>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <p id="textpwd" style="visibility: hidden;"></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" onclick="return checkRegistrationValues()">
                                                Register
                                            </button>
                                            <button type="reset" class="btn btn-primary" onclick="resetForm()">
                                                Reset
                                            </button>
                                            <a href="index.php">Already have an account?</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </nav>
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
        </script>

    </body>

</html>