<?php
require("db.php");
$sql = "DELETE FROM events WHERE id = " . $_GET['id'];
mysqli_query($link, $sql);
echo "<script>javascript: history.go(-1)</script>";
?>