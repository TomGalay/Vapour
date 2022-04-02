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
    //view all games owned
    //connect to database
    require_once "config.php";

    //asumming id and username is already in session
    $param_id = $_SESSION['u_id'];
    $sql = "SELECT tg_id FROM transaction_table WHERE tu_id = $param_id";
    $result = $mysqli->query($sql);
    echo $result->num_rows; //echo number of games owned

    //view list of games (for recently played)
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $param_g_id = $row['tg_id'];
            $sql_search = "SELECT g_name, g_img FROM game_catalog WHERE g_id = $param_g_id";
            $result_search = $mysqli->query($sql);
            $row_search = $result_search->fetch_assoc();
            echo $row_search['g_name'];
            echo $row_search['g_img'];
        }
        } else {
            echo "No games";
        }
    $mysqli->close();
?>


<?php
    //view all users accounts (find more people)
    //connect to database
    require_once "config.php";

    $sql = "SELECT  u_username FROM user_accounts WHERE u_level = 'user'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //echo for demo
            echo $row['u_username'];
        }
    }
    $mysqli->close();
?>