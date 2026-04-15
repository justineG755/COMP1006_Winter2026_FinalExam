<!-- CREATE -->
<!-- get nformation, validates and sanitises info and store into database table -->

<?php 
require "includes/connect.php";
require "includes/auth.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

// sanitize form input
$photo_name = trim(filter_input(INPUT_POST, 'photo_name', FILTER_SANITIZE_SPECIAL_CHARS));


// server-side validation
$errors = [];

// Required fields
if ($photo_name === null || $photo_name === '') {
    $errors[] = "Name for image is required.";
}

// variable to store uploaded photo file name
$photo = null;

//check uploaded file if one was selected
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    $fileType = $_FILES['photo']['type'];

    // check file type
    if (!in_array($fileType, $allowedTypes)) {
        $errors[] = "Only JPG, PNG, and GIF files are allowed.";
    } else {

        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        $tempName = $_FILES['photo']['tmp_name'];

        $destination = __DIR__ . '/uploads/' . $photoName;

        if (move_uploaded_file($tempName, $destination)) {
            $photo = $photoName;
        } else {
            $errors[] = "Photo upload failed.";
        }
    }

} elseif (!empty($_FILES['photo']['name'])) {
    $errors[] = "Invalid file upload.";
}

// if there are errors
if (!empty($errors)) {
    echo "<h2>Please fix the following:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "<a href='add.php'>Go Back</a>";

    exit;
}

// SQL query
$sql = "INSERT INTO photo_storage (photo_name, photo) 
        VALUES (:photo_name, :photo)";

// prepare statement
$stmt = $pdo->prepare($sql);

// bind values
$stmt->bindParam(':photo_name', $photo_name);
$stmt->bindParam(':photo', $photo);

// execute
$stmt->execute();

// go back to home
header("Location: index.php");
exit;
?>