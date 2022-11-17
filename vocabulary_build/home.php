<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-14 23:59:06
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-21 17:16:11
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
$query = "SELECT * FROM student_info";
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
<body>
	<div class="container" id="main">
		
	    <div class="row navigation">
        	<div class="column column-60 column-offset-20">
        		<div class="formc">
                    <nav>
                       <a href="create.php">Add Student</a> | <a href="edit.php">Edit Student</a>
                   </nav>
                    <h3>Student View</h3>
                    <a href="logout.php">logout(<?php echo $_user_name; ?>)</a>
                </div>
        	</div>
        </div>

        <?php 
            if (mysqli_num_rows($result) == 0) {
                echo "No result Found";
            }else{ ?>
                <table>
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
                                </tr>
                            <?php }
                            mysqli_close($connection);
                        ?>
                        
                    </tbody>
                </table>
            <?php }
        ?>
        

	</div>

</body>
</html>