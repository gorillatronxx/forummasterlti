<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'config.class.php';
include 'database.class.php';

echo "Modified Preorder Tree Traversal <BR><BR>";

$root = "Fruit";
//$root = "Meat"; 
$tree = display_tree($root); 

echo "%%%%%%%%%%%%%%%%%%<BR>"; 
echo $tree . "<BR>"; 
echo "%%%%%%%%%%%%%%%%%%<BR>"; 

echo rebuild_tree('Fruit',0);


// Rebuild tree
function rebuild_tree($parent, $left) {   
    // the right value of this node is the left value + 1   
    $right = $left+1;   
    // get all children of this node   
    // retrieve the left and right value of the $root node  
    $database = new Database();
    $sql = "SELECT title FROM " . TABLE_NAME . " WHERE parent ='" . $parent . "';";  
    
    var_dump($sql);
    
    $database->query($sql);  
    $row = $database->single(); 
    
        //$result = mysql_query('SELECT title FROM tree '.   
        //                       'WHERE parent="'.$parent.'";');   

    var_dump($row); 
    exit;
    while($row) {
    //while ($row = mysql_fetch_array($result)) {   

        // recursive execution of this function for each   
        // child of this node   
        // $right is the current right value, which is   
        // incremented by the rebuild_tree function   

        $right = rebuild_tree($row['title'], $right);   

    }   

   

    // we've got the left value, and now that we've processed   

    // the children of this node we also know the right value   

    mysql_query('UPDATE tree SET lft='.$left.', rgt='.   

                 $right.' WHERE title="'.$parent.'";');   

   

    // return the right value of this node + 1   

    return $right+1;   

}   








// Display the tree
function display_tree($root) {  
    $out = '';
    // retrieve the left and right value of the $root node  
    $database = new Database();
    $sql = "SELECT lft, rgt FROM " . TABLE_NAME . " WHERE title ='" . $root . "';";  
    $database->query($sql);  
    $row = $database->single(); 
//var_dump($row); 
    // start with an empty $right stack  
    $right = array();  
    // now, retrieve all descendants of the $root node  
    $sql = "SELECT title, lft, rgt FROM " 
            . TABLE_NAME . 
            " WHERE lft BETWEEN "
            . $row['lft'] . " AND " 
            . $row['rgt'] . " ORDER BY lft ASC;";   
//var_dump($sql);
    $database->query($sql);
    $rows = $database->resultset(); 
//var_dump($rows); 
    
    // display each row  
    foreach($rows as $row ) {    
    // only check stack if there is one  
        if (count($right)>0) {  
            // check if we should remove a node from the stack  
            while ($right[count($right)-1]<$row['rgt']) {  
                array_pop($right);  
            }  
        }  
        // display indented node title  
        $out .= str_repeat('--',count($right)).$row['title']."<BR>\n";  

        // add this node to the stack  
        $right[] = $row['rgt'];  
    }  
    return $out; 
}  
