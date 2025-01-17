<?php include('partials/menu.php'); ?>

<div class ="main-content">
    <div class = "wrapper">
        <h1> Add Category </h1>

        <br> <br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

         
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <!--Add Category form starts -->
        <form action = "" method = "POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name = "title" placeholder="category Title">
                    </td>
                </tr>
                <tr>
                    <td> Select Image:</td>
                    <td>
                        <input type= "file" name = "image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name = "featured" value= "yes"> Yes
                        <input type="radio" name = "featured" value= "No"> No
                    </td>
                </tr> 
                <tr>
                    <td> Active: </td>
                    <td>
                        <input type="radio" name = "active" value= "yes"> Yes
                        <input type="radio" name = "active" value= "No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type = "submit" name="submit" value = "Add Category" class = "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        
        <?php 
            // check the submit button is clicked or not
            if(isset($_POST['submit'])){
        
                //1. Get the value from Category form
                $title = $_POST['title'];
                
                // for radio input type we need to check whether the button is selected or not
                if(isset($_POST['featured'])){
                    // get the value from form
                    $featured = $_POST['featured'];
                }
                else{
                    // set the default value
                    $featured = "No";
                }
                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else{
                    $active = "No";
                }
                
                // check whether the image is selected or not 
               // print_r($_FILES['image']); 

               if(isset($_FILES['image']['name'])){
                    // upload the image
                    // To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    // Upload the image only if image is selected
                    if($image_name != ""){

                        // Auto Rename our Image
                        // Get the extension of our image (jpg, png, gif, etc)

                        $ext = end(explode('.',$image_name));  // get extension of image like jpg, png

                        // Rename the image
                        $image_name = "Food_category_".rand(000,999).'.'.$ext; // e.g food_category_850.jpg

                        $source_path = $_FILES['image']['tmp_name'];
                        
                        $destination_path = "../images/category/".$image_name;
                        
                        // finally upload the image
                        $upload = move_uploaded_file($source_path,$destination_path);

                        // check whether the image is uploaded or not
                        // and if the image is not uploaded then we will stop the process and redirect with error message

                        if($upload==false){
                            // SET message
                            $_SESSION['upload'] = "<div class = 'error'> Failed to upload the image. </div>";
                            // redirect to add category page
                            header("location:".SITEURL.'admin/add-category.php');
                            // stop the process
                            die(); 
                        }
                    }
               }
               else{
                    // Don't upload image and set the image name value as blank
                    $image_name = "";
               } 

                // 2. Create sql query to insert Category into Database

                $sql = "INSERT INTO tbl_category SET 
                    title = '$title',
                    image_name= '$image_name',
                    featured= '$featured',
                    active = '$active'
                 "; 

                //3.  execute the query
                 $res = mysqli_query($conn, $sql);

                 //4. Check whether the query executed or not and data added or not

                 if($res==true){
                    // Query Executed and Category Added
                    $_SESSION['add'] = "<div class = 'success'> Category Added Sucessfully. </div>";
                    header('location:'.SITEURL.'admin/manage-categories.php');
                 }
                 else{
                    $_SESSION['add'] = "<div class = 'error'> Failed to add Category into Database. </div>";
                    header('location:'.SITEURL.'admin/manage-categories.php');
                 }

            }
        ?>
        
    
    </div>
</div>


<?php include('partials/footer.php');?>