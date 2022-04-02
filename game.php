<?php
    session_start();
    ob_start();
    $game_purch = $_SESSION['game_purchase'];
?>


<?php

require_once "config.php";

$sql_query = "SELECT * FROM game_catalog WHERE g_id='".$game_purch."'";

$result = $mysqli->query($sql_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="marketplace_styles.css">
    <?php include('styles.php'); ?> <!-- css for nav and footer -->
    <title>Game</title>
</head>
<body>
    <div class="background">
        <?php include('navbar.php'); ?> <!-- nav -->
        <?php include ('format.php'); ?>
        <div class="container marketplace">
            <div class="nav-space"></div>
            <div class="page-title">
                <h1>Game</h1>
            </div>

            <?php
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            ?>

            <div class="col gap-3">
                <div class="game-header">
                    <div class="game-title">
                        <h2><?php echo $row["g_name"]; ?></h2>
                    </div>

                </div>
                <div class="featured-img">
                    <img src="./assets/marketplace/landscape/<?php echo $row["g_id"]; ?>.png" alt="">
                </div>
                <div class="col">
                    <div class="header">
                        <h2>Offers</h2>
                    </div>
                    <div class="row gap-2 game-offer-card">
                        <div class="card-info">
                            <div class="card-name">
                                <p><?php echo $row["g_name"]; ?></p>
                            </div>
                            <div class="card-price">
                                <p><?php echo formatPrice($row["g_price"]); ?></p>
                            </div>
                        </div>
                        <form action="payment.php">
                            <input class="btn-buy" type="submit" value="BUY NOW"/>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <div class="row game-details">
                        <div class="header">
                            <h2>About</h2>
                        </div>
                        <div class="col game-description">
                            <p class="game-info-band-aid">
                            <?php echo $row["g_desc"]; ?>
                            </p>
                        </div>
                        <div class="row game-info">
                            <div class="col game-info-band-aid">
                                <h3>Publisher</h3>
                                <p><?php echo $row["g_publisher"]; ?></p>
                            </div>
                            <div class="col game-info-band-aid">
                                <h3>Developer</h3>
                                <p><?php echo $row["g_publisher"]; ?></p>
                            </div>
                            <div class="col game-info-band-aid">
                                <h3>Genre</h3>
                                <p><?php echo $row["g_category"]; ?></p>
                            </div>
                            <div class="col game-info-band-aid">
                                <h3>Relase Date</h3>
                                <p><?php echo formatDate($row["g_release_date"]); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-space"></div>
        </div>

        <?php
        }
        } 
                
       
            
        $mysqli->close();
        ?>

        
    </div>
    <?php include('footer.php'); ?> <!-- footer -->
</body>
</html>