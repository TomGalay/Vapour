<?php
// Initialize the session
ob_start();
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: marketplace.php");
    exit;
}

// Include config file
require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login_styles.css" rel="stylesheet">
    <?php include('styles.php'); ?>
    <!-- css for nav and footer -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <title>Vapour Login</title>
</head>

<body>
    <?php include('navbar.php'); ?>
    <!-- nav -->
    <div class="custom-shape-divider-top-1616334821">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>
    <div class="container">
        <div class="header">
            <h1>Log in to your account</h1>
        </div>
        <div class="forms">
            <form method="post">
                <div class="username">
                    <input type="text" placeholder="Username" name="uname" autocomplete="off">
                </div>
                <div class="pass">
                    <input type="password" placeholder="Password" name="pass">
                </div>
                <div class="remember">
                    <input id="one" type="checkbox">
                    <span class="check"></span>
                    <label for="one">Remember Me</label>
                </div>
                <p id="valid"></p>
                <div class="registerbtn">
                    <input type="hidden" name="form_submitted" value="1">
                    <input type="submit" value="Log In">
                </div>
                <div class="register">
                    <h2>Don't have an account yet?</h2>
                    <a href="registration.php">Register Now</a>
                </div>
            </form>
            <?php

            // Define variables and initialize with empty values
            $username = $password = "";
            $username_err = $password_err = "";

            // Processing form data when form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Check if username is empty
                if (empty(trim($_POST["uname"]))) {
                    $username_err = "Please enter username.";
                } else {
                    $username = trim($_POST["uname"]);
                }

                // Check if password is empty
                if (empty(trim($_POST["pass"]))) {
                    $password_err = "Please enter your password.";
                } else {
                    $password = trim($_POST["pass"]);
                }

                // Validate credentials
                if (empty($username_err) && empty($password_err)) {
                    // select statement
                    $sql = "SELECT u_id, u_fname, u_lname, u_username, u_password, u_bday,
                        u_email, u_cnumber, u_level FROM user_accounts WHERE u_username = ?";

                    if ($stmt = $mysqli->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $param_username);

                        // Set parameters
                        $param_username = $username;

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // Store result
                            $stmt->store_result();

                            // Check if username exists, if yes then verify password
                            if ($stmt->num_rows == 1) {
                                // Bind result variables
                                $stmt->bind_result($id, $fname, $lname, $username, $hashed_password, $bday, $email, $cnumber, $level);
                                if ($stmt->fetch()) {
                                    if (password_verify($password, $hashed_password)) {
                                        // Password is correct, so start a new session
                                        session_start();

                                        $sql = "SELECT u_id, u_fname, u_lname, u_username, u_password, u_bday, 
                            u_email, u_cnumber, u_level FROM user_accounts WHERE u_username = ?";

                                        // Store data in session variables
                                        $_SESSION["loggedin"] = true;
                                        $_SESSION["u_id"] = $id;
                                        $_SESSION["u_fname"] = $fname;
                                        $_SESSION["u_lname"] = $lname;
                                        $_SESSION["u_username"] = $username;
                                        $_SESSION["u_password"] = $password;
                                        $_SESSION["u_bday"] = $bday;
                                        $_SESSION["u_email"] = $email;
                                        $_SESSION["u_cnumber"] = $cnumber;
                                        $_SESSION["u_level"] = $level;

                                        if ($_SESSION["u_level"] == "admin") {
                                            header("location: admin_home.php");
                                            exit;
                                        }

                                        // Redirect user to welcome page
                                        header("location: marketplace.php");
                                        exit;
                                    } else {
                                        // Display an error message if password is not valid
                                        $password_err = "The password you entered was not valid.";
                                        echo "<script>document.getElementById(\"valid\").innerHTML = \"$password_err\";</script>";
                                    }
                                }
                            } else {
                                // Display an error message if username doesn't exist
                                $username_err = "No account found with that username.";
                                echo "<script>document.getElementById(\"valid\").innerHTML = \"$username_err\";</script>";
                            }
                        } else {
                            echo "<script>document.getElementById(\"valid\").innerHTML = \"Oops! Something went wrong. Please try again later.\";</script>";
                        }

                        // Close statement
                        $stmt->close();
                    } else {
                        echo "ERROR: Could not connect. ";
                    }
                }

                // Close connection
                $mysqli->close();
            }

            ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <!-- footer -->
    </div>
</body>

</html>