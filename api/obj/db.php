<?php 
class DB{
    private $db;

    public function __construct(){
        //$this->db = new mysqli("localhost", "id18883972_root", "1234567890mM#", "id18883972_test");
        //$this->db = new mysqli("localhost", "root", "", "login_api");
        $this->db = new mysqli("localhost", "root", "estudyPal@1234", "estudypal");
        if($this->db->connect_error){
            $this->db = false;
        }
    }

    public function db(){
        return $this->db;
    }

    //READ
    //"SELECT * FROM cars"
    //"SELECT * FROM cars WHERE id='1'"
    public function GetDataJson($para){
        $arr = array();
        $sql = $this->db->query($para);
        if($sql->num_rows > 0){
            foreach($sql as $row){
                $arr[] = $row;
            }
        }
        return json_encode($arr);
    } 

    //DELETE, UPDATE, CREATE
    //"DELETE FROM cars WHERE id='1'"
    //"INSERT INTO cars() VALUES()"
    //$comment = Delete, Insert, Update
    public function InputData($comment,$para){
        //$sql = $this->$db->query($para);
        //$sql = mysqli_query($this->$db, $para);
        $db = new mysqli("localhost", "root", "", "test");
        $sql = $db->query($para);
        if($sql){
            return $comment . " success";
        }else{
            return $comment . " failed";
        }
       // return $comment.$para;
    }

    function InsertUpdateData($arr,$tablename){

        $conn = $this->$db;
        //$arr = json_decode($arr,true);
    
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
    
        $message['status'] = 'Failed! Something wrong';
        $message['code'] = '0';
        $message['id'] = '0';
        if(isset($arr['editId']) && $arr['editId'] != null){
            //echo 'Update';
            $editId = mysqli_real_escape_string($conn,$arr['editId']);
            $sql = 'UPDATE ' . $tablename . ' SET ' . $updating_data . ' WHERE id="' . $editId . '" LIMIT 1';
            //echo $sql;
            mysqli_query($conn,$sql);
            $message['status'] = 'Update Success';
            $message['code'] = '1';
            $message['id'] = $editId;
        }else{
            //echo  'Insert';
            $sql = 'INSERT INTO ' . $tablename . '(' . $insert_names . ') VALUE(' . $insert_values . ')';
            //echo $sql;
            mysqli_query($conn,$sql);
            $message['status'] = 'Insert Success';
            $message['code'] = '1';
            $message['id'] = mysqli_insert_id($conn);
            //$message['sql'] = $sql;
            $message['err'] = mysqli_error($conn);
        }
        echo json_encode($message);
    }
    //@example : InsertUpdateData($_REQUEST,'tablename');
    // [editId] is compulsory if you want to edit
}
?>