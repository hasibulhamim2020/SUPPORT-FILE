<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



if (isset($_POST['region_id'])) {
    
    echo $sql = "SELECT * FROM zon where REGION_ID=".$_POST['region_id']." order by ZONE_NAME";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->ZONE_CODE.'>'.$data->ZONE_NAME.'</option>';
         }
    
}elseif (isset($_POST['zone_id'])) {
     

   echo $sql = "SELECT * FROM area where ZONE_ID=".$_POST['zone_id']." ORDER BY AREA_NAME";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->AREA_CODE.'>'.$data->AREA_NAME.'</option>';
         }

}elseif (isset($_POST['area_id'])) {
     

    $sql = "SELECT * FROM ss_route where area_id=".$_POST['area_id']." ORDER BY route_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->route_id.'>'.$data->route_name.'</option>';
         }

}elseif (isset($_POST['item_group'])) {
     
    $sql = "SELECT * FROM item_category where group_id=".$_POST['item_group']." ORDER BY category_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->id.'>'.$data->category_name.'</option>';
         }

}elseif (isset($_POST['category_id'])) {
     
    echo $sql = "SELECT * FROM item_subcategory where category_id=".$_POST['category_id']." ORDER BY subcategory_name";
    $query = mysqli_query($conn, $sql);
    echo '<option></option>';
    while($data=mysqli_fetch_object($query)){
            echo '<option value='.$data->id.'>'.$data->subcategory_name.'</option>';
         }

}


?>