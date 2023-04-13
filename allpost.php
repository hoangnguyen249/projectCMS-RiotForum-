<?php


require('connect.php');


    $query = "SELECT * FROM Post ORDER BY post_id ASC";

    $statement = $db->prepare($query);
    $statement->execute();

if(isset($_POST['sort_title'])){
    $query = "SELECT * FROM Post ORDER BY title";

    $statement = $db->prepare($query);
    $statement->execute();

}
if(isset($_POST['sort_created_date'])){
    $query = "SELECT * FROM Post ORDER BY created_date";

    $statement = $db->prepare($query);
    $statement->execute();

}
if(isset($_POST['sort_updated_date'])){
    $query = "SELECT * FROM Post ORDER BY updated_date DESC
    ";

    $statement = $db->prepare($query);
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
<form id="post" action="allpost.php" method="post">
    <input type="submit" name="sort_title" value="Sort by Title">
    <input type="submit" name="sort_created_date" value="Sort by Created Date">
    <input type="submit" name="sort_updated_date" value="Sort by Updated Date">
</form>
<p><a href= "adminpage.php">Go back to home page</a></p>

        <div id=post>
        
            <?php while ($row= $statement->fetch()): ?>
                <h2><?= $row['title'] ?></h2>
            <h4><?= $row['champion']?></h4>
            <p><?= $row['date']?></p>
            <p><?= $row['content'] . " " ?><a href="edit.php/?post_id=<?=$row['post_id']?>">edit</a></p>
            <p><b>Created:</b> <?= $row['created_date']?> <b>Updated:</b><?= $row['updated_date']?></p>
            <br>
            <?php endwhile ?>

        </div>

            
</body>
</html>
