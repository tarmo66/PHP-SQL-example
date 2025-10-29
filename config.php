<?php
$db_host = 'localhost';
$db_username = 'user';
$db_password = 'password';
$db_name = 'database';
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
