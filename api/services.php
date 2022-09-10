<?
class DB_con{
    function __construct(){
        include '../config/userpassDb.php';
        $conn = mysqli_connect($hostDb, $userDb ,$passDb,$nameDb);
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


    // 
    public function select($sql)
    {
        $result = array();
        $res = $this->dbcon->query($sql) or die("SQL Error: <br>" . $sql . "<br>" . $this->dbcon->error);
        while ($data = $res->fetch_assoc()) {
            $result[] = $data;
        }
        return $result;
    }
}

?>