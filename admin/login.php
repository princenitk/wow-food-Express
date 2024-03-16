<?php include('../config/constants.php'); ?>
<html>
    <head> 
        <title> Login food order System</title>
        <link rel="stylesheet" href ="../css/login.css">
    </head>

    <body>
        <div class = "Login">
            <h1 class = "text-center"> Login</h1>
            <!-- Login form starts--> <br><br>

            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

            <br><br>

            <form action="" method ="POST" class = "text-center">
                Username: <br>
                <input type ="text" name = "username" placeholder = "Enter Username"> <br><br>
                Password: <br>
                <input type = "password" name = "password" placeholder ="Enter password"><br>
                <br> <br>
                <input type = "submit" name = "submit" value="Login" class = "btn-primary">
            </form>

        </div>
    </body>
</html>

<?php
        // check whether submit button has pressed
        
        if(isset($_POST['submit'])){

            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = md5($_POST['password']);
          
        // sql to check whether the user with username and password exists or not

            $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
            
            $res = mysqli_query($conn,$sql);
            
        // count rows to check whether the user exists or not
            $count = mysqli_num_rows($res);
           
            if($count == 1){
                
                // user Available and login success
                $_SESSION['login'] = "<div class = 'success'> Login successful. </div>";
                $_SESSION['user'] = $username; // to check whether user is logged in or not and logout will unset it
                // Redirect to home page
                header('location:'.SITEURL.'admin/');
            }
            else{
                // user not available and login failed
                $_SESSION['login'] = "<div class = 'error text-center'> Username or password did not match. </div>";
                // Redirect to home page
                header('location:'.SITEURL.'admin/login.php');
            }
            
        }
?>