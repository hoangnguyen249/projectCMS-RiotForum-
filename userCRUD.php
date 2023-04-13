<?php

require('connect.php');

$query = "SELECT * FROM adminlogin ";
        // preparring sql for execution
    $statement = $db->prepare($query);
    
        //executing sql
    $statement->execute();
    $row = [];
    while ($x = $statement->fetch() ){
        $row[] = $x;
        
    }
	$users=$row;
	

	if(isset($_POST['add_user']))
	{
		$username = filter_input(INPUT_POST, 'new_user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    	$query = "INSERT INTO adminlogin(username,password) VALUES (:username, :password)";
    	$statement = $db->prepare($query);
    	$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);

    	if($statement->execute()){
        	echo "Success";
   		}

	}


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
    <!-- loading the categories--->
    <form action="userCRUD.php" method="post">

    <label for="loaded_category">Category</label>
    <select name="user" >

    <?php foreach($users as $user): ?>    
    <option value="<?= $user['id'] ?>"> <?= $user['username'] ?> </option>
    <?php endforeach ?>

    </select>
   

    <label for="rename">Rename</label>
    <input type="text" name="rename">

    <input type="submit" value="Rename Category" name="rename_category">
    </form>


    <!-- adding new categories--->
    <form action="userCRUD.php" method="post">
        <label for="new_user">Add New User</label>
        <input type="text" name="new_user">
		<input type="text" name="new_password">

        <input type="submit" value="Add User" name="add_user">
		<input type="submit" value="Update User" name="add_user">
        
    </form>
</body>
</html>