<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Customer Aging Report';



do_calander("#f_date");

do_calander("#t_date");

?>

    <div class="d-flex justify-content-center">
        <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
            <div class="row m-0 p-0">
                <div class="col-sm-5">
                    <div class="text-start">Select Report </div>
                    <div class="form-check">
                        <input name="report" type="radio" class="radio1" id="report1-btn" value="230226001"  checked="checked" />
                        <label class="form-check-label p-0" for="report1-btn">
                            Customer Aging Report
                        </label>
                    </div>
                    

                </div>

                <div class="col-sm-7">
                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">	</label>
                        <div class="col-sm-8 p-0">
                        </div>
                    </div>

                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"></label>
                        <div class="col-sm-8 p-0">
                                                <span id="acc_gl_ledger">
                           
                                                </span>
                        </div>
                    </div>


                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Year</label>
                        <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <select  name="year"  id="year" class="form-control">
                        </select>
                      </span>

                        </div>
                    </div>

                    <div class="form-group row m-0 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Period :</label>
                        <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select   name="period" type="text" id="period"  class="form-control">
                            <option value="Q1">January - March</option>
                            <option value="Q2">April - June</option>
                            <option value="Q3">July - September</option>
                            <option value="Q4">October - December</option>
                            </select>

                        </span>


                        </div>
                    </div>



                </div>

            </div>
            <div class="n-form-btn-class">
                <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />
            </div>
        </form>
    </div>



    <script>
        // Get the select element by its ID
        var yearSelect = document.getElementById("year");

        // Get the current year
        var currentYear = new Date().getFullYear();
        var yearsToInclude = 5;
        for (var year = currentYear; year <= currentYear + yearsToInclude; year++) {
            var option = document.createElement("option");
            option.text = year;
            option.value = year;
            yearSelect.appendChild(option);
        }
    </script>
<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>