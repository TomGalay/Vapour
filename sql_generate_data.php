<?php
// Server credentials
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "vapourDB";

// Create connection and check connection
$mysqli = mysqli_connect($db_servername, $db_username, $db_password, $db_name) or die("Unable to Connect");

//game data
$sql = "INSERT INTO `game_catalog` (`g_id`, `g_name`, `g_publisher`, `g_developer`, `g_img`, `g_desc`, `g_release_date`, `g_price`, `g_created_at`, `g_category`) VALUES
(1, 'Batman™: Arkham Knight', 'Warner Bros. Interactive Entertainment', 'Rocksteady Studios', '1', 'Batman™: Arkham Knight brings the award-winning Arkham trilogy from Rocksteady Studios to its epic conclusion. Developed exclusively for New-Gen platforms, Batman: Arkham Knight introduces Rocksteady\'s uniquely designed version of the Batmobile.', '2015-06-23', 499.75, '2021-04-01 20:25:12', 'Action'),
(2, 'Brawlhalla', 'Ubisoft', 'Blue Mammoth Games', '2', 'An epic platform fighter for up to 8 players online or local. Try casual free-for-alls, ranked matches, or invite friends to a private room. And it\'s free! Play cross-platform with millions of players on PlayStation, Xbox, Nintendo Switch, iOS, Android & Steam! Frequent updates. Over fifty Legends.', '2017-10-17', 0, '2021-04-01 20:25:12', 'Action'),
(3, 'Counter- Strike: Global Offensive', 'Valve', 'Valve, Hidden Path Entertainment', '3', 'Counter-Strike: Global Offensive (CS: GO) expands upon the team-based action gameplay that it pioneered when it was launched 19 years ago. CS: GO features new maps, characters, weapons, and game modes, and delivers updated versions of the classic CS content (de_dust2, etc.).', '2012-08-22', 0, '2021-04-01 20:25:12', 'Action'),
(4, 'Deceit', 'Baseline', 'Baseline', '4', 'Deceit tests your instincts at trust and deception in an action-filled, multiplayer first-person shooter. You wake up in unknown surroundings to the sound of the Game Master’s unfamiliar voice, surrounded by five others. A third of your group have been infected with a virus, but who will escape?', '2017-04-04', 0, '2021-04-01 20:25:12', 'Multiplayer'),
(5, 'Eternal Return: Black Survival', 'Nimble Neuron', 'Nimble Neuron', '5', 'Eternal Return is a unique MOBA/Battle Royale/Survival mix that combines strategy, mechanics, and cool characters. Choose one of the ever growing cast of characters, take on Lumia Island as one of 18 players - either solo or with a team, and prove your strength, ability, and wit.', '2020-10-14', 0, '2021-04-01 20:25:12', 'Multiplayer'),
(6, 'Minecraft', 'Mojang, Microsoft Studios, Sony Interactive Entertainment', 'Mojang', '6', 'Explore new gaming adventures, accessories, & merchandise on the Minecraft Official Site. Buy & download the game here, or check the site for the latest news.', '2011-11-18', 925, '2021-04-01 20:25:12', 'Simulation'),
(7, 'NBA 2K21', '2K', 'Visual Concepts', '7', 'NBA 2K21 is the latest title in the world-renowned, best-selling NBA 2K series, delivering an industry-leading sports video game experience.', '2020-09-04', 755.5, '2021-04-01 20:25:12', 'Sports'),
(8, 'NFS: Heat', 'Electronic Arts', 'Ghost Games', '8', 'Hustle by day and risk it all at night in Need for Speed™ Heat Deluxe Edition, a white-knuckle street racer, where the lines of the law fade as the sun starts to set.', '2019-11-08', 3600, '2021-04-01 20:25:12', 'Racing'),
(9, 'Valheim', 'Coffee Stain Publishing', 'Iron Gate AB', '9', 'A brutal exploration and survival game for 1-10 players, set in a procedurally-generated purgatory inspired by viking culture. Battle, build, and conquer your way to a saga worthy of Odin’s patronage!', '2021-02-02', 449.95, '2021-04-01 20:25:12', 'Adventure'),
(10, 'Valorant', 'Riot Games', 'Riot Games', '10', 'Blend your style and experience on a global, competitive stage. You have 13 rounds to attack and defend your side using sharp gunplay and tactical abilities. And, with one life per-round, you\'ll need to think faster than your opponent if you want to survive. Take on foes across Competitive and Unranked modes as well as Deathmatch and Spike Rush.', '2020-06-02', 0, '2021-04-01 20:25:12', 'Action');";

$result = mysqli_query($mysqli, $sql) or die("Bad Query: $sql");


//user data
$sql =  "INSERT INTO `user_accounts` (`u_id`, `u_fname`, `u_lname`, `u_username`, `u_password`, `u_bday`, `u_email`, `u_cnumber`, `u_level`, `u_created_at`) VALUES
(4, 'Isaiah Thomas', 'Galay', 'aeroboros', '$2y$10\$wEOIFprHnWxKgIQ2ywM7Y.A43nK6UdOWDfFakxx9W9emyAaOmUG5y', '2021-04-03', 'tomgalay@gmail.com', '09152391880', 'user', '2021-04-02 13:55:45'),
(5, 'yes', 'qweqwe', 'ced', '$2y$10$0RxTo4HO7daL12C.EDLAeeGKObjZdvYNi7V/vHf/L0xv0rlvN4B.K', '2021-04-03', 'qwe@email.com', '09152391880', 'admin', '2021-04-02 23:18:22');";


$result = mysqli_query($mysqli, $sql) or die("Bad Query: $sql");


//transaction data
$sql = "INSERT INTO `transaction_table` (`t_id`, `tu_id`, `tg_id`, `t_created_at`) VALUES
(1, 4, 1, '2021-04-03 00:44:53'),
(2, 4, 2, '2021-04-03 00:44:53'),
(3, 4, 3, '2021-04-03 00:44:53'),
(27, 4, 5, '2021-04-03 16:53:29'),
(28, 4, 9, '2021-04-03 21:58:00'),
(29, 4, 4, '2021-04-03 21:58:21'),
(30, 4, 6, '2021-04-04 01:17:36'),
(31, 4, 8, '2021-04-04 01:32:53');";

$result = mysqli_query($mysqli, $sql) or die("Bad Query: $sql");

mysqli_close($mysqli);
