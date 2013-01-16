simple-PHP-accounts
===================

simple user accounts system using PHP/mySQL
I have dumbed the system down to 4 simple function calls, all listed in sample.php
Code is documented in doxygen/javadoc style

This is intended to work under any environment. If you are using a framework, copy config.php into user.php to resolve inclusion issues.

1. Have a PHP/mySQL setup ready
2. Edit config.php to your likings
3. run command "php create_tables.php" to create database with tables
4. Take a look below or in sample.php for directions
<pre>
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
    </pre>
