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


if(isset($_GET['t_type']) && isset($_GET['delete_id'])){
	$delete_id= $_GET['delete_id'];
	$t_type = $_GET['t_type'];
	if($t_type == 'Deposit' || $t_type == 'Withdrawal'){
		$delsql = "DELETE FROM `transactions` WHERE id = '$delete_id'";
		mysqli_query($conn, $delsql);
	}
	else{
		$delsql = "DELETE FROM `bank_transaction` WHERE id= $delete_id";
		mysqli_query($conn, $delsql);
	}
}

$bnksql= "SELECT id, bankaccount_id, transaction_type, date, amount, remark, created_by, status FROM `bank_transaction` where 1=1";
$bnksql2 = "SELECT id, IF(transactiontype = 'Withdrawal', withdrawal_bank_id, bankid ) AS bankaccount_id, transactiontype AS transaction_type, CONCAT(transferdate,' ',hours,':',minutes,':',seconds) AS date, amount, remark, createdby AS created_by, status FROM transactions WHERE 1=1";
$iaccList= $_GET['iaccList'];	
$remarksearch= $_GET['remarksearch'];

/* 
if(isset($_GET['cashin']) && $_GET['cashin'] == 0){
	$bnksql.=" AND transaction_type >= '$fromdate'";
} */

if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) || (isset($_GET['todate']) && !empty($_GET['todate'])))
{
	$bnksql2.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_GET['fromdate']."' AND '".$_GET['todate']."'";
}
				
if(isset($_GET['fromdate']) && !empty($_GET['fromdate']))
{
	$fromdate = $_GET['fromdate'];
	$bnksql.=" AND date >= '$fromdate'";
}
	

if(isset($_GET['todate']) && !empty($_GET['todate']))
{
		$todate = $_GET['todate'];

		$bnksql.=" AND date <= '$todate'";
}
		

if(isset($iaccList) && !empty($iaccList)){
	$bnksql.= " AND bankaccount_id= $iaccList";	
	$bnksql2 .= " AND IF(`transactiontype` = 'Withdrawal', `withdrawal_bank_id`, `bankid`) = '$iaccList'";
}

if(isset($remarksearch) && !empty($remarksearch))
{		
	$bnksql.= " AND remark LIKE '%$remarksearch%'";
	$bnksql2 .= " AND remark = '$remarksearch'";
}

if(isset($_GET['transaction_type']) && !empty($_GET['transaction_type']))
{
	$transactiontypes= "'" . implode("','", $_GET['transaction_type']) . "'";	
	$bnksql.= " AND transaction_type IN ($transactiontypes)";
	$bnksql2 .= " AND transactiontype IN ($transactiontypes)";
}
else{
	$bnksql2 .= " AND transactiontype IN ('Deposit', 'Withdrawal')";
}

$bnksql2 .= " AND status = 'Approve'";



$newbankq = '('.$bnksql.') union ('.$bnksql2.') ORDER BY date DESC';

$bnkres= mysqli_query($conn, $newbankq);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title> 
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="src/jquery.table2excel.js"></script>
    <script src="jquery.datetimepicker.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>   
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />   
    <link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/>
    
<style>

table.dataTable tbody th, table.dataTable tbody td {
	padding: 10px 18px 6px 18px !important;
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
    </style>
    
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
<div class="container" >
  <div class="filternav">
	<h2>Bank Transaction</h2>
		<form method="get" enctype="multipart/form-data">
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					<input type="text" name="fromdate" id="fromdate" value="<?php echo $_GET['fromdate']?>"/> ~
					<input type="text" name="todate" id="todate" value="<?php echo $_GET['todate'];?>"/>
                    
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
				<div class="col-md-2"><b>Account</b></div>
				<div class="col-md-10">					
					<select id="bankAccList" name="iaccList">
                        <option selected="selected" value="" data-select2-id="2">All</option>
                        <option value="-1" data-select2-id="5">AllActive</option>
                        <option value="-2" data-select2-id="6">AllDisable</option>
                        <optgroup label="Active" data-select2-id="7">
                        
                        	<?php
								$optsql= "SELECT * FROM `bank_account`";
								$optres= mysqli_query($conn, $optsql);
								
								while($optrow= mysqli_fetch_assoc($optres))
								{
							?>
                            
                            <option value="<?php echo $optrow['id'];?>" <?php if($optrow['id']==$_GET['iaccList']){echo 'selected'; } ?> data-select2-id="8"><?php echo  $optrow['bank_account_code']."-".$optrow['bank_account_name']."[".$optrow['bank_account_number']."]";?></option>                            
							
							<?php
								}
							?>
                            
                        </optgroup>
                        <optgroup label="Disable" data-select2-id="16"></optgroup>
                    </select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2"><b>Remark Search</b></div>
				<div class="col-md-10">					
					<input type="text" name="remarksearch" value="<?php echo $_GET['remarksearch']; ?>"/>
				</div>
			</div>
                        
			<div class="form-group">
				<div class="col-md-2">
					<b>Transaction Type</b>
				</div>
				<div class="col-md-10">
                
                <?php
					$transactiontype= array();
					
					if(!empty($_GET['transaction_type']))
					{
						$transactiontype= $_GET['transaction_type'];	
					}
					
					if(empty($_GET['transaction_type']))
					{
					?>
					<script type="text/javascript">
					$(document).ready(function(){
					$("#allcheckbox").trigger('click');
					});
					</script>
					<?php
					}
			?>
                
					<input type="checkbox" name="" class="transactiontype" id= "allcheckbox" value="All"/>&nbsp;All
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="Deposit" <?php if(in_array("Deposit", $transactiontype)){ echo "checked"; }?>/>&nbsp;DEPOSIT
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="Withdrawal" <?php if(in_array("Withdrawal", $transactiontype)){ echo "checked"; }?>/>&nbsp;WITHDRAW
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="TF Deposit" <?php if(in_array("TF Deposit", $transactiontype)){ echo "checked"; }?> />&nbsp;TF DEPOSIT
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="TF Withdrawal" <?php if(in_array("TF Withdrawal", $transactiontype)){ echo "checked"; }?> />&nbsp;TF WITHDRAWAL
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="Transfer(+)" <?php if(in_array("Transfer(+)", $transactiontype)){ echo "checked"; }?> />&nbsp;TRANSFER (+)
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="Transfer(-)" <?php if(in_array("Transfer(-)", $transactiontype)){ echo "checked"; }?> />&nbsp;TRANSFER (-)
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="Other(+)" <?php if(in_array("Other(+)", $transactiontype)){ echo "checked"; }?> />&nbsp;OTHER (+)
                    &nbsp;
                    <input type="checkbox" name="transaction_type[]" class="transactiontype" value="Other(-)" <?php if(in_array("Other(-)", $transactiontype)){ echo "checked"; }?> />OTHER (-)
<!--                     &nbsp;
                    <input type="checkbox" name="transaction_type" value="REBATE"/>REBATE
-->				</div>
			</div>
            
			
			<div>
				<input type="submit" class="btn btn-secondary" name="submit" id="submit" value="Enquiry"/>
                <a href="add_bank_transaction.php" class="btn btn-secondary">New</a>
				<input type="button" class="btn btn-secondary" name="exportreportCurrent" value="Export Report(Current)"/>
                <input type="button" class="btn btn-secondary" name="exportreportAll" value="Export Report(All)"/>
			</div>
		</form>
    </div>
    <br/>
    <br/>
    <div class="resulttable">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results dataTable" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                  <!-- <th>No</th> -->
                  <th class="col-md-3 col-xs-3">Transaction Id</th>
                  <th class="col-md-3 col-xs-3">Bank</th>
                  <th class="col-md-3 col-xs-3">Code</th>
                  <th class="col-md-3 col-xs-3">Bank Account Name</th>
                  <th class="col-md-3 col-xs-3">Bank Account Number</th>
                  <th class="col-md-3 col-xs-3">Transaction Type</th>                  
                  <th class="col-md-3 col-xs-3">Time</th>
                  <th class="col-md-3 col-xs-3">Last Modified By</th>
                  <th class="col-md-3 col-xs-3">Cash In</th>
                  <th class="col-md-3 col-xs-3">Cash Out</th>                  
                  <th class="col-md-3 col-xs-3">Remark</th>
                  <th class="col-md-3 col-xs-3">Action</th>
              	</tr>
            </thead>
            <tbody>
           
            <?php				
				$all_total_cashin = 0;
				$all_total_cashout = 0;
				$count= 1;
				
				while($bnk_row= mysqli_fetch_assoc($bnkres))				
				{	
					$transaction_id = $bnk_row['id'];
					$bnkac_id= 	$bnk_row['bankaccount_id'];

					$bnkresult= mysqli_query($conn, "SELECT * FROM `bank_account` WHERE id= $bnkac_id");
					$bnk_detail= mysqli_fetch_assoc($bnkresult);
					
					$bnkid= $bnk_detail['bank_id'];
					
					$result= mysqli_query($conn, "SELECT name FROM `bank` WHERE id= $bnkid");
					$bnk_name= mysqli_fetch_assoc($result);		
					
				?>
            
            	<tr>
                  <!--<td><?php //echo $count; ?></td> -->
                  <td>
				  <?php
				  if($bnk_row['transaction_type'] == 'Deposit' || $bnk_row['transaction_type'] == 'Withdrawal'){
					echo 'BTF';
				  }
				  else{
					  echo 'BTS';
				  }
				  ?>
				   <?php echo $bnk_row['id']; ?></td>
                  <td><?php echo $bnk_name['name']; ?> </td>
                  <td><?php echo $bnk_detail['bank_account_code']; ?></td>
                  <td><?php echo $bnk_detail['bank_account_name']; ?></td>
				  <td><?php echo $bnk_detail['bank_account_number']; ?></td>                 
				  <td><?php echo $bnk_row['transaction_type']; ?></td>                  
                  <td><?php echo $bnk_row['date']; ?></td>
                  <td><?php echo $bnk_row['created_by']; ?></td>
                  <td>
				  <?php
				  if($bnk_row['transaction_type'] == 'Deposit' || $bnk_row['transaction_type'] == 'TF Deposit' || $bnk_row['transaction_type'] == 'Transfer(+)' || $bnk_row['transaction_type'] == 'Other(+)'){
					$amount = $bnk_row['amount'];
					echo $amount;
					$all_total_cashin += $amount;
				  }
				  ?>
				  </td>
                  <td>
				  <?php
				  if($bnk_row['transaction_type'] == 'Withdrawal' || $bnk_row['transaction_type'] == 'TF Withdrawal' || $bnk_row['transaction_type'] == 'Transfer(-)' || $bnk_row['transaction_type'] == 'Other(-)'){
					$amount = $bnk_row['amount'];
					echo $amount;
					$all_total_cashout += $amount;
				  }
				  ?>
				  </td>
                  <td><?php echo $bnk_row['remark'];?></td>   
                  <td>
				  <?php
				  if($bnk_row['transaction_type'] == 'Deposit' || $bnk_row['transaction_type'] == 'Withdrawal'){
					?>  
				  <a href="approve_reject_transaction.php?edit_id=<?php echo $transaction_id;?>"><i class="fa fa-search ml-2"></i></a>
				  <?php
				  }
				  else{
					  ?>  
				  <a href="edit_bank_transaction.php?id=<?php echo $transaction_id;?>"><i class="fa fa-search ml-2"></i></a>
				  <?php
				  }
				  ?><a href="?delete_id=<?php echo $transaction_id;?>&t_type=<?php echo $bnk_row['transaction_type']; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash ml-2"></i></a></td>
              	</tr> 
            
				<?php
					$count++;	
				}
			?>   
                        
            </tbody>
            <tfoot>
            	<tr style="background: #fafafa;">
                	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Total</td>
                    <td><?php echo number_format($all_total_cashin, 2); ?></td>
                    <td><?php echo number_format($all_total_cashout, 2); ?></td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>

<script>
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
	
	var clicked = false;
	
	$("#allcheckbox").on("click", function() {
  		$(".transactiontype").prop("checked", !clicked);
  		clicked = !clicked;
	}); 	

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
	
	
	$(document).ready( function () {
		$('#table2excel').DataTable({
			"bInfo": false,
			"bLengthChange": false,
			"bFilter": false,
			"order": [[ 7, "desc" ]]
		});
	});
	
	/*$('#fromdate').datetimepicker({
		inline:true,
	});
	
	$('#todate').datetimepicker({
		inline:true,
	});*/
	
	 $('#fromdate').datetimepicker('show');
	
   	 $('#todate').datetimepicker('show');	

</script>