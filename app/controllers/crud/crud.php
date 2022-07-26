<?php 
class APP_CRUD_CRUD{

    private $db;

    public function __construct(){
        
        //$this->db = new mysqli("localhost", constant('DATABASE_USER_NAME'), constant('DATABASE_PASS'), constant('DATABASE_NAME'));
        //$this->db = new mysqli("localhost", "root", "", "login_api");
        //$this->db = new mysqli("localhost", "id18883972_root", "1234567890mM#", "id18883972_test");
        $this->db = new mysqli("localhost", "root", "estudyPal@1234", "estudypal");
        if($this->db->connect_error){
            $this->db = false;
        }
    }

    public function db(){
        return $this->db;
    }

    public static function fetchURL($url){
        $context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
        return file_get_contents($url,false,$context);
    }

    public static function fetchAllLists($api_url,$body){
        $json_data = self::fetchURL($api_url);
        $response_data = json_decode($json_data,true);
        for($i = 0; $i < count($response_data); $i++){
            echo $body($response_data[$i]);
        }
    }

    public static function fetchCont($api_url){
        $json_data = self::fetchURL($api_url);
        return json_decode($json_data,true);
    }

    public static function content($arr,$cont){
        if(!empty($arr[0][$cont])){
          return $arr[0][$cont];
        }
    }

    public static function InsertUpdateData($arr,$tablename,$conn,$folder){

        //$arr = json_decode($arr,true);
    
        //FOR UPLOADING IMAGE
        $imageName = 'image';
        if(isset($_FILES[$imageName]["name"])){
            $target_dir = "uploads/" . $folder;
            $target_file = $target_dir . basename($_FILES[$imageName]["name"]);
    
            if (move_uploaded_file($_FILES[$imageName]["tmp_name"], $target_file)) {
                //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                $arr['image'] = $target_file;
            }
        }
    
        $i = 0;
        $updating_data = '';
        $insert_names = '';
        $insert_values = '';
        foreach($arr as $key => $value){
            $i++;
            if($i == count($arr)){
                $insert_names .= mysqli_real_escape_string($conn,$key);
                $insert_values .= '"' . mysqli_real_escape_string($conn,$value) . '"';
                $updating_data .= mysqli_real_escape_string($conn,$key) . '="' . mysqli_real_escape_string($conn,$value) . '"';
            }else{
                $insert_names .= mysqli_real_escape_string($conn,$key) . ',';
                $insert_values .= '"' . mysqli_real_escape_string($conn,$value) . '",';
                $updating_data .= mysqli_real_escape_string($conn,$key) . '="' . mysqli_real_escape_string($conn,$value) . '",';
            }
        }
    
        //$message['status'] = 'Failed! Something wrong';
        //$message['code'] = '0';
        //$message['id'] = '0';
        if(isset($arr['id']) && $arr['id'] != ""){
            //echo 'Update';
            $editId = mysqli_real_escape_string($conn,$arr['id']);
            $sql = 'UPDATE ' . $tablename . ' SET ' . $updating_data . ' WHERE id="' . $editId . '" LIMIT 1';
            //echo $updating_data;
            mysqli_query($conn,$sql);
            //$message['status'] = 'Update Success';
            //$message['code'] = '1';
            $lastID = $editId;
        }else{
            //echo  'Insert';
            $sql = 'INSERT INTO ' . $tablename . '(' . $insert_names . ') VALUE(' . $insert_values . ')';
            //echo $sql;
            mysqli_query($conn,$sql);
            //$message['status'] = 'Insert Success';
            //$message['code'] = '1';
            $lastID = mysqli_insert_id($conn);
            //$message['sql'] = $sql;
            //$message['err'] = mysqli_error($conn);
        }
        //echo json_encode($message);
        return $lastID;
    }
    //@example : InsertUpdateData($_REQUEST,'tablename',$conn,$upload_folder);
    //
    //For Editing: send post request [id]
    //
    //  $db = new DB();
    //  InsertUpdateData($_REQUEST,'Art',$db->db(),"uploads/");
    //
    //FOR UPLOADING IMAGE: send post file [image]


    //$para = "SELECT * FROM blogs WHERE id='$id' LIMIT 1";    
    //$req = single, all, pag
    public function GetDataJson($para,$req){

        $arr = array();
        $sql = $this->db->query($para);
        if($sql->num_rows > 0){
            foreach($sql as $row){
                $arr[] = $row;
            }
        }
        if($req == 'total'){
            return $sql->num_rows;
        }else{
            return $arr;
        }
        //print_r($arr);
    } 

    public function sql_query($para){
        $sql = $this->db->query($para);
        if($sql->num_rows > 0){
            return true;
        }else{
            return false;
        }
    } 

    public static function deleteFunctions($function){
        if(APP_AUTH_USERS::user_log_status() == true){
            if(isset($_POST['forDeleting']) && $_POST['forDeleting'] == 'Delete'){
                if($_POST["delete-confirm"]!= '' && $_POST['del-id']!=''){
                    $function();
                }else{
                    $message['code'] = 0;
                    $message['status'] = 'No details found';
                    echo json_encode($message);
                }
            }
        }
    }

    
}
?>