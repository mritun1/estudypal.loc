<?php 
require_once 'config/autoload.php';

$db = new DB();

if($db->db() == true){
    echo 'Database Connected';
}else{
    echo 'Something went wrong';
}
echo '<br/>';

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

// $sql = "CREATE TABLE IF NOT EXISTS users (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     fname VARCHAR(255) NULL,
//     lname VARCHAR(255) NULL,
//     email VARCHAR(255) NULL,
//     password VARCHAR(255) NULL,
//     token VARCHAR(255) NULL
//     )";
// if ($db->db()->query($sql) === TRUE) {
//     echo "Table cars created successfully";
// } else {
//     echo "Error creating table: " . $db->db()->error;
// }

// $sql = "CREATE TABLE IF NOT EXISTS citations (
//     id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     user_id VARCHAR(255) NULL,
//     day VARCHAR(255) NULL,
//     format VARCHAR(255) NULL,
//     content TEXT NULL
//     )";
// if ($db->db()->query($sql) === TRUE) {
//     echo "citations cars table successfully";
// } else {
//     echo "Error citations table: " . $db->db()->error;
// }
?>