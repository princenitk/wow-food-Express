<?php
 // check whether user is logged in or not
    if(!isset($_SESSION['user'])){  // if user session not set
        // user is not logged in
        $_SESSION['no-login-message'] = "<div class= 'error'> Please login to access admin panel</div>";
    
        // redirect to login page with msg
        header('location:'.SITEURL.'admin/login.php');
    } 
?> 