<?php 
class APP_CUSTOM_USERS{
    public static function googleLogin(){
        //FIRST LOGIN
        $message['code'] = "0";
        $email = htmlentities($_POST['email']);
        $data = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        
        if(APP_CRUD_DB::checkData($data) == true){
            //LOGGING IN
            $getAll = json_decode(APP_CRUD_DB::getAll($data),true);
            $password = $getAll[0]['password'];
            $user_id = $getAll[0]['id'];
            
            if(password_verify(htmlentities($_POST['googleId']), $password)){
    
                $temp_pass = base64_encode(random_bytes(33));
                $temp_pass_hash = password_hash($temp_pass, PASSWORD_DEFAULT);
    
                $arr = array(
                    "token" => $temp_pass_hash,
                    "id" => $user_id
                );
                APP_CRUD_CRUD::InsertUpdateData($arr,'users',APP_CRUD_DB::conn(),"");
    
                $user = password_hash($email, PASSWORD_DEFAULT);
    
                //SETTING THE COOKIES
                // APP_AUTH_SET::setcookie("user_id",$user_id,"30");
                // APP_AUTH_SET::setcookie("user",$user,"30");
                // APP_AUTH_SET::setcookie("pass",$temp_pass,"30");
                
                $message['code'] = 1;
                $message['status'] = "Login success";

                //SEND SOME USERS DATA
                $where = "email='".$email."'";
                $message['user_id'] = APP_CRUD_DB::getOne('id','users',$where);
                $message['fname'] = APP_CRUD_DB::getOne('fname','users',$where);
                $message['lname'] = APP_CRUD_DB::getOne('lname','users',$where);

                $message['user_id'] = $user_id;
                $message['user'] = $user;
                $message['pass'] = $temp_pass;

            }else{
                $message['status'] = "Wrong username or password.";
                
            }
            
        }else{
            //REGISTERING
            
            //START INSERTING HERE
            $pass = password_hash($_POST['googleId'], PASSWORD_BCRYPT);

            $arr = array(
                "fname" => htmlentities($_POST['givenName']),
                "lname" => htmlentities($_POST['familyName']),
                "email" =>  $email,
                "password" =>  $pass
            );
            
            $db = new APP_CRUD_CRUD();
            APP_CRUD_CRUD::InsertUpdateData($arr,'users',$db->db(),"");

            $message['code'] = 1;
            $message['status'] = 'Registered Success';

        }
        echo json_encode($message);
    }
}

?>