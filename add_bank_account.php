<?php
session_start();

$_SESSION['page']='bank';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$success = '';
if(isset($_POST['sbtt']))
{	
	$ibnkid = $_POST['ibnkid'];
	$BankAccountName = $_POST['BankAccountName'];
	$BankAccountNumber = $_POST['BankAccountNumber'];
	$BankAccountCode = $_POST['BankAccountCode'];	
	$currency = $_POST['currency'];
	$status = $_POST['status'];	
	
	$bankaccount_editid = $_POST['bankaccount_editid'];
	if(!empty($bankaccount_editid))
	{
		$update_sql = "UPDATE  bank_account SET `bank_id`=$ibnkid, `bank_account_name`='$BankAccountName',`bank_account_number`='$BankAccountNumber',`bank_account_code`='$BankAccountCode' ,`currency`='$currency' ,`status`='$status' where id =$bankaccount_editid";
		if(mysqli_query($conn,$update_sql)==TRUE)
		{
			$success = 'Bank Account Detail Updated Successfully.';
		}
		
	}
	else
	{
	
		$insert_sql = "INSERT INTO bank_account SET `bank_id`=$ibnkid, `bank_account_name`='$BankAccountName',`bank_account_number`='$BankAccountNumber',`bank_account_code`='$BankAccountCode' ,`currency`='$currency' ,`status`='$status'";
		
		if(mysqli_query($conn,$insert_sql)==TRUE)
		{
			$success = 'Bank Account Added Successfully.';
		}
	}
}


$bank_id = $bank_account_name = $bank_account_number = $bank_account_code = $currency=$status = '';
$edit_id = '';
if(isset($_GET['edit_id']))
{
	$edit_id = $_GET['edit_id'];
	
	$get_bankaccount_detail = mysqli_query($conn,"SELECT * from bank_account where id = $edit_id ");
	if(mysqli_num_rows($get_bankaccount_detail)>0)
	{
		$rows = mysqli_fetch_assoc($get_bankaccount_detail);
		
		$bank_id =$rows['bank_id'];
		$bank_account_name=$rows['bank_account_name'];
		$bank_account_number=$rows['bank_account_number'];
		$bank_account_code = $rows['bank_account_code'];
		$currency=$rows['currency'];
		$status = $rows['status'];
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
	<a href="bank.php" id="sc8_1">Bank</a>
    <span>|</span>
    <a href="bank_account.php" id="sc8_1" class="actives">Bank Account</a>
</div>
<div class="container">
 <center><h2><strong>New Bank Account</strong></h2></center>
 
 
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
  <input type="hidden" name="bankaccount_editid" value="<?php echo $edit_id;?>"/>
   <div class="container-fluid">
   	<div class="row">
    	<div class="col-sm-12">
           
            <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">New Bank Account</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Bank</label>
                  <div class="col-sm-9">
                        <select name="ibnkid" required>
                        	<?php 
							$getbank = mysqli_query($conn,"Select id,name,short_name from bank");
							if(mysqli_num_rows($getbank)>0)
							{
								while($rowbank = mysqli_fetch_assoc($getbank))
								{
							?>
							<option value="<?php echo $rowbank['id']; ?>" <?php if($bank_id==$rowbank['id']){echo "selected";}?>><?php echo $rowbank['name']; ?> (<?php echo $rowbank['short_name']; ?>)</option>
							<?php
								}
							}
							?>
                        
							<!--<option label="MAYBANK (MBB)" value="1">MAYBANK (MBB)</option>
                            <option label="BSN BANK (BSN)" value="2">BSN BANK (BSN)</option>
                            <option label="RHB BANK (RHB)" value="3">RHB BANK (RHB)</option>
                            <option label="PUBLIC BANK (PBB)" value="4">PUBLIC BANK (PBB)</option>
                            <option label="CIMB BANK (CIMB)" value="5">CIMB BANK (CIMB)</option>
                            <option label="HLB BANK (HLB)" value="6">HLB BANK (HLB)</option>
                            <option label="BANK ISLAM (BIM)" value="7">BANK ISLAM (BIM)</option>
                            <option label="UOB BANK (UOB)" value="8">UOB BANK (UOB)</option>
                            <option label="OCBC BANK (OCBC)" value="9">OCBC BANK (OCBC)</option>
                            <option label="AMBANK (AMB)" value="10">AMBANK (AMB)</option>
                            <option label="AFFIN BANK (AFFIN)" value="12">AFFIN BANK (AFFIN)</option>
                            <option label="BANK RAKYAT (BRM)" value="14">BANK RAKYAT (BRM)</option>
                            <option label="ALLIANCE BANK (ALL)" value="13">ALLIANCE BANK (ALL)</option>
                            <option label="MUAMALAT BANK (MUA)" value="16">MUAMALAT BANK (MUA)</option>
                            <option label="AGRO BANK (AGRO)" value="17">AGRO BANK (AGRO)</option>
                            <option label="E-WALLET T&amp;G (TNG)" value="11">E-WALLET T&amp;G (TNG)</option>
                            <option label="PARKING (PARK)" value="18">PARKING (PARK)</option>
                            <option label="HSBC BANK (HCBS)" value="19">HSBC BANK (HCBS)</option>
                            <option label="EXTRA IN (WRONG)" value="20">EXTRA IN (WRONG)</option>    -->                        
                       </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Bank Account Name</label>
                  <div class="col-sm-9">
                        <input type="text" name="BankAccountName" value="<?php echo $bank_account_name;?>" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Bank Account Number</label>
                  <div class="col-sm-9">
                        <input type="text" name="BankAccountNumber" value="<?php echo $bank_account_number;?>" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Bank Account Code</label>
                  <div class="col-sm-9">
                        <input type="text" name="BankAccountCode" value="<?php echo $bank_account_code;?>" required/>
                  </div>
                </div>
                <!--<div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Deposit Limit</label>
                  <div class="col-sm-9">
                        <input type="number" name="DepositLimit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Deposit Count Limit</label>
                  <div class="col-sm-9">
                        <input type="number" name="DepositCountLimit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Withdraw Limit</label>
                  <div class="col-sm-9">
                        <input type="number" name="WithdrawLimit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Withdraw Count Limit</label>
                  <div class="col-sm-9">
                        <input type="number" name="WithdrawCountLimit" value=""/>
                  </div>
                </div>-->
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Currency</label>
                  <div class="col-sm-9">
                       <select name="currency" required>
                       	<option value="MYR" <?php if($currency=='MYR'){echo 'selected';}?>>MYR</option>
                        <option value="TNG" <?php if($currency=='TNG'){echo 'selected';}?>>TNG</option>
                       </select>
                  </div>
                </div>
               <!-- <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Expiry Date</label>
                  <div class="col-sm-9">
                        Transaction From <input type="date" name="transactionfrom" value=""/>
                        To <input type="date" name="transactionto" value=""/>
                  </div>
                </div>-->
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Status</label>
                  <div class="col-sm-9">
                       <input type="radio" name="status" value="Active" <?php if($status=='Active'){echo 'checked';}?> required/>&nbsp;Active
                       &nbsp;&nbsp;
                       <input type="radio" name="status" value="Suspended" <?php if($status=='Suspended'){echo 'checked';}?> required/>&nbsp;Suspended
                  </div>
                </div>
                
			</fieldset>
      	</div>       
    </div>
    <br/>
   <div style="margin-left:1%;"><p>( <span class="red">*</span> ) Mandatory field</p></div>
   <div class="btn_bar1" style="bottom:0px;text-align: center;">
        <input class="btn1" type="submit" name="sbtt" value="Submit">&nbsp;
        <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
	</div>
  
</div>
  </form>

 </body>
 </html>