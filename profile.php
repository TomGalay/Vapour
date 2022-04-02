<?php
//view user details
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
    exit;
}

//connect to database
require_once "config.php";

//asumming id and username is already in session
$param_id = $_SESSION['u_id'];
$sql = "SELECT tg_id FROM transaction_table WHERE tu_id = $param_id";
$array_from_query = $mysqli->query($sql);
$result = mysqli_fetch_all($array_from_query);


$sql_query = "SELECT u_created_at FROM user_accounts WHERE u_id = $param_id";

$result_query = mysqli_query($mysqli, $sql_query);

$array_from_query2 = mysqli_fetch_all($result_query);




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="marketplace_styles.css">
    <?php include('styles.php'); ?>
    <!-- css for nav and footer -->
    <title>Profile</title>
</head>

<body>
    <div class="background">
        <?php include('navbar.php'); ?>
        <!-- nav -->
        <div class="container marketplace gap-3">
            <div class="nav-space"></div>
            <div class="page-title">
                <h1>my profile</h1>
            </div>
            <div class="col">
                <div class="row profile-info">
                    <div class="profile-text">
                        <h3 class="profile-user"><?php echo $_SESSION['u_username']; ?></h3>
                        <p>user</p>
                    </div>
                    <div class="profile-text">
                        <h3 class="profile-bday">
                            <?php //echo $_SESSION['u_bday']; 
                            include('format.php');
                            foreach ($array_from_query2 as $arr) {
                                foreach ($arr as $var) {
                                    echo formatDate($var) . "<br>";
                                }
                            }
                            ?>

                        </h3>
                        <p>account created on</p>
                    </div>
                </div>
                <div class="nav-space"></div>
                <div class="row flex-wrap profile-list gap-3">

                    <div class="profile-game">
                        <div class="profile-text">
                            <p class="em">
                                Recently Played
                            </p>
                        </div>

                        <div class="row profile-game-list">
                            <?php
                            $index = 0;
                            $var = $result;
                            shuffle($var);
                            foreach ($var as $data) {
                                if ($index < 3) {
                                    foreach ($data as $info) {
                                        $index++; ?>
                                        <img src="./assets/marketplace/portrait/<?php echo $info ?>.png" alt="">
                            <?php
                                    }
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="col profile-text">
                        <div class="row">
                            <p class="em">No. of Games Owned: <?php echo $array_from_query->num_rows; ?></p>
                        </div>
                        <div class="row profile-game-list">
                            <?php
                            $index = 0;
                            foreach ($result as $data) {
                                foreach ($data as $info) {
                                    $index++; ?>
                                    <img src="./assets/marketplace/portrait/<?php echo $info ?>.png" alt="">
                            <?php
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-space"></div>
        <!-- footer -->
        <?php $mysqli->close(); ?>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>