<?php





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


            <input type="submit" value="Post" name="submit">
        </form>
    </div>    
    </body>
</html>
