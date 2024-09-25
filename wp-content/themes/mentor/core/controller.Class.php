<?php
	
class Connect extends PDO
{
    public function __construct(){
       parent::__construct("mysql:host=localhost;port=3306;dbname=sps_mwp", 'sps_mwp', 'PiWheFdEedV6CdYL',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
	
}

class Controller {
    // generate char
    function generateCode($length){
        $chars = 'vwyzABC01256';
        $code = '';
        $clean = strlen($chars) - 1;
        while(strlen($code) < $length){
            $code .= $chars[mt_rand(0, $clean)];
        }
        return $code;
    }
    // insert data
    function insertData($data){
        $db = new Connect;
        $checkUser = $db->prepare("SELECT * FROM user WHERE email=:email");
        $checkUser->execute(['email' => $data["email"]]);
        $info = $checkUser->fetch(PDO::FETCH_ASSOC);
        

        if(!(isset($info["id"]) && $info["id"])){
            $session = $this -> generateCode(10);
            $inserUser = $db->prepare("INSERT INTO user (f_name, l_name, email, password, session, login) VALUES (:f_name, :l_name, :email, :password, :session, :login)");
            $inserUser -> execute([
                ':f_name' => $data["givenName"],
                ':l_name' => $data["familyName"],
                ':email' => $data["email"],
                ':password' => $this->generateCode(5),
                ':session' => $session,
                ':login' => $data["email"],
            ]);

            if($inserUser){
                setcookie("id", $db->lastInsertId(), time() + 3600, '/', NULL);
                setcookie("sess", $session, time() + 3600, '/', NULL);
                setcookie('user', $info['f_name'], time() + 3600, "/");
                header("Location: /interviewer");
                exit();
            }else{
                return 'Error inserting user!';
            }
        }else{


            if(!$info['polling']){
                setcookie("id", $info['id'], time() + 3600, '/', NULL);
                setcookie("sess", $info['session'], time() + 3600, '/', NULL);
                setcookie('user', $info['f_name'], time() + 3600, "/");
                header("Location: /interviewer");
                exit();
            }else{                
                setcookie("id", $info["id"], time() + 3600, '/', NULL);
                setcookie('user', $info['f_name'], time() + 3600, "/");
                setcookie("sess", $info["session"], time() + 3600, '/', NULL);
                header('Location: /login');
                exit();
            }
        }
    } 
}