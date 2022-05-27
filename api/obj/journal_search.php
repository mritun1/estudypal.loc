<?php 
class JOURNAL_SEARCH{

    public static function getAllData(){
        // if(isset($_GET['search'])){
        //     return $_GET['search'];
        // }else{
        //     return "no";
        // }
        return "PARA_NUM";
    }

    public static function getDataUsingId($id){
        //GET SINGLE DATA BY ID
        // $db = new DB();
        // $para = "SELECT * FROM Art WHERE id='".$id."' LIMIT 1";
        // return $db->GetDataJson($para);
    }

    public static function searchData_1($query){
        //GET SINGLE DATA BY ID
        
        $get_query = str_replace(" ","+",$query);
        $url = "https://api.crossref.org/works?query=" . str_replace("@","/",$get_query);
                
        $file = file_get_contents($url);
        $data = json_decode($file,true);

        $message = $data['message'];
        
        $items = $message['items'];

        $arr_result = array();
        for($i=0; $i<10; $i++){

            array_push($arr_result, 
                array(
                    'doi' => $items[$i]['DOI'], 
                    'title' => $items[$i]['title']['0'], 
                    'url' => $items[$i]['URL']
                )
            );

        }
        return json_encode($arr_result);
    }

    public static function searchData_2($query){
        
        $pattern = "/10./i";
        
        $url = "https://api.crossref.org/works/" . str_replace("@","/",$query);
                
        $file = file_get_contents($url);
        $data = json_decode($file,true);

        $message = $data['message'];
        
        $arr_result = array();
        for($i=0; $i<10; $i++){
            
            array_push($arr_result, 
                array(
                    'doi' => $message['DOI'], 
                    'title' => $message['title']['0'], 
                    'url' => $message['URL']
                )
            );

           
        }
        return json_encode($arr_result);
         
    }

    public static function insertData(){
        //INSERT DATA
        // $db = new DB();
        // $para = "INSERT INTO cars(car_name)
        //         VALUES('" . $_POST['car_name'] . "')";
        // return $db->InputData("Insert", $para);
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
        $db = new DB();
        $para = "DELETE FROM articles WHERE articleID='$id' LIMIT 1";
        return $db->InputData("Delete", $para);
        
        
    }
}
?>