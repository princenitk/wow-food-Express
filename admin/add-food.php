<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class= "wrapper">
        <h1> Add Food </h1>

        <?php 
       
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>
        <form action="" method = "POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td> Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="title of the food">
                    </td>
                </tr>

                <tr>
                    <td> Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder ="Description of the food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td> Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td> Select Image: </td>
                    <td> 
                        <input type= "file" name = "image">
                    </td>
                </tr>

                <tr>
                    <td> Category: </td>
                    <td> 
                        <Select name="category">
                            <?php
                                // Create php code to display categories from database
                                // 1. Create sql to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
                                
                                $res = mysqli_query($conn,$sql);

                                $count = mysqli_num_rows($res);

                                if($count>0){
                                    // we have categories
                                    while($row = mysqli_fetch_assoc($res)){
                                        // get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        
                                        ?>

                                        <option value="<?php echo $id ?>"><?php echo $title; ?></option>

                                        <?php 
                                    }
                                }   
                                else{
                                    // we do not have categories
                                    ?>
                                    <option value = "0"> No Category Found</option>

                                    <?php
                    
                                }

                            ?>
                    
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type = "radio" name = "featured" value="Yes"> Yes
                        <input type = "radio" name = "featured" value = "No"> NO
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type = "radio" name = "active" value="Yes"> Yes
                        <input type = "radio" name = "active" value = "No"> NO
                    </td>
                </tr>

                <tr>
                    <td colspan = "2"> 
                        <input type = "submit" name="submit" value = "Add " class = "btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

       <?php
            if(isset($_POST['submit'])){
               // Add the food in database
               echo "clidcked";

                // 1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                // check whether radio button for featured 
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                }
                else{
                    $featured = "No";
                }
                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else{
                    $active = "No";
                }
                //2. upload the image if selected
                if(isset($_FILES['image']['name'])){
                    echo "clicked";
                    // get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // check whether the image is selected or not and upload only if selected
                    if($image_name!=""){
                        // Image is selected
                        // A. Rename the image
                        // Get the extension of selected image(jpg, png, gif etc)
                        
                        $ext = end(explode('.',$image_name));
                        
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; // New image name may be "Food-Name 657"

                        //B. upload the image
                        // Get the src path and destination path
                        // source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        // Destination path for the image to be uploaded

                        $dst = "../images/food/".$image_name;

                        $upload = move_uploaded_file($src,$dst);

                        if($upload==false){
                            // failed to upload the image
                            $_SESSION['upload'] = "<div class= 'error'> Failed to upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            // Redirect to add food page with error msg
                            die();
                        }

                    }
                }
                else{
                    $image_name = ""; // setting default value as blank
                }
                //3. Insert into database

                // Create a sql query to save or add to database
                // For numerical value we don't need to pass value inside single quotes only for strings
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";
           
                echo "hello ";
                $res2 = mysqli_query($conn,$sql2);

                if($res2==true){
                    $_SESSION['add'] = "<div class='success'>Food Added successfully. </div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    // failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed to add food </div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                
            }
    
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>