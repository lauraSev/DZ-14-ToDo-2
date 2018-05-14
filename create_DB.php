<?php  
$mysqli = mysqli_connect("localhost", "severyuhina", "neto1715", "severyuhina");
if (!$mysqli) die ('нет подключения к mysqli');  
$res = mysqli_query($mysqli, "SET NAMES 'utf-8'");
echo mysqli_error($mysqli).'<br>';
$res = mysqli_query($mysqli, "SET NAMES utf8 COLLATE utf8_general_ci");
echo '7'.mysqli_error($mysqli).'<br>';
$res = mysqli_query($mysqli, "SET time_zone = '+00:00'");
echo mysqli_error($mysqli).'9<br>';
$res = mysqli_query($mysqli, "SET foreign_key_checks = 0");
echo mysqli_error($mysqli).'11,<br>';
$res = mysqli_query($mysqli, "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
echo mysqli_error($mysqli).'13<br>';
$res = mysqli_query($mysqli, "DROP TABLE IF EXISTS tasks");
echo mysqli_error($mysqli).'15<br>';
$res = mysqli_query($mysqli, "CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `is_done` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE=InnoDB DEFAULT CHARSET=utf8");
echo mysqli_error($mysqli).'23<br>';
$res = mysqli_query($mysqli, "SHOW TABLES");
echo mysqli_error($mysqli).'25<br>';
while ($row = mysqli_fetch_assoc($res)) 
    print_r($row);	
?>