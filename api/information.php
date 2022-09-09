<?
    header("Content-type: application/json; charset=utf-8");
    
    require('./database.php');
    $_POST = json_decode(file_get_contents("php://input"),true);
    $access = new DB_con();
    $topic = $_POST['topic'];
    $result = array();
    if($topic == 'checkLogin'){
        $username  = $_POST['data']['username'];
        $password  = md5($_POST['data']['password']);
        $username = strtoupper($username);
        $jsonurl = 'http://203.131.209.236/_authen/_authen.php?user_login=' . $username;
        $json = file_get_contents($jsonurl);
        $returnInfo = json_decode($json, true);

        if($password == $returnInfo['chkData']){
            session_start();
            $_SESSION['user'] = $username;
            $result['message'] = 'login successfull';
            $result['status'] = true;
            // check role on database
        }else{
            $result['message'] = 'Username or Password is Invalid';
            $result['status'] = false;
        }
    }else if ($topic == 'insertNewProject'){

    }else if ($topic == 'updateProject'){

    }else if ($topic == 'deleteProject'){

    }else if ($topic == 'AllProjects'){

    }else if ($topic == 'DetailProject'){
        
    }
    echo json_encode($result);
?>