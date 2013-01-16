<?php

require_once('user.php');

//IMPORTANT - make sure you edit config.php and run create_table.php first

//create a user
try {
    User::create('myusername','mypassword','myoptionalemail');
} catch(Exception $e) {
//username already taken
}

//spawn a new session ID valid for 24hrs by default (edit in config)
$sessionID = User::newSession();

//login with password
if(!$user_obj = User::loginPassword('myusername','mypassword')) {
//login information is bad
}

//login with sessionID
if(!$user_obj = User::loginSession('myusername',$sessionID)) {
//sessionID given does not match stored sessionID - this should not happen
}

//changepassword
if(!User::changePassword('myusername','mypassword','newpassword')) {
//username/password do not match, new password not accepted
}

echo $user_obj->email;//prints out user email
?>
