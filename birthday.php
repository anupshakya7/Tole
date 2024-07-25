<?php
require('nepali-date.php');
$birthday = '1995-02-08';
$e_birthday = explode('-', $birthday); //Seperate the year month and day
//Lets convert it to nepali date

$nepali_birthday = new nepali_date();
$bday = $nepali_birthday->get_nepali_date($e_birhtday['0'], $e_birhtday['1'], $e_birhtday['2']);
$bmd = $bday['m'].'-'.$bday['d'];

//Lets find todays date
$y = date('Y', time()); //Getting Year
$m = date('m', time()); //Getting Month
$d = date('d', time()); //Getting Day
$today = $nepali_date->get_nepali_date($y, $m, $d);
$tmd = $today['m'].'-'.$today['d'];

//Lets match
if($bmd==$tmd){echo "Happy Birthday";};

?>