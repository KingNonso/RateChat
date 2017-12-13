<?php
/**
 * Created by PhpStorm.
 * User: Nonny
 * Date: 4/12/15
 * Time: 1:05 AM
 */

class Date {

    /*#######################################################################################
######################## DATE AND TIME FUNCTIONS ########################################
#########################################################################################*/

    public  static  function daygen(){
        // this function generates the date number of the month

        $a=1;
        $b=31;
        //echo '<option value="0">Day</option>';
        while($a<=$b)
        {

            if($a <=9){
                $i = $a++;
                echo '<option  value="'.'0'.$i.'">'.'0'.$i.'</option>';
            }
            else {
                $i = $a++;
                echo '<option  value="'.$i.'">'.$i.'</option>';
            }
        }
    }
    public  static  function daygenJS(){
        // this function generates the date number of the month

        $a=1;
        $b=31;
        //echo '<option value="0">Day</option>';
        while($a<=$b)
        {

            if($a <=9){
                $i = $a++;
                echo '<option  value="'.$i.'">'.'0'.$i.'</option>';
            }
            else {
                $i = $a++;
                echo '<option  value="'.$i.'">'.$i.'</option>';
            }
        }
    }

    public  static  function monthgen(){
        //<option value="0">Month</option>
        echo '
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
		';
    }
    public  static  function monthgenJS(){
        //<option value="0">Month</option>
        echo '
        <option value="0">January</option>
        <option value="1">February</option>
        <option value="2">March</option>
        <option value="3">April</option>
        <option value="4">May</option>
        <option value="5">June</option>
        <option value="6">July</option>
        <option value="7">August</option>
        <option value="8">September</option>
        <option value="9">October</option>
        <option value="10">November</option>
        <option value="11">December</option>
		';
    }

    public  static  function yeargen($a = 1960){

        $b=date('Y');
        //echo '<option value="0">Year</option>';
        while($a<=$b){ $i = $b--;  echo '<option value="'.$i.'">'.$i.'</option>';}
    }
    public  static  function yearInFuture($start = 10){
        $date = new DateTime('now');
        $date->add(new DateInterval('P'.$start.'Y'));
        $a = $date->format('Y');
        $b=date('Y');
        //echo '<option value="0">Year</option>';
        while($a>=$b){ $i = $b++; echo '<option  value="'.$i.'">'.$i.'</option>';}
    }

    public function CheckDate($day,$month,$year){
        //check the validity of date as compared to standard calender time
        $gooddate = checkdate($month,$day,$year);
        $day1 = date_create($year, $month, $day);
        $day2 = date("Y-m-d");
        $pastdate = date_diff($day1,$day2);
        //then concatenate date into a single piece timestamp

    }
    /* ##############################################################################################################################
############################################ AUTOGENREATE A LIST OF NUMBERS ######################################################
##################################################################################################################################*/
    public  static function numeral(){
        $a=1;
        $b=100;
        echo '<option value="0">Select</option>';
        while($a<=$b)
        {
            echo '<option>'.$a++.'</option>';
        }
    }

/* Prints the day
date("l") . "<br>";

// Prints the day, date, month, year, time, AM or PM
date("l jS \of F Y h:i:s A");
*/
    // SETS THE TIME ZONE
//ini_set'date.timezone','Africa/Lagos');
    /* For a view of all the various time zones go to
    http://www.php.net/manual/en/timezones.php */

    /*
       d - The day of the month (from 01 to 31)
       D - A textual representation of a day (three letters)
       j - The day of the month without leading zeros (1 to 31)
       l (lowercase 'L') - A full textual representation of a day
       N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
       S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)
       w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
       z - The day of the year (from 0 through 365)
       W - The ISO-8601 week number of year (weeks starting on Monday)
       F - A full textual representation of a month (January through December)
       m - A numeric representation of a month (from 01 to 12)
       M - A short textual representation of a month (three letters)
       n - A numeric representation of a month, without leading zeros (1 to 12)
       t - The number of days in the given month
       L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)
       o - The ISO-8601 year number
       Y - A four digit representation of a year
       y - A two digit representation of a year
       a - Lowercase am or pm
       A - Uppercase AM or PM
       B - Swatch Internet time (000 to 999)
       g - 12-hour format of an hour (1 to 12)
       G - 24-hour format of an hour (0 to 23)
       h - 12-hour format of an hour (01 to 12)
       H - 24-hour format of an hour (00 to 23)
       i - Minutes with leading zeros (00 to 59)
       s - Seconds, with leading zeros (00 to 59)
       u - Microseconds (added in PHP 5.2.2)
       e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)
       I (capital i) - Whether the date is in daylights savings time (1 if Daylight Savings Time, 0 otherwise)
       O - Difference to Greenwich time (GMT) in hours (Example: +0100)
       P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)
       T - Timezone abbreviations (Examples: EST, MDT)
       Z - Timezone offset in seconds. The offset for timezones west of UTC is negative (-43200 to 50400)
       c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
       r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)
       U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)

   and the following predefined constants can also be used (available since PHP 5.1.0):

       DATE_ATOM - Atom (example: 2013-04-12T15:52:01+00:00)
       DATE_COOKIE - HTTP Cookies (example: Friday, 12-Apr-13 15:52:01 UTC)
       DATE_ISO8601 - ISO-8601 (example: 2013-04-12T15:52:01+0000)
       DATE_RFC822 - RFC 822 (example: Fri, 12 Apr 13 15:52:01 +0000)
       DATE_RFC850 - RFC 850 (example: Friday, 12-Apr-13 15:52:01 UTC)
       DATE_RFC1036 - RFC 1036 (example: Fri, 12 Apr 13 15:52:01 +0000)
       DATE_RFC1123 - RFC 1123 (example: Fri, 12 Apr 2013 15:52:01 +0000)
       DATE_RFC2822 - RFC 2822 (Fri, 12 Apr 2013 15:52:01 +0000)
       DATE_RFC3339 - Same as DATE_ATOM (since PHP 5.1.3)
       DATE_RSS - RSS (Fri, 12 Aug 2013 15:52:01 +0000)
       DATE_W3C - World Wide Web Consortium (example: 2013-04-12T15:52:01+00:00)
    */


} 