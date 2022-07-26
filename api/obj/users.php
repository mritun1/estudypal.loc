<?php 
class USERS{

    public static function getAllData(){
        //LISTS OF ALL DATA
        // $db = new DB();
        // $para = "SELECT * FROM articles LIMIT 10";
        // return $db->GetDataJson($para);
    }

    public static function getDataUsingId($id){
        //GET SINGLE DATA BY ID
        // $db = new DB();
        // $para = "SELECT * FROM Art WHERE id='".$id."' LIMIT 1";
        // return $db->GetDataJson($para);
    }

    public static function searchData_1($query){
        //GET SINGLE DATA BY ID
        
        // $db = new DB();
        // $para = "SELECT * FROM Art WHERE artist LIKE '%".$query."%'";
        // return $db->GetDataJson($para);
    }

    public static function searchData_2($query){
        // $db = new DB();
        // $para = "SELECT * FROM Art WHERE year<='2015' AND year>='2007'";
        // return $db->GetDataJson($para);
    }

    public static function insertData(){
        //INSERT DATA
        //SEND REQUEST - POST
        //password, password1, email, first_name, last_name
        if(isset($_POST['registration']) && $_POST['registration'] == 'access'){

            return APP_AUTH_USERS::register_users();

        }
    }

    public static function UpdateData($id){
        //UPDATE DATA BY ID
        // $db = new DB();
        // $para = "UPDATE cars SET 
        //         car_name='" . $_POST["car_name"] . "' 
        //         WHERE id='" . $id ."' LIMIT 1";
        // return $db->InputData("Update", $para);
    }

    public static function DeleteData($id){
        //DELETE DATA BY ID
        // $db = new DB();
        // $para = "DELETE FROM articles WHERE articleID='$id' LIMIT 1";
        // return $db->InputData("Delete", $para);
        
        
    }
    
    public static function Access(){
        
        if(isset($_POST['login']) && $_POST['login'] == 'access'){
            
            return APP_AUTH_USERS::login_users();
        
        }
        if(isset($_POST['googleId']) && $_POST['googleId'] != ''){
            
            return APP_CUSTOM_USERS::googleLogin();
        
        }
    }
}
?>