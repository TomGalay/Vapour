<?php
ob_start();
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
    <title>Payment</title>
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
            $var = "";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $var = $row["g_id"];
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
                        </div>
                        <div class="nav-space"></div>
                        <h2>Select Payment Options</h2>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="col gap-1">
                                <div class="row payment-option">
                                    <div class="row gap-3">
                                        <img src="./assets/payment/online.png" alt="">
                                        <div class="choice row gap-1">
                                            <img src="./assets/payment/online-1.png" alt="">
                                            <img src="./assets/payment/online-2.png" alt="">
                                        </div>
                                    </div>
                                    <input type="radio" name="payment" value="Online" required>
                                </div>
                                <div class="row payment-option">
                                <div class="row gap-3">
                                        <img src="./assets/payment/card.png" alt="">
                                        <div class="choice row gap-1">
                                            <img src="./assets/payment/card-1.png" alt="">
                                            <img src="./assets/payment/card-2.png" alt="">
                                        </div>
                                    </div>
                                    <input type="radio" name="payment" value="Credit Card" required>
                                </div>
                                <div class="row payment-option">
                                <div class="row gap-3">
                                        <img src="./assets/payment/deposit.png" alt="">
                                        <div class="choice row gap-1">
                                        <img src="./assets/payment/dep-1.png" alt="">
                                        <img src="./assets/payment/dep-2.png" alt="">
                                        <img src="./assets/payment/dep-3.png" alt="">
                                        <img src="./assets/payment/dep-4.png" alt="">
                                        <img src="./assets/payment/dep-5.png" alt="">
                                        <img src="./assets/payment/dep-6.png" alt="">
                                        </div>
                                    </div>
                                    <input type="radio" name="payment" value="Deposit" required>
                                </div>
                            </div>
                            <div class="nav-space"></div>
                            <div class="col payment-email">
                                <h3>Enter Your Email Address</h3>
                                <p id="valid" style="color: #ec6565;"></p>
                                <div class="col gap-1 center">
                                    <input type="text" name="email" required>
                                    <input class="btn-buy" type="submit">
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="nav-space"></div>
        </div>
<?php
                }
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                function postVal($val)
                {
                    return isset($_POST[$val]) ? $_POST[$val] : null;
                }
                $payment = postVal('payment');
                $email = postVal('email');
                $_SESSION['payment_method'] = $payment;
                $_SESSION['payment_email'] = $email;

                $check_id = $_SESSION["u_id"];

                $sql = "SELECT t_id FROM transaction_table WHERE tu_id = $check_id AND tg_id = $var";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    $err = "You already own this game";
                    echo "<script>document.getElementById(\"valid\").innerHTML = \"$err\";</script>";
                } else {
                    $sql = "INSERT INTO transaction_table (tu_id, tg_id) VALUES (?, ?)";

                    if ($stmt = $mysqli->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("ss", $tu_id, $tg_id);

                        // Set parameters
                        $tu_id = $_SESSION["u_id"];
                        $tg_id = $var;

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // Redirect to login page
                            header("location: confirmation.php");
                            exit;
                        } else {
                            echo "<script>document.getElementById(\"valid\").innerHTML = \"Oops! Something went wrong. Please try again later.\";</script>";
                        }

                        // Close statement
                        $stmt->close();
                    }
                }
            }
            $mysqli->close();
?>

<?php include('footer.php'); ?>
<!-- footer -->
    </div>
</body>

</html>