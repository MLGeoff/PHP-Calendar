<?php
require("db.php");
if (isset($_GET['error'])) {
if(empty($_POST['name'])) {
$error = 1;
}
if(empty($_POST['description'])) {
$error = 1;
}
if($_POST['starthour'] > $_POST['endhour']) {
$error = 1;
}
if($_POST['starthour'] == $_POST['endhour']) {
$error = 1;
}
}
/*
if($error == 1) {
@header("Location: " ."view.php?error=1&eventdate=" . $_GET['date']);
exit;
} else {
*/
$elements = explode("-", $_POST['date']);
$redirectdate = $elements[1] . "-" . $elements[0];
$finalstart = $_POST['starthour'] . ":" . $_POST['startminute']
. ":00";
$finalend = $_POST['endhour'] . ":" . $_POST['endminute'] . ":00";
$inssql = "INSERT INTO events(date, starttime, endtime, name,
description) VALUES("
. "'" . $_POST['date']
. "', '" . $finalstart
. "', '" . $finalend
. "', '" . addslashes($_POST['name'])
. "', '" . addslashes($_POST['description'])
. "');";
mysqli_query($link, $inssql);
//header("Location: " . "view.php?date=". $redirectdate);

echo "<script>window.location.href='view.php'</script>";
?>