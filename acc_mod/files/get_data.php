<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



if (isset($_POST['class_type'])) {
    
    $sql = "select id,sub_class_name from acc_sub_class where acc_class =".$_POST['class_type']." order by id";
    $query = db_query($sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->id.'>'.$data->sub_class_name.'</option>';
         }
    
}elseif (isset($_POST['sub_class_type'])) {
     
echo $sql = "select group_id,group_name from ledger_group where acc_sub_class =".$_POST['sub_class_type']." order by group_id";
    $query = db_query($sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->group_id.'>'.$data->group_name.'</option>';
         }

}








?>