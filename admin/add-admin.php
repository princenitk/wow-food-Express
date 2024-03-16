<?php include('partials/menu.php')?>

<div class= "main-content">
    <div class= "wrapper">
        <h1> Add admin</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // displaying session msg
                unset($_SESSION['add']); // remove session msg
            }
        ?>
        <form action="" method="POST">
            <table  class="tbl-30">
                <tr>
                    <td> Full Name</td>
                    <td><input type ="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td> Username</td>
                    <td><input type= "text" name ="username" placeholder="Your username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type= "password" name ="password" placeholder="password"></td>
                </tr>
                <tr>
                    <td colspan = "2" >
                        <input type="submit" name="submit" value= "Add Admin" class="btn-secondary">
                    </td>
                   
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php')?>

<?php
    // Process the value from form and save it in database
    //check whether the button is clicked or not
    // isset($_POST['submit']) checks whether submit button has clicked or not 
    if(isset($_POST['submit'])){
        // BUTTON clicked
        
        //1. Get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password  = md5($_POST['password']); // password encryption with MD5

       //2. SQL query to save the data into database
       $sql = "INSERT INTO tbl_admin SET 
       full_name =  '$full_name',
       username = '$username',
       password = '$password' "; 
        //echo $sql;

       //3. Execute query and save data in database 
       $res = mysqli_query($conn,$sql) or die(mysqli_error());
        
       //4. check whether the (Query is executed or not and display msg)data is inserted or not
        
       if($res == TRUE){
        //echo "Data Inserted";
        // create a session variable to Display message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
        // Redirect page
        header("location:".SITEURL.'admin/manage-admin.php');
       }
       else{
         // echo "Failed to insert data";
        // create a session variable to Display message
        $_SESSION['add'] = "<div class='error'>Failed to add admin </div>";
        // Redirect page to Add admin
        header("location:".SITEURL.'admin/manage-admin.php');
       }
    }   
?>