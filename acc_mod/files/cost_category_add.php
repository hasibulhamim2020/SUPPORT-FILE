<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Cost Category';

$proj_id=$_SESSION['proj_id'];

$button="yes";

$now=time();

$unique='cat_id';

$$unique=$_GET[$unique];



$cat_id=$_REQUEST['cat_id'];

//echo $proj_id;

if(isset($_REQUEST['category_name']) && !empty($_REQUEST['category_name']))

{

	//common part.............

	$category_name = $_REQUEST['category_name'];

		$check="select id from cost_category where category_name='$category_name'";

		//echo $check;

		if(mysqli_num_rows(db_query($check))>0)

		{

			$aaa=mysqli_num_rows(db_query($check));

				$type=0;

				$msg='Given Name('.$category_name.') is already exists.';

		}

		else

		{

	if(isset($_POST['ncategory']))

	{

		$check="select id from cost_category where category_name='$category_name'";

		//echo $check;

		if(mysqli_num_rows(db_query($check))>0)

		{

			$aaa=mysqli_num_rows(db_query($check));

			$cat_id=$aaa[0];

		}

		else

		{

			$sql="INSERT INTO `cost_category` (

			`category_name`, `proj_id`)

			VALUES ('$category_name', '$proj_id')";

			//echo $sql;

			$query=db_query($sql);

		$type=1;

		$msg='New Entry Successfully Inserted.';

		}

	}

	

	//for Modify..................................

	

	if(isset($_POST['modify']))

	{ if(isset($_GET['cat_id'])){

		$sql="UPDATE `cost_category` SET `category_name` = '$category_name'

		 WHERE `id` = '$cat_id' LIMIT 1";

		$qry=db_query($sql);

				$type=1;

		$msg='Successfully Updated.';}



	}

	}

		if(isset($_POST['dcategory']))

	{

		$sql="delete from cost_category

		 WHERE `id` = '$cat_id' LIMIT 1";

		$qry=db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

	}

}

$report=db_query("select id, category_name from cost_category");

if(isset($_REQUEST['cat_id']))

{

	$c_id=$_REQUEST['cat_id'];

	$ddd="select * from cost_category where id='$c_id'";

	$data=mysqli_fetch_row(db_query($ddd));

	//echo $ddd;

}?>

<script type="text/javascript">

function DoNav(theUrl)

{

	document.location.href = 'cost_category.php?cat_id='+theUrl;

}

</script>



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                  <td><div class="box">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Category  Name:</td>

                                        <td>

                                        <input name="category_name" style="max-width:250px;" type="text" id="category_name" value="<?php echo $data[1];?>" class="required"/></td>

									  </tr>

                                    </table>

                                  </div></td>

                                </tr>

                                

                                

                              </table>12

<script type="text/javascript">

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>