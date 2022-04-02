<?php
//ADMIN HOME PHP


session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["u_level"] != "admin" ){
    header("location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vapourDB";    

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT t_id, tu_id, tg_id, t_created_at FROM transaction_table";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="background">
        <div class="container">
            <form action="">
                <h1>My Information</h1>
                <p><a href="logout.php">Log-out</a></p>
                <p><a href="marketplace.php">Go to Site</a></p>
                <div class="form-detail">
                    <p>Welcome, </p><?php echo "<p>".$_SESSION["u_fname"]. " " . $_SESSION["u_lname"];?></p>
                </div>
                <div class="form-detail">
                    <p>Userlevel: </p><?php echo "<p>".$_SESSION["u_level"];?></p>
                </div>
                <div class="form-detail">
                    <p>Birthday: </p><?php echo "<p>".$_SESSION["u_bday"];?></p>
                </div>
                <h2>Contact Details</h2>
                <div class="form-detail">
                    <p>Contact: </p><?php echo "<p>".$_SESSION["u_cnumber"];?></p>
                </div>
                <div class="form-detail">
                    <p>Email: </p><?php echo "<p>".$_SESSION["u_email"];?></p>
                </div>
                <div class="form-detail">
                <h2>Records</h2>
                        <p><a href="admin_addgame.php">Add New Game</a></p>
                </div>
                <table>        
                    <tr>
                        <th>Transaction ID</th>
                        <th>User ID</th>
                        <th>Game ID</th>
                        <th>Date Purchased</th>
                    </tr>
                    
                    <?php
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row["t_id"]; ?></td>
                            <td><?php echo $row["tu_id"]; ?></td>
                            <td><?php echo $row["tg_id"]; ?></td>
                            <td><?php echo $row["t_created_at"]; ?></td>
                        </tr>
                        <?php
                        }
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                    ?>
                </table>
            </form>
        </div>
    </div>
    
</body>
</html>