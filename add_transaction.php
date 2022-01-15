<?php
session_start();


$_SESSION['page']='home';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
$success = '';
$user=$_SESSION['user'];
/*$search="";
$searchkey='';
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

$csv_data[] = array("No", "Username", "User Code", "Full Name", "Email", "Phone", "IP", "Registered On", "Last Active", "Status");*/

if(isset($_POST['add_new_transaction']))
{
	if($_POST['newtransaction_type']=='Deposit')
	{

		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = (isset($_POST['edit_account_id_deposit']))?$_POST['edit_account_id_deposit']:'';
		$Transfer_Date_deposit = (isset($_POST['Transfer_Date_deposit']))?$_POST['Transfer_Date_deposit']:'';
		$hours_deposit = (isset($_POST['hours_deposit']))?$_POST['hours_deposit']:'';
		$minutes_deposit = (isset($_POST['minutes_deposit']))?$_POST['minutes_deposit']:'';
		$seconds_deposit = (isset($_POST['seconds_deposit']))?$_POST['seconds_deposit']:'';
		$Amount_deposit =(isset($_POST['Amount_deposit']))?$_POST['Amount_deposit']:'';
		$payment_method_deposit = (isset($_POST['payment_method_deposit']))?$_POST['payment_method_deposit']:'';
		$product_deposit = (isset($_POST['product_deposit']))?$_POST['product_deposit']:'';
		$BankAccount_deposit = (isset($_POST['BankAccount_deposit']))?$_POST['BankAccount_deposit']:'';
		$Reference_deposit = (isset($_POST['Reference_deposit']))?$_POST['Reference_deposit']:'';
		$Instant_transaction_deposit = (isset($_POST['Instant_transaction_deposit'])) ? $_POST['Instant_transaction_deposit'] : '';
		
		//bonus transaction
		$bonus_transaction_deposit = (isset($_POST['bonus_transaction_deposit'])) ? $_POST['bonus_transaction_deposit']:'';
		$bonus_amount_deposit = (isset($_POST['bonus_amount_deposit'])) ? $_POST['bonus_amount_deposit']:'';
		$Banktype_deposit = (isset($_POST['Banktype_deposit'])) ? $_POST['Banktype_deposit'] : '';	
		
		
		$Instant_transaction_deposit =(isset($_POST['Instant_transaction_deposit']))?$_POST['Instant_transaction_deposit']:'';
		
		$remark_deposit = (isset($_POST['remark_deposit']))?$_POST['remark_deposit']:'';
		
		if(isset($_POST['Instant_transaction_deposit']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
		$insertdeposit = "INSERT INTO transactions SET
			`accountid`=$account_id,
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$Transfer_Date_deposit',
			`hours`=$hours_deposit,
			`minutes`=$minutes_deposit,
			`seconds`=$seconds_deposit,
			`amount`='$Amount_deposit',
			`payment_method`='$payment_method_deposit',
			`productid_from`=$product_deposit,
			`bankid`=$BankAccount_deposit,
			`reference_no`='$Reference_deposit',
			`bonus_amount`='$bonus_amount_deposit',
			`instant_transaction`='$Instant_transaction_deposit',
			`account_name`='',
			`bank_account_number`='',
			`withdrawal_bank_id`='',
			`productid_to`='',
			`deposit_transaction_id`='',
			`remark`='$remark_deposit',
			`status`='$status'
		";
		if(mysqli_query($conn,$insertdeposit)==TRUE)
		{
			$deposit_transaction_id = mysqli_insert_id($conn);
			if($bonus_transaction_deposit == 'Bonus'){
				$insert_bonus_transaction_for_deposit_sql = "INSERT INTO transactions SET `transactiontype` = 'Bonus', `accountid` = '$account_id', `createdby` = '$user', `transferdate` = '$Transfer_Date_deposit', `hours`= '$hours_deposit', `minutes` = '$minutes_deposit', `seconds` = '$seconds_deposit', `amount` = '$bonus_amount_deposit', `productid_from` = '$product_deposit', `instant_transaction` = '$Instant_transaction_deposit', deposit_transaction_id = '$deposit_transaction_id', `bonus_promotion_id` = '$Banktype_deposit', `status`='$status'";
				mysqli_query($conn, $insert_bonus_transaction_for_deposit_sql);
				$bonus_transaction_id = mysqli_insert_id($conn);
				
				$update_t_sql = "UPDATE transactions SET bonus_promotion_id = '$bonus_transaction_id' WHERE id = '$deposit_transaction_id'";
				mysqli_query($conn, $update_t_sql);
			}
			
			$success = 'Deposit Transaction added successfully.';
		}
	}
	if($_POST['newtransaction_type']=='Withdrawal')
	{
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = (isset($_POST['edit_account_id_Withdrawal']))?$_POST['edit_account_id_Withdrawal']:'';
		$Transfer_DateWithdrawal = (isset($_POST['Transfer_DateWithdrawal']))?$_POST['Transfer_DateWithdrawal']:'';
		$hoursWithdrawal = (isset($_POST['hoursWithdrawal']))?$_POST['hoursWithdrawal']:'';
		$minutesWithdrawal = (isset($_POST['minutesWithdrawal']))?$_POST['minutesWithdrawal']:'';
		$secondsWithdrawal = (isset($_POST['secondsWithdrawal']))?$_POST['secondsWithdrawal']:'';
		$AmountWithdrawal =(isset( $_POST['AmountWithdrawal']))?$_POST['AmountWithdrawal']:'';
		$payment_methodWithdrawal = (isset($_POST['payment_methodWithdrawal']))?$_POST['payment_methodWithdrawal']:'';
		$productWithdrawal = (isset($_POST['productWithdrawal']))?$_POST['productWithdrawal']:'';
		$BankAccountWithdrawal = (isset($_POST['BankAccountWithdrawal']))?$_POST['BankAccountWithdrawal']:'';
		$bankaccoutnumberWithdrawal = (isset($_POST['bankaccoutnumberWithdrawal']))?$_POST['bankaccoutnumberWithdrawal']:'';
		$ReferenceWithdrawal = (isset($_POST['ReferenceWithdrawal']))?$_POST['ReferenceWithdrawal']:'';
		
		$Instant_transactionWithdrawal = (isset($_POST['Instant_transactionWithdrawal']))?$_POST['Instant_transactionWithdrawal']:'';
		
		$remarkWithdrawal = (isset($_POST['remarkWithdrawal']))?$_POST['remarkWithdrawal']:'';
		$withdrawalaccountWithdrawal = (isset($_POST['withdrawalaccountWithdrawal']))?$_POST['withdrawalaccountWithdrawal']:'';
		$account_name = (isset($_POST['account_name']))?$_POST['account_name']:'';
		
		if(isset($_POST['Instant_transactionWithdrawal']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
	 	$insertWithdrawal = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$Transfer_DateWithdrawal',
			`hours`=$hoursWithdrawal,
			`minutes`=$minutesWithdrawal,
			`seconds`=$secondsWithdrawal,
			`amount`='$AmountWithdrawal',
			`payment_method`='$payment_methodWithdrawal',
			`productid_from`='$productWithdrawal',
			`bankid`='$BankAccountWithdrawal',
			`reference_no`='$ReferenceWithdrawal',
			`bonus_promotion_id`='',
			`bonus_amount`='',
			`instant_transaction`='$Instant_transactionWithdrawal',
			`account_name`='$account_name',
			`bank_account_number`='$bankaccoutnumberWithdrawal',
			`withdrawal_bank_id`='$withdrawalaccountWithdrawal',
			`productid_to`='',
			`deposit_transaction_id`='',
			`remark`='$remarkWithdrawal',
			`status`='$status'
		";
		if(mysqli_query($conn,$insertWithdrawal)==TRUE)
		{
			$success = 'Withdrawal Transaction added successfully.';
		}
	}	
	if($_POST['newtransaction_type']=='Transfer')
	{
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = (isset($_POST['edit_account_id_Transfer']))?$_POST['edit_account_id_Transfer']:'';
		$AmountTransfer = (isset($_POST['AmountTransfer']))?$_POST['AmountTransfer']:'';
		$productfromTransfer = (isset($_POST['productfromTransfer']))?$_POST['productfromTransfer']:'';
		$producttoTransfer = (isset($_POST['producttoTransfer']))?$_POST['producttoTransfer']:'';		
		$Instant_transactionTransfer = (isset($_POST['Instant_transactionTransfer']))?$_POST['Instant_transactionTransfer']:'';			
		$remarkTransfer = (isset($_POST['remarkTransfer']))?$_POST['remarkTransfer']:'';
		
		if(isset($_POST['Instant_transactionTransfer']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
	  	$insertTransfer = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='',
			`hours`='',
			`minutes`='',
			`seconds`='',
			`amount`='$AmountTransfer',
			`payment_method`='',
			`productid_from`='$productfromTransfer',
			`bankid`='',
			`reference_no`='',
			`bonus_promotion_id`='',
			`bonus_amount`='',
			`instant_transaction`='$Instant_transactionTransfer',
			`account_name`='',
			`bank_account_number`='',
			`withdrawal_bank_id`='',
			`productid_to`='$producttoTransfer',
			`deposit_transaction_id`='',
			`remark`='$remarkTransfer',
			`status`='$status'
		";
		if(mysqli_query($conn,$insertTransfer)==TRUE)
		{
			$success = 'Transfer Transaction added successfully.';
		}
	}	
	if($_POST['newtransaction_type']=='Bonus')
	{
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = (isset($_POST['edit_account_id_Bonusnew']))?$_POST['edit_account_id_Bonusnew']:'';
		$Transfer_DateBonusnew = (isset($_POST['Transfer_DateBonusnew']))?$_POST['Transfer_DateBonusnew']:'';
		$hoursBonusnew = (isset($_POST['hoursBonusnew']))?$_POST['hoursBonusnew']:'';
		$minutesBonusnew = (isset($_POST['minutesBonusnew']))?$_POST['minutesBonusnew']:'';
		$secondsBonusnew = (isset($_POST['secondsBonusnew']))?$_POST['secondsBonusnew']:'';
		$AmountBonusnew = (isset($_POST['AmountBonusnew']))?$_POST['AmountBonusnew']:'';
		$productBonusnew = (isset($_POST['productBonusnew']))?$_POST['productBonusnew']:'';
		$DepositTransactionIdBonusnew = (isset($_POST['DepositTransactionIdBonusnew']))?$_POST['DepositTransactionIdBonusnew']:'';
		$bonustypeBonusnew = (isset($_POST['bonustypeBonusnew']))?$_POST['bonustypeBonusnew']:'';	
		$Instant_transactionBonusnew = (isset($_POST['Instant_transactionBonusnew']))?$_POST['Instant_transactionBonusnew']:'';	
		$remarkBonusnew = (isset($_POST['remarkBonusnew']))?$_POST['remarkBonusnew']:'';
		
		if(isset($_POST['Instant_transactionBonusnew']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
		$insertBonus = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$Transfer_DateBonusnew',
			`hours`=$hoursBonusnew,
			`minutes`=$minutesBonusnew,
			`seconds`=$secondsBonusnew,
			`amount`='$AmountBonusnew',
			`payment_method`='',
			`productid_from`='$productBonusnew',
			`bankid`='',
			`reference_no`='',
			`bonus_promotion_id`='$bonustypeBonusnew',
			`bonus_amount`='',
			`instant_transaction`='$Instant_transactionBonusnew',
			`account_name`='',
			`bank_account_number`='',
			`withdrawal_bank_id`='',
			`productid_to`='',
			`deposit_transaction_id`='$DepositTransactionIdBonusnew',
			`remark`='$remarkBonusnew',
			`status`='$status'
		";
		if(mysqli_query($conn,$insertBonus)==TRUE)
		{
			$success = 'Bonus Transaction added successfully.';
		}
	}	
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
.ui-tabs-active a,.btn-outline-dark:hover
{
	color:#fff !important;
}
.ui-tabs-active
{
	background: gray !important;
	border: gray !important;
}
.bonusdiv,.DepositTransactionId
{
	display:none;
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
.container-fluid,#subtabs
{
	border: none !important;
}
.container{
	background: #dedede !important;
	max-width: 100%;
	padding-bottom: 4%;
	}
	.form-group
	{
		display: flex;
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
</head>
<body>


 <?php 
  $filter = $_POST['aflt'];
 ?>

 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="new_transaction.php" id="sc8_1">New Transaction</a>
    <span>|</span>
    <a href="transaction_history.php" id="sc8_1">Transaction History</a>
     <span>|</span>
    <a href="transaction_report.php" id="sc8_1">Report</a>
</div>
<div class="container" id="subtabs">
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
 <center><h2><strong>Add Transaction</strong></h2></center>
 
  <form class="form-horizontal" method="post">
   <div class="container-fluid">
   	<div class="row">
    	<div class="col-sm-12">
            <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Type</legend>
                <div class="form-group">
                  <div class="col-sm-10">                       
                        <!--<input type="button" class="btn btn-light" name="Deposit" value="Deposit"/>
                        <input type="button" class="btn btn-light" name="Withdrawal" value="Withdrawal"/>
                        <input type="button" class="btn btn-light" name="Transfer" value="Transfer"/>
                        <input type="button" class="btn btn-light" name="Bonus" value="Bonus"/>-->
                        <ul>
                            <li><a class="btn btn-outline-dark transactiontypebutton" href="#Deposit">Deposit</a></li>
                            <li><a class="btn btn-outline-dark transactiontypebutton" href="#Withdrawal">Withdrawal</a></li>
                            <li><a class="btn btn-outline-dark transactiontypebutton" href="#Transfer">Transfer</a></li>
                            <li><a class="btn btn-outline-dark transactiontypebutton" href="#Bonusnew">Bonus</a></li>
                    	</ul>
                  </div>
                </div>
			</fieldset>
            <br/>
            <!--<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                        <input type="text" name="username" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_Date" value=""/>
                        
                        <select name="hours">
                        	<option value="00">00</option>    
                            <?php 
							for($i=1;$i<24;$i++)
							{
								if($i<10)
								{
									$i = '0'.$i;
								}
								?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option> 
                                <?php
							}
							?>                    
                        </select> :
                        <select name="minutes">
                        	<option value="00">00</option>    
                            <?php 
							for($i=1;$i<60;$i++)
							{
								if($i<10)
								{
									$i = '0'.$i;
								}
								?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option> 
                                <?php
							}
							?>                    
                        </select> :
                        <select name="seconds">
                        	<option value="00">00</option>    
                            <?php 
							for($i=1;$i<60;$i++)
							{
								if($i<10)
								{
									$i = '0'.$i;
								}
								?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option> 
                                <?php
							}
							?>                    
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="Amount" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Payment Method</label>
                  <div class="col-sm-9">
                        <input type="radio" name="payment_method" value="ATM"/> ATM
                        &nbsp;
                        <input type="radio" name="payment_method" value="Online"/> Online
                        &nbsp;
                        <input type="radio" name="payment_method" value="Cash"/> Cash
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="product">
                        <?php 
						$sqlproductname = "SELECT name from product_info";
						$productname = mysqli_query($conn,$sqlproductname);
						if(mysqli_num_rows($productname)>0)
						{		
							while($row = mysqli_fetch_assoc($productname))
							{
						?>
							<option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
						<?php 
							}
						}else
						{
							echo "No products";
						}	
						?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bank Account</label>
                  <div class="col-sm-9">
                        <select name="BankAccount">
                        	<option label="BSN - LEE JUN CHEK [0113229000090895]" value="19">BSN - LEE JUN CHEK [0113229000090895]</option>
                            <option label="CIMB - LEE JUN CHEK [7636255741]" value="18">CIMB - LEE JUN CHEK [7636255741]</option>
                            <option label="HLB - XY YUMMY BAKE ENTERPRISE [12300293979]" value="17">HLB - XY YUMMY BAKE ENTERPRISE [12300293979]</option>
                            <option label="MBB - XY YUMMY BAKE ENTERPRISE [551203537913]" value="21">MBB - XY YUMMY BAKE ENTERPRISE [551203537913]</option>
                            <option label="PARK - PARKING [PARKING]" value="22">PARK - PARKING [PARKING]</option>
                            <option label="PBB - NG XUE YUN [6396674613]" value="16">PBB - NG XUE YUN [6396674613]</option>
                            <option label="TNG - TANG CHET POH [011-61134995]" value="20">TNG - TANG CHET POH [011-61134995]</option>
                            <option label="TNG2 - KHENG JIN JING [011-61705150]" value="23">TNG2 - KHENG JIN JING [011-61705150]</option>

                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Reference No</label>
                  <div class="col-sm-9">
                        <input type="text" name="Reference" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transaction" value="Bonus"/>&nbsp;Bonus
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transaction" value="Instant Transaction"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remark"></textarea>
                  </div>
                </div>
			</fieldset>-->
      	</div>       
    </div>
    <input type="hidden" name="newtransaction_type" id="newtransaction_type" value="Deposit"/>
    <div id="Deposit">
            <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                        <!--<input type="text" name="username_deposit" value="<?php echo $username;?>" readonly/>-->
                    <select name="edit_account_id_deposit">
                    <?php 
					$getalluser_account = mysqli_query($conn,"select * from account");
					if(mysqli_num_rows($getalluser_account)>0)
					{
						while($rowacc = mysqli_fetch_assoc($getalluser_account))
						{
						?>
							<option value="<?php echo $rowacc['id'];?>"><?php echo $rowacc['username'];?></option>
						<?php
						}
					}
					?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_Date_deposit" value="<?php echo date('Y-m-d');?>"/>
                        
                        <select name="hours_deposit">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<24;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>" <?php if($i == date('H')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="minutes_deposit">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('i')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="seconds_deposit">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('s')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="Amount_deposit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Payment Method</label>
                  <div class="col-sm-9">
                        <input type="radio" name="payment_method_deposit" value="ATM"/> ATM
                        &nbsp;
                        <input type="radio" name="payment_method_deposit" value="Online"/> Online
                        &nbsp;
                        <input type="radio" name="payment_method_deposit" value="Cash"/> Cash
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="product_deposit">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bank Account</label>
                  <div class="col-sm-9">
                        <select name="BankAccount_deposit">
                            <?php 
                            $get_bank = "select * from bank_account";
                            $result = mysqli_query($conn,$get_bank);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['bank_account_code']. ' - '.$row['bank_account_name'].'['.$row['bank_account_number'].']';?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Reference No</label>
                  <div class="col-sm-9">
                        <input type="text" name="Reference_deposit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="bonus_transaction_deposit" id="bonus_transaction_deposit" value="Bonus"/>&nbsp;Bonus
                  </div>
                </div>
                <div class="form-group bonusdiv">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus Amount</label>
                  <div class="col-sm-9">
                        <input type="text" name="bonus_amount_deposit" value=""/>
                  </div>
                </div>
                <div class="form-group bonusdiv">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus Type</label>
                  <div class="col-sm-9">
                         <select name="Banktype_deposit">
                            <?php 
                            $get_promotion = "select * from promotion";
                            $result = mysqli_query($conn,$get_promotion);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transaction_deposit" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remark_deposit"></textarea>
                  </div>
                </div>
            </fieldset>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Deposit" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        <div id="Withdrawal">
        	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                        <!--<input type="text" name="usernameWithdrawal" value="<?php echo $username;?>" readonly/>-->
                   <select name="edit_account_id_Withdrawal">
                    <?php 
					$getalluser_account = mysqli_query($conn,"select * from account");
					if(mysqli_num_rows($getalluser_account)>0)
					{
						while($rowacc = mysqli_fetch_assoc($getalluser_account))
						{
						?>
							<option value="<?php echo $rowacc['id'];?>"><?php echo $rowacc['username'];?></option>
						<?php
						}
					}
					?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_DateWithdrawal" value="<?php echo date('Y-m-d');?>"/>
                        
                        <select name="hoursWithdrawal">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<24;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>" <?php if($i == date('H')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="minutesWithdrawal">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('i')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="secondsWithdrawal">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('s')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">User Bank</label>
                  <div class="col-sm-9">
                        <select name="BankAccountWithdrawal">
                            <?php 
							$bank_first = '';
                            $get_bank = "select * from bank";
                            $result = mysqli_query($conn,$get_bank);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
									if($count==1)
									{
										$bank_first = $row['id'];
									}
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <?php 
				$bankdetail='';
				$accountnumber = '';
				$accountname = '';
				$select_sql=mysqli_query($conn,"SELECT * From account WHERE id=".$edit_id);
				if(mysqli_num_rows($select_sql)>0)
				{
					$bankdetail=$get_account['bankdetail'];
				}
				if($bankdetail!='')
				{
					$bankdetail = (array)json_decode($bankdetail);
					foreach($bankdetail as $keybank => $accRemark)
					{
						foreach($accRemark->account as $key => $account)
						{
							$accountnumber = $account;
							$accountname = $accRemark->remark[$key];
						}
					}
				}
				?>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Account Name</label>
                  <div class="col-sm-9">
                        <input type="text" name="account_name" value="<?php echo $accountname;?>"/>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bank Account Number</label>
                  <div class="col-sm-9">
                        <input type="number" name="bankaccoutnumberWithdrawal" value="<?php echo $accountnumber;?>"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="AmountWithdrawal" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Payment Method</label>
                  <div class="col-sm-9">
                        <input type="radio" name="payment_methodWithdrawal" value="ATM"/> ATM
                        &nbsp;
                        <input type="radio" name="payment_methodWithdrawal" value="Online"/> Online
                        &nbsp;
                        <input type="radio" name="payment_methodWithdrawal" value="Cash"/> Cash
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="productWithdrawal">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Withdrawal Account</label>
                  <div class="col-sm-9">
                        <select name="withdrawalaccountWithdrawal">
                            <?php 
                            $get_bank = "select * from bank_account";
                            $result = mysqli_query($conn,$get_bank);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['bank_account_code']. ' - '.$row['bank_account_name'].'['.$row['bank_account_number'].']';?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Reference No</label>
                  <div class="col-sm-9">
                        <input type="text" name="ReferenceWithdrawal" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transactionWithdrawal" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remarkWithdrawal"></textarea>
                  </div>
                </div>
            </fieldset>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Withdrawal" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        <div id="Transfer">
       		<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                       <!-- <input type="text" name="usernameTransfer" value="<?php echo $username;?>" readonly/>-->
                    <select name="edit_account_id_Transfer">
                    <?php 
					$getalluser_account = mysqli_query($conn,"select * from account");
					if(mysqli_num_rows($getalluser_account)>0)
					{
						while($rowacc = mysqli_fetch_assoc($getalluser_account))
						{
						?>
							<option value="<?php echo $rowacc['id'];?>"><?php echo $rowacc['username'];?></option>
						<?php
						}
					}
					?>
                    </select>
                  </div>
                </div>
               
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="AmountTransfer" value=""/>
                  </div>
                </div>
               
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="productfromTransfer">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products (To)</label>
                  <div class="col-sm-9">
                        <select name="producttoTransfer">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transactionTransfer" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remarkTransfer"></textarea>
                  </div>
                </div>
            </fieldset>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Transfer" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        <div id="Bonusnew">
        	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                       <!-- <input type="text" name="usernameBonusnew" value="<?php echo $username;?>" readonly/>-->
                       <select name="edit_account_id_Bonusnew">
                    <?php 
					$getalluser_account = mysqli_query($conn,"select * from account");
					if(mysqli_num_rows($getalluser_account)>0)
					{
						while($rowacc = mysqli_fetch_assoc($getalluser_account))
						{
						?>
							<option value="<?php echo $rowacc['id'];?>"><?php echo $rowacc['username'];?></option>
						<?php
						}
					}
					?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_DateBonusnew" value="<?php echo date('Y-m-d');?>"/>
                        
                        <select name="hoursBonusnew">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<24;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>" <?php if($i == date('H')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="minutesBonusnew">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('i')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="secondsBonusnew">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('s')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select>
                  </div>
                </div>
             
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="AmountBonusnew" value=""/>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="productBonusnew">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
              	<div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus Type</label>
                  <div class="col-sm-9">
                        <select name="bonustypeBonusnew">
                        <?php 
                            $get_promotion = "select * from promotion";
                            $result = mysqli_query($conn,$get_promotion);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Deposit</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Deposit_transactionBonusnew" id="Deposit_transactionBonusnew" value="bonus"/>&nbsp;Deposit
                  </div>
                </div>
                <div class="form-group DepositTransactionId">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Deposit Transaction Id</label>
                  <div class="col-sm-9">
                        <input type="text" name="DepositTransactionIdBonusnew" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transactionBonusnew" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remarkBonusnew"></textarea>
                  </div>
                </div>
                
            </fieldset>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Bonusnew" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        <div class="btn_bar1" style="bottom:0px;text-align: center;">
            <input class="btn1" type="submit" name="add_new_transaction" value="Submit">&nbsp;
            <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
        </div>
   <!--
    <div class="row">
    	<div class="col-sm-12">
        	
      	</div>       
    </div>
   <div class="btn_bar1" style="bottom:0px;text-align: center;">
        <input class="btn1" type="submit" name="sbtt" value="Submit">&nbsp;
        <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back">
	</div>-->
  
</div>
  </form>

</body>
</html>
<script>
$( function() {
	$( "#subtabs" ).tabs();
	$(".bonusdiv").hide();
});
$(document).on('click',".transactiontypebutton",function(){
	$("#newtransaction_type").val($(this).text());
});

$("#bonus_transaction_deposit").click(function(){		
	if ($("#bonus_transaction_deposit").is(":checked")) {
		$(".bonusdiv").show();
	} else {
		$(".bonusdiv").hide();
	}
});
$("#Deposit_transactionBonusnew").click(function(){		
	if ($("#Deposit_transactionBonusnew").is(":checked")) {
		$(".DepositTransactionId").show();
	} else {
		$(".DepositTransactionId").hide();
	}
});

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