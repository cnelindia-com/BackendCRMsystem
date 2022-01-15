<?php
session_start();

$_SESSION['page']='report';
$_SESSION['pagereport']='uploadfinancereport';
include('header.php');


if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$user_id = $_SESSION['user'];
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
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('#finance_upline_report').DataTable({
		"bInfo": false,
		"bLengthChange": false,
		"bFilter": false
	});
});
</script>
<style>
table.dataTable tbody th, table.dataTable tbody td {
	padding: 10px 18px 6px 18px !important;
}
</style>
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
    <a href="Upline_Report_Finance.php" id="sc8_1" class="<?php if($_SESSION['pagereport']=='uploadfinancereport'){ echo 'actives';}?>">Upline Report (Finance)</a>
    <span>|</span>
    <a href="Upline_Report_Member.php" id="sc8_1">Upline Report (Member)</a>
    <span>|</span>
    <a href="Bonus.php" id="sc8_1">Bonus</a>
    <span>|</span>
    <a href="Performanace_Report.php" id="sc8_1">Performanace Report</a>
</div>
  <div class="container" >
  <div class="filternav">
	<h2>Upline Report (Finance)</h2>
		<form method="get">
        	<div class="form-group">
				<div class="col-md-2">
					<b>Status</b>
				</div>
				<div class="col-md-10">
					<select name="status">
						<option value="">All</option>
						<option value="active" <?php if(isset($_GET['status']) && $_GET['status'] == 'active'){ echo 'selected="selected"'; } ?>>Active</option>
						<option value="suspended" <?php if(isset($_GET['status']) && $_GET['status'] == 'suspended'){ echo 'selected="selected"'; } ?>>Suspended</option>
						<option value="blocked" <?php if(isset($_GET['status']) && $_GET['status'] == 'blocked'){ echo 'selected="selected"'; } ?>>Blocked</option>
					</select>
				</div>
			</div>
        
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					<input type="datetime" name="fromdate" id="fromdate" value="<?php if(isset($_GET['fromdate']) && !empty($_GET['fromdate'])){ echo $_GET['fromdate']; } ?>"/> ~
					<input type="datetime" name="todate" id="todate" value="<?php if(isset($_GET['todate']) && !empty($_GET['todate'])){ echo $_GET['todate']; } ?>"/>
                    
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
	
	<?php
	/*$finance_upline_report_sql = "SELECT * FROM transactions WHERE accountid IN(SELECT id FROM account WHERE adminuserid = '$user_id') AND status = 'Approve'";
	$finance_upline_report_query = mysqli_query($conn, $finance_upline_report_sql);
	while($finance_upline_report_row = mysqli_fetch_assoc($finance_upline_report_query)){
		print_r($finance_upline_report_row);
	}
	*/
	
	$user_info_sql = "SELECT * FROM user_info WHERE 1=1";
	if(isset($_GET['status']) && !empty($_GET['status'])){
		$status = $_GET['status'];
		$user_info_sql .= " AND status = '$status'";
	}

	$user_info_query = mysqli_query($conn, $user_info_sql);
	
	$resulttable = 'style="display:none;"';
	if(isset($_GET['submit'])){
		$resulttable = '';
	}
	?>
	
    <div class="resulttable" <?php echo $resulttable; ?>>
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="finance_upline_report">
            <thead style="background-color: #ff720b;">
                <tr>
                    <th>NO</th>
                    <th class="col-md-3 col-xs-3">Username</th>
                    <th class="col-md-3 col-xs-3">New Account Count</th>
                    <th class="col-md-3 col-xs-3">Deposit Count</th>
                    <th class="col-md-3 col-xs-3">Deposit Total</th>
                    <th class="col-md-3 col-xs-3">Withdraw Count</th>
                    <th class="col-md-3 col-xs-3">Withdraw Total</th>
                    <th class="col-md-3 col-xs-3">Bonus Count</th>
                    <th class="col-md-3 col-xs-3">Bonus Total</th>
                    <th class="col-md-3 col-xs-3">Win/Loss</th>              
              	</tr>
            </thead>
            <tbody>
				<?php
				$total_deposit_count = 0;
				$total_withdrawal_count = 0;
				$total_bonus_count = 0;
				$total_winloss_count = 0;
				$total_deposit_amount = 0;
				$total_withdrawal_amount = 0;
				$total_bonus_amount = 0;
				$total_winloss_amount = 0;
				$deposit_total=0;
				$withdrawal_total=0;
				$bonus_total=0;
				
				$rcount = 1;
				while($user_info_row = mysqli_fetch_assoc($user_info_query)){
					$username = $user_info_row['user_id'];
					
					$account_sql = "SELECT COUNT(*) as total FROM account WHERE adminuserid = '$username'";
					
					if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) && (isset($_GET['todate']) && !empty($_GET['todate']))){
						$fromdate = $_GET['fromdate'];
						$todate = $_GET['todate'];

						$account_sql.=" AND createdON BETWEEN '$fromdate' AND '$todate'";
					}
					
					$account_query = mysqli_query($conn, $account_sql);
					$account_row = mysqli_fetch_assoc($account_query);
					$new_account_count = $account_row['total'];
					
					
					
					$deposit_t_sql = "SELECT COUNT(*) as deposit_count, SUM(amount) AS deposit_total FROM transactions WHERE accountid IN(SELECT id FROM account WHERE adminuserid = '$username') AND status = 'Approve' AND transactiontype = 'Deposit'";
					
					if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) && (isset($_GET['todate']) && !empty($_GET['todate']))){
						$fromdate = $_GET['fromdate'];
						$todate = $_GET['todate'];

						$deposit_t_sql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '$fromdate' AND '$todate'";
					}

					$deposit_t_query = mysqli_query($conn, $deposit_t_sql);
					$deposit_t_row = mysqli_fetch_assoc($deposit_t_query);																		
					
					$deposit_count = $deposit_t_row['deposit_count'];
					$deposit_total = $deposit_t_row['deposit_total'];
					
					$withdrawal_t_sql = "SELECT COUNT(*) as withdrawal_count, SUM(amount) AS withdrawal_total FROM transactions WHERE accountid IN(SELECT id FROM account WHERE adminuserid = '$username') AND status = 'Approve' AND transactiontype = 'Withdrawal'";
					
					if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) && (isset($_GET['todate']) && !empty($_GET['todate']))){
						$fromdate = $_GET['fromdate'];
						$todate = $_GET['todate'];

						$withdrawal_t_sql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '$fromdate' AND '$todate'";
					}
					
					
					$withdrawal_t_query = mysqli_query($conn, $withdrawal_t_sql);
					$withdrawal_t_row = mysqli_fetch_assoc($withdrawal_t_query);
			
					$withdrawal_count = $withdrawal_t_row['withdrawal_count'];
					$withdrawal_total = $withdrawal_t_row['withdrawal_total'];
					
					$bonus_t_sql = "SELECT COUNT(*) as bonus_count, SUM(amount) AS bonus_total FROM transactions WHERE accountid IN(SELECT id FROM account WHERE adminuserid = '$username') AND status = 'Approve' AND transactiontype = 'Bonus'";
					
					if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) && (isset($_GET['todate']) && !empty($_GET['todate']))){
						$fromdate = $_GET['fromdate'];
						$todate = $_GET['todate'];

						$bonus_t_sql.=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '$fromdate' AND '$todate'";
					}
					
					
					$bonus_t_query = mysqli_query($conn, $bonus_t_sql);
					$bonus_t_row = mysqli_fetch_assoc($bonus_t_query);
			
					$bonus_count = $bonus_t_row['bonus_count'];
					$bonus_total = $bonus_t_row['bonus_total'];
					
					$total_new_account_count += $new_account_count;
					$total_deposit_count += $deposit_count;
					$total_withdrawal_count += $withdrawal_count;
					$total_bonus_count += $bonus_count;
					$total_deposit_amount += $deposit_total;;
					$total_withdrawal_amount += $withdrawal_total;
					$total_bonus_amount += $bonus_total;
					$total_winloss_amount += ($deposit_total-($withdrawal_total+$bonus_total));
					
				?>
            	<tr>
                  <td><?php echo $rcount; ?></td>
                  <td><?php echo strtoupper($username); ?></td>
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void()" onClick="openwindow('customer.php?adminuserid=<?php echo $username;?>&todate=<?php echo $todate;?>&fromdate=<?php echo $fromdate;?>&aflt=<?php echo ucfirst($_GET['status']);?>')"><?php echo $new_account_count; ?></a></td>
                  <td><?php echo $deposit_count; ?></td>
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void()" onClick="openwindow('transaction_history.php?todate=<?php echo $todate;?>&fromdate=<?php echo $fromdate;?>&transaction_type[]=<?php echo 'Deposit';?>')"><?php echo number_format($deposit_total, "2", ".", ","); ?></a></td>
                  <td><?php echo $withdrawal_count; ?></td>
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void()" onClick="openwindow('transaction_history.php?todate=<?php echo $todate;?>&fromdate=<?php echo $fromdate;?>&transaction_type[]=<?php echo 'Withdrawal';?>')"><?php echo number_format($withdrawal_total, "2", ".", ","); ?></a></td>
                  <td><?php echo $bonus_count; ?></td>
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void()" onClick="openwindow('transaction_history.php?todate=<?php echo $todate;?>&fromdate=<?php echo $fromdate;?>&transaction_type[]=<?php echo 'Bonus';?>')"><?php echo number_format($bonus_total, "2", ".", ","); ?></a></td>
                  <td><?php echo number_format($deposit_total-($withdrawal_total+$bonus_total), 2); ?></td>
              	</tr>
                <?php
					$rcount++;
				}
				?>
            </tbody>
            <tfoot>
            	<tr style="background: #fafafa;">
                	<th colspan="2">Total</th>
                    <th><?php echo $total_new_account_count; ?></th>
                    <th><?php echo $total_deposit_count; ?></th>
                    <th><?php echo number_format($total_deposit_amount, 2); ?></th>
                    <th><?php echo $total_withdrawal_count; ?></th>
                    <th><?php echo number_format($total_withdrawal_amount, 2); ?></th>
                    <th><?php echo $total_bonus_count; ?></th>
                    <th><?php echo number_format($total_bonus_amount, 2); ?></th>
                    <th><?php echo number_format($total_winloss_amount, 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>
<script>
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