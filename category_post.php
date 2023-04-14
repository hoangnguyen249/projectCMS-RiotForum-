<?php


session_start();

require('connect.php');
$query = "SELECT * FROM Post ORDER BY post_id ASC";

$statement = $db->prepare($query);
$statement->execute();
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
$row = loading_categories();

if(isset($_POST['submit'])){
    $query = "SELECT * FROM Post WHERE category = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $_POST['category']);
    $statement->execute();

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if(isset($_SESSION['username'])): ?>
<p><a href= "adminpage.php">Go back to home page</a></p>
<?php else: ?>
    <p><a href= "index.php">Go back to home page</a></p>
<?php endif ?>


        <div id=post>
        
        <form id="post" action="category_post.php" method="post">
        <select name="category">
            <?php foreach($row as $category_type): ?>
                <option value="<?= $category_type['category_id'] ?>"> <?= $category_type['category_name'] ?> </option>
            <?php endforeach ?>
        </select>
        <input type="submit" name="submit" value="Pick">
            </form>
           

            <?php while ($row= $statement->fetch()): ?>
                <h2><?= $row['title'] ?></h2>
                <h4><?= $row['champion']?></h4>
                <p><?= $row['date']?></p>
                <p><?= $row['content'] . " " ?></p>
                <p><b>Created:</b> <?= $row['created_date']?> <b>Updated:</b><?= $row['updated_date']?></p>
                <br>
           
            <?php endwhile ?>
        </div>

            
</body>
</html>
