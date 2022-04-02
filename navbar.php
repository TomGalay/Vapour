<?php
if (isset($_SESSION["u_username"])) {
    $user = $_SESSION["u_username"];
}

?>
<nav>
    <div class="navbar" id="nav-bar">
        <ul class="left-side">
            <li><a id="image" href="./marketplace.php"><img src="assets/navbar/logo-small.png"></a></li>
            <li><a href="./marketplace.php">market</a></li>
            <li><a href="./library.php">game library</a></li>
            <li><a href="./about.php">about</a></li>
        </ul>
        <ul class="right-side">
            <?php
            
            if (isset($_SESSION["loggedin"])){
                if($_SESSION["loggedin"] == true){
                    echo "<li><a class=\"profile\" href=\"./profile.php\">$user</a></li>
                    <li><a href=\"./logout.php\">logout</a></li>";
                }
            }
            else {
                echo "<li><a href=\"./login.php\">login</a></li> | <li><a href=\"./registration.php\">register</a></li>";
            }
            ?>
            
        </ul>

    </div>
</nav>    
<script>
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        document.getElementById("nav-bar").style.top = "0";
    } else {
        document.getElementById("nav-bar").style.top = "-100px";
    }
    prevScrollpos = currentScrollPos;
}
</script>
