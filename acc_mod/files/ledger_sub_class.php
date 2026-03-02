<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ledger Sub Class';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
//var_dump($_SESSION);
if(isset($_REQUEST['sub_class_name'])||isset($_REQUEST['sub_class_id']))
{
//common part.............
$sub_class_name			= mysqli_real_escape_string($_REQUEST['sub_class_name']);
$sub_class_type_id		= mysqli_real_escape_string($_REQUEST['sub_class_type_id']);
$sub_class_id			= mysqli_real_escape_string($_REQUEST['sub_class_id']);
//end 
if(isset($_POST['ngroup']) && !empty($sub_class_name))
{
					$sql="INSERT INTO `acc_sub_class` (
					`sub_class_name`,
					`sub_class_type_id` ,
					`status`
					)
					VALUES ('$sub_class_name','$sub_class_type_id', '1')";

					$query=db_query($sql);
					$type=1;
					$msg='New Entry Successfully Inserted.';
}


//for Modify..................................

if(isset($_POST['mgroup']))
{
	$sql="UPDATE `acc_sub_class` SET 
		`sub_class_name` = '$sub_class_name',
		`sub_class_type_id` ='$sub_class_type_id'
		WHERE `id` = $sub_class_id LIMIT 1";
	$qry=db_query($sql);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['dgroup']))
{

	$sql="UPDATE `acc_sub_class` SET 
		`status` = '0'
		WHERE `id` = $sub_class_id LIMIT 1";
		$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}



		$ddd="select * from acc_sub_class where id='$sub_class_id' and 1";
		$dddd=db_query($ddd);
		if(mysqli_num_rows($dddd)>0)
		$data = mysqli_fetch_row($dddd);
}
?>
<script type="text/javascript">

function checkUserName()
{	
	var e = document.getElementById('group_name');
	if(e.value=='')
	{
		alert("Invalid Group Name!!!");
		e.focus();
		return false;
	}
	else
	{
		$.ajax({
		  url: 'common/check_entry.php',
		  data: "query_item="+$('#group_name').val()+"&pageid=ledger_group",
		  success: function(data) 
		  	{			
			  if(data=='')
			  	return true;
			  else	
			  	{
				alert(data);
				e.value='';
				e.focus();
				return false;
				}
			}
		});
	}
}
function DoNav(theUrl)
{
	document.location.href = 'ledger_sub_class.php?sub_class_id='+theUrl;
}
</script>
 
<select name="PBI_ID" id="PBI_ID"   class="selectpicker form-control" data-live-search="true">
        <option></option>
                <option value="2">
          MNG-008          |
          Tapan Kumar Roy          |
                    |
          Executive Director          </option>
                <option value="3">
          MNG-009          |
          Chowdhury Alamgir Hossain          |
                    |
          Executive Director          </option>
                <option value="4">
          MNG-002          |
          Md. Ariful Hoque Shuhan          |
          Sales & Marketing           |
          Vice Chairman           </option>
                <option value="5">
          MNG-003          |
          S. M Faysal           |
          Utility Sales           |
          Director          </option>
                <option value="6">
          MNG-004          |
          Abu Bakar Shiddik          |
          Engineering & Design           |
          Deputy Managing Director           </option>
                <option value="7">
          HO-240          |
          Md. Sirajul Alam          |
          Project Management Office (Alpha)           |
          General Manager          </option>
                <option value="8">
          HO-392          |
          Md. Khairul Islam          |
          Sales & Marketing           |
          Assistant General Manager          </option>
                <option value="9">
          HO-109          |
          Md. Aktarujjaman Sajib          |
          Engineering Documentation & Development           |
          Manager          </option>
                <option value="10">
          HO-006          |
          Ashish Saha          |
          Project Management Office (Alpha)           |
          Head of Project Execution          </option>
                <option value="11">
          HO-056          |
          Md. Younus Tareq          |
          Project Management Office (Alpha)           |
          Head of Service          </option>
                <option value="12">
          HO-059          |
          Md. Ariful Islam          |
          Project Management Office (Alpha)           |
          Deputy Manager          </option>
                <option value="13">
          HO-221          |
          Aftabur Rahman          |
                    |
          Deputy Manager          </option>
                <option value="14">
          HO-031          |
          Md. Jannatul Al Mamun          |
          Project Management Office (Alpha)           |
          Senior Engineer          </option>
                <option value="15">
          HO-037          |
          Gopi Narayan Sardar          |
          Project Management Office (Alpha)           |
          Senior Engineer          </option>
                <option value="16">
          HO-044          |
          Md. Al Imran          |
          Project Management Office (Alpha)           |
          Senior Engineer          </option>
                <option value="17">
          HO-067          |
          Hashem Talukder          |
          Project Management Office (Alpha)           |
          Senior Engineer          </option>
                <option value="18">
          HO-126          |
          Malay Kumar Pramanik          |
          Project Management Office (Alpha)           |
          Senior Engineer          </option>
                <option value="19">
          HO-127          |
          Md. Mosfiqur Rahman          |
          Supply Chain Management            |
          Senior Engineer          </option>
                <option value="20">
          HO-133          |
          Abu Sayeed Md Bin Noor Rakib          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="21">
          HO-147          |
          Jan-A-Alam          |
          Project Management Office (Alpha)           |

          Senior Engineer          </option>
                <option value="22">
          HO-149          |
          Md. Alif Al Shefaet          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="23">
          HO-185          |
          S. M. Touhidur Rahman          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="24">
          HO-217          |
          Md. Shikat Hossain          |
          Engineering Documentation & Development           |
          Senior Engineer          </option>
                <option value="25">
          HO-342          |
          Rokonuzzaman          |
          Sales & Marketing           |
          Senior Engineer          </option>
                <option value="26">
          HO-024          |
          Mohammad Ekram Khan          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="27">
          HO-111          |
          Md. Simun Ahmed          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="28">
          HO-140          |
          Md. Sahidul Islam          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="29">
          HO-159          |
          Md. Farhad Sarker          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="30">
          HO-227          |
          Md. Shahnewaz          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="31">
          HO-237          |
          Fahima Akter          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="32">
          HO-261          |
          Md. Shekh Farid          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="33">
          HO-264          |
          Md. Mahmudul Hasan          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="34">
          HO-277          |
          Amirul Islam Razu          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="35">
          HO-338          |
          Md. Khourshed Alam          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="36">
          HO-345          |
          Maisha Farjana          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="37">
          HO-353          |
          Abu Farha Md. Tohedur Rahman Tohed          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="38">
          HO-357          |
          Sadid Siraj          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="39">
          HO-358          |
          Mizanur Rahman          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="40">
          HO-359          |
          Murtuza Ali Reza          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="41">
          HO-360          |
          Md. Zubayed Hossain Jamil          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="42">
          HO-361          |
          Enamul Huq Sabuj          |
                    |
          Assistant Engineer          </option>
                <option value="43">
          HO-362          |
          Md. Ashif Iqbal          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="44">
          HO-366          |
          Jakia Mustary Lina          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="45">
          HO-367          |
          Karim Shafiul Bashar          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="46">
          HO-368          |
          Samina Alam Lisa          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="47">
          HO-380          |
          Ummey Sufia Mousumi          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="48">
          HO-381          |
          Md. Mehedi Hasan          |
                    |
          Assistant Engineer          </option>
                <option value="49">
          HO-382          |
          Md. Masum Billah          |
          Engineering & Design           |
          Assistant Engineer          </option>
                <option value="50">
          HO-383          |
          Md. Mahafuzur Rahman          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="51">
          HO-384          |
          Md. Rahidul Islam Ratul          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="52">
          HO-385          |
          Md. Shafatur Rahman          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="53">
          HO-412          |
          Abdul Malak Shifat          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="54">
          TR-004          |
          Sirajam Munira          |
                    |
          Trainee Engineer          </option>
                <option value="55">
          HO-082          |
          Md. Shehab Uddin          |
          Supply Chain Management            |
          Executive          </option>
                <option value="56">
          HO-282          |
          Md. Asaduzzaman          |
          Accounts & Finance          |
          Executive          </option>
                <option value="57">
          HO-207          |
          Md. Khairul Basar Plabon          |
          Project Management Office (Alpha)           |
          Executive          </option>
                <option value="58">
          HO-098          |
          Sohidur Rahman          |
          Audit-Cost Control & Compliance           |
          Junior Executive          </option>
                <option value="59">
          HO-145          |
          Md. Masum Hossain          |
          Engineering Documentation & Development           |
          Junior Executive          </option>
                <option value="60">
          HO-327          |
          Golam Rabbi          |
          Project Management Office (Alpha)           |
          Junior Executive          </option>
                <option value="61">
          HO-287          |
          Farid Kazi          |
          Supply Chain Management            |
          Junior Executive          </option>
                <option value="62">
          HO-378          |
          Md. Shakil Sarkar          |
          Supply Chain Management            |
          Junior Executive          </option>
                <option value="63">
          HO-400          |
          Md. Abdur Rakib          |
          Project Management Office (Alpha)           |
          Junior Executive          </option>
                <option value="64">
          HO-248          |
          Fahaduzzaman          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="65">
          HO-249          |
          Md. Abul Kashem          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="66">
          HO-254          |
          Md. Sohel Rana          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="67">
          HO-255          |
          Md. Golam Azam          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="68">
          HO-256          |
          Al-Amin Touhid          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="69">
          HO-257          |
          Ashok Kumar Saha          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="70">
          HO-258          |
          Mohen Chandra Roy          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="71">
          HO-259          |
          Md. Jahidul Islam          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="72">
          HO-260          |
          Dipok Roy          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="73">
          HO-262          |
          Md. Shahnewaz Noyon          |
          Supply Chain Management            |
          Junior Assistant Engineer          </option>
                <option value="74">
          HO-263          |
          Md. Abu Huraira (Shohid)          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="75">
          HO-269          |
          Md. Razaul Karim          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="76">
          HO-288          |
          Md. Shah Alam          |
          Supply Chain Management            |
          Junior Assistant Engineer          </option>
                <option value="77">
          HO-291          |
          Ahasan Habib          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="78">
          HO-293          |
          Naim Hasan          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="79">
          HO-295          |
          Md. Nazmul Haque          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="80">
          HO-318          |
          Mahafuz Howlader          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="81">
          HO-369          |
          Md. Aburasel Jony          |
          Engineering Documentation & Development           |
          Junior Assistant Engineer          </option>
                <option value="82">
          HO-386          |
          Md. Shaokat Sharif          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="83">
          HO-387          |
          Md. Abdur Razzak          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="84">
          HO-388          |
          Monoj Dhali          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="85">
          HO-393          |
          Md. Mehedi Hasan          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="86">
          HO-394          |
          Md. Fahim Hoshen          |
                    |
          Junior Assistant Engineer          </option>
                <option value="87">
          HO-395          |
          Md. Zubayer Shakil          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="88">
          HO-003          |
          Md. Shahangir Alam          |
          Project Management Office (Alpha)           |
          Senior Supervisor          </option>
                <option value="89">
          HO-021          |
          Sattajit Halder          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="90">
          HO-079          |
          Md. Fazlur Rahman          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="91">
          HO-104          |
          Md. Shofi Uddin          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="92">
          HO-206          |
          Md. Ansarul Haque          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="93">
          HO-252          |
          Pobitro Kumar Mondol          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="94">
          HO-299          |
          Mohammad Panjab Ali          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="95">
          HO-314          |
          Md. Abdul Gofur          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="96">
          HO-316          |
          Md. Jakirul Islam          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="97">
          HO-430          |
          Md. Sukkur Ali          |
          Project Management Office (Alpha)           |
          Foreman          </option>
                <option value="98">
          HO-019          |
          Md. Mamun Hossain          |
          Project Management Office (Alpha)           |
          Senior Technician          </option>
                <option value="99">
          HO-034          |
          Md. Ebrahim Sheikh          |
          Project Management Office (Alpha)           |
          Senior Technician          </option>
                <option value="100">
          HO-035          |
          Shahin Sheikh          |
          Project Management Office (Alpha)           |
          Senior Technician          </option>
                <option value="101">
          HO-064          |
          Md. Abid Mahmud Sobuj          |
          Project Management Office (Alpha)           |
          Senior Technician          </option>
                <option value="102">
          HO-119          |
          Bisnu Sikder          |
          Project Management Office (Alpha)           |
          Senior Technician          </option>
                <option value="103">
          HO-202          |
          Md. Shamim Howlader          |
          Project Management Office (Alpha)           |
          Senior Technician          </option>
                <option value="104">
          HO-020          |
          Raju Ahmed          |
          Project Management Office (Alpha)           |
          Technician          </option>
                <option value="105">
          HO-050          |
          Shohel Sheikh          |
          Project Management Office (Alpha)           |
          Technician          </option>
                <option value="106">
          HO-118          |
          Md. Noor Islam           |
          Project Management Office (Alpha)           |
          Technician          </option>
                <option value="107">
          HO-274          |
          Md. Shohil Rana          |
          Project Management Office (Alpha)           |
          Technician          </option>
                <option value="108">
          HO-389          |
          Md. Shahed Sharif          |
          Project Management Office (Alpha)           |
          Technician          </option>
                <option value="109">
          HO-390          |
          Md. Shafiqul Islam          |
          Project Management Office (Alpha)           |
          Technician          </option>
                <option value="110">
          HO-161          |
          Md. Abul Kalam          |
          HR & Admin          |
          Driver          </option>
                <option value="111">
          HO-196          |
          Md. Alamin Howlader          |
          HR & Admin          |
          Driver          </option>
                <option value="114">
          MNG-005          |
          Abdur Rahman          |
                    |
          Director          </option>
                <option value="115">
          HO-040          |
          Md. Abid Hossain          |
          Project Management Office (Gamma)          |
          Manager          </option>
                <option value="116">
          HO-043          |
          Md. Abdul Alim Sarker          |
          Project Management Office (Gamma)          |
          Senior Engineer          </option>
                <option value="117">
          HO-335          |
          Shahin Mahmud          |
          Project Management Office (Gamma)          |
          Senior Engineer          </option>
                <option value="118">
          HO-266          |
          Md. Shamsur Rahman          |
          Project Management Office (Gamma)          |
          Assistant Engineer          </option>
                <option value="119">
          HO-328          |
          Md. Mahmudul Alam          |
          Project Management Office (Gamma)          |
          Assistant Engineer          </option>
                <option value="120">
          HO-376          |
          M. Sajib Zaheen          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="121">
          HO-377          |
          Md. Ridwanur Rahman          |
                    |
          Assistant Engineer          </option>
                <option value="122">
          HO-270          |
          Khokon Mia          |
          Project Management Office (Gamma)          |
          Junior Assistant Engineer          </option>
                <option value="123">
          HO-339          |
          Anowarul Islam          |
          Project Management Office (Gamma)          |
          Junior Assistant Engineer          </option>
                <option value="124">
          HO-411          |
          Khondoker Sadman Shabab          |
                    |
          Junior Assistant Engineer          </option>
                <option value="126">
          MNG-006          |
          Md. Jahangir Al Jilani          |
          Audit-Cost Control & Compliance           |
          Managing Director          </option>
                <option value="127">
          HO-005          |
          Md. Zikrul Hasan          |
          Sales & Marketing           |
          Senior Manager          </option>
                <option value="128">
          HO-171          |
          Md. Mahfujur Rahman          |
          Project Management Office (Beta)          |
          Manager          </option>
                <option value="129">
          HO-194          |
          Md. Moyenudden           |
          Supply Chain Management            |
          Manager          </option>
                <option value="130">
          HO-070          |
          Md. Abdus Salam          |
          Engineering & Design           |
          Senior CAD Engineer          </option>
                <option value="131">
          HO-209          |
          Md. Alomgir          |
          Engineering & Design           |
          Senior 3D Designer          </option>
                <option value="132">
          HO-429          |
          Mst. Rowshonara Khatun          |
          Engineering & Design           |
          Junior CAD Engineer          </option>
                <option value="133">
          HO-047          |
          Mohammad Rakib Uddin Khan          |
          Sales & Marketing           |
          Manager          </option>
                <option value="134">
          HO-333          |
          Anish Kumar Biswas          |
                    |
          Deputy Manager          </option>
                <option value="135">
          HO-086          |
          Maruf Ur Rashid          |
          Project Management Office (Beta)          |
          Manager          </option>
                <option value="136">
          HO-407          |
          Nazmul Hasan          |
          Audit-Cost Control & Compliance           |
          Deputy Manager          </option>
                <option value="137">
          HO-015          |
          Iqbal Masud          |
          Project Management Office (Beta)          |
          Assistant Manager          </option>
                <option value="138">
          HO-028          |
          Md. Zayed Mahmud Shakil          |
          Project Management Office (Beta)          |
          Assistant Manager          </option>
                <option value="139">
          HO-029          |
          Goutwm Kumar Biswas          |
          Project Management Office (Beta)          |
          Senior Engineer          </option>
                <option value="140">
          HO-072          |
          Sanjib Kumar Nandi          |
          Engineering Documentation & Development           |
          Assistant Manager          </option>
                <option value="141">
          HO-095          |
          Bipro Kanti Ghosh          |
          Engineering Documentation & Development           |
          Assistant Manager          </option>
                <option value="142">
          HO-223          |
          S. M. Tariqul Islam          |
          Sales & Marketing           |
          Senior Engineer          </option>
                <option value="143">
          HO-242          |
          Engr. Romanul Islam          |
          Sales & Marketing           |
          Senior Engineer          </option>
                <option value="144">
          HO-241          |
          Md. Shahin Khan          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="145">
          HO-281          |
          Nurmohammad Ali          |
          Project Management Office (Beta)          |
          Executive          </option>
                <option value="146">
          HO-332          |
          Md. Hasanur Rahman          |
                    |
          Executive          </option>
                <option value="147">
          HO-199          |
          Md. Munibur Rahman          |
          Supply Chain Management            |
          Executive          </option>
                <option value="148">
          HO-350          |
          Md. Azizul Haque          |
          Supply Chain Management            |
          Executive          </option>
                <option value="149">
          HO-399          |
          Md. Hanjala Islam (Hamja)          |
                    |
          Junior Executive          </option>
                <option value="150">
          HO-053          |
          A.K.M Rabiul Ahsan          |
          Project Management Office (Beta)          |
          Senior Engineer          </option>
                <option value="151">
          HO-075          |
          Md. Shahriar Mehmood          |
          Engineering Documentation & Development           |
          Senior Engineer          </option>
                <option value="152">
          HO-100          |
          Riaz Tazim Rafi          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="153">
          HO-101          |
          Md. Zakir Hossain          |
          Engineering & Design           |
          Assistant Engineer          </option>
                <option value="154">
          HO-165          |
           Md Abu Rayhan Mostofa          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="155">
          HO-189          |
          Md. Akash          |
          Sales & Marketing           |
          Assistant Engineer          </option>
                <option value="156">
          HO-200          |
          Al Amin Hossain          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="157">
          HO-205          |
          Atik Raian Himel          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="158">
          HO-215          |
          Md. Mahmudul Hasan          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="159">
          HO-216          |
          Md. Razibul Islam          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="160">
          HO-224          |
          Md. Kutub Uddin          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="161">
          HO-228          |
          Md. Olliullah Lipon          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="162">
          HO-265          |
          Md. Shazzad Hossain          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="163">
          HO-267          |
          Md. Mashiur Rahman Khan          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="164">
          HO-286          |
          Md. Juel Hasan          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="165">
          HO-290          |
          Mowsumi Bhattacharjee          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="166">
          HO-305          |
          Md. Shafiqul          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="167">
          HO-306          |
          Muhammad Nazmul Hasan          |
                    |
          Assistant Engineer          </option>
                <option value="168">
          HO-308          |
          Ashif Iqbal Khan          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="169">
          HO-309          |
          Md. Rizvi Hannan Nissan          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="170">
          HO-315          |
          Md. Nayeem Hossain          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="171">
          HO-340          |
          Sajid Hasan          |
                    |
          Assistant Engineer          </option>
                <option value="172">
          HO-348          |
          Rasel Ahmed          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="173">
          HO-356          |
          Md. Shakil Ahmed          |
                    |
          Assistant Engineer          </option>
                <option value="174">
          HO-375          |
          S.M. Mahmud Hasan          |
                    |
          Assistant Engineer          </option>
                <option value="175">
          HO-401          |
          Shuvra Dev Mittra          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="176">
          HO-408          |
          Minhaz Ahmed Pallab          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="177">
          HO-419          |
          Md. Ahsanul Haque          |
          Engineering & Design           |
          Assistant Engineer          </option>
                <option value="178">
          HO-420          |
          Afsana Rahman Mou          |
                    |
          Assistant Engineer          </option>
                <option value="179">
          HO-421          |
          Shahara Rahman Esha          |
                    |
          Assistant Engineer          </option>
                <option value="180">
          HO-422          |
          Lutfan Nahar Mohona          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="181">
          HO-102          |
          Md. Rakibul Hasan (Ratul)          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="182">
          HO-174          |
          Hridoy Hossain          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="183">
          HO-176          |
          Md. Ariful Islam          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="184">
          HO-177          |
          Md. Rakibul Islam          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="185">
          HO-271          |
          Sabashis Das          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="186">
          HO-303          |
          Ramjan Ali          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="187">
          HO-304          |
          Md. Parvez Kabir          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="188">
          HO-302          |
          Md. Abdur Rahman          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="189">
          HO-313          |
          Md. Shahadat Hossain          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="190">
          HO-325          |
          Md. Saidul Islam          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="191">
          HO-326          |
          Md. Nurul Islam          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="192">
          HO-320          |
          Kazi Sabbir Ahmed          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="193">
          HO-321          |
          All Mamun          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="194">
          HO-322          |
          Abdullah-Al-Mamun          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="195">
          HO-323          |
          Nahid Islam          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="196">
          HO-334          |
          Md. Zahidur Rahman          |
          Engineering Documentation & Development           |
          Junior Assistant Engineer          </option>
                <option value="197">
          HO-337          |
          Md. Mahadi Hasan          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="198">
          HO-431          |
          Saidul Islam Shakil          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="199">
          HO-272          |
          Md. Mehedi Hasan          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="200">
          HO-188          |
          Saddam Hossain Siddiqui          |
          Audit-Cost Control & Compliance           |
          Junior Executive          </option>
                <option value="201">
          HO-208          |
          Md. Nazmul Islam          |
          Project Management Office (Beta)          |
          Junior Executive          </option>
                <option value="202">
          HO-023          |
          Mohammad Ali          |
          Project Management Office (Beta)          |
          Foreman          </option>
                <option value="203">
          HO-409          |
          Md. Masud Rana          |
          Project Management Office (Beta)          |
          Foreman          </option>
                <option value="204">
          HO-039          |
          Md. Rayhan Uddin Bahar          |
                    |
          Assistant Foreman          </option>
                <option value="205">
          HO-418          |
          Md. Omar Faruque          |
          Project Management Office (Beta)          |
          Supervisor          </option>
                <option value="206">
          HO-300          |
          Molla Hashekuzzaman          |
          Project Management Office (Beta)          |
          Senior Technician          </option>
                <option value="207">
          HO-417          |
          Mamun Sheikh          |
          Project Management Office (Beta)          |
          Senior Technician          </option>
                <option value="208">
          HO-065          |
          Md. Golam Kader Cidiki          |
                    |
          Technician          </option>
                <option value="209">
          HO-110          |
          Sadekul Islam          |
          Project Management Office (Beta)          |
          Senior Technician          </option>
                <option value="210">
          HO-187          |
          Md. Akter Hossen          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="211">
          HO-192          |
          Md. Jakir Hossen          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="212">
          HO-201          |
          Jinnatul Islam Rasel          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="213">
          HO-203          |
          Md. Niamul Kabir          |
          Project Management Office (Beta)          |
          Senior Technician          </option>
                <option value="214">
          HO-312          |
          Md. Shakil Khan          |
                    |
          Technician          </option>
                <option value="215">
          HO-347          |
          Md. Rafiqul Islam          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="216">
          HO-352          |
          Md. Ataur Rahman          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="217">
          HO-364          |
          Md. Mehedi Hasan Liton          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="218">
          HO-365          |
          Md. Panna          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="219">
          HO-397          |
          Md. Rofiqul Islam          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="220">
          HO-398          |
          Md. Al-Amin Sheikh          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="221">
          HO-414          |
          Md. Rubel Munshi          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="222">
          HO-415          |
          Md. Razib Munshi          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="223">
          HO-331          |
          Md. Foysal Ahmed          |
                    |
          Helper          </option>
                <option value="224">
          HO-396          |
          Sree Nironjon Kumar Shel          |
          Project Management Office (Beta)          |
          Helper          </option>
                <option value="225">
          HO-167          |
          Md. Jewel          |
          HR & Admin          |
          Driver          </option>
                <option value="226">
          HO-169          |
          Md. Robiul Islam          |
          HR & Admin          |
          Driver          </option>
                <option value="227">
          HO-310          |
          Md. Rajon Howlader          |
          HR & Admin          |
          Driver          </option>
                <option value="228">
          HO-413          |
          Md. Habibur Rahman          |
          HR & Admin          |
          Driver          </option>
                <option value="229">
          FAC-110          |
          Engr. Nazmul HudaTutul          |
          R&D+ Management          |
          Senior Genaral Manager          </option>
                <option value="230">
          FAC-058          |
          Md. Jashim Uddin          |
          Production+Management          |
          General Manager          </option>
                <option value="231">
          FAC-022          |
          Md. Mahadi Hasan          |
          R&D+ Management          |
          Manager          </option>
                <option value="232">
          FAC-082          |
          ENGR. Md. Minhaj Morshed          |
          Production+Management          |
          Manager          </option>
                <option value="233">
          FAC-084          |
          Lipon Chandra Roy (Bijoy)          |
          Supply Chain Management            |
          Senior Executive          </option>
                <option value="234">
          FAC-003          |
          Md. Anowar Hossain          |
          Production+Management          |
          Assistant Engineer          </option>
                <option value="235">
          FAC-036          |
          Md. Sanwar Ullah          |
          Admin (Factory)          |
          Executive          </option>
                <option value="236">
          FAC-113          |
          Sagar Kumer Bagchi          |
                    |
          Assistant Executive          </option>
                <option value="237">
          FAC-035          |
          Al Mahmud          |
          Transformer Section          |
          Junior Assistant Engineer          </option>
                <option value="238">
          FAC-042          |
          Md. Ariful Islam (Shamim)          |
          Supply Chain Management (Inventory & Store )          |
          Junior Assistant Officer          </option>
                <option value="239">
          FAC-053          |
          Md. Raihan Hossain          |
          Switchgear Section          |
          Junior Assistant Engineer          </option>
                <option value="240">
          FAC-070          |
          Md. Rasel Hossain          |
          Transformer Section          |
          Junior Assistant Engineer          </option>
                <option value="241">
          FAC-081          |
          Md. Moklesur Rahman          |
          Transformer Section          |
          Junior Assistant Engineer          </option>
                <option value="242">
          FAC-103          |
          Md. Abdullah Al- Mamun          |
          Fabrication Section          |
          Junior Assistant Engineer          </option>
                <option value="243">
          FAC-124          |
          Md. Moniruzzaman          |
          Paint Section          |
          Junior Assistant Engineer          </option>
                <option value="244">
          FAC-073          |
          Md. Reajul Hasan          |
          Switchgear Section          |
          Junior Assistant Engineer          </option>
                <option value="245">
          FAC-164          |
          Md. Hasan Habib          |
          Switchgear Section          |
          Junior Assistant Engineer          </option>
                <option value="246">
          FAC-114          |
          Md. Kamruzzaman          |
          Logistic          |
          Junior Assistant Engineer          </option>
                <option value="247">
          FAC-001          |
          Md. Shafiqul Islam          |
          Fabrication Section          |
          Senior Foreman          </option>
                <option value="248">
          FAC-119          |
          Md. Mahabub Khan          |
          Radiator Section          |
          Assistant Foreman          </option>
                <option value="249">
          FAC-109          |
          Md. Mabud Sarkar          |
          Transformer Section          |
          Assistant Foreman          </option>
                <option value="250">
          FAC-072          |
          Eakub Ali          |
          Transformer Section          |
          Foreman          </option>
                <option value="251">
          FAC-002          |
          Md. Rashidul Islam          |
          Switchgear Section          |
          Foreman          </option>
                <option value="252">
          FAC-010          |
          Md Amirul Islam          |
          Paint Section          |
          Foreman          </option>
                <option value="253">
          FAC-065          |
          Md. Yasin Mia          |
          Transformer Section          |
          Foreman          </option>
                <option value="254">
          FAC-130          |
          Md. Mokaddesh Ali (Monir)          |
          In Charge Machine Shop          |
          In Charge Machine Shop          </option>
                <option value="255">
          FAC-017          |
          Md. Panir          |
          Fabrication Section          |
          Senior Technician          </option>
                <option value="256">
          FAC-051          |
          Md. Rabet Hossain Sheikh          |
          Paint Section          |
          Senior Technician          </option>
                <option value="257">
          FAC-075          |
          Md. Shahabuddin          |
          Fabrication Section          |
          Senior Technician          </option>
                <option value="258">
          FAC-123          |
          Md. Mahedi Hasan          |
          Radiator Section          |
          Senior Technician          </option>
                <option value="259">
          FAC-021          |
          Md. Abdur Rahim          |
          Switchgear Section          |
          Senior Technician          </option>
                <option value="260">
          FAC-016          |
          Md. Hashem Ali          |
          Fabrication Section          |
          Technician          </option>
                <option value="261">
          FAC-019          |
          Saddam Hossain          |
          Fabrication Section          |
          Technician          </option>
                <option value="262">
          FAC-023          |
          Md. Asadul          |
          Fabrication Section          |
          Technician          </option>
                <option value="263">
          FAC-061          |
          Md. Saddam Hossain          |
          Transformer Section          |
          Technician          </option>
                <option value="264">
          FAC-064          |
          Md. Nayem Shikder          |
          Gas Cutting          |
          Technician          </option>
                <option value="265">
          FAC-066          |
          Md. Titu          |
          Transformer Section          |
          Technician          </option>
                <option value="266">
          FAC-067          |
          Md. Rubel Mia          |
          Fabrication Section          |
          Technician          </option>
                <option value="267">
          FAC-068          |
          Md. Amirul Islam          |
          Lathe Section          |
          Technician          </option>
                <option value="268">
          FAC-069          |
          Md. Shamim Khan          |
          Lathe Section          |
          Technician          </option>
                <option value="269">
          FAC-085          |
           Md. Din Islam          |
          Fabrication Section          |
          Technician          </option>
                <option value="270">
          FAC-087          |
          Md. Sumon Miah          |
          Fabrication Section          |
          Technician          </option>
                <option value="271">
          FAC-088          |
          Md. Rasel Islam          |
          Transformer Section          |
          Technician          </option>
                <option value="272">
          FAC-095          |
          Md. Sahajalal          |
          Fabrication Section          |
          Technician          </option>
                <option value="273">
          FAC-098          |
          Md. Ataur Rahman          |
          Transformer Section          |
          Technician          </option>
                <option value="274">
          FAC-101          |
          Md. Shuhag Miah          |
          Switchgear Section          |
          Technician          </option>
                <option value="275">
          FAC-105          |
          Md. Safiqul Islam          |
          Switchgear Section          |
          Technician          </option>
                <option value="276">
          FAC-106          |
          Yasin Mia          |
          Fabrication Section          |
          Technician          </option>
                <option value="277">
          FAC-146          |
          Sree Amolo Toropdar          |
          Fabrication Section          |
          Technician          </option>
                <option value="278">
          FAC-147          |
          Nur Alam Fakir          |
          Fabrication Section          |
          Technician          </option>
                <option value="279">
          FAC-151          |
          Md. Masud          |
          Fabrication Section          |
          Technician          </option>
                <option value="280">
          FAC-152          |
          Saiful Islam          |
          Fabrication Section          |
          Technician          </option>
                <option value="281">
          FAC-155          |
          Md. Ashraful Alam          |
          Transformer Section          |
          Technician          </option>
                <option value="282">
          FAC-156          |
          Md. Alam Mia          |
          Fabrication Section          |
          Technician          </option>
                <option value="283">
          FAC-165          |
          Md. Azharul Islam          |
          Transformer Section          |
          Technician          </option>
                <option value="284">
          FAC-126          |
          Nur Mohammad          |
          Radiator Section          |
          Technician          </option>
                <option value="285">
          FAC-170          |
          Md. Parvez Bapari          |
          Radiator Section          |
          Technician          </option>
                <option value="286">
          FAC-180          |
          Md. Julhash Hossain          |
          Transformer Section          |
          Technician          </option>
                <option value="287">
          FAC-181          |
          Elias          |
          Paint Section          |
          Technician          </option>
                <option value="288">
          FAC-182          |
          Md. Rabiul Hassen          |
          Transformer Section          |
          Technician          </option>
                <option value="289">
          FAC-184          |
          Md. Mehedi Hasan          |
          Transformer Section          |
          Technician          </option>
                <option value="290">
          FAC-186          |
          Md. Shohan Sheikh          |
          Transformer Section          |
          Technician          </option>
                <option value="291">
          FAC-187          |
          Abu Hanif          |
          Transformer Section          |
          Technician          </option>
                <option value="292">
          FAC-046          |
          Md. Din Islam          |
          Transformer Section          |
          Helper          </option>
                <option value="293">
          FAC-077          |
          Md. Zahidul Islam          |
          Transformer Section          |
          Helper          </option>
                <option value="294">
          FAC-089          |
          Abhigit Mandol          |
          Paint Section          |
          Helper          </option>
                <option value="295">
          FAC-092          |
          Md. Abu Taleb          |
          Transformer Section          |
          Helper          </option>
                <option value="296">
          FAC-093          |
          Md. Shohel Rana          |
          Switchgear Section          |
          Helper          </option>
                <option value="297">
          FAC-094          |
          Md. Ikbal Hossen          |
          Fabrication Section          |
          Helper          </option>
                <option value="298">
          FAC-097          |
          Md. Sirazul Islam          |
          Switchgear Section          |
          Helper          </option>
                <option value="299">
          FAC-111          |
          Md. Nur Mohammad          |
          Switchgear Section          |
          Helper          </option>
                <option value="300">
          FAC-116          |
          Md. Biplob Hossen          |
          Admin (Factory)          |
          Helper          </option>
                <option value="301">
          FAC-117          |
          Md. Habibur Rahman          |
          Transformer Section          |
          Helper          </option>
                <option value="302">
          FAC-122          |
          Md. Solaiman Shah          |
          Fabrication Section          |
          Helper          </option>
                <option value="303">
          FAC-125          |
          Md. Mohon Miya          |
          Paint Section          |
          Helper          </option>
                <option value="304">
          FAC-127          |
          Md. Anowar Hossain          |
          Switchgear Section          |
          Helper          </option>
                <option value="305">
          FAC-128          |
          Md. Ridoy Hossain          |
          Fabrication Section          |
          Helper          </option>
                <option value="306">
          FAC-129          |
          Md. Shohel Molla          |
          Switchgear Section          |
          Helper          </option>
                <option value="307">
          FAC-131          |
          Md. Ekram Hossain          |
          Switchgear Section          |
          Helper          </option>
                <option value="308">
          FAC-132          |
          Md. Abu Hashem          |
          Switchgear Section          |
          Helper          </option>
                <option value="309">
          FAC-133          |
          Md. Shamim Reza          |
          Switchgear Section          |
          Helper          </option>
                <option value="310">
          FAC-134          |
          Md. Kalam          |
          Structure          |
          Helper          </option>
                <option value="311">
          FAC-136          |
          Md. Alamin          |
          Structure          |
          Helper          </option>
                <option value="312">
          FAC-137          |
          Md. Rafiq Ahmed          |
          Radiator Section          |
          Helper          </option>
                <option value="313">
          FAC-141          |
          Md. Ariful Islam          |
          Transformer Section          |
          Helper          </option>
                <option value="314">
          FAC-142          |
          Md. Mobarak Hossain          |
          Fabrication Section          |
          Helper          </option>
                <option value="315">
          FAC-144          |
          Md. Mikayel Hossain          |
          Gas Cutting          |
          Helper          </option>
                <option value="316">
          FAC-145          |
          Md. Shohag Ali Sorker          |
          Transformer Section          |
          Helper          </option>
                <option value="317">
          FAC-150          |
          Omor Faruk          |
          Structure          |
          Helper          </option>
                <option value="318">
          FAC-154          |
          Md. Sabbir Hossain          |
          Switchgear Section          |
          Helper          </option>
                <option value="319">
          FAC-159          |
          Md. Kawsar Ali          |
          Transformer Section          |
          Helper          </option>
                <option value="320">
          FAC-166          |
          Md. Jewel Bepary          |
          Switchgear Section          |
          Helper          </option>
                <option value="321">
          FAC-168          |
          Md. Abdullah Al Mamun          |
          Switchgear Section          |
          Helper          </option>
                <option value="322">
          FAC-169          |
          Sujit Ray          |
          Switchgear Section          |
          Helper          </option>
                <option value="323">
          FAC-171          |
          Md. Raihan Ahmed          |
          Fabrication Section          |
          Helper          </option>
                <option value="324">
          FAC-174          |
          Md. Sumon Hossain          |
          Transformer Section          |
          Helper          </option>
                <option value="325">
          FAC-176          |
          Md. Abdul Kadir          |
          Fabrication Section          |
          Helper          </option>
                <option value="326">
          FAC-177          |
          Ashraful          |
          Paint Section          |
          Helper          </option>
                <option value="327">
          FAC-178          |
          Md. Kawsar Ahmed          |
          Transformer Section          |
          Helper          </option>
                <option value="328">
          FAC-183          |
          Md. Asaduzzaman Sikhdar          |
          Transformer Section          |
          Helper          </option>
                <option value="329">
          FAC-188          |
          Sajib Howlader          |
          Transformer Section          |
          Helper          </option>
                <option value="330">
          FAC-162          |
           Md. Zobaer Ahamed          |
          Admin (Factory)          |
          Driver          </option>
                <option value="331">
          FAC-120          |
          Md. Monsur Ahmed          |
          Admin (Factory)          |
          Cook (Head)          </option>
                <option value="332">
          FAC-013          |
          Md. Ripon          |
          HR & Admin          |
          Cook          </option>
                <option value="333">
          FAC-121          |
          Md. Kalam          |
          Admin (Factory)          |
          Cook          </option>
                <option value="334">
          FAC-062          |
          Md. Shafyet Ullah          |
          Admin (Factory)          |
          Office Assistant          </option>
                <option value="335">
          FAC-172          |
          Md. Sumon Hossain          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="336">
          FAC-060          |
          Md. Jahangir Mia          |
          Admin (Factory)          |
          Cleaner          </option>
                <option value="337">
          FAC-037          |
          Mintu Khan          |
          Admin (Factory)          |
          Security Guard          </option>
                <option value="338">
          MNG-001          |
          Md. Zahid Hossain          |
                    |
          Chairman          </option>
                <option value="339">
          HO-032          |
          Farzana Akter          |
          Accounts & Finance          |
          Senior Manager          </option>
                <option value="340">
          HO-042          |
          Md. Shokat Osman          |
          Accounts & Finance          |
          Assistant Manager          </option>
                <option value="341">
          HO-074          |
          Md. Sadakur Rahaman          |
          Accounts & Finance          |
          Assistant Manager          </option>
                <option value="342">
          HO-073          |
          Md. Sumon Hossain          |
          Accounts & Finance          |
          Senior Executive          </option>
                <option value="343">
          HO-284          |
          Md. Nazrul islam          |
          Accounts & Finance          |
          Senior Executive          </option>
                <option value="344">
          HO-349          |
          Sohani Habib          |
          Accounts & Finance          |
          Senior Executive          </option>
                <option value="345">
          HO-317          |
          Shah Mahfuz Ahmed          |
          Accounts & Finance          |
          Executive          </option>
                <option value="346">
          HO-212          |
          Md. Shariful Islam          |
          Accounts & Finance          |
          Junior Executive          </option>
                <option value="347">
          HO-427          |
          Masum Billal Sarker          |
          Accounts & Finance          |
          Assistant Executive          </option>
                <option value="348">
          HO-428          |
          Md. Golam Rabbani          |
          Accounts & Finance          |
          Assistant Executive          </option>
                <option value="349">
          HO-009          |
          A.A. Rahamanul Karim Mondol          |
          Supply Chain Management            |
          Manager          </option>
                <option value="350">
          HO-112          |
          Md. Humayun Kabir          |
          Supply Chain Management            |
          Assistant Manager          </option>
                <option value="351">
          HO-078          |
          Mst. Arifa Nasrin           |
          Supply Chain Management            |
          Assistant Engineer          </option>
                <option value="352">
          HO-289          |
          Rinku Barman          |
          Supply Chain Management            |
          Junior Assistant Engineer          </option>
                <option value="353">
          HO-416          |
          Gopal Chandra Barmon          |
          Supply Chain Management            |
          Junior Executive          </option>
                <option value="354">
          HO-406          |
          Md. Kamrul Hasan          |
          HR & Admin          |
          Assistant General Manager          </option>
                <option value="355">
          HO-055          |
          Arif Hossain Khan          |
          Audit-Cost Control & Compliance           |
          Manager          </option>
                <option value="356">
          HO-077          |
          Nadia Reza          |
          HR & Admin          |
          Senior Executive          </option>
                <option value="357">
          HO-423          |
          Sharmin Akther Lina          |
          HR & Admin          |
          Senior Executive          </option>
                <option value="358">
          HO-424          |
          Obaydur Rahman          |
          HR & Admin          |
          Senior Executive          </option>
                <option value="359">
          HO-219          |
          Zahidul Islam Ayon          |
          Audit-Cost Control & Compliance           |
          Junior Assistant Engineer          </option>
                <option value="360">
          HO-346          |
          Nafis Al Reza          |
          HR & Admin          |
          Junior Executive          </option>
                <option value="361">
          TR-003          |
          Nargis Akter          |
          HR & Admin          |
          Trainee executive          </option>
                <option value="362">
          HO-094          |
          Md. Rofiq          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="363">
          HO-231          |
          Md. Rasel Rana Rony          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="364">
          HO-279          |
          Md. Afzal          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="365">
          HO-379          |
          Abdul Kader          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="366">
          HO-403          |
          Md. Foysal          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="367">
          HO-404          |
          Md. Noman          |
          HR & Admin          |
          Office Assistant          </option>
                <option value="368">
          HO-027          |
          Nurul Islam          |
          HR & Admin          |
          Cook          </option>
                <option value="369">
          HO-402          |
          Md. Rostom Mia          |
          HR & Admin          |
          Cook          </option>
                <option value="370">
          HO-405          |
          Md. Faruk Hossain          |
          HR & Admin          |
          Caretaker          </option>
                <option value="371">
          HO-410          |
          Md. Nazmul          |
          HR & Admin          |
          Cleaner          </option>
                <option value="373">
          HO-121          |
          Syed Tarique Nomani          |
          Engineering & Design           |
          Manager          </option>
                <option value="374">
          HO-238          |
          Md. Omor Faruk Monsi Parvaz          |
          Engineering & Design           |
          Senior Engineer          </option>
                <option value="375">
          HO-246          |
          Md. Ariful Islam          |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="376">
          HO-278          |
          Mithun Kumar Paul          |
          Engineering & Design           |
          Assistant Engineer          </option>
                <option value="377">
          HO-142          |
          Md. Fardin Ahmed Patowary          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="378">
          HO-275          |
          Md. Gannatul Ferdush          |
          Project Management Office (Alpha)           |
          Junior Assistant Engineer          </option>
                <option value="381">
          HO-076          |
          Mohammad Shahinur Rahman          |
                    |
          Deputy Manager          </option>
                <option value="382">
          HO-336          |
          Adnan Saquib Chowdhury          |
                    |
          Senior Executive          </option>
                <option value="383">
          HO-123          |
          Shahjalal Hossain          |
                    |
          Assistant Engineer          </option>
                <option value="384">
          HO-214          |
          Farzana Akther          |
                    |
          Assistant Engineer          </option>
                <option value="385">
          HO-226          |
          Sajeda Akter Mony          |
                    |
          Assistant Engineer          </option>
                <option value="386">
          HO-253          |
          Sharmin Jahan          |
          Engineering Documentation & Development           |
          Assistant Engineer          </option>
                <option value="387">
          HO-324          |
          A B M Shakeruzzaman          |
                    |
          Assistant Engineer          </option>
                <option value="388">
          HO-341          |
          Md. Khalid Hasan           |
                    |
          Assistant Engineer          </option>
                <option value="389">
          HO-343          |
          Amina Khatun          |
                    |
          Assistant Engineer          </option>
                <option value="390">
          HO-344          |
          Fatima Mostafa          |
                    |
          Assistant Engineer          </option>
                <option value="391">
          HO-354          |
          Faisal Adil Quadery          |
                    |
          Assistant Engineer          </option>
                <option value="392">
          HO-144          |
          H. M. Istiaque Mahmood          |
                    |
                    </option>
                <option value="393">
          TR-001          |
          Syed Ehtefazz Ur Rahman          |
                    |
                    </option>
                <option value="394">
          HO-180          |
          Ratan Biswas          |
                    |
                    </option>
                <option value="395">
          HO-245          |
          Sohag Molla          |
                    |
                    </option>
                <option value="396">
          HO-268          |
          Rubayet Ahmed          |
                    |
                    </option>
                <option value="397">
          HO-292          |
          Zihadul Islam          |
                    |
                    </option>
                <option value="398">
          HO-294          |
          Jahirul Islam          |
                    |
                    </option>
                <option value="399">
          HO-296          |
          Motin Tripura          |
                    |
                    </option>
                <option value="400">
          HO-297          |
          Sabbir Rahman Shishir          |
                    |
                    </option>
                <option value="401">
          HO-298          |
          Md. Ainun Nishat Tanvir          |
                    |
                    </option>
                <option value="402">
          HO-355          |
          Rabiul Islam          |
                    |
                    </option>
                <option value="403">
          HO-301          |
          Md. Mehedi Hasan          |
                    |
          Driver          </option>
                <option value="404">
          HO-197          |
          Md. Nazrul Islam          |
                    |
          Assistant Engineer          </option>
                <option value="405">
          HO-307          |
          Asif Hosain Khan          |
                    |
          Deputy Manager          </option>
                <option value="406">
          TR-002          |
          Md. Ahnaf Uz Zaman          |
                    |
          Trainee executive          </option>
                <option value="407">
          HO-001          |
          Md. Rezwan Arafat          |
                    |
          Senior Executive          </option>
                <option value="408">
          HO-036          |
          Mahedi Sufian Sagor          |
                    |
          Assistant Engineer          </option>
                <option value="409">
          HO-225          |
          Md. Omar Sharif (Shawon)          |
                    |
          Assistant Engineer          </option>
                <option value="410">
          HO-276          |
          Harun-Or-Rashid          |
                    |
          Assistant Engineer          </option>
                <option value="411">
          HO-391          |
          Zahid Hossain          |
                    |
          Junior Assistant Engineer          </option>
                <option value="412">
          HO-239          |
          Md. Milon Hossain          |
                    |
          Assistant Engineer          </option>
                <option value="413">
          HO-285          |
          Tanmoy Das          |
                    |
          Assistant Engineer          </option>
                <option value="414">
          HO-211          |
          Zakaria Mostofa          |
                    |
                    </option>
                <option value="415">
          Ho-138          |
          Md. Rumon Mia          |
                    |
                    </option>
                <option value="416">
          HO-247          |
          Md. Shahidul Islam          |
                    |
                    </option>
                <option value="417">
          HO-372          |
          Md. Layes (Raju)          |
                    |
                    </option>
                <option value="418">
          HO-210          |
          Md. Sohel Rana Chowdury          |
                    |
          Technician          </option>
                <option value="419">
          HO-234          |
          Md. Akther Hussan ( 20 March)          |
                    |
          Technician          </option>
                <option value="420">
          HO-243          |
          Md. Roushon Alahi          |
                    |
          Technician          </option>
                <option value="421">
          HO-250          |
          Md. Aslam Parvej          |
                    |
          Technician          </option>
                <option value="422">
          HO-280          |
          Md. Raju thakur          |
                    |
          Technician          </option>
                <option value="423">
          HO-371          |
          Oyashim Akram          |
                    |
          Technician          </option>
                <option value="424">
          HO-363          |
          Rowsan Ali          |
                    |
          Technician          </option>
                <option value="425">
          HO-370          |
          Md. Shahin          |
                    |
          Technician          </option>
                <option value="426">
          HO-184          |
          Md. Masum          |
                    |
          Helper          </option>
                <option value="427">
          HO-233          |
          Juwel Sheikh          |
                    |
          Helper          </option>
                <option value="428">
          HO-273          |
          Md. Milon Mia          |
                    |
          Helper          </option>
                <option value="429">
          HO-283          |
          Md. Shohedul Islam          |
                    |
          Helper          </option>
                <option value="430">
          HO-319          |
          Md. Naime Sheikh          |
                    |
          Helper          </option>
                <option value="431">
          HO-329          |
          Ali Ahmed          |
                    |
          Helper          </option>
                <option value="432">
          HO-330          |
          Limon Miah          |
                    |
          Helper          </option>
                <option value="433">
          HO-351          |
          Md. Rakib Hossain          |
                    |
          Helper          </option>
                <option value="434">
          HO-374          |
          Md. Nasim Shikder          |
                    |
          Helper          </option>
                <option value="435">
          HO-373          |
          Md. Shariful Islam          |
                    |
          Helper          </option>
                <option value="436">
          HO-232          |
          Md. Shohag Shekder          |
                    |
          Driver          </option>
                <option value="437">
          HO-183          |
          Md. Julhash          |
                    |
          Driver          </option>
                <option value="438">
          HO-125          |
          Khondker Rahat Hasan          |
                    |
          Deputy Manager          </option>
                <option value="439">
          HO-158          |
          Md. Athikur Rahman          |
                    |
          Assistant Engineer          </option>
                <option value="440">
          HO-220          |
          Md. Abu Khaled Sojib          |
                    |
          Junior Executive          </option>
                <option value="441">
          HO-155          |
          Md. Mozahedul Islam          |
                    |
          Junior Executive          </option>
                <option value="442">
          HO-083          |
          Md. Azizul Haque          |
          Project Management Office (Alpha)           |
          Junior Executive          </option>
                <option value="443">
          HO-170          |
          Abul Khaer Mia          |
                    |
          Office Assistant          </option>
                <option value="444">
          HO-311          |
          Md. Bellal Molla          |
                    |
          Office Assistant          </option>
                <option value="445">
          HO-229          |
          Md. Saidul          |
                    |
          Cook          </option>
                <option value="446">
          HO-          |
          Emon          |
                    |
          Office Assistant          </option>
                <option value="448">
          FAC-158          |
          Abdullah Al Numan          |
                    |
          Assistant Engineer          </option>
                <option value="449">
          FAC-149          |
          H.M. Alomgir Kobir          |
                    |
          Junior Assistant Engineer          </option>
                <option value="450">
          FAC-157          |
          Md. Ronju Mia          |
                    |
          Junior Assistant Engineer          </option>
                <option value="451">
          FAC-078          |
          Shamol Sorker          |
                    |
                    </option>
                <option value="452">
          FAC-135          |
          Md. Abdullah          |
                    |
          Technician          </option>
                <option value="453">
          FAC-112          |
          Md. Mizanur Rahman          |
                    |
          Helper          </option>
                <option value="454">
          FAC-138          |
          Md. Helal Uddin          |
                    |
          Helper          </option>
                <option value="455">
          FAC-139          |
          Md. Al-Amin Hossain          |
                    |
          Helper          </option>
                <option value="456">
          FAC-140          |
          Md. Fajlun Karim          |
                    |
          Helper          </option>
                <option value="457">
          FAC-143          |
          Md. Humayon          |
                    |
          Helper          </option>
                <option value="458">
          FAC-148          |
          Abdul Noyon          |
                    |
          Helper          </option>
                <option value="459">
          FAC-163          |
          Md. Shaminur Islam          |
                    |
          Junior Executive          </option>
                <option value="460">
          FAC-050          |
          Milon Mahmud          |
                    |
          Technician          </option>
                <option value="461">
          FAC-100          |
          Md. Abdullah Al-Amin          |
                    |
          Technician          </option>
                <option value="462">
          FAC-090          |
          Jagodish Biswas          |
                    |
          Helper          </option>
                <option value="463">
          FAC-185          |
          Subinoy Chicham          |
                    |
          Helper          </option>
                <option value="464">
          FAC-153          |
          Md. Sajib Hossain          |
                    |
          Helper          </option>
                <option value="465">
          FAC-043          |
          Md. Shojib Ali          |
                    |
          Helper          </option>
                <option value="466">
          FAC-160          |
          Md. Mostafa Kamal          |
                    |
          Helper          </option>
                <option value="467">
          FAC-161          |
          Md. Yesa Hossin          |
                    |
          Helper          </option>
                <option value="468">
          FAC-167          |
          Mijanur Rahman          |
                    |
          Helper          </option>
                <option value="469">
          FAC-173          |
          Md. Ruhul Amin          |
                    |
          Helper          </option>
                <option value="470">
          FAC-175          |
          Md. Mokhtar Hossain          |
                    |
          Helper          </option>
                <option value="471">
          FAC-179          |
          Md. Al-Amin          |
                    |
          Helper          </option>
                <option value="474">
          MNG-007          |
          Mustazeb Hossain          |
                    |
          Director          </option>
                <option value="475">
          HO-426          |
          Mahin Akter          |
          Engineering & Design           |
          Assistant Engineer          </option>
                <option value="476">
                    |
          Master Account          |
                    |
                    </option>
                <option value="477">
          HO-433          |
          Soumitro Sarkar          |
          Sales & Marketing           |
          Assistant Engineer          </option>
                <option value="480">
          HO-434          |
          Syed Taha Saleh          |
          Sales & Marketing           |
          Assistant Engineer          </option>
                <option value="482">
          HO-435          |
          Syed Fathe Uddin Ahmmed Anik          |
          Sales & Marketing           |
          Assistant Engineer          </option>
                <option value="483">
          HO-436          |
          Md. Nehal Hossain          |
                    |
          Assistant Engineer          </option>
                <option value="485">
          HO-442          |
          Md. Arifull Islam          |
          HR & Admin          |
          Driver          </option>
                <option value="486">
          HO-443          |
          Md. Rana Mia          |
          HR & Admin          |
          Driver          </option>
                <option value="487">
          HO-438          |
          Md. Ariful Islam          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="489">
          HO-445          |
          Al Amin Molla          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="491">
          HO-437          |
          Doyal Roy          |
          Project Management Office (Beta)          |
          Helper          </option>
                <option value="492">
          Ho-432          |
          Mohammad Emdadul Hoque          |
          Supply Chain Management            |
          Deputy Manager          </option>
                <option value="493">
          HO-439          |
          Eshtiak Ahmed          |
          Sales & Marketing           |
          Assistant Engineer          </option>
                <option value="494">
          HO-440          |
          Md. Ejas Miah          |
          Project Management Office (Beta)          |
          Senior Technician          </option>
                <option value="504">
          HO-041          |
          Sajid Rakih Ahmed          |
          Sales & Marketing           |
          Deputy Manager          </option>
                <option value="505">
          HO-441          |
          Md. Abdur Razzak          |
          Sales & Marketing           |
          Senior Engineer          </option>
                <option value="506">
          FAC-189          |
          Mahabubul Islam          |
          Supply Chain Management            |
          Junior Executive          </option>
                <option value="507">
          FAC-190          |
          Maynul Hasan Zihad          |
          Supply Chain Management            |
          Junior Executive          </option>
                <option value="509">
          MNG-010          |
          Md. Asaduzzaman (CEO)          |
                    |
          CEO          </option>
                <option value="510">
          HO-446          |
          Md. Akhirul Islam          |
          Project Management Office (Beta)          |
          Assistant Engineer          </option>
                <option value="511">
          HO-999          |
          ERP TEST USER          |
                    |
          Executive          </option>
                <option value="512">
          HO-449          |
          Muhammad Rizvi Hossain           |
          Project Management Office (Alpha)           |
          Assistant Engineer          </option>
                <option value="513">
          TR-006          |
          Md. Shariful Islam          |
          HR & Admin          |
          Trainee executive          </option>
                <option value="514">
          TR-007          |
          Nazrul Islam          |
          HR & Admin          |
          Trainee executive          </option>
                <option value="515">
          HO-469          |
          Abid-Ur-Rahman          |
          Sales & Marketing           |
          Junior Assistant Engineer          </option>
                <option value="516">
          HO-470          |
          Md. Abdur Rashid          |
          Project Management Office (Gamma)          |
          Junior Assistant Engineer          </option>
                <option value="517">
          HO-471          |
          Md. Shangidur Rahman          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="518">
          HO-472          |
          Mizanur          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="519">
          HO-473          |
          Md. Bokul Miah          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="520">
          HO-447          |
          Md. Noor-A-Alam          |
          Project Management Office (Beta)          |
          Senior Engineer          </option>
                <option value="521">
          HO-461          |
          Md. Manik Mia          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="522">
          HO-462          |
          Alif Hossen          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="523">
          HO-463          |
          Md. Liton Munshi          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="524">
          HO-464          |
          Md. Jahidul Munshi          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="525">
          HO-466          |
          Maruf Hossain          |
          Project Management Office (Beta)          |
          Technician          </option>
                <option value="526">
          HO-448          |
          Foridul Islam          |
          Project Management Office (Beta)          |
          Helper          </option>
                <option value="527">
          HO-465          |
          Abdullah Al Mamun          |
          Project Management Office (Beta)          |
          Helper          </option>
                <option value="528">
          HO-451          |
          Mayeenul Islam          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="529">
          HO-452          |
          Md. Sohal Ahmed          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="530">
          HO-453          |
          Md. Sadikur Rahman          |
          Project Management Office (Beta)          |
          Junior Assistant Engineer          </option>
                <option value="531">
          HO-454          |
          Mohammad Minhajol Islam          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="532">
          HO-455          |
          Md. Rakibul Hasan          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="533">
          HO-456          |
          Md. Towhid Hasan Rasel          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="534">
          HO-457          |
          Abdullah Al Mamun          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="535">
          HO-458          |
          Md. Omar Faruk          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="536">
          HO-459          |
          Forhad Hossain          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="537">
          HO-460          |
          Nazmul Hussain          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                <option value="538">
          HO-467          |
          Md. Ibrahim Hossain          |
          Engineering & Design           |
          Junior Assistant Officer          </option>
                <option value="539">
          HO-468          |
          Md. Farukul Islam          |
          Engineering & Design           |
          Junior Assistant Engineer          </option>
                      </select>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<table id="data_table_inner" class="table table-bordered" cellspacing="0">
							  <thead><tr>
								<th>IDs</th>
								<th>Sub Class</th>
								<th>Type</th>
								<th>Class</th>
							  </tr></thead><tbody>
<?php
	$rrr = "SELECT a.id, a.sub_class_name, b.sub_class_type, c.class_name FROM `acc_sub_class` a,acc_sub_class_type b,acc_class c WHERE c.id=b.class_id and b.id=a.sub_class_type_id ";
	$report = db_query($rrr);
	$i=0;
	
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
								<td><?=$rp[3];?></td>
							  </tr>
	<?php }?></tbody>
							</table>
																		</td>
								  </tr>
								</table>

	</div></td>
    <td valign="top"><div class="center"><form id="form2" name="form2" method="post" action="?sub_class_id=<?php echo $sub_class_id;?>">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Sub Class  Name :</td>
                                        <td><input name="sub_class_name" type="text" id="sub_class_name" value="<?php echo $data[1];?>" class="required" /></td>
									  </tr>
                                      <tr>
                                        <td>Sub Class Type:</td>
                                        <td>
                                        <select name="sub_class_type_id" id="sub_class_type_id">
                                        <option></option>
                                        <?	$sql="select * from acc_sub_class_type order by class_id,priority";
											$query=db_query($sql);
											while($datas=mysqli_fetch_object($query)){
										?>
 <option <? if($datas->id==$data[2]) echo 'selected';?> value="<?=$datas->id?>"><?=$datas->sub_class_type?></option>
                                        <? } ?>
                                        </select></td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="ngroup" type="submit" id="ngroup" value="Record" onclick="return checkUserName()" class="btn" /></td>
                                      <td><input name="mgroup" type="submit" id="mgroup" value="Modify" class="btn" /></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='ledger_group.php'"/></td>
                                      <td><? if($_SESSION['user']['level']==5){?><input class="btn" name="dgroup" type="submit" id="dgroup" value="Delete"/><? }?></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>