<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
<title><?=$master->job_no;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">
function hide()
{
   document.getElementById("pr").style.display="none";
}
</script>


<style type="text/css">
		@media print {
		  .brack {page-break-after: always;}
		}
		
		#pr input[type="button"] {
			width: 70px;
			height: 25px;
			background-color: #ebfffa;
			color: #333;
			font-weight: bolder;
			border-radius: 5px;
			border: 1px solid #333;
			cursor: pointer;
		}
		.p1{
		margin:0px ;
		line-height: 1.5;
		}
		.p{
		margin:0px ;
		line-height: 1.5;
		}
		.pt{
		padding-top:30px;
		}
		.b{
		font-weight:bold;
		}
		.ft-35{
		font-size:35px;
		}
		.ft-34{
		font-size:34px;
		}
		.ft-33{
		font-size:33px;
		}
		.ft-32{
		font-size:32px;
		}
		.ft-31{
		font-size:31px;
		}
		.ft-30{
		font-size:30px;
		}
		.ft-29{
		font-size:29px;
		}
		.ft-25{
		font-size:25px;
		}
		.ft-24{
		font-size:24px;
		}
		.ft-23{
		font-size:23px;
		}
		.ft-22{
		font-size:22px;
		}
		.ft-20{
		font-size:20px;
		}
		.ft-19{
		font-size:19px;
		}
		.ft-18{
		font-size:18px;
		}
		.ft-14{
		font-size:14px;
		}
</style>

</head>
<body style="font-family:Tahoma, Geneva, sans-serif; ">

	<div class="page_brack" >
	
		<div id="pr">
			<h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
		</div>
	
		<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" >
		
		  
		  
		  <thead style="width:100%">
		  <tr>
			  <td colspan="8" ‍align="center">
				  <p class="p b ft-30" align="center"> বৈদেশিক মুদ্রা ঘোষণা ফরম</p>
				  <p class="p ft-25" align="center">(Foreign Exchange Declaration Form)</p>
			  </td>
			  
			  <td colspan="4">
				  <div align="center" style="border:1px solid #333; padding-top:5px; padding-bottom:5px; font-size:16px;">
					 	<P class="p b" style="font-size:15px;"> এফএমজে ফরম</P>
						<p class="p b" style="font-size:15px;">FMJ FORM</p>
				  </div>
			  </td>
		  </tr>
		  <tr>
				<td colspan="12"> &nbsp</td>
		</tr>
		  <tr> 
		  <td colspan="12">
		  	<p class="p b" align="center"> (১৯৪৭ সালের বৈদেশিক মুদ্রা নিয়ন্ত্রণ আইন এর ৮(১) ধারা অনুযায়ী বাংলাদেশ ব্যাংক কর্তৃক প্রবর্তিত)</p>
			<p class="p" align="center">(Prescribed by Bangladesh Bank under Section 8(I) of the Foreign Exchange Regulation Act, 1947)</p>
		  </td>
		  
		  </tr>
		  </thead>
		  <tbody>
		 	<tr>
				<td colspan="12"> &nbsp</td>
			</tr>
		  	<tr> 
				<td colspan="12">
					<p class="p b" align="left"> এই ফরমটি বাংলাদেশের আগমনকারী ব্যক্তি কর্তৃক পুরণ করিতে হইবে।</p>
					<p class="p" align="left"> This form is to be filled in by a person entering Bangladesh. </p>
				</td>
			  
			</tr>
			
			<tr>
				<td colspan="6" class="pt">
					<p class="p b" align="left">পূর্ণ নামঃ</p>
					<p class="p" align="left">(Full Name): </p>
				</td>
				<td colspan="6" class="pt">
					<p class="p b" align="left">জাতীয়তাঃ</p>
					<p class="p" align="left">(Nationality)</p>
				</td>
			</tr>
			
			<tr>
				<td colspan="4" class="pt">
					<p class="p b" align="left">পাসপের্ট নংঃ</p>
					<p class="p" align="left">(Passport No): </p>
				</td>
				<td colspan="4" class="pt">
					<p class="p b" align="left">ইস্যুর তারিখঃ</p>
					<p class="p" align="left">(Date of Issue): </p>
				</td>
				<td colspan="4" class="pt">
					<p class="p b" align="left">ইস্যুর স্থানঃ</p>
					<p class="p" align="left">(Place of Issue): </p>
				</td>
			</tr>
			
			<tr>
				<td colspan="6" class="pt">
					<p class="p b" align="left">আগমনের তারিখ ও সময়ঃ</p>
					<p class="p" align="left">(Date & time of arrival):</p>
				</td>
				<td colspan="6" class="pt">
					<p class="p b" align="left">ফ্লাইট নম্বরঃ</p>
					<p class="p" align="left">(Flight No):</p>
				</td>
			</tr>
			
			<tr>
				<td colspan="6" class="pt">
					<p class="p b" align="left">বাংলাদেশে ঠিকানাঃ</p>
					<p class="p" align="left">(Address in Bangladesh):</p>
				</td>
				<td colspan="6" class="pt">
					<p class="p b" align="left">বিদেশে আবস্থানের মেয়াদঃ</p>
					<p class="p" align="left">(Duration of stay in abroad):</p>
				</td>
			</tr>
			
			<tr>
				<td colspan="6" class="pt">
					<p class="p b" align="left">পেশাঃ</p>
					<p class="p" align="left">(Profession):</p>
				</td>
				<td colspan="6" class="pt">
					<p class="p b" align="left">যোগাযোগ নম্বরঃ</p>
					<p class="p" align="left">(Contact No):</p>
				</td>
			</tr>
		  
		  </tbody>

		</table>
		
		<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top:70px;">
		  <thead style="width:100%">
		  <tr>
			  <td colspan="12" ‍align="center" style="border-bottom:1px solid #333;">
				  <p class="p b ft-20" align="center">ঘোষণা</p>
				  <p class="p b ft-18" style=" padding-bottom:8px;" align="center">DECLARATION</p>
			  </td>
			  
		  </tr>
		  <tr> 
		  <td colspan="12">
		  	<p class="p b" align="center" style="text-align:justify;">সঙ্গে আনীত নগদ বৈদেশিক মুদ্রা এরং হস্ত্রান্তরযোগ্য বাহকের দলিল (ড্রাফট, পে অর্ডার, ট্রাভেলার্স চেক প্রভৃতি) / Cash and negotable bearer instruments in foreign currency (drafts, pay orders, traveler's cheques etc.) in:  </p>
		  </td>
		  
		  </tr>
		  </thead>
		  <tbody>
		  
		 	<tr>
				<td colspan="12"> 
				
				<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
					<thead>
						<tr>
							<th>
							<p class="p b" align="center" >
							বৈদেশিক মুদ্রার বর্ণনা
							</p>
							<p class="p1 b" align="center" >(Description of Currency)</p>
							</th>
							<th>
							<p class="p1 b" align="center" >
							পরিমাণ
							</p>
							<p class="p1 b" align="center" >(Amount) </p>
							</th>
							<th>
							<p class="p1 b" align="center" >
							কথায়
							</p>
							<p class="p1 b" align="center" >(In Words) </p>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td> &nbsp</td>
							<td> &nbsp</td>
							<td> &nbsp</td>
						</tr>
						<tr>
							<td> &nbsp</td>
							<td> &nbsp</td>
							<td> &nbsp</td>
						</tr>
						<tr>
							<td> &nbsp</td>
							<td> &nbsp</td>
							<td> &nbsp</td>
						</tr>
						<tr>
							<td> &nbsp</td>
							<td> &nbsp</td>
							<td> &nbsp</td>
						</tr>
					
					</tbody>
				
				</table>
				
				
				
				</td>
			</tr>
		  
		  
		  
		  
		  
		  
		 	<tr>
				<td colspan="12"> &nbsp</td>
			</tr>

			<td colspan="12">
		  	<p class="p b" align="center"> আমি, নিম্নস্বাক্ষরকারী, এতদ্বারা প্রত্যয়ন করিতেছি যে,উপরে প্রদত্ত তথ্যসমূহ সঠিক। </p>
			<p class="p b" align="center">(I, the undersigned, hereby solemnly declare that the information given above is correct.)  </p>
		  </td>
		  
			<tr>
				<td colspan="6" class="pt">
					<p class="p b" align="left">শুল্ক কর্মকর্তার স্বাক্ষরঃ</p>
					<p class="p" align="left">(Signature of Customs Official): </p>
					<p class="p" align="left">তারিখ(Date): </p>
				</td>
				<td colspan="6" class="pt">
					<p class="p b" align="left">ঘোষণাকারীর স্বাক্ষরঃ</p>
					<p class="p" align="left">Signature of Deciarant:</p>
					<p class="p" align="left">তারিখ(Date): </p>
				</td>
			</tr>

		  </tbody>

		</table>
	
	
	</div>

</body>
</html>
