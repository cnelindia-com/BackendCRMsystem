<?php
session_start();


if(isset($_POST['stype']) && $_POST['stype']=="Cash Out")
{		
	include('config.php');
	$acid= $_POST['withdrawfromaccount'];
	$famount= $_POST['famount'];
	$transtype= $_POST['itransactiontype'];
	$sremark= $_POST['sremark'];
	$cashout= $_POST['stype'];
	$user= $_POST['loguser'];

	$sql= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by, status, actiontype) VALUES ('$acid', '$transtype', CURDATE(), $famount, '$sremark', '$user', 'Active', '$cashout')";
	
	$result= mysqli_query($conn, $sql);	
	echo json_encode(array('result' => 'success'));
	die();
}

if(isset($_POST['stype']) && $_POST['stype']=="Cash In")
{	
	include('config.php');
	$acid= $_POST['depositinaccount'];
	$famount= $_POST['famount'];
	$transtype= $_POST['itransactiontype'];
	$sremark= $_POST['sremark'];
	$cashin= $_POST['stype'];
	$user= $_POST['loguser'];

	$sql= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by, status, actiontype) VALUES ('$acid', '$transtype', CURDATE(), $famount, '$sremark', '$user', 'Active', '$cashin')";
	
	$result= mysqli_query($conn, $sql);	
	echo json_encode(array('result' => 'success'));
	die();
}

if(isset($_POST['stype']) && $_POST['stype']=="Transfer")
{	
	include('config.php');
	$acid= $_POST['transferinaccount'];
	$famount= $_POST['famount'];
	$transtype= $_POST['itransactiontype'];
	$itransactiontypeto= $_POST['itransactiontypeto'];
	$sremark= $_POST['sremark'];
	$bnkid= $_POST['ibnkid'];
	$tobnkid= $_POST['ibnkidto'];
	$transfer= $_POST['stype'];
	$user= $_POST['loguser'];

	//Transfer in account
	$sql= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by, status, actiontype) VALUES ('$tobnkid', '$transtype', CURDATE(), $famount, '$sremark', '$user', 'Active',  '$transfer')";
	
	$result= mysqli_query($conn, $sql);
	
	//Transfer from account
	$sql1= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by, status, actiontype) VALUES ('$acid', '$itransactiontypeto', CURDATE(), $famount, '$sremark', '$user', 'Active', '$transfer')";
	
	$result2= mysqli_query($conn, $sql1);	
	echo json_encode(array('result' => 'success'));
	die();
}

if(isset($_POST['stype']) && $_POST['stype']=="Other")
{	
	include('config.php');
	$acid= $_POST['ibnkid'];
	$famount= $_POST['famount'];
	$transtype= $_POST['itransactiontype'];
	$sremark= $_POST['sremark'];
	$transtype='';
	$other= $_POST['stype'];
	$user= $_POST['loguser'];
	
	if($_POST['itransactiontype']=='Other(+)')
	{
		$transtype= $_POST['itransactiontype'];
		$sql= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by, status, actiontype) VALUES ('$acid', '$transtype', CURDATE(), $famount, '$sremark', '$user', 'Active', 'other')";
	}
	else
	{
		$transtype= $_POST['itransactiontype'];
		$sql= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by, status, actiontype) VALUES ('$acid', '$transtype', CURDATE(), $famount, '$sremark', '$user', 'Active', 'other')";
	}
	$result= mysqli_query($conn, $sql);	
	echo json_encode(array('result' => 'success'));
	die();
}


$_SESSION['page']='finance';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$user=$_SESSION['user'];
$search="";
$searchkey='';
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

$csv_data[] = array("No", "Username", "User Code", "Full Name", "Email", "Phone", "IP", "Registered On", "Last Active", "Status");


if(isset($_POST['fromdate']) && isset($_POST['todate']) && !empty($_POST['fromdate']) && !empty($_POST['todate'])){
	
	$fromdate=$_POST['fromdate'];
	$todate=$_POST['todate'];
	
	$sql= "SELECT SUM(CASE WHEN (transaction_type = 'TF Deposit') OR (transaction_type = 'Transfer(+)') OR (transaction_type = 'Other(+)') THEN amount else 0 end) as deposit, SUM(CASE WHEN (transaction_type = 'TF Withdrawal') OR (transaction_type = 'Transfer(-)') OR (transaction_type = 'Other(-)') THEN amount else 0 end) as withdrawal, bank_transaction.* FROM `bank_transaction` WHERE (transaction_type='TF Deposit' OR transaction_type= 'TF Withdrawal' OR transaction_type= 'Transfer(+)' OR transaction_type= 'Transfer(-)' OR transaction_type= 'Other(+)' OR transaction_type= 'Other(-)') AND (date BETWEEN '$fromdate' AND '$todate') GROUP BY bankaccount_id";		
}
else{
$sql= "SELECT SUM(CASE WHEN (transaction_type = 'TF Deposit') OR (transaction_type = 'Transfer(+)') OR (transaction_type = 'Other(+)') THEN amount else 0 end) as deposit, SUM(CASE WHEN (transaction_type = 'TF Withdrawal') OR (transaction_type = 'Transfer(-)') OR (transaction_type = 'Other(-)') THEN amount else 0 end) as withdrawal, bank_transaction.* FROM `bank_transaction` WHERE transaction_type='TF Deposit' OR transaction_type= 'TF Withdrawal' OR transaction_type= 'Transfer(+)' OR transaction_type= 'Transfer(-)' OR transaction_type= 'Other(+)' OR transaction_type= 'Other(-)' GROUP BY bankaccount_id";
}
	$result= mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

      <script>

      function ConfirmDelete() {  
       var r = confirm("Are you sure you want to DELETE the USER ?");
       if(r==true){var s = confirm("Are you sure you want to DELETE the USER ?(Secrond Confirm)");}else{return false;			}
       if(s==true){var t = confirm("Are you sure you want to DELETE the USER ?(Last Confirm)");}else{return false;}
       if(t!=true){return false;}
      }

      function WrongDelete() {  
       alert("You cannot delete your own ID");
      }

      function getFocus(){
        searchbox.focus();
        var length = searchbox.value.length;  
        searchbox.setSelectionRange(length, length);
      }
     
      </script>

    <style>
.popupDiv,.popupDiv_hwe,.txpopupDiv,.popupDivother{
	border: 2px solid #000;
	display: block;
	background-color: #eee;
}
.popupDiv,.popupDiv_hwe,.txpopupDiv,.popupDivother{
	display:none;	
}
.popupDiv .cashInDiv,.popupDiv_hwe .cashoutDiv,.txpopupDiv .cashTxDiv,.popupDivother  .otherDiv{
	font-size: 14px;
}
	
.popupDiv .top,.popupDiv_hwe .top_hwe,.txpopupDiv .toptx,.popupDivother .topother{
	padding: 2px 5px 0 5px;
	display: block;
	height: 25px;
	border-bottom: 1px solid #000;
	font-size: 16px;
}
.popupDiv .closeBtn,.popupDiv_hwe .closeBtn_hwe,.txpopupDiv .closeBtntx,.popupDivother .closeBtnother{
	cursor: pointer;
	float: right;
	font-size: 16px;
	font-weight: 600;
	margin: -2px -2px 0 0;
	text-decoration: none;
}
.popupDiv-overlay,.popupDiv-overlay_hwe,.popupDiv-overlay_tx,.popupDiv-overlay_other{
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
	z-index: 99;
	position: absolute;
	top: 0;
	left: 0;
}
.popupDiv-overlay,.popupDiv-overlay_hwe,.popupDiv-overlay_tx,.popupDiv-overlay_other{
	display:none;	
}
.body{
	font-size: 14px;
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, SimSun, sans-serif;	
}
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

.cashInDiv table tr td {
	background: #eeeeee;
}

.cashoutDiv table tr td {
	background: #eeeeee;
}

.cashTxDiv table tr td {
	background: #eeeeee;
}

.otherDiv table tr td {
	background: #eeeeee;
} 
 

.cashInDiv table tr th, .cashInDiv table tr td {
	padding: 2px 0 0 15px;
}
.cashoutDiv table tr th, .cashoutDiv table tr td {
	padding: 2px 0 0 15px;
}
.cashTxDiv table tr th, .cashTxDiv table tr td {
	padding: 2px 0 0 15px;
}
.otherDiv table tr th, .otherDiv table tr td {
	padding: 2px 0 0 15px;
}

.hwepopuparea span {
	color: black !important;
}

.popupDiv .top span {
	color: #000;
}

.popupDiv_hwe .top_hwe span {
	color: #000;
}
.txpopupDiv .toptx span {
	color: #000;
}
.popupDivother .topother span {
	color: #000;
}


    </style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


 <?php 
  $filter = $_POST['aflt'];
 ?>

 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="bank_transaction.php" id="sc8_1">Bank Transaction</a>
    <span>|</span>
    <a href="finance_summary.php" id="sc8_1">Finance Summary</a>
    <span>|</span>
    <a href="finance_summary_lite.php" id="sc8_1" class="actives">Finance Summary (Lite)</a>
    <span>|</span>
    <a href="daily_summary.php" id="sc8_1">Daily Summary</a>
</div>
<div class="container" >
  <div class="filternav">
	<h2>Finance Summary (Lite)</h2>
		<form method="post">
        	 <div class="form-group">
				<div class="col-md-2"><b>Status</b></div>
				<div class="col-md-10">					
					<select name="aflt" id="aflt">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Suspended</option>
                    </select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					<input type="text" name="fromdate" id="fromdate" value="<?php echo $_POST['fromdate'];?>"/> ~
					<input type="text" name="todate" id="todate" value="<?php echo $_POST['todate'];?>"/>
                    
                    <span class="txt_sp3">
                        <a class="nounderscore" href="javascript:add1day()">+1</a>&nbsp;&nbsp;
                        <a class="nounderscore" href="javascript:minus1day()">-1</a>&nbsp;&nbsp;
                        <a class="nounderscore" href="#" onclick="populateDate('<?php echo date('Y-m-d');?>','<?php echo date('Y-m-d');?>');return false;">Today</a>&nbsp;&nbsp;
                        <a class="nounderscore"href="#" onclick="populateDate('<?php echo date('Y-m-d',strtotime("-1 days"));?>','<?php echo date('Y-m-d',strtotime("-1 days"));?>');return false;">Yesterday</a>&nbsp;&nbsp;
                        <a class="nounderscore" href="#" onclick="populateDate('<?php echo date('Y-m-d', strtotime('last Monday'));?>','<?php echo date('Y-m-d', strtotime('next Sunday'));?>');return false;">This Week</a>&nbsp;&nbsp;
                        <a class="nounderscore" href="#" onclick="populateDate('<?php echo date('Y-m-d', strtotime("last week monday"));?>','<?php echo date('Y-m-d', strtotime("last week sunday"));?>');return false;">Last Week</a>&nbsp;&nbsp;
                        <a class="nounderscore" href="#" onclick="populateDate('<?php echo date('Y-m-d',strtotime('first day of this month'));?>','<?php echo date('Y-m-d',strtotime('last day of this month'));?>');return false;">This Month</a>&nbsp;&nbsp;
                        <a class="nounderscore" href="#" onclick="populateDate('<?php echo date('Y-m-d',strtotime("first day of last month"));?>','<?php echo date('Y-m-d',strtotime("last day of last month"));?>');return false;">Last Month</a>&nbsp;&nbsp;
                        <a class="nounderscore button" href="#" onclick="cleardate();return false;">Clear</a>
                    </span>
				</div>
			</div>
          			
			<div>
				<input type="submit" class="btn btn-secondary" name="submit" id="submit" value="Search"/>
				<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
    </div>
    <br/>
    <br/>
    <div class="resulttable">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Bank </th>
                  <th class="col-md-3 col-xs-3">Bank Account Code</th>
                  <th class="col-md-3 col-xs-3">Bank Account Name</th>
                  <th class="col-md-3 col-xs-3">Bank Account Number</th>
                  <th class="col-md-3 col-xs-3">Total Balance</th>
                  <th class="col-md-3 col-xs-3">Last Action</th>                  
                  <th class="col-md-3 col-xs-3">Status</th>
                  <th class="col-md-3 col-xs-3">Action</th>
              	</tr>
            </thead>
            <tbody>
            	<tr>
            <?php	
			if(isset($_POST['fromdate']) && isset($_POST['todate']) && !empty($_POST['fromdate']) && !empty($_POST['todate'])){
			
			$fromdate=$_POST['fromdate'];
			$todate=$_POST['todate'];
			$sql1= "SELECT SUM(CASE WHEN (transaction_type = 'TF Deposit') OR (transaction_type = 'Transfer(+)') OR (transaction_type = 'Other(+)') THEN amount else 0 end) as deposit, SUM(CASE WHEN (transaction_type = 'TF Withdrawal') OR (transaction_type = 'Transfer(-)') OR (transaction_type = 'Other(-)') THEN amount else 0 end) as withdrawal, bank_transaction.* FROM `bank_transaction` WHERE (date BETWEEN '$fromdate' AND '$todate') GROUP BY bankaccount_id";

			$result1= mysqli_query($conn, $sql1);		
			$accountid1='';
			$accid= array();
			}
			else
			{
				$sql1= "SELECT SUM(CASE WHEN (transaction_type = 'TF Deposit') OR (transaction_type = 'Transfer(+)') OR (transaction_type = 'Other(+)') THEN amount else 0 end) as deposit, SUM(CASE WHEN (transaction_type = 'TF Withdrawal') OR (transaction_type = 'Transfer(-)') OR (transaction_type = 'Other(-)') THEN amount else 0 end) as withdrawal, bank_transaction.* FROM `bank_transaction` GROUP BY bankaccount_id";

				$result1= mysqli_query($conn, $sql1);		
				$accountid1='';
				$accid= array();
	
			}									
			
				$bnk= 1;								
				
				$total=0;
				$total_amount= 0;
				$total_deposit= 0;
				$total_withdrawal= 0;				
				
				while($bnk_row= mysqli_fetch_assoc($result1)){
					
					$accountid= explode(",", $bnk_row['bankaccount_id']);
					$accid[]=$accountid[0];
					$accountid1= implode(",", $accid);
				}				
				
				while($bnk_rows= mysqli_fetch_assoc($result)){
										
					$total_deposit+=$bnk_rows['deposit'];
					$total_withdrawal+= $bnk_rows['withdrawal'];
					
					$total_amount= ($bnk_rows['deposit']-$bnk_rows['withdrawal']);	
					$total= ($total_deposit-$total_withdrawal);				
					$bnk_id= $bnk_rows['bankaccount_id'];
					
					$account_sql= "SELECT * FROM `bank_account` WHERE id= $bnk_id";
					$account_res= mysqli_query($conn, $account_sql);
					$account_rows= mysqli_fetch_assoc($account_res);
				
			?>
            	<tr>
                  <td><?php echo $bnk; ?></td>
                  <td><?php echo $account_rows['bank_account_code']; ?></td>
				  <td><?php echo $account_rows['bank_account_name']; ?> </td>
                  <td><?php echo $account_rows['bank_account_number']; ?> </td>
                  <td><?php echo number_format($total_amount, "2", ".", ","); ?></td>
                  <td><?php echo $bnk_rows['date']; ?></td>                  
                  <td style="color:blue;"><?php echo $account_rows['status']; ?></td>                 
                  <td>
                  
                  <span style="color:#0055ff;TEXT-DECORATION: underline;">
                  		<a href="javascript:void(0);" onclick="openDiv(this);">Cash In</a> | 
						<a href="javascript:void(0);" onclick="cashoutopenDiv(this);">Cash Out</a> | 
						<a href="javascript:void(0);" onclick="txopenDiv(this);">Transfer</a> |
						<a href="javascript:void(0);" onclick="openDivother(this);">Other</a>
                   </span>
                    
                    <div class="popupDiv-overlay"></div>
                    <div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -183px; margin-top: -107px;" class="popupDiv">

    	<div class="top">
    	
        	<span><b>Cash In - <?php echo $account_rows['bank_account_code']; ?> BANK</b></span>
    		<a class="closeBtn" onclick="closeMe()">[X]</a>
        
    	</div>
        
        <div class="cashInDiv">
        
        	<form name="cashin_form" method="get" class="transformcolor">
        	<table border="0px">
        		<tbody class="hideborder hwepopuparea">
        			<tr>
        				<th><span>Account Name</span></th>
        					<td>:</td>
       						<td><?php echo $account_rows['bank_account_name'];?></td>
                    </tr>
        			<tr>
                    	<th><span>Bank Account</span></th>
        					<td>:</td>
        					<td><?php echo $account_rows['bank_account_number'];?></td>
                    </tr>
       				<tr>
                    	<th><span>Amount</span></th>
        					<td>:</td>
        					<td><input type="number" name="famount" id="famount" placeholder="0" value="<?php echo $_GET['famount']; ?>"></td>
                    </tr>
        			<tr>
                    	<th><span>Type</span></th>
        					<td>:</td>
        					<td><label for="agent"><input type="radio" name="typeselection" id="agent" onclick="selecttype(this)" checked="checked">Cash Flow Agent</label>&nbsp;&nbsp;&nbsp;<label for="salexp"><input type="radio" name="typeselection" id="salexp" onclick="selecttype(this)">Sales</label></td>
                    </tr>
        
        			<tr style="display:none;" class="salexp">
                    	<th><span>Sales</span></th>
        					<td>:</td>
        					<td></td>
                    </tr>
			        <tr class="agent">
        				<th><span>Cash Flow Agent</span></th>
        					<td>:</td>
        					<td></td>
        			</tr>
        			<tr>
        				<th><span>Remark</span></th>
					        <td>:</td>
				    	    <td><input type="text" name="sremark" placeholder="enter remark"></td></tr>
       				<tr>
				        <td colspan="3" style="text-align:center;">
                        <input type="submit" value="Submit" class="saveaccountinfo" >&nbsp;
                        <input type="button" value="Cancel" class="closepopup">
                        </td>
                    </tr>

        	</tbody>
        </table>
        
        	
        	<input type="hidden" name="depositinaccount" id="savedepositamnt" value="<?php echo $bnk_rows['bankaccount_id']?>">
            <input type="hidden" name="itransactiontype" value="TF Deposit">
            <input type="hidden" name="ibnkid" value="<?php echo $account_rows['bank_id']; ?>">
            <input type="hidden" name="loguser" value="<?php echo $user; ?>">
            <input type="hidden" name="stype" value="Cash In">
        
        </form>
        
   	</div>
  </div>
  
				<div class="popupDiv-overlay_hwe"></div>   
  				<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -183px; margin-top: -107px;" class="popupDiv_hwe">

    	<div class="top_hwe">
    	
        	<span><b>Cash Out - <?php echo $account_rows['bank_account_code']; ?> BANK</b></span>
    		<a class="closeBtn_hwe" onclick="closeMe_hwe()">[X]</a>
        
    	</div>
        
        <div class="cashoutDiv">
        
        	<form name="cashout_form" method="get" class="transformcolor">
        	<table border="0px">
        		<tbody class="hideborder hwepopuparea">
        			<tr>
        				<th><span>Account Name</span></th>
        					<td>:</td>
       						<td><?php echo $account_rows['bank_account_name'];?></td>
                    </tr>
        			<tr>
                    	<th><span>Bank Account</span></th>
        					<td>:</td>
        					<td><?php echo $account_rows['bank_account_number'];?></td>
                    </tr>
       				<tr>
                    	<th><span>Amount</span></th>
        					<td>:</td>
        					<td><input type="number" name="famount" id="famount" placeholder="0" value="<?php echo $_GET['famount']; ?>"></td>
                    </tr>
        			<tr>
                    	<th><span>Type</span></th>
        					<td>:</td>
        					<td><label for="agent"><input type="radio" name="typeselection" id="agent" onclick="selecttype(this)" checked="checked">Cash Flow Agent</label>&nbsp;&nbsp;&nbsp;<label for="salexp"><input type="radio" name="typeselection" id="salexp" onclick="selecttype(this)">Sales</label></td>
                    </tr>
        
        			<tr style="display:none;" class="salexp">
                    	<th><span>Sales</span></th>
        					<td>:</td>
        					<td></td>
                    </tr>
			        <tr class="agent">

        				<th><span>Cash Flow Agent</span></th>
        					<td>:</td>
        					<td></td>
        			</tr>
        			<tr>
        				<th><span>Remark</span></th>
					        <td>:</td>
				    	    <td><input type="text" name="sremark" placeholder="enter remark"></td></tr>
       				<tr>
				        <td colspan="3" style="text-align:center;">
                        <input type="submit" value="Submit" class="saveaccountinfo" >&nbsp;
                        <input type="button" value="Cancel" class="closepopup_hwe">
                        </td>
                    </tr>

        	</tbody>
        </table>
        
        	
        	<input type="hidden" name="withdrawfromaccount" id="savedepositamnt" value="<?php echo $bnk_rows['bankaccount_id'];?>">
            <input type="hidden" name="itransactiontype" value="TF Withdrawal">
            <input type="hidden" name="ibnkid" value="<?php echo $account_rows['bank_id']; ?>">
            <input type="hidden" name="loguser" value="<?php echo $user; ?>">
            <input type="hidden" name="stype" value="Cash Out">
        
        </form>
        
   	</div>
  </div>
  
  				<div class="popupDiv-overlay_tx"></div>
  				<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -208px; margin-top: -120.5px;" class="txpopupDiv">
            
				<div class="toptx">

					<span><b>Transfer</b></span>
						<a class="closeBtntx" onclick="closeMe_tx();">[X]</a>
				</div>

				<div class="cashTxDiv">
					<form id="transferForm" name="transferForm" method="get" class="transformcolor">               
                    <table>
                    <tbody class="hideborder hwepopuparea">
                    	<tr>
                    		<th colspan="3" style="text-align: center;">Transaction From Bank Account</th>
                    	</tr>
                        
                    	<tr>
                    		<th>
                            <span>Account Name</span>
                            </th>
                            <td>:</td>
                            <td><?php echo $account_rows['bank_account_name']; ?></td>
                        </tr>
                        
                   		<tr>
                    		<th>
                    			<span>Bank Account</span>
                            </th>
                            
                            <td>:</td>
                            <td><?php echo $account_rows['bank_account_number']; ?></td>
                            </tr>
                            <tr>
                           <th colspan="3" style="text-align: center;border-top: 1px solid #000; padding-top:4px;">				  							To Bank Account</th>
                   		</tr>
                        
                    	<tr>
                        
                    		<th><span>Account Name</span></th>
                    			<td>:</td>
                                
                                <td>
                                <select name="ibnkidto" style="width:250px;">
                                                                
                                <?php
								
									$tx_sql= "SELECT * FROM `bank_account`"; 
									$tx_res= mysqli_query($conn, $tx_sql);
									
									while($account_row= mysqli_fetch_assoc($tx_res))
									{
								?>
                                
                                <option value="<?php echo $account_row['id'];?>" "<?php if(isset($_GET['ibnkidto'])) echo 'selected'; ?>"><?php echo $account_row['bank_account_code']."-".$account_row['bank_account_name']."[".$account_row['bank_account_number']."]"; ?></option>                               
                                 <?php
									}
                                ?>
                                </select>
                                </td>
                                
                    	</tr>
                        
                    	<tr>
                        
                            <th><span>Amount</span></th>
                            <td>:</td>
                            <td><input type="number" name="famount" placeholder="0"></td>
                    	</tr>
                        
                    	<tr>
                        
                            <th>
                            <span>Remark</span>
                            </th>
                            <td>:</td>
                            <td><input type="text" name="sremark" placeholder="enter remark"></td>
                            
                    	</tr>
                        
                    	<tr>
                        
                            <th colspan="3" style="text-align:center;">
                            <input type="submit" value="Submit">&nbsp;
                            <input type="button" value="Cancel" class="closepopuptx">
                            </th>
                            
                    	</tr>
                        
                    </tbody>
                 </table>
                                  	
                        <input type="hidden" name="transferinaccount" id="savedepositamnt" value="<?php echo $bnk_rows['bankaccount_id'];?>">
                        <input type="hidden" name="itransactiontype" value="Transfer(+)">
                        <input type="hidden" name="itransactiontypeto" value="Transfer(-)">
                        <input type="hidden" name="ibnkid" value="<?php echo $account_rows['bank_id']; ?>">
                        <input type="hidden" name="loguser" value="<?php echo $user; ?>">
                        <input type="hidden" name="stype" value="Transfer">
                        
                  </form>
                  
             </div>
             
   		</div>
        
        		
        		<div class="popupDiv-overlay_other"></div>
        		<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -162.5px; margin-top: -96px;" class="popupDivother">
	
	<div class="topother">
	
		<span><b>Other</b></span>
		<a class="closeBtnother" onclick="closeMeother();">[X]</a>
	
	</div>
	
	<div class="otherDiv">
	
		<form id="otherForm" name="otherForm" method="get" class="transformcolor">
		
		<table>
			<tbody class="hideborder hwepopuparea">
				<tr>
					<th>
						<span>Account Name</span>	
					</th>
						<td>:</td>
						<td><?php echo $account_rows['bank_account_name']; ?></td>
				</tr>
				
				<tr>
				
					<th><span>Bank Account</span></th>					
						<td>:</td><td><?php echo $account_rows['bank_account_number']; ?></td>
						
				</tr>
			
				<tr>
					
					<th><span>Type</span></th>
						<td>:</td>
						<td>
							<input type="radio" name="itransactiontype" id="in" value="Other(+)">
							<label for="in" value="In">In</label>&nbsp;&nbsp;&nbsp;
							<input type="radio" name="itransactiontype" id="out" value="Other(-)">
							<label for="out">Out</label>
						</td>
				</tr>

				<tr>
				
					<th><span>Amount</span></th>
						<td>:</td>
						<td><input type="number" name="famount" placeholder="0"></td>
				</tr>
					
				<tr>
					<th><span>Remark</span></th>
						<td>:</td>
						<td><input type="text" name="sremark" placeholder="enter remark"></td>
				</tr>
				
				<tr>
					<td colspan="3" style="text-align:center;">
						<input type="submit" value="Submit">&nbsp;
						<input type="button" value="Cancel" class="closepopupother">
					</td>
				</tr>
	</tbody>
</table>
			<input type="hidden" name="ibnkid" value="<?php echo $bnk_rows['bankaccount_id']; ?>">
            <input type="hidden" name="loguser" value="<?php echo $user; ?>">
			<input type="hidden" name="stype" value="Other">
	</form>
	
	</div>
	
</div>
</td>
</tr>

		<?php 
			$bnk++;				
				}
			if($accountid1!==''){
				$accnt_res=mysqli_query($conn, "SELECT * FROM `bank_account` WHERE id NOT IN ($accountid1)");
			}
			else
			{
				$accnt_res=mysqli_query($conn, "SELECT * FROM `bank_account`");	
			}
				while($accnt_rows= mysqli_fetch_assoc($accnt_res)){													
				$total_amount=0;									        
		?>            
            
            <tr>
                  <td><?php echo $bnk; ?></td>
                  <td><?php echo $accnt_rows['bank_account_code']; ?></td>
				  <td><?php echo $accnt_rows['bank_account_name']; ?> </td>
                  <td><?php echo $accnt_rows['bank_account_number']; ?> </td>
                  <td><?php echo number_format($total_amount, '2', '.', ','); ?></td>
                  <td><?php echo $bnk_rows['date']; ?></td>                  
                  <td style="color:blue;"><?php echo $account_rows['status']; ?></td>                 
                  <td>
                  
                  <span style="color:#0055ff;TEXT-DECORATION: underline;">
                  		<a href="javascript:void(0);" onclick="openDiv(this);">Cash In</a> | 
						<a href="javascript:void(0);" onclick="cashoutopenDiv(this);">Cash Out</a> | 
						<a href="javascript:void(0);" onclick="txopenDiv(this);">Transfer</a> |
						<a href="javascript:void(0);" onclick="openDivother(this);">Other</a>
                   </span>
                    
                    <div class="popupDiv-overlay"></div>
                    <div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -183px; margin-top: -107px;" class="popupDiv">

    	<div class="top">
    	
        	<span><b>Cash In - <?php echo $accnt_rows['bank_account_code']; ?> BANK</b></span>
    		<a class="closeBtn" onclick="closeMe()">[X]</a>
        
    	</div>
        
        <div class="cashInDiv">
        
        	<form name="cashin_form" method="get" class="transformcolor">
        	<table border="0px">
        		<tbody class="hideborder hwepopuparea">
        			<tr>
        				<th><span>Account Name</span></th>
        					<td>:</td>
       						<td><?php echo $accnt_rows['bank_account_name'];?></td>
                    </tr>
        			<tr>
                    	<th><span>Bank Account</span></th>
        					<td>:</td>
        					<td><?php echo $accnt_rows['bank_account_number'];?></td>
                    </tr>
       				<tr>
                    	<th><span>Amount</span></th>
        					<td>:</td>
        					<td><input type="number" name="famount" id="famount" placeholder="0" value="<?php echo $_GET['famount']; ?>"></td>
                    </tr>
        			<tr>
                    	<th><span>Type</span></th>
        					<td>:</td>
        					<td><label for="agent"><input type="radio" name="typeselection" id="agent" onclick="selecttype(this)" checked="checked">Cash Flow Agent</label>&nbsp;&nbsp;&nbsp;<label for="salexp"><input type="radio" name="typeselection" id="salexp" onclick="selecttype(this)">Sales</label></td>
                    </tr>
        
        			<tr style="display:none;" class="salexp">
                    	<th><span>Sales</span></th>
        					<td>:</td>
        					<td></td>
                    </tr>
			        <tr class="agent">
        				<th><span>Cash Flow Agent</span></th>
        					<td>:</td>
        					<td></td>
        			</tr>
        			<tr>
        				<th><span>Remark</span></th>
					        <td>:</td>
				    	    <td><input type="text" name="sremark" placeholder="enter remark"></td></tr>
       				<tr>
				        <td colspan="3" style="text-align:center;">
                        <input type="submit" value="Submit" class="saveaccountinfo" >&nbsp;
                        <input type="button" value="Cancel" class="closepopup">
                        </td>
                    </tr>

        	</tbody>
        </table>
        
        	
        	<input type="hidden" name="depositinaccount" id="savedepositamnt" value="<?php echo $accnt_rows['id']?>">
            <input type="hidden" name="itransactiontype" value="TF Deposit">
            <input type="hidden" name="ibnkid" value="<?php echo $accnt_rows['bank_id']; ?>">
            <input type="hidden" name="loguser" value="<?php echo $user; ?>">
            <input type="hidden" name="stype" value="Cash In">
        
        </form>
        
   	</div>
  </div>
  
				<div class="popupDiv-overlay_hwe"></div>   
  				<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -183px; margin-top: -107px;" class="popupDiv_hwe">

    	<div class="top_hwe">
    	
        	<span><b>Cash Out - <?php echo $accnt_rows['bank_account_code']; ?> BANK</b></span>
    		<a class="closeBtn_hwe" onclick="closeMe_hwe()">[X]</a>
        
    	</div>
        
        <div class="cashoutDiv">
        
        	<form name="cashout_form" method="get" class="transformcolor">
        	<table border="0px">
        		<tbody class="hideborder hwepopuparea">
        			<tr>
        				<th><span>Account Name</span></th>
        					<td>:</td>
       						<td><?php echo $accnt_rows['bank_account_name'];?></td>
                    </tr>
        			<tr>
                    	<th><span>Bank Account</span></th>
        					<td>:</td>
        					<td><?php echo $accnt_rows['bank_account_number'];?></td>
                    </tr>
       				<tr>
                    	<th><span>Amount</span></th>
        					<td>:</td>
        					<td><input type="number" name="famount" id="famount" placeholder="0" value="<?php echo $_GET['famount']; ?>"></td>
                    </tr>
        			<tr>
                    	<th><span>Type</span></th>
        					<td>:</td>
        					<td><label for="agent"><input type="radio" name="typeselection" id="agent" onclick="selecttype(this)" checked="checked">Cash Flow Agent</label>&nbsp;&nbsp;&nbsp;<label for="salexp"><input type="radio" name="typeselection" id="salexp" onclick="selecttype(this)">Sales</label></td>
                    </tr>
        
        			<tr style="display:none;" class="salexp">
                    	<th><span>Sales</span></th>
        					<td>:</td>
        					<td></td>
                    </tr>
			        <tr class="agent">

        				<th><span>Cash Flow Agent</span></th>
        					<td>:</td>
        					<td></td>
        			</tr>
        			<tr>
        				<th><span>Remark</span></th>
					        <td>:</td>
				    	    <td><input type="text" name="sremark" placeholder="enter remark"></td></tr>
       				<tr>
				        <td colspan="3" style="text-align:center;">
                        <input type="submit" value="Submit" class="saveaccountinfo" >&nbsp;
                        <input type="button" value="Cancel" class="closepopup_hwe">
                        </td>
                    </tr>

        	</tbody>
        </table>
        
        	
        	<input type="hidden" name="withdrawfromaccount" id="savedepositamnt" value="<?php echo $accnt_rows['id'];?>">
            <input type="hidden" name="itransactiontype" value="TF Withdrawal">
            <input type="hidden" name="ibnkid" value="<?php echo $accnt_rows['bank_id']; ?>">
            <input type="hidden" name="loguser" value="<?php echo $user; ?>">
            <input type="hidden" name="stype" value="Cash Out">
        
        </form>
        
   	</div>
  </div>
  
  				<div class="popupDiv-overlay_tx"></div>
  				<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -208px; margin-top: -120.5px;" class="txpopupDiv">
            
				<div class="toptx">

					<span><b>Transfer</b></span>
						<a class="closeBtntx" onclick="closeMe_tx();">[X]</a>
				</div>

				<div class="cashTxDiv">
					<form id="transferForm" name="transferForm" method="get" class="transformcolor">               
                    <table>
                    <tbody class="hideborder hwepopuparea">
                    	<tr>
                    		<th colspan="3" style="text-align: center;">Transaction From Bank Account</th>
                    	</tr>
                        
                    	<tr>
                    		<th>
                            <span>Account Name</span>
                            </th>
                            <td>:</td>
                            <td><?php echo $accnt_rows['bank_account_name']; ?></td>
                        </tr>
                        
                   		<tr>
                    		<th>
                    			<span>Bank Account</span>
                            </th>
                            
                            <td>:</td>
                            <td><?php echo $accnt_rows['bank_account_number']; ?></td>
                            </tr>
                            <tr>
                           <th colspan="3" style="text-align: center;border-top: 1px solid #000; padding-top:4px;">				  							To Bank Account</th>
                   		</tr>
                        
                    	<tr>
                        
                    		<th><span>Account Name</span></th>
                    			<td>:</td>
                                
                                <td>
                                <select name="ibnkidto" style="width:250px;">
                                                                
                                <?php
								
									$tx_sql= "SELECT * FROM `bank_account`"; 
									$tx_res= mysqli_query($conn, $tx_sql);
									
									while($account_row= mysqli_fetch_assoc($tx_res))
									{
								?>
                                
                                <option value="<?php echo $account_row['id'];?>" "<?php if(isset($_GET['ibnkidto'])) echo 'selected'; ?>"><?php echo $account_row['bank_account_code']."-".$account_row['bank_account_name']."[".$account_row['bank_account_number']."]"; ?></option>                               
                                 <?php
									}
                                ?>
                                </select>
                                </td>
                                
                    	</tr>
                        
                    	<tr>
                        
                            <th><span>Amount</span></th>
                            <td>:</td>
                            <td><input type="number" name="famount" placeholder="0"></td>
                    	</tr>
                        
                    	<tr>
                        
                            <th>
                            <span>Remark</span>
                            </th>
                            <td>:</td>
                            <td><input type="text" name="sremark" placeholder="enter remark"></td>
                            
                    	</tr>
                        
                    	<tr>
                        
                            <th colspan="3" style="text-align:center;">
                            <input type="submit" value="Submit">&nbsp;
                            <input type="button" value="Cancel" class="closepopuptx">
                            </th>
                            
                    	</tr>
                        
                    </tbody>
                 </table>
                                  	
                        <input type="hidden" name="transferinaccount" id="savedepositamnt" value="<?php echo $accnt_rows['id'];?>">
                        <input type="hidden" name="itransactiontype" value="Transfer(+)">
                        <input type="hidden" name="itransactiontypeto" value="Transfer(-)">
                        <input type="hidden" name="ibnkid" value="<?php echo $accnt_rows['bank_id']; ?>">
                        <input type="hidden" name="loguser" value="<?php echo $user; ?>">
                        <input type="hidden" name="stype" value="Transfer">
                        
                  </form>
                  
             </div>
             
   		</div>
        
        		
        		<div class="popupDiv-overlay_other"></div>
        		<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -162.5px; margin-top: -96px;" class="popupDivother">
	
	<div class="topother">
	
		<span><b>Other</b></span>
		<a class="closeBtnother" onclick="closeMeother();">[X]</a>
	
	</div>
	
	<div class="otherDiv">
	
		<form id="otherForm" name="otherForm" method="get" class="transformcolor">
		
		<table>
			<tbody class="hideborder hwepopuparea">
				<tr>
					<th>
						<span>Account Name</span>	
					</th>
						<td>:</td>
						<td><?php echo $accnt_rows['bank_account_name']; ?></td>
				</tr>
				
				<tr>
				
					<th><span>Bank Account</span></th>					
						<td>:</td><td><?php echo $accnt_rows['bank_account_number']; ?></td>
						
				</tr>
			
				<tr>
					
					<th><span>Type</span></th>
						<td>:</td>
						<td>
							<input type="radio" name="itransactiontype" id="in" value="Other(+)">
							<label for="in" value="In">In</label>&nbsp;&nbsp;&nbsp;
							<input type="radio" name="itransactiontype" id="out" value="Other(-)">
							<label for="out">Out</label>
						</td>
				</tr>

				<tr>
				
					<th><span>Amount</span></th>
						<td>:</td>
						<td><input type="number" name="famount" placeholder="0"></td>
				</tr>
					
				<tr>
					<th><span>Remark</span></th>
						<td>:</td>
						<td><input type="text" name="sremark" placeholder="enter remark"></td>
				</tr>
				
				<tr>
					<td colspan="3" style="text-align:center;">
						<input type="submit" value="Submit">&nbsp;
						<input type="button" value="Cancel" class="closepopupother">
					</td>
				</tr>
	</tbody>
</table>
			<input type="hidden" name="ibnkid" value="<?php echo $accnt_rows['id']; ?>">
            <input type="hidden" name="loguser" value="<?php echo $user; ?>">
			<input type="hidden" name="stype" value="Other">
	</form>
	
	</div>
	</div>
	
        	</td>
    	</tr>            
             <?php
				$bnk++;
				}
				
				//echo $accountid1;
			?>             
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="4" style="text-align:right;background: #DCE9F9;">Total</td>
                    <td style="background: #DCE9F9;"><?php echo number_format($total, "2", ".", ",");?></td>
                    <td colspan="3" style="background: #DCE9F9;"></td>
                </tr>           
        </table>
    </div>
</div>
</body>
</html>
<script>
	
function openDiv(t){		
		jQuery(t).closest('tr').find('.popupDiv').show();	
		jQuery(t).closest('tr').find('.popupDiv-overlay').show();		
	}
	
	function closeMe(){
		jQuery('.closeBtn').click(function(){
			jQuery('.popupDiv').hide();		
			jQuery('.popupDiv-overlay').hide();		
		});
	}
	
	jQuery('.closepopup').click(function(){
		jQuery('.popupDiv').hide();
		jQuery('.popupDiv-overlay').hide();
	});		
	
	jQuery('form[name=cashin_form]').on('submit', function(){	
					
		jQuery.ajax({
			dataType:'json',		
			type: "post",
			data: jQuery(this).serialize(),
			success: function(ares){
				if(ares.result == 'success'){				
					window.location.reload();
				}
			}
		});
		
		return false;		
	});
	
	
	
	function cashoutopenDiv(t){
		jQuery(t).closest('tr').find('.popupDiv_hwe').show();	
		jQuery(t).closest('tr').find('.popupDiv-overlay_hwe').show();	
	}
	
	function closeMe_hwe(){
		jQuery('.closeBtn_hwe').click(function(){
			jQuery('.popupDiv_hwe').hide();		
			jQuery('.popupDiv-overlay_hwe').hide();		
		});
	}
	
	jQuery('.closepopup_hwe').click(function(){
		jQuery('.popupDiv_hwe').hide();
		jQuery('.popupDiv-overlay_hwe').hide();
	});
	
	jQuery('form[name=cashout_form]').on('submit', function(){	
				
		jQuery.ajax({
			dataType:'json',		
			type: "post",
			data: jQuery(this).serialize(),
			success: function(response){			
				if(response.result == 'success'){				
					window.location.reload();
				}
			}
		});
		
		return false;		
	});	
	
	function txopenDiv(t){
		jQuery(t).closest('tr').find('.txpopupDiv').show();	
		jQuery(t).closest('tr').find('.popupDiv-overlay_tx').show();
	}
	
	function closeMe_tx(){
		jQuery('.closeBtntx').click(function(){
			jQuery('.txpopupDiv').hide();		
			jQuery('.popupDiv-overlay_tx').hide();		
		});
	}
	
	jQuery('.closepopuptx').click(function(){
		jQuery('.txpopupDiv').hide();
		jQuery('.popupDiv-overlay_tx').hide();
	});
	
	jQuery("form[name='transferForm']").on('submit', function(){
		
		jQuery.ajax({
			dataType: 'json',
			type:"post",
			data: jQuery(this).serialize(),
			success: function(result){				
				if(result.result == "success"){
					window.location.reload();	
				}
			}
		});
		return false;	
	});
	
	function openDivother(t){
		jQuery(t).closest('tr').find('.popupDivother').show();	
		jQuery(t).closest('tr').find('.popupDiv-overlay_other').show();
	}	
	
	function closeMeother(){
		jQuery('.closeBtnother').click(function(){
			jQuery('.popupDivother').hide();		
			jQuery('.popupDiv-overlay_other').hide();		
		});
	}	
	
	jQuery('.closepopupother').click(function(){
		jQuery('.popupDivother').hide();
		jQuery('.popupDiv-overlay_other').hide();
	});
	
	jQuery("form[name='otherForm']").on('submit', function(){
		
		jQuery.ajax({
			dataType: 'json',
			type:"post",
			data: jQuery(this).serialize(),
			success: function(result){				
				if(result.result == "success"){
					window.location.reload();	
				}
			}
		});
		return false;	
	});
	
	
	$(document).ready(function(){
		$("#submit").click(function(){
			$(".resulttable").show();
		});
	});
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