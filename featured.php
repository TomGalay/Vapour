<?php
$purchase = $_POST['featured'];
echo $purchase;
$_SESSION['game_purchase'] = $purchase;
header("location:game.php");
exit;



?>