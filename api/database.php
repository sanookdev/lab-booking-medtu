<?
require('../config/userpassDB.php');
class DB_con{
    function __construct(){
        $conn = mysqli_connect(HOSTDB,USERDB,PASSDB,NAMEDB);
        $this->dbcon = $conn;
        mysqli_set_charset($this->dbcon,"utf8");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: ".mysqli_connect_error();
        }
    }
    public function fetch_data($sql){
        $fetch = mysqli_query($this->dbcon ,$sql);
        return $fetch;
    }
    public function check_role($username){
        $sql = "SELECT * FROM role_access WHERE username = '$username'";
        $check_role = mysqli_query($this->dbcon,$sql);
    }
}

?>