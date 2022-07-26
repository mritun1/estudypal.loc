<?php 
class BOOKS{

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
        if(isset($_POST['book_id']) && $_POST['book_id'] != ''){
            
            $search = str_replace(" ","+",$_POST['title']);
            $file = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=" . $search);
            $data = json_decode($file,true);
            
            //echo '<pre>';
            
            //print_r($data);
            
           // echo '</pre>';

            $message['code'] = 0;
            $message['status'] = 'Sorry, No data found.';
            
            
            if($data['totalItems'] > 0){
                
                //echo '<ul class="list-group">';
                for($i = 0;$i<$data['totalItems'];$i++){
                    
                    if($data['items'][$i]['id'] == $_POST['book_id']){
                        

                        $message['code'] = 1;
                        $message['status'] = 'Success';
                        $message['data'] = $data['items'][$i];

                //         // echo '  <li style="cursor:pointer;" go_href href="'.$data['items'][$i]['id'].'" class="list-group-item">
                //         //         <img src="'.$data['items'][$i]['volumeInfo']['imageLinks']['smallThumbnail'].'" style="height:60px;width:auto;" /><br/>
                //         //         '.$data['items'][$i]['volumeInfo']['title'].'<br/>
                //         //         '.$data['items'][$i]['volumeInfo']['publishedDate'].' . '.$data['items'][$i]['volumeInfo']['authors'][0] ?? null.'
                                
                //         //     </li>';
                //         // $book_title = $data['items'][$i]['volumeInfo']['title'];

                //         // $authors = $data['items'][$i]['volumeInfo']['authors'] ?? null;
                //         // foreach($authors as $key => $values){
                //         //     $book_authors .= $values . ',';
                //         // }
                //         // $book_authors = name_list($book_authors);

                //         // $book_publisher = $data['items'][$i]['volumeInfo']['publisher'];
                //         // $book_publishedDate = date_format(date_create($data['items'][$i]['volumeInfo']['publishedDate']),"Y");
                        
                        break;
                    }
                }
                //echo '</ul>';
                
            }

            return json_encode($message);
        
        }
        
    }
}
?>