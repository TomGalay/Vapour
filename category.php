<?php
ob_start();
session_start();
include "getGenre.php";
$genre = getGenre($_SESSION['genre']);

require_once "config.php";

//$sql_query = 'SELECT * FROM game_catalog;';
$sql_query = "SELECT * FROM game_catalog WHERE g_category='" . $genre . "'";

$result_query = mysqli_query($mysqli, $sql_query);

$array_from_query = mysqli_fetch_all($result_query);

mysqli_free_result($result_query);

mysqli_close($mysqli);

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
    <title>Marketplace - <?php echo $genre ?></title>
</head>

<body>
    <div class="background">
        <?php include('format.php'); ?>
        <?php include('navbar.php'); ?>
        <!-- nav -->
        <div class="container marketplace gap-3">
            <div class="nav-space"></div>
            <div class="page-title">
                <h1>Marketplace</h1>
            </div>
            <?php if (!empty($array_from_query)) {

            ?>
                <div class="featured">
                    <div class="header">
                        <h2>Featured Today</h2>
                    </div>
                    <div class="featured-img">
                        <form class="featured-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <?php shuffle($array_from_query); ?>
                            <img src="./assets/marketplace/landscape/<?php echo $array_from_query[0][0]; ?>.png" alt="">
                            <div class="div">
                                <button class="btn-featured" type='submit' name='featured' value="<?php echo $array_from_query[0][0]; ?>"><?php echo $array_from_query[0][1]; ?></button>
                                <div class="info">
                                    <p><?php echo $array_from_query[0][5]; ?></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <form method='post'>
                <div class="categories">
                    <button class="btn-genre" type='submit' name='genre' value='12'>ALL</button>
                    <button class="btn-genre" type='submit' name='genre' value='1'>Action</button>
                    <button class="btn-genre" type='submit' name='genre' value='2'>Adventure</button>
                    <button class="btn-genre" type='submit' name='genre' value='3'>Casual</button>
                    <button class="btn-genre" type='submit' name='genre' value='4'>Indie</button>
                    <button class="btn-genre" type='submit' name='genre' value='5'>Multiplayer</button>
                    <button class="btn-genre" type='submit' name='genre' value='6'>Racing</button>
                    <button class="btn-genre" type='submit' name='genre' value='7'>RPG</button>
                    <button class="btn-genre" type='submit' name='genre' value='8'>Horror</button>
                    <button class="btn-genre" type='submit' name='genre' value='9'>Simulation</button>
                    <button class="btn-genre" type='submit' name='genre' value='10'>Sports</button>
                    <button class="btn-genre" type='submit' name='genre' value='11'>Strategy</button>
                </div>
            </form>

            <?php
            if (isset($_POST['genre']) && !empty($_POST['genre'])) {
                $genre = $_POST['genre'];
                if ($genre == 12) {
                    header("location:marketplace.php");
                    exit;
                } else {
                    $_SESSION['genre'] = $genre;
                    header("location:category.php");
                    exit;
                }
            }

            if (isset($_POST['featured']) && !empty($_POST['featured'])) {
                $purchase = $_POST['featured'];
                echo $purchase;
                $_SESSION['game_purchase'] = $purchase;
                header("location:game.php");
                exit;
            }
            ?>

            <div class="header">
                <h2><?php echo $genre; ?> Games</h2>
            </div>

            <div class="col">
                <div class="col gap-1">
                    <?php
                    $index = 0;
                    // prints the first three games
                    foreach ($array_from_query as $array) {
                    ?>
                        <!-- game div -->
                        <div class="game">
                            <div class="game-img">
                                <img src="./assets/marketplace/landscape/<?php echo $array[0] ?>.png" alt="">
                            </div>
                            <div class="game-text">
                                <div>
                                    <div class="game-title">
                                        <h3><?php echo $array[1] ?></h3>
                                    </div>
                                    <div class="col game-description">
                                        <p class="game-price"><?php echo formatPrice($array[7]) ?></p>
                                        <p>
                                            <?php echo $array[5] ?>
                                        </p>
                                    </div>
                                </div>

                                <form class="market-btn" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <?php echo "<button class=\"btn-buy\" type='submit' name='clickers' value= $array[0] >VIEW DETAILS</button>" ?>
                                    <?php echo "<button class=\"btn-details\" type='submit' name='game_clickers' value= $array[0]> BUY NOW </button>" ?>
                                </form>
                            </div>
                        </div>
                    <?php
                        $index++;
                        if (isset($_POST['clickers']) && !empty($_POST['clickers'])) {
                            $purchase = $_POST['clickers'];
                            echo $purchase;
                            $_SESSION['game_purchase'] = $purchase;
                            header("location:game.php");

                            exit;
                        }

                        if (isset($_POST['game_clickers']) && !empty($_POST['game_clickers'])) {
                            $purchase = $_POST['game_clickers'];
                            echo $purchase;
                            $_SESSION['game_purchase'] = $purchase;
                            header("location:payment.php");

                            exit;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="nav-space"></div>
        </div>
        
        
    </div>
    <?php include('footer.php'); ?> <!-- footer -->
</body>

</html>