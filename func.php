<?php
$file_list=[];
function add_list ($name){
    global $file_list;
    $file_list = $name.".php";
    array_push($file_list,$file_name);
}

add_list("function");
var_dump($file_list);

?>