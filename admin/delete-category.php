<?php
    //echo "deletepage";
    // check whether and image_name value is set or not
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])){
        // get the value and delete
        // echo "get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // remove the physical image file if available
        if($image_name != ""){
            // image is available so remove it 
            $path = "../images/category/".$image_name;

            // remove the image
            $remove = unlink($path);
            // if failed to remove image then add an error message
            if($remove == false){
                // set the session message
                $_SESSION['remove'] = "<div class = 'error'> Failed to remove Category image.</div>" ;
                // redirect to manage category page
                header('location:'.SITEURL.'admin/manage-categories.php');
                // stop the process
                die();
            }
        }
        // delete data from database

        // SQl Query to delete data from database 
        $sql = "DELETE FROM tbl_category WHERE id = $id";
        
        $res = mysqli_query($conn, $sql);

        // check whether data is delete from database or not
        if($res==true){
            // set success msg
            $_SESSION['delete'] = "<div class= 'success'> Category deleted successfully.</div>";
            header('location:'.SITEURL.'admin/manage-categories.php');
        }
        else{
            $_SESSION['delete'] = "<div class= 'error'> Failed to delete.</div>";
            header('location:'.SITEURL.'admin/manage-categories.php');
        }
        // redirect to manage category page with message

    }
    else{
        // redirect to manage category page
        header('location:'.SITEURL.'admin/manage-categories.php');
    }
?>