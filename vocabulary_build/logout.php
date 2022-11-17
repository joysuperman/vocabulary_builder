<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-15 00:23:04
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-15 00:24:55
 */
session_name('_user');
session_start();
$_SESSION['id'] = 0;
session_destroy();
header("location: home.php");