<?php 
class GENERATECITE{

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

        $data = APP_CUSTOM_CITE::citation_format(
            $_POST['format'],
            $_POST['author'],
            $_POST['publish_date'],
            $_POST['title'],
            $_POST['type'],
            $_POST['doi_url'],
            $_POST['volume'],
            $_POST['volume_issue'],
            $_POST['library_name'],
            $_POST['edition'],
            $_POST['publication_place'],
            $_POST['publisher'],
            $_POST['page_num']
        );

        if($_POST['for'] == 'logged_in'){
            $message['code'] = 0;
            $message['status'] = 'User is not logged in';
            if(APP_AUTH_USERS::user_log_status() == true){
                $message['code'] = 1;
                $message['status'] = 'Logged in';
                //$data = APP_CUSTOM_CITE::citation_format($_POST['format'],$_POST['author'],$_POST['publish_date'],$_POST['title'],$_POST['type'],$_POST['doi_url'],$_POST['volume'],$_POST['volume_issue'],$_POST['library_name']);
                //INSERT INTO DATABASE
                $uid = APP_AUTH_USERS::logData('id');
                $arr = array(
                    "user_id" => $uid,
                    "day" => time(),
                    "format" => htmlentities($_POST['format']),
                    "author" => htmlentities($_POST['author']),
                    "publish_date" => htmlentities($_POST['publish_date']),
                    "title" => htmlentities($_POST['title']),
                    "type" => htmlentities($_POST['type']),
                    "doi_url" => htmlentities($_POST['doi_url']),
                    
                );
                APP_CRUD_CRUD::InsertUpdateData($arr,'citations',APP_CRUD_DB::conn(),"");

                $sql = "SELECT * FROM citations WHERE user_id='$uid' ORDER BY id DESC";
                $getAll = json_encode(APP_CRUD_DB::getAll($sql),true);
                $message['data'] = $getAll;
            
            }
            echo json_encode($message);
        }
        
        if($_POST['for'] == 'logoff'){

            

            if(!isset($_COOKIE["citations"])){
                //NEW COOKIE SET
                APP_AUTH_SET::setcookie("citations",json_encode(array($data)),"30");
                //return json_encode(array($data));
                $message['code'] = 1;
                $message['status'] = 'Success.';
                $message['data'] = array($data);
                return json_encode($message);
            }else{
                //COOKIE EXISTS
                //APP_AUTH_SET::setcookie("citations",json_encode(array($data)),"30");
                $citation_json = $_COOKIE["citations"];
                $citation_obj = json_decode($citation_json,true);
                if(count($citation_obj) > 4){
                    //INSERT TO DATABASE
                    $message['code'] = 0;
                    $message['status'] = 'User need to login to input more than 5 times.';
                    return json_encode($message);
                }else{
                    //INSERT TO EXISTING COOKIES
                    array_push($citation_obj,$data);
                    APP_AUTH_SET::setcookie("citations",json_encode($citation_obj),"30");
                    $message['code'] = 1;
                    $message['status'] = 'Success.';
                    $message['data'] = $citation_obj;
                    return json_encode($message);
                }
                
            }

            
        }
        
        
    }

    
}
?>