<?php
session_start();

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

if(isset($_POST['sbtt'])){
	$account= $_POST['ibankaccount'];
	$transaction_type= $_POST['ibanktransactiontype'];
	$time= $_POST['Time'];
	$amount= floatval($_POST['Amount']);
	$remark= $_POST['Remark'];
	
	$bnk_insert= "INSERT INTO `bank_transaction` (bankaccount_id, transaction_type, date, amount, remark, created_by) VALUES ($account, '$transaction_type', '$time', $amount, '$remark', '$user')";
	
	$bnk_trans_result= mysqli_query($conn, $bnk_insert);
}

$bnkquery= "SELECT * FROM `bank_account`";
$bnkresult= mysqli_query($conn, $bnkquery);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
    
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


 <?php 
  $filter = $_POST['aflt'];
 ?>

 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="bank_transaction.php" id="sc8_1" class="actives">Bank Transaction</a>
    <span>|</span>
    <a href="finance_summary.php" id="sc8_1">Finance Summary</a>
    <span>|</span>
    <a href="finance_summary_lite.php" id="sc8_1">Finance Summary (Lite)</a>
    <span>|</span>
    <a href="daily_summary.php" id="sc8_1">Daily Summary</a>
</div>
<div class="container">
 <center><h2><strong>NewBank Transaction</strong></h2></center>
  <form class="form-horizontal" method="post">
   <div class="container-fluid">
   	<div class="row">
    	<div class="col-sm-12">
           
            <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">NewBank Transaction</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Account</label>
                  <div class="col-sm-9">
                        <select name="ibankaccount" required>
                          
                        	<?php
								while($bnk_rows= mysqli_fetch_assoc($bnkresult))
								{
 							?>                       
                            		<option value="<?php echo $bnk_rows['id']?>"><?php echo $bnk_rows['bank_account_code']." - ".$bnk_rows['bank_account_name']."[".$bnk_rows['bank_account_number']."]"; ?></option>
                            <?php
								}
                     		?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Transaction Type</label>
                  <div class="col-sm-9">
                        <select name="ibanktransactiontype" required>
								<!--
								<option label="Deposit" value="Deposit">Deposit</option>
                                <option label="Withdrawal" value="Withdrawal">Withdrawal</option>
								-->
								<option label="TF Deposit" value="TF Deposit">TF Deposit</option>
                                <option label="TF Withdrawal" value="TF Withdrawal">TF Withdrawal</option>
                                <option label="Transfer(+)" value="Transfer(+)">Transfer(+)</option>
                                <option label="Transfer(-)" value="Transfer(-)">Transfer(-)</option>
                                <option label="Other(+)" value="Other(+)">Other(+)</option>
                                <option label="Other(-)" value="Other(-)">Other(-)</option>

							</select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Time</label>
                  <div class="col-sm-9">
                        <input type="datetime-local" name="Time" value="" class="textbox1" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Amount</label>
                  <div class="col-sm-9">
                        <input type="text" name="Amount" value="" required/>
                  </div>
                </div>
             	<div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;"><span style="color:red;">*</span>Remark</label>
                  <div class="col-sm-9">
                       <textarea name="Remark" required></textarea>
                  </div>
                </div>	
                
			</fieldset>
      	</div>       
    </div>
    <br/>
   <div style="margin-left:1%;"><p>( <span class="red">*</span> ) Mandatory field</p></div>
   <div class="btn_bar1" style="bottom:0px;text-align: center;">
        <input class="btn1" type="submit" name="sbtt" value="Submit">&nbsp;
        <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back">
	</div>
  
</div>
  </form>

 </body>
 </html>