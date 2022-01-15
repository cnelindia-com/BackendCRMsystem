<?php 
    include('config.php');

    date_default_timezone_set("Asia/Kuala_Lumpur");
    //echo date('d-m-Y H:i:s'); //Returns IST

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
  <link rel="icon" href="images/logo.png" type="image/ico" />

	  	<link href="style.css" rel="stylesheet">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	    
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>

		function ConfirmLogOut() {  
		return confirm("Are you sure you want to LOG OUT now ?");
		}
		
		function openwindow(url){
			//window.open(url, target, "width=700,height=500");
			 var myWindow = window.open(url, "", "width=800,height=500");
		}
		</script>

</head>
<style>
.fixed-top 
{
	position:absolute;
}
.header02menu {
    padding: unset;
}

.row {
	margin-right: 0px;
	margin-left: 0px;
	padding-left: 5px;
	padding-right: 5px;
}

.row.header02 .col-2 {
	-ms-flex: unset !important;
	flex: unset !important;
	max-width: unset !important;
	padding: 5px 10px 0px 14px;
	font-weight: 500;
	width: auto;
	display: inline-block;
	white-space: normal;
	margin: 0 5px 0 0;
	height: 40px;
}

#sc8 {
	padding: 0 8px;
	margin-left: 0;
}

#sc8 a {
	font-size: 15px;
	padding: 0 6px;
	margin: 0;
}
.row.header02 .col-2 .fa::before {
	font-size: 20px;
}

#table2excel th, #table2excel td {
	white-space: nowrap;
}

#finance_upline_report th, #finance_upline_report td {
	white-space: nowrap;
}

#table2excel thead th, #finance_upline_report thead th{
	color:#fff;
	font-weight: normal;
}

form .col-sm-3 {
	-ms-flex: 0 0 25%;
	flex: 0 0 18%;
	max-width: 25%;
}

form b {
	font-weight: normal;
}

form .form-group {
	margin-bottom: 2px;
}

form input[type="text"] {
	width: 118px;
}
form input[type="datetime"] {
	width: 118px;
}

input[type="button"], input[type="submit"] {
	.btn1 { border: 0px;
	/* -webkit-box-shadow: inset 0px 1px 0px 0px #bbdaf7; */
	/* box-shadow: inset 0px 1px 0px 0px #bbdaf7; */
	background: rgb(56,56,56);
	background: -moz-linear-gradient(top, rgba(56,56,56,1) 14%, rgba(117,117,117,1) 99%, rgba(117,117,117,1) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(14%,rgba(56,56,56,1)), color-stop(99%,rgba(117,117,117,1)), color-stop(100%,rgba(117,117,117,1)));
	background: -webkit-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
	background: -o-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
	background: -ms-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
	background: linear-gradient(to bottom, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#383838', endColorstr='#757575',GradientType=0 );
	/* background-color: #79bbff; */
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	/* border: 1px solid #84bbf3; */
	display: inline-block;
	color: #EFEFEF;
	font-family: "微软雅黑",arial;
	font-size: 14px;
	font-weight: normal;
	padding: 4px 20px;
	text-decoration: none;
	/* text-shadow: 1px 1px 0px #528ecc; */
	cursor: pointer;
}

h2{
	font-size: 16px !important;
}
html, body {
	background: #dedede;
}

.fixed-top {
	height: 100%;	
}
</style>
<body>
	<div class="fixed-top">
		<div class="row header01">
			<div class="col-2 name-website">
				<h3 class="text-light font-italic">
					<img src="images/eg.png" height="50"/>
				</h3>
			</div>

			<div class="col-5">		
				<p class="text-white" id="time"></p>
			</div>
			<div class="col-5">
				<div style="float: right;">
					<div style="float: left;margin-right: 10px;">
						<div style="background: #ff6c04;color: #fff;text-align: center;height: 60px;width: 60px;margin-top: 5px;">
							<i class="fa fa-user" style="font-size: 60px;margin-top: 0px;"></i>
						</div>
					</div>
					<div style="float: left;padding: 0;">
						<div class="col-12 text-white" style="padding: 0;font-size: 14px;">SYSTEM TIME: <?php echo date('Y-m-d h:i:s');?></div>
						<?php
						$user="";              

						if(isset($_SESSION['user'])){
							$user_type = $_SESSION['user_type'];
							if($user_type == 'superadmin'){
								$user_type_lable = 'Super Admin';
							}
						echo '<div class="col-12" style="padding: 0;font-size: 14px;"><strong style="color:#ff6c04;">'.$_SESSION['user'].'</strong><br/><strong style="color:#ffff;">'.$user_type_lable.'</strong><a href="verification.php?logout" onclick="return ConfirmLogOut()"><button class="logout" style="float: right;"><b>Logout</b><i class="fa fa-sign-out ml-2"></i></button></a></div>';
						$user=$_SESSION['user'];
						}


						
						?> 
					</div>
				</div>				
			</div>
			
		</div>
     </div>

		<!--<div class="row header02 font-weight-bold text-center bg-light">
			<div class="col-1 header02menu <?php if($_SESSION['page']=='home'){echo 'active';}?>" onclick="window.location.assign('new_transaction.php')">
			<i class="fa fa-dollar"></i>Transaction
			</div>
			<div class="col-1 header02menu <?php if($_SESSION['page']=='customer'){echo 'active';}?>" onclick="window.location.assign('customer.php')">
			<i class="fa fa-user"></i>Account</div>
			<div class="col-1 header02menu <?php if($_SESSION['page']=='bank'){echo 'active';}?>" onclick="window.location.assign('bank.php')">
			<i class="fa fa-home"></i>Bank</div>
			<div class="col-1 header02menu <?php if($_SESSION['page']=='product'){echo 'active';}?>" onclick="window.location.assign('product.php')">
			<i class="fa fa-th"></i>Product</div>
            <div class="col-1 header02menu <?php if($_SESSION['page']=='promotion'){echo 'active';}?>" onclick="window.location.assign('show_promotion_list.php')">
			<i class="fa fa-gift" style="margin-top: 6px;"></i>Promotion</div>
			<div class="col-1 header02menu <?php if($_SESSION['page']=='finance'){echo 'active';}?>" onclick="window.location.assign('bank_transaction.php')">
			<i class="fa fa-pie-chart"></i>Finance</div>
			<div class="col-1 header02menu <?php if($_SESSION['page']=='report'){echo 'active';}?>" onclick="window.location.assign('Finanace_Report.php')">
			<i class="fa fa-bar-chart"></i>Report</div>
			<?php if($_SESSION['user_type']=='superadmin'){?>
			<div class="col-1 header02menu <?php if($_SESSION['page']=='user'){echo 'active';}?>" onclick="window.location.assign('https://readyforyourreview.com/BackendCRMsystem/user_manage.php')">
			<i class="	fa fa-group"></i>Admin User</div>
			<?php }?>
            

		</div>-->
        
        <div class="row header02 font-weight-bold text-center bg-light" style="margin-top: 71px;">
			            
            <a href="new_transaction.php" class="col-2 header02menu <?php if($_SESSION['page']=='home'){echo 'active';}?>"><i class="fa fa-dollar"></i>Transaction</a>
            
            <a href="customer.php" class="col-2 header02menu <?php if($_SESSION['page']=='customer'){echo 'active';}?>"><i class="fa fa-user"></i>Account</a>
            
            <a href="bank.php" class="col-2 header02menu <?php if($_SESSION['page']=='bank'){echo 'active';}?>"><i class="fa fa-home"></i>Bank</a>
           
           	<a href="product.php" class="col-2 header02menu <?php if($_SESSION['page']=='product'){echo 'active';}?>"><i class="fa fa-th"></i>Product</a>
            <a href="show_promotion_list.php" class="col-2 header02menu <?php if($_SESSION['page']=='promotion'){echo 'active';}?>"><i class="fa fa-gift"></i>Promotion</a>
            
            <a href="bank_transaction.php" class="col-2 header02menu <?php if($_SESSION['page']=='finance'){echo 'active';}?>"><i class="fa fa-pie-chart"></i>Finance</a>
            
            <a href="Finanace_Report.php" class="col-2 header02menu <?php if($_SESSION['page']=='report'){echo 'active';}?>"><i class="fa fa-bar-chart"></i>Report</a>
            <?php if($_SESSION['user_type']=='superadmin'){?>
            <a href="user_manage.php" class="col-2 header02menu <?php if($_SESSION['page']=='user'){echo 'active';}?>"><i class="	fa fa-group"></i>Admin User</a>
          <?php }?>

		</div>

	

</body>
</html>