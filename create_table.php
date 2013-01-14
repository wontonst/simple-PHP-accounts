<?php
require_once('config.php');

$query=<<<QUERY
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `$database_name` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `simplePHPaccounts`;

CREATE TABLE IF NOT EXISTS `users` (
  `usr` varchar(20) NOT NULL,
  `pwd` varchar(80) NOT NULL,
  `email` varchar(20) NOT NULL,
  `session` int(11) NOT NULL,
  `sessionID` varchar(80) NOT NULL,
  `metadata` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
QUERY;

$connection = new mysqli($mysql_server,$mysql_username,$mysql_password);
$connection->query($query);

?>