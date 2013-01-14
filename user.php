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

    public function __construct($data) {
$this->data = $data;
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
    public static function loginPassword($u, $p) {
        $password = User::hash($p);
        $query = 'SELECT * FROM users WHERE usr=\'royz\'';// WHERE '."usr='$u';";// AND `pwd`='$password';";
        return User::login($query);
    }
    public static function loginSession($u,$s)
    {
        $query= 'SELECT * FROM users WHERE usr=\''.$u.'\' AND session=\''.$s.'\';';
        return User::login($query);
    }
    private static function login($query)
    {
        $sql=User::connect();
        $results = $sql->query($query) or die('MySQL Error line '.__LINE__.': ' . $sql->error);
        if ($results->num_rows != 1) return false;
        return new User($results->fetch_assoc());
    }
    public function getNewSession()
    {
        $sql=User::connect();
//$query =
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
        $sql = User::connect();
        if(User::checkUsername($sql,$u))//if user is taken
            throw new Exception('User creation failed: User already exists');

        $password = $sql->real_escape_string(User::hash($p));
        $email = isset($e) ? $e : 'null';
        $query = 'INSERT INTO users (usr,pwd,email)
                 VALUES (\'' . $u . '\',\'' . $password . '\',\'' . $email . '\');';
        $sql->query($query) or die('MySQL Error: ' . $sql->error);
    }

    public static function hash($value) {
        global $salt;
        return crypt($value, $salt);
    }
    public static function checkUsername($sql,$username) {
        $query = 'SELECT * FROM users WHERE usr=\''.$username.'\';';
        $results = $sql->query($query) or die('MySQL Error: ' . $sql->error);
        return ($results->num_rows != 0);
    }
    public static function connect()
    {
        global $database_name, $mysql_server, $mysql_username, $mysql_password;
        $sql = new mysqli($mysql_server, $mysql_username, $mysql_password,$database_name);
        if ($sql->connect_errno)
            die('Failed to connect to MySQL: ' . $mysqli->connect_error);
        return $sql;
    }
}

//User::create('royzhe','mypassword','m@gmail.com');
var_dump(User::loginPassword('royzhe','mypassword'));
?>