<?php
session_start();

$_SESSION['page']='report';


$_SESSION['pagereport']='bonusreport';

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
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
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
    <a href="Bonus.php" id="sc8_1" class="<?php if($_SESSION['pagereport']=='bonusreport'){ echo  "actives";}?>">Bonus</a>
    <span>|</span>
    <a href="Performanace_Report.php" id="sc8_1">Performanace Report</a>
</div>
  <div class="container" >
  <div class="filternav">
	<h2>Bonus</h2>
		<form method="get">
        	            
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					<?php 
					$fromdatesearch = '';
					$todatesearch = '';
					if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) || (isset($_GET['todate']) && !empty($_GET['todate'])))
					{
						$fromdatesearch = $_GET['fromdate'];
						$todatesearch = $_GET['todate'];
					}
					?>
					<div class="col-md-6">
								<div class="input-group date form_datetime from_datetime" data-date="<?php  echo date("Y-m-d H:i:s"); ?>" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="fromdate" style="width: 170px;float: left;">
									<input size="16" type="text" value="<?php echo $fromdatesearch;?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar" style="color: #000;"></span></span>
								</div>
								<input type="hidden" id="fromdate" name="fromdate" value="<?php echo $fromdatesearch;?>" />
								
								<div style="float:left;margin-right: 11px;">~</div>
								<div class="input-group date form_datetime to_datetime" data-date="<?php  echo date("Y-m-d H:i:s"); ?>" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="todate" style="width: 170px;float: left;">
									<input size="16" type="text" value="<?php echo $todatesearch;?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar" style="color: #000;"></span></span>
								</div>
								<input type="hidden" id="todate" name="todate" value="<?php echo $todatesearch;?>" />
							</div>
                    
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
	$promotion_sql = "SELECT * FROM promotion WHERE 1=1";
	if(isset($_GET['status']) && !empty($_GET['status'])){
		$status = $_GET['status'];
		$user_info_sql .= " AND status = '$status'";
	}
	
	
	$fromdate='';
	$todate='';
	
	if((isset($_GET['fromdate']) && !empty($_GET['fromdate'])) && (isset($_GET['todate']) && !empty($_GET['todate']))){
		$fromdate = date('Y-m-d', strtotime($_GET['fromdate']));
		$todate = date('Y-m-d', strtotime($_GET['todate']));
	} 
						
	$promotion_query = mysqli_query($conn, $promotion_sql);
	
	$resulttable = 'style="display:none;"';
	if(isset($_GET['submit'])){
		$resulttable = '';
	}
	?>
    <div class="resulttable" <?php echo $resulttable; ?>>
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                    <th>NO</th>
                    <th class="col-md-3 col-xs-3">Bonus Name</th>
                    <th class="col-md-3 col-xs-3">Bonus Code</th>
                    <th class="col-md-3 col-xs-3">Players</th>
                    <th class="col-md-3 col-xs-3">Count</th>
                    <th class="col-md-3 col-xs-3">Amount</th>    
              	</tr>
            </thead>
            <tbody>
				<?php
				$rcount = 1;
				$total_player_count_sum = 0;
				$total_bonus_used_count_sum = 0;
				$total_bonus_used_sum = 0;
				while($promotion_row = mysqli_fetch_assoc($promotion_query)){
					$promotion_id = $promotion_row['id'];
					$name = $promotion_row['name'];
					$promotion_code = $promotion_row['promotion_code'];	
					
					$total_player_sql = "SELECT COUNT(DISTINCT accountid) as total_players FROM transactions WHERE bonus_promotion_id = '$promotion_id' AND transactiontype = 'Bonus' AND status = 'Approve'";
					
					$total_count_sql = "SELECT COUNT(accountid) as total_count, SUM(amount) AS total_amount FROM transactions WHERE bonus_promotion_id = '$promotion_id' AND transactiontype = 'Bonus' AND status = 'Approve'";
					
					if(isset($_GET['fromdate']) && !empty($_GET['fromdate'])){
						$fromdate = $_GET['fromdate'];
						$total_player_sql .= " AND transferdate >= '$fromdate'";
						$total_count_sql .= " AND transferdate >= '$fromdate'";
					}
					
					if(isset($_GET['todate']) && !empty($_GET['todate'])){
						$todate = $_GET['todate'];
						$total_player_sql .= " AND transferdate <= '$todate'";
						$total_count_sql .= " AND transferdate <= '$todate'";						
					}
							 
					$total_player_query = mysqli_query($conn, $total_player_sql);
					$total_player_row = mysqli_fetch_assoc($total_player_query);
					$total_players = $total_player_row['total_players'];
							
			
							
					$total_count_query = mysqli_query($conn, $total_count_sql);
					$total_count_row = mysqli_fetch_assoc($total_count_query);
				
					
					$total_counts = $total_count_row['total_count'];
					$total_amount = $total_count_row['total_amount'];
					
					$total_player_count_sum += $total_players;
					$total_bonus_used_count_sum += $total_counts;
					$total_bonus_used_sum += $total_amount;

					
					
				?>
            	<tr>
                  <td><?php echo $rcount; ?></td>
                  <td><?php echo $name; ?></td>
                  <td style="color:green;"><?php echo $promotion_code; ?></td>
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void();" onclick="openwindow('bonus-rebate.php?rebate_type=players&bonus_id=<?php echo $promotion_id; ?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>');"><?php echo $total_players; ?> </a></td>                
                  <td><a style="text-decoration: underline;color:#0055ff;" href="javascript:void();" onclick="openwindow('bonus-rebate.php?rebate_type=counts&bonus_id=<?php echo $promotion_id; ?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>');"><?php echo $total_counts; ?></a></td>                
                  <td><?php echo number_format($total_amount,2); ?></td>                
              	</tr>
				<?php
					$rcount++;
				}
				?>
            </tbody>

            <tfoot>
            	<tr>
                  <td colspan="3">Total</td>
                  <td><?php echo $total_player_count_sum; ?></td>                
                  <td><?php echo $total_bonus_used_count_sum; ?></td>
                   <td><?php echo number_format($total_bonus_used_sum,2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script>
	$(document).ready(function(){
		$("#submit").click(function(){
			//$(".resulttable").show();
		});
		
		$('.form_datetime').datetimepicker({
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
			showMeridian: 1
		});
		
	});
	
	
	function populateDate(fromdate,todate)
	{
		$("#fromdate").val(fromdate+' 00:00:00');
		$(".from_datetime").find('input').val(fromdate+' 00:00:00');	
		$("#todate").val(todate+' 23:59:59');		
		$(".to_datetime").find('input').val(todate+' 23:59:59');	
	}
	
	function cleardate()
	{
		$("#fromdate").val('');	
		$("#todate").val('');
		$(".from_datetime").find('input').val('');		
		$(".to_datetime").find('input').val('');
	}
</script>
</body>
</html>
