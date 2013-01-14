<?php

require_once('user.php');

//IMPORTANT - make sure you edit config.php and run create_table.php first

//create a user
User::create('myusername','mypassword','myoptionalemail');

//spawn a new session ID valid for 24hrs by default (edit in config)
$sessionID = User::newSession();

//login with password
$user_obj = User::loginPassword('myusername','mypassword');

//login with sessionID
$user_obj = User::loginSession('myusername',$sessionID);

//changepassword
User::changePassword('myusername','mypassword','newpassword');
?>