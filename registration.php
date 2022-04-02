<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: marketplace.php");
    exit;
}
?>

<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="registration_styles.css" rel="stylesheet">
    <?php include('styles.php'); ?>
    <!-- css for nav and footer -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <title>Vapour Registration Page</title>
</head>

<body>
    <?php
    include('navbar.php');
    ?>
    <div class="container">
        <div class="header">
            <h1>Create your new account</h1>
        </div>
        <div class="forms">
            <form method="post">
                <div class="full-name">
                    <div class="first-name">
                        <label for="fname">First Name:</label>
                        <input type="text" name="fname" required>
                    </div>
                    <div class="last-name">
                        <label for="lname">Last Name:</label>
                        <input type="text" name="lname" required>
                    </div>
                </div>
                <div class="username">
                    <label for="uname">Username:</label>
                    <input type="text" name="uname" required>
                </div>
                <div class="pass">
                    <label for="pass">Password (Enter atleast 6 letters):</label>
                    <input type="password" name="pass" required>
                </div>
                <div class="confirm-pass">
                    <label for="c-pass">Confirm Password:</label>
                    <input type="password" name="c-pass" required>
                </div>
                <div class="dob">
                    <label for="date">Birthday:</label>
                    <input type="date" name="date" required>
                </div>
                <div class="email">
                    <label for="email">Email:</label>
                    <input type="text" name="email" required>
                </div>
                <div class="contact">
                    <label for="cont">Contact Number:</label>
                    <input type="text" name="cont" required>
                </div>
                <p id="valid"></p>
                <div class="registerbtn">
                    <input type="hidden" name="form_submitted" value="1">
                    <input type="submit" value="Submit">
                </div>
                <div class="log-in">
                    <h2>Already have an account?</h2>
                    <a href="login.php">Sign In</a>
                </div>
            </form>
            <?php
            // Processing form data when form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Validate username
                if (empty(trim($_POST["uname"]))) {
                    $username_err = "Please enter a username.";
                    echo "<script>document.getElementById(\"valid\").innerHTML = \"$username_err\";</script>";
                } else {
                    // Prepare a select statement
                    $sql = "SELECT u_id FROM user_accounts WHERE u_username = ?";

                    if ($stmt = $mysqli->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $param_username);

                        // Set parameters
                        $param_username = trim($_POST["uname"]);

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // Store result
                            $stmt->store_result();
                            if ($stmt->num_rows == 1) {
                                $username_err = "This username is already taken.";
                                echo "<script>document.getElementById(\"valid\").innerHTML = \"$username_err\";</script>";
                            } else {
                                $username = trim($_POST["uname"]);
                            }
                        } else {
                            echo "<script>document.getElementById(\"valid\").innerHTML = \"Oops! Something went wrong. Please try again later.\";</script>";
                        }
                        // Close statement
                        $stmt->close();
                    }
                }

                // Validate password
                if (empty(trim($_POST["pass"]))) {
                    $password_err = "Please enter a password.";
                    echo "<script>document.getElementById(\"valid\").innerHTML = \"$password_err\";</script>";
                } elseif (strlen(trim($_POST["pass"])) < 6) {
                    $password_err = "Password must have atleast 6 characters.";
                    echo "<script>document.getElementById(\"valid\").innerHTML = \"$password_err\";</script>";
                } else {
                    $password = trim($_POST["pass"]);
                }

                // Validate confirm password
                if (empty(trim($_POST["c-pass"]))) {
                    $confirm_password_err = "Please confirm password.";
                    echo "<script>document.getElementById(\"valid\").innerHTML = \"$confirm_password_err\";</script>";
                } else {
                    $confirm_password = trim($_POST["c-pass"]);
                    if (empty($password_err) && ($password != $confirm_password)) {
                        $confirm_password_err = "Password did not match.";
                        echo "<script>document.getElementById(\"valid\").innerHTML = \"$confirm_password_err\";</script>";
                    }
                }

                // Check input errors before inserting in database
                if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
                    // Prepare an insert statement
                    $sql = "INSERT INTO user_accounts (u_fname, u_lname, u_username, u_password, u_bday,
                                            u_email, u_cnumber, u_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                    if ($stmt = $mysqli->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param(
                            "ssssssss",
                            $u_fname,
                            $u_lname,
                            $param_username,
                            $param_password,
                            $u_bday,
                            $u_email,
                            $u_cnumber,
                            $u_level
                        );

                        // Set parameters
                        $u_fname = $_POST["fname"];
                        $u_lname = $_POST["lname"];
                        $param_username = $username;
                        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                        $u_bday = $_POST["date"];
                        $u_email = $_POST["email"];
                        $u_cnumber = $_POST["cont"];
                        $u_level = "user";

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // Redirect to login page
                            header("location: login.php");
                        } else {
                            echo "<script>document.getElementById(\"valid\").innerHTML = \"Oops! Something went wrong. Please try again later.\";</script>";
                        }

                        // Close statement
                        $stmt->close();
                    }
                }

                // Close connection
                $mysqli->close();
            }

            ?>
        </div>
    </div>
    <div class="custom-shape-divider-bottom-1616380876">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>
    <?php
    include('footer.php');
    ?>
</body>

</html>