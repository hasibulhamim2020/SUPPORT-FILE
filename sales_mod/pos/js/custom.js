
    $(document).ready(function(){
	"use strict";
	// get all customer name	
    $("#customer_name").keyup(function(){
    $.ajax({
	url:"get_customer_name.php",
	method:"get",
	datatype:"json",
	data:{
	customer:$("#customer_name").val(),
	},
	success:function(response){
	var availableTags = JSON.parse(response);
	$("#customer_name").autocomplete({
	source: availableTags
	});
	}
	
	});
    });
    var t =0;
    var j =0;
	
    // get item list and item info
	$("#item_id").keyup(function(event){
    var x = event.which || event.keyCode;
    $.ajax({
	url:"get_item_list.php",
	method:"get",
	datatype:"json",
	data:{
	item_info:$("#item_id").val(),
	},
	success:function(response){
	var availableTags1 = JSON.parse(response);
	$("#item_id").autocomplete({
	source: availableTags1
	});
	}
	
	});
    if(x==13){
          t+=1;
          j=t-1;
		  if($("#item_id").val()!=""){
          $.ajax({
          url:"get_item_info.php",
          method:"get",
          datatype:"json",
          data:{
          item_id:$("#item_id").val()
          },
          success:function(response){
          var data = JSON.parse(response);
          var text="";
          if(data.item_name==null){
          alert("Invalid Barcode");
          }else{
          var rate = data.d_price;
          if(rate==0){
          rate="";  
          }
          if(data.stock>0){
          var amt = parseFloat(data.d_price) * 1;
          
          text+="<tr class='new_tr' id='new_tr_"+t+"'><td class='item_name' id='item_id_"+t+"'><input name='item_code[]' id='item_code_"+t+"' class='item_code' type='hidden' value='"+data.item_code+"' />"+data.item_name+"</td><td>"+data.stock+"</td><td><input class='qty' name='qty[]' id='qty_"+t+"' onchange='cal("+t+")' value='1' /></td><td><input class='rate' name='rate[]' id='rate_"+t+"' onchange='cal("+t+")' value='"+rate+"'/></td><td><input class='amount' id='amount_id_"+t+"' value='"+amt+"' /></td><td><input type='button' id='remove_button_"+t+"' class='btn btn-danger' onclick='remove_tr("+t+")' value='Delete'/></td></tr>";
          $("tbody").prepend(text);    
          $("#item_id").val("");
          var sum = 0;
          var total_discount = parseFloat($("#total_discount").val());
          $('.amount').each(function(key, val){
          sum += parseFloat($(this).val());
          });
		  var vat_percent = parseFloat($("#vat_percent").val()*1);
		  $("#total_item_amount").val(sum);
		  $("#vat_amount").val(sum*vat_percent/100);
         $("#grand_total").val(sum-total_discount);
          }else{
          alert("No Stock Found of this Item") ;
          }
          }
          }
          });  
		  }else{
		alert("No Barcode Found");
			}
          }
    });
	
    // full paid function
    $("#full_paid").click(function(){
          var grand_total = parseFloat($("#grand_total").val());
          $("#paid_amount").val(grand_total);
          $("#due").val(0);
          });
    // reset function
    $("#reset").click(function(){
          $("tbody > .new_tr ").html("");
          $(":input").val("");
          $("#total_discount").val(0);
          $("#grand_total").val(0);
          $("#due").val(0);
          });
    // save invoice function
    $("#save_invoice").click(function(){
		 var bool_var = [];
         var date_cus = $("#date").val();
         var customer_name =  $("#customer_name").val();
         var all_tr_element = $(".item_name").length;
		 var current_date = new Date();
		 
		 if(date_cus==""){
		 bool_var.push(false);
		 alert("Invalid Date");
		 }
		 if(customer_name==""){
		 bool_var.push(false);
		 alert("Invalid Customer Name");  
		 }
		 if(all_tr_element>0){
         for(var r = 0; r<=all_tr_element;r++){
             
             if($("#rate_"+r).val()=="" || $("#rate_"+r).val()<0){
		         bool_var.push(false);
                 $("#rate_p_"+r).remove();
                 $("#rate_"+r).css("border", "1px solid red").after("<p id='rate_p_"+r+"' style='color:red'>Invalid Value</p>");
             }
             if($("#qty_"+r).val()=="" || $("#qty_"+r).val()<0){
		         bool_var.push(false);
                 $("#qty_p_"+r).remove();
                 $("#qty_"+r).css("border", "1px solid red").after("<p id='qty_p_"+r+"' style='color:red'>Invalid Value</p>");
             }
             if($("#amount_id_"+r).val()=="" || $("#amount_id_"+r).val()<0){
		         bool_var.push(false);
                 $("#amount_p_"+r).remove(); 
                 $("#amount_id_"+r).css("border", "1px solid red").after("<p id='amount_p_"+r+"' style='color:red'>Invalid Value</p>");
             }
         }
		 }
		 else{
		 bool_var.push(false);	 
		 alert("No Item Selected");
		 }
		 
		var vat_percent = parseFloat($("#vat_percent").val()*1);
		if($("#vat_percent").val()=="" || $("#vat_percent").val()<0){
		bool_var.push(false);
		$("#vat_id").remove();
		$("#vat_percent").css("border", "1px solid red").after("<p id='vat_id' style='color:red'>Invalid Vat Percent</p>");
		}
		else{
		$("#vat_id").remove();
		$("#vat_percent").css("border", "1px solid #dddddd");
		}
		if($("#total_discount").val()<0 || $("#total_discount").val()==""){
		$("#discount_id").remove();
		$("#total_discount").css("border", "1px solid red").after("<p id='discount_id' style='color:red'>Invalid Value</p>");
		}
		else{
		$("#discount_id").remove();
		$("#total_discount").css("border", "1px solid #dddddd");
		}
		
		function truth(less){return less = true;}
		var g_result = bool_var.find(truth);
		if(g_result==undefined){
		$.ajax({
			url:"submit_form.php",
			method:"post",
			dataType:"json",
			data:$("#new_form").serializeArray(),
			success:function(result){

				if(result['pos_id']>0){
				$.get("pos_print_view.php",{pos_id:result['pos_id']}).done(function(data){
				$("#pos_print_report").html(data);});
				// var cus_name =  $("#customer_name").val();
				// $("#modal_cus_name").html(cus_name);
				// var date_var = $("#date").val();
				// $("#modal_date").html(date_var);
				// var new_tr = $(".new_tr").length;
				
				// for(var w = 0; w<new_tr;w++){
				// $("#modal_item_details").append("<tr><td>"+$("#item_id_"+w).html()+"</td></tr>");
				// }
				$('#print_modal').modal('show'); 
				$("tbody > .new_tr ").html("");
				$("#vat_percent").val(5.00);
				$("#total_discount").val(0);
				$("#grand_total").val(0);
				$("#due").val(0);
				$("#customer_name").val("3557::Cash Sale Customer");
				}
				if(result==0){
				alert("Something Wrong Try Later or contact service provider");
					}				
				}
			})
		}
		
	   
         })
     
	 });
	// calculation function
	function cal(id){
	var rate= $("#rate_"+id).val()*1;
	var qty = $("#qty_"+id).val()*1;
	var amt = parseFloat(rate*qty);
	var sum = 0;
	if(rate>=0){
	$("#rate_p_"+id).remove();
	$("#rate_"+id).css("border", "1px solid #DDDDDD");
	}else if(rate<0 || rate=="" ){
	 $("#rate_p_"+id).remove();
	 $("#rate_"+id).css("border", "1px solid red").after("<p id='rate_p_"+id+"' style='color:red'>Invalid Value</p>");	
	}
	if(qty>=0){
	$("#qty_p_"+id).remove();
	$("#qty_"+id).css("border", "1px solid #DDDDDD");
	}else if(qty<0 || qty=="" ){
	$("#qty_p_"+id).remove();
	$("#qty_"+id).css("border", "1px solid red").after("<p id='qty_p_"+id+"' style='color:red'>Invalid Value</p>");	
	}
	if(amt>=0){
	$("#amount_p_"+id).remove();
	$("#amount_id_"+id).css("border", "1px solid #DDDDDD");
	}else if(amt<0 || amt=="" ){
	$("#amount_p_"+id).remove(); 
	$("#amount_id_"+id).css("border", "1px solid red").after("<p id='amount_p_"+id+"' style='color:red'>Invalid Value</p>");
	}
	var total_discount = parseFloat($("#total_discount").val());
	var vat_percent = parseFloat($("#vat_percent").val()*1);
	$("#amount_id_"+id).val(amt);
	$('.amount').each(function(key, val){
	sum += parseFloat($(this).val());
	});
	$("#total_item_amount").val(sum);
	$("#vat_amount").val(sum*vat_percent/100);
	var grand_total = sum-total_discount + (sum*vat_percent/100);
	$("#grand_total").val(grand_total);
	}
	
	// vat calculation function
	function vat_cal(){
		var sum = 0;
		var vat_percent = parseFloat($("#vat_percent").val()*1);
		if($("#vat_percent").val()=="" || $("#vat_percent").val()<0){	
		$("#vat_id").remove();
		$("#vat_percent").css("border", "1px solid red").after("<p id='vat_id' style='color:red'>Invalid Vat Percent</p>");
		}
		else{
		
		$("#vat_id").remove();
		$("#vat_percent").css("border", "1px solid #dddddd");	
		
		var total_discount = parseFloat($("#total_discount").val());
		$('.amount').each(function(key, val){
		sum += parseFloat($(this).val());
		});
		$("#vat_amount").val(sum*vat_percent/100);
		var grand_total = sum-total_discount + (sum*vat_percent/100);
		$("#grand_total").val(grand_total);
		}
		
	}
	
	// discount calculation function
	function discount_cal(){
	var sum = 0;
	if($("#total_discount").val()<0 || $("#total_discount").val()==""){
	$("#discount_id").remove();
	$("#total_discount").css("border", "1px solid red").after("<p id='discount_id' style='color:red'>Invalid Value</p>");
	}
	else{
	$("#discount_id").remove();
	$("#total_discount").css("border", "1px solid #dddddd");
	$('.amount').each(function(key, val){
	sum += parseFloat($(this).val());
	});
	var total_discount = parseFloat($("#total_discount").val());  
	var tot = sum-total_discount;
	$("#grand_total").val(tot);
	vat_cal();	
	}
	
	}
	
	// paid amount calculation function
	function paid_cal(){
	var sum = 0;
	var paid_amt = parseFloat($("#paid_amount").val());
	var total_discount = parseFloat($("#total_discount").val());
	var due = parseFloat($("#due").val());
	var vat_percent = parseFloat($("#vat_percent").val()*1);
	$('.amount').each(function(key, val){
	sum += parseFloat($(this).val());
	});
	$("#due").val((sum-total_discount + (sum*vat_percent/100))-paid_amt);
	}
	
	// remove tr
	function remove_tr(id){
	$("#new_tr_"+id).remove();
	discount_cal();
	paid_cal();
	vat_cal();
	}
	