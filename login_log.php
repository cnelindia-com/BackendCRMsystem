<?php
session_start();

$_SESSION['page']='user';

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
	<a href="user_manage.php" id="sc8_1">User Manage</a>
    <span>|</span>
    <a href="login_request.php" id="sc8_1">Login Request</a>
    <span>|</span>
    <a href="login_log.php" id="sc8_1" class="actives">Login Log</a>
</div>
<div class="container" >
  <div class="filternav">
	<h2>Admin UserLogin Log</h2>
		<form method="post">
			<div class="form-group">
				<div class="col-md-2">
					<b>Date</b>
				</div>
				<div class="col-md-10">
					<input type="datetime" name="fromdate" id="fromdate" value="<?php if(isset($_POST['fromdate'])){echo $_POST['fromdate'];}?>"/> ~
					<input type="datetime" name="todate" id="todate" value="<?php if(isset($_POST['todate'])){echo $_POST['todate'];}?>"/>
                    
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
				<div class="col-md-2">Platform</div>
				<div class="col-md-10">
                
                <?php  
				
					if(!isset($_POST['submit']))              	
					{
						$_POST['viewtype'][]='All';
						$_POST['viewtype'][]='PC';
						$_POST['viewtype'][]='Mobile';
						$_POST['viewtype'][]='Tablet';	
					}
					
					if(isset($_POST['viewtype']))
					{
						//var_dump($_POST['viewtype']);
						$devicetype=$_POST['viewtype'];	
					}
                ?>				
					<input type="checkbox" name="viewtype[]" value="All" class="checkalldevices" <?php if(in_array('All', $_POST['viewtype'])){echo "checked";}?>/>All 
					<input type="checkbox" name="viewtype[]" value="PC" <?php if(in_array('PC', $_POST['viewtype'])){echo "checked";}?>/>PC
					<input type="checkbox" name="viewtype[]" value="Mobile" <?php if(in_array('Mobile', $_POST['viewtype'])){echo "checked";}?>/>Mobile  
                    <input type="checkbox" name="viewtype[]" value="Tablet" <?php if(in_array('Tablet', $_POST['viewtype'])){echo "checked";}?>/>Tablet
				</div>
			</div>
            
            <div class="form-group">
				<div class="col-md-2">Search</div>
				<div class="col-md-10">					
					<select name="search">
                    	<option value="Username" <?php if(isset($_POST['search']) && ($_POST['search'] == 'Username')){echo "selected='selected'";}?>>Username</option>
                        <option value="IP" <?php if(isset($_POST['search']) && ($_POST['search'] == 'IP')){echo "selected='selected'";}?>>IP</option>
                        <option value="Description" <?php if(isset($_POST['search']) && ($_POST['search'] == 'Description')){echo "selected='selected'";}?>>Description</option>
                        <option value="UserAgent" <?php if(isset($_POST['search']) && ($_POST['search'] == 'UserAgent')){echo "selected='selected'";}?>>User-Agent</option>
                    </select>
                    <input type="text" name="searchtext" value="<?php if((isset($_POST['searchtext'])) && !empty($_POST['searchtext'])){echo $_POST['searchtext'];}?>" />
				</div>
			</div>
						
			<div>
				<input type="submit" class="btn btn-secondary" name="submit" id="submit" value="Enquiry"/>
				<input type="button" class="btn btn-secondary" name="exportreport" value="Export Report"/>
			</div>
		</form>
    </div>
    <br/>
    <br/>
    <div class="resulttable">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                  <th>No</th>
                  <th class="col-md-3 col-xs-3">Username</th>
                  <th class="col-md-3 col-xs-3">IP</th>
                  <th class="col-md-3 col-xs-3">Platform</th>
                  <th class="col-md-3 col-xs-3">Description</th>
                  <th class="col-md-3 col-xs-3">Date</th>
                  <th class="col-md-3 col-xs-3">User-Agent</th>
              	</tr>
            </thead>
            <tbody>
            
            <?php
			
			if(isset($_POST['viewtype']))
			{							
            	$logusersql="SELECT * FROM `login_log` WHERE 1=1";
				
				$count=0;
				if(isset($_POST['fromdate']) && !empty($_POST['fromdate']) && isset($_POST['fromdate']) && !empty($_POST['todate']))
			{
				$fromdate=$_POST['fromdate'];
				$todate=$_POST['todate'];
				$logusersql.=" AND login_time BETWEEN '$fromdate' AND '$todate'";
			}
			
				if(isset($_POST['viewtype']))
				{
					$devices="'".implode("','", $devicetype)."'";
					//echo $devices;
					$logusersql.=" AND plateform IN ($devices)";	
				}	
				
				if(isset($_POST['search']))		
				{
					$searchwithinfo=$_POST['searchtext'];
					if($_POST['search']=='Username')	
					{
						$logusersql.=" AND user_id LIKE '%$searchwithinfo%'";
					}
					if($_POST['search']=='IP')	
					{
						$logusersql.=" AND IP LIKE '%$searchwithinfo%'";
					}
					if($_POST['search']=='Description')	
					{
						$logusersql.= " AND status LIKE '%$searchwithinfo%'";
					}
					if($_POST['search']=='UserAgent')	
					{
						$logusersql.=" AND user_agent LIKE '%$searchwithinfo%'";
					}
				}

				$logusersql.=" ORDER BY login_time DESC";
				$loguserres=mysqli_query($conn, $logusersql);
			
				while($loguserrows=mysqli_fetch_assoc($loguserres))
				{
				
			?>
            	<tr>
                  <td><?php echo ++$count;?></td>
                  <td><?php echo $loguserrows['user_id'];?></td>
                  <td><?php echo $loguserrows['IP'];?></td>
                  <td><?php echo $loguserrows['plateform'];?></td>
                  <td><?php echo $loguserrows['status'];?></td>
                  <td><?php echo $loguserrows['login_time'];?></td>
                  <td><?php echo $loguserrows['user_agent'];?></td>
              	</tr>                
            
            <?php
				}
			}
			?>
            
            </tbody>
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
	
	$(document).ready(function(e) {		
        $(".checkalldevices").click(function(){
			$("input[name='viewtype[]']").not(this).prop('checked', this.checked);
		});
    });
</script>