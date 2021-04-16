<?php
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if(isset($_GET['date']) == TRUE) {
        $explodeddate = explode("-", $_GET['date']);
        $month = $explodeddate[0];
        $year = $explodeddate[1];
        $numdays = date("t", time()); //0, 0, 0, $month, 1, $year
    } else {
        $month = date("n", time());
        $numdays = date("t", time());
        $year = date("Y", time());
    }

    $displaydate = date("F Y", time());

    if($month == 1) {
        $prevdate = "12-" . ($year-1);
    } else {
        $prevdate = ($month-1) . "-" . $year;
    }

    if($month == 12) {
        $nextdate = "1-" . ($year+1);
    } else {
        $nextdate = ($month+1) . "-" . $year;
    }

    echo "<span class='datepicker'>";
    echo "<a href='view.php?date=" . $prevdate . "'>&larr;</a> ";  //$SCRIPT_NAME
    echo $displaydate;
    echo " <a href='view.php?date=" . $nextdate . "'>&rarr;</a> "; //$SCRIPT_NAME
    echo "</span>";
    echo "<br />";
?>

        <div id="eventcage">
        <p>To view event information here, click on the item in the
        calendar.</p>
        </div>

<?php
    echo "<h1>Latest events</h1>";
    echo "<ul>";
    $nearsql = "SELECT * FROM events ORDER BY starttime;";
    $nearres = mysqli_query($link, $nearsql) or die("Unable to execute the query"). " Error Code: " . mysqli_errno;
    $nearnumrows = mysqli_num_rows($nearres);
    

    if ($nearnumrows == 0) {
        echo "No events!";
    } else {
        while ($nearrow = mysqli_fetch_assoc($nearres)) {
            echo "<li><a href='#' onclick='getEvent("                   //displays info for events in sidebar
            . $nearrow['id'] . ")'>" . $nearrow['name'] . "</a> (<i>"
            . $nearrow['date'] . "</i>)</li>";
        }
    }

    echo "</ul>";
?>

if(isset($_GET['date']) == TRUE) {
        $explodeddate = explode("-", $_GET['date']);
        $month = $explodeddate[0];
        $year = $explodeddate[1];
        $numdays = date("t", time()); //0, 0, 0, $month, 1, $year
    } else {
        $month = date("n", time());
        $numdays = date("t", time());
        $year = date("Y", time());
    }

    $displaydate = date("F Y", time());

    if($month == 1) {
        $prevdate = "12-" . ($year-1);
    } else {
        $prevdate = ($month-1) . "-" . $year;
    }

    if($month == 12) {
        $nextdate = "1-" . ($year+1);
    } else {
        $nextdate = ($month+1) . "-" . $year;
    }
    

    echo "<span class='datepicker'>";
    echo "<a href='view.php?date=" . $prevdate . "'>&larr;</a> ";  //$SCRIPT_NAME
    echo $displaydate;
    echo " <a href='view.php?date=" . $nextdate . "'>&rarr;</a> "; //$SCRIPT_NAME
    echo "</span>";
    echo "<br />";
?>

        <div id="eventcage">
        <p>To view event information here, click on the item in the
        calendar.</p>
        </div>

<?php
    echo "<h1>Latest events</h1>";
    echo "<ul>";
    $nearsqlsas = "SELECT * FROM events ORDER BY starttime;";
    $nearres = mysqli_query($link, $nearsql) or die("Unable to execute the query"). " Error Code: " . mysqli_errno;
    $nearnumrows = mysqli_num_rows($nearres);
    

    if ($nearnumrows == 0) {
        echo "No events!";
    } else {
        while ($nearrow = mysqli_fetch_assoc($nearres)) {
            echo "<li><a href='#' onclick='getEvent("
            . $nearrow['id'] . ")'>" . $nearrow['name'] . "</a> (<i>"
            . $nearrow['date'] . "</i>)</li>";
        }
    }

    echo "</ul>";
?>

