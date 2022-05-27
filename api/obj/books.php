<?php 
class BOOKS{

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
        
        $search = str_replace(" ","+",$query);
        $file = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=" . $search);
        $data = json_decode($file,true);

        // echo '<pre>';
        
        // print_r($data);
        
        // echo '</pre>';
        
        $arr_result = array();
        if($data['totalItems'] > 0){
            // echo '<ul class="list-group">';
            for($i = 0;$i<10;$i++){
            //     echo '  <li style="cursor:pointer;" go_href href="'.$data['items'][$i]['id'].'&title='.$data['items'][$i]['volumeInfo']['title'].'" class="list-group-item">
            //                 <img src="'.$data['items'][$i]['volumeInfo']['imageLinks']['smallThumbnail'].'" style="height:60px;width:auto;" /><br/>
            //                 '.$data['items'][$i]['volumeInfo']['title'].'<br/>
            //                 '.$data['items'][$i]['volumeInfo']['publishedDate'].' . '.$data['items'][$i]['volumeInfo']['authors'][0] ?? null.'
                            
            //             </li>';

                array_push($arr_result, 
                    array(
                        'title' => $data['items'][$i]['volumeInfo']['title'], 
                        'publishedDate' => $data['items'][$i]['volumeInfo']['publishedDate'], 
                        'authors' => $data['items'][$i]['volumeInfo']['authors'][0] ?? null
                    )
                );

            }
            // echo '</ul>';

            

        }
        return json_encode($arr_result);
        // else{
        //     echo '<h4>Sorry! no data found.</h4>';
        // }
    }

    public static function searchData_2($query){
        
        
         
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