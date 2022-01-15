<?php
session_start();

$_SESSION['page']='finance';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
$success='';
$user=$_SESSION['user'];
$get_transaction_rows='';
$get_accountrow='';

$confirmdate = date('Y-m-d H:i:s');


if(!isset($_GET['id'])){
	die("Invalid URL");
}

if(empty($_GET['id'])){
	die("Invalid URL");
}

$this_id = $_GET['id'];

if(isset($_POST['Save']))
{ 
	$bank_account = $_POST['bank_account'];
	$tranaction_type =$_POST['tranaction_type'];
	$time = date('Y-m-d H:i:s', strtotime($_POST['time']));
	$amount = $_POST['amount'];
	$remark = $_POST['remark'];
	
	
	$update_bank_transaction = "UPDATE bank_transaction SET bankaccount_id = '$bank_account', transaction_type = '$tranaction_type', date = '$time', amount = '$amount', remark = '$remark' WHERE id = '$this_id'";
	if(mysqli_query($conn,$update_bank_transaction)==TRUE)
	{
		$success = 'Transaction Updated Successfull';
	}
}


$bank_transaction_sql = "SELECT * FROM bank_transaction WHERE id = '$this_id'";
$bank_transaction_query = mysqli_query($conn, $bank_transaction_sql);
if(mysqli_num_rows($bank_transaction_query) == 0){
	die("Invalid Transaction");
}

$bank_transaction_row = mysqli_fetch_assoc($bank_transaction_query);
$bankaccount_id = $bank_transaction_row['bankaccount_id'];
$transaction_type = $bank_transaction_row['transaction_type'];
$date = $bank_transaction_row['date'];
$amount = $bank_transaction_row['amount'];
$remark = $bank_transaction_row['remark'];
$created_by = $bank_transaction_row['created_by'];
$status = $bank_transaction_row['status'];
$actiontype = $bank_transaction_row['actiontype'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

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
	<a href="bank_transaction.php" id="sc8_1" class="actives">Bank Transaction</a>
    <span>|</span>
    <a href="finance_summary.php" id="sc8_1">Finance Summary</a>
    <span>|</span>
    <a href="finance_summary_lite.php" id="sc8_1">Finance Summary (Lite)</a>
    <span>|</span>
    <a href="daily_summary.php" id="sc8_1">Daily Summary</a>
</div>
<div class="container" >
	<center><h2><strong>EditBank Transaction</strong></h2></center>
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
                        <legend style="background:#fff; width: auto; padding: 4px;">EditBank Transaction</legend>
						
						<div class="form-group">
							<label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bank Account</label>
							<div class="col-sm-9">
								 <select name="bank_account">
									<?php	
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
											if($bank_account_id == $bankaccount_id){
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
                            <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transaction Type</label>
                            <div class="col-sm-9">
								<select name="tranaction_type">
									<option value="TF Deposit" <?php if($transaction_type == 'TF Deposit'){ echo 'selected="selected"'; }?> >TF Deposit</option>
									<option value="TF Withdrawal" <?php if($transaction_type == 'TF Withdrawal'){ echo 'selected="selected"'; }?> >TF Deposit</option>
									<option value="Transfer(+)" <?php if($transaction_type == 'Transfer(+)'){ echo 'selected="selected"'; }?> >Transfer (+)</option>
									<option value="Transfer(-)" <?php if($transaction_type == 'Transfer(-)'){ echo 'selected="selected"'; }?> >Transfer (-)</option>
									<option value="Other(+)" <?php if($transaction_type == 'Other(+)'){ echo 'selected="selected"'; }?> >Other (+)</option>
									<option value="Other(-)" <?php if($transaction_type == 'Other(-)'){ echo 'selected="selected"'; }?> >Other (-)</option>
								</select>
                            </div>
                        </div>
						<div class="form-group">
						  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Time</label>
						  <div class="col-sm-9">
								<input type="date" name="time" value="<?php echo $date; ?>" class="textbox1" required/>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Amount</label>
						  <div class="col-sm-9">
								<input type="text" name="amount" value="<?php echo $amount; ?>" required/>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Remark</label>
						  <div class="col-sm-9">
							   <textarea name="remark" required><?php echo $remark; ?></textarea>
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