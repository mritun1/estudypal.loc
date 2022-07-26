<?php 
// spl_autoload_register(function ($class) {
//     include './obj/' . strtolower($class) . '.php';
// });
spl_autoload_register(function ($class) {
    
    if(preg_match("/APP_/i", $class) == 1){
        $app_path = '../app/controllers/';
        $class = str_replace('APP_','',$class);
    }else{
        $app_path = './obj/';
    }

    $path = $app_path . str_replace('_','/', strtolower($class)) .'.php';
    //require $path;
    if(!file_exists($path)){ return false; }else{ require $path; }
});
//TO ACCESS GLOBALLY app/controllers/test/test.php
//And class APP_TEST_TEST{}
//Execution -> echo APP_TEST_TEST::tt();

//TO ACCESS LOCALLY obj/test.php
//Execution -> echo TEST::tt();
?>