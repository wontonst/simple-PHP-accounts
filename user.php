<?php

require_once('config.php');

/**
  Stores information about a user and interacts with mySQL database to modify persistent user data.
 */
class User {

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

    public function __construct() {
        
    }

    /**
      Retrieves data in $this->data
     */
    public function __get($value) {
        if (isset($this->data['$value']))
            return $this->data['$value'];
        else
            throw new Exception("User: cannot __get($value) because it does not exist in $this-.data");
    }

    /**
      Logs the user in.
      @param $u username
      @param $p password
     */
    public function login($u, $p) {
        
    }

    /**
      Changes the user's password.
      @param @u username
      @param $op old password
      @param $np new password
     */
    public function changePassword($u, $op, $np) {
        
    }

    /**
      Creates a new user
      @param $u username
      @param $p password
      @param $e email (optional)
     */
    public static function create($u, $p, $e) {
        global $database_name, $mysql_server, $mysql_username, $mysql_password;
        $sql = new mysqli($mysql_server, $mysql_username, $mysql_password,$database_name);
        if ($sql->connect_errno)
            die('Failed to connect to MySQL: ' . $mysqli->connect_error);

        $query = 'SELECT * FROM users WHERE usr=\''.$u.'\';';
echo $query;
        $results = $sql->query($query) or die('MySQL Error: ' . $sql->connect_error);
        if ($results->num_rows != 0)
            throw new Exception('User creation failed: User already exists');

        $password = User::hash($p);
        $email = isset($e) ? $e : 'null';
        $query = 'INSERT INTO users (usr,pwd,email)
               VALUES (\'' . $u . '\',\'' . $password . '\',\'' . $email . '\');';
        $sql->query($query);
    }

    public static function hash($value) {
        global $salt;
        return crypt($value, $salt);
    }

}


?>