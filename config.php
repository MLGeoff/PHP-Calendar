<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Password1');
define('DB_NAME', 'demo');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_select_db($link, DB_NAME);

$config_author = "Jeff, Dean, Joe, and Jules.  my rok";
$config_basedir = "http://projects:8080/calendarProject/";
$config_name = "My Calendar";

if($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>