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

    	$statement->execute();

	}
	if(isset($_POST['update_user'])){
		$username = filter_input(INPUT_POST, 'update_username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'update_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

		$statement = $db->prepare("UPDATE adminlogin SET username= :username, password= :password WHERE id = :id ");
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		$statement->bindValue(':id', $id);
		$statement->execute();
	}
	if(isset($_POST['pick'])){
		
		$query="SELECT * FROM adminlogin WHERE id = :id";
		$statement = $db->prepare($query);
		$id = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_NUMBER_INT);
    	$statement->bindValue(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

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
	<header>
        <nav id="command">
            <ul>
            <h3><a href="adminpage.php">Back to Home Page</a></h3>
                            
            </ul>      
        </nav>
       
            
    </header>

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
		<input type="hidden" name="user_id" value="<?php echo $result['id'] ?>">
		<label for="update_user">Update User</label>
        <input type="text" name="update_username" value=<?= $result['username']?>>
		<input type="text" name="update_password" value=<?= $result['password']?>>
		
		<?php endif ?>
		<input type="submit" value="Update User" name="update_user">

	</form>


   
    <form action="userCRUD.php" method="post">
        <label for="new_user">Add New User</label>
        <input type="text" name="new_user">
		<input type="text" name="new_password">

        <input type="submit" value="Add User" name="add_user">
        
    </form>
</body>
</html>