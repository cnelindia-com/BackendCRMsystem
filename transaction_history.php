<?php
session_start();

$_SESSION['page']='home';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
$success = '';
$user=$_SESSION['user'];
if(isset($_GET['transaction_id']))
{
	$delete_transaction ="Delete from transactions where id=".$_GET['transaction_id'];
	if(mysqli_query($conn,$delete_transaction)==TRUE)
	{
		$success = 'Transaction deleted successfully.';
	}
}
/*$search="";
$searchkey='';
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

$csv_data[] = array("No", "Username", "User Code", "Full Name", "Email", "Phone", "IP", "Registered On", "Last Active", "Status");*/
$search_status = '';
if(isset($_GET['transaction_status']))
{
	$search_status=$_GET['transaction_status'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

     <!-- <script>

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
     
      </script>-->

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
	}
	.form-group
	{
		display: flex;
	}
	.txt_sp3 a
	{
		color:#007bff;
	}
	.resulttable
	{
		height:500px;
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
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
</head>
<body>

<div id="sc8" class="tabcontent" style="display: block;">
	<a href="new_transaction.php" id="sc8_1">New Transaction</a>
    <span>|</span>
   <!-- <a href="#" id="sc8_1">Online User</a>
    <span>|</span>
    <a href="#" id="sc8_1">VIP</a>
    <span>|</span>-->
    <a href="transaction_history.php" id="sc8_1" class="actives">Transaction History</a>
     <span>|</span>
    <a href="transaction_report.php" id="sc8_1">Report</a>
</div><div class="container" >
  <div class="filternav">
	<h2>Transaction</h2>
      <?php 
	if(!empty($success))
	{
	?>
	<div class="row">
    	<div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="alert alert-success" role="alert" style="text-align: center;">
              <?php echo $success;?>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
	<?php
	}
	?>
		<form method="get">
        	<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10" style="padding-left: 0;">
							<?php 
							$fromdatesearch = '';
							$todatesearch = '';
							if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) || (isset($_GET['todate']) && !empty($_GET['todate'])))
							{
								$fromdatesearch = $_GET['fromdate'];
								$todatesearch = $_GET['todate'];
							}
							?>
							<div class="col-md-6">
								<div class="input-group date form_datetime from_datetime" data-date="<?php  echo date("Y-m-d H:i:s"); ?>" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="fromdate" style="width: 170px;float: left;">
									<input size="16" type="text" value="<?php echo $fromdatesearch;?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar" style="color: #000;"></span></span>
								</div>
								<input type="hidden" id="fromdate" name="fromdate" value="<?php echo $fromdatesearch;?>" />
								
								<div style="float:left;margin-right: 11px;">~</div>
								<div class="input-group date form_datetime to_datetime" data-date="<?php  echo date("Y-m-d H:i:s"); ?>" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="todate" style="width: 170px;float: left;">
									<input size="16" type="text" value="<?php echo $todatesearch;?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar" style="color: #000;"></span></span>
								</div>
								<input type="hidden" id="todate" name="todate" value="<?php echo $todatesearch;?>" />
							</div>
                         
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
            
            <div class="form-group">
				<div class="col-md-2">
					<b>Transaction Id</b>
				</div>
				<div class="col-md-10">
					<input type="text" name="starttransactionid" value="<?php if(isset($_GET['starttransactionid'])){ echo $_GET['starttransactionid']; } ?>"/> ~
                    <input type="text" name="endtransactionid" value="<?php if(isset($_GET['endtransactionid'])){ echo $_GET['endtransactionid']; } ?>"/>                   
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-2">
					<b>Username / User Code</b>
				</div>
				<div class="col-md-10">
					<input type="text" name="username_usercode" value="<?php if(isset($_GET['username_usercode'])){ echo $_GET['username_usercode']; }?>"/>                  
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-2">
					<b>Bank / Code / Bank Account</b>
				</div>
				<div class="col-md-10">
					<input type="text" name="Bank_Account" value="<?php if(isset($_GET['Bank_Account'])){ echo $_GET['Bank_Account']; }?>"/>                  
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-2">
					<b>Status</b>
				</div>
				<div class="col-md-10">
					<select name="transaction_status">
                    	<option value="">All</option>
                        <option value="Approve" <?php if($search_status=='Approve'){echo 'selected';}?>>Approve</option>
                        <option value="Reject" <?php if($search_status=='Reject'){echo 'selected';}?>>Reject</option>
                    </select>                
				</div>
			</div>
            
			<div class="form-group">
				<div class="col-md-2">
					<b>Transaction Type</b>
				</div>
				<div class="col-md-10">
					<?php 
					$all_transtype_checked = '';
					$deposit_transtype_checked = '';
					$withdrawal_transtype_checked = '';
					$transfer_transtype_checked = '';
					$bonus_transtype_checked = '';
										
					if(isset($_GET['transaction_type'])){
						
						if(in_array('Deposit', $_GET['transaction_type'])){
							$deposit_transtype_checked = 'checked="checked"';							
						}
						if(in_array('Withdrawal', $_GET['transaction_type'])){
							$withdrawal_transtype_checked = 'checked="checked"';
						}
						if(in_array('Transfer', $_GET['transaction_type'])){
							$transfer_transtype_checked = 'checked="checked"';
						}
						if(in_array('Bonus', $_GET['transaction_type'])){
							$bonus_transtype_checked = 'checked="checked"';
						}
						
						if(in_array('Deposit', $_GET['transaction_type']) && in_array('Withdrawal', $_GET['transaction_type']) && in_array('Transfer', $_GET['transaction_type']) && in_array('Bonus', $_GET['transaction_type'])){
							$all_transtype_checked = 'checked="checked"';
						}
					}
					else{
						$all_transtype_checked = 'checked="checked"';
						$deposit_transtype_checked = 'checked="checked"';
						$withdrawal_transtype_checked = 'checked="checked"';
						$transfer_transtype_checked = 'checked="checked"';
						$bonus_transtype_checked = 'checked="checked"';
					}
					?>
				
					<input type="checkbox" name="" id="tranaction_type" value="all" <?php echo $all_transtype_checked; ?> /> All
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter" value="Deposit" <?php echo $deposit_transtype_checked; ?>/> Deposit
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter"  value="Withdrawal" <?php echo $withdrawal_transtype_checked; ?>/> Withdrawal
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter" value="Transfer" <?php echo $transfer_transtype_checked; ?>/> Transfer
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter" value="Bonus" <?php echo $bonus_transtype_checked; ?>/> Bonus                           
				</div>
			</div>
            
            <!--<div class="form-group">
				<div class="col-md-2">
					<b>Transaction From</b>
				</div>
				<div class="col-md-10">
					<input type="checkbox" name="transaction_type" value="yes"/> Apps transaction only            
				</div>
			</div>-->
           									
			<div>
				<input type="submit" class="btn btn-secondary" name="searchfilter" id="searchfilter" value="Submit"/>
				<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
    </div>
    <br/>
    <br/>
    <?php echo $_POST['fromdate'];?>
    <div class="resulttable" style="overflow: scroll;">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                  <th>No</th>
                  <th class="col-md-3 col-xs-3">Transaction Id</th>
                  <th class="col-md-3 col-xs-3">Transaction Type</th>
                  <th class="col-md-3 col-xs-3">Transfer Date</th>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Bank</th>
                  <th class="col-md-3 col-xs-3">Code</th>
                  <th class="col-md-3 col-xs-3">Bank Account Name</th>
                  <th class="col-md-3 col-xs-3">Product Category</th>
                  <th class="col-md-3 col-xs-3">Promotion</th>
                  <th class="col-md-3 col-xs-3">Cash In</th>
                  <th class="col-md-3 col-xs-3">Cash Out</th>
                  <th class="col-md-3 col-xs-3">Remark</th>
                  <!--<th class="col-md-3 col-xs-3">Receipt</th>-->
                  <th class="col-md-3 col-xs-3">Status</th>
                  <th class="col-md-3 col-xs-3">Action</th>
              	</tr>
            </thead>
            <tbody>
            <?php 						
			
			$transactionsql = "select *, CONCAT(transferdate,' ',hours,':',minutes,':',seconds) as tdate from transactions where 1=1 AND status!='NewTransaction'";
			
			if(isset($_GET['searchfilter']))
			{
				if(!empty($_GET['transaction_type']))
				{
					 $transaction_type = "'" . implode ( "', '", $_GET['transaction_type'] ) . "'";
					 $transactionsql.=" AND transactiontype IN($transaction_type)";
				}
				if(!empty($_GET['transaction_status']))
				{				
					//$transaction_status = "'" . implode ( "', '", $_GET['transaction_status'] ) . "'";
					$transaction_status = "'".$_GET['transaction_status']."'";
					$transactionsql.=" AND status IN($transaction_status)";
				}
				
				if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) || (isset($_GET['todate']) && !empty($_GET['todate'])))
				{
					$transactionsql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_GET['fromdate']."' AND '".$_GET['todate']."'";
				}
				
				if(isset($_GET['starttransactionid']) && !empty($_GET['starttransactionid'])){ 
					$starttransactionid = $_GET['starttransactionid']; 
					$transactionsql.= " AND id >= $starttransactionid";
				} 
				
				if(isset($_GET['endtransactionid']) && !empty($_GET['endtransactionid'])){ 
					$endtransactionid = $_GET['endtransactionid']; 
					$transactionsql.= " AND id <= $endtransactionid";
				} 
				
				if(isset($_GET['username_usercode']) && !empty($_GET['username_usercode'])){
					$username_usercode = $_GET['username_usercode'];
					$transactionsql.= " AND accountid IN(SELECT id FROM account WHERE username LIKE '%$username_usercode%' OR usercode LIKE '%$username_usercode%')";
				}
				//echo $transactionsql;
				
				if(isset($_GET['Bank_Account']) && !empty($_GET['Bank_Account'])){
					$Bank_Account = $_GET['Bank_Account'];
					$transactionsql.= " AND (bankid IN(SELECT id FROM bank_account WHERE bank_account_name LIKE '%$Bank_Account%' OR bank_account_number LIKE '%$Bank_Account%' OR bank_account_code LIKE '%$Bank_Account%') OR bankid IN(SELECT id FROM bank WHERE name LIKE '%$Bank_Account%' or short_name LIKE '%$Bank_Account%') OR account_name LIKE '%$Bank_Account%' OR bank_account_number LIKE '%$Bank_Account%')";
				}	
				
			}
			else{
				
				if(!empty($_GET['transaction_type']))
				{
					 $transaction_type = "'" . implode ( "', '", $_GET['transaction_type'] ) . "'";
					 $transactionsql.=" AND transactiontype IN($transaction_type)";
				}
				if(!empty($_GET['transaction_status']))
				{
					//$transaction_status = "'" . implode ( "', '", $_GET['transaction_status'] ) . "'";
					$transaction_status = "'".$_GET['transaction_status']."'";
					$transactionsql.=" AND status IN($transaction_status)";
				}
				
				if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) || (isset($_GET['todate']) && !empty($_GET['todate'])))
				{
					$transactionsql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_GET['fromdate']."' AND '".$_GET['todate']."'";
				}
				
				if(isset($_GET['starttransactionid']) && !empty($_GET['starttransactionid'])){ 
					$starttransactionid = $_GET['starttransactionid']; 
					$transactionsql.= " AND id >= $starttransactionid";
				} 
				
				if(isset($_GET['endtransactionid']) && !empty($_GET['endtransactionid'])){ 
					$endtransactionid = $_GET['endtransactionid']; 
					$transactionsql.= " AND id <= $endtransactionid";
				} 
				
				if(isset($_GET['username_usercode']) && !empty($_GET['username_usercode'])){
					$username_usercode = $_GET['username_usercode'];
					$transactionsql.= " AND accountid IN(SELECT id FROM account WHERE username LIKE '%$username_usercode%' OR usercode LIKE '%$username_usercode%')";
				}
				//echo $transactionsql;
				
				if(isset($_GET['Bank_Account']) && !empty($_GET['Bank_Account'])){
					$Bank_Account = $_GET['Bank_Account'];
					$transactionsql.= " AND (bankid IN(SELECT id FROM bank_account WHERE bank_account_name LIKE '%$Bank_Account%' OR bank_account_number LIKE '%$Bank_Account%' OR bank_account_code LIKE '%$Bank_Account%') OR bankid IN(SELECT id FROM bank WHERE name LIKE '%$Bank_Account%' or short_name LIKE '%$Bank_Account%') OR account_name LIKE '%$Bank_Account%' OR bank_account_number LIKE '%$Bank_Account%')";
				}				
				
			}

			$transactionsql .= " ORDER BY tdate DESC";
			$totalcashin = 0;
			$totalcashout = 0;
		
			$get_transaction = mysqli_query($conn,$transactionsql);
			if(mysqli_num_rows($get_transaction)>0)
			{
				$count=1;
				while($rows_trans = mysqli_fetch_assoc($get_transaction))
				{
					$getaccount=mysqli_query($conn,'select username,usercode,id from account where id='.$rows_trans['accountid']);
					$getaccount = mysqli_fetch_assoc($getaccount);
					
					$get_bank = mysqli_query($conn,"select * from bank where id=".$rows_trans['bankid']);
					$get_bank=mysqli_fetch_assoc($get_bank);
					
					$productname =  mysqli_query($conn,"SELECT id,name from products where id=".$rows_trans['productid_from']);
					$productname = mysqli_fetch_assoc($productname);
					
					$promotion =  mysqli_query($conn,"SELECT name from promotion where id=".$rows_trans['bonus_promotion_id']);
					$promotion = mysqli_fetch_assoc($promotion);
					 
					$bankid = $rows_trans['bankid'];		
					$getuserbank = mysqli_query($conn,"SELECT * from bank_account where id = '$bankid'");
					$getuserbank= mysqli_fetch_assoc($getuserbank);
					$db_bank_id = $getuserbank['bank_id'];
					$get_bank = mysqli_query($conn,"select * from bank where id='$db_bank_id'");
					$get_bank=mysqli_fetch_assoc($get_bank);
					
					$cashin=0;
					$cashout=0;
					
					if($rows_trans['transactiontype']=='Deposit' || $rows_trans['transactiontype']=='Bonus' || $rows_trans['transactiontype']=='Transfer')
					{
						$cashin=$rows_trans['amount'];
					}
					if($rows_trans['transactiontype']=='Withdrawal' || $rows_trans['transactiontype']=='Transfer')
					{
						$cashout=$rows_trans['amount'];
					}
					$style= '';
									
					if($rows_trans['transactiontype']=='Withdrawal')
					{
						$style= 'background: #FFCCCC;';
					}
					if($rows_trans['status']=="Approve")
					{
						$totalcashin += $cashin;
						$totalcashout +=$cashout;
					}
				?>
				<tr>
				  <td style="<?php echo $style;?>"><?php echo $count++;?></td>
				  <td style="<?php echo $style;?>"><?php echo $rows_trans['id'];?></td>
				  <td style="<?php echo $style;?>"><?php echo $rows_trans['transactiontype'];?></td>
				  <td style="<?php echo $style;?>"><?php echo $rows_trans['transferdate'].' '.$rows_trans['hours'].':'.$rows_trans['minutes'].':'.$rows_trans['seconds'];?></td>
				  <td style="<?php echo $style;?>"><a style="text-decoration: underline;color:#0055ff;" href="add_account.php?id=<?php echo $getaccount['id']; ?>"><?php echo strtoupper($getaccount['username']);?></a></td>
				  <td style="<?php echo $style;?>"><?php echo $getaccount['usercode'];?></td>
				  <?php
				  if($rows_trans['transactiontype']=='Withdrawal'){
					  
					  
					$bankid = $rows_trans['bankid'];		
					$get_bank = mysqli_query($conn,"select * from bank where id='$bankid'");
					$get_bank=mysqli_fetch_assoc($get_bank);
					
					$withdrawal_bank_id = $rows_trans['withdrawal_bank_id'];		
					$getuserbank = mysqli_query($conn,"SELECT * from bank_account where id = '$withdrawal_bank_id'");
					$getuserbank= mysqli_fetch_assoc($getuserbank);
					
				  ?>
				  <td style="<?php echo $style;?>"><?php echo $get_bank['short_name'];?></td>
				  <td style="<?php echo $style;?>"><?php echo $getuserbank['bank_account_code']; ?></td>
				  <td style="<?php echo $style;?>"><?php echo $rows_trans['account_name'].'<br/>'. $rows_trans['bank_account_number'];?></td>
				  <?php
				  }
				  else if($rows_trans['transactiontype']=='Deposit'){
				  ?>
				  <td style="<?php echo $style;?>"><?php echo $getuserbank['bank_account_code'];?></td>
				  <td style="<?php echo $style;?>"><?php echo $getuserbank['bank_account_code']; ?></td>
				  <td style="<?php echo $style;?>"><?php echo $getuserbank['bank_account_name'].'<br/>'. $getuserbank['bank_account_number'];?></td>
				  <?php
				  }
				  else{
				  ?>
				  <td style="<?php echo $style;?>"><?php echo $get_bank['short_name'];?></td>
				  <td style="<?php echo $style;?>"><?php echo $getuserbank['bank_account_code']; ?></td>
				  <td style="<?php echo $style;?>"><?php echo $getuserbank['bank_account_name'].'<br/>'. $getuserbank['bank_account_number'];?></td>
				  <?php
				  }
				  ?>
                  
				  <td style="<?php echo $style;?>">
				  <?php
				  if($rows_trans['transactiontype']=='Transfer'){
					  
					  $account_id = $rows_trans['accountid'];
					  $acc_sql = "SELECT productIDS FROM account WHERE id = '$account_id'";
					  $acc_query = mysqli_query($conn, $acc_sql);
					  $acc_row = mysqli_fetch_assoc($acc_query);
					  $productIDS_json = $acc_row['productIDS'];
					  $productIDS = json_decode($productIDS_json, true);
					  
					  
					  
					  
					  $productid_from_id = $rows_trans['productid_from'];
					  $productid_to_id = $rows_trans['productid_to'];
					  
					  $sqlp1 = "SELECT * FROM products WHERE id = '$productid_from_id'";
					  $queryp1 = mysqli_query($conn, $sqlp1);
					  $rowp1 = mysqli_fetch_assoc($queryp1);
						
					  $sqlp2 = "SELECT * FROM products WHERE id = '$productid_to_id'";
					  $queryp2 = mysqli_query($conn, $sqlp2);
					  $rowp2 = mysqli_fetch_assoc($queryp2);
					  
					  $from_product_customer_pid_html = '';
					  $to_product_customer_pid_html = '';
					  if(isset($productIDS[$productid_from_id]) && !empty($productIDS[$productid_from_id])){
						  $from_product_customer_pid = $productIDS[$productid_from_id];
						  $from_product_customer_pid_html = '<br>('.$from_product_customer_pid.')';
					  }
					  
					  if(isset($productIDS[$productid_to_id]) && !empty($productIDS[$productid_to_id])){
						  $to_product_customer_pid = $productIDS[$productid_to_id];
						  
						  $to_product_customer_pid_html = '<br>('.$to_product_customer_pid.')';
					  }
					  
					  
					  
					echo '<span style="white-space:nowrap;color: #000;">'.$rowp1['name'].$from_product_customer_pid_html.'<div class="arrow-down"><i class="fa fa-caret-down" style="font-size:24px"></i></div>'.$rowp2['name'].$to_product_customer_pid_html.'</span>';
				  }
				  else{
					  
					  $account_id = $rows_trans['accountid'];
					  $acc_sql = "SELECT productIDS FROM account WHERE id = '$account_id'";
					  $acc_query = mysqli_query($conn, $acc_sql);
					  $acc_row = mysqli_fetch_assoc($acc_query);
					  $productIDS_json = $acc_row['productIDS'];
					  $productIDS = json_decode($productIDS_json, true);
					  
					  $product_id = $productname['id'];
					  $sqlp1 = "SELECT * FROM products WHERE id = '$product_id'";
					  $queryp1 = mysqli_query($conn, $sqlp1);
					  $rowp1 = mysqli_fetch_assoc($queryp1);
					  
					  $from_product_customer_pid_html = '';
				
					  if(isset($productIDS[$product_id]) && !empty($productIDS[$product_id])){
						  $from_product_customer_pid = $productIDS[$product_id];
						  $from_product_customer_pid_html = '<br>('.$from_product_customer_pid.')';
					  }
					  
			
					  
					echo $productname['name'].$from_product_customer_pid_html;
				  }
				  ?>
			      </td>
				  <td style="<?php echo $style;?>"><?php echo $promotion['name'];?></td>
				  <td style="<?php echo $style;?>"><?php echo $cashin;?></td>
				  <td style="<?php echo $style;?>"><?php echo $cashout;?></td>
				  <td style="<?php echo $style;?>"><?php echo $rows_trans['remark'];?></td>
				 <!-- <td><?php echo $rows_trans['status'];?></td>-->
                 <?php 
				if($rows_trans['status']=="Approve")
				{
				?>
				<td style="background: #C6FFD9;text-align: center;"><?php echo $rows_trans['status'];?></td>  
				<?php
				}
				else if($rows_trans['status']=="Reject")
				{
				?>  
				<td style="background: #FFCCCC;text-align: center;"><?php echo $rows_trans['status'];?></td>    
				<?php
				}                  
				?>
				  <td><a href="approve_reject_transaction.php?edit_id=<?php echo $rows_trans['id'];?>"><i class="fa fa-search ml-2"></i></a> &nbsp;
                                  
                      <a href="?transaction_id=<?php echo $rows_trans['id'];?>" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash ml-2"></i></a>
				</tr>
				
				 <?php
				}
			}
			?>
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="11" style="text-align:right;">Total</td>
                    <td><? echo number_format($totalcashin,'2','.',',');?></td>
                    <td><? echo number_format($totalcashout,'2','.',',');?></td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
</div>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	
	function populateDate(fromdate,todate)
	{
		$("#fromdate").val(fromdate+' 00:00:00');
		$(".from_datetime").find('input').val(fromdate+' 00:00:00');	
		$("#todate").val(todate+' 23:59:59');		
		$(".to_datetime").find('input').val(todate+' 23:59:59');	
	}
	function cleardate()
	{
		$("#fromdate").val('');	
		$("#todate").val('');
		$(".from_datetime").find('input').val('');		
		$(".to_datetime").find('input').val('');
	}
	$('#tranaction_type').click(function() {
		if ($(this).is(':checked')) {
			$('.tranaction_typefilter').prop('checked', true);
		} else {
			$('.tranaction_typefilter').prop('checked', false);
		}
	});
	
	$('#tranaction_typeall_status').click(function() {
		if ($(this).is(':checked')) {
			$('.tranaction_statusfilter').prop('checked', true);
		} else {
			$('.tranaction_statusfilter').prop('checked', false);
		}
	});	
</script>
</body>
</html>