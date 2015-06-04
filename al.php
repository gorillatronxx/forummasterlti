<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// $parent is the parent of the children we want to see 
// $level is increased when we go deeper into the tree, 
//        used to display a nice indented tree 

include 'config.class.php';
include 'database.class.php';

echo "Tree - Agency List Example<BR><BR>";

$foo =  display_children('',0);

function display_children($parent, $level) { 
    // retrieve all children of $parent 
    
    $database = new Database();
    //echo $parent; 
    $sql = '';
    $sql = "SELECT * FROM " . TABLE_NAME . " WHERE parent ='" . $parent . "';";  

    
    $database->query($sql);  
    $rows = $database->resultset(); 
     
       
     foreach ($rows as $row) {        
        // indent and display the title of this child 
        echo str_repeat('---',$level).$row['title']."<BR>\n"; 

        // call this function again to display this 
        // child's children 
        display_children($row['title'], $level+1); 
    } 
    
} 


