<?php
$db_host = 'localhost';
$db_username = 'r293685_actyUser';
$db_password = 'KK4#pxD15(QV';
$db_name = 'r293685_acty';
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}