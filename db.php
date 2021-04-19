<?php
require("config.php");
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
mysqli_select_db($link, DB_NAME);
?>