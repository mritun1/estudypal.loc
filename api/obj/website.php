<?php 
class WEBSITE{

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
        
        if(isset($_POST['url']) && $_POST['url']!=''){
            $url = $_POST['url'];
            $title = APP_INTI_FUNC::getTitle($url);

            $search = str_replace(" ","+",$title);
            $file = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=" . $search);
            $data = json_decode($file,true);

            // $message['code'] = 0;
            // $message['status'] = 'Sorry, No data found.';
            
            // if($data['totalItems'] > 0){
                
            //     for($i = 0;$i<$data['totalItems'];$i++){
                    
            //         if($data['items'][$i]['id'] == $_POST['book_id']){
                        
            //             $message['code'] = 1;
            //             $message['status'] = 'Success';
            //             $message['data'] = $data['items'][$i];
                       
            //             break;
            //         }
            //     }
                
            // }

            // return json_encode($message);
            return json_encode($data);

        }
        
    }
}
?>