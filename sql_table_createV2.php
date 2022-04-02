<?php
  // Server credentials
  $db_servername = "localhost";
  $db_username = "root";
  $db_password = "";
  $db_name = "vapourDB";

  // Create connection and check connection
  $mysqli = mysqli_connect($db_servername, $db_username, $db_password, $db_name) or die("Unable to Connect");

  // Create user account table
  $sql = "CREATE TABLE user_accounts (
          u_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          u_fname VARCHAR(255) NOT NULL,
          u_lname VARCHAR(255) NOT NULL,
          u_username VARCHAR(255) NOT NULL UNIQUE,
          u_password VARCHAR(255) NOT NULL,
          u_bday DATE NOT NULL,
          u_email VARCHAR(255) NOT NULL,
          u_cnumber VARCHAR(255) NOT NULL,
          u_level VARCHAR(255) NOT NULL,
          u_created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
      

      


      
  $result = mysqli_query($mysqli, $sql) or die("Bad Query: $sql");
  
  // Create game catalog table
  
  $sql = "CREATE TABLE game_catalog (
          g_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          g_name VARCHAR(255) NOT NULL,
          g_publisher VARCHAR(255) NOT NULL,
          g_developer VARCHAR(255) NOT NULL,
          g_img VARCHAR(255) NOT NULL,
          g_desc MEDIUMTEXT NOT NULL,
          g_release_date DATE NOT NULL,
          g_price FLOAT NOT NULL,
          g_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          g_category VARCHAR(255) NOT NULL
        )";



      
  $result = mysqli_query($mysqli, $sql) or die("Bad Query: $sql");

  // Create owned games table
  $sql = "CREATE TABLE transaction_table (
          t_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          tu_id INT NOT NULL,
          tg_id INT NOT NULL,
          t_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          FOREIGN KEY (tu_id) REFERENCES user_accounts(u_id),
          FOREIGN KEY (tg_id) REFERENCES game_catalog(g_id)
        )";
      
  $result = mysqli_query($mysqli, $sql) or die("Bad Query: $sql");
  
        
  mysqli_close($mysqli);
?>