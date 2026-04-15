<!-- ADD-->
<?php 
require "includes/auth.php";
require "includes/header.php";
?>
            <h2 >ADD IMAGE</h2>
            <!-- form submits users input to process.php for validation and to add to table -->
            <form action="process.php" method="post" enctype="multipart/form-data">

                <fieldset>
                    <!-- Photo name -->
                    <label>Photo Name:</label>
                    <input type="text" name="photo_name" required>
                    
                    <!-- file upload for users pics -->
                        <label class="form-label">Add Your Image:</label>
                        <input type="file" name="photo" accept="image/*">
                </fieldset>

                <!-- submit and back to home button -->
                <br>
                <button type="submit">Add Photo</button>
                <a href="index.php">Back</a>
            </form>

