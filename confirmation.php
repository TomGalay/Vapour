<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
    exit;
}

$game_purch = $_SESSION['game_purchase'];
echo $game_purch;

?>

<?php

require_once "config.php";


$sql_query = "SELECT * FROM game_catalog WHERE g_id='" . $game_purch . "'";

$result = $mysqli->query($sql_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="marketplace_styles.css">
    <?php
    include('styles.php'); //css for nav and footer
    include('format.php');
    ?>
    <title>Confirmation</title>
</head>

<body>

    <div class="background">
        <?php include('navbar.php'); ?>
        <!-- nav -->
        <div class="container checkout">
            <div class="nav-space"></div>
            <div class="page-title">
                <h1>Payment</h1>
            </div>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="payment">
                        <h2>Review Your Purchase Below</h2>
                        <div class="payment-img">
                            <img src="./assets/marketplace/portrait/<?php echo $row["g_id"] ?>.png" alt="">
                        </div>
                        <div class="nav-space"></div>
                        <div class="payment-text">
                            <div class="payment-order">
                                <p>Game Ordered: </p>
                                <p><?php echo $row["g_name"]; ?></p>
                            </div>
                            <div class="payment-price">
                                <p>Price: </p>
                                <p><?php echo formatPrice($row["g_price"]); ?></p>
                            </div>
                            <div class="payment-price">
                                <p>Payment Method: </p>
                                <p><?php echo $_SESSION['payment_method']; ?></p>
                            </div>
                            <div class="payment-price">
                                <p>Email: </p>
                                <p><?php echo $_SESSION['payment_email']; ?></p>
                            </div>
                        </div>
                        <div class="nav-space"></div>
                        <form class="col confirm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <p>
                                We’ve sent you an email with all the details
                                of your order!
                            </p>
                            <input class="btn-details" type="submit" value="Go Back">
                    </div>
                    </form>
        </div>
        <div class="nav-space"></div>
    </div>
<?php
                }
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                header("Location: ./marketplace.php");
                exit;
            }
            $mysqli->close();
?>

<?php include('footer.php'); ?>
<!-- footer -->
</div>
</body>

</html>