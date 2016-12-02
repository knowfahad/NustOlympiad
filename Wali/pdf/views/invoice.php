<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>pdf</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		
		<link rel="stylesheet" type="text/css" href="../app/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/app/css/bootstrap.min.css">
		
		<link rel="stylesheet" href="bootstrap.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		
		
		<style>
			body{
				height: 1222px;
				overflow: visible;
			}
		 
	table {
    border-collapse: separate;
   width: 90%;
}
			table tr td{
				text-align: center;
				font-size: 12px;
				font-weight: 900;
				color: black;
				border:1px solid #808080;;
			}

	.emphasis{
		font-weight: 900;
		font-size: 20px;
	}
	.a{
		position: relative;
	}
	.col-md-4 {
     
    overflow: hidden;
}
	 
	
	/* You could use :after - it doesn't really matter */
.col-md-4:before {
    content: ' ';
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 80%;
    height: 80%;
    z-index: 1;
    opacity: 0.1;
    background-image: url('bg.png');
    background-repeat: no-repeat;
    background-position: 86% 0;
    -ms-background-size: cover;
    -o-background-size: cover;
    -moz-background-size: cover;
    -webkit-background-size: cover;
    background-size: cover;
}
	
	.logo{
		height: 50px;
		width: 50px;
		margin-left: -14px;
		padding: 0px;
		
	}
 
	#reg{
		padding:10px;
	}
	#reg h2{
		line-height: 10px;
	}
	table, td{
		font-size: 105%;
		font-weight: 900;
		
		padding:5px;
	}
	
	p{
		line-height: 10px;
	}
	h2{
		font-size: 110%;
		line-height: 18px;
		font-weight: 900;
	}
	.responsive{
		width:40%;
	}
	.row{
		margin-top: 0px;
		margin-top: -12px;
	}
	.narrow-row{
		margin-top: -20px;
		margin-bottom: -25px;
	}
	h4{
		font-size: 100%;
	}
	
	.fb {
		
		float: left;
		position: absolute;
		display: inline;
		width: 100px;
		height:50px;
		margin-left: 170px;
		
	}

	.logo {
		bottom: 0;
		display: inline;
		left: 0;
		
	}

	.top {
		height: 58px;
		
		margin: 0;
		
		position: relative;
	}
	.challan{
		padding-bottom: 20px;
	}
		</style>
	</head>
	<body><br>
		<div class="container">
			<div class="col-md-4 bg">
				<div class="top">
					<img class="logo" src="https://drive.google.com/file/d/0B30qEw3x6vBSSEl4Q25mNmVJYlU/view?usp=sharing" class="logo  img-responsive" height="50" width="50">
					<img class="fb"src="logo.png" class=" " >
				</div>
				<div class="row" style="padding-bottom:5px;">
					<b><h4>Challan ID: _______</h4></b>
				</div>
				<div class="row">
					<h2 style="margin:0px;">National University of Sciences & Technology
						(NUST), Sector H12, Islamabad.</h2>

				</div>
				<div class="row challan">
					<u><h2 class="text-center">Fee Challan(Bank Copy)</h2></u>
					</div>
				<div class="row">	
					<h2 style=" display:inline;  " >Bank A/C#: </h2>
					<p style="display:inline;">{{ PKHAB902044001
					}}</p>
					</div>
				<div class="row">
					<h2 >
						HBL H­12 Sector Islamabad
					</h2>
					<p>Payable on all online branches of
	Habib Bank Ltd</p>

				</div>
				<div class="row">
					<table style="margin-top:10px;" >
						<tr>
							<td class="responsive" style="width:20%;">Generation Date</td>
							<td class="responsive">#Apr 27, 2016</td>
						</tr>
						<tr>
							<td class="responsive" style="width:20%;">Due Date </td>
							<td class="responsive">#May 27, 2016</td>
						</tr>
					</table>
				</div>
				<div class="row narrow-row" id="reg">
					<h2 >Registration Type: </h2>
					<h2>Team Name: </h2>
					<h2>Team ID: </h2>
				</div>
				<div class="row">
					<h2>Event Participation Details:</h2>
					<table style="margin-top:10px; ">
						<tr  >
							<td class="responsive" style="width:30%;">Registration</td>
							<td class="responsive" style="width:50%;">Registration Fee</td>
							<td class="responsive" style=" text-algin:center; "> 800</td>
							 
						</tr>
						<tr style="height:20px;" >
							<td class="responsive" style="  width:30%;">Due Date </td>
							<td class="responsive" style="  width:50%;">Event Name</td>
							<td class="responsive" style=" ">Fee</td>
						</tr>
						<tr style="height:20px;" >
							<td class="responsive" style="width:30%;"> </td>
							<td class="responsive" style="width:50%;"><hidden></hidden></td>
							<td class="responsive" style="width:20%; height:25px;"></td>
						</tr>
					</table>
					<h2>&nbsp;______________________________<u>Total</u>&nbsp;_______</h2>	
					<h2>&nbsp;________________________<u>Grand Total</u>&nbsp;_______</h2>	
	
				</div>
				<div class="row">
					<h2>Official Bank Stamp</h2>
					<h2 style="display:inline;">Bank Note:</h2> 
					<span style="display:inline;">
						Please Punch Name, Challan ID and Total Amountin Transaction
					</span>
				</div>
				
			</div>
			
			<!-----participant copy---->
			<div class="col-md-4 bg">
				<div class="top">
					<img class="logo" src="nust.png" class="logo  img-responsive" height="50" width="50">
					<img class="fb"src="logo.png" class=" " >
				</div>
				<div class="row" style="padding-bottom:10px;">
					<b><h4>Challan ID: _______</h4></b>
				</div>
				<div class="row">
					<h2 style="margin:0px;">National University of Sciences & Technology
						(NUST), Sector H12, Islamabad.</h2>

				</div>
				<div class="row challan">
					<u><h2 class="text-center">Fee Challan(Participant Copy)</h2></u>
					</div>
				<div class="row">	
					<h2 style=" display:inline;  " >Bank A/C#: </h2>
					<p style="display:inline;">{{ PKHAB902044001
					}}</p>
					</div>
				<div class="row">
					<h2 >
						HBL H­12 Sector Islamabad
					</h2>
					<p>Payable on all online branches of
	Habib Bank Ltd</p>

				</div>
				<div class="row">
					<table style="margin-top:10px;" >
						<tr>
							<td class="responsive" style="width:20%;">Generation Date</td>
							<td class="responsive">#Apr 27, 2016</td>
						</tr>
						<tr>
							<td class="responsive" style="width:20%;">Due Date </td>
							<td class="responsive">#May 27, 2016</td>
						</tr>
					</table>
				</div>
				<div class="row narrow-row" id="reg">
					<h2>Registration Type: </h2>
					<h2>Team Name: </h2>
					<h2>Team ID: </h2>
				</div>
				<div class="row">
					<h2>Event Participation Details:</h2>
					<table style="margin-top:10px; ">
						<tr  >
							<td class="responsive" style="width:30%;">Registration</td>
							<td class="responsive" style="width:50%;">Registration Fee</td>
							<td class="responsive" style=" text-algin:center; "> 800</td>
							 
						</tr>
						<tr style="height:20px;" >
							<td class="responsive" style="  width:30%;">Due Date </td>
							<td class="responsive" style="  width:50%;">Event Name</td>
							<td class="responsive" style=" ">Fee</td>
						</tr>
						<tr style="height:20px;" >
							<td class="responsive" style="width:30%;"> </td>
							<td class="responsive" style="width:50%;"><hidden></hidden></td>
							<td class="responsive" style="width:20%; height:25px;"></td>
						</tr>
					</table>
					<h2>&nbsp;______________________________<u>Total</u>&nbsp;_______</h2>	
					<h2>&nbsp;________________________<u>Grand Total</u>&nbsp;_______</h2>	
	
				</div>
				<div class="row">
					<h2>Official Bank Stamp</h2>
					<h2 style="display:inline;">Bank Note:</h2> 
					<span style="display:inline; overflow:visible; height:100px;">
						Please Punch Name, Challan ID and Total</span>
					<p> Amountin Transaction
					</p>
				</div>
							</div>
			<!----Bank Copy -->
			<div class="col-md-4 a">
				<div class="top">
					<img class="logo" src="nust.png" class="logo  img-responsive" height="50" width="50">
					<img class="fb"src="logo.png" class=" " >
				</div>
				<div class="row" style="padding-bottom:10px;">
					<b><h4>Challan ID: _______</h4></b>
				</div>
				<div class="row">
					<h2 style="margin:0px;">National University of Sciences & Technology
						(NUST), Sector H12, Islamabad.</h2>

				</div>
				<div class="row challan">
					<u><h2 class="text-center">Fee Challan(Olympiad Copy)</h2></u>
					</div>
				<div class="row">	
					<h2 style=" display:inline;  " >Bank A/C#: </h2>
					<p style="display:inline;">{{ PKHAB902044001
					}}</p>
					</div>
				<div class="row">
					<h2 >
						HBL H­12 Sector Islamabad
					</h2>
					<p>Payable on all online branches of
	Habib Bank Ltd</p>

				</div>
				<div class="row">
					<table style="margin-top:10px;" >
						<tr>
							<td class="responsive" style="width:20%;">Generation Date</td>
							<td class="responsive">#Apr 27, 2016</td>
						</tr>
						<tr>
							<td class="responsive" style="width:20%;">Due Date </td>
							<td class="responsive">#May 27, 2016</td>
						</tr>
					</table>
				</div>
				<div class="row narrow-row" id="reg">
					<h2>Registration Type: </h2>
					<h2>Team Name: </h2>
					<h2>Team ID: </h2>
				</div>
				<div class="row">
					<h2>Event Participation Details:</h2>
					<table style="margin-top:10px; ">
						<tr  >
							<td class="responsive" style="width:30%;">Registration</td>
							<td class="responsive" style="width:50%;">Registration Fee</td>
							<td class="responsive" style=" text-algin:center; "> 800</td>
							 
						</tr>
						<tr style="height:20px;" >
							<td class="responsive" style="  width:30%;">Due Date </td>
							<td class="responsive" style="  width:50%;">Event Name</td>
							<td class="responsive" style=" ">Fee</td>
						</tr>
						<tr style="height:20px;" >
							<td class="responsive" style="width:30%;"> </td>
							<td class="responsive" style="width:50%;"><hidden></hidden></td>
							<td class="responsive" style="width:20%; height:25px;"></td>
						</tr>
					</table>
					<h2>&nbsp;______________________________<u>Total</u>&nbsp;_______</h2>	
					<h2>&nbsp;________________________<u>Grand Total</u>&nbsp;_______</h2>	
	
				</div>
				<div class="row">
					<h2>Official Bank Stamp</h2>
					<h2 style="display:inline;">Bank Note:</h2> 
					<span style="display:inline;">
						Please Punch Name, Challan ID and Total Amountin Transaction
					</span>
				</div>
			</div>
	 <!-----Participant copy ----->
		</div>
	</body>
</html>