<?php
    session_start();
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

    if (isset($_SESSION['LOGGEDIN']) == FALSE) {
        header("Location: ". $config_basedir);
    }

    function short_event($name) {
        $final = "";
        $final = (substr($name, 0, 12) . "...");

        return $final;
    }

?>
    <!DOCTYPE html>
    <head>
        <title>Calendar Project</title>
        <script language="javascript" type="text/javascript" src="./internal_request.js"></script>
        <link href="stylesheet.css" rel="stylesheet">
    </head>
        
    <body>
        <div id="header">
            <h1><?php echo $config_name; ?></h1>
        </div>
        <div id="menu">
            &bull;
            <a href="<?php echo $config_basedir; ?>">This month</a>
            &bull;
            <a href="<?php echo $config_basedir; ?>logout.php">Logout</a>
            &bull;
        </div>

        <div id="container">
            <div id="bar">
            <?php

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
<p>To view event information here, click on the item in
the calendar.</p>
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
            echo "<li><a href='#' onclick='getEvent("
            . $nearrow['id'] . ")'>" . $nearrow['name'] . "</a> (<i>"
            . $nearrow['date'] . "</i>)</li>";
        }
    }

    echo "</ul>";
?>
            </div>
        </div>
    </body>
</html>

<?php
    
    $cols = 7;
    //$weekday = date("w", mktime(0, 0, 0, $month, 1, $year));
    $weekday = date("w", time());
    $numdays = date("t", time()); //0, 0, 0, $month, 1, $year
    $numrows = ceil(($numdays + $weekday) / $cols);
    echo "<br />";
    echo "<table class='cal' cellspacing=0 cellpadding=5 border=1>";
    echo "<tr>";
    echo "<th class='cal'>Sunday</th>";
    echo "<th class='cal'>Monday</th>";
    echo "<th class='cal'>Tuesday</th>";
    echo "<th class='cal'>Wednesday</th>";
    echo "<th class='cal'>Thursday</th>";
    echo "<th class='cal'>Friday</th>";
    echo "<th class='cal'>Saturday</th>";
    echo "</tr>";
    $counter = 1;
    $newcounter = 1;

    echo "<tr>";
    $daysleft = 6 - $weekday;

    for($f=0;$f<=$weekday;$f++) {
        echo "<td class='cal_date' width='110' height='10'>";
        echo "</td>";
    }

    for($f=0;$f<=$daysleft;$f++) {
        echo "<td class='cal_date' width='100' height='10'>";
        $display = date("jS", mktime(0, 0, 0, $month, $counter, $year));
        $todayday = date("d");
        $todaymonth = date("n");
        $todayyear = date("Y");
        if($counter == $todayday AND $month == $todaymonth AND
        $year == $todayyear) {
        echo "<strong>TODAY " . $display . "</strong>";
    } else {
        echo $display;
    }
    echo "</td>";
    $counter++;
    }
    echo "</tr>";

    echo "<tr>";
    for($f=0;$f<=$weekday;$f++) {
        echo "<td class='cal' width='110' height='10'>";
        if($newcounter <= $numdays) {
    }
        echo "</td>";
    }

    for ($f=0; $f<=$daysleft; $f++) {
        echo "<td class='cal' width='110' height='40'>";

            $date = $year . "-" . $month . "-" . $newcounter;
            echo "<a class='cal' href='#' onclick=\"newEvent('" . $date . "')\"></a>";

            $eventsql = "select * from events where date = '" . $date . "';";
            $eventres = mysqli_query($link, $eventsql);

            while ($eventrow = mysqli_fetch_assoc($eventres)) {
                echo "<a class='deleteevent' href='delete.php?id=" . $eventrow['id'] . "' onclick=\"return confirm('Are you sure
                you want to delete 1". $eventrow['name'] ."`?');\">X</a>";
                echo "<a class='event href='#' onclick='getEvent(". $eventrow['id'] . ")'>" . short_event($eventrow['name']) . "</a><br />";
            }

            echo "</td>";
            $newcounter++;
    }

    echo "</tr>";

    for ($i=1; $i<=($numrows-1); $i++) {
        echo "<tr>";

        for ($a=0; $a <= ($cols-1); $a++) {
            echo "<td class'cal_date' width='110' height='10'>";

            $display = date("jS", mktime(0, 0, 0, $month, $counter, $year));

            $todayday = date("d");
            $todaymonth = date("n");
            $todayyear = date("Y");

            if ($counter == $todayday AND $month == $todaymonth AND $year == $todayyear ) {
                echo "<strong>TODAY " . $display . "</strong>";

            } else {
                echo $display;
            }

            echo "</td>";
            $counter++;
        }

        echo "</tr>";

        echo "<tr>";

        for($aa=1;$aa<=$cols;$aa++) {
            echo "<td class='cal' width='110' height='40'>";
            if($newcounter <= $numdays) {
            $date = $year . "-" . $month . "-" . $newcounter;
            echo "<a class='cal' href='#' onclick=\"newEvent('" . $date
            . "')\"></a>";
            //$eventsql = "SELECT * FROM events WHERE date = '" . $date
            //. "';";
            $eventsql = "select * from events where date = '" . $date . "';";
            $eventres = mysqli_query($link, $eventsql);
            while($eventrow = mysqli_fetch_assoc($eventres)) {
            echo "<a class='deleteevent' href='delete.php?id="
            . $eventrow['id'] . "' onclick=\"return confirm('Are you sure
            you want to delete `" . $eventrow['name'] ."`?');\">X</a>";
            echo "<a class='event' href='#' onclick='getEvent("
            . $eventrow['id'] . ")'>" . short_event($eventrow['name'])
            . "</a><br />";
            }
            }
            echo "</td>";
            $newcounter++;
            }
            echo "</tr>";
            }

    echo "</table>";
    require("footer.php");
?>

