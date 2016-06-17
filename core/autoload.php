<?php
function core_autoload($class_name) {
    $file = mb_strtolower(CORE . 'classes/'.$class_name.'.php');
    if(file_exists($file) == false )
        return false;
    require_once ($file);
}
function controller_autoload($class_name) {
    $file = mb_strtolower(APP . 'controllers/'.$class_name.'.php');
    if(file_exists($file) == false )
        return false;
    require_once ($file);
}
function model_autoload($class_name) {
    $file = mb_strtolower(APP . 'models/'. $class_name.'.php');
    if(file_exists($file) == false )
        return false;
    require_once ($file);
}

spl_autoload_register('core_autoload');
spl_autoload_register('controller_autoload');
spl_autoload_register('model_autoload');