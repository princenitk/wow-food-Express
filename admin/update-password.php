<?php  include('partials/menu.php') ?>

<div class ="main-content">
    <div class = "wrapper">
        <h1> Change Password</h>
        
        <br> <br>

        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>
        
        <form action="" method ="POST">

            <table class = "tbl-30">
                <tr>
                    <td> Current Password: </td>
                    <td> 
                        <input type = "password" name ="current_password" placeholder= "current password">
                    </td>
                </tr>
                <tr>
                    <td> New password: </td>
                    <td> 
                        <input type ="password" name="new_password" placeholder="New password">
                    </td>
                </tr>

                <tr>
                    <td> Confirm password: </td>
                    <td> 
                        <input type ="password" name="confirm_password" placeholder="Confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan = "2"> 
                        <input type ="hidden" name = "id" value = "<?php echo $id; ?>">
                        <input type ="submit" name="submit" placeholder="change password" class="btn-secondary">
                    </td>
                </tr>
        </table>

        </form>

    </div>
</div>


<?php
    // check whether submit buttom is clicked

    if(isset($_POST['submit'])){
        // echo "clicked";

        // 1. get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password= md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        //2. Check whether the user with current id and current password exiss or not
        
        $sql = "SELECT * from tbl_admin where id=$id AND password = '$current_password'";
        // Execute the query

        $res = mysqli_query($conn,$sql);
        
        if($res == TRUE){
            $count = mysqli_num_rows($res);
            if($count==1){
                // user exists and password can be changed
                // check whether the new password and confirm password match or not
                if($new_password==$confirm_password){
                    // update password
                    echo "password match";
                    $sql2 = "UPDATE tbl_admin SET 
                        password='$new_password'
                        where id = $id
                    ";
                    $res2 = mysqli_query($conn,$sql2);

                    if($res2==true){
                        //display msg 
                        $_SESSION['change-pwd'] = "<div class = 'success'> Password changed Successfully. </div>";
                        // redirect the user to manage admin
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    
                    else{
                        //display error msg
                        $_SESSION['change-pwd'] = "<div class = 'error'>Failed to Change password. </div>";
                        // redirect the user to manage admin
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    
                }
                else{
                    // Redirect to manage admin with error msg
                    $_SESSION['pwd not match'] = "<div class = 'error'> Password did not Match.</div>";
                    // redirect the user to manage admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else{
                // user does not exists set message and redirect
                $_SESSION['user not found'] = "<div class = 'error'> User not Found</div>";
                // redirect the user to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        //3. check whether the new password and confirm password
        
        //4. change password if all above is true
    }
?>

<?php include('partials/footer.php')?>