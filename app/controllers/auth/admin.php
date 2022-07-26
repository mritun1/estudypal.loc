<?php 
class APP_AUTH_ADMIN{
    public static function login($username,$password){
        $message['status'] = 'Can\'t submit empty field.';
        $message['code'] = 0;
        if(!empty($username) && !empty($password)){
            $message['status'] = 'Username or Password not match!';
            //VERIFYING THE USERNAME AND PASSWORD
            if(self::matchAdminAuth($username, $password) == true){
                $_SESSION['userType'] = 'admin';
                $_SESSION['userName'] = $username;
                $_SESSION['userPass'] = $password;
                $message['code'] = 1;
                $message['status'] = 'Login Success.';
            }
        }
        return $message;
    }

    public static function authCheck(){
        $return = false;
        //If there is session created
        if(isset($_SESSION['userType'])){
            if($_SESSION['userType'] == 'admin'){
                //CHECK ADMIN
                if(self::matchAdminAuth($_SESSION['userName'], $_SESSION['userPass']) == true){
                    $return = true;
                }
            }else{
                //CHECK IF USERS IS LOGGED IN OR NOT


            }
        }
        return $return;
        //matching the session with database
        //Print out if login or not
    }

    public static function matchAdminAuth($username, $password){
        $return = false;
        if(password_verify($password, ADMIN_PASSWORD)){
            if($username == ADMIN_USERNAME){
                $return = true;
            }
        }
        return $return;
    }

    public static function authRedirect($state, $url){
        if(self::authCheck() == $state){
            header('Location:' . $url);
        }else{
            return false;
        }
    }
}
?>