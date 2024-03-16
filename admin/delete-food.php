<?php
    // echo "delete food page";
    include('../config/constants.php');
    if(isset($_GET['id']) && isset($_GET['image_name'])){

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != ""){
            $path = "../images/food/".$image_name;

            $remove= unlink($path);

            if($remove == false){
                // Failed to remove image
                $_SESSION['upload'] = "<div class = 'error'>Failed to remove image File.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }

        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res == true){
            $_SESSION['delete'] = "<div class = 'success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{
            // failed to delete;
            $_SESSION['delete'] = "<div class = 'error'>Failed to delete.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else{
        // redirect to main page

        $_SESSION['unauthorize'] = "<div class='error'> Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>