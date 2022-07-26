<?php 
class CONFIG{

    public static function include($query){
        $path = 'assets/view/' . str_replace('.','/', $query) . '.php';
        if(file_exists($path)){
            include $path;
        }else{
            echo '<p>Error: 404_page_not_created</p>';
        }
    }
    //EXAMPLE - config::include('404.404');

    public static function route_set($header_temp,$content,$footer_temp,$arr){
        global $page_arr, $page_exists;
        $page_arr = $arr;
        if($header_temp){config::include($header_temp);}
        if($content){config::include($content);}
        if($footer_temp){config::include($footer_temp);}
        $page_exists = 1;
    }
    // CONFIG::route_set('layout.header','home','layout.footer');

    public static function route($page,$controller){
        if($page == self::getRouteRequest(1)){
           self::getController($controller);
        }
    }
    //Example -> CONFIG::route('home','pagecontroller@function_name');

    public static function getRouteRequest($req){
        $request = $_SERVER['REQUEST_URI'];
        $exp_req = explode('/' , $request);
        return $exp_req[$req];
    }

    public static function route404($controller){
        global $page_exists;
        if($page_exists == 0){
            self::getController($controller);
        }
    }

    public static function getController($controller){
        $exp = explode('@', $controller);
        $page = $exp[0];
        $func = $exp[1];
        return $page::$func();
    }

    public static function include_func($file,$error){
        $file = 'assets/functions/' . $file . '.php';
        if(file_exists($file)){
            include $file;
        }else{
            return $error();
        }
    }

}
?>