<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-14 23:59:06
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-22 12:07:04
 */
session_name('_user');
session_start();
$_user_name = '';
$_user_id = $_SESSION['id'] ?? 0;
if (!$_user_id) {
    header("location: index.php");
}else{
	$_user_name = $_SESSION['name'];
}

include_once "functions.php";
$status = filter_input(INPUT_GET,'status', FILTER_SANITIZE_URL) ?? 0;

include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connection,'utf8');
$status = 0;
if (!$connection) {
    throw new Exception("Can Not Connect TO Database"); 
}

$email = "";
if (isset($_POST['submit'])) {
	$email = filter_var(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING), FILTER_SANITIZE_EMAIL);
}

$query = "SELECT * FROM student_info"??"";
if ($email) {
	$query = "SELECT * FROM student_info WHERE email LIKE '{$email}%'";
}
else{
	$query = "SELECT * FROM student_info";
}


$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
</head>
<body style="padding: 100px 0px;">
	<div class="container" id="main">
		
	    <div class="row navigation">
        	<div class="column column-60">
        		<div class="formc">
                    <nav>
                       <a href="home.php">Home</a> | <a href="create.php">Add Student</a> 
                   </nav>
                    <h3>Student View</h3>
                    <a href="logout.php">logout(<?php echo $_user_name; ?>)</a>
                </div>
        	</div>
        	<div class="column column-60">
        		<form method="POST">
        			<input type="text" placeholder="search" name="email">
        			<button name="submit" value="submit">😁</button>
        		</form>
        		
        	</div>
        </div>
    </div>

	<?php 

        if (mysqli_num_rows($result) == 0) {
            echo "No result Found";
        }else{ ?>
            <table style="padding: 0px 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Birth Date</th>
                        <th>Phone</th>
                        <th>Image</th>
                        <th>City</th>
                        <th>Distric</th>
                        <th>Add User</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Language</th>
                        <th>Country</th>
                        <th>th</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($data = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                              <td><?php echo $data['id']; ?></td>
                              <td><?php echo $data['name']; ?></td>
                              <td><?php echo $data['email']; ?></td>
                              <td><?php echo $data['birth_date']; ?></td>
                              <td><?php echo $data['phone']; ?></td>
                              <td><img style="height: 60px; object-fit: cover;" src="<?php echo $data['image']; ?>" alt="img"></td>
                              <td><?php echo $data['city']; ?></td>
                              <td><?php echo $data['distric']; ?></td>
                              <td><?php echo $data['user_id']; ?></td>
                              <td><?php echo $data['gender']; ?></td>
                              <td><?php echo $data['age']; ?></td>
                              <td><?php echo $data['language']; ?></td>
                              <td><?php echo $data['country']; ?></td>
                              <td><a href="#">Edit</a>|<a href="#">Delete</a></td>
                            </tr>
                        <?php }
                        mysqli_close($connection);
                    ?>
                    
                </tbody>
            </table>
        <?php }
    ?>
</body>
</html>