<?php 
class APP_AUTH_VALID{
    public static function password($password){
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
            //return 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        }else{
            return true;
        }
    }

    public static function mobile($phone){
        if(preg_match('/^[0-9]{10}+$/', $phone)) {
            return true;
        } else {
            return false;
        }
    }

    public static function personName($givenName){
        if(preg_match("/^([a-zA-Z' ]+)$/",$givenName)){
            return true;
        }else{
            return false;
        }
    }
}
?>