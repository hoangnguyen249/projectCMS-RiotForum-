<?php

require('connect.php');

function test_input($data) {
	
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	$stmt = $db->prepare("SELECT * FROM adminlogin");
	$stmt->execute();
	$users = $stmt->fetchAll();
	
	foreach($users as $user) {
		
	    if(($user['username'] == $username) &&
			($user['password'] == $password)) {
                session_start();
                if(isset($_SESSION['username'])){
                    echo "<h1> Welcome ". $_SESSION['username'] . "<h1>";
                    echo "<a href ='adminpage.php'>Homepage</a><br>";
                }
                else{
                    $_SESSION['username']= $username;
                    echo "<a href ='adminpage.php'>Homepage</a><br>";
                }
				
		}
	}
    //echo "<script language='javascript'>";
    //echo "alert('WRONG INFORMATION')";
    //echo "</script>";
   

}
?>