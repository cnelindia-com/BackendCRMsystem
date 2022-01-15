<?php
session_start();

$_SESSION['page']='customer';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
$success='';
if(isset($_GET['delete_id']))
{
	$delete_id = $_GET['delete_id'];
	$dlt_sql = "DELETE from account where id=$delete_id";
	if(mysqli_query($conn,$dlt_sql)==TRUE)
	{
		$success='Account Deleted Successfully.';
	}
}
/*
$user=$_SESSION['user'];
$search="";
$searchkey='';
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

$csv_data[] = array("No", "Username", "User Code", "Full Name", "Email", "Phone", "IP", "Registered On", "Last Active", "Status");*/
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
<!--
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
	<a href="customer.php" id="sc8_1" class="actives">Account</a>
    <span>|</span>
    <a href="vip_setting.php" id="sc8_1">VIP Setting</a>
</div>
  <div class="container" >
  <div class="filternav">
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
			<h2>Account</h2>
                 <form method="get">
                    <div class="form-group">
                        <div class="col-md-1">
                            <b>Status </b>
                        </div>
                        <div class="col-md-11">
                             <select name="aflt" id="istatus">
                                <option value="">All</option>
                                <option value="Active" <?php if(isset($_GET['aflt']) && $_GET['aflt'] == 'Active'){ echo 'selected="selected"'; }?>>Active</option>
                                <option value="Suspended" <?php if(isset($_GET['aflt']) && $_GET['aflt'] == 'Suspended'){ echo 'selected="selected"'; }?>>Suspended</option>
                            </select>       
                            
                            <input type="text" name="search_field" value="<?php echo $_GET['search_field'];?>"/>
                            In
                            <select name="usersearch" id="usersearch">
                                
                                <option value="usernameusercode" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='usernameusercode'){echo 'selected';}?>>Username/User Code</option>
                                <option value="fullname" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='fullname'){echo 'selected';}?>>Full Name</option>
                                <option value="phone" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='phone'){echo 'selected';}?>>Telephone No</option>
                                <option value="productusername" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='productusername'){echo 'selected';}?>>Product Username</option>
                                <option value="bankaccnameno" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='bankaccnameno'){echo 'selected';}?>>Bank Account</option>
                                <option value="email" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='email'){echo 'selected';}?>>Email</option>
                                <option value="remark" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='remark'){echo 'selected';}?>>Remark</option>
                                <option value="upline_id" <?php if(isset($_GET['usersearch']) && $_GET['usersearch']=='upline_id'){echo 'selected';}?>>Upline</option>
                               <!-- <option value="ip">IP</option>
                                <option value="referral">Referral Site</option>-->
                            </select>           
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-1">
                            <b>Date</b>
                        </div>
                        <div class="col-md-11" style="padding-left: 0;">
                        <?php 
						$searched_fromdate= '';
						$searched_todate= '';
						if(isset($_GET['fromdate']) && isset($_GET['todate']))
						{
							$searched_fromdate= $_GET['fromdate'];
							$searched_todate= $_GET['todate'];
						}
						?>
							
						<div class="col-md-6">
								<div class="input-group date form_datetime from_datetime" data-date="<?php  echo date("Y-m-d H:i:s"); ?>" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="fromdate" style="width: 170px;float: left;">
									<input size="16" type="text" value="<?php echo $searched_fromdate;?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar" style="color: #000;"></span></span>
								</div>
								<input type="hidden" id="fromdate" name="fromdate" value="<?php echo $searched_fromdate;?>" />
								
								<div style="float:left;margin-right: 11px;">~</div>
								<div class="input-group date form_datetime to_datetime" data-date="<?php  echo date("Y-m-d H:i:s"); ?>" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="todate" style="width: 170px;float: left;">
									<input size="16" type="text" value="<?php echo $searched_todate;?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar" style="color: #000;"></span></span>
								</div>
								<input type="hidden" id="todate" name="todate" value="<?php echo $searched_todate;?>" />
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
                        <input type="submit" class="btn btn-secondary" name="submit" id="submit" value="Search"/>
                        <a href="add_account.php" class="btn btn-secondary">Add</a>
                        <input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
                    </div>
                </form>
     
</div>


<span class="counter pull-right"></span>
<table class="table table-hover table-bordered results" id="table2excel">
  <thead style="background-color: #ff720b;">
    <tr>
      <th>NO</th>
      <th class="col-md-3 col-xs-3">Username</th>
      <th class="col-md-3 col-xs-3">User Code</th>
      <th class="col-md-3 col-xs-3">Full Name</th>
      <th class="col-md-3 col-xs-3">Email</th>
      <th class="col-md-3 col-xs-3">Phone</th>
      <!--<th class="col-md-3 col-xs-3">IP</th>-->
      <th class="col-md-3 col-xs-3">Registered On</th>
      <th class="col-md-3 col-xs-3">Last Active</th>
      <th class="col-md-3 col-xs-3">Status</th>
      <th class="col-md-3 col-xs-3">Delete</th>
      </tr>
  </thead>
<tbody>
  <?php 
  //$filter = $_POST['aflt'];
 /*
  if(!empty($filter)){
	     $sqla="SELECT * From account WHERE status='$filter'";
        $results=$conn->query($sqla);
        if ($results->num_rows > 0) {
          while($rows = $results->fetch_assoc()) {
			 
			  $csv_data[] = array($row['id'], $row['username'], $row['user_code'], $row['full_name'], $row['email'], $row['phone'], '11', '11', '11', $row['status']);
			  ?>
	  <tr class="noExl">
      <td scope="row"><?php echo $rows['id']; ?></td>
      <td><a href="account_edit.php?id=<?php echo $rows['id']; ?>"><?php echo $rows['username']; ?></a></td>
      <td><?php echo $rows['user_code']; ?></td>
      <td><?php echo $rows['full_name']; ?></td>
      <td><?php echo $rows['email']; ?></td>
      <td><?php echo $rows['phone']; ?></td>
      <!--<td>11</td>-->
      <td>11</td>
      <td>11</td>
      <?php if($rows['status'] == 'Active'){ ?>
      <td style="background:#00ff7f; color:black;"><?php echo $rows['status']; }?></td>
      <?php if($rows['status'] == 'Suspended '){ ?>
      <td style="background:#ffc1cc; color:black;"><?php echo $rows['status']; }?></td>
      <td align="left">
		<i class="fa fa-trash ml-2"></i>
	 </td>
     </tr>
    <?php

		  }
		  }
  
		
	  }else{*/
	  
	  
        $sql="SELECT * From account WHERE 1=1";
		 
		if(isset($_GET['adminuserid']) && !empty($_GET['adminuserid'])){
			$adminuserid = $_GET['adminuserid'];
			$sql .= " AND adminuserid='$adminuserid'";
		}			

		
		if(isset($_GET['aflt']) && !empty($_GET['aflt']))
		{
			$status = $_GET['aflt'];
			$sql.=" AND status= '$status'";
		}

		$search_field = $_GET['search_field'];
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='usernameusercode')
		{
			if(!empty($search_field))
			{
				$sql.=" AND username LIKE '%$search_field%' OR usercode LIKE '%$search_field%'";
			}
		}
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='fullname')
		{
			$sql.=" AND fullname LIKE '%$search_field%'";
		}
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='phone')
		{
			$sql.=" AND phone LIKE '%$search_field%'";
		}
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='email')
		{
			$sql.=" AND email LIKE '%$search_field%'";
		}
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='remark')
		{
			$sql.=" AND remark LIKE '%$search_field%'";
		}		
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='productusername')
		{
			$sql.=" AND productIDS LIKE '%$search_field%'";
		}
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='bankaccnameno')
		{
			$sql.=" AND bankdetail LIKE '%$search_field%'";
		}		
		if(isset($_GET['usersearch']) && $_GET['usersearch']=='upline_id')
		{
			$sql.=" AND adminuserid LIKE '%$search_field%'";
		}
		
		if(isset($_GET['fromdate']) && !empty($_GET['fromdate']))
		{
			$fromdate = $_GET['fromdate'];
			$sql.=" AND createdON >= '$fromdate'";		
		}
		
		if(isset($_GET['todate']) && !empty($_GET['todate']))
		{
			$todate = $_GET['todate'];
			$sql.=" AND createdON <= '$todate'";		
		}
	
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
			$count=1;
          while($row = $result->fetch_assoc()) {

  ?>
    <tr class="noExl">
      <td scope="row"><?php echo $count++; ?></td>
      <td><a style="text-decoration: underline;color:#0055ff;" href="add_account.php?id=<?php echo $row['id']; ?>"><?php echo strtoupper($row['username']); ?></a></td>
      <td><?php echo $row['usercode']; ?></td>
      <td><?php echo $row['fullname']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td>
	  	<?php 
		
		echo $phone = implode(', ',json_decode($row['phone'])); 
		
		?>
      </td>
      <!--<td>11</td>-->
      <td><?php echo $row['createdON']?></td>
      <td>      
      <?php 
	  		
		$accid=$row['id'];
		$last_active='';
		$transdatetimesql=mysqli_query($conn, "SELECT transferdate, hours, minutes, seconds FROM `transactions` WHERE accountid=$accid");
		while($transdatetimerow=mysqli_fetch_assoc($transdatetimesql))
		{			
			$last_active=$transdatetimerow['transferdate']." ".sprintf("%02s", $transdatetimerow['hours']).":".sprintf("%02s", $transdatetimerow['minutes']).":".sprintf("%02s", $transdatetimerow['seconds']);
		}
		
		if($last_active=='')
		{
			echo "0000-00-00 00:00:00";	
		}
		else
		{
			echo $last_active;		
		}
	  ?>
      </td>
      <?php 
		if($row['status']=="Active")
		{
		?>
		<td style="background: #C6FFD9;text-align: center;"><?php echo $row['status'];?></td>  
		<?php
		}
		else if($row['status']=="Suspended")
		{
		?>  
		<td style="background: #FFCCCC;text-align: center;"><?php echo $row['status'];?></td>    
		<?php
		}                  
		?>
      <td align="left">
		<a href="?delete_id=<?php echo $row['id'];?>" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash ml-2"></i></a>
	 </td>
    </tr>
   <?php 
    }
		}
	//  }
	?>	

 </tbody>
</table>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
</script>	
<script>
	$(document).ready(function(){
		$("#submit").click(function(){
			$(".resulttable").show();
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
</div>
</div>

</body>
</html>

<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

<?php
if(isset($_GET['exportexcel'])){
$filename = 'account.csv';
	$file = fopen($filename,"w");
	foreach ($csv_data as $line){

				fputcsv($file,$line);
			}

fclose($file);
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   

         $url = "https://";   

    else  

         $url = "http://";   

    // Append the host(domain name, ip) to the URL.   

   		$url.= $_SERVER['HTTP_HOST'];

	 $open_url = $url.'/BackendCRMsystem/'.$filename;

	 //file_get_contents('download-file.php');

	 

	 ?>

	 <script>

	 var url = "<?php echo $open_url ?>";

	 //location.replace(url);

	  //window.open(url, "datacsvWindow5", "width=800,height=600");

	  window.open(url);

	</script>
    <?php
}
