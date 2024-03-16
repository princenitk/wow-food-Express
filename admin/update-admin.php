<?php include('partials/menu.php')?>

<div class = "main-content">
    <div class= "wrapper">
        <h1> Update Admin</h1>
        
        <br> <br>

        <?php
            // 1. get the id of the selected admin
            
            $id = $_GET['id'];

            //2. Create sql query to get details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

            $res = mysqli_query($conn,$sql);

            // check whether the query is executed or not

            if($res==true){
                // check whether data is available
                $count = mysqli_num_rows($res);
                // check whether we have admin data or not 
                if($count==1){
                    // Get the details
                    //echo "Admin Available";
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else{
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        ?>

        <form action="" method = "POST">
            <table class ="tbl-30">
                <tr>
                    <td> Full Name: </td>
                    <td>
                        <input type ="text" name="full_name" value="<?php echo $full_name;?>">
                    </td>
                </tr>

                <tr>
                    <td> Username: </td>
                    <td>
                        <input type ="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <input type="hidden" name = "id" value="<?php echo $id; ?>" >
                        <input type = "submit" name ="submit" value="Update Admin" class = "btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php 
    // check whether the submit buttom is clicked or not
    if(isset($_POST['submit'])){
        //echo " button Clicked";
        // Get all the values from form to update
        echo "hello world";
        echo $id = $_POST['id'];
        echo $full_name = $_POST['full_name'];
        echo  $username = $_POST['username'];

        // create sql query to update admin

        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        //execute the query
        $res= mysqli_query($conn,$sql);
        
        if($res==true){
            // Query executed and Admin Updated
            $_SESSION['update'] = "<div class = 'success'> Admin Updated Successfully</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else{
            // Failed to Update Admin
            $_SESSION['update'] = "<div class = 'success'> Failed to Delete </div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>

<?php include('partials/footer.php')?>