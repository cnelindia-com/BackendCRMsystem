<?php
session_start();

$_SESSION['page']='home';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
$success='';
$user=$_SESSION['user'];
$get_transaction_rows='';
$get_accountrow='';

$confirmdate = date('Y-m-d H:i:s');

$edit_id = $_GET['edit_id'];
	
$check_already_confirm_sql = "SELECT id, confirmed FROM transactions WHERE id = '$edit_id'";
$check_already_confirm_query = mysqli_query($conn, $check_already_confirm_sql);
$check_already_confirm_row = mysqli_fetch_assoc($check_already_confirm_query);
$confirmed = $check_already_confirm_row['confirmed'];
$neweditid1= $check_already_confirm_row['id'];

if(isset($_POST['Save']))
{ 
	$transaction_id= $_POST['transaction_id'];
	$status =$_POST['status'];
	$amount =$_POST['amount'];
	$Banktype_deposit = $_POST['Banktype_deposit'];
	$reject_reason = $_POST['reject_reason'];
	$comment = $_POST['comment'];
	$hwe_transaction_type_chek = $_POST['hwe_transaction_type_chek'];
	
	if($confirmed == 0){
		if($hwe_transaction_type_chek == 'Withdrawal'){
			$update_approve_status = "UPDATE transactions SET status ='$status',amount='$amount',confrimedby='$user',withdrawal_bank_id='$Banktype_deposit',confirmeddate='$confirmdate', confirmed = '1', remark = '$comment', reject_reason = '$reject_reason' where id=$transaction_id";
		}
		else{
			$update_approve_status = "UPDATE transactions SET status ='$status',amount='$amount',confrimedby='$user',bankid='$Banktype_deposit',confirmeddate='$confirmdate', remark = '$comment', confirmed = '1', reject_reason = '$reject_reason' where id=$transaction_id";
			
		}
	}
	else{
		if($hwe_transaction_type_chek == 'Withdrawal'){
			$update_approve_status = "UPDATE transactions SET status ='$status',amount='$amount',confrimedby='$user',withdrawal_bank_id='$Banktype_deposit', remark = '$comment', reject_reason = '$reject_reason' where id=$transaction_id";
		}
		else{
			$update_approve_status = "UPDATE transactions SET status ='$status',amount='$amount',confrimedby='$user',bankid='$Banktype_deposit', remark = '$comment', reject_reason = '$reject_reason' where id=$transaction_id";			
		}
	}		
	
	if(mysqli_query($conn,$update_approve_status)==TRUE)
	{
		$success = 'Transaction Status Changed';
	}
}

if(isset($_GET['edit_id']))
{	
	$get_transaction = mysqli_query($conn,"SELECT * from transactions where id =".$_GET['edit_id']);

	if(mysqli_num_rows($get_transaction)>0)
	{
		$get_transaction_rows= mysqli_fetch_assoc($get_transaction);
		
		//print_r($get_transaction_rows);
		
		$get_account = mysqli_query($conn,"SELECT * from account where id = ".$get_transaction_rows['accountid']);
		$get_accountrow = mysqli_fetch_assoc($get_account);
	}	
}

if(isset($_GET['neweditid'])){

	$neweditid= $_GET['neweditid'];					

	$transresult=mysqli_query($conn, "SELECT * FROM `transactions` WHERE id='$neweditid'");	
	echo "SELECT * FROM `transactions` WHERE id='$neweditid'";			
	$transrow= mysqli_fetch_assoc($transresult);	
		
	if($transrow['transactiontype'] == 'Deposit'){	
		$transquery= mysqli_query($conn, "SELECT * FROM `transactions` WHERE id= ".$transrow['bonus_promotion_id']);
		$transaction_row= mysqli_fetch_assoc($transquery);
		
		$newamount=$transaction_row['amount'];	
	
		mysqli_query($conn, "UPDATE `transactions` SET bonus_amount='$newamount' WHERE id='$neweditid'");
		
		$get_transaction = mysqli_query($conn,"SELECT * from transactions where id='$neweditid'"); 
	}	
	
	 if($transrow['transactiontype'] == 'Bonus'){			
		$transquery= mysqli_query($conn, "SELECT * FROM `transactions` WHERE id= ".$transrow['deposit_transaction_id']);
		$transaction_row= mysqli_fetch_assoc($transquery);
		$newamount=$transaction_row['amount'];
		echo "Deposit";
		echo $newamount;		
		mysqli_query($conn, "UPDATE `transactions` SET amount='$newamount' WHERE id='$neweditid'");		
		$get_transaction = mysqli_query($conn,"SELECT * from transactions where id='$neweditid'");		
	}	
		
	if(mysqli_num_rows($get_transaction)>0)
	{
		$get_transaction_rows= mysqli_fetch_assoc($get_transaction);
		
		//print_r($get_transaction_rows);
		
		$get_account = mysqli_query($conn,"SELECT * from account where id = ".$get_transaction_rows['accountid']);
		$get_accountrow = mysqli_fetch_assoc($get_account);
		//print_r($get_accountrow);
	}
}

/*
if(isset($_POST['Reject']))
{ 
	$update_reject_status = "UPDATE transactions SET status  ='Reject' where id=".$_GET['edit_id'];
	if(mysqli_query($conn,$update_reject_status)==TRUE)
	{
		$success = 'Transaction Rejected';
	}
}*/
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
.form-group
{
	margin-bottom: unset;
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
	height: unset !important;
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
</div>
<div class="container" >
	<center><h2><strong>Transaction Details - <?php echo $get_accountrow['username']; ?>  < <?php echo $get_transaction_rows['status']; ?>> </strong></h2></center>
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
        <div class="container-fluid">
        	<div class="row">
                <div class="col-sm-12">
                    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                        <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data - <?php echo $get_transaction_rows['transactiontype']; ?></legend>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Transaction Id</label>
                            <div class="col-sm-8">
                            <?php echo $get_transaction_rows['id']; ?>
                            </div>
                        </div>
                        <input type="hidden" name="transaction_id" value="<?php echo $get_transaction_rows['id']; ?>" />
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">IP Address</label>
                            <div class="col-sm-8">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Created On</label>
                            <div class="col-sm-8">
                            <?php echo $get_transaction_rows['transferdate'].' '.$get_transaction_rows['hours'].':'.$get_transaction_rows['minutes'].':'.$get_transaction_rows['seconds']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                            <div class="col-sm-8">
                            <?php echo $get_transaction_rows['transferdate'].' '.$get_transaction_rows['hours'].':'.$get_transaction_rows['minutes'].':'.$get_transaction_rows['seconds']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Reference No</label>
                            <div class="col-sm-8">
                            <?php echo $get_transaction_rows['reference_no']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Amount</label>
                            <div class="col-sm-8">
                            <?php //echo $get_transaction_rows['amount']; ?>
                            <input type="text" name="amount" value="<? echo $get_transaction_rows['amount']; ?>"/>
                            </div>
                        </div>
						<input type="hidden" name="hwe_transaction_type_chek" value="<?php echo $get_transaction_rows['transactiontype']; ?>">
						<?php
						if(($get_transaction_rows['transactiontype'] == 'Deposit')){														
						?>
							<div class="form-group">
								<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Bonus Transaction Id</label>
                                <?php
									if(($get_transaction_rows['bonus_promotion_id']) == 0){
								?>
                                	&nbsp;&nbsp;
                                <?php
										echo 'None';								
									}
									else{
								?>
								<div class="col-sm-8">
                                <a style="text-decoration: underline;color:#0055ff;" href="javascript:void(0);" onclick="openwindow('approve_reject_transaction.php?edit_id=<?php echo $get_transaction_rows['bonus_promotion_id'];?>');">
								<? echo $get_transaction_rows['bonus_promotion_id']; ?>
                                </a>
								</div>
                                <?php																											
									}
								?>
							</div>
							<?php
							$bonus_promotion_id = $get_transaction_rows['bonus_promotion_id'];
							$sql_bonus_tr = "SELECT amount FROM transactions WHERE id = '$bonus_promotion_id'";
							$sql_bonus_query = mysqli_query($conn, $sql_bonus_tr);
							$sql_bonus_row = mysqli_fetch_assoc($sql_bonus_query);
							$amount_bonus_t = $sql_bonus_row['amount'];
							?>
							<div class="form-group">
								<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Bonus Amount</label>
                                <?php 
									if(($amount_bonus_t == 0)){

								?>
                                	&nbsp;&nbsp;
                                <?php
									echo 'None';								
									}
                                	else
									{
								?>
								<div class="col-sm-8"><? echo $amount_bonus_t; ?>
								</div>                                
                                <?php										
									}
								?>
							</div>
							<div class="form-group">
                                <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Bank Account</label>
                                <div class="col-sm-8">
                                     <select name="Banktype_deposit">
                                        <?php
										$bankid = $get_transaction_rows['bankid'];		
                                        $get_bank_account= "select * from bank_account";
                                        $get_bank_account_query = mysqli_query($conn,$get_bank_account);
                                        if(mysqli_num_rows($get_bank_account_query)>0)
                                        {
      
                                            while($get_bank_account_row = mysqli_fetch_assoc($get_bank_account_query))
                                            {
												
												$bank_account_id = $get_bank_account_row['id'];
												$bank_account_code = $get_bank_account_row['bank_account_code'];
												$bank_account_name = $get_bank_account_row['bank_account_name'];
												$bank_account_number = $get_bank_account_row['bank_account_number'];
												$bank_account_status = $get_bank_account_row['status'];
												
												$option_text = $bank_account_code.' - '.$bank_account_name.' ['.$bank_account_number.'] '.ucfirst($bank_account_status);
												
												$make_option_selected = '';
												if($bank_account_id == $bankid){
													$make_option_selected = 'selected="selected"';
												}
                                        ?>
                                        <option value="<?php echo $bank_account_id; ?>" <?php echo $make_option_selected; ?>><?php echo $option_text;?></option>
											<?php 
											}
                                        }?>
                                    </select>
                                </div>
                            </div>
							
						<?php		
						}
						else if($get_transaction_rows['transactiontype'] == 'Withdrawal'){
						?>
						<div class="form-group">
							<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Bank Account</label>
							<div class="col-sm-8">
								 <select name="Banktype_deposit">
									<?php
									$withdrawal_bank_id = $get_transaction_rows['withdrawal_bank_id'];		
									$get_bank_account= "select * from bank_account";
									$get_bank_account_query = mysqli_query($conn,$get_bank_account);
									if(mysqli_num_rows($get_bank_account_query)>0)
									{
  
										while($get_bank_account_row = mysqli_fetch_assoc($get_bank_account_query))
										{
											
											$bank_account_id = $get_bank_account_row['id'];
											$bank_account_code = $get_bank_account_row['bank_account_code'];
											$bank_account_name = $get_bank_account_row['bank_account_name'];
											$bank_account_number = $get_bank_account_row['bank_account_number'];
											$bank_account_status = $get_bank_account_row['status'];
											
											$option_text = $bank_account_code.' - '.$bank_account_name.' ['.$bank_account_number.'] '.ucfirst($bank_account_status);
											
											$make_option_selected = '';
											if($bank_account_id == $withdrawal_bank_id){
												$make_option_selected = 'selected="selected"';
											}
									?>
									<option value="<?php echo $bank_account_id; ?>" <?php echo $make_option_selected; ?>><?php echo $option_text;?></option>
										<?php 
										}
									}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Withdraw To Bank Account</label>
							<div class="col-sm-8">
								<strong>
								<?php 
								$withdrawal_bank_id = $get_transaction_rows['withdrawal_bank_id'];	
								$account_name = $get_transaction_rows['account_name'];
								$bank_account_number = $get_transaction_rows['bank_account_number'];
							
								if($withdrawal_bank_id != 0){
									$get_bank_account= "select * from bank_account WHERE id = '$withdrawal_bank_id'";
									$get_bank_account_query = mysqli_query($conn,$get_bank_account);
									$get_bank_account_row = mysqli_fetch_assoc($get_bank_account_query);
									$bank_id_from_bankacc_tb = $get_bank_account_row['bank_id'];
									$get_bank_sql = "SELECT short_name FROM bank WHERE id = '$bank_id_from_bankacc_tb'";
									$get_bank_query = mysqli_query($conn, $get_bank_sql);
									$get_bank_row = mysqli_fetch_assoc($get_bank_query);
									$short_name = $get_bank_row['short_name'];
									echo $account_name.' | '.$bank_account_number.' | '.$short_name;
								}else{
									echo '----';
								}?></strong>
							</div>
						</div>	
						
						<?php						
						}
						else if($get_transaction_rows['transactiontype'] == 'Transfer'){
								
						}
						else if($get_transaction_rows['transactiontype'] == 'Bonus'){																							
						?>

                        <div class="form-group">
								<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;"> Bonus Type</label>
                            <?php 
								$get_promotion = "select name from promotion WHERE id= ".$get_transaction_rows['bonus_promotion_id'];
	                            $result = mysqli_query($conn,$get_promotion);
								$get_promotion_row=mysqli_fetch_assoc($result);
								
								echo '&nbsp;&nbsp;'.$get_promotion_row['name'];
							?>    
							</div>
                        
							<div class="form-group">
								<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;"> Deposit Transaction Id</label>
                                <?php
									if(($get_transaction_rows['deposit_transaction_id']) == 0){
								?>
                                	&nbsp;&nbsp;
                                <?php
										echo 'None';								
									}
									else{
								?>
								<div class="col-sm-8">
                                <a style="text-decoration: underline;color:#0055ff;" href="javascript:void();" onclick="openwindow('approve_reject_transaction.php?edit_id=<?php echo $get_transaction_rows['deposit_transaction_id'];?>');">
								<? echo $get_transaction_rows['deposit_transaction_id']; ?>
                                </a>
								</div>
                                <?php																											
									}
								?>
							</div>
							<?php
							$deposit_transaction_id = $get_transaction_rows['deposit_transaction_id'];
							$sql_deposit_tr = "SELECT amount FROM transactions WHERE id = '$deposit_transaction_id'";
							$sql_deposit_query = mysqli_query($conn, $sql_deposit_tr);
							$sql_deposit_row = mysqli_fetch_assoc($sql_deposit_query);
							$amount_bonus_depost = $sql_deposit_row['amount'];
							?>
							<div class="form-group">
								<label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;"> Deposit Amount</label>
                                <?php 
									if(($amount_bonus_depost!=='0')){																		
								?>
                                
                                <div class="col-sm-8"><? echo $amount_bonus_depost; ?>
								</div>
                                	
                                <?php																	
									}								
                                	else
									{
								?>
                                &nbsp;&nbsp;
                                <?php
										echo 'None';																		
									}
								?>
							</div>
							
						<?php	
						}

						
						if($get_transaction_rows['transactiontype']!='Bonus' && $get_transaction_rows['transactiontype']!='Withdrawal')
						{
						?>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Products Transaction From</label>
                            <div class="col-sm-8">
							<strong>
                            <?php $productfromid = $get_transaction_rows['productid_from']; 
								$getproductname=  mysqli_query($conn,"select name from products where id=".$productfromid);
								if(mysqli_num_rows($getproductname)>0)
								{
									$getproductnamerow = mysqli_fetch_assoc($getproductname);
									echo $getproductnamerow['name'];
								}
							?>
							</strong>
                            </div>
                        </div>
                        <? } ?>
                        <?
						if($get_transaction_rows['transactiontype']=='Deposit')
						{
						?>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Payment Method</label>
                            <div class="col-sm-8">
                            <?php echo $get_transaction_rows['payment_method'];  ?>
                            </div>
                        </div>
                        <?
						}
						?>
                        <?
						if($get_transaction_rows['transactiontype']!='Bonus' && $get_transaction_rows['transactiontype']!='Withdrawal')
						{
						?>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Products To</label>
                            <div class="col-sm-8">
							<strong>	
                            <?php 
								
							$productid_to = $get_transaction_rows['productid_to']; 
								$getproductname=  mysqli_query($conn,"select name from products where id=".$productid_to);
								if(mysqli_num_rows($getproductname)>0)
								{
									$getproductnamerow = mysqli_fetch_assoc($getproductname);
									echo $getproductnamerow['name'];
								} ?>
								</strong>
                            </div>
                        </div>
                        <? }?>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Status</label>
                            <div class="col-sm-8">
                            <?php //echo $get_transaction_rows['status']; ?>
                            <select name="status">
                            	<option value="Approve" <? if($get_transaction_rows['status']=='Approve'){echo 'selected="selected"';}?>>Approve</option>
                                <option value="Reject" <? if($get_transaction_rows['status']=='Reject'){echo 'selected="selected"';}?>>Reject</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Submit By</label>
                            <div class="col-sm-8">
                            <?php echo $get_accountrow['username'].' (User)'; ?>
                            </div>
                        </div>
                    </fieldset>
                    
                    <br/>
                    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                        <legend style="background:#fff; width: auto; padding: 4px;">User's Data</legend>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Username</label>
                            <div class="col-sm-8">
                            <?php echo $get_accountrow['username']; ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Full Name</label>
                            <div class="col-sm-8">
                             <?php echo $get_accountrow['fullname']; ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Telephone No</label>
                            <div class="col-sm-8">
                             <?php echo $get_accountrow['username']; ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Email</label>
                            <div class="col-sm-8">
                             <?php echo $get_accountrow['email']; ?>
                            </div>
                        </div>
                    </fieldset>
                     <br/>
					 <?php
					 $remark = $get_transaction_rows['remark'];
					 $reject_reason = $get_transaction_rows['reject_reason'];
					 
					 
					 ?>
                    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                        <legend style="background:#fff; width: auto; padding: 4px;">Other Data</legend>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Reject Reason</label>
                            <div class="col-sm-8">
                            	<select name="reject_reason">
                                	<option value=""> - </option>
                                    <option value="Bank Not Receiving" <?php if($reject_reason == 'Bank Not Receiving'){ echo 'selected="selected"'; }?>>Bank Not Receiving</option>
                                    <option value="Bank Maintenance" <?php if($reject_reason == 'Bank Maintenance'){ echo 'selected="selected"'; }?>>Bank Maintenance</option>
                                    <option value="Game Maintenance" <?php if($reject_reason == 'Game Maintenance'){ echo 'selected="selected"'; }?>>Game Maintenance</option>
                                    <option value="Unclaim Ticket" <?php if($reject_reason == 'Unclaim Ticket'){ echo 'selected="selected"'; }?>>Unclaim Ticket</option>
                                    <option value="DONE CLAIMED" <?php if($reject_reason == 'DONE CLAIMED'){ echo 'selected="selected"'; }?>>DONE CLAIMED</option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Comment</label>
                            <div class="col-sm-8">
                            	<textarea name="comment"><?php echo $remark; ?></textarea>
                            </div>
                        </div>
                         
                    </fieldset>
                     <br/>
                    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                        <legend style="background:#fff; width: auto; padding: 4px;">Confirmed Data</legend>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Confirm User</label>
                            <div class="col-sm-8">
                            	<?php echo $get_transaction_rows['confrimedby']; ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-3" style="margin-left: 10px;padding-top: unset;">Confirm Date</label>
                            <div class="col-sm-8">
                            	<?php echo $get_transaction_rows['confirmeddate']; ?>
                            </div>
                        </div>
                         
                    </fieldset>
                </div>
            </div>
            <div class="row" style="display: unset;">
            	<div class="btn_bar1" style="bottom:0px;text-align: center;">
                    <input class="btn1" type="submit" name="Save" value="Save">&nbsp;
                    <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
                </div>
            </div>
        </div>
    </form> 
</div>
</body>
</html>
<script>
	
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

$('select[name=reject_reason]').on('change', function(){
	$('textarea[name=comment]').val($(this).val());
});
</script>