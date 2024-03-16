<?php
    // start session
    session_start();
    // create constants to store non repeating values
    // constants are named with capital letter
    define('SITEURL','http://localhost/food-order/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');   
    define('DB_PASSWORD','');
    define('DB_NAME','food_order');

    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error()); // Establish database connection
    $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error()); //selecting database   
 
?> 