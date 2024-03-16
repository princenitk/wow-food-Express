<?php
    // include constants.php for connection
    include('../config/constants.php');
    // 1. get the id of the admin to be deleted

    $id = $_GET['id'];

    // 2. create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    $res = mysqli_query($conn,$sql);

    // check whether query executed succesfuly or not 
    if($res == TRUE){
        // query executed successfully
        echo "Admin Deleted ";
        // create session variable to display message
        $_SESSION['delete'] = "<div class = 'success'>Admin Deleted Successfully</div>";
        // redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{ 
        // failed to delete admin
        $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try Again Later.</div> ";
        header('location:'.SITEURL.'admin/manage-admin.php');
        //echo " Failed to delete" ;
    }

    // 3. Redirect to manage admin page with message 

?>