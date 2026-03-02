<?php

require_once "../../../assets/template/layout.top.php";



function auto_update($table_name, $where_column,$values) {

$assignments = array();
$where_clause = "";


    foreach ($values as $columns => $value) {
        $assignments[] = "$columns='$value'";
    }


    $set_clause = implode(", ", $assignments);
    //$where_clause = "$where_column='$where_column'";
    //$where_clause = "$where_column= '$values[ (count($values)) - 1]' ";
    $where_clause =$where_column;


    echo $sql_update = "UPDATE $table_name SET $set_clause WHERE $where_clause";
    
    //mysql_query($sql_update);
}


// Usage example

$condition='id=10';
$values = [
    "name" => 'Faysal',
    "code" => 80,
    "status" => 3
];

auto_update("aaa1", $condition, $values);



















//require_once "../../../assets/template/layout.bottom.php";
?>