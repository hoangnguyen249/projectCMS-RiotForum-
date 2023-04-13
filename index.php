<?php


require('connect.php');

// Query Database
$query = "SELECT * FROM Post ORDER BY post_id ASC";

$statement = $db->prepare($query);

$statement->execute();
// Query Database
$query = "SELECT * FROM Post WHERE post_id = :id";

$statement2 = $db->prepare($query);
$statement2->bindValue(':id', $_GET['post_id']);
$statement2->execute();



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
    <div id="mainContainer">
    <header>
        <h3><a href="authenticate.php">Login</a></h3>
        
        <nav id="homemenu">
        <?php while ($row= $statement->fetch()): ?>
            <ul>

            <h5><a href="?post_id=<?=$row['post_id']?>"><?= $row['title'] ?></a></h5>

            </ul>  
        <?php endwhile ?>    
        </nav>
            
    </header>

        <div id=post>
        
            <?php while ($row= $statement2->fetch()): ?>
                <h2><?= $row['title'] ?></h2>
                <h4><?= $row['champion']?></h4>
                <p><?= $row['date']?></p>
                <p><?= $row['content'] . " " ?></p>
                <p><b>Created:</b> <?= $row['created_date']?> <b>Updated:</b><?= $row['updated_date']?></p>
                <br>
           
            <?php endwhile ?>

        </div>

    </div>   
            
</body>
</html>