<?php


require('connect.php');



//Update
if(isset($_POST['submit'])) {
    $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST,'content',FILTER_SANITIZE_SPECIAL_CHARS);
    $champion = filter_input(INPUT_POST,'champion',FILTER_SANITIZE_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST,'category',FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST,'post_id',FILTER_SANITIZE_SPECIAL_CHARS);
    $statement = $db->prepare("UPDATE Post SET title = :title, content = :content, champion = :champion, updated_date= :updated_date, category= :category WHERE post_id = :id");

    // Bind the values from the form to the query
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':champion', $champion);
    $statement->bindValue(':updated_date',date('Y-m-d H:i:s') );
    $statement->bindValue(':category', $category);

    // Execute the query
    $statement->execute();

    // Redirect to the homepage
    header("Location: adminpage.php");
    exit();
} 

// Delete post
if (isset($_POST['delete'])) {
    $statement = $db->prepare("DELETE FROM Post WHERE post_id = :id");

    $statement->bindValue(':id', $_POST['post_id']);

    $statement->execute();

    header("Location: adminpage.php");
    exit();
}


// Prepare the select statement
$statement = $db->prepare("SELECT * FROM Post WHERE post_id = :id");

// Bind the id to the query
$statement->bindValue(':id', $_GET['post_id']);

// Execute the query
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC); 

if (!$result){    
    header("Location: adminpage.php");
    exit();

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
    <title>Edit this Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id=container1>
    <h2>Edit Post</h2>

    <form id ="post" action="edit.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo $result['post_id'] ?>">
        <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo $result['title']?>">
            </div>

            <div>
                <label for="champion">Champion</label>
                <input type="text" id="champion" name="champion" value="<?php echo $result['champion']?>">
            </div>

            <div>
                <label for="content">Content</label>
                <textarea id="content" name="content"><?php echo $result['content']?></textarea>
            </div>
            <div>
            <label for="category">Category</label> <!-- maybe createa   a dropdown-->
        <select name="category">
            <?php foreach($row as $category_type): ?>
                <option value="<?= $category_type['category_id'] ?>"> <?= $category_type['category_name'] ?> </option>
            <?php endforeach ?>
        </select>
            </div>


        <!--Submit and Delete -->
        <input type="submit" name="submit" value="Update Blog">
        <input type="submit" name="delete" value="Delete">

    </form>
    </div> 
</body>
</html>