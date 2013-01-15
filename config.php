<?php

//MYSQL INFORMATION
$database_name='simplePHPaccounts';//name of your SQL database, this will be created
$mysql_server='localhost';//your server location (do not change if you
                                                //dont know what this is)
$mysql_username='';//your username
$mysql_password='';//your password

//OTHER INFORMATION
$salt = '$6$s%3F81@o$';//password hashing salt, change everything after 
                                          //$6$ to what you like
$sessiontimeout = 79200;//session expiration in seconds (79200 = 24hrs)
?>