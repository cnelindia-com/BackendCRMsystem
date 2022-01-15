<?php
session_start();

$_SESSION['page']='report';

$_SESSION['pagereport']='memberreport';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";
}

$limittop = '';
$limitleast = '';
if(isset($_POST['limitleast']))
{
	$limitleast=$_POST['limitleast'];
}

if(isset($_POST['limittop']))
{
	$limittop=$_POST['limittop'];
}
if(isset($_POST['MemberDepositTHEN'])){
	$MemberDepositTHEN=$_POST['MemberDepositTHEN']-1;	
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
.tableborder1 tr:nth-child(2n+1) {
	background-color: #fafafa;
}
td.memberacc_code, td.memberacc_specialid {
	width: 160px;
	text-transform: uppercase;
	text-align: left;
}
.memberReportTable td {
	background: #ffffff;
	padding-top: 5px;
	padding-bottom: 5px;
	text-align: right;
}
td.memberAmount, td.memberProfit {
	text-align: right;
	padding-right: 20px;
	width: 160px;
}
td.memberCount {
	text-align: center;
	width: 90px;
}
.tableborder1 {
	background-color: #fff;
	*border-collapse: collapse;
	border-spacing: 0;
	width: 50%;
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
.tableborder1 td:first-child, .tableborder1 th:first-child {
	border-left: none;
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
    <a href="Member_Report.php" id="sc8_1"  class="<?php if($_SESSION['pagereport']=='memberreport'){ echo 'actives';}?>">Member Report</a>
    <span>|</span>
    <a href="Bank_Report.php" id="sc8_1">Bank Report</a>
    <span>|</span>
    <a href="Upline_Report_Finance.php" id="sc8_1">Upline Report (Finance)</a>
    <span>|</span>
    <a href="Upline_Report_Member.php" id="sc8_1">Upline Report (Member)</a>
    <span>|</span>
    <a href="Bonus.php" id="sc8_1">Bonus</a>
    <span>|</span>
    <a href="Performanace_Report.php" id="sc8_1">Performanace Report</a>
</div>
  <div class="container" >
  <div class="filternav">
	<h2>Member Report</h2>
		<form method="post">
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
            <?php  
			$reportTop=array();
			if(isset($_POST['searchfilter']))
			{
				$reportTop=$_POST['reportTop'];
			}
			if(!isset($_POST['reportTop'])){
				$_POST['reportTop'][]='TopWinLoss';	
			}
			//print_r($_POST['reportTop']);
			?>         
			<div class="form-group">
				<div class="col-md-2">
					<b>Filter</b>
				</div>
				<div class="col-md-10">
					Top <input type="number" name="limittop" value="<?php if(isset($_POST['limittop'])){echo $limittop;} else { echo 5; }?>" defaultValue="5" />
					<input type="checkbox" name="reportTop[]" class="reporttopAll" value="All" <?php if(in_array('All',$_POST['reportTop'])){echo "checked='checked'";}?>/>All 
					<input type="checkbox" name="reportTop[]" class="reporttopAllfilter" <?php if(in_array('Deposit',$_POST['reportTop'])){echo "checked='checked'";}?> value="Deposit"/>Deposit
					<input type="checkbox" name="reportTop[]" class="reporttopAllfilter" <?php if(in_array('Withdraw',$_POST['reportTop'])){echo "checked='checked'";}?> value="Withdraw"/>Withdraw 
					<input type="checkbox" name="reportTop[]" class="reporttopAllfilter" <?php if(in_array('Bonus',$_POST['reportTop'])){echo "checked='checked'";}?> value="Bonus"/>Bonus			
					<input type="checkbox" name="reportTop[]" class="reporttopAllfilter" <?php if(in_array('TopWinLoss',$_POST['reportTop'])){echo "checked='checked'";}?> value="TopWinLoss"/>Win / Loss
					
				</div>
			</div>
			<?php 
			$reportleast=array();
			if(isset($_POST['searchfilter']))
			{
				$reportleast=$_POST['reportleast'];
			}
			if(!isset($_POST['reportleast'])){
				$_POST['reportleast'][]='LeastWinLoss';
			}
			//print_r($_POST['reportleast']);
			?>     
			<div class="form-group">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					
                Least <input type="number" name="limitleast" value="<?php if(isset($_POST['limitleast'])){echo $limitleast;} else { echo 5; }?>"/>
                <input type="checkbox" name="reportleast[]" class="reportleastAll" value="All" <?php if(in_array('All',$_POST['reportleast'])){echo "checked='checked'";}?>/>All 
                <input type="checkbox" name="reportleast[]" class="reportleastAllfilter" <?php if(in_array('Deposit',$_POST['reportleast'])){echo "checked='checked'";}?> value="Deposit"/>Deposit
                <input type="checkbox" name="reportleast[]" class="reportleastAllfilter" <?php if(in_array('Withdraw',$_POST['reportleast'])){echo "checked='checked'";}?> value="Withdraw"/>Withdraw 
                <input type="checkbox" name="reportleast[]" class="reportleastAllfilter" <?php if(in_array('Bonus',$_POST['reportleast'])){echo "checked='checked'";}?> value="Bonus"/>Bonus			
                <input type="checkbox" name="reportleast[]" class="reportleastAllfilter" <?php if(in_array('LeastWinLoss',$_POST['reportleast'])){echo "checked='checked'";}?> value="LeastWinLoss"/>Win / Loss
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					<input type="checkbox" name="depositviewtype" value="MemberDepositCountLess" <?php if(isset($_POST['depositviewtype'])){echo "checked='checked'";}?>/>MemberDepositCountLess 
					
					Than <input type="number" name="MemberDepositTHEN" value="<?php if(isset($_POST['MemberDepositTHEN'])){echo $_POST['MemberDepositTHEN'];}else {echo 5;} ?>"/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2"></div>
				<div class="col-md-10">
                	<?php
                    	if(!($_POST['viewtype'])){
							$_POST['viewtype'][]='With User Code';	
						}
					?>
					<input type="checkbox" name="viewtype[]" value="All" class="checkallabc" <?php if(in_array('All',$_POST['viewtype'])){echo 'checked';}?>/>All 
					<input type="checkbox" name="viewtype[]" value="Inactive Member" <?php if(in_array('Inactive Member',$_POST['viewtype'])){echo "checked='checked'";}?>/>Inactive Member
					<input type="checkbox" name="viewtype[]" value="With User Code" <?php if(in_array('With User Code',$_POST['viewtype'])){echo "checked='checked'";}?>/>With User Code
				</div>
			</div>
			
			<div>
				<input type="submit" class="btn btn-secondary" name="searchfilter" id="submit" value="Submit"/>
				<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
	</div>
<br/><br/>

	<div class="resulttable">
		<span class="counter pull-right"></span>
        <?php
		$translimitsql='';
		if(isset($_POST['searchfilter']))
		{
			
			if((isset($_POST['fromdate']) && !empty($_POST['fromdate'])) || (isset($_POST['todate']) && !empty($_POST['todate'])))
			{
				$translimitsql=" AND CONCAT(transferdate,' ',hours,':',minutes,':',seconds) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
			}
					
		?>
       	<?php		 
		if(in_array('Deposit',$reportTop))
		{	
		?>
		<div>
            <h2>Top Deposit</h2> 
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Amount</th>
                  <th class="col-md-3 col-xs-3">Count</th>
                  </tr>
              </thead>
            <tbody>
            <?php 
			//echo "SELECT SUM(amount) as depositamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Deposit'".$translimitsql."  AND status='Approve' GROUP BY accountid ORDER BY depositamt desc  LIMIT 0,$limittop";
			
			$getTopDepositTrans = mysqli_query($conn,"SELECT SUM(amount) as depositamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Deposit'".$translimitsql."  AND status='Approve' GROUP BY accountid ORDER BY depositamt desc  LIMIT 0,$limittop"); 
			if(mysqli_num_rows($getTopDepositTrans)>0)
			{
				while($getTopDepositTransrow = mysqli_fetch_assoc($getTopDepositTrans))
				{
					//$depositaccountid[]=$getTopDepositTransrow['accountid'];
					$getaccountuser = mysqli_query($conn,"SELECT username,usercode from account where id=".$getTopDepositTransrow['accountid']);
					$getaccountuserrows = mysqli_fetch_assoc($getaccountuser);
					?>
					<tr>
                        <td><?php echo strtoupper($getaccountuserrows['username']);?></td>
                        <td><?php echo strtoupper($getaccountuserrows['usercode']);?></td>
                        <td><?php echo $getTopDepositTransrow['depositamt'];?></td>
                        <td><?php echo $getTopDepositTransrow['depositcount'];?></td>
                    </tr>
					<?php
				}	
				//print_r($depositaccountid);			
			}			
			?>	
             </tbody>
            </table>
        </div>
        <?php }?>
        
        <?php 		
		if(in_array('Withdraw',$reportTop))
		{			
		?>
		<div>
            <h2>Top Withdraw</h2>
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Amount</th>
                  <th class="col-md-3 col-xs-3">Count</th>
                  </tr>
              </thead>
            <tbody>
            <?php 			
			//echo "SELECT SUM(amount) as Withdrawalamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt desc  LIMIT 0,$limittop";
			$getTopWithdrawalTrans = mysqli_query($conn,"SELECT SUM(amount) as Withdrawalamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt desc  LIMIT 0,$limittop"); 
			if(mysqli_num_rows($getTopWithdrawalTrans)>0)
			{
				while($getTopWithdrawalTransrow = mysqli_fetch_assoc($getTopWithdrawalTrans))
				{
					//$withdrawaccountid[]=$getTopWithdrawalTransrow['accountid'];
					$getaccountuser = mysqli_query($conn,"SELECT username,usercode from account where id=".$getTopWithdrawalTransrow['accountid']);
					$getaccountuserrows = mysqli_fetch_assoc($getaccountuser);
					?>
					<tr>
                        <td><? echo strtoupper($getaccountuserrows['username']);?></td>
                        <td><? echo strtoupper($getaccountuserrows['usercode']);?></td>
                        <td><? echo $getTopWithdrawalTransrow['Withdrawalamt'];?></td>
                        <td><? echo $getTopWithdrawalTransrow['depositcount'];?></td>
                    </tr>
					<?php
				}
				//print_r($withdrawaccountid);
			}
			?>	
             </tbody>
            </table>
        </div>
        <?php }?>
        
        <?php 
		if(in_array('Bonus',$reportTop))
		{	
		?>
		<div>
            <h2>Top Bonus</h2>
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Amount</th>
                  <th class="col-md-3 col-xs-3">Count</th>
                  </tr>
              </thead>
            <tbody>
            <?php 
			$getTopBonusTrans = mysqli_query($conn,"SELECT SUM(amount) as Withdrawalamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Bonus'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt desc  LIMIT 0,$limittop"); 
			if(mysqli_num_rows($getTopBonusTrans)>0)
			{
				while($getTopBonusTransrow = mysqli_fetch_assoc($getTopBonusTrans))
				{
					$getaccountuser = mysqli_query($conn,"SELECT username,usercode from account where id=".$getTopBonusTransrow['accountid']);
					$getaccountuserrows = mysqli_fetch_assoc($getaccountuser);
					?>
					<tr>
                        <td><?php echo strtoupper($getaccountuserrows['username']);?></td>
                        <td><?php echo strtoupper($getaccountuserrows['usercode']);?></td>
                        <td><?php echo $getTopBonusTransrow['Withdrawalamt'];?></td>
                        <td><?php echo $getTopBonusTransrow['depositcount'];?></td>
                    </tr>
					<?php
				}
			}
			?>	
             </tbody>
            </table>
        </div>
        <?php }?>
        
        
        <?php 
		if(in_array('TopWinLoss',$reportTop))
		{	
		?>
		<div>
            <h2>Top  Win / Loss</h2> 
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Win/Loss</th>                  
                  </tr>
              </thead>
            <tbody>
            <?php 
			$depositaccountid=array();
			$withdrawaccountid=array();
			
			$getTopDepstTrans = mysqli_query($conn,"SELECT SUM(amount) as depositamt ,accountid from transactions where transactiontype='Deposit'".$translimitsql."  AND status='Approve' GROUP BY accountid ORDER BY depositamt desc  LIMIT 0,$limittop");
			while($dpsrows=mysqli_fetch_assoc($getTopDepstTrans)){
				$depositaccountid[]=$dpsrows['accountid'];	
			}
			
			$getTopWithdratrans=mysqli_query($conn, "SELECT SUM(amount) as Withdrawalamt, accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt desc  LIMIT 0,$limittop");
			while($withdrawrows=mysqli_fetch_assoc($getTopWithdratrans)){
				$withdrawaccountid[]=$withdrawrows['accountid'];	
			}
						
			  $depositaccountids=implode(",", $depositaccountid);
			  $withdrawaccountids=implode(",", $withdrawaccountid);								 							
					
				$getTopDepositTrans = mysqli_query($conn,"SELECT SUM(amount) as depositamt ,accountid from transactions where transactiontype='Deposit'".$translimitsql."  AND status='Approve' AND accountid IN ($depositaccountids) GROUP BY accountid ORDER BY depositamt desc  LIMIT 0,$limittop");																				
				
				$getTopWithdrawalTrans = mysqli_query($conn,"SELECT SUM(amount) as Withdrawalamt, accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' AND accountid IN ($withdrawaccountids) GROUP BY accountid ORDER BY Withdrawalamt desc  LIMIT 0,$limittop");
				$allhwewithdrawl = array();
				while($getTopWithdrawalTransrow=mysqli_fetch_assoc($getTopWithdrawalTrans)){
					$withdrawid=$getTopWithdrawalTransrow['accountid'];
					$allhwewithdrawl[$withdrawid] = $getTopWithdrawalTransrow['Withdrawalamt'];							
				}
				$getTopWithdrawalTransrow=array();
				while($getTopDepositTransrow=mysqli_fetch_assoc($getTopDepositTrans)){
						$depositid=$getTopDepositTransrow['accountid'];
						$totaldepositamt=$getTopDepositTransrow['depositamt'];
						
						
						
						$usersres=mysqli_query($conn, "SELECT * FROM `account` WHERE status='Active' AND id= ".$getTopDepositTransrow['accountid']);
							$usersrows=mysqli_fetch_assoc($usersres);																						
							if(isset($allhwewithdrawl[$depositid])){
							$totalwinlossamt = $totaldepositamt - $allhwewithdrawl[$depositid];							
						?>
                        <tr>
                            <td><?php echo strtoupper($usersrows['username']);?></td>
                            <td><?php echo strtoupper($usersrows['usercode']);?></td>
                            <td><?php echo number_format($totalwinlossamt,"2", ".", ",");?></td>                        
                        </tr>
                    
                		<?php
							}
							else
							{
						?>
							<tr>
                            <td><?php echo strtoupper($usersrows['username']);?></td>
                            <td><?php echo strtoupper($usersrows['usercode']);?></td>
                            <td><?php echo number_format($totaldepositamt,"2", ".", ",");?></td>                        
                        	</tr>
                        <?php
							}
					}													
				?>	
             </tbody>
            </table>
        </div>
        <?php }?>
        
        
        <?php 
		if(in_array('Deposit',$reportleast))
		{	
		?>
		<div>
            <h2>Least Deposit</h2> 
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Amount</th>
                  <th class="col-md-3 col-xs-3">Count</th>
                  </tr>
              </thead>
            <tbody>
            <?php 			
			//echo "SELECT SUM(amount) as depositamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Deposit'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY depositamt asc  LIMIT 0,$limitleast";
			$getTopDepositTrans = mysqli_query($conn,"SELECT SUM(amount) as depositamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Deposit'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY depositamt asc  LIMIT 0,$limitleast"); 
			if(mysqli_num_rows($getTopDepositTrans)>0)
			{
				while($getTopDepositTransrow = mysqli_fetch_assoc($getTopDepositTrans))
				{
					$getaccountuser = mysqli_query($conn,"SELECT username,usercode from account where id=".$getTopDepositTransrow['accountid']);
					$getaccountuserrows = mysqli_fetch_assoc($getaccountuser);
					?>
					<tr>
                        <td><?php echo strtoupper($getaccountuserrows['username']);?></td>
                        <td><?php echo strtoupper($getaccountuserrows['usercode']);?></td>
                        <td><?php echo $getTopDepositTransrow['depositamt'];?></td>
                        <td><?php echo $getTopDepositTransrow['depositcount'];?></td>
                    </tr>
					<?php
				}
			}
			?>	
             </tbody>
            </table>
        </div>
        <?php }?>
        
        <?php 
		if(in_array('Withdraw',$reportleast))
		{	
		?>
		<div>
            <h2>Least Withdraw</h2> 
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Amount</th>
                  <th class="col-md-3 col-xs-3">Count</th>
                  </tr>
              </thead>
            <tbody>
            <?php
			$getTopDepositTrans = mysqli_query($conn,"SELECT SUM(amount) as Withdrawalamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt asc  LIMIT 0,$limitleast"); 
			if(mysqli_num_rows($getTopDepositTrans)>0)
			{
				while($getTopDepositTransrow = mysqli_fetch_assoc($getTopDepositTrans))
				{
					$getaccountuser = mysqli_query($conn,"SELECT username,usercode from account where id=".$getTopDepositTransrow['accountid']);
					$getaccountuserrows = mysqli_fetch_assoc($getaccountuser);
					?>
					<tr>
                        <td><?php echo strtoupper($getaccountuserrows['username']);?></td>
                        <td><?php echo strtoupper($getaccountuserrows['usercode']);?></td>
                        <td><?php echo $getTopDepositTransrow['Withdrawalamt'];?></td>
                        <td><?php echo $getTopDepositTransrow['depositcount'];?></td>
                    </tr>
					<?php
				}
			}
			?>	
             </tbody>
            </table>
        </div>
        <?php }?>
        
        <?php 
		if(in_array('Bonus',$reportleast))
		{	
		?>
		<div>
            <h2>Least Bonus</h2> 
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Amount</th>
                  <th class="col-md-3 col-xs-3">Count</th>
                  </tr>
              </thead>
            <tbody>
            <?php  
			$getTopDepositTrans = mysqli_query($conn,"SELECT SUM(amount) as Withdrawalamt, COUNT(*) as depositcount,accountid from transactions where transactiontype='Bonus'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt asc  LIMIT 0,$limitleast"); 
			if(mysqli_num_rows($getTopDepositTrans)>0)
			{
				while($getTopDepositTransrow = mysqli_fetch_assoc($getTopDepositTrans))
				{
					$getaccountuser = mysqli_query($conn,"SELECT username,usercode from account where id=".$getTopDepositTransrow['accountid']);
					$getaccountuserrows = mysqli_fetch_assoc($getaccountuser);
					?>
					<tr>
                        <td><?php  echo strtoupper($getaccountuserrows['username']);?></td>
                        <td><?php  echo strtoupper($getaccountuserrows['usercode']);?></td>
                        <td><?php  echo $getTopDepositTransrow['Withdrawalamt'];?></td>
                        <td><?php  echo $getTopDepositTransrow['depositcount'];?></td>
                    </tr>
					<?php 
				}
			}
			?>	
             </tbody>
            </table>
        </div>
        <?php  }?>
        
        
        <?php 
		if(in_array('LeastWinLoss',$reportleast))
		{	
		?>
		<div>
            <h2>Least  Win / Loss</h2> 
            <table class="table table-hover table-bordered results" id="table2excel" style="width: 50%;">
              <thead style="background-color: #ff720b;">
                <tr>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">User Code</th>
                  <th class="col-md-3 col-xs-3">Win/Loss</th>                  
                  </tr>
              </thead>
            <tbody>
            <?php 
			$depositaccountid=array();
			$withdrawaccountid=array();
			
			$getTopDepstTrans = mysqli_query($conn,"SELECT SUM(amount) as depositamt, accountid from transactions where transactiontype='Deposit'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY depositamt asc  LIMIT 0,$limitleast");
			while($dpsrows=mysqli_fetch_assoc($getTopDepstTrans)){
				$depositaccountid[]=$dpsrows['accountid'];	
			}
			
			$getTopWithdratrans=mysqli_query($conn, "SELECT SUM(amount) as Withdrawalamt, accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' GROUP BY accountid ORDER BY Withdrawalamt asc  LIMIT 0,$limitleast");
			while($withdrawrows=mysqli_fetch_assoc($getTopWithdratrans)){
				$withdrawaccountid[]=$withdrawrows['accountid'];	
			}
						
			  $depositaccountids=implode(",", $depositaccountid);
			  $withdrawaccountids=implode(",", $withdrawaccountid);								 										
				
				$getTopDepositTrans = mysqli_query($conn, "SELECT SUM(amount) as depositamt, accountid from transactions where transactiontype='Deposit'".$translimitsql." AND status='Approve' AND accountid IN ($depositaccountids) GROUP BY accountid ORDER BY depositamt asc  LIMIT 0,$limitleast");																				
				
				$getTopWithdrawalTrans = mysqli_query($conn,"SELECT SUM(amount) as Withdrawalamt, accountid from transactions where transactiontype='Withdrawal'".$translimitsql." AND status='Approve' AND accountid IN ($withdrawaccountids) GROUP BY accountid ORDER BY Withdrawalamt asc  LIMIT 0,$limitleast");
				$allhwewithdrawl = array();
				while($getTopWithdrawalTransrow=mysqli_fetch_assoc($getTopWithdrawalTrans)){
					$withdrawid=$getTopWithdrawalTransrow['accountid'];
					$allhwewithdrawl[$withdrawid] = $getTopWithdrawalTransrow['Withdrawalamt'];							
				}
				$getTopWithdrawalTransrow=array();
				while($getTopDepositTransrow=mysqli_fetch_assoc($getTopDepositTrans)){
						$depositid=$getTopDepositTransrow['accountid'];
						$totaldepositamt=$getTopDepositTransrow['depositamt'];
						
						
						
						$usersres=mysqli_query($conn, "SELECT * FROM `account` WHERE status='Active' AND id= ".$getTopDepositTransrow['accountid']);
							$usersrows=mysqli_fetch_assoc($usersres);																						
							if(isset($allhwewithdrawl[$depositid])){
							$totalwinlossamt = $totaldepositamt - $allhwewithdrawl[$depositid];							
						?>
                        <tr>
                            <td><?php echo strtoupper($usersrows['username']);?></td>
                            <td><?php echo strtoupper($usersrows['usercode']);?></td>
                            <td><?php echo number_format($totalwinlossamt,"2", ".", ",");?></td>                        
                        </tr>
                    
                		<?php
							}
							else
							{
						?>
							<tr>
                            <td><?php echo strtoupper($usersrows['username']);?></td>
                            <td><?php echo strtoupper($usersrows['usercode']);?></td>
                            <td><?php echo number_format($totaldepositamt,"2", ".", ",");?></td>                        
                        	</tr>
                        <?php
							}
					}													
				?>	
             </tbody>
            </table>
        </div>
        <?php }?>
                       
	</div>
    
    <?php
    
		if(isset($_POST['depositviewtype']))
		{			
	?>
	<div>
    	<h2>DepositCountLess Than < <?php echo $_POST['MemberDepositTHEN']; ?></h2>
    <table id="depositTable" class="tableborder1 memberReportTable">
    	<tbody>
                    
            <tr>
                <th>Username</th>
                <th>User Code</th>
                <th>Amount</th>
                <th>Count</th>
            </tr>
            <tr></tr>
            <?php			
            	
				$alluserres=mysqli_query($conn, "SELECT * FROM `account` WHERE status='Active'");
				while($alluserrows=mysqli_fetch_assoc($alluserres))
				{					
					$usersid=$alluserrows['id'];
					//echo "SELECT transactions.* FROM `transactions` WHERE status='Approve' AND accountid= $usersid AND transactiontype='Deposit' ".$translimitsql." LIMIT 0, $MemberDepositTHEN";
					$hwedepositres=mysqli_query($conn, "SELECT transactions.* FROM `transactions` WHERE status='Approve' AND accountid= $usersid AND transactiontype='Deposit' ".$translimitsql." LIMIT 0, $MemberDepositTHEN");																				
					
					while($hwedepositrows=mysqli_fetch_assoc($hwedepositres)){
						$totaldepositcount+=1;
						$totaldeposamt+=$hwedepositrows['amount'];
					}
					
					if(isset($totaldeposamt))
					{
			?>
            <tr class="dataField">
                <td class="memberacc_code"><?php echo $alluserrows['username'];?></td>
                <td class=""><?php echo $alluserrows['usercode'];?></td>
                <td class="memberAmount"><?php echo $totaldeposamt;?></td>
                <td class="memberCount"><?php echo $totaldepositcount; ?></td>
            </tr>          		
        
    		<?php
				$totaldepositcount=0;
				$totaldeposamt=0;
					}
				}
			?>
			</tbody>
    	</table>
		
		</div>
        <br/>
	<?php	
		}
    ?>
    
<?php
	
	if(isset($_POST['viewtype']) && in_array('Inactive Member', $_POST['viewtype']))
		{	
					
	?>		
    <div>
    	<h2>Inactive Member</h2>
		 <table id="depositTable" class="tableborder1 memberReportTable">
    	<tbody>
                    
            <tr>
                <th>Username</th>
                <th>User Code</th>
                <th>Last Active</th>                
            </tr>		
		<?php
					
			if(in_array('With User Code', $_POST['viewtype']))
			{
				$hweuserssql=mysqli_query($conn, "SELECT * FROM `account`");
				while($hweusersrows=mysqli_fetch_assoc($hweuserssql))					
				{					
					$accountid=$hweusersrows['id'];					
					$currdatetime=date("Y-m-d H:i:s", strtotime("today - 30 days"));										
																					
					$lasttransdate_sql=mysqli_query($conn, "SELECT id AS trans_id, transactions.* FROM `transactions` WHERE accountid=$accountid ORDER BY id DESC LIMIT 1");					
											
					$lasttransdaterow=mysqli_fetch_assoc($lasttransdate_sql);
						
					$lasttransdatetime=$lasttransdaterow['transferdate'].' '.sprintf('%02s', $lasttransdaterow['hours']).':'.sprintf('%02s', $lasttransdaterow['minutes']).':'.sprintf('%02s', $lasttransdaterow['seconds']);	
						//var_dump($lasttransdatetime);						
																	
					if($lasttransdatetime<=$currdatetime && $lasttransdaterow['amount'] != '')
					{					
		?>		
        
        		<tr>	
                  	<td class="memberacc_code"><?php echo $hweusersrows['username'];?></td>
                    <td class=""><?php echo strtoupper($hweusersrows['usercode']);?></td>                        
                    <td class="memberAmount"><?php echo $lasttransdatetime;?></td>	                    
            	</tr>
                
			<?php
					}
					else if(!isset($lasttransdaterow) && $hweusersrows['createdON']<=$currdatetime)
					{
			?>
            			<tr>	
                            <td class="memberacc_code"><?php echo $hweusersrows['username'];?></td>
	                        <td class=""><?php echo strtoupper($hweusersrows['usercode']);?></td>                            <td class="memberAmount"><?php echo $hweusersrows['createdON'];?></td>	                    
                        </tr>
            			
            <?php	
					}				
				}
				
			}			
              
       		?>
        
		</tbody>
        </table>
        </div>
        <br/>	
	<?php		
		}
	
	}
	?>
</div>
</body>
</html>
<script>
	$(document).ready(function(){
		$("#submit").click(function(){
			$(".resulttable").show();
		});
	});
	
	$('.reportleastAll').click(function() {
		if ($(this).is(':checked')) {
			$('.reportleastAllfilter').prop('checked', true);
		} else {
			$('.reportleastAllfilter').prop('checked', false);
		}
	});
	
	$('.reporttopAll').click(function() {
		if ($(this).is(':checked')) {
			$('.reporttopAllfilter').prop('checked', true);
		} else {
			$('.reporttopAllfilter').prop('checked', false);
		}
	});
	
	$(".checkallabc").click(function(){
		if($(this).is(':checked')){
			$("input[name='viewtype[]']").prop('checked', true);			
		}
		else{
			$("input[name='viewtype[]']").prop('checked', false);				
		}
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