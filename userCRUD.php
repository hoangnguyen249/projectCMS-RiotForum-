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
	if(isset($_POST['pick'])){
		
		$query="SELECT * FROM adminlogin WHERE id = :id";
		$statement = $db->prepare($query);
		
    	$statement->bindValue(':id', $_POST['user']);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

	}
	if(isset($_POST['update_user'])){
		$statement = $db->prepare("UPDATE Post SET username= :username, password= :password ");
		$statement = $db->prepare($query);
		$statement->bindValue(':username', $_POST['update_user']);
		$statement->bindValue(':password', $_POST['update_password']);
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
    <title>My Blog Post!</title>
</head>
<body>

    <form action="userCRUD.php" method="post">

    <label for="loaded_category">Category</label>
    <select name="user" >

    <?php foreach($users as $user): ?>    
    <option value="<?= $user['id'] ?>"> <?= $user['username'] ?> </option>
    <?php endforeach ?>

    </select>

    <input type="submit" value="Pick Category" name="pick">
    </form>

	<form action="userCRUD.php" method="post">
		<?php if(isset($result)): ?>
		<label for="update_user">Update User</label>
        <input type="text" name="update_user" value=<?= $result['username']?>>
		<input type="text" name="update_password" value=<?= $result['password']?>>
		<input type="submit" value="Update User" name="update_user">
		<?php endif ?>

	</form>


   
    <form action="userCRUD.php" method="post">
        <label for="new_user">Add New User</label>
        <input type="text" name="new_user">
		<input type="text" name="new_password">

        <input type="submit" value="Add User" name="add_user">
        
    </form>
</body>
</html>