<?php

require('connect.php');

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $current_folder = dirname(__FILE__);
    
    // Build an array of paths segment names to be joins using OS specific slashes.
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    
    // The DIRECTORY_SEPARATOR constant is OS specific.
    return join(DIRECTORY_SEPARATOR, $path_segments);
 }
 function file_is_an_image($temporary_path, $new_path) {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
    
    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];
    
    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
    
    return $file_extension_is_valid && $mime_type_is_valid;
}

$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
$upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

if ($image_upload_detected) { 
    $image_filename        = $_FILES['image']['name'];
    $temporary_image_path  = $_FILES['image']['tmp_name'];
    $new_image_path        = file_upload_path($image_filename);
    if (file_is_an_image($temporary_image_path, $new_image_path)) {
        move_uploaded_file($temporary_image_path, $new_image_path);
    }
}

// Validate is the post has been submitted
if (isset($_POST['submit'])) {

    // Get the data    
    $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST,'content',FILTER_SANITIZE_SPECIAL_CHARS);
    $champion = filter_input(INPUT_POST,'champion',FILTER_SANITIZE_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST,'category',FILTER_SANITIZE_SPECIAL_CHARS);
    

    // Validate title and content

    $errors = [];
    if (strlen($title) < 1) {
        $errors[] = "Post must be at least 1 character in length";
    }

    if (strlen($content) < 1) {
        $errors[] = "Post must be at least 1 character in length";
    }
    if (strlen($champion) < 1) {
        $errors[] = "Post must be at least 1 character in length";
    }

   
    if (empty($errors)) {

        // Prepare the SQL statement
        $statement = $db->prepare("INSERT INTO Post (title, content,champion,category) VALUES (:title, :content, :champion,:category)");

        // link parameters    
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':champion', $champion);
        $statement->bindValue(':category', $category);
        


        // Execute the statement    
        $statement->execute();

        // Redirect back to the home page    
        header("Location: adminpage.php");
        exit();

    }
    else{
        echo '<script>alert("Missing something!!!")</script>';
        
    }
}
function loading_categories(){
    global $db;

    $query = "SELECT * FROM categories ;";
        // preparring sql for executoin
    $statement = $db->prepare($query);
    
        //executing sql
    $statement->execute();
    $categories = [];
    while ($x = $statement->fetch() ){
        $categories[] = $x;
        
    }
    
    return $categories;
}
$row= loading_categories();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id=formContainer>
        <h1> Create New Post!</h1>
        <form id="post" action="post.php" method="post">
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title">
            </div>

            <div>
                <label for="champion">Champion</label>
                <input type="text" id="champion" name="champion">
            </div>

            <div>
                <label for="content">Content</label>
                <textarea id="content" name="content"></textarea>
            </div>
            
            <div>
            <label for="category">Category</label> <!-- maybe createa   a dropdown-->
        <select name="category">
            <?php foreach($row as $category_type): ?>
                <option value="<?= $category_type['category_id'] ?>"> <?= $category_type['category_name'] ?> </option>
            <?php endforeach ?>
        </select>
            </div>

            <div>
            <label for='image'>Image Filename:</label>
            <input type='file' name='image' id='image'>
            </div>  


            <input type="submit" value="Post" name="submit">
        </form>
    </div>    
    </body>
</html>
