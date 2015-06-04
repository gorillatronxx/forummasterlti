<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'config.class.php';
include 'database.class.php';

echo "Tree - Path to Node Example<BR><BR>";

$node = "Cherry"; 

$x =  get_path($node);
echo "Node is: " . $node; 
var_dump($x); 

function get_path($node) { 
    // retrieve all children of $parent    
    $database = new Database();
    $sql = '';
    $sql = "SELECT parent FROM " . TABLE_NAME . " WHERE title ='" . $node . "';";  
    $database->query($sql);  
    $row = $database->single(); 
    $path = array();
    if($row['parent'] != '') {
        $path[] = $row['parent']; 
        $path = array_merge(get_path($row['parent']), $path); // more
    }  
    return $path; 
} 
