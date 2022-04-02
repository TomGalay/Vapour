<?php
//ADMIN ADD USER PHP

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["u_level"] != "admin") {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <div class="background">
        <div class="container">
            <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <h1>Add Game</h1>
                <p><a href="admin_home.php">Back</a></p>

                <?php

include ('config.php');
$sql_query = "SELECT AUTO_INCREMENT
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = \"vapourDB\"
AND TABLE_NAME = \"game_catalog\"";
$result_query = mysqli_query($mysqli, $sql_query);
$array_from_query = mysqli_fetch_all($result_query);

?>
                <div class="form-detail">
                    <p>Game ID: </p>
                    <p><?php echo $array_from_query[0][0] ?></p>
                </div>
                <div class="form-detail">
                    <p>Game Name: </p>
                    <p><input type="text" id="g_name" name="g_name" required></p>
                </div>
                <div class="form-detail">
                    <p>Game Publisher: </p>
                    <p><input type="text" id="g_publisher" name="g_publisher" required></p>
                </div>
                <div class="form-detail">
                    <p>Game Developer: </p>
                    <p><input type="text" id="g_developer" name="g_developer" required></p>
                </div>
                <div class="form-detail">
                    <p>Game Description: </p>
                    <p><input type="text" id="g_desc" name="g_desc" required></p>
                </div>
                <div class="form-detail">
                    <p>Game Release Date: </p>
                    <p><input type="date" id="g_release_date" name="g_release_date" required></p>
                </div>
                <div class="form-detail">
                    <p>Game Price: </p>
                    <p><input type="text" id="g_price" name="g_price" required></p>
                </div>
                <div class="form-detail">
                    <p>Game Category: </p>
                    <select name="g_genre">
                        <option value="1">Action</option>
                        <option value="2">Adventure</option>
                        <option value="3">Casual</option>
                        <option value="4">Indie</option>
                        <option value="5">Multiplayer</option>
                        <option value="6">Racing</option>
                        <option value="7">RPG</option>
                        <option value="8">Horror</option>
                        <option value="9">Simulation</option>
                        <option value="10">Sports</option>
                        <option value="11">Strategy</option>
                    </select>
                </div>
                <div class="form-detail">
                    <p>Portrait Image: </p><input name="fileToUpload" type="file" required/>
                </div>
                <div class="form-detail">
                    <p>Landscape Image: </p><input name="fileToUpload2" type="file" required/>
                </div>
                <input type="hidden" name="form_submitted" value="1">
                <input type="submit" name="upload" value="Send File"/>
                <br>

                <?php
                $ok_upload = false;
                $g_img = "";
                require "upload.php";

                if (isset($_POST['form_submitted']) && $ok_upload) {
                    $g_name = $_POST['g_name'];
                    $g_publisher = $_POST['g_publisher'];
                    $g_developer = $_POST['g_developer'];
                    $g_desc = $_POST['g_desc'];
                    $g_release_date = $_POST['g_release_date'];
                    $g_price = $_POST['g_price'];
                    include ('getGenre.php');
                    $g_genre = getGenre($_POST['g_genre']);
                    

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "vapourDB";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "INSERT INTO game_catalog (g_name, g_publisher, g_developer, g_desc, g_release_date, g_price, g_img, g_category)
                                VALUES ('$g_name', '$g_publisher', '$g_developer', '$g_desc', '$g_release_date', '$g_price', '$g_img', '$g_genre')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p>Game registered!</p>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $conn->close();
                }
                ?>
            </form>
        </div>
    </div>
</body>

</html>