
<?php
    //view user details
    session_start();
    //connect to database
    require_once "config.php";

    //asumming id and username is already in session
    $param_id = $_SESSION['u_id'];
    $sql = "SELECT u_id, u_fname, u_lname, u_username, u_bday, 
                    u_email, u_cnumber FROM user_accounts WHERE u_id = $param_id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    //echo for demo
    echo $_SESSION['u_id'];
    echo $_SESSION['u_username'];
    echo $row["u_fname"];
    echo $row["u_lname"];
    echo $row["u_bday"];
    echo $row["u_email"];
    echo $row["u_cnumber"];

    $mysqli->close();
?>

<?php
    //view all games
    //connect to database
    require_once "config.php";

    $sql = "SELECT g_id, g_name, g_publisher, g_developer, g_img, g_desc, g_release_date, g_price FROM game_catalog";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //echo for demo
            echo $row['g_id'];
            echo $row['g_name'];
            echo $row['g_publisher'];
            echo $row['g_developer'];
            echo $row['g_img'];
            echo $row['g_desc'];
            echo $row['g_release_date'];
            echo $row['g_price'];
        }
        } else {
            echo "No games";
        }
    $mysqli->close();
?>

<?php
    //view all games owned
    //connect to database
    require_once "config.php";

    //asumming id and username is already in session
    $param_id = $_SESSION['u_id'];
    $sql = "SELECT tg_id FROM transaction_table WHERE tu_id = $param_id";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $param_g_id = $row['tg_id'];
            $sql_search = "SELECT g_id, g_name, g_publisher, g_developer, g_img, g_desc, g_release_date, g_price 
                            FROM game_catalog WHERE g_id = $param_g_id";
            $result_search = $mysqli->query($sql);
            $row_search = $result_search->fetch_assoc();
            echo $row_search['g_id'];
            echo $row_search['g_name'];
            echo $row_search['g_publisher'];
            echo $row_search['g_developer'];
            echo $row_search['g_img'];
            echo $row_search['g_desc'];
            echo $row_search['g_release_date'];
            echo $row['g_price'];
        }
        } else {
            echo "No games";
        }
    $mysqli->close();
?>