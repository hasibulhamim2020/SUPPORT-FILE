<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Financial Accounting Dashboard";

require_once SERVER_CORE."routing/inc.notify.php";



 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

 

$header_add .='  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <script src="https://maps.googleapis.com/maps/api/js"></script>

  ';

  $cur = '&#x9f3;';

?>







<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>





<?php 







$payment=find_a_field('journal','sum(dr_amt-cr_amt)','1 and  tr_from ="payment" and jv_date between "2019-01-01" AND "2020-12-31" ');



$IncomeOverall =find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086000100010000"');

$BillsOverall  =find_a_field('journal','sum(cr_amt)','1 ');









?>
<style>
	.card{
		margin-top: 10px;
		margin-bottom: 10px;
	}
	
	#myBarCharts{
		height: 100% !important;
	}
.top-block-card-without-back{ 
		text-align: center;
		padding: 0px;  
		padding-left: 0px; 
		padding-right: 0px;
	padding-top: 3px;
	background-color: white;
	}
	.top-block-card{
		background-image: url('https://clouderp.com.bd/CloudERP/acc_mod/pages/images/1.jpg'); 
		background-size: 100% 100%; 
		text-align: center;
		padding: 17px;  
		background-repeat: no-repeat; 
		padding-left: 0px; 
		padding-right: 0px;
		color: white;
	}
	
	.padding-5px{
	padding: 5px;
	}
	.padding-bottom-none{
	padding-bottom: 0px;	
	}
	#myLineCharts{
		background: white !important;
	}
	
	#myBarCharts2{
		background: white !important;
	}
</style>


<div class="content" style="background: #F6F6F7">
	
	
	
	

        <div class="container-fluid">
			
			
			
			<div class="row">
				
				
				
				<div class="col-md-7">
				
					<div class="row">
					
						<div class="col-md-3 padding-5px" >
							
							<div class="top-block-card"> 
				
				<p style="margin-bottom: 0px; font-size: 14px; font-weight: bold;">Receivable</p>
				<h1 style="font-size: 20px;font-weight: bold;margin-top: 0px;">$6,621,280</h1>
				</div>
				
				</div>
				<div class="col-md-3 padding-5px">
					
							<div class="top-block-card"> 
				
				<p style="margin-bottom: 0px; font-size: 14px; font-weight: bold;">Payable</p>
					
				<h1 style="font-size: 20px;font-weight: bold;margin-top: 0px;">$ 1,630,270</h1>
					</div>
				
				</div>
				<div class="col-md-3 padding-5px">
				
							<div class="top-block-card"> 
				<p style="margin-bottom: 0px; font-size: 14px; font-weight: bold;">Equity Ratio</p>
				<h1 style="font-size: 20px;font-weight: bold;margin-top: 0px;">75.38 %</h1>
				
					</div>
				</div>
				<div class="col-md-3 padding-5px">
				
							<div class="top-block-card"> 
				<p style="margin-bottom: 0px; font-size: 14px; font-weight: bold;">Debt Equity</p>
				<h1 style="font-size: 20px;font-weight: bold;margin-top: 0px;">1.10 %</h1>
				
					</div>
				</div>
						
						
						
					</div>
				<div class="row">
					
					<div class="col-md-3  padding-5px padding-bottom-none" >
					<div class="top-block-card-without-back"> 
	<canvas id="myPieCharts1"></canvas>
						</div>
					</div>
					<div class="col-md-3  padding-5px  padding-bottom-none" >
					<div class="top-block-card-without-back"> 
						
	<canvas id="myPieCharts2"></canvas>
					
					</div>
					</div>
					<div class="col-md-3  padding-5px  padding-bottom-none" >
					
					<div class="top-block-card-without-back"> 
	<canvas id="myPieCharts3"></canvas>
					</div>
					</div>
					<div class="col-md-3  padding-5px  padding-bottom-none" >
					<div class="top-block-card-without-back"> 
	<canvas id="myPieCharts4"></canvas>
					</div>
					
					</div>
					
					</div>
				
				
				
				</div>
				<div class="col-md-5  padding-5px"  style="box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%); border-radius: 6px; background: white;">
				
					<div class="" style="background: white; height: 100%">
				
	<canvas id="myBarCharts"></canvas>
	</div>
					</div>
				
				
				
			
			
			</div>
			
			
			<br>
			
			<div class="row">
			
			<div class="col-md-6">
	
	
	<canvas id="myLineCharts"></canvas>
	</div>
			<div class="col-md-6">
	
	<canvas id="myBarCharts2"></canvas>
	</div>
			
			</div>
			
			
			

          

		  

		  

		  

		  

		  

		  

          

		  

		  

		  

		   

		  

		  

          

        </div>

      </div>

















   

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script>
var ctx = document.getElementById('myLineCharts');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['REVENUE', 'EXPANSE', 'BANK', 'CASH', 'BANK', 'CASH', 'BANK'],
        datasets: [{
    label: 'My First Dataset',
    data: [-65, 59, 80, 81, 56, 55, 40],
    fill: false,
    borderColor: 'rgb(70, 83, 158)',
    tension: 0.1
  },{
    label: 'My First Dataset',
    data: [-23, 34, 23, 45, 56, 87, 23],
    fill: false,
    borderColor: 'rgb(240, 204, 25)',
    tension: 0.1
  },
				   {
    label: 'My First Dataset',
    data: [45, 23, 56, 12, 09, -67, 56],
    fill: false,
    borderColor: 'rgb(0, 176, 95)',
    tension: 0.1
  }
				  ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>
	
	
	
	<script>
var ctx = document.getElementById('myBarCharts');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2016', '2017', '2018', '2019', '2020', '2021'],
        datasets: [{
            label: '# of Votes',
            data: [100, 200, 300, 400, 500, 600],
            backgroundColor: 'rgb(73, 87, 163)',
        },{
            label: '# of Votes',
            data: [120, 170, 85, 97, 220, 500],
            backgroundColor: 'rgb(255, 43, 49)',
        }
				  
				  
				  
				  ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>
	<script>
var ctx = document.getElementById('myBarCharts2');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2016', '2017', '2018', '2019', '2020', '2021'],
        datasets: [{
            label: '# of Votes',
            data: [100, 200, 300, 400, 500, 600],
            backgroundColor: 'rgb(244, 187, 0)',
			stack: 'Stack 0'
        },{
            label: '# of Votes',
            data: [-120, 170, 85, -97, -220, 500],
            backgroundColor: 'rgb(71, 85, 160)',
			stack: 'Stack 0'
        },{
            label: '# of Votes',
            data: [620, 706, 856, -97, -220, 540],
            backgroundColor: 'rgb(0, 177, 93)',
			stack: 'Stack 0'
        },
				   {
            label: '# of Votes',
            data: [120, 170, 85, 97, 220, 500],
            backgroundColor: 'rgb(255, 43, 49)',
					   stack: 'Stack 1'
        }
				  
				  
				  
				  ]
    },
    options: {
		tooltips: {
			mode: 'index',
		},
		scales:{
			xAxes:[{
				stacked: true,
			}],
			yAxes:[{
				stacked: true,
			}]
		}
    }
});

</script>
	
	
	<script>
var ctx = document.getElementById('myRadarCharts');
var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['Cash', 'Cheque', 'Journal', 'Contra'],
        datasets: [{
            label: 'Transection',
            data: [7, 1, 15, 9],
            backgroundColor: [
                'rgba(255, 99, 132)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>
	
	
	<script>
		
	
		
var ctx = document.getElementById('myPieCharts1');
var myDoughnutChart  = new Chart(ctx, {
    type: 'doughnut',
	clip: {left: 5, top: false, right: -2, bottom: 0},
    data: {
        labels: ['Cash Book', 'Bank Book'],
        datasets: [{
            label: 'Balance',
            data: [90,10],
            backgroundColor: [
                'rgba(70, 85, 160, 0.999)',
                'rgba(200, 200, 200, 0.7)'
            ]
        }]
    },
    options: {
		
		
		
		legend: {
      position: 'bottom',
    },
    maintainAspectRatio: false,
    circumference: Math.PI + 2,
    rotation: -Math.PI - 1,
    cutoutPercentage: 54,

    onClick(...args) {
      console.log(args);
    }
  }
});

</script>


<script>
		
	
		
var ctx = document.getElementById('myPieCharts2');
var myDoughnutChart  = new Chart(ctx, {
    type: 'doughnut',
	clip: {left: 5, top: false, right: -2, bottom: 0},
    data: {
        labels: ['Cash Book', 'Bank Book'],
        datasets: [{
            label: 'Balance',
            data: [80,20],
            backgroundColor: [
                'rgba(245, 184, 0, 0.9)',
                'rgba(200, 200, 200, 0.7)'
            ]
        }]
    },
    options: {
		
		
		
		legend: {
      position: 'bottom',
    },
    maintainAspectRatio: false,
    circumference: Math.PI + 2,
    rotation: -Math.PI - 1,
    cutoutPercentage: 54,

    onClick(...args) {
      console.log(args);
    }
  }
});

</script>


<script>
		
	
		
var ctx = document.getElementById('myPieCharts3');
var myDoughnutChart  = new Chart(ctx, {
    type: 'doughnut',
	clip: {left: 5, top: false, right: -2, bottom: 0},
    data: {
        labels: ['Cash Book', 'Bank Book'],
        datasets: [{
            label: 'Balance',
            data: [85,15],
            backgroundColor: [
                'rgba(255, 40, 47, 0.9)',
                'rgba(200, 200, 200, 0.7)'
            ]
        }]
    },
    options: {
		
		
		
		legend: {
      position: 'bottom',
    },
    maintainAspectRatio: false,
    circumference: Math.PI + 2,
    rotation: -Math.PI - 1,
    cutoutPercentage: 54,

    onClick(...args) {
      console.log(args);
    }
  }
});

</script>

<script>
		
	
		
var ctx = document.getElementById('myPieCharts4');
var myDoughnutChart  = new Chart(ctx, {
    type: 'doughnut',
	clip: {left: 5, top: false, right: -2, bottom: 0},
    data: {
        labels: ['Cash Book', 'Bank Book'],
        datasets: [{
            label: 'Balance',
            data: [95,5],
            backgroundColor: [
                'rgba(0, 179, 91, 0.9)',
                'rgba(200, 200, 200, 0.7)'
            ]
        }]
    },
    options: {
		
		
		
		
		legend: {
      position: 'bottom',
    },
    maintainAspectRatio: false,
    circumference: Math.PI + 2,
    rotation: -Math.PI - 1,
    cutoutPercentage: 54,

    onClick(...args) {
      console.log(args);
    }
  }
});

</script>


	