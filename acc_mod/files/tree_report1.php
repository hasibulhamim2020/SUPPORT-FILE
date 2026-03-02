<?php
session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



require_once ('../../common/class.numbertoword.php');



jv_double_check();



$title='Chart Of Accounts';



do_calander('#fdate');

do_calander('#tdate');





$active='bankbo';

$proj_id=$_SESSION['proj_id'];



if($_SESSION['user']['group']>1)



$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' ");



else



$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');



if(isset($_REQUEST['show']))



{



$tdate=$_REQUEST['tdate'];



//fdate-------------------



$fdate=$_REQUEST["fdate"];



$ledger_id=$_REQUEST["ledger_id"];



if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')



$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];



if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')



$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"]);



if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')



$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);



$j=0;



for($i=0;$i<strlen($fdate);$i++)



{



if(is_numeric($fdate[$i]))



$time1[$j]=$time1[$j].$fdate[$i];







else $j++;



}







//$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);







//tdate-------------------











$j=0;



for($i=0;$i<strlen($tdate);$i++)



{



if(is_numeric($tdate[$i]))



$time[$j]=$time[$j].$tdate[$i];



else $j++;



}



//$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);











}



?>



<?php 



	



	$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");



	  if(mysqli_num_rows($led1) > 0)



	  {	



		  $data1 = '[';



		  while($ledg1 = mysqli_fetch_row($led1)){



			  $data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';



		  }



		  $data1 = substr($data1, 0, -1);



		  $data1 .= ']';



	  }



	  else



	  {



		$data1 = '[{ name: "empty", id: "" }]';



	  }



	







?>



<script type="text/javascript">







$(document).ready(function(){







    function formatItem(row) {



		//return row[0] + " " + row[1] + " ";



	}



	function formatResult(row) {



		return row[0].replace(/(<.+?>)/gi, '');



	}







    



	



	var data = <?php echo $data1; ?>;



    $("#cc_code").autocomplete(data, {



		matchContains: true,



		minChars: 0,        



		scroll: true,



		scrollHeight: 300,



        formatItem: function(row, i, max, term) {



            return row.name + " : [" + row.id + "]";



		},



		formatResult: function(row) {            



			return row.id;



		}



	});	











  });







</script>



<!--<script type="text/javascript">



$(document).ready(function(){



	



	$(function() {



		$("#fdate").datepicker({



			changeMonth: true,



			changeYear: true,



			dateFormat: 'dd-mm-y'



		});



	});



		$(function() {



		$("#tdate").datepicker({



			changeMonth: true,



			changeYear: true,



			dateFormat: 'dd-mm-y'



		});



	});







});



</script>-->


	<style>

		.in{
			display: block !important;
		}


		.panel {
			margin: 0px !important;
			border-radius: 0px !important;
			border: 1px !important;
		}

		.panel-heading {
			padding: 0px !important;
		}

		.panel-default>.one {
			background: #696969;
			font-weight: bold;
		}

		.panel-default>.one td{
			color: #333333 !important;
		}

		tr:nth-child(odd){
			background-color: #fafafa!important;
			color: #333333;
		}


		.panel-default>.two {
			background: #adadad;
			font-weight: bold;
		}

		.panel-default>.three {
			background: #d1d1d1;
		}

		.panel-default>.four {
			/* background: #82D8CF; */
		}

		.panel-heading table tr td {
			padding: 3px !important;
			font-size: 12px;
		}

		th,
			/* .table td {
                width: 30%;
            } */


		.sr-ledger-name{
			width: 65%;
		}
		.sr-ledger-dr-amt{
			width: 15%;
		}
		.sr-ledger-cr-amt{
			width: 15%;
		}
		.sr-ledger-action{
			width: 5%;
		}
		.sr-custom-table td{
			font-size: 12px;
		}
		.sr-custom-table td{
			padding: 3px;
		}
	</style>







<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td><div class="left_report">



							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



									<td><div id="reporting">
									<div id="grp">



									<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">



<div class="container ">
        <div class="panel-group" id="faqAccordion">
            <table class="table" style="margin: 0px; background: #82D8CF; color: black;">
                <tr>
                    <th class="sr-ledger-name">Head Name</th>
                    <!-- <th class="sr-ledger-dr-amt">Debit</th>
                    <th  class="sr-ledger-cr-amt">Credit</th> -->
                    <th  class="sr-ledger-action">Action</th>
                </tr>
            </table>

<?

$select = 'select * from acc_class where 1';
$query = db_query($select);
while($row = mysqli_fetch_object($query)){
  
?>

            <div class="panel panel-default ">
                <div class="panel-heading one accordion-toggle question-toggle collapsed">
                    <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
                        <tr>
                            <td  class="sr-ledger-name"><?=$row->class_name?></td>
                            <!-- <td  class="sr-ledger-dr-amt"><?=$value_g_dr[$row->group_id]?></td>
                            <td  class="sr-ledger-cr-amt"><?=$value_g_cr[$row->group_id]?></td> -->
                            <td  class="sr-ledger-action"><button data-toggle="collapse" data-parent="#faqAccordion"
                                    data-target="#f<?=$row->id?>">+</button></td>
                        </tr>
                    </table>
                </div>

                <div id="f<?=$row->id?>" class="panel-collapse collapse" style="height: 0px;">
                    <div class="panel-body" style="padding: 0px;">
                        <?
                        $select2 =  'select * from acc_sub_class where acc_class="'.$row->id.'"';
                        $query2 = db_query($select2);
                        while($row2=mysqli_fetch_object($query2)){
                        ?>
                            <div class="panel panel-default ">
                                <div class="panel-heading two accordion-toggle question-toggle collapsed">
                                    <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
                                        <tr>
                                            <td  class="sr-ledger-name">&emsp;&emsp;<span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">-</span><?=$row2->sub_class_name?></td>
                                            <!-- <td  class="sr-ledger-dr-amt"><?=$value_l_dr[$row2->ledger_id]?></td>
                                            <td  class="sr-ledger-cr-amt"><?=$value_l_cr[$row2->ledger_id]?></td> -->
                                            <td  class="sr-ledger-action"><button data-toggle="collapse" data-parent="#faqAccordion"
                                                    data-target="#s<?=$row2->id?>">+</button></td>
                                        </tr>
                                    </table>

                                </div>
                                <div id="s<?=$row2->id?>" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body" style="padding: 0px;">
                                        <!-- <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
                                            <tr>
                                                <td>One</td>
                                                <td>Three</td>
                                                <td>Four</td>
                                                <td>Action</td>
                                            </tr>
                                        </table> -->


                                        
                                                      <?
                                                      $select3 =  'select * from ledger_group where acc_sub_class="'.$row2->id.'" ';
                                                      $query3 = db_query($select3);
                                                      while($row3=mysqli_fetch_object($query3)){
                                                      ?>
                                                          <div class="panel panel-default ">
                                                              <div class="panel-heading three accordion-toggle question-toggle collapsed">
                                                                  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
                                                                      <tr>
                                                                          <td  class="sr-ledger-name">&emsp;&emsp;&emsp;&emsp;<span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">--</span><?=$row3->group_name?></td>
                                                                          <!-- <td  class="sr-ledger-dr-amt"><?=$value_l_dr[$row3->ledger_id]?></td>
                                                                          <td  class="sr-ledger-cr-amt"><?=$value_l_cr[$row3->ledger_id]?></td> -->
                                                                          <td  class="sr-ledger-action"><button data-toggle="collapse" data-parent="#faqAccordion"
                                                                                  data-target="#t<?=$row3->group_id?>">+</button></td>
                                                                      </tr>
                                                                  </table>

                                                              </div>
                                                              <div id="t<?=$row3->group_id?>" class="panel-collapse collapse" style="height: 0px;">
                                                                  <div class="panel-body" style="padding: 0px;">
                                                                      <table border="1" cellspacing="0" cellpadding="0" class="table sr-custom-table" style="margin-bottom: 0px;;">
                                                                          
                                                                      <?
                                                      $select4 =  'select * from accounts_ledger where  ledger_group_id="'.$row3->group_id.'"';
                                                      $query4 = db_query($select4);
                                                      while($row4=mysqli_fetch_object($query4)){
                                                      ?>
                                                                      
                                                                      <tr>
                                                                              <td  class="sr-ledger-name">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">---</span><?=$row4->ledger_name?></td>
                                                                              <!-- <td  class="sr-ledger-dr-amt"><?=$value_l_dr[$row4->ledger_id]?></td>
                                                                              <td  class="sr-ledger-cr-amt"><?=$value_l_cr[$row4->ledger_id]?></td> -->
                                                                              <td  class="sr-ledger-action"></td>
                                                                          </tr>

                                                                          <?  } ?>
                                                                      </table>


                                                                      

                                                                      
                                                                  </div>
                                                              </div>
                                                          </div>
                                                    <?  } ?>



                                        
                                    </div>
                                </div>
                            </div>
                      <?  } ?>







                    </div>
                </div>
            </div>
<? $grand_dr += $value_g_dr[$row->group_id]; $grand_cr += $value_g_cr[$row->group_id];   } ?>

<!-- <table class="table" style="margin: 0px; background: #82D8CF; color: black;">
                <tr>
                    <th class="sr-ledger-name">Total : </th>
                    <th class="sr-ledger-dr-amt"><?=$grand_dr?></th>
                    <th  class="sr-ledger-cr-amt"><?=$grand_cr?></th>
                    <th  class="sr-ledger-action"> </th>
                </tr>

                <tr>
                    <th class="sr-ledger-name">Difference : </th>
                    <th class="sr-ledger-dr-amt" colspan="3" style="text-align:center;"><?=abs($grand_dr-$grand_cr)?></th>
                </tr>
            </table> -->

           

        </div>
        <script src="bootstrap.min.js"></script>


							</table> 



									<br /><br />                          






									</div></div>                            



							</td>



						  </tr>



						</table>







							</div></td>



    



  </tr>



</table>







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>