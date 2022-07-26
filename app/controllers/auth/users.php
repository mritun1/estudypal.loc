<?php 
class APP_AUTH_USERS{

    //FOR REGISTERING USER
    //SEND REQUEST
    //password, password1, email, first_name, last_name
    public static function register_users(){
        $message['code'] = 0;
        if($_POST['password'] == $_POST['password1']){
            

            $email = htmlentities($_POST['email']);
            $crud = new APP_CRUD_CRUD();
            
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            if($crud->sql_query($query) == false){
                //check if valid password, name, email, etc.
                if(
                    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == true &&
                    APP_AUTH_VALID::personName($_POST['first_name']) == true &&
                    APP_AUTH_VALID::personName($_POST['last_name']) == true
                    
                    )
                {
                    if(APP_AUTH_VALID::password($_POST['password']) == true){
                        //START INSERTING HERE
                        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

                        $arr = array(
                            "fname" => htmlentities($_POST['first_name']),
                            "lname" => htmlentities($_POST['last_name']),
                            "email" =>  $email,
                            "password" =>  $pass
                        );
                        
                        $db = new APP_CRUD_CRUD();
                        APP_CRUD_CRUD::InsertUpdateData($arr,'users',$db->db(),"");

                        $message['code'] = 1;
                        $message['status'] = 'Registered Success';
                    }else{
                        $message['status'] = 'Password must be 8 characters, one upper letter, one number, and one special character.';
                    }
                }else{
                    $message['status'] = 'Please, Enter Correct details';
                }
            }else{
                $message['status'] = 'User already exists!';
            }

            

        }else{
            $message['status'] = 'Password not matched';
        }

        echo json_encode($message);
    }

    public static function login_users(){
        // 1. Check if the user exists in database and get the password.
        // 2. match the password with database.
        // 3. set to session and cookies.
        // 4. Redirect
        
        
        $message['code'] = "0";
        $email = htmlentities($_POST['email']);
        $data = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        
        if(APP_CRUD_DB::checkData($data) == true){
            
            $getAll = json_decode(APP_CRUD_DB::getAll($data),true);
            $password = $getAll[0]['password'];
            $user_id = $getAll[0]['id'];
            
            if(password_verify(htmlentities($_POST['password']), $password)){
    
                $temp_pass = base64_encode(random_bytes(33));
                $temp_pass_hash = password_hash($temp_pass, PASSWORD_DEFAULT);
    
                $arr = array(
                    "token" => $temp_pass_hash,
                    "id" => $user_id
                );
                APP_CRUD_CRUD::InsertUpdateData($arr,'users',APP_CRUD_DB::conn(),"");
    
                $user = password_hash($email, PASSWORD_DEFAULT);
    
                //SETTING THE COOKIES
                APP_AUTH_SET::setcookie("user_id",$user_id,"30");
                APP_AUTH_SET::setcookie("user",$user,"30");
                APP_AUTH_SET::setcookie("pass",$temp_pass,"30");
                
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
            $message['status'] = "User not exists";
        }
        echo json_encode($message);
        
    }

    public static function user_log_status(){
        // 1. Check if cookie is set
        // 2. Match cookies data with database data
        // 3. Print out status
        $return = false;
        if(
            isset($_COOKIE["user_id"]) && $_COOKIE["user_id"]!="" &&
            isset($_COOKIE["user"]) && $_COOKIE["user"]!="" && 
            isset($_COOKIE["pass"]) && $_COOKIE["pass"]!=""
        ){
            $uid = htmlentities($_COOKIE["user_id"]);
            $user = htmlentities($_COOKIE["user"]);
            $pass = htmlentities($_COOKIE["pass"]);
            $where = "id='".$uid."'";
            $email = APP_CRUD_DB::getOne('email','users',$where);
            $password = APP_CRUD_DB::getOne('token','users',$where);
            $verify_email = password_verify($email,$user);
            $verify_pass = password_verify($pass,$password);
            //if($verify_email == true && $verify_pass == true){
            if($verify_email){
                if($verify_pass){
                    $return = true;
                }
            }
        }
        return $return;
    }

    public static function log_redirect($url){
        if(APP_AUTH_USERS::user_log_status() == true){
            header("Location:$url");
        }
    }

    public static function log_redirect_off($url){
        if(APP_AUTH_USERS::user_log_status() == false){
            header("Location:$url");
        }
    }

    public static function user_logout($url){
        unset($_COOKIE['user_id']);
        setcookie('user_id', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_COOKIE['user']);
        setcookie('user', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_COOKIE['pass']);
        setcookie('pass', '', time() - 3600, '/'); // empty value and old timestamp
        header("Location:$url");
    }

    public static function logData(string $column){
        $where = "id='".$_COOKIE['user_id']."'";
        $data = APP_CRUD_DB::getOne($column,'users',$where);
        return $data;
    }
    //APP_AUTH_USERS::logData('fname');

}
?>