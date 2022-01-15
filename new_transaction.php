<?php
session_start();



if(isset($_POST['exportreport'])){   
	include "config.php";    
		
	$transactionsql ="select * from transactions where 1=1 AND status='NewTransaction'";
							

			if(!empty($_POST['transaction_type']))
			{
				 $transaction_type = "'" . implode ( "', '", $_POST['transaction_type'] ) . "'";
				 $transactionsql.=" AND transactiontype IN($transaction_type)";
			}
			/*if(!empty($_POST['transaction_status']))
			{
				$transaction_status = "'" . implode ( "', '", $_POST['transaction_status'] ) . "'";
				$transactionsql.=" AND status IN($transaction_status)";
			}*/
			
			if((isset($_POST['fromdate']) && !empty($_POST['fromdate'])) || (isset($_POST['todate']) && !empty($_POST['todate'])))
			{
				$transactionsql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
			}

		
	$transactionsql .= "ORDER BY id DESC";
	$query=mysqli_query($conn, $transactionsql);		     
     
    // Output each row of the data, format line as csv and write to file pointer 
	if($query->num_rows > 0){
		
		$delimiter = ","; 
    	$filename = "Report_" . date('Y-m-d') . ".csv"; 
     
    	// Create a file pointer 
    	$f = fopen('php://memory', 'w'); 
     
    	// Set column headers 
    	$fields = array('No', 'Transaction Id', 'Transaction Type', 'Transfer Date', 'Username', 'User Code', 'Bank', 'Bank Code', 'Bank Account Name', 'Product Category', 'Promotion', 'Cash In', 'Cash Out', 'Remark', 'Status'); 
    fputcsv($f, $fields, $delimiter);
		
	$count=0;	
    while($rows_trans = $query->fetch_assoc()){
		//print_r($rows_trans);
		$transid= $rows_trans['id'];
		$transactiontype=$rows_trans['transactiontype'];
		$transferDate=$rows_trans['transferdate'].' '.$rows_trans['hours'].':'.$rows_trans['minutes'].':'.$rows_trans['seconds'];
		 
        $getaccount=mysqli_query($conn,'select username,usercode,id from account where id='.$rows_trans['accountid']);
		$getaccount = mysqli_fetch_assoc($getaccount);
		
		$username=$getaccount['username'];
		$usercode=$getaccount['usercode'];
		
		$get_bank = mysqli_query($conn,"select * from bank_account where id=".$rows_trans['bankid']);
		$get_bank=mysqli_fetch_assoc($get_bank);
		
		$productname =  mysqli_query($conn,"SELECT id,name from products where id=".$rows_trans['productid_from']);
		$productname = mysqli_fetch_assoc($productname);
		
		$promotion =  mysqli_query($conn,"SELECT name from promotion where id=".$rows_trans['bonus_promotion_id']);
		$promotion = mysqli_fetch_assoc($promotion);
			
		$cashin='';
		$cashout='';
		
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
		
		$bankid = $rows_trans['bankid'];		
		$getuserbank = mysqli_query($conn,"SELECT * from bank_account where id = '$bankid'");
		$getuserbank= mysqli_fetch_assoc($getuserbank);
		$db_bank_id = $getuserbank['bank_id'];
		$get_bank = mysqli_query($conn,"select * from bank where id='$db_bank_id'");
		$get_bank=mysqli_fetch_assoc($get_bank);
		
		if($rows_trans['transactiontype']=='Withdrawal'){
									  
									  
			$bankid = $rows_trans['bankid'];		
			$get_bank = mysqli_query($conn,"select * from bank where id='$bankid'");
			$get_bank=mysqli_fetch_assoc($get_bank);
			
			$withdrawal_bank_id = $rows_trans['withdrawal_bank_id'];		
			$getuserbank = mysqli_query($conn,"SELECT * from bank_account where id = '$withdrawal_bank_id'");
			$getuserbank= mysqli_fetch_assoc($getuserbank);
			
			$bank=$get_bank['short_name'];
			$userbankcode=$getuserbank['bank_account_code'];
			$useraccountnamenumber=$rows_trans['account_name'].'<br/>'. $rows_trans['bank_account_number'];;
		}
		
		else if($rows_trans['transactiontype']=='Deposit'){
		  
		  $bank=$getuserbank['bank_account_code'];
		  $userbankcode=$getuserbank['bank_account_code'];
		  $useraccountnamenumber=$getuserbank['bank_account_name'].'\n'. $getuserbank['bank_account_number'];
		  
		  }
		  else{
		 
		   $bank=$get_bank['short_name'];
		   $userbankcode=$getuserbank['bank_account_code'];
		   $useraccountnamenumber=$getuserbank['bank_account_name'].'\n'. $getuserbank['bank_account_number'];
		  
		  }
		  
		  $product_category=$productname['name'].'<br/>('.$productname['id'].')';
		  $promtion=$promotion['name'];				 
		  $remark=$rows_trans['remark'];
		
		$lineData=array(++$count, $transid, $transactiontype, $transferDate, $username, $usercode, $bank, $userbankcode, $useraccountnamenumber, $product_category, $promtion, $cashin, $cashout, $remark, 'New Transaction(accept)');
									 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
}
exit;
}
 
 
$_SESSION['page']='home';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$confirmdate = date('Y-m-d H:i:s');
$success = '';
$user=$_SESSION['user'];

$accept_trans_id = $_GET['accept_trans'];

$check_already_confirm_sql = "SELECT confirmed FROM transactions WHERE id = '$accept_trans_id'";
$check_already_confirm_query = mysqli_query($conn, $check_already_confirm_sql);
$check_already_confirm_row = mysqli_fetch_assoc($check_already_confirm_query);
$confirmed = $check_already_confirm_row['confirmed'];

if(isset($_GET['accept_trans']))
{
	if($confirmed == 0){
		$updateTrans_status=  "UPDATE transactions SET status='Approve', confrimedby='$user',confirmeddate='$confirmdate', confirmed = '1' where id='$accept_trans_id'";
	}
	else{
		$updateTrans_status=  "UPDATE transactions SET status='Approve', confrimedby='$user' where id='$accept_trans_id'";
	}
	
	if(mysqli_query($conn,$updateTrans_status)==TRUE)
	{
		$success = 'Transaction Approved';
	}
}


if(isset($_GET['transaction_id']))
{
	$delete_transaction ="Delete from transactions where id=".$_GET['transaction_id'];
	if(mysqli_query($conn,$delete_transaction)==TRUE)
	{
		$success = 'Transaction deleted successfully.';
	}
}

$search="";
$searchkey='';

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
	.resulttable
	{
		height:500px;
	}
	html, body {
	background: #dedede;
}

h2 strong {
	font-size: 16px;
}

legend {
	font-size: 14px;
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
	<a href="new_transaction.php" id="sc8_1" class="actives">New Transaction</a>
    <span>|</span>
   <!-- <a href="#" id="sc8_1">Online User</a>
    <span>|</span>
    <a href="#" id="sc8_1">VIP</a>
    <span>|</span>-->
    <a href="transaction_history.php" id="sc8_1">Transaction History</a>
     <span>|</span>
    <a href="transaction_report.php" id="sc8_1">Report</a>
</div><div class="container" >
  <div class="filternav">
	<h2>New Transaction</h2>
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
		<form method="post">
			<div class="form-group">
				<div class="col-md-2">
					<b>Transaction Type</b>
				</div>
				<div class="col-md-10">
					<?php 
					$transactiontypechecked=  array();
					if(!empty($_POST['transaction_type']))
					{
						$transactiontypechecked = $_POST['transaction_type'];
					}
					?>
				
					<input type="checkbox" name="" id="tranaction_type" value=""/> All
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter" <?php if(in_array('Deposit',$transactiontypechecked)){echo 'checked';}?> value="Deposit"/> Deposit
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter"  <?php if(in_array('Withdrawal',$transactiontypechecked)){echo 'checked';}?>  value="Withdrawal"/> Withdrawal
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter" <?php if(in_array('Transfer',$transactiontypechecked)){echo 'checked';}?>  value="Transfer"/> Transfer
					&nbsp;
					<input type="checkbox" name="transaction_type[]" class="tranaction_typefilter" <?php if(in_array('Bonus',$transactiontypechecked)){echo 'checked';}?>  value="Bonus"/> Bonus        
				</div>
			</div>
            <!--<div class="form-group">
				<div class="col-md-2">
					<b>Transaction Status</b>
				</div>
				<div class="col-md-10">
					<?php 
							$transactionstatuschecked=  array();
							if(!empty($_POST['transaction_status']))
							{
								$transactionstatuschecked = $_POST['transaction_status'];
							}
							?>
                            <input type="checkbox" name=""  id="tranaction_typeall_status"  value="All"/> All
                            &nbsp;
                            <input type="checkbox" name="transaction_status[]" <?php if(in_array('NewTransaction',$transactionstatuschecked)){echo 'checked';}?>  class="tranaction_statusfilter" value="NewTransaction"/>New Transaction
                            &nbsp;
                            <input type="checkbox" name="transaction_status[]" <?php if(in_array('Approve',$transactionstatuschecked)){echo 'checked';}?>  class="tranaction_statusfilter"  value="Approve"/> 	Approve 
                            &nbsp;
                            <input type="checkbox" name="transaction_status[]" <?php if(in_array('Reject',$transactionstatuschecked)){echo 'checked';}?>   class="tranaction_statusfilter" value="Reject"/> Reject
				</div>
			</div>-->
									
			<div>
				<input type="submit" class="btn btn-secondary" name="searchfilter" id="searchfilter" value="Search"/>
                <a href="add_transaction.php" class="btn btn-secondary">Add</a>
				<input type="submit" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
    </div>
    <br/>
    <br/>
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
                  <th class="col-md-3 col-xs-3">Bank Code</th>
                  <th class="col-md-3 col-xs-3">Bank Account Name</th>
                  <th class="col-md-3 col-xs-3">Product Category</th>
                  <th class="col-md-3 col-xs-3">Promotion</th>
                  <th class="col-md-3 col-xs-3">Cash In</th>
                  <th class="col-md-3 col-xs-3">Cash Out</th>
                  <th class="col-md-3 col-xs-3">Remark</th>
                <!--  <th class="col-md-3 col-xs-3">Receipt</th>-->
                  <th class="col-md-3 col-xs-3">Status</th>
                  <th class="col-md-3 col-xs-3">Action</th>
              	</tr>
            </thead>
            <tbody>
            <?php 
							$transactionsql ="select * from transactions where 1=1 AND status='NewTransaction'";
							
							if(isset($_POST['searchfilter']))
							{
								if(!empty($_POST['transaction_type']))
								{
									 $transaction_type = "'" . implode ( "', '", $_POST['transaction_type'] ) . "'";
									 $transactionsql.=" AND transactiontype IN($transaction_type)";
								}
								/*if(!empty($_POST['transaction_status']))
								{
									$transaction_status = "'" . implode ( "', '", $_POST['transaction_status'] ) . "'";
									$transactionsql.=" AND status IN($transaction_status)";
								}*/
								
								if((isset($_POST['fromdate']) && !empty($_POST['fromdate'])) || (isset($_POST['todate']) && !empty($_POST['todate'])))
								{
									$transactionsql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
								}
							}
							
							$transactionsql .= "ORDER BY id DESC";
							
							$get_transaction = mysqli_query($conn,$transactionsql);
							if(mysqli_num_rows($get_transaction)>0)
							{
								$count=1;
								while($rows_trans = mysqli_fetch_assoc($get_transaction))
								{
									$getaccount=mysqli_query($conn,'select username,usercode,id from account where id='.$rows_trans['accountid']);
									$getaccount = mysqli_fetch_assoc($getaccount);
									
									$get_bank = mysqli_query($conn,"select * from bank_account where id=".$rows_trans['bankid']);
									$get_bank=mysqli_fetch_assoc($get_bank);
									
									$productname =  mysqli_query($conn,"SELECT id,name from products where id=".$rows_trans['productid_from']);
									$productname = mysqli_fetch_assoc($productname);
									
									$promotion =  mysqli_query($conn,"SELECT name from promotion where id=".$rows_trans['bonus_promotion_id']);
									$promotion = mysqli_fetch_assoc($promotion);
										
									$cashin='';
									$cashout='';
									
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
									
									$bankid = $rows_trans['bankid'];		
									$getuserbank = mysqli_query($conn,"SELECT * from bank_account where id = '$bankid'");
									$getuserbank= mysqli_fetch_assoc($getuserbank);
									$db_bank_id = $getuserbank['bank_id'];
									$get_bank = mysqli_query($conn,"select * from bank where id='$db_bank_id'");
									$get_bank=mysqli_fetch_assoc($get_bank);
								?>
                                <tr>
                                  <td  style="<?php echo $style;?>"><?php echo $count++;?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $rows_trans['id'];?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $rows_trans['transactiontype'];?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $rows_trans['transferdate'].' '.$rows_trans['hours'].':'.$rows_trans['minutes'].':'.$rows_trans['seconds'];?></td>
                                  <td  style="<?php echo $style;?>"><a style="text-decoration: underline;color:#0055ff;" href="add_account.php?id=<?php echo $getaccount['id']; ?>"><?php echo $getaccount['username'];?></a></td>
                                  <td  style="<?php echo $style;?>"><?php echo $getaccount['usercode'];?></td>
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
                                  
                                  <td  style="<?php echo $style;?>"><?php echo $productname['name'].'<br/>('.$productname['id'].')';?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $promotion['name'];?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $cashin;?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $cashout;?></td>
                                  <td  style="<?php echo $style;?>"><?php echo $rows_trans['remark'];?></td>
                                 <!-- <td></td>-->
                                  <!--<td><?php echo $rows_trans['status'];?></td>-->
                                  <td>New Transaction(<a href="?accept_trans=<?php echo $rows_trans['id'];?>" onclick="return confirm('Are you sure you want to accept?');" style="color:blue;">Accept</a>)</td>
                                  <td><a href="new_transactionedit.php?edit_id=<?php echo $rows_trans['id'];?>"><i class="fa fa-search ml-2"></i></a> &nbsp;
                                  
                                  <a href="?transaction_id=<?php echo $rows_trans['id'];?>" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash ml-2"></i></a></td>
                                </tr>
                                
                                 <?php
								}
							}
							?>
            	<!--<tr>
                  <td>1</td>
                  <td>025050</td>
				  <td>Transfer</td>
                  <td>2021-11-17 06:05:12 </td>
                  <td>NEWTOWN</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Unclaimed MEGA888</td>
                  <td></td>
                  <td>40.00</td>
                  <td>40.00</td>
                  <td></td>
                  <td></td>
                  <td>New Transaction (Accept)</td>
                  <td><i class="fa fa-search ml-2"></i> &nbsp; <i class="fa fa-envelope ml-2"></i> &nbsp; <i class="fa fa-trash ml-2"></i></td>
              	</tr>
                <tr>
                  <td>2</td>
                  <td>025023</td>
				  <td>Transfer</td>
                  <td>2021-11-16 06:05:12 </td>
                  <td>NEWTOWN</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Unclaimed MEGA888</td>
                  <td></td>
                  <td>40.00</td>
                  <td>40.00</td>
                  <td></td>
                  <td></td>
                  <td>New Transaction (Accept)</td>
                  <td><i class="fa fa-search ml-2"></i> &nbsp; <i class="fa fa-envelope ml-2"></i> &nbsp; <i class="fa fa-trash ml-2"></i></td>
              	</tr>-->
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<script>
/*localStorage.setItem('countdown', 5);
var countdown = localStorage.getItem('countdown');
$("#searchfilter").val('Search ('+countdown+')');
localStorage.setItem('countdown',--countdown);	
setInterval(function(){
	var countdown = localStorage.getItem('countdown');
	$("#searchfilter").val('Search ('+countdown+')');	
	localStorage.setItem('countdown',--countdown);
	if(countdown==0)
	{
		location.reload();		
	}
},1000);
*/
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