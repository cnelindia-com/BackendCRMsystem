<?php
session_start();

$_SESSION['page']='report';

$_SESSION['pagereport']='performancereport';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";
}


function displayDates($date1, $date2, $format = 'Y-m-d' ) {
  $dates = array();
  $current = strtotime($date1);
  $date2 = strtotime($date2);
  $stepVal = '+1 day';
  while( $current <= $date2 ) {
	 $dates[] = date($format, $current);
	 $current = strtotime($stepVal, $current);
  }
  return $dates;
}
 
$period = array();
if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) && (isset($_GET['todate']) && !empty($_GET['todate']))){	
	$fromdate= date('Y-m-d', strtotime($_GET['fromdate'])); 
	$todate= date('Y-m-d', strtotime($_GET['todate']));
	//$performsql= "SELECT COUNT(username) as new_member, DATE(createdON), createdON, id FROM `account` WHERE createdON BETWEEN '$fromdate' AND '$todate' GROUP BY DATE(createdON)";
	//echo $performsql;	
	
	$period = displayDates($fromdate, $todate);
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

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

<div id="sc8" class="tabcontent" style="display: block;">
	<a href="Finanace_Report.php" id="sc8_1">Finanace Report</a>
    <span>|</span>
    <a href="Product_Report.php" id="sc8_1">Product Report</a>
    <span>|</span>
    <a href="Member_Report.php" id="sc8_1">Member Report</a>
    <span>|</span>
    <a href="Bank_Report.php" id="sc8_1">Bank Report</a>
    <span>|</span>
    <a href="Upline_Report_Finance.php" id="sc8_1">Upline Report (Finance)</a>
    <span>|</span>
    <a href="Upline_Report_Member.php" id="sc8_1">Upline Report (Member)</a>
    <span>|</span>
    <a href="Bonus.php" id="sc8_1">Bonus</a>
    <span>|</span>
    <a href="Performanace_Report.php" id="sc8_1"  class="<?php if($_SESSION['pagereport']=='performancereport'){ echo 'actives';}?>" >Performanace Report</a>
</div>
  <div class="container" >
  <div class="filternav">
	<h2>Performance Report</h2>
		<form method="get">
        	            
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					<input type="datetime" name="fromdate" id="fromdate" value="<?php echo $_GET['fromdate']; ?>"/> ~
					<input type="datetime" name="todate" id="todate" value="<?php echo $_GET['todate']; ?>"/>
                    
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
				<input type="submit" class="btn btn-secondary" name="submit" id="submit" value="Submit"/>
				<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
	</div>
	<br/>
    <br/>
    <div class="resulttable" style="display:none;overflow: scroll;">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                    <th>NO</th>
                    <th class="col-md-3 col-xs-3">Date</th>
                    <th class="col-md-3 col-xs-3">New Member Count</th>
                    <th class="col-md-3 col-xs-3">New Member First Deposit Total</th>
                    <th class="col-md-3 col-xs-3">New Member Total Deposit Total</th>
                    <th class="col-md-3 col-xs-3">New Member Total Deposit Count</th>   
                    <th class="col-md-3 col-xs-3">Deposit Count</th>
                    <th class="col-md-3 col-xs-3">Deposit Total (A)</th>
                    <th class="col-md-3 col-xs-3">Withdraw Count</th>
                    <th class="col-md-3 col-xs-3">Withdraw Total (B)</th>
                    <th class="col-md-3 col-xs-3">Bonus Count</th> 
                    <th class="col-md-3 col-xs-3">Bonus Total (C)</th> 
                    <th class="col-md-3 col-xs-3">Winloss (A-B)</th> 
                    <th class="col-md-3 col-xs-3">Winrate (B/A)</th>
              	</tr>
            </thead>
            <tbody>
            
            	<?php 
				$count= 1;						
				
				$total_member=0;
				$first_depos_total=0;
				$total_deposit_total=0;
				$total_deposit_count=0;
				$deposit_count_total=0;
				$total_withdraw_count=0;
				$total_withdraw=0;
				$total_bonus_count=0;
				$total_bonus=0;
				$total_winloss=0;
				$total_winrate=0;
				
				/*$new_acc_id= array();
				$bnk_res= mysqli_query($conn, "SELECT bankaccount_id FROM `bank_transaction`");
				while($bnk_rows= mysqli_fetch_assoc($bnk_res))
				{
					$newly_account_id = $new_member_ids_row['id'];
					$new_acc_id[]=$newly_account_id;	
				}
				$account_ids= implode(",", $new_acc_id);*/
				
				foreach ($period as $period_date) {				
					
					$performsql = "SELECT COUNT(username) as new_member_count FROM `account` WHERE DATE(createdON) = '$period_date'";					
					$performsql_query = mysqli_query($conn, $performsql);
					$performrows = mysqli_fetch_assoc($performsql_query);			
					$total_member += $performrows['new_member_count'];			
					
					$new_member_ids_sql = "SELECT id FROM `account` WHERE DATE(createdON) = '$period_date'";
					$new_member_ids_query = mysqli_query($conn, $new_member_ids_sql);
					$single_first_deposit_total = 0;
					$single_total_deposit_total_new_account = 0;
					$single_count_deposit_total_new_account = 0;					
					
					while($new_member_ids_row = mysqli_fetch_assoc($new_member_ids_query)){												
						
						$get_first_deposit_amount_sql = "SELECT amount FROM transactions WHERE accountid = '$newly_account_id' AND  status = 'Approve' AND transactiontype='Deposit' ORDER id ASC LIMIT 0,1";
						$get_first_deposit_amount_query = mysqli_query($conn, $get_first_deposit_amount_sql);
						if(mysqli_num_rows($get_first_deposit_amount_query) > 0){
							$get_first_deposit_amount_row = mysqli_fetch_assoc($get_first_deposit_amount_query);
							$first_deposit_amount = $get_first_deposit_amount_row['amount'];
							$single_first_deposit_total += $first_deposit_amount;
						}
						
						$get_total_deposit_of_new_account_sql = "SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM transactions WHERE accountid = '$newly_account_id' AND status = 'Approve' AND transactiontype='Deposit'";
						$get_total_deposit_of_new_account_query = mysqli_query($conn, $get_total_deposit_of_new_account_sql);
						$get_total_deposit_of_new_account_row = mysqli_fetch_assoc($get_total_deposit_of_new_account_query);
						$total_deposit_of_new_account = $get_total_deposit_of_new_account_row['total_amount'];
						$count_deposit_of_new_account = $get_total_deposit_of_new_account_row['total_count'];
						
						$single_total_deposit_total_new_account += $total_deposit_of_new_account;
						$single_count_deposit_total_new_account += $count_deposit_of_new_accoun;
					}										
					
					$first_depos_total += $single_first_deposit_total;
									
					
					$total_deposit_total += $single_total_deposit_total_new_account;
					$total_deposit_count += $single_count_deposit_total_new_account;
					
					
					$total_deposit_sql = "SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM transactions WHERE transferdate = '$period_date' AND transactiontype = 'Deposit' AND status = 'Approve' UNION SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM  bank_transaction WHERE date = '$period_date' AND transaction_type IN ('TF Deposit', 'Transfer(+)', 'Other(+)')";				
					//echo $total_deposit_sql;							
					$total_deposit_query = mysqli_query($conn, $total_deposit_sql);
					$single_total_deposit = 0;
					$single_count_deposit = 0;
					while($total_deposit_row = mysqli_fetch_assoc($total_deposit_query)){
						$total_deposit_row_am = $total_deposit_row['total_amount'];
						$total_count_deposit_row_am = $total_deposit_row['total_count'];
						$single_count_deposit += $total_count_deposit_row_am;
						$single_total_deposit += $total_deposit_row_am;
					}
					
					$deposit_count_total += $single_count_deposit;
					$deposit_total += $single_total_deposit;
					
					
					$total_withdrawal_sql = "SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM transactions WHERE transferdate = '$period_date' AND transactiontype = 'Withdrawal' AND status = 'Approve' UNION SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM  bank_transaction WHERE date = '$period_date' AND transaction_type IN ('TF Withdrawal', 'Transfer(-)', 'Other(-)')";
					
					$total_withdrawal_query = mysqli_query($conn, $total_withdrawal_sql);
					
					$single_total_withdrawal = 0;
					$single_total_count_withdrawal = 0;
					while($total_withdrawal_row = mysqli_fetch_assoc($total_withdrawal_query)){
						$total_withdrawal_row = mysqli_fetch_assoc($total_withdrawal_query);
						$total_withdrawal_am = $total_withdrawal_row['total_amount'];
						$total_count_withdrawal = $total_withdrawal_row['total_count'];
						$single_total_withdrawal += $total_withdrawal_am;
						$single_total_count_withdrawal += $total_count_withdrawal;
					}
					
					$total_withdraw_count+=$single_total_count_withdrawal;
					$total_withdraw+=$single_total_withdrawal;

					
					$bonussql= "SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM transactions WHERE transferdate = '$period_date' AND transactiontype = 'Bonus' AND status = 'Approve'";
					
					//echo $bonussql;
					$bonusres= mysqli_query($conn, $bonussql);
					$bonusrows= mysqli_fetch_assoc($bonusres);
					
					$total_bonus_count+=$bonusrows['total_count'];
					$total_bonus+=$bonusrows['total_amount'];
					
					$winloss= $single_total_deposit-$single_total_withdrawal;
					$winrate= ($winloss/$single_total_deposit) * 100;
					
					$total_winloss+=$winloss;
					$total_winrate+=$winrate;

					if($performrows['new_member_count'] == 0 && $single_first_deposit_total == 0 && $single_total_deposit_total_new_account == 0 && $single_count_deposit_total_new_account == 0 && $single_count_deposit == 0 && $single_total_deposit == 0 && $single_total_count_withdrawal == 0 && $single_total_withdrawal == 0 && $bonusrows['total_count'] == 0 && $bonusrows['total_amount'] == 0){
						continue;
					}
				?>
            
            	<tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $period_date;?></td>
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void();" onclick="openwindow('customer.php?fromdate=<?php echo urlencode($period_date.' 00:00:00'); ?>&todate=<?php echo urlencode($period_date.' 23:59:59'); ?>');"><?php echo $performrows['new_member_count'];?></a></td>
                  <td><?php echo number_format($single_first_deposit_total, 2);?></td>                
                  <td><?php echo number_format($single_total_deposit_total_new_account, 2);?></td>
                  <td><?php echo $single_count_deposit_total_new_account;?></td>
                  <td><?php echo $single_count_deposit;?></td>
                  <td><?php echo number_format($single_total_deposit, 2);?></td>
                  <td><?php echo $single_total_count_withdrawal;?></td>                
                  <td><?php echo number_format($single_total_withdrawal, 2);?></td>
                  <td><?php echo $bonusrows['total_count'];?></td>
                  <td><?php echo number_format($bonusrows['total_amount'], 2);?></td>
                  <td><?php echo number_format($winloss, 2, '.', ',');?></td>
                  <td><?php echo number_format($winrate, 2);?>%</td>                
              	</tr>
                
                <?php 
					$count++;						
				}					
				?>              
                
            </tbody>
            <tfoot>
            	<tr>                                               
                    <td colspan="2">Total</td>
                    <td><?php echo $total_member;?></td>
                    <td><?php echo number_format($first_depos_total, 2, '.', ',');?></td>                
                    <td><?php echo number_format($total_deposit_total, 2, '.', ',');?></td>
                    <td><?php echo number_format($total_deposit_count, 2, '.', ',');?></td>
                    <td><?php echo $deposit_count_total;?></td>
                    <td><?php echo number_format($deposit_total, 2, '.', ',');?></td>
                    <td><?php echo $total_withdraw_count;?></td>                
                    <td><?php echo number_format($total_withdraw, 2, '.', ',');?></td>
                    <td><?php echo $total_bonus_count;?></td>
                    <td><?php echo number_format($total_bonus, 2, '.', ',');?></td>
                    <td><?php echo number_format($total_winloss, 2, '.', ',');?></td>
                    <td><?php echo number_format((($total_winloss/$deposit_total)*100), 2);?>%</td>  
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>
<script>
	$(".resulttable").show();
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
</script>