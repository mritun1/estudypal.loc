<?php 
class APP_AUTH_SET{

    public static function setCookie($cookie_name, $cookie_value,$day){
        setcookie($cookie_name, $cookie_value, time() + (86400 * $day), "/"); // 86400 = 1 day
    }

    public static function postData(string $query){
        if(isset($_POST[$query]) && $_POST[$query] != ""){
            return htmlentities($_POST[$query]);
        }else{
            return false;
        }
    }
    
}
?>