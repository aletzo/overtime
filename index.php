<?php

error_reporting(-1);


function getHoursDiff($date, $start, $end)
{
    
    $date1 = strtotime("$date $start:00");
    $date2 = strtotime("$date $end:00");

    $startHours = substr($start, 0, 2);

    if ($startHours < 5) { // after midnight
        $date1 += 24 * 3600;
    }

    $endHours = substr($end, 0, 2);

    if ($endHours < 10) { // after midnight
        $date2 += 24 * 3600;
    }

    return round(abs($date1 - $date2) / 3600, 2);
}

function getStartTime($hours)
{
    $hours = trim($hours);

    if (strlen($hours) != 13) {
        return null;
    }

    return substr($hours, 0, 5);
}

function getEndTime($hours)
{
    $hours = trim($hours);

    if (strlen($hours) != 13) {
        return null;
    }

    return substr($hours, -5);
}


$file2008= <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2009 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2010 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2011 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2012 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2013 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2014 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2015 = <<<YIPPEEKAYAY
YIPPEEKAYAY;

$file2016 = <<<YIPPEEKAYAY
YIPPEEKAYAY;


$files = array(
    2008 => $file2008,
    2009 => $file2009,
    2010 => $file2010,
    2011 => $file2011,
    2012 => $file2012,
    2013 => $file2013,
    2014 => $file2014,
    2015 => $file2015,
    2016 => $file2016
);

$overtimeHours = 0;

foreach($files as $filename => $file) {

    $lines = explode("\n", $file);

    $lesstime        = 0;
    $overtime        = 0;
    $weekendOvertime = 0;
    $totalOvertime   = 0;

    foreach ($lines as $line) {
        $beginning = substr($line, 0, 10);

        $slashesCount = substr_count($beginning, '-');

        if ($slashesCount != 2) {
            continue;
        }

        list($day, $month, $year) = explode('-', $beginning);

        $dateTime = new DateTime("$year-$month-$day");

        $start  = strpos($line, '(');
        $end    = strpos($line, ')', $start + 1);
        $length = $end - $start;
        $hours  = substr($line, $start + 1, $length - 1);

        $dayName = $dateTime->format('D');

        $date = $dateTime->format('Y-m-d');

        $color = '#555';

        if (strpos($hours, ',') !== false) {
            $parts = explode(',', $hours);
            
            $workedHours = 0;

            foreach ($parts as $part) {

    //echo "$part <br>";

                $startTime = getStartTime($part);
                $endTime   = getEndTime($part);

                if ( ! $startTime
                    ||
                    ! $endTime
                ) {
                    continue;
                }
            
                $workedHours += getHoursDiff(
                    $date,
                    $startTime,
                    $endTime
                );
            }

        } else {

    //echo "$hours <br>";

            $startTime = getStartTime($hours);
            $endTime   = getEndTime($hours);

            if ( ! $startTime
                ||
                ! $endTime
            ) {
                $color = 'green';
            }
            
            $workedHours = getHoursDiff(
                $date,
                $startTime,
                $endTime
            );
        }

        
        if ($workedHours > 8) {
            $color = 'orange';

            $overtime += $workedHours - 8;
        }

        if ($workedHours > 16) { // error in calculation
            $color = 'blue';
        }

        if ($dayName == 'Sat'
            ||
            $dayName == 'Sun'
        ) {
            $color = 'red';

            $weekendOvertime += $workedHours;

            $displayDiff = $workedHours;
        } else {
            if ($workedHours < 8) {
                $lesstime += 8 - $workedHours;
            }

            $displayDiff = $workedHours - 8;
        }

        $totalOvertime = $overtime + $weekendOvertime - $lesstime;

//    echo <<<YIPPEEKAYAY
//<span style="color:$color">
//    $date : $workedHours ($displayDiff)
//</span>
//<br>
//YIPPEEKAYAY;
    }

    $overtimeHours += $totalOvertime;

    echo <<<YIPPEEKAYAY
$filename
<br>
weekday overtime: $overtime hours
<br>
weekday lesstime: $lesstime hours
<br>
weekend overtime: $weekendOvertime hours
<br>
total overtime:  $totalOvertime hours
<br>
<br>
<br>
YIPPEEKAYAY;


}

echo 'Sum <br>';

echo "$overtimeHours hours <br>";

$overtimeDays = round( $overtimeHours / 8, 2 );

echo " $overtimeDays days <br>";

$overtimeWeeks = round( $overtimeDays / 5 );

echo " $overtimeWeeks weeks <br>";

$overtimeMonths = round( $overtimeWeeks / 4 );

echo " $overtimeMonths months <br>";

