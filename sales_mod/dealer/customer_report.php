<?php
 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Advance Customer Report'; 	

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');
$tr_type="show";

?>



  <!--Customer report-->
  <form action="../dealer/master_report_complex.php" target="_blank" method="post">


    <div class="form-container_large">
      <h4 class="text-center bg-titel bold pt-2 pb-2"> Select Options </h4>
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer :</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <? create_combobox("dealer_code");?>

                  <select name="dealer_code" id="dealer_code">
                    <option></option>
                    <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1')?>
                  </select>

              </div>
            </div>

          </div>

          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 p-1">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Type :</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <!--<span class="oe_form_group_cell">-->

                                <select name="dealer_type" id="dealer_type">
                                  <option></option>
                                  <? foreign_relation('dealer_type','id','dealer_type',$_POST['dealer_type'], '1');?>

                                </select>
                            <!--</span>-->

              </div>
            </div>
          </div>

        </div>
		
		
		<div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depo List :</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                  <input name="depot_id" list="depots" id="depot_id" type="text" value="<?=$_POST['depot_id'];?>">
				  <datalist id="depots">					  
                    <option></option>
                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],' use_type="WH"');?>
                  </datalist>

              </div>
            </div>

          </div>

          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region :</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                   
                          <input name="branch_id" list="branch" id="branch_id" type="text" value="<?=$_POST['branch_id'];?>">
						  <datalist id="branch">					  
							<option></option>
							<? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['branch_id'],'1');?>
						  </datalist>
                   

              </div>
            </div>
          </div>

        </div>
		
      </div>

      <div class="container-fluid pt-5 p-0 ">

        <h4 class="text-center bg-titel bold pt-2 pb-2">
          Select Columns
        </h4>

        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th  width="5%"></th>
            <th class="text-left"></th>

            <th width="5%"></th>
            <th class="text-left"></th>
          </tr>
          </thead>
          <tbody class="tbody1">

          <tr>
            <td>
              <input name="report" type="hidden" value="201" checked="checked" />
              <input name="dealer_name_e" type="checkbox" id="dealer_name_e" value="1" />
            </td>
            <td style="text-align:left">Customer Name</td>

            <td><input name="region_code" type="checkbox" id="region_code" value="1" /></td>
            <td style="text-align:left">Region</td>
          </tr>


          <tr>
            <td>
              <input name="propritor_name_e" type="checkbox" id="propritor_name_e" value="1" />
            </td>
            <td style="text-align:left">Proprietor Name</td>

            <td><input name="zone_code" type="checkbox" id="zone_code" value="1" /></td>
            <td style="text-align:left">Zone</td>
          </tr>

          <tr>
            <td><input name="dealer_type_code" type="checkbox" id="dealer_type_code" value="1" /></td>
            <td style="text-align:left">Customer Type</td>

            <td><input name="area_code" type="checkbox" id="area_code" value="1" /></td>
            <td style="text-align:left">Area</td>
          </tr>

          <tr>
            <td><input name="contact_no" type="checkbox" id="contact_no" value="1" /></td>
            <td style="text-align:left">Main Phone</td>

            <td><input name="address_e" type="checkbox" id="address_e" value="1" /></td>
            <td style="text-align:left">Address</td>
          </tr>

          <tr>
            <td><input name="sms_mobile_no" type="checkbox" id="sms_mobile_no" value="1" /></td>
            <td style="text-align:left">SMS Phone</td>

            <td><input name="credit_limit" type="checkbox" id="credit_limit" value="1" /></td>
            <td style="text-align:left">Credit Limit</td>
          </tr>

          <tr>
            <td><input name="email" type="checkbox" id="v" value="1" /></td>
            <td style="text-align:left">Main Email</td>

            <td><input name="depot" type="checkbox" id="depot" value="1" /></td>
            <td style="text-align:left">Depot</td>
          </tr>

          <tr>
            <td><input name="cc_email" type="checkbox" id="cc_email" value="1" /></td>
            <td for="cc_email" style="text-align:left">CC Email</td>

            <td><input name="contact_person_designation" type="checkbox" id="contact_person_designation" value="1" /></td>
            <td style="text-align:left">Job Title</td>
          </tr>

          <tr>
            <td><input name="contact_person_name" type="checkbox" id="contact_person_name" value="1" /></td>
            <td style="text-align:left">Contact Person</td>

            <td><input name="contact_person_mobile" type="checkbox" id="contact_person_mobile" value="1" /></td>
            <td style="text-align:left">Contact Person Phone</td>
          </tr>


          </tbody>
        </table>


          <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
              <input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
            </div>

          </div>


      </div>
    </div>

  </form>




















<?/*>

<form action="../dealer/master_report_complex.php" target="_blank" method="post">

<div class="oe_view_manager oe_view_manager_current">

        

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form">
                  <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container">
          <div class="oe_form">

          <div class="">

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

<table width="100%" border="0" class="table table-bordered table-sm"><thead>



<tr class="oe_list_header_columns">

  <th colspan="4"><span style="text-align:center; font-size:16px; color:#C00">Select Options</span></th>

  </tr>

</thead><tfoot>

</tfoot><tbody>

  <tr>

    <td width="40%" align="right"><strong>Customer :</strong></td>
<? create_combobox("dealer_code");?>
  <td width="10%" align="left">

    <select name="dealer_code" id="dealer_code" style="width:200px;">
  <option></option>
  <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1')?>
  </select>

  </td>

  <td width="40%" align="right" class="alt"><strong>Customer Type :</strong></td>

    <td width="10%">
      <span class="oe_form_group_cell">

      <select name="dealer_type" style="width:160px;" id="dealer_type">

          <option></option>

        <? foreign_relation('dealer_type','id','dealer_type',$_POST['dealer_type'], '1');?>

      </select>

      </span>
    </td>

  </tr>

  </tbody>
</table>



<div style="text-align:center">

<table width="100%" class="table table-bordered table-sm">

  <thead>

<tr class="oe_list_header_columns">

  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Columns</span></th>
  </tr>
  </thead>

  <tfoot>
  </tfoot>

  <tbody>

    <tr>

      <td align="center" class="alt">
        <input name="report" type="hidden" value="201" checked="checked" />
        <input name="dealer_name_e" type="checkbox" id="dealer_name_e" value="1" />
      </td>

      <td class="alt">Customer Name</td>

      <td width="4%" align="center"><input name="region_code" type="checkbox" id="region_code" value="1" /></td>

      <td width="44%">Region</td>
      </tr>

    <tr>

      <td align="center"><span class="alt">

        <input name="propritor_name_e" type="checkbox" id="propritor_name_e" value="1" />

      </span></td>

      <td>Propritor Name</td>

      <td align="center" class="alt"><input name="zone_code" type="checkbox" id="zone_code" value="1" /></td>

      <td class="alt">Zone</td>
    </tr>

    <tr>

      <td width="4%" align="center"><input name="dealer_type_code" type="checkbox" id="dealer_type_code" value="1" /></td>

      <td width="44%">Customer Type</td>

      <td align="center" class="alt"><input name="area_code" type="checkbox" id="area_code" value="1" /></td>

      <td class="alt">Area</td>
    </tr>

    <tr >

      <td align="center" class="alt"><input name="contact_no" type="checkbox" id="contact_no" value="1" /></td>

      <td class="alt">Main Phone</td>

      <td align="center"><input name="address_e" type="checkbox" id="address_e" value="1" /></td>

      <td>Address</td>
    </tr>

    <tr >

      <td align="center" class="alt"><input name="sms_mobile_no" type="checkbox" id="sms_mobile_no" value="1" /></td>

      <td class="alt">SMS Phone</td>

      <td align="center"><input name="credit_limit" type="checkbox" id="credit_limit" value="1" /></td>

      <td>Credit Limit</td>
      </tr>

    <tr >

      <td align="center" class="alt"><input name="email" type="checkbox" id="v" value="1" /></td>

      <td class="alt">Main Email</td>

      <td align="center"><input name="depot" type="checkbox" id="depot" value="1" /></td>

      <td>Depot</td>
      </tr>

    <tr >

      <td align="center"><input name="cc_email" type="checkbox" id="cc_email" value="1" /></td>

      <td>CC Email</td>

      <td align="center"><input name="contact_person_designation" type="checkbox" id="contact_person_designation" value="1" /></td>

      <td>Job Title</td>
    </tr>

    <tr >

      <td align="center"><input name="contact_person_name" type="checkbox" id="contact_person_name" value="1" /></td>

      <td>Contact Person</td>

      <td align="center"><input name="contact_person_mobile" type="checkbox" id="contact_person_mobile" value="1" /></td>

      <td>Contact Person Phone</td>
    </tr>

    



<tr >

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>
</tr>
  </tbody>
</table>

<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />

          </div></div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

  </div>

</form>

  <*/?>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>