<?php 
spl_autoload_register(function($req){

    if(preg_match("/APP_/i", $req) == 1){
        $req = str_replace('APP_','',$req);
    }

    $path = 'app/controllers/' . strtolower(str_replace('_','/', $req)) . '.php';
    //echo $path;
    if(!file_exists($path)){ return false; }else{ require $path; }
});

//TO ACCESS GLOBALLY app/controllers/test/test.php
//And class APP_TEST_TEST{}
//Execution -> echo APP_TEST_TEST::tt();

//TO ACCESS LOCALLY app/controllers/test.php
//Execution -> echo TEST::tt();
?>