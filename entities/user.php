<?php
namespace Accounts\Entities;

/**
Stores information about a user.
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

}

?>