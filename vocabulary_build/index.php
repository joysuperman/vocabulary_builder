<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-14 10:37:18
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-21 00:06:19
 */
session_name('_user');
session_start();
$_user_name = '';
$_user_id = $_SESSION['id'] ?? 0;
if ($_user_id) {
    header("location: home.php");
    $_user_name = $_SESSION['name'];
}

include_once "functions.php";
$status = filter_input(INPUT_GET,'status', FILTER_SANITIZE_URL) ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vocabulary Builder</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
</head>
<body class="home">
<div class="container" id="main">
    
    <h1 class="maintitle" style="text-align: center;">
        <i class="fas fa-language"></i> <br/>My Crud In Database
    </h1>

    <div class="row navigation">
        <div class="column column-60 column-offset-20">
            <div class="formaction">
                <a href="index.php?page=login">Login</a> | <a href="index.php?page=registar">Register Account</a>
            </div>

            <?php 
                $page = filter_input(INPUT_GET,'page', FILTER_SANITIZE_STRING) ?? 'login';
                if ('registar' == $page) { ?>
                    <div class="formc">
                        <form id="form02" method="post" action="task.php">
                            <h3>Registration</h3>
                            <?php
                                if (4 == $status)  {
                                   echo "<blockquote style='color: green;'>Successfully User Added Done!</blockquote>";
                                }
                            ?>
                            <fieldset>
                                <label for="name">Name</label>
                                <input type="text" placeholder="Name" id="name" name="name">
                                <label for="email">Email</label>
                                <input type="email" placeholder="Email Address" id="email" name="email">
                                <label for="password">Password</label>
                                <input type="password" placeholder="Password" id="password" name="password">

                                <?php
                                    if ($status)  {
                                        getStatusMessage($status);
                                    }
                                ?>

                                <input class="button-primary" type="submit" value="Submit">
                                <input type="hidden" name="action" id="register" value="register">
                            </fieldset>
                        </form>
                    </div>
                <?php 
                }
                else{ ?>
                    <div class="formc">
                        <form id="form01" method="post" action="task.php">
                            <h3>Login</h3>
                            <fieldset>
                                <?php
                                    if (6 == $status)  {
                                       echo "<blockquote style='color: green;'>Login Successfull!</blockquote>";
                                    }
                                ?>
                                <label for="email">Email</label>
                                <input type="text" placeholder="Email Address" id="email" name="email">
                                <label for="password">Password</label>
                                <input type="password" placeholder="Password" id="password" name="password">
                                <?php
                                    if ($status)  {
                                        getStatusMessage($status);
                                    }
                                ?>
                                <input class="button-primary" type="submit" value="Submit">
                                <input type="hidden" name="action" id="login" value="login">
                            </fieldset>
                        </form>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>