<?php
session_start();

$_SESSION['page']='report';

$_SESSION['pagereport']='financereport';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

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
	<a href="Finanace_Report.php" id="sc8_1" class="<?php if($_SESSION['pagereport']=='financereport'){ echo 'actives';}?>">Finanace Report</a>
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
    <a href="Performanace_Report.php" id="sc8_1">Performanace Report</a>
</div>
  <div class="container">
	<div class="filternav">
		<h2>Finance Report</h2>
		<form method="get">
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					 <?php 
						$searched_fromdate= '';
						$searched_todate= '';
						if(isset($_GET['fromdate']) && isset($_GET['todate']))
						{
							$searched_fromdate= $_GET['fromdate'];
							$searched_todate= $_GET['todate'];
						}
						?>
                        
                            <input type="datetime" name="fromdate" id="fromdate" value="<?php echo $searched_fromdate;?>"/> ~
							<input type="datetime" name="todate" id="todate" value="<?php echo $searched_todate;?>"/>
                    
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
					<b>View</b>
				</div>
				<div class="col-md-10">
					<?php
					if(!isset($_GET['viewtype'])){
						$_GET['viewtype'][] = 'Monthly';
					}
					?>
					<input type="checkbox" name="viewtype" value="All" class="checkallseason" <?php if(in_array('All', $_GET['viewtype'])){ echo "checked='checked'";}?>/>All 
					<input type="checkbox" name="viewtype[]" value="Annually" <?php if(in_array('Annually', $_GET['viewtype'])){ echo "checked='checked'";}?>/>Annually
					<input type="checkbox" name="viewtype[]" value="Monthly" <?php if(in_array('Monthly', $_GET['viewtype'])){ echo 'checked="checked"';}?> />Monthly
					<input type="checkbox" name="viewtype[]" value="Weekly" <?php if(in_array('Weekly', $_GET['viewtype'])){ echo "checked='checked'";}?>/>Weekly			
					<input type="checkbox" name="viewtype[]" value="Daily" <?php if(in_array('Daily', $_GET['viewtype'])){ echo "checked='checked'";}?>/>Daily
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2">
					<b style="font-weight: bold;color: ;">Highlight <br/> <span style="background:#a0ff8b;color: #000;">highest</span>/<span style="background:#ff9d9d;color: #000;">lowest</span></b>
				</div>
				<div class="col-md-10">
					<?php 
					if(!isset($_GET['highlight'])){
						$_GET['highlight'] = 1;
					}
					?>
					<input type="checkbox" name="highlight" value="1" <?php if(isset($_GET['highlight']) && $_GET['highlight'] == 1){  echo 'checked="checked"'; } ?>/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2">
					<b>Year</b>
				</div>
				<div class="col-md-10">
                	<?php
					$years = range(2013, date('Y'));
					?>
					<select name="year">
                    	<?php
						foreach($years as $year){
							$selected_year = '';
							if(isset($_GET['year'])){
								if($_GET['year'] == $year){
									$selected_year = 'selected="selected"';
								}
							}
							else{
								if($year == date('Y')){
									$selected_year = 'selected="selected"';
								}
							}
						?>
						<option value="<?php echo $year; ?>" <?php echo $selected_year; ?>><?php echo $year; ?></option>
						<?php
						}
						?>
                    </select>
				</div>
			</div>
			<div>
				<input type="submit" class="btn btn-secondary" name="searchfilter" id="submit" value="Submit"/>
				<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
	</div>
	<?php 
	if(isset($_GET['searchfilter'])){
		$cyear = $_GET['year'];
		
		
	?>
	<br/><br/>
	<span class="counter pull-right"></span>
		<?php
		if(!empty($_GET['fromdate']) && !empty($_GET['todate'])){
			
			$start_month_date = $_GET['fromdate'];
			$end_month_date = $_GET['todate'];

			?>
			<div id="datefromtofilter_section">
				<h3 id="custom&quot;Title&quot;" style="display:inline-block; margin-right:10px;font-size: 14px;font-weight: 800;">Report <?php echo $start_month_date; ?> To <?php echo $end_month_date; ?></h3>
				<br/>
				<table class="table table-hover table-bordered results datefromtofilterdatatable" id="table2excel">
					<thead style="background-color: #ff720b;">
						<tr>
						  <th class="col-md-3 col-xs-3">Deposit</th>
						  <th class="col-md-3 col-xs-3">Bonus</th>
						  <th class="col-md-3 col-xs-3">Withdraw</th>
						  <th class="col-md-3 col-xs-3">Win/Loss</th> 
						</tr>
					</thead>
					<tbody>
						<?php
						$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND transferdate >= '$start_month_date' AND transferdate <= '$end_month_date'";
						$t1_query = mysqli_query($conn, $t1_sql);
						$t1_row = mysqli_fetch_assoc($t1_query);
						$deposit_amount = $t1_row['deposit'];
						
						$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND transferdate >= '$start_month_date' AND transferdate <= '$end_month_date'";
						$t2_query = mysqli_query($conn, $t2_sql);
						$t2_row = mysqli_fetch_assoc($t2_query);
						$bonus_amount = $t2_row['bonus'];
						
						$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND transferdate >= '$start_month_date' AND transferdate <= '$end_month_date'";
						$t3_query = mysqli_query($conn, $t3_sql);
						$t3_row = mysqli_fetch_assoc($t3_query);
						$withdrawal_amount = $t3_row['withdrawal'];
						
						$winloss = $deposit_amount - $withdrawal_amount;
						
						

						?>
						<tr>
						  <td><?php echo number_format($deposit_amount, 2);?></td>
						  <td><?php echo number_format($bonus_amount, 2);?></td>
						  <td><?php echo number_format($withdrawal_amount, 2);?></td>
						  <td><?php echo number_format($winloss, 2);?></td>
						</tr>
											
					 </tbody>
				</table>
			</div>
			<?php
		}
	
	
		if(in_array('Annually', $_GET['viewtype'])){
		?>
			<div id="annually_section">
				<div>
					
					<select name="annually">
						<option value="all">All</option>
						<?php
						$years = range(2021, date('Y'));
						
						
						foreach($years as $thisyear){
							$sly = '';
							if($thisyear == $cyear){
								$sly = 'selected="selected"';
							}								
						?>
						<option value="<?php echo $thisyear; ?>" <?php echo $sly; ?>><?php echo $thisyear; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<br/>
				<table class="table table-hover table-bordered results annuallydatatable" id="table2excel">
					<thead style="background-color: #ff720b;">
						<tr>
						  <th>Interval</th>
						  <th class="col-md-3 col-xs-3">Deposit</th>
						  <th class="col-md-3 col-xs-3">Bonus</th>
						  <th class="col-md-3 col-xs-3">Withdraw</th>
						  <th class="col-md-3 col-xs-3">Win/Loss</th> 
						</tr>
					</thead>
					<tbody>
						<?php
			
						$get_annually_sql = "SELECT EXTRACT(year from transferdate) as year FROM transactions GROUP BY year";
						$get_annually_query = mysqli_query($conn, $get_annually_sql);
						
						while($get_annually_row = mysqli_fetch_assoc($get_annually_query)){

							$this_year = $get_annually_row['year'];
							
							$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND YEAR(transferdate) = '$this_year'";
							$t1_query = mysqli_query($conn, $t1_sql);
							$t1_row = mysqli_fetch_assoc($t1_query);
							$deposit_amount = $t1_row['deposit'];
							
							$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND YEAR(transferdate) = '$this_year'";
							$t2_query = mysqli_query($conn, $t2_sql);
							$t2_row = mysqli_fetch_assoc($t2_query);
							$bonus_amount = $t2_row['bonus'];
							
							$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND YEAR(transferdate) = '$this_year'";
							$t3_query = mysqli_query($conn, $t3_sql);
							$t3_row = mysqli_fetch_assoc($t3_query);
							$withdrawal_amount = $t3_row['withdrawal'];
							
							$winloss = $deposit_amount - $withdrawal_amount;
							
							if($deposit_amount == 0 && $bonus_amount == 0 && $withdrawal_amount == 0){
								continue;
							}
							?>
							<tr class="<?php echo 'row_'.$this_year; ?> hweanualtrow">
							  <td>
							  <style>
							  <?php 
							  if($this_year == $cyear){
								echo '.row_'.$this_year.'{ display:inset;}';
							  }
							  else{
								  echo '.row_'.$this_year.'{ display:none;}';
							  }
							  ?>
							  </style>
							  
							  <?php echo $this_year; ?></td>
							  <td><?php echo number_format($deposit_amount, 2);?></td>
							  <td><?php echo number_format($bonus_amount, 2);?></td>
							  <td><?php echo number_format($withdrawal_amount, 2);?></td>
							  <td><?php echo number_format($winloss, 2);?></td>
							</tr>
							<?php
						}
						?>					
					 </tbody>
				</table>
			</div>
		<?php	
		}
		if(in_array('Monthly', $_GET['viewtype'])){	
		?>
		<div id="monthly_section">
			<div>
				<b>Monthly</b> 
				<select name="monthly">
					<option value="all">All</option>
					<?php
					if($cyear == date('Y')){
						$cmonth = date('m');
						
						for($m=1;$m<=$cmonth;$m++){
							$dateObj   = DateTime::createFromFormat('!m', $m);
							$monthName = $dateObj->format('M'); // Mar	
							
							$slm = '';
							if($cmonth == $m){
								$slm = 'selected="selected"';
							}							
							?>
							<option value="<?php echo $m; ?>" <?php echo $slm; ?>><?php echo $monthName; ?></option>
							
							<?php	
						}
					}
					else{
						$cmonth = date('m');
					?>
					<option value="1" <?php if($cmonth == 1){ echo 'selected="selected"'; }?>>Jan</option>
					<option value="2" <?php if($cmonth == 2){ echo 'selected="selected"'; }?>>Feb</option>
					<option value="3" <?php if($cmonth == 3){ echo 'selected="selected"'; }?>>Mar</option>
					<option value="4" <?php if($cmonth == 4){ echo 'selected="selected"'; }?>>Apr</option>
					<option value="5" <?php if($cmonth == 5){ echo 'selected="selected"'; }?>>May</option>
					<option value="6" <?php if($cmonth == 6){ echo 'selected="selected"'; }?>>June</option>
					<option value="7" <?php if($cmonth == 7){ echo 'selected="selected"'; }?>>July</option>
					<option value="8" <?php if($cmonth == 8){ echo 'selected="selected"'; }?>>Aug</option>
					<option value="9" <?php if($cmonth == 9){ echo 'selected="selected"'; }?>>Sept</option>
					<option value="10" <?php if($cmonth == 10){ echo 'selected="selected"'; }?>>Oct</option>
					<option value="11" <?php if($cmonth == 11){ echo 'selected="selected"'; }?>>Nov</option>
					<option value="12" <?php if($cmonth == 12){ echo 'selected="selected"'; }?>>Dec</option>
					<?php		
					}
					?>
					
					
				</select>
			</div>
			<br/>
			<table class="table table-hover table-bordered results monthlydatatable" id="table2excel">
				<thead style="background-color: #ff720b;">
					<tr>
					  <th>Interval</th>
					  <th class="col-md-3 col-xs-3">Deposit</th>
					  <th class="col-md-3 col-xs-3">Bonus</th>
					  <th class="col-md-3 col-xs-3">Withdraw</th>
					  <th class="col-md-3 col-xs-3">Win/Loss</th> 
					</tr>
				</thead>
				<tbody>
					<?php
					if($cyear == date('Y')){
						$cmonth = date('m');
					}
					else{
						$cmonth = 12;
					}
					
					for($m1=1;$m1<=$cmonth;$m1++){
						
						$start_month_date = $cyear.'-'.$m1.'-01';
						$end_month_date = $cyear.'-'.$m1.'-31';
						
						$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND transferdate >= '$start_month_date' AND transferdate <= '$end_month_date'";
						$t1_query = mysqli_query($conn, $t1_sql);
						$t1_row = mysqli_fetch_assoc($t1_query);
						$deposit_amount = $t1_row['deposit'];
						
						$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND transferdate >= '$start_month_date' AND transferdate <= '$end_month_date'";
						$t2_query = mysqli_query($conn, $t2_sql);
						$t2_row = mysqli_fetch_assoc($t2_query);
						$bonus_amount = $t2_row['bonus'];
						
						$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND transferdate >= '$start_month_date' AND transferdate <= '$end_month_date'";
						$t3_query = mysqli_query($conn, $t3_sql);
						$t3_row = mysqli_fetch_assoc($t3_query);
						$withdrawal_amount = $t3_row['withdrawal'];
						
						$winloss = $deposit_amount - $withdrawal_amount;
						
						if($deposit_amount == 0 && $bonus_amount == 0 && $withdrawal_amount == 0){
							continue;
						}
						?>
						<tr class="<?php echo 'row_'.$m1; ?> hwemntrow">
						  <td>
						  <style>
						  <?php 
						  if($m1 == $cmonth){
							echo '.row_'.$m1.'{ display:inset;}';
						  }
						  else{
							  echo '.row_'.$m1.'{ display:none;}';
						  }
						  ?>
						  </style>
						  
						  <?php echo date('Y/m', strtotime($start_month_date)); ?></td>
						  <td><?php echo number_format($deposit_amount, 2);?></td>
						  <td><?php echo number_format($bonus_amount, 2);?></td>
						  <td><?php echo number_format($withdrawal_amount, 2);?></td>
						  <td><?php echo number_format($winloss, 2);?></td>
						</tr>
						<?php
					}
					?>					
				 </tbody>
			</table>
		</div>	
		<?php
		}
		
		if(in_array('Weekly', $_GET['viewtype'])){	
			
			
		?>
		<div id="weekly_section">
			<div>
				<b>Weekly</b> 
				<select name="weekly">
					<option value="all">All</option>
					<?php
					if($cyear == date('Y')){
						$c_week_number = date('W',strtotime("-1 week +1 day"));
					}
					else{
						$c_week_number = 'all';
					}
				
					$sql_get_week_start_date = "SELECT transferdate FROM transactions WHERE YEAR(transferdate) = '$cyear' ORDER BY transferdate ASC limit 0,1";
					$query_get_week_start_date = mysqli_query($conn, $sql_get_week_start_date);
					$row_get_week_start_date = mysqli_fetch_assoc($query_get_week_start_date);
					$transferdate_week_start_date = $row_get_week_start_date['transferdate'];
					
					if($cyear == date('Y')){
						$transferdate_week_end_date = date('Y-m-d');
					}
					else{
						$transferdate_week_end_date = '2021-12-31';
					}
					
					$date1 = new DateTime($transferdate_week_start_date);
					$date2 = new DateTime($transferdate_week_end_date);
					$interval = $date1->diff($date2);

					$weeks = floor(($interval->days) / 7);
					$start_date = $transferdate_week_start_date;
					for($i = 1; $i <= $weeks; $i++){    
						
						$week = $date1->format("W");
						$date1->add(new DateInterval('P6D'));
						$this_week_end_date = $date1->format('Y-m-d');
						
						$slw = '';
						
						
						if($week == $c_week_number){
							$slw = 'selected="selected"';
						}
						?>
						<option value="<?php echo $week; ?>" <?php echo $slw; ?>><?php echo date('d/m/Y', strtotime($start_date)).' - '.date('d/m/Y', strtotime($this_week_end_date)); ?></option>
						<?php
						$date1->add(new DateInterval('P1D'));
						$start_date = $date1->format('Y-m-d');
						
						
							
					}
					?>
				</select>
			</div>
			<br/>
			<table class="table table-hover table-bordered results monthlydatatable" id="table2excel">
				<thead style="background-color: #ff720b;">
					<tr>
					  <th>Interval</th>
					  <th class="col-md-3 col-xs-3">Deposit</th>
					  <th class="col-md-3 col-xs-3">Bonus</th>
					  <th class="col-md-3 col-xs-3">Withdraw</th>
					  <th class="col-md-3 col-xs-3">Win/Loss</th> 
					</tr>
				</thead>
				<tbody>
					<?php
					$start_date = $transferdate_week_start_date;
					$date1 = new DateTime($start_date);
					$date2 = new DateTime($transferdate_week_end_date);
					$interval = $date1->diff($date2);

					$weeks = floor(($interval->days) / 7);
					
					for($i = 1; $i <= $weeks; $i++){ 
						
						$week = $date1->format("W");
						$date1->add(new DateInterval('P6D'));
						
						$row_end_date = $date1->format('Y-m-d');
						
				
						$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND transferdate >= '$start_date' AND transferdate <= '$row_end_date'";
						
						$t1_query = mysqli_query($conn, $t1_sql);
						$t1_row = mysqli_fetch_assoc($t1_query);
						$deposit_amount = $t1_row['deposit'];
						
						$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND transferdate >= '$start_date' AND transferdate <= '$row_end_date'";
						$t2_query = mysqli_query($conn, $t2_sql);
						$t2_row = mysqli_fetch_assoc($t2_query);
						$bonus_amount = $t2_row['bonus'];
						
						$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND transferdate >= '$start_date' AND transferdate <= '$row_end_date'";
						$t3_query = mysqli_query($conn, $t3_sql);
						$t3_row = mysqli_fetch_assoc($t3_query);
						$withdrawal_amount = $t3_row['withdrawal'];
						
						$winloss = $deposit_amount - $withdrawal_amount;
						
						if($deposit_amount == 0 && $bonus_amount == 0 && $withdrawal_amount == 0){
							//continue;
						}
						?>
						<tr class="<?php echo 'row_week'.$week; ?> hwewkrow">
						  <td>
						 
						  <style>
						  <?php 
						  
						  if($week == $c_week_number){
							echo '.row_week'.$week.'{ display:inset;}';
						  }
						  else{
							  echo '.row_week'.$week.'{ display:none;}';
						  }
						  ?>
						  </style>
						  
						  <?php echo date('d/m/Y', strtotime($start_date)).' - '.date('d/m/Y', strtotime($row_end_date)); ?></td>
						  <td><?php echo number_format($deposit_amount, 2);?></td>
						  <td><?php echo number_format($bonus_amount, 2);?></td>
						  <td><?php echo number_format($withdrawal_amount, 2);?></td>
						  <td><?php echo number_format($winloss, 2);?></td>
						</tr>
						<?php
						$date1->add(new DateInterval('P1D'));
						$start_date = $date1->format('Y-m-d');
					}
					?>					
				 </tbody>
			</table>
		</div>	
		<?php
		}
		
		if(in_array('Daily', $_GET['viewtype'])){	
			
			
		?>
		<div id="daily_section">
			<div>
				<table>
					<tr>
						<td style="background: transparent;">
							<b>Daily</b> 
							<input type="date" id="daily_date" value="<?php echo date('Y-m-d'); ?>" />
							<select id="daily_monthly" style="display:none;">
								<option value="">Please select</option>
								<?php
								if($cyear == date('Y')){
									$cmonth = date('m');
									
									for($m=1;$m<=$cmonth;$m++){
										$dateObj   = DateTime::createFromFormat('!m', $m);
										$monthName = $dateObj->format('M'); // Mar	

																
										?>
										<option value="<?php echo $m; ?>"><?php echo $monthName; ?></option>
										
										<?php	
									}
								}
								else{
									$cmonth = date('m');
									?>
									<option value="1" <?php if($cmonth == 1){ echo 'selected="selected"'; }?>>Jan</option>
									<option value="2" <?php if($cmonth == 2){ echo 'selected="selected"'; }?>>Feb</option>
									<option value="3" <?php if($cmonth == 3){ echo 'selected="selected"'; }?>>Mar</option>
									<option value="4" <?php if($cmonth == 4){ echo 'selected="selected"'; }?>>Apr</option>
									<option value="5" <?php if($cmonth == 5){ echo 'selected="selected"'; }?>>May</option>
									<option value="6" <?php if($cmonth == 6){ echo 'selected="selected"'; }?>>June</option>
									<option value="7" <?php if($cmonth == 7){ echo 'selected="selected"'; }?>>July</option>
									<option value="8" <?php if($cmonth == 8){ echo 'selected="selected"'; }?>>Aug</option>
									<option value="9" <?php if($cmonth == 9){ echo 'selected="selected"'; }?>>Sept</option>
									<option value="10" <?php if($cmonth == 10){ echo 'selected="selected"'; }?>>Oct</option>
									<option value="11" <?php if($cmonth == 11){ echo 'selected="selected"'; }?>>Nov</option>
									<option value="12" <?php if($cmonth == 12){ echo 'selected="selected"'; }?>>Dec</option>
									<?php		
									}
									?>
							</select>
						</td>
						<td style="background: transparent;">
							<fieldset >
								<legend style="font-size: 12px;margin-bottom: 0;">Select</legend>
								Daily <input type="radio" name="daily_select" value="daily" checked="checked"/>
								Monthly <input type="radio" name="daily_select" value="monthly" />
							</fieldset>
						</td>
					</tr>
				</table>
				
			</div>
			<br/>
			<table class="table table-hover table-bordered results dailymonthlydatatable" id="table2excel">
				<thead style="background-color: #ff720b;">
					<tr>
					  <th>Interval</th>
					  <th class="col-md-3 col-xs-3">Deposit</th>
					  <th class="col-md-3 col-xs-3">Bonus</th>
					  <th class="col-md-3 col-xs-3">Withdraw</th>
					  <th class="col-md-3 col-xs-3">Win/Loss</th> 
					</tr>
				</thead>
				<tbody>
					<?php
					$current_date = date('Y-m-d');
					$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND transferdate = '$current_date'";
					
					$t1_query = mysqli_query($conn, $t1_sql);
					$t1_row = mysqli_fetch_assoc($t1_query);
					$deposit_amount = $t1_row['deposit'];
					
					$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND transferdate = '$current_date'";
					$t2_query = mysqli_query($conn, $t2_sql);
					$t2_row = mysqli_fetch_assoc($t2_query);
					$bonus_amount = $t2_row['bonus'];
					
					$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND transferdate = '$current_date'";
					$t3_query = mysqli_query($conn, $t3_sql);
					$t3_row = mysqli_fetch_assoc($t3_query);
					$withdrawal_amount = $t3_row['withdrawal'];
					
					$winloss = $deposit_amount - $withdrawal_amount;
					
					if($deposit_amount != 0 && $bonus_amount != 0 && $withdrawal_amount != 0){
						
					
					?>
					<tr>
					  <td>
					  <?php echo date('d/m/Y', strtotime($current_date)); ?></td>
					  <td><?php echo number_format($deposit_amount, 2);?></td>
					  <td><?php echo number_format($bonus_amount, 2);?></td>
					  <td><?php echo number_format($withdrawal_amount, 2);?></td>
					  <td><?php echo number_format($winloss, 2);?></td>
					</tr>
					<?php
					}
					?>					
				 </tbody>
			</table>
		</div>	
		<?php
		}
	}
	?>
</div>

<script>
	var clicked = false;
	$('.checkallseason').click(function(){	
		
		if(!clicked){	
			$('input[name="viewtype[]"]').prop('checked', true);
			clicked = true;
		}
		else{
			$('input[name="viewtype[]"]').prop('checked', false);
			clicked = false;
		}
	});
	
	$('#daily_date').change(function(){
		var this_daily_date = $(this).val();
		$.ajax({ url: 'ajax.php',
				 data: {daily_date: this_daily_date},
				 type: 'post',
				 dataType:'json',
				 success: function(ajaxoutput) {
					if(ajaxoutput.result == 'success'){
						$('.dailymonthlydatatable tbody').html(ajaxoutput.data.content);
					}
				 }
		});
	});
	$('#daily_monthly').change(function(){
		var this_daily_monthly = $(this).val();
		$.ajax({ url: 'ajax.php',
				 data: {daily_monthly: this_daily_monthly, year: $('select[name="year"]').val()},
				 type: 'post',
				 dataType:'json',
				 success: function(ajaxoutput) {
					if(ajaxoutput.result == 'success'){
						$('.dailymonthlydatatable tbody').html(ajaxoutput.data.content);
					}
				 }
		});
	});
	
	

	$('input[name=daily_select]').change(function(){
		var $this_daily_select_value = $(this).val();
		if($this_daily_select_value == 'daily'){
			$('#daily_date').show();
			$('#daily_monthly').hide();
		}
		else if($this_daily_select_value == 'monthly'){
			$('#daily_date').hide();
			$('#daily_monthly').show();
		}
	});
	
	$('select[name="annually"]').change(function(){
		var thisannualval = $(this).val();
		if(thisannualval != 'all'){
			$('.hweanualtrow').hide();	
			$('.row_'+thisannualval).show();
		}
		else{
			$('.hweanualtrow').show();	
		}
	});
	
	$('select[name="weekly"]').change(function(){
		var thisweeklyval = $(this).val();
		if(thisweeklyval != 'all'){
			$('.hwewkrow').hide();	
			$('.row_week'+thisweeklyval).show();
		}
		else{
			$('.hwewkrow').show();	
		}
	});
	
	$('select[name="monthly"]').change(function(){
		var thismonthval = $(this).val();
		if(thismonthval != 'all'){
			$('.max').css('background', '#fff');	
			$('.min').css('background', '#fff');	
			
			$('.hwemntrow').hide();
			$('.row_'+thismonthval).show();
		}
		else{
			$('.hwemntrow').show();	
			$('.max').css('background', '#a0ff8b');	
			
			$('.min').css('background', '#ff9d9d');		
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
	
	
	
	var offset = 1;

	var values1 = [];
	var values2 = [];
	var values3 = [];
	var values4 = [];
	$('.monthlydatatable tbody tr').each(function () {
		
		
		$(this).children('td').each(function (i,v) {
			if (i < offset) return;
			
			var $thistext = $(this).text();
			var $thistext = $thistext.replace(',','');
			var value = parseFloat($thistext);

			if(!isNaN(value)){
				if(i == 1){
					values1.push(value);
				}
				else if(i == 2){
					values2.push(value);
				}
				else if(i == 3){
					values3.push(value);
				}
				else if(i == 4){
					values4.push(value);
				}
				
			}
		});
	});
	
	
	var maxValue1 = Math.max.apply(null, values1);
	var minValue1 = Math.min.apply(null, values1);
	
	
	
	var maxValue2 = Math.max.apply(null, values2);
	var minValue2 = Math.min.apply(null, values2);
	
	var maxValue3 = Math.max.apply(null, values3);
	var minValue3 = Math.min.apply(null, values3);
	
	var maxValue4 = Math.max.apply(null, values4);
	var minValue4 = Math.min.apply(null, values4);

	$('.monthlydatatable tbody tr').each(function () {

		$(this).children('td').each(function (trtdi, trtdv) {
			
			if (trtdi < offset) return;
			
			var $thistext = $(this).text();
			var $thistext = $thistext.replace(',','');
			var $thistext = parseFloat($thistext);
			
			if(trtdi == 1){
				
				if ($thistext == maxValue1.toFixed(2)) {
					if(!checkclassalreadytrtd(trtdi, 'max')){
						$(this).addClass('max');
					}
				}

				if ($thistext == minValue1.toFixed(2)) {
					if(!checkclassalreadytrtd(trtdi, 'min')){
						$(this).addClass('min');
					}
				}
			}
		
		
			if(trtdi == 2){
				if ($thistext == maxValue2) {
					if(!checkclassalreadytrtd(trtdi, 'max')){
						$(this).addClass('max');
					}
				}

				if ($thistext == minValue2) {
					if(!checkclassalreadytrtd(trtdi, 'min')){
						$(this).addClass('min');
					}
				}
			}
			
			if(trtdi == 3){
				if ($thistext == maxValue3) {
					if(!checkclassalreadytrtd(trtdi, 'max')){
						$(this).addClass('max');
					}
				}

				if ($thistext == minValue3) {
					if(!checkclassalreadytrtd(trtdi, 'min')){
						$(this).addClass('min');
					}
				}
			}
			
			if(trtdi == 4){
				if ($thistext == maxValue4) {
					if(!checkclassalreadytrtd(trtdi, 'max')){
						$(this).addClass('max');
					}
				}

				if ($thistext == minValue4) {
					if(!checkclassalreadytrtd(trtdi, 'min')){
						$(this).addClass('min');
					}
				}
			}
		});		
	});
	
	function checkclassalreadytrtd(index, classn){
		var returnout = false;
		$('.monthlydatatable tbody tr').each(function () {
			$(this).children('td').each(function (thisindex, thisval) {
				if(thisindex == index){
					if($(this).hasClass(classn)){
						returnout = true;
					}
				}
			});
		});
		
		return returnout;
	}
</script>
</body>
</html>
