<?php 
class INTEXTCITE{

    public static function getAllData(){
    }

    public static function getDataUsingId($id){
    }

    public static function searchData_1($query){
    }

    public static function searchData_2($query){
    }

    public static function insertData(){
    }

    public static function UpdateData($id){
    }

    public static function DeleteData($id){
    }
    
    public static function Access(){

        $pos = $_POST['pos'];
        $val = $_POST['val'];
        $cite_id = $_POST['cite_id'];

        $data = "SELECT * FROM citations WHERE id='$cite_id' LIMIT 1";
        $getAll = json_decode(APP_CRUD_DB::getAll($data),true);
        if($getAll){
            $data = APP_CUSTOM_CITE::citation_format($getAll[0]['format'],$getAll[0]['author'],$getAll[0]['publish_date'],$getAll[0]['title'],$getAll[0]['type'],$getAll[0]['doi_url']);

        }
        $message['data'] = $data;
        echo json_encode($message);
        
        
    }

    
}
?>