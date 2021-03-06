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
      <li>session</li>
      <li>sessionid</li>
      </ul>
     */
    private $data;
    private $sql;///<sql connection
    private function __construct($data,&$sql) {
        $this->data = (array)$data;
        $this->sql=$sql;
    }
    /**
      Retrieves data in $this->data
     */
    public function __get($value) {
        if (isset($this->data[$value]))
            return $this->data[$value];
        else
            throw new Exception('User: cannot __get('.$value.') because it does not exist in $this->data'.print_r($this->data));
    }

    /**
      Logs the user in.
      @param $u username
      @param $p password
     */
    public static function loginPassword($u, $p) {
        $password = User::hash($p);
        $query = 'SELECT * FROM users WHERE '."usr='$u' AND `pwd`='$password';";
        return User::login($query);
    }
    public static function loginSession($u,$s) {
        global $sessiontimeout;
        $query= 'SELECT * FROM users WHERE usr=\''.$u.'\' AND sessionID=\''.$s.'\';';
        if(!$v = User::login($query))return false;
        if(time()-$v->session > $sessiontimeout)return false;
        return $v;

    }
    private static function login($query) {
        $sql=User::connect();
        $results = $sql->query($query) or die('MySQL Error line '.__LINE__.': ' . $sql->error);
//echo $query;
        if ($results->num_rows != 1) return false;
        return new User($results->fetch_assoc(),$sql);
    }
    public function newSession() {
        global $salt;
        $session = md5($this->data['usr'].time().$salt);
        $time = time();
        $usr = $this->data['usr'];
        $query='UPDATE users SET `session`'."='$time', `sessionID`='$session' WHERE `usr`='$usr'";
        $this->sql->query($query) or die('MySQL Error line '.__LINE__.': ' . $this->sql->error);
        return $session;
    }

    /**
      Changes the user's password.
      @param @u username
      @param $op old password
      @param $np new password
     */
    public static function changePassword($u, $op, $np) {
        if(!$user = User::loginPassword($u,$op))return false;
        $password = User::hash($np);
        $query = 'UPDATE users SET `pwd`=\''.$password.'\' WHERE `usr`=\''.$u.'\';';
        $user->query($query);
        return true;
    }
    /**
    Performs a direct query to the mySQL database. This method is NOT RECOMMENDED FOR USE unless you know what you're doing.
    @param $query query to be directly sent
    */
    public function query($query) {
        $this->sql->query($query);
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
        return addslashes(crypt($value, $salt));
    }
    /**
    Checks to see if the uesrname exists.
    @param $sql mysqli object
    @param $uesrname username to check for
    */
    public static function checkUsername($sql,$username) {
        $query = 'SELECT * FROM users WHERE usr=\''.$username.'\';';
        $results = $sql->query($query) or die('MySQL Error: ' . $sql->error);
        return ($results->num_rows != 0);
    }
    public static function connect() {
        global $database_name, $mysql_server, $mysql_username, $mysql_password;
        $sql = new mysqli($mysql_server, $mysql_username, $mysql_password,$database_name);
        if ($sql->connect_errno)
            die('Failed to connect to MySQL: ' . $mysqli->connect_error);
        return $sql;
    }
}

//User::create('roygbiv','mypasswords','m@gmail.com');
//$user = User::loginPassword('roygbiv','mypasswordss');
//var_dump($user);
//var_dump($user->newSession());
//$user = User::loginSession('roymanz','d3de8305f93266526703f35e94e8c6d3');
//var_dump($user);
//echo User::changePassword('roygbiv','mypasswords','mypasswordss');
?>