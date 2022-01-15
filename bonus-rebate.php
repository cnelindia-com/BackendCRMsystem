<?php
session_start();

$_SESSION['page']='report';


$_SESSION['pagereport']='bonusreport';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

    <style>
.tabcontent{
	font-size: 18px;
	background:#cccccc;
	margin-left: -15px;
}
#sc8_1{
	margin-right: 9px;
	margin-left: 18px;
	color: #1b1b1b;
}
#sc8_2{
	color: #1b1b1b;
}
#sc8_1:hover {
    color: #ff6c04;
}
#sc8_2:hover {
    color: #ff6c04;
}
a:hover{
    text-decoration: none;
}
span{
	color:#ff6c04;
}
.actives{
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
	text-decoration: none;
	border: 1px solid #FF6C04;
	background: rgba(255,108,4, 0.2);	
}
.tableborder1 {
    background-color: #fff;
    *border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: solid #ccc 1px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 1px 1px #ccc;
    -moz-box-shadow: 0 1px 1px #ccc;
    box-shadow: 0 1px 1px #ccc;
}
td {
    font-family: "微软雅黑", Arial, Helvetica, sans-serif;
    font-size: 14px;
    cursor: default;
    white-space: nowrap;
	background:#fff;
}
.tableborder1 th {
    background-color: #FFA241;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#FFA241), to(rgb(255, 108, 4)));
    background-image: -webkit-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: -moz-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: -ms-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: -o-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: linear-gradient(top, #FFA241, rgb(255, 108, 4));
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    -moz-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    border-top: none;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
}
.tableborder1 td, .tableborder1 th {
    border-left: 1px solid #ccc;
    border-top: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
.tableborder1 th {
    color: #ffffff;
    font-weight: 100;
    position: relative;
}
.filternav {
    font-size: 14px;
    margin: 0 auto;
    padding: 2px 14px 3px;
    overflow: hidden;
    background: #E6E6E6;
    border-top: 1px solid #d9d9d9;
    border-bottom: 1px solid #8c8c8c;
    width: auto;
}
.filternav h2 {
    font-weight: bold;
    +padding-bottom: 9px;
}
.filternav h2 {
    font-size: 26px;
    font-family: "微软雅黑", Tahoma, Arial, Helvetica, sans-serif;
    padding-bottom: 7px;
}
.filternav {
    font-size: 14px;
	
}
.pb-5, .py-5 {
    padding-bottom: unset !important;
}

.btn1 {
    border: 0px;
    -webkit-box-shadow: inset 0px 1px 0px 0px #bbdaf7;
    box-shadow: inset 0px 1px 0px 0px #bbdaf7;
    background: rgb(56,56,56);
    background: -moz-linear-gradient(top, rgba(56,56,56,1) 14%, rgba(117,117,117,1) 99%, rgba(117,117,117,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(14%,rgba(56,56,56,1)), color-stop(99%,rgba(117,117,117,1)), color-stop(100%,rgba(117,117,117,1)));
    background: -webkit-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    background: -o-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    background: -ms-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    background: linear-gradient(to bottom, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#383838', endColorstr='#757575',GradientType=0 );
    background-color: #79bbff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: 1px solid #84bbf3;
    display: inline-block;
    color: #EFEFEF;
    font-family: "微软雅黑",arial;
    font-size: 14px;
    font-weight: normal;
    padding: 4px 20px;
    text-decoration: none;
    text-shadow: 1px 1px 0px #528ecc;
    cursor: pointer;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.container{
	background: #dedede;
max-width: 100%;
overflow-y: scroll;
height: 753px;
	}
	.form-group
	{
		display: flex;
	}
	.txt_sp3 a
	{
		color:#007bff;
	}
	html, body {
	background: #dedede;
}
    </style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id="sc8" class="tabcontent" style="display: block;">
	<a href="Finanace_Report.php" id="sc8_1">Finanace Report</a>
    <span>|</span>
    <a href="Product_Report.php" id="sc8_1">Product Report</a>
    <span>|</span>
    <a href="Member_Report.php" id="sc8_1">Member Report</a>
    <span>|</span>
    <a href="Bank_Report.php" id="sc8_1">Bank Report</a>
    <span>|</span>
    <a href="Upline_Report_Finance.php" id="sc8_1">Upline Report (Finance)</a>
    <span>|</span>
    <a href="Upline_Report_Member.php" id="sc8_1">Upline Report (Member)</a>
    <span>|</span>
    <a href="Bonus.php" id="sc8_1" class="<?php if($_SESSION['pagereport']=='bonusreport'){ echo  "actives";}?>">Bonus</a>
    <span>|</span>
    <a href="Performanace_Report.php" id="sc8_1">Performanace Report</a>
</div>
  <div class="container" >
  <div class="filternav">
	<h2>Bonus (Rebate)</h2>
		
	</div>
	<br/>
    <br/>
	
	<?php
	if($_GET['rebate_type'] == 'players'){	
	
		if(isset($_GET['bonus_id']) && !empty($_GET['bonus_id'])){
			
			$bonus_id = $_GET['bonus_id'];
		
			
			$accountid_sql = "SELECT DISTINCT(accountid) FROM transactions WHERE bonus_promotion_id  = '$bonus_id' AND transactiontype = 'Bonus' AND status = 'Approve'";
			
			if(isset($_GET['fromdate']) && !empty($_GET['fromdate'])){
							$fromdate = $_GET['fromdate'];
							$accountid_sql .= " AND transferdate >= '$fromdate'";
						}
							
						if(isset($_GET['todate']) && !empty($_GET['todate'])){
							$todate = $_GET['todate'];
							$accountid_sql .= " AND transferdate <= '$todate'";
						}			
			$accountid_query = mysqli_query($conn, $accountid_sql);		
		

		?>
		<div class="resulttable">
		
			<span class="counter pull-right"></span>
			<table class="table table-hover table-bordered results" id="table2excel">
				<thead style="background-color: #ff720b;">
					<tr>
						<th>NO</th>
						<th class="col-md-3 col-xs-3">User</th>
						<th class="col-md-3 col-xs-3">User Code</th>
						<th class="col-md-3 col-xs-3">Count</th>
						<th class="col-md-3 col-xs-3">Amount</th>    
					</tr>
				</thead>
				<tbody>
					<?php
					$rcount = 1;

					while($accountid_row = mysqli_fetch_assoc($accountid_query)){
						$accountid = $accountid_row['accountid'];
						
						$account_sql = "SELECT username, usercode FROM account WHERE id = '$accountid'";
											
						$account_query = mysqli_query($conn, $account_sql);
						$account_query_row = mysqli_fetch_assoc($account_query);
						
						$a_username = $account_query_row['username'];
						$a_user_code = $account_query_row['usercode'];
						
						$total_count_sql = "SELECT COUNT(*) as total_counts, SUM(amount) as total_amount FROM transactions WHERE transactiontype = 'Bonus' AND bonus_promotion_id  = '$bonus_id' AND accountid = '$accountid' AND status = 'Approve'";
					if(isset($_GET['fromdate']) && !empty($_GET['fromdate'])){
							$fromdate = $_GET['fromdate'];
							$total_count_sql .= " AND transferdate >= '$fromdate'";
						}
							
						if(isset($_GET['todate']) && !empty($_GET['todate'])){
							$todate = $_GET['todate'];
							$total_count_sql .= " AND transferdate <= '$todate'";
						}
						$total_count_query = mysqli_query($conn, $total_count_sql);
						$total_count_row = mysqli_fetch_assoc($total_count_query);
						$total_counts = $total_count_row['total_counts'];
						$total_amount = $total_count_row['total_amount'];
						

						
						
					?>
					<tr>
					  <td><?php echo $rcount; ?></td>
					  <td><?php echo strtoupper($a_username); ?></td>
					  <td><?php echo $a_user_code; ?></td>               
					  <td><?php echo $total_counts; ?></td>                
					  <td><?php echo number_format($total_amount,2); ?></td>                
					</tr>
					<?php
						$rcount++;
					}
					?>
				</tbody>


			</table>
		</div>
		<?php
		}
	}
	else if($_GET['rebate_type'] == 'counts'){	
	
		if(isset($_GET['bonus_id']) && !empty($_GET['bonus_id'])){
			
			$bonus_id = $_GET['bonus_id'];
			
			$accountid_sql = "SELECT DISTINCT(accountid) FROM transactions WHERE bonus_promotion_id  = '$bonus_id' AND transactiontype = 'Bonus' AND status = 'Approve'";

						if(isset($_GET['fromdate']) && !empty($_GET['fromdate'])){
							$fromdate = $_GET['fromdate'];
							$accountid_sql .= " AND transferdate >= '$fromdate'";
						}
							
						if(isset($_GET['todate']) && !empty($_GET['todate'])){
							$todate = $_GET['todate'];
							$accountid_sql .= " AND transferdate <= '$todate'";
						}

			$accountid_query = mysqli_query($conn, $accountid_sql);
			
	
		?>
		<div class="resulttable">
		
			<span class="counter pull-right"></span>
			<table class="table table-hover table-bordered results" id="table2excel">
				<thead style="background-color: #ff720b;">
					<tr>
						<th>NO</th>
						<th class="col-md-3 col-xs-3">User</th>
						<th class="col-md-3 col-xs-3">User Code</th>
						<th class="col-md-3 col-xs-3">Count</th>
						<th class="col-md-3 col-xs-3">Amount</th>    
					</tr>
				</thead>
				<tbody>
					<?php
					$rcount = 1;

					while($accountid_row = mysqli_fetch_assoc($accountid_query)){
						$accountid = $accountid_row['accountid'];
						
						$total_count_sql = "SELECT COUNT(*) as total_counts, SUM(amount) as total_amount FROM transactions WHERE transactiontype = 'Bonus' AND bonus_promotion_id  = '$bonus_id' AND accountid = '$accountid' AND status = 'Approve'";
						if(isset($_GET['fromdate']) && !empty($_GET['fromdate'])){
							$fromdate = $_GET['fromdate'];
							$total_count_sql .= " AND transferdate >= '$fromdate'";
						}
							
						if(isset($_GET['todate']) && !empty($_GET['todate'])){
							$todate = $_GET['todate'];
							$total_count_sql .= " AND transferdate <= '$todate'";
						}
						
						$total_count_query = mysqli_query($conn, $total_count_sql);
						$total_count_row = mysqli_fetch_assoc($total_count_query);
						$total_counts = $total_count_row['total_counts'];
						$total_amount = $total_count_row['total_amount'];	
			
						
					
						$account_sql = "SELECT username, usercode FROM account WHERE id = '$accountid'";
											
						$account_query = mysqli_query($conn, $account_sql);
						$account_query_row = mysqli_fetch_assoc($account_query);
						
						$a_username = $account_query_row['username'];
						$a_user_code = $account_query_row['usercode'];
						
	
						

						
						
					?>
					<tr>
					  <td><?php echo $rcount; ?></td>
					  <td><?php echo strtoupper($a_username); ?></td>
					  <td><?php echo $a_user_code; ?></td>               
					  <td><?php echo $total_counts; ?></td>                
					  <td><?php echo number_format($total_amount,2); ?></td>                
					</tr>
					<?php
						$rcount++;
					}
					?>
				</tbody>


			</table>
		</div>
		<?php
		}
	}
	?>
</div>
</body>
</html>
<script>
	function populateDate(fromdate,todate)
	{
		$("#fromdate").val(fromdate+' 00:00:00');	
		$("#todate").val(todate+' 23:59:59');		
	}
	function cleardate()
	{
		$("#fromdate").val('');	
		$("#todate").val('');
	}
</script>