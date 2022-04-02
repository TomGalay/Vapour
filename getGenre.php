<?php
function getGenre($val){
    switch($val){
        case 1:
            return "Action";
        case 2:
            return "Adventure";
        case 3:
            return "Casual";
        case 4:
            return "Indie";
        case 5:
            return "Multiplayer";
        case 6:
            return "Racing";
        case 7:
            return "RPG";
        case 8:
            return "Horror";
        case 9:
            return "Simulation";
        case 10:
            return "Sports";
        case 11:
            return "Strategy";
        case 12:
            return "All";
    }
}
?>