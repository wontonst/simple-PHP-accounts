<?php
require_once('config.php');

$query1="CREATE DATABASE `$database_name` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
$query2=<<<QUERY
        CREATE TABLE IF NOT EXISTS `users` (
            `usr` varchar(20) NOT NULL,
            `pwd` varchar(100) NOT NULL,
            `email` varchar(20) NOT NULL,
            `session` int(11) NOT NULL,
            `sessionID` varchar(40) NOT NULL,
            `metadata` longtext NOT NULL,
            PRIMARY KEY (`usr`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
QUERY;

$connection = new mysqli($mysql_server,$mysql_username,$mysql_password);
if($connection->connect_errno)die('Failed to connect to MySQL: '.$mysqli->connect_error);

echo 'Creating database...';
$connection->query($query1);
echo "done\n";
echo 'Creating tables...';
$connection->select_db($database_name);
if(!$connection->query($query2))die($connection->connect_error);
echo "done\n";
?>