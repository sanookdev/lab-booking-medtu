<?php

/*$config = array(
    "host"=>"192.168.66.1",
    "user"=>"root",
    "pass"=>"medadmin",
    "dbname"=>"petition_system",
    "charset"=>"utf8"
);*/
/*$con = new mysqli($config['host'],$config['user'],$config['pass'],$config['dbname']);
$con->set_charset($config['charset']);
if($con->connect_error){
    trigger_error("Database connect failed".$con->connect_error, E_USER_ERROR);
}

$con1 = new mysqli('192.168.66.1',$config['user'],$config['pass'],'personal');
$con1->set_charset($config['charset']);
if($con1->connect_error){
    trigger_error("Database connect failed".$con->connect_error, E_USER_ERROR);
}*/

if (!function_exists('connect')){
function connect($host,$user,$pass,$dbname,$charset){

    /*$db_config=array(
        "host"=>"localhost",
        "user"=>"root",
        "pass"=>"",
        "dbname"=>"test",
        "charset"=>"utf8"
    );*/
    $con = @new mysqli($host, $user, $pass, $dbname);
    $con->set_charset($charset);
    if(mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
        exit;
    }
    if(!$con->set_charset($charset)) {

    }else{

    }
    return $con;
    //echo $mysqli->character_set_name();  // แสดง charset เอา comment ออก
    //echo 'Success... ' . $mysqli->host_info . "n";
    //$mysqli->close();
}
}
if (!function_exists('closeDB')){
function closeDB(){
    $con->close();
}
}
if (!function_exists('query')){
function query($sql){
        //global $con;
        if($con->query($sql)) { return true; }
        else { die("SQL Error: <br>".$sql."<br>".$con->error); return false; }
}
}
if (!function_exists('select')){
function select($sql){
    global $con;
    $result=array();
    $res = $con->query($sql) or die("SQL Error: <br>".$sql."<br>".$con->error);
    while($data= $res->fetch_assoc()) {
        $result[]=$data;
    }
    return $result;
}
}

if (!function_exists('insert')){
function insert($table,$data){
    global $con;
    $fields=""; $values="";
    $i=1;
    foreach($data as $key=>$val)
    {
        if($i!=1) { $fields.=", "; $values.=", "; }
        $fields.="$key";
        $values.="'$val'";
        $i++;
    }
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";
    if($con->query($sql)) { return true; }
    else { die("SQL Error: <br>".$sql."<br>".$con->error); return false; }
}
}

if (!function_exists('update')){
function update($table,$data,$where){
    global $con;
    $modifs="";
    $i=1;
    foreach($data as $key=>$val){
        if($i!=1){ $modifs.=", "; }
        if(is_numeric($val)) { $modifs.=$key.'='.$val; }
        else { $modifs.=$key.' = "'.$val.'"'; }
        $i++;
    }
    //echo 'UPDATE '.$table.' SET '.$modifs.' WHERE '.$where;
    $sql = ("UPDATE $table SET $modifs WHERE $where");
    if($con->query($sql)) { return true; }
    else { die("SQL Error: <br>".$sql."<br>".$con->error); return false; }
}
}
if (!function_exists('delete')){
function delete($table, $where){
    global $con;
    $sql = "DELETE FROM $table WHERE $where";
    if($con->query($sql)) { return true; }
    else { die("SQL Error: <br>".$sql."<br>".$con->error); return false; }
}
}
if (!function_exists('listfield')){
function listfield($table){
    global $con;
    $sql="SELECT * FROM $table LIMIT 1 ";
    $row_title="$data=array(<br/>";
    $res = $con->query($sql) or die("SQL Error: <br>".$sql."<br>".$con->error);
    $i=1;
    while($data= $res->fetch_field()) {
        $var=$data->name;
        $row_title.='"$var"=>"value$i",<br/>';
        $i++;
    }
    $row_title.=");<br/>";
    //echo $row_title;
}
}

	$con=connect('192.168.66.1','root','medadmin','personal','utf8') or die('55');

?>