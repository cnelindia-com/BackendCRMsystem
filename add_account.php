<?php
session_start();
include('header.php');
$user=$_SESSION['user'];
$success = '';

if(isset($_POST['sbtt']))
{
	$username = $_POST['username'];
	$full_name = $_POST['full_name'];
	$phone =json_encode($_POST['phone']);
	$user_code = $_POST['user_code'];
	$email = $_POST['email'];
	$dob = $_POST['dob'];
	$currency = $_POST['currency'];
	$vip = $_POST['vip'];
	$status = $_POST['status'];
	$remark = $_POST['remark'];
	$admin_user = $_POST['admin_user'];
	$productIDS = json_encode($_POST['productids']);
	$date = date('Y-m-d H:i:s');
	$bankdetail=json_encode($_POST['bankaccount']);
		
	if(isset($_POST['edit_account_id']) && !empty($_POST['edit_account_id']))
	{				
		$updateaccount = "UPDATE account SET
			`username`='$username',
			`fullname`='$full_name',
			`phone`='$phone',
			`usercode`='$user_code',
			`email`='$email',
			`dob`='$dob',
			`currency`='$currency',
			`vip`='$vip',
			`status`='$status',
			`productIDS`='$productIDS',
			`adminuserid`='$admin_user',
			`remark`='$remark',
			`bankdetail`='$bankdetail' where id=".$_POST['edit_account_id'];			
		if(mysqli_query($conn,$updateaccount)==TRUE)
		{
			$success = 'Account updated successfully.';
		}
	}
	else
	{												
		$insertaccount = "Insert INTO account SET
			`username`='$username',
			`fullname`='$full_name',
			`phone`='$phone',
			`usercode`='$user_code',
			`email`='$email',
			`dob`='$dob',
			`currency`='$currency',
			`vip`='$vip',
			`status`='$status',
			`productIDS`='$productIDS',
			`adminuserid`='$admin_user',
			`remark`='$remark',
			`createdON`='$date',
			`bankdetail`='$bankdetail'			
		";
		if(mysqli_query($conn,$insertaccount)==TRUE)
		{
			$success = 'Account added successfully.';
		}
		
		$aid = mysqli_insert_id($conn);
		echo "<script>window.location.href = 'add_account.php?id=$aid';</script>";
		exit();
	}
}

if(isset($_POST['add_new_transaction']))
{
	if($_POST['newtransaction_type']=='Deposit')
	{
		//print_r($_POST);
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = (isset($_POST['edit_account_id']))?$_POST['edit_account_id']:'';
		$Transfer_Date_deposit = (isset($_POST['Transfer_Date_deposit']))?$_POST['Transfer_Date_deposit']:'';
		$hours_deposit = (isset($_POST['hours_deposit']))?$_POST['hours_deposit']:'';
		$minutes_deposit = (isset($_POST['minutes_deposit']))?$_POST['minutes_deposit']:'';
		$seconds_deposit = (isset($_POST['seconds_deposit']))?$_POST['seconds_deposit']:'';
		$Amount_deposit =(isset($_POST['Amount_deposit']))?$_POST['Amount_deposit']:'';
		$payment_method_deposit = (isset($_POST['payment_method_deposit']))?$_POST['payment_method_deposit']:'';
		$product_deposit = (isset($_POST['product_deposit']))?$_POST['product_deposit']:'';
		$BankAccount_deposit = (isset($_POST['BankAccount_deposit']))?$_POST['BankAccount_deposit']:'';
		$Reference_deposit = (isset($_POST['Reference_deposit']))?$_POST['Reference_deposit']:'';
		$bonus_amount_deposit = (isset($_POST['bonus_amount_deposit']))?$_POST['bonus_amount_deposit']:'';
		$Banktype_deposit = (isset($_POST['Banktype_deposit']))?$_POST['Banktype_deposit']:'';					
		
		//bonus transaction
		$bonus_transaction_deposit = (isset($_POST['bonus_transaction_deposit'])) ? $_POST['bonus_transaction_deposit']:'';
		
		
		$Instant_transaction_deposit =(isset($_POST['Instant_transaction_deposit']))?$_POST['Instant_transaction_deposit']:'';
		
		$remark_deposit = (isset($_POST['remark_deposit']))?$_POST['Instant_transaction_deposit']:'';
		
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
			`bonus_promotion_id`='$Banktype_deposit',
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
		$account_id = (isset($_POST['edit_account_id']))?$_POST['edit_account_id']:'';
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
		$account_id = (isset($_POST['edit_account_id']))?$_POST['edit_account_id']:'';
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
		
		$transferdate = date('Y-m-d');
	  	$hours = date('H');
		$minutes = date('i');
		$seconds = date('s');
		
	  	$insertTransfer = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$transferdate',
			`hours`='$hours',
			`minutes`='$minutes',
			`seconds`='$seconds',
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
		$account_id = (isset($_POST['edit_account_id']))?$_POST['edit_account_id']:'';
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

if(isset($_GET['transaction_id']))
{
	$delete_transaction ="Delete from transactions where id=".$_GET['transaction_id'];
	if(mysqli_query($conn,$delete_transaction)==TRUE)
	{
		$success = 'Transaction deleted successfully.';
	}
}


$edit_id = '';
$username = $fullname = $phone =$usercode =  $email = $dob = $currency = $vip = $status = $productIDS = $adminuserid = $remark = $createdON =$bankdetail= "";
if(isset($_GET['id']))
{
	$edit_id = $_GET['id'];
	$select_sql=mysqli_query($conn,"SELECT * From account WHERE id=".$edit_id);
	if(mysqli_num_rows($select_sql)>0)
	{
		$get_account = mysqli_fetch_assoc($select_sql);
		$username = $get_account['username'];
		$fullname = $get_account['fullname'];
		$phone = $get_account['phone'];
		$usercode = $get_account['usercode'];
		$email = $get_account['email'];
		$dob = $get_account['dob'];
		$currency = $get_account['currency'];
		$vip = $get_account['vip'];
		$status = $get_account['status'];
		$productIDS = $get_account['productIDS'];
		$adminuserid = $get_account['adminuserid'];
		$remark = $get_account['remark'];
		$createdON = $get_account['createdON'];
		$bankdetail=$get_account['bankdetail'];
	}
	
	if(isset($_POST['status']) && $_POST['status'] == 'Active')
	{
		$datetime= date("Y-m-d", strtotime("Now"));
		
		$createdon_obj=DateTime::createFromFormat("Y-m-d", "$datetime");	
		$last_active=	$createdon_obj->format('Y-m-d H:i:s');
			
		$datetimesql=mysqli_query($conn, "UPDATE `account` SET `last_active`='$last_active' WHERE id = $edit_id");
	}
}
?>

<style>
.resulttable
{
	max-height:500px;
}
.ui-tabs-active a,.btn-outline-dark:hover
{
	color:#fff !important;
}
.ui-tabs-active
{
	background: gray !important;
	border: gray !important;
}

body {
    font-size: 14px !important;
    color: #000;
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, SimSun, sans-serif;
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, Hiragino Sans GB, WenQuanYi Micro Hei, Verdana, Aril, sans-serif;
    background: #DEDEDE;
    margin: 0 0 50px;
        margin-bottom: 50px;
}
.tabcontent{
	font-size: 18px;
	background:#cccccc;
	margin-left: -15px;
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
    text-decoration: none !important; 
}
a{
	color:black !important;
}
span{
	color:#ff6c04;
}
.title1 {
    text-align: center;
    margin: 18px auto 19px;
}
#customerInfo {
    position: relative;
    height: 645px;
    width: 100%;
    clear: both;
    overflow: hidden;
}
.actives{
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
	text-decoration: none;
	border: 1px solid #FF6C04;
	background: rgba(255,108,4, 0.2);	
}
div.leftColumn, div.rightColumn {
    width: 50%;
    height: 100%;
    display: block;
    float: left;
}
#customerInfo fieldset, .acc_banktransfer fieldset {
    padding: 2px 20px;
}
.csLegend {
    font-weight: bold;
    background: #ffffff;
}
#customerInfo table {
    width: 100%;
    margin: 10px;
}
div.leftColumn, div.rightColumn {
    width: 50%;
    height: 100%;
    display: block;
    float: left;
}
.btn_bar1 {
    background: inherit;
    margin: 0 10px;
    padding: 5px 0 5px 0;
    +padding: 6px 0 4px 0;
    text-align: center;
}
container-fluid {
  height: 100%;
  background: lightyellow;
 
}
.container-fluid,#subtabs
{
	background:unset !important;
	border: none !important;
}
.container{
    width: 100% !important;
	max-width: 100% !important;
	background:#dedede;
	}
.form-group {
    margin-bottom: -4px !important;
	display: inline-block;
	width: 100%;
}	
legend{
	font-weight: bold;
}
label {
    font-weight: unset;
	font-size: 12px;
}
.form-horizontal .control-label{
	text-align: unset !important;
}
.btn1:hover {
    background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
        background-color: rgba(0, 0, 0, 0);
    background: -moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
    background-color: #378de5;
    cursor: pointer;
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


.btn1:hover {

   
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
    background-color: #378de5;
    cursor: pointer;

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
  
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
   
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
.btn1 {
    +padding-bottom: 0px;
    +top: -1px;
}
input, button {
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
}
.btn_bar1 {
    text-align: center;
}
.red{
	color:red;
}
.fixed-top {
	position:absolute !important;
	}
.menuoptionclass
{
	margin-right:5%;
}

html, body {
	background: #dedede;
}

.ui-tabs .ui-tabs-nav > li a {
	font-size: 13px;
	font-weight: 600;
	border: none;
	border-radius: 5px;
}

#Account {
	padding: 0;
}

#Account .form-group label {
	width: 130px;
}
#Account .form-group label {
	width: 115px;
}
</style>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
</head>
<body background="#cccccc">
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="customer.php" id="sc8_1" style="margin-left:18px;" class="actives">Account</a>
    <span>|</span>
   <!-- <a href="#" id="sc8_1">Online User</a>
    <span>|</span>
    <a href="#" id="sc8_1">VIP</a>
    <span>|</span>-->
    <a href="vip_setting.php" id="sc8_1">VIP Setting</a>
</div>

<div class="container">
<?php if($edit_id!==''){?>
 <center><h2><strong>Edit Account</strong></h2></center>
<?php }else{?>
 <center><h2><strong>New Account</strong></h2></center>
 <?php }?>
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
  <form class="form-horizontal" method="post">
  	<input type="hidden" name="edit_account_id" value="<?php echo $edit_id;?>"/>
   <div class="container-fluid" id="tabs">
   
   <?php if($edit_id!==''){?>
    
   <div class="row">
    	<div class="col-sm-12">
        	<fieldset style="padding-left: 5px;background:#cccccc;border-radius: 4px;padding-bottom: 10px;">
                <legend style="background:#fff; width: 137px; padding: 4px;">Account Search</legend>
                <div>
                  <label class="control-label col-sm-1" style="padding-top: unset;width: 45px;padding: 5px 0;">Status</label>
                  <div class="col-sm-10" style="padding-left: 1px;">
                        <select name="statustype">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                        
                        <input type="text" name="searchtext" value="" style="height: 22px;width: 200px;"/>
                        
                        <select name="Username">
                            <option value="">Username / User Code</option>
                        </select>
                        
                        <input type="button" name="search" value="Search"/>
                  </div>
                </div>
			</fieldset>

            <fieldset style="padding-left: 5px;background:#cccccc;border-radius: 4px;padding-bottom: 10px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Menu</legend>
                <div>
                  <!-- <label class="control-label col-sm-1" style="margin-left: 10px;padding-top: unset;"></label> -->
					<div class="col-sm-12" style="padding-left: 0;">                       
					  <ul style="background: right;border: none;">
						<li><a class="btn btn-outline-dark" href="#Account" id="Accountid" class="tablinks" onclick=openTabs(evt, Account);>Account</a></li>
						<li><a class="btn btn-outline-dark" href="#Transaction" id="Transactionid" class="tablinks" onclick=openTabs(evt, Transaction);>Transaction</a></li>
						<li><a class="btn btn-outline-dark" href="#NewTransaction" id="NewTransactionid" class="tablinks" onclick=openTabs(evt, NewTransaction);> New Transaction</a></li>
						<li><a class="btn btn-outline-dark" href="#Bonus" id="Bonusid" class="tablinks" onclick=openTabs(evt, Bonus);>Bonus</a></li>
					  </ul>
                   </div>
                </div>
			</fieldset>
      	</div>
    </div>
    <br/>
   
    <?php }?>
    <div id="Account">
        <div class="row">
          <div class="col-sm-6">
          <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
      <legend style="background:#fff; width: 121px; padding: 4px;">Account Details</legend>
        <div class="form-group">
          <label class="control-label col-sm-3">Username<span class="red">*</span></label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="username" value="<?php echo $username;?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" >Full Name<span class="red">*</span></label>
          <div class="col-sm-7">          
            <input type="text" class="form-control" name="full_name" value="<?php echo $fullname;?>" required>
          </div>
        </div>
        <?php 
        if($phone!='')
        {
            $phone = json_decode($phone);						
			$countphone=1;
            foreach($phone as $number)
            {
				if($countphone==1)
				{
            ?>
                <div class="form-group hwedivphone">
                  <label class="control-label col-sm-3">Phone (Main)</label>
                  <div class="col-sm-7 " style="width: 100%;">          
                    <input type="number" class="form-control" name="phone[]" value="<?php echo $number;?>" required>
                  </div>
                </div>
            <?php
				}
				else
				{
					?>
					<div class="form-group hwedivphone">
                      <div class="col-sm-7">          
                        <div style="display: inline-flex;width: 100%;"><input type="number" class="form-control" name="phone[]" value="<?php echo $number;?>" required>
                        <a href="#" class="remove_field"><i class="fa fa-remove blue-color "  style="color: red; font-size: 20px;"></i> </a>
						</div>
						<div class="input_fields_wrap"></div>
                      </div>
                    </div>
					<?php
				}
				$countphone++;
            }
        }
        else
        {
            ?>
             <div class="form-group">
              <label class="control-label col-sm-3" >Phone (Main)<span class="red">*</span></label>
              <div class="col-sm-7">          
                <div style="display: inline-flex;width: 100%;">
				<input type="number" class="form-control" name="phone[]" value="<?php echo $phone;?>" required>
                 <input type="button" class="add_field_button" value="Add" style="padding: 0px 5px 0px 5px; margin-right:-3px;">
				</div>
				<div class="input_fields_wrap"></div>
              </div>
            </div>
    
            <?php 
        }
        ?>
        
        <div class="form-group">
          <label class="control-label col-sm-3">User Code</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="user_code" value="<?php echo $usercode;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" >Email</label>
          <div class="col-sm-7">          
            <input type="email" class="form-control" name="email" value="<?php echo $email;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3">Date of birth</label>
          <div class="col-sm-7">
            <input type="date" class="form-control" name="dob" value="<?php echo $dob;?>">
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-3">Currency</label>
          <div class="col-sm-7">
           <select name="currency">
                <option value="MYR" <?php if($currency=='MYR'){ echo 'checked';}?>>MYR</option>
                <option value="TNG" <?php if($currency=='TNG'){ echo 'checked';}?>>TNG</option>
           </select>
           
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-3">VIP</label>
          <div class="col-sm-7">
            <select name="vip">
                <option value="">Select</option>
                <?php 
                $get_vips = mysqli_query($conn,"SELECT * from vip_setting");
                if(mysqli_num_rows($get_vips)>0)
                {
                    while($rowvip= mysqli_fetch_assoc($get_vips))
                    {
                        ?>
                        <option value="<?php echo $rowvip['id'];?>" <?php if($vip==$rowvip['id']){ echo 'selected';}?>><?php echo $rowvip['name'];?></option>
                        <?php
                    }
                }
                ?>
           </select>
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-3">Status</label>
          <div class="col-sm-7">
            
            <label class="col-sm-3" style="padding-left: 0px;"><input type="radio"  name="status" value="Active" <?php if($status=='Active'){ echo 'checked';} 
			if(empty($status)){ echo "checked"; } ?> required >Active</label>
            
            <label class="col-sm-5" style="padding-left: 0px;"><input type="radio" name="status" value="Suspended" <?php if($status=='Suspended'){ echo 'checked';}?> required>Suspended </label><br>
          </div>
        </div>
        </fieldset>
      
        <!--<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
      <legend style="background:#fff; width: 137px; padding: 4px;">Account Password</legend>
        <div class="form-group">
          <label class="control-label col-sm-2" style="margin-left: 10px;">Password</label>
          <div class="col-sm-7">
            <input type="Password" name="password" class="form-control" style="margin-left: 25px;">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;" >Repeat Password</label>
          <div class="col-sm-7">          
            <input type="password" name="repeat_password" class="form-control" style="margin-left:-29px;">
          </div>
        </div>
        </fieldset>-->
      
    	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
      	<legend style="background:#fff; width: 48px; padding: 4px;">Other</legend>
        <!--<div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;">Registered IP</label>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3"  style="margin-left: 10px;" >Referrer</label>
        </div>-->
         <div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;" >Created On</label><?php echo $createdON;?>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3"  style="margin-left: 10px;">Total Withdraw 	</label>
          </div>
        <div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;" >Total Deposit</label>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;">Total Bonus</label>
        </div>
         <!--<div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;">Mobile Apps</label>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-3" style="margin-left: 10px;">None</label>
        </div>-->
    	</fieldset>
    	</div>
          <div class="col-sm-6">
          <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
          <legend style="background:#fff; width: 140px; padding: 4px;">Product Username</legend>
           <div class="form-group">
              <label class="control-label col-sm-4" style="font-weight: bold;width:19.33%"><strong>Products</strong></label>
            
              <label class="control-label col-sm-4" style="font-weight: bold;width:45.33%"><strong>Products ID</strong></label>
              
           <!--   <label class="control-label col-sm-2" style="margin-left: 25px; font-weight: bold;"><strong>Turnover</strong></label>-->
             
              <label class="control-label col-sm-4" style="margin-left: 25px; font-weight: bold;width:33.33%"><strong>Last Transaction</strong></label>
            </div>
        <?php 
        $sqlproductname = "SELECT id,name from products";
        $productname = mysqli_query($conn,$sqlproductname);
        if(mysqli_num_rows($productname)>0)
        {		
            while($row = mysqli_fetch_assoc($productname))
            {
                if($productIDS!='')
                {
                    $productIDSs= (array)json_decode($productIDS);
            ?>
            <div class="form-group">
              <label class="control-label col-sm-3"><?php echo $row['name'];?></label>
              <div class="col-sm-7 " style="width: 38%;">
                <input type="text" class="form-control" name="productids[<?php echo $row['id'];?>]" value="<?php echo $productIDSs[$row['id']];?>">
              </div>
            </div>
            <?php 
                }
                else
                {
            ?>
            <div class="form-group">
              <label class="control-label col-sm-3"><?php echo $row['name'];?></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="productids[<?php echo $row['id'];?>]">
              </div>
            </div>
            <?php 
                }
            }
        }else
        {
            echo "No products";
        }	
        ?>
        </fieldset>
       
        <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
      <legend style="background:#fff; width: 107px; padding: 4px;">Bank Account</legend>
        <div class="form-group">
          <label class="control-label col-sm-3">Add Bank Account</label>
          <div class="col-sm-4">
           <select class="hwe_bank" name="bank_account">
           
            <?php 
                $get_bank = "select * from bank";
                $result = mysqli_query($conn,$get_bank);
                if(mysqli_num_rows($result)>0)
                {
                    $count=1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                ?>
                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                <?php }
                }?>
                <!-- <option label="MAYBANK" value="MAYBANK">MAYBANK</option>
                <option label="BSN BANK" value="BSN BANK">BSN BANK</option>
                <option label="RHB BANK" value="RHB BANK">RHB BANK</option>
                <option label="PUBLIC BANK" value="PUBLIC BANK">PUBLIC BANK</option>
                <option label="CIMB BANK" value="CIMB BANK">CIMB BANK</option>
                <option label="HLB BANK" value="HLB BANK">HLB BANK</option>
                <option label="BANK ISLAM" value="BANK ISLAM">BANK ISLAM</option>
                <option label="UOB BANK" value="UOB BANK">UOB BANK</option>
                <option label="OCBC BANK" value="OCBC BANK">OCBC BANK</option>
                <option label="AMBANK" value="AMBANK">AMBANK</option>
                <option label="AFFIN BANK" value="AFFIN BANK">AFFIN BANK</option>
                <option label="BANK RAKYAT" value="BANK RAKYAT">BANK RAKYAT</option>
                <option label="ALLIANCE BANK" value="ALLIANCE BANK">ALLIANCE BANK</option>
                <option label="MUAMALAT BANK" value="MUAMALAT BANK">MUAMALAT BANK</option>
                <option label="AGRO BANK" value="AGRO BANK">AGRO BANK</option>
                <option label="E-WALLET T&amp;G" value="E-WALLET T&amp;G">E-WALLET T&amp;G</option>
                <option label="PARKING" value="PARKING">PARKING</option>
                <option label="HSBC BANK" value="HSBC BANK">HSBC BANK</option>-->
            </select>
            <input type="button" class="hwe_add_bank" value="add" style="padding: 0px 5px 0px 5px;">
          </div>
        </div>
        
        <div class="form-group input_fields_bank">
        <?php 
        if($bankdetail!='')
        {
            $bankdetail = json_decode($bankdetail);
        //	print_r($bankdetail);
            
            foreach($bankdetail as $keybank => $accRemark)
            {
                $getbankname= mysqli_query($conn,"select name from bank where id=".$keybank);
                $getbankname=mysqli_fetch_assoc($getbankname);
                foreach($accRemark->account as $key => $account)
                {
                    $remark = $accRemark->remark[$key];
                ?>
                <div class="form-group"><label class="control-label col-sm-3" style="margin-left: 40px;"><?php echo $getbankname['name'];?></label><div class="col-sm-4" style="display:flex;"><input type="radio" name="bank_radio"><input type="text" class="form-control" style="margin-left: 10px;" name="bankaccount[<?php echo $keybank;?>][account][]" placeholder="Bank Account No" value="<?php echo $account;?>"> <input type="text" name="bankaccount[<?php echo $keybank;?>][remark][]" class="form-control" placeholder="Remark" value="<?php echo $remark;?>" style="margin-left: 5px;"><a href="#" class="remove_field_bank"><i class="fa fa-remove blue-color" style="color: red; font-size: 20px;"></i></a></div></div>
                <?php
                }
            }
        }
        ?>
        </div>
        </fieldset>
      
        <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
      <legend style="background:#fff; width: 54px; padding: 4px;">Upline</legend>
        <div class="form-group">
          <label class="control-label col-sm-3">Admin User</label>
          <div class="col-sm-7">
            <select name="admin_user" required>
                <option value="0">-</option>
                <?php 
                $getadmin = mysqli_query($conn,'select user_id,name from user_info');
                if(mysqli_num_rows($getadmin)>0)
                {
                    while($rowuser = mysqli_fetch_assoc($getadmin))
                    {
                        ?>
                        <option value="<?php echo $rowuser['user_id'];?>" <?php if($adminuserid==$rowuser['user_id']){ echo 'selected';}elseif($rowuser['user_id']==$_SESSION['user']){echo 'selected';}?>><?php echo $rowuser['name'];?></option>
                        <?php
                    }
                }
                ?>
                <!--<option label="egadmin" value="egadmin">egadmin</option>
                <option label="admin" value="admin">admin</option>
                <option label="hung777" value="hung777">hung777</option>
                <option label="anny" value="anny">anny</option>
                <option label="mandy996" value="mandy996">mandy996</option>
                <option label="eason" value="eason">eason</option>
                <option label="demo123" value="demo123">demo123</option>
                <option label="ahy996" value="ahy996">ahy996</option>-->
            </select>
          </div>
        </div>
        </fieldset>
       
        <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
      <legend style="background:#fff; width: 63px; padding: 4px;">Remark</legend>
        <div class="form-group">
          <label class="control-label col-sm-3">Remark</label>
          <div class="col-sm-7">
            <textarea rows="4" cols="50" name="remark"><?php echo $remark;?></textarea>
          </div>
        </div>
        </fieldset>
          </div>
        </div>  
  
       <div class="btn_bar1" style="bottom:0px;">
            <input class="btn1" type="submit" name="sbtt" value="Submit">&nbsp;
            <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back"  onclick="history.go(-1);">
        </div>
    </div>
    </div>
    </form>
    <?php if(isset($_GET['id'])){?>
    	<style>
        td
		{
			background:#fff;
		}						
        </style>
        <div id="Transaction" style="display:none;">
         	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Details</legend>
                <form method="post" id="transactionform">
                    <div class="form-group">
                        <div class="col-md-2">
                            <b>Date</b>
                        </div>
                        <div class="col-md-10">
                        	<?php 
							$fromdatesearch = '';
							$todatesearch = '';
							if((isset($_POST['fromdate']) && !empty($_POST['fromdate'])) || (isset($_POST['todate']) && !empty($_POST['todate'])))
							{
								$fromdatesearch = $_POST['fromdate'];
								$todatesearch = $_POST['todate'];
							}
							?>
                        
                            <input type="datetime" name="fromdate" id="fromdate" value="<?php echo $fromdatesearch;?>"/> ~
                            <input type="datetime" name="todate" id="todate" value="<?php echo $todatesearch;?>"/>
                            
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
                    
                    <div class="form-group">
                        <div class="col-md-2">
                            <b>Status</b>
                        </div>
                        <div class="col-md-10">
                           <!-- <select name="status">
                                <option value="">All</option>
                                <option value="Approve">Approve</option>
                                <option value="Reject">Reject</option>
                            </select>  -->
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
                            <!--&nbsp;
                            <input type="checkbox" name="transaction_status[]" <?php if(in_array('Processing',$transactionstatuschecked)){echo 'checked';}?>   class="tranaction_statusfilter" value="Processing"/> Processing -->
                           <!-- &nbsp;
                            <input type="checkbox" name="transaction_status[]" class="tranaction_statusfilter"  value="Verified"/> Verified -->
                                          
                        </div>
                    </div>
                  
                    
                  <!--  <div class="form-group">
                        <div class="col-md-2">
                            <b>Transaction From</b>
                        </div>
                        <div class="col-md-10">
                            <input type="checkbox" name="transaction_fromtype" value="yes"/> Apps transaction only            
                        </div>
                    </div>-->
                                                    
                    <div>
                        <input type="submit" class="btn btn-secondary" name="searchfilter" id="searchfilter" value="Submit"/>
                        <input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
                    </div>
                </form>
                
                <?php					
                	if(isset($_POST['searchfilter']))
					{
				?>
                	<script>											
						setTimeout(function(){
							$("#Transactionid").trigger('click');
						}, 1000);												
					</script>
                <?php
					}
				?>
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
							$transactionsql = "select * from transactions where accountid=".$edit_id."  AND status!='NewTransaction'";
							
							if(isset($_POST['searchfilter']))
							{
								if(!empty($_POST['transaction_type']))
								{
									 $transaction_type = "'" . implode ( "', '", $_POST['transaction_type'] ) . "'";
									 $transactionsql.=" AND transactiontype IN($transaction_type)";
								}
								if(!empty($_POST['transaction_status']))
								{
									$transaction_status = "'" . implode ( "', '", $_POST['transaction_status'] ) . "'";
									$transactionsql.=" AND status IN($transaction_status)";
								}
								
								if((isset($_POST['fromdate']) && !empty($_POST['fromdate'])) || (isset($_POST['todate']) && !empty($_POST['todate'])))
								{
									$transactionsql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
								}
							}
							
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
								  <td style="<?php echo $style;?>"><a style="text-decoration: underline;color:#0055ff !important;" href="add_account.php?id=<?php echo $getaccount['id']; ?>"><?php echo strtoupper($getaccount['username']);?></a></td>
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
                                <td><? echo number_format($totalcashin,'2','.','0');?></td>
                                <td><? echo number_format($totalcashout,'2','.','0');?></td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>                
                <div class="btn_bar1" style="bottom:0px;text-align: center;">
                    <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
                </div>
            </fieldset>
        </div>
                
        <div id="NewTransaction" style="display:none;">
        	
			<?php 
			
				include('edit_new_transaction.php');
				if(isset($_POST['add_new_deposit_transaction']) || isset($_POST['add_new_withdrawal_transaction']) || isset($_POST['add_new_transfer_transaction']) || isset($_POST['add_new_bonusnew_transaction']))
				{
			?>
            	<script>
					setTimeout(function(){
						$("#NewTransactionid").trigger('click');
					}, 1000);
				</script>
            <?php	
				}				
			?>
            
        </div>
        
        <div id="Bonus" style="display:none;">
        	<form method="post">
            	<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
      	<div>
                <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                    <legend style="background:#fff; width: 63px; padding: 4px;">Bonus</legend>
                    <div class="resulttable">
    
                        <span class="counter pull-right"></span>
                        <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
                            <thead style="background-color: #ff720b;">
                                <tr>
                                    <th>NO</th>
                                    <th class="col-md-3 col-xs-3">Bonus Name</th>
                                    <th class="col-md-3 col-xs-3">Bonus Code</th>                                 
                                    <th class="col-md-3 col-xs-3">Count</th>
                                    <th class="col-md-3 col-xs-3">Amount</th> 
                                   <!-- <th class="col-md-3 col-xs-3">Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            	 <?php 
								 $total_count =0;
								 $total_amount = 0;
									$get_promotion = "select * from promotion";
									$result = mysqli_query($conn,$get_promotion);
									if(mysqli_num_rows($result)>0)
									{
										$count=1;
										while($rowpromotion = mysqli_fetch_assoc($result))
										{
											$bonuscount=0;
											$amount=0;
											
											$transactionsql = mysqli_query($conn,"select COUNT(*) as count, SUM(amount) as b_amount from transactions where accountid=".$edit_id." AND bonus_promotion_id=".$rowpromotion['id']." AND transactiontype='Bonus'");
											if(mysqli_num_rows($transactionsql)>0)
											{
												$transactionsql = mysqli_fetch_assoc($transactionsql);
												$bonuscount=$transactionsql['count'];
												if($transactionsql['b_amount']>0)
												{
													$amount=$transactionsql['b_amount'];
												}
											}
											
											$total_count+=$bonuscount;
								 			$total_amount+=$amount;
									?>
								  		<tr>
										  <td><?php echo $count++;?></td>
										  <td><?php echo $rowpromotion['name'];?></td>  
                                          
										  <?php if($rowpromotion['status'] == 'Active'){ ?>
                                          <td style="background:#00ff7f; color:black;"><?php echo $rowpromotion['promotion_code'];?></td>
                                          <?php }elseif($rowpromotion['status'] == 'Suspended'){ ?>
                                          <td style="background:#ffc1cc; color:black;"><?php echo $rowpromotion['promotion_code'];?></td>
                                          <?php }?>
                                          
										  <td><?php echo $bonuscount;?></td>
                                          <td><?php echo $amount;?></td>
										
										</tr>
									<?php }
									}?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Total</td>
                                         
                                  <td><?php echo $total_count;?></td>
                                   <td><?php echo $total_amount;?></td>
                                  
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="btn_bar1" style="bottom:0px;text-align: center;">
                        <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="account_page();">
                    </div>
                </fieldset>
            </div>
            </form>
        </div>
    <?php }?>
    
</div>
  

<script>
function account_page()
{
	window.location.href='https://stage2.readyforyourreview.com/customer.php';	
}
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
		//	$(wrapper).append('<div style="display:flex;"><input type="text" name="mytext[]" class="form-control" id="pwd" name="pwd" style="margin-left: -29px; margin-top: 4px;"/><a href="#" class="remove_field"><i class="fa fa-remove blue-color "  style="color: red; font-size: 20px;"></i> </a></div>'); 
			$(wrapper).append('<div class="form-group hwedivphone"><div class="col-sm-12" style="display:flex;width: 100%;"><input type="number" class="form-control" name="phone[]" required><a style="padding: 4px 10px;" href="#" class="remove_field"><i class="fa fa-remove blue-color "  style="color: red; font-size: 20px;"></i> </a></div></div>'); 
		//add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parents('.hwedivphone').remove(); x--;
	})
	$(document).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parents('.hwedivphone').remove(); x--;
	})
	
});
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_bank"); //Fields wrapper
	var add_button      = $(".hwe_add_bank"); //Add button ID
	var x = 1; 
	 
	
	$(add_button).click(function(e){ //on add input button click
	var selectedbankid = $('.hwe_bank option:selected').val();
	var selectedbankname = $(".hwe_bank option:selected").text(); 
	e.preventDefault();
	if(x < max_fields){ //max input box allowed
		x++; //text box increment
		$(wrapper).append('<div class="form-group"><label class="control-label col-sm-2" style="margin-left: 40px;">'+selectedbankname+'</label><div class="col-sm-8" style="display:flex; margin-left: 23px;"><input type="radio" name="bank_radio"><input type="text" class="form-control" style="margin-left: 10px;" name="bankaccount['+selectedbankid+'][account][]" placeholder="Bank Account No"> <input type="text" name="bankaccount['+selectedbankid+'][remark][]" class="form-control" placeholder="Remark" style="margin-left: 5px;"><a href="#" class="remove_field_bank"><i class="fa fa-remove blue-color" style="color: red; font-size: 20px;"></i></a></div></div>'); 
		}
	});
	$(wrapper).on("click",".remove_field_bank", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
	})
	
});

$(document).ready(function(){
	$("#submit").click(function(){
		$(".resulttable").show();
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
	
});

$(document).ready(function(e) {
    $("#Accountid").click(function(){
		$("#Account").show();
		$("#Bonus").hide();
		$("#NewTransaction").hide();
		$("#Transaction").hide();
	});
	$("#Bonusid").click(function(){
		$("#Bonus").show();
		$("#Account").hide();
		$("#NewTransaction").hide();
		$("#Transaction").hide();		
	});
	$("#NewTransactionid").click(function(){
		$("#NewTransaction").show();
		$("#Bonus").hide();
		$("#Account").hide();
		$("#Transaction").hide();		
	});
	$("#Transactionid").click(function(){
		$("#Transaction").show();
		$("#Bonus").hide();
		$("#NewTransaction").hide();
		$("#Account").hide();						
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
  <script>
  $( function() {
    $( "#tabs" ).tabs();
	 $( "#subtabs" ).tabs();
  } );

  function openTabs(evt, tabsname){
	var tablinks=document.getElementsByClassName("tablinks");

	for(var i=0; i<tablinks.length; i++)	
	{
		tablinks[i].className=tablinks[i].className.replace(" active", "");
	}
	document.getElementById(tabsname).style.display = "block";
	evt.currentTarget.className+= " active";
  }

</script>
</body>
</html>
<?php
/*if(isset($_POST['sbtt'])){
	$username = $_POST['username'];
	$full_name = $_POST['full_name'];
	$phone = $_POST['phone'];
	$user_code = $_POST['user_code'];
	$email = $_POST['email'];
	$dob = $_POST['dob'];
	$currency = $_POST['currency'];
	$vip = $_POST['vip'];
	$status = $_POST['status'];
	$password = $_POST['password'];
	$repeat_password = $_POST['repeat_password'];
	$DSPORT = $_POST['4D-SPORT'];
	$Unclaimed = $_POST['Unclaimed'];
	$KISS = $_POST['918KISS'];
	$LIVE = $_POST['LIVE22'];
	$KING = $_POST['KING855'];
	$KISSs = $_POST['918KISS2'];
	$MEGA = $_POST['MEGA888'];
	$PUSSY = $_POST['PUSSY888'];
	$XE = $_POST['XE-88'];
	$SCR = $_POST['SCR888'];
	$KAYA = $_POST['918KAYA'];
	$KISSPLUS = $_POST['918KISSPLUS'];
	$GW = $_POST['GW99'];
	$PLAYBOY = $_POST['PLAYBOY2'];
	$JOKER = $_POST['JOKER'];
	$NEWTOWN = $_POST['NEWTOWN'];
	$iMAXBET = $_POST['i-MAXBET'];
	$bank_account = $_POST['bank_account'];
	$account_no = $_POST['account_no'];
	$admin_user = $_POST['admin_user'];
	$remark = $_POST['remark'];
 $sql = "INSERT INTO account (username, full_name, phone, `user_code`, email, dob, currency, `VIP`, status, password, repeat_password, `4D-SPORT`, Unclaimed, `918KISS`, `LIVE22`, `KING855`, `918KISS2`, `MEGA888`, `PUSSY888`, `XE-88`, `SCR888`, `918KAYA`, `918KISSPLUS`, `GW99`, `PLAYBOY2`, JOKER, NEWTOWN, `i-MAXBET`, bank_account_name, account_no, admin_user, remark)
VALUES ('$username', '$full_name', '$phone', '$user_code', '$email', '$dob', '$currency', '$vip', '$status', '$password', '$repeat_password', '$DSPORT', '$Unclaimed', '$KISS', '$LIVE', '$KING', '$KISSs', '$MEGA', '$PUSSY', '$XE', '$SCR', '$KAYA', '$KISSPLUS', '$GW', '$PLAYBOY', '$JOKER', '$NEWTOWN', '$iMAXBET', '$bank_account', '$account_no', '$admin_user', '$remark')";
    $result=$conn->query($sql);
}
*/
?>