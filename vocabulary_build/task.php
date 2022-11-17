<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-14 10:53:25
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-21 12:02:24
 */

session_name('_user');
session_start();

include_once "config.php";

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connection,'utf8');
$status = 0;
if (!$connection) {
	throw new Exception("Can Not Connect TO Database");	
}
else{
	$action = filter_var(filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING)?? "";

	if (!$action) {
		header('location: index.php');
		die();
	}else{
		
		if ('register' == $action) {
	 		$name = filter_var(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING) ?? "";
			$email = filter_var(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING), FILTER_VALIDATE_EMAIL) ?? "";
			$password = filter_var(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING) ?? "";

		 	if ($name && $email && $password) {
		 		$hash = password_hash($password, PASSWORD_BCRYPT);

		 		$query = "INSERT INTO user_info (name,email,password) VALUES ('{$name}','{$email}','{$hash}')";
		 		mysqli_query($connection, $query);
		 		if (mysqli_error($connection)) {
		 			$status = 1;
		 		}
		 		else{
		 			$status = 4;
		 		}
		 	}
		 	else{
		 		$status = 2;
		 	}
		 	header("location: index.php?page=registar&&status={$status}");

		}else if ('login' == $action) {
			$email = filter_var(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING), FILTER_VALIDATE_EMAIL) ?? "";
			$password = filter_var(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING) ?? "";

			if ($email && $password) {
				$query = "SELECT id,name,password FROM user_info where email='{$email}'";
				$result = mysqli_query($connection,$query);

				if (mysqli_num_rows($result) > 0) {
					$data = mysqli_fetch_assoc($result);
					$_id = $data['id'];
					$_name = $data['name'];
					$_password = $data['password'];
					if (password_verify($password, $_password)) {
						$status = 6;
						$_SESSION['id'] = $_id;
						$_SESSION['name'] = $_name;
						header("location: home.php");
						die();
					}
					else{
						$status = 3;
					}
				}else{
					$status = 5;
				}
			}else{
		 		$status = 2;
		 	}
		 	header("location: index.php?page=login&&status={$status}");
		 	
		}else if ('addStudent' == $action) {
			$name = filter_var(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING)??'';
			$birthday = filter_var(filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING)??'';
			$email = filter_var(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING), FILTER_VALIDATE_EMAIL)??'';
			$phone = $_REQUEST['phone']??'';
			$image = "";
			$allowTypes = array(
				'image/png',
				'image/jpg',
				'image/jpeg'
			);
			if ($_FILES['img']) {
				if (in_array($_FILES['img']['type'], $allowTypes) != false && $_FILES['img']['size'] < 2*1024*1024 ) {
					move_uploaded_file($_FILES['img']['tmp_name'], "upload/".$_FILES['img']['name']);
					$image = "upload/".$_FILES['img']['name'];
				}else{
					$image = "";
				}
			}
			$city =	filter_var(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING)??'';
			$distric = filter_var(filter_input(INPUT_POST, 'distric', FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRING)??'';
			$user_id = $_SESSION['id']??0;
			$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING)??'';
			$age = filter_var(filter_input(INPUT_POST, 'age', FILTER_SANITIZE_STRING), FILTER_VALIDATE_INT)??'';
			$language = "";
			$selectLang = $_POST['language'];
		    foreach($selectLang as $lang)  
		   	{  
		      	$language .= $lang.",";  
		   	}

			$country = $_REQUEST['country']??'';
			if ($name && $birthday && $email && $phone && $image && $city && $distric && $user_id && $gender && $age && $language && $country ) {
				
				$query = "INSERT INTO student_info (name,email,birth_date,phone,image,city,distric,user_id,gender,age,language,country) VALUES ('{$name}','{$email}','{$birthday}','{$phone}','{$image}','{$city}','{$distric}','{$user_id}','{$gender}','{$age}','{$language}','{$country}')";

				// echo "$query";
				mysqli_query($connection, $query);
			 	if (mysqli_error($connection)) {
		 			$status = 1;
		 		}
		 		else{
		 			$status = 4;
		 		}
			}else{
	 		 	$status = 2;
	 		 	// echo "$name","$email","$birthday","$phone","$image","$city","$distric","$user_id","$gender","$age","$language","$country";
		 	}


		 	if (4 == $status) {
		 		header("location: home.php");
		 	}else{
		 		header("location: create.php?status={$status}");
		 	}
			
		}
	}
}