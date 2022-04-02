<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
    exit;
}

$list_games_owned = array();
$button_value = 0;

/* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'vapourDB');

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

//asumming id and username is already in session
$param_id = $_SESSION['u_id'];
$sql = "SELECT tg_id FROM transaction_table WHERE tu_id = '$param_id'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $param_g_id = $row['tg_id'];
        $sql_search = "SELECT g_id, g_name, g_publisher, g_developer, g_img, g_desc, g_release_date, g_price 
                            FROM game_catalog WHERE g_id = $param_g_id";
        $result_search = $mysqli->query($sql_search);
        $row_search = $result_search->fetch_assoc();

        //insert into array 
        $temp_array = array(
            $row_search['g_id'], //0
            $row_search['g_name'], //1
            $row_search['g_publisher'], //2
            $row_search['g_developer'], //3
            $row_search['g_img'], //4
            $row_search['g_desc'], //5
            $row_search['g_release_date']
        ); //6

        array_push($list_games_owned, $temp_array); //list of games as array

        //

    }
} else {
    $isEmptyGames = true;
}
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="marketplace_styles.css">
    <?php include('styles.php'); ?>
    <!-- css for nav and footer -->
    <link href="library_styles.css" rel="stylesheet">
    <title>Library</title>

    <?php
    $isEmptyGames = false;
    if (count($list_games_owned) == 0)
        $isEmptyGames = true;
    else
        $isEmptyGames = false;
    ?>

</head>

<body>
    <div class="background">
        <?php include('navbar.php'); ?>
        <!-- nav -->
        <div class="container marketplace gap-3">
            <div class="nav-space"></div>
            <div class="page-title">
                <h1>Library</h1>
                <?php
                if ($isEmptyGames == true) {
                    echo "<p>It seems you do not have any games yet!</p>
                <p>Hop on to the <a href=\"./marketplace.php\">market</a> and get some games!</p>";

                    echo "</div>";
                } else {
                ?>
            </div>

            <div class="row library flex-wrap">
                <!--<form class="row gap-1" >-->
                <?php
                    foreach ($list_games_owned as $games) { ?>
                    <div class="card-img">
                        <img src=<?php echo "\"./assets/marketplace/portrait/" . $games[0] . ".png\""; ?> alt="">
                        <div class="div_button hide-name">
                            <button class="btnsubmit" name="card" value=<?php echo $games[0]; ?>>
                                <p class=""><?php echo $games[1]; ?></p>
                            </button>
                        </div>

                    </div>

                    <!-- The Modal -->
                    <div class="modal" id=<?php echo "\"myModal" .  $games[0] . "\""; ?>>
                        <!-- Modal content -->
                        <div class="row modal-content">
                            <div class="image_modal_game">
                                <img src=<?php echo "\"./assets/marketplace/landscape/" . $games[0] . ".png\""; ?> alt="">
                            </div>
                            <div class="row modal-name">
                                <h3 class="game-title"><?php echo $games[1]; ?></h3>
                                <button class="btn-play">Play Now</button>
                            </div>

                            <div class="col">
                                <h3>Description</h3>
                                <p><?php echo $games[5]; ?></p>
                            </div>

                            <div class="col">
                                <h3>Developer</h3>
                                <p><?php echo $games[3]; ?></p>
                            </div>

                            <div class="col">
                                <h3>Publisher</h3>
                                <p><?php echo $games[2]; ?></p>
                            </div>

                            <div class="col">
                                <h3>Release Date</h3>
                                <p><?php echo $games[6]; ?></p>
                            </div>

                            <div class="btns_choice">

                            </div>

                            <span class="close">&times;</span>
                        </div>
                    </div>
                <?php
                    }
                ?>


                <!--<?php
                    if (isset($_POST['card']) && !empty($_POST['card'])) {
                        $button_post = $_POST['card'];
                    }
                    ?> -->
                <!-- <div class = "card_img">
                <img src="./assets/marketplace/portrait/1.png" alt="">
            </div> -->

            </div>



        <?php
                }
        ?>

        <div class="nav-space"></div>
        </div>
        
    </div>
    <?php include('footer.php'); ?> <!-- footer -->
    <script src="library_js.js"></script>

</body>

</html>