<?php
 
/**
Stores information about a user and interacts with mySQL database to modify persistent user data.
*/
class User{

/**
Contains the following keys. Not all of them may be set.
<ul>
<li>usr</li>
<li>pwd</li>
<li>email</li>
<li>sessiontime</li>
<li>sessionid</li>
</ul>
*/
private $data;
private $meta;
public function __construct()
{

}
public function __get($value)
{
if(isset($this->data['$value']))
return $this->data['$value'];
else throw new Exception("User: cannot __get($value) because it does not exist in $this-.data");
}
public function getIdeas()
{

}
public function getProjects()
{

}
/**
Logs the user in.
@param $u username
@param $p password
*/
public function login($u,$p)
{

}
/**
Changes the user's password.
@param @u username
@param $op old password
@param $np new password
*/
public function changePassword($u,$op,$np)
{

}
public static function create($u,$p,$e)
{

}

}

?>