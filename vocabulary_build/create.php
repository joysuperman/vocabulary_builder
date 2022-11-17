<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-14 23:59:06
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-21 17:17:33
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
                       <a href="home.php">Home</a> | <a href="edit.php">Edit Student</a>
                    </nav>
                    <form id="form03" method="post" action="task.php" enctype="multipart/form-data">
                        <h3>Student Registration</h3>
                        <a href="logout.php">logout(<?php echo $_user_name; ?>)</a>
                        <br>

                        <?php
                            if (4 == $status)  {
                               echo "<blockquote style='color: green;'>Successfully Added Student Done!</blockquote>";
                            }
                        ?>
                        <fieldset>
                            <label for="name">Name</label>
                            <input type="text" placeholder="Name" id="name" name="name">

                            <label for="birthday">Birth Date</label>
                            <input type="date" placeholder="Birthday" id="birthday" name="birthday">

                            <label for="email">Email</label>
                            <input type="email" placeholder="Email Address" id="email" name="email">

                            <label for="tel">phone</label>
                            <input type="tel" placeholder="Phone tel" id="tel" name="phone">

                            <label for="city">City</label>
                            <input type="text" placeholder="City" id="city" name="city">

                            <label for="dist">Distric</label>
                            <input type="text" placeholder="Distric" id="dist" name="distric">

                            <label for="img">Image</label>
                            <input type="file" placeholder="Image" id="img" name="img">

                            <div class="row navigation">
        						<div class="column">
        							<fieldset>
			                        	<p>Gender: </p>
										
										<label for="male"><input type="radio" id="male" name="gender" value="Male"> Male</label>
										<label for="female"><input type="radio" id="female" name="gender" value="FeMale"> FeMale</label>
										<label for="unisex"><input type="radio" id="unisex" name="gender" value="unisex"> Unisex</label>
									</fieldset>
        						</div>
        						<div class="column">
        							<fieldset>
										<p>Age:</p>
										
										<label for="age1"><input type="radio" id="age1" name="age" value="30"> 0 - 15</label>
										<label for="age2"><input type="radio" id="age2" name="age" value="60"> 16 - 30</label>
										<label for="age3"><input type="radio" id="age3" name="age" value="100"> 31 - 45</label>
									</fieldset>
        						</div>
        						<div class="column">
        							<fieldset>
										<p>Language:</p>
										
										<label for="language1"><input type="checkbox" id="language1" name="language[]" value="Bangla" <?php isCheckedCheckBox('language','Bangla'); ?>> Bangla</label>
										<label for="language2"><input type="checkbox" id="language2" name="language[]" value="English" <?php isCheckedCheckBox('language','English'); ?>> English</label>
										<label for="language3"><input type="checkbox" id="language3" name="language[]" value="Spanish" <?php isCheckedCheckBox('language','Spanish'); ?>> Spanish</label>
									<fieldset>
        						</div>

        						<div class="column">
        							<fieldset>
										<p>Country:</p>
										<?php 
											$country = ["Bangladesh","India","Srilanka","Nepal","Vutan"];
										?>
										<select name="country" id="country">
										  	<option value="" disabled selected>Select Country</option>
										  	<?php echo selectItem($country) ?>
										</select>
									</fieldset>
        						</div>
        					</div>
							
                            <?php
                                if ($status)  {
                                    getStatusMessage($status);
                                }
                            ?>

                            <input class="button-primary" type="submit" value="Submit">
                            <input type="hidden" name="action" id="addStudent" value="addStudent">
                        </fieldset>
                    </form>
                </div>
        	</div>
        </div>
	</div>

</body>
</html>