<?php 
require_once 'config/autoload.php';
require_once 'config/api_function.php';

$request = $_SERVER['REQUEST_URI'];

$exp_req = explode('/' , $request);

define("PARA_NUM", count($exp_req));
if($exp_req[1]=='api'){
    if(isset($exp_req[2]) && $exp_req[2]!=''){
        $file = './api/'. $exp_req[2] . '.php';
        if(file_exists($file)){
            //echo $file;
            include $file;
        }else{
            include '404.php';
        }
    }else{
        include '404.php';
    }
}



?>