<?php 
require_once 'config/autoload.php';

// $db = new DB();

// if($db->db() == true){
//     echo 'Database Connected';
// }else{
//     echo 'Something went wrong';
// }
// echo '<br/>';


$db = new mysqli("localhost", "root", "", "72dragons");
if($db == true){
    echo 'Database Connected';
}else{
    echo 'Something went wrong';
}

//$query = mysqli_query($db, "DELETE FROM `articles` WHERE articleID=`3`");
//$query=$db->query("DELETE FROM articles WHERE id ='1'");

$query = $db->query("INSERT INTO articles(title,author,coverImage,video_mobile,urlFormat,created,hidden) 
VALUES('details','1','2','1','1','1','1')");
//$query = $db->query("UPDATE articles SET title='dddd' WHERE id='1'");
//$query = $db->query("DELETE FROM articles WHERE id='1'");

if($query){
    echo   " success";
}else{
    echo  " failed";
}
print_r($query);




//create cars table if not exists
// $sql = "CREATE TABLE IF NOT EXISTS cars (
//    car_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//    car_name VARCHAR(30) NOT NULL,
//    car_price INT(6) NOT NULL,
//    car_image VARCHAR(30) NOT NULL,
//    car_model VARCHAR(30) NOT NULL,
//    car_fuel VARCHAR(30) NOT NULL,
//    car_bodytype VARCHAR(30) NOT NULL,
//    car_seattype VARCHAR(30) NOT NULL,
//    car_tyretype VARCHAR(30) NOT NULL,
//    car_seatcapacity VARCHAR(30) NOT NULL,
//    car_carrierability VARCHAR(30) NOT NULL
// )";
// if ($db->query($sql) === TRUE) {
//    echo "Table cars created successfully";
// } else {
//    echo "Error creating table: " . $db->db()->error;
// }
?>