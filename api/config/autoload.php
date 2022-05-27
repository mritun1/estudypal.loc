<?php 
spl_autoload_register(function ($class) {
    include './obj/' . strtolower($class) . '.php';
});
?>