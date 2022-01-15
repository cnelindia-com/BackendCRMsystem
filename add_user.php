<?php
session_start();

if(isset($_POST['mdl'])){
	include 'config.php';
	
	$susername= $_POST['susername'];
	$spassword= $_POST['spassword'];
	$passwd= md5($spassword);
	
	$sfirstname= $_POST['sfirstname'];
	$slastname= $_POST['slastname'];	
	$name=$sfirstname." ".$slastname;
	$sphoneno= $_POST['sphoneno'];
	$semail= $_POST['semail'];
	$istatus= $_POST['istatus'];
	$slanguage= $_POST['slanguage'];
	$sremark=$_POST['sremark'];
	$itimezone= $_POST['itimezone'];			
	$spb273648= $_POST['spb273648'];
	$srole= $_POST['srole'];
	$mdl= $POST['mdl'];	
	$action= $POST['action'];
	$currdatetime=date('Y-m-d', strtotime("now"));
	
	$createdon_obj=DateTime::createFromFormat("Y-m-d", "$currdatetime", new DateTimeZone("$itimezone"));	
	$createdon=	$createdon_obj->format('Y-m-d H:i:s');
	
	$adminusersql= "INSERT INTO `user_info` (user_id, password, type, name, phone_no, email, status, remark, createdOn, last_login) VALUES ('$susername', '$passwd', '$srole', '$name', '$sphoneno', '$semail', '$istatus', '$sremark', '$createdon', '$itimezone')";	
	
	mysqli_query($conn, $adminusersql);
	
	echo json_encode(array('result' => 'success'));		
	die();
}

if(isset($_POST['editadminuser'])){
	include 'config.php';
	
	$adminid=$_POST['editadminuser'];
	$susername= $_POST['susername'];
	$spassword= $_POST['newusrpassword'];
	$passwd= md5($spassword);
	
	$sfirstname= $_POST['sfirstname'];
	$slastname= $_POST['slastname'];	
	$name=$sfirstname." ".$slastname;
	$sphoneno= $_POST['sphoneno'];
	$semail= $_POST['semail'];
	$istatus= $_POST['istatus'];
	$slanguage= $_POST['slanguage'];
	$sremark=$_POST['sremark'];
	$itimezone= $_POST['itimezone'];			
	$spb924665= $_POST['spb924665'];
	$srole= $_POST['srole'];	
	
	if($spassword==''){
		$adminusersql= "UPDATE `user_info` SET user_id='$susername', name='$name', phone_no='$sphoneno', email='$semail', status='$istatus', remark='$sremark', last_login='$itimezone' WHERE id=$adminid";
		mysqli_query($conn, $adminusersql);	
	}
	
	else
	{
		$adminusersql= "UPDATE `user_info` SET user_id='$susername', password='$passwd', name='$name', phone_no='$sphoneno', email='$semail', status='$istatus', remark='$sremark', last_login='$itimezone' WHERE id=$adminid";	
		mysqli_query($conn, $adminusersql);
	}
	
	if(isset($srole) && !empty($srole)){
		$adminusersql= "UPDATE `user_info` SET user_id='$susername', type='$srole', name='$name', phone_no='$sphoneno', email='$semail', status='$istatus', remark='$sremark', last_login='$itimezone' WHERE id=$adminid";	
		mysqli_query($conn, $adminusersql);
	}
	else
	{
		$adminusersql= "UPDATE `user_info` SET user_id='$susername', name='$name', phone_no='$sphoneno', email='$semail', status='$istatus', remark='$sremark', last_login='$itimezone' WHERE id=$adminid";	
		mysqli_query($conn, $adminusersql);
	}		
	
	
	echo json_encode(array('result' => 'success'));		
	die();	
}


$_SESSION['page']='user';

include('header.php');

/*if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}*/

$user=$_SESSION['user'];
$search="";
$searchkey='';
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

$csv_data[] = array("No", "Username", "User Code", "Full Name", "Email", "Phone", "IP", "Registered On", "Last Active", "Status");

if(isset($_GET['edit_id'])){
	//echo  "SELECT * FROM `user_info` WHERE id= ".$_GET['id'];
	$userres=mysqli_query($conn, "SELECT * FROM `user_info` WHERE id= ".$_GET['edit_id']);
	$userrows=mysqli_fetch_assoc($userres);	
	//print_r($userrows);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
body, html {
	background-color: FFFFFF;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding: 0px;
	overflow: auto;
	height: 100%;
}	
.asterisk {
	font-size: 14px;
	color: #e60000;
}
.textbox1, .textbox2 {
	/* background: url(../img/keyIcon.png) 14px 11px no-repeat, linear-gradient(to bottom, #f7f7f8 0%,#ffffff 100%); */
	border-radius: 3px;
	border: none;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2) inset, 0 -1px 0 rgba(0,0,0,0.05) inset;
	transition: all 0.2s linear;
	font-family: "微软雅黑", "Helvetica Neue", sans-serif;
	font-size: 13px;
	color: #222222;
	position: relative;
	height: 26px;
	width: 130px !important;
	padding-left: 5px;
	&: :-webkit-input-placeholder { color: #999999; } &:-moz-placeholder { color: #999999; } &:focus{ box-shadow: 0 1px 0 #2392F3 inset, 0 -1px 0 #2392F3 inset, 1px 0 0 #2392F3 inset, -1px 0 0 #2392F3 inset, 0 0 4px rgba(35,146,243,0.5); outline: none; };
}
th {
	text-align: initial;
}	
body#popmenu {
	margin-bottom: 0 !important;
}
body {
	font-size: 14px;
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, SimSun, sans-serif;
	/* font-family: "微软雅黑", Arial, Tahoma, Helvetica, Hiragino Sans GB, WenQuanYi Micro Hei, Verdana, Aril, sans-serif; */
	background: #DEDEDE;
	margin: 0 0 50px;
}
.outerformborder1 {
	border: 1px solid #808080;
	margin: 0 10px 20px;
}
.subtitle1 b {
	font-size: 14px;
	color: #4d4d4d;
	font-family: "微软雅黑", Tahoma, Arial, Helvetica, sans-serif;
	padding: 0 4px 0 5px;
	background: #ffffff;
}
.horline_wt {
	border-top: 1px solid #fff;
}
body#popmenu {
	margin-bottom: 0 !important;
}
.title1 {
	text-align: center;
	margin: 18px auto 19px;
}
.content_table2 {
	width: 50%;
}
.innerformborder1 {
	border: 1px solid #fff;
}
.subtitle1 {
	text-align: left;
	height: 14px;
	padding-left: 3px;
	top: -10px;
}

.form_sp1 {
	margin: 0 14px 12px;
}
.formtable1 {
	font-size: 11px;
}	
.formtable1 td {
	height: 25px;
	white-space: nowrap;
	text-align: left;
}
.formtable1 th {
	font-size: 14px;
	font-weight: normal;
	width: 130px;
	padding-right: 20px;
}	
.notice1 {
	padding: 0 865px 20px 15px;
}
.btn_bar1 {
	background: inherit;
	margin: 0 10px;
	padding: 5px 0 5px 0;
	/*+padding: 6px 0 4px 0;*/
	text-align: center;
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
	height: 20px;
	padding: 0 5px 1px 5px;
	white-space: nowrap;
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
<script src="/src/jquery.table2excel.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>



<body id="popmenu">
<div class="horline_wt"></div>

 <?php 
  $filter = $_POST['aflt'];
 ?>

 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="user_manage.php" id="sc8_1" class="actives">User Manage</a>
    <span>|</span>
    <a href="login_request.php" id="sc8_1">Login Request</a>
    <span>|</span>
    <a href="login_log.php" id="sc8_1">Login Log</a>
</div>
<div class="title1">
 <center><h2><strong>New Admin User</strong></h2></center>
<form name="spbform" id="spbform" action="" method="POST">
<div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
    	<tr valign="top">
		<td class="content_table2">
			<div class="outerformborder1"><div class="innerformborder1">
				<div class="subtitle1">
                <b>Infomation</b>
           	</div>
				
				<div class="form_sp1">
					<table class="formtable1" cellspacing="0" cellpadding="0" border="0">
					<tbody>
                    <tr>
						<td class="asterisk width10">*</td>

						<th>Username</th>
                        <?php
                        if(isset($_GET['edit_id'])){
							if(isset($_GET['edit_id'])){
							echo "<td>".$userrows['user_id']."</td>";
							echo "<input type='hidden' name='susername' class='textbox1 width92' value='".$userrows['user_id']."'>";
							echo "<input type='hidden' name='editadminuser' class='textbox1 width92' value=".$userrows['id'].">";	
						}	
						}
						else{
						?>                        							    
							<td><input type="text" name="susername" class="textbox1 width92" value=""></td>			                     		<input type="hidden" name="mdl" value="adminuser">
                         <?php
						}
						?>
					</tr>
					<tr>
                    <?php
						if(isset($_GET['edit_id']))
						{
					?>
						<td class="asterisk width10">*</td>
						<th>New Password</th>
						<td><input type="password" name="newusrpassword" class="textbox1 width92" id="bnkuserpass"></td>
                        
					<?php
						}
						else
						{
					?>
						<td class="asterisk width10">*</td>
						<th>Password</th>
						<td><input type="password" name="spassword" class="textbox1 width92" id="bnkuserpass"></td>					 					<?php
						}
					?>                    	
					</tr>
					<tr>
						<td class="asterisk width10">*</td>
						<th>Retype Password</th>
						<td><input type="password" name="svpassword" class="textbox1 width92" id="cbnkuserpass"></td>
					</tr>
                    
                        <?php
							$name=array();
							$name=explode(" ", $userrows['name']);
							$firstname=$name[0];
							$lastname=$name[1];
						?>

					<tr>
						<td class="asterisk width10">*</td>
						<th>First Name</th>                        
						<td><input type="text" name="sfirstname" class="textbox1 width92" value="<?php echo $firstname;?>"></td>                       
					</tr>
					<tr>
						<td class="asterisk width10">*</td>
						<th>Last Name</th>
						<td><input type="text" name="slastname" class="textbox1 width92" value="<?php echo $lastname;?>"></td>
					</tr>
                    
                    <tr>
						<td class="asterisk width10"></td>
						<th>Phone NO</th>
						<td><input type="text" name="sphoneno" class="textbox1 width92" value="<?php echo $userrows['phone_no'];?>"></td>
					</tr>
                    
					<tr>
						<td class="asterisk width10"></td>
						<th>Email</th>
						<td><input type="text" name="semail" class="textbox1 width92" value="<?php echo $userrows['email'];?>"></td>
					</tr>
					<tr>
						<td class="asterisk width10"></td>
						<th>Language</th>
						<td><select name="slanguage" class="select1">
							<option label="Chinese" value="cn">Chinese</option>
							<option label="English" value="en">English</option>

						</select>
                        </td>
					</tr>
                    <!--<tr>
						<td class="asterisk width10">*</td>
						<th>Remark</th>
						<td><input type="text" name="sremark" class="textbox1 width92" value=""></td>
					</tr>
					<tr>-->
						<td class="asterisk width10"></td>
						<th>GMT Timezone</th>
						<td><select name="itimezone" class="select1">
							<option label="- 12 Hours" value="-12">- 12 Hours</option>
<option label="- 11 Hours" value="-11">- 11 Hours</option>
<option label="- 10 Hours" value="-10">- 10 Hours</option>
<option label="- 9 Hours" value="-9">- 9 Hours</option>
<option label="- 8 Hours" value="-8">- 8 Hours</option>
<option label="- 7 Hours" value="-7">- 7 Hours</option>
<option label="- 6 Hours" value="-6">- 6 Hours</option>
<option label="- 5 Hours" value="-5">- 5 Hours</option>
<option label="- 4 Hours" value="-4">- 4 Hours</option>
<option label="- 3 Hours" value="-3">- 3 Hours</option>
<option label="- 3.5 Hours" value="-3.5">- 3.5 Hours</option>
<option label="- 2 Hours" value="-2">- 2 Hours</option>
<option label="- 1 Hour" value="-1">- 1 Hour</option>
<option label="- 0 Hours" value="0">- 0 Hours</option>
<option label="+ 1 Hour" value="+1">+ 1 Hour</option>
<option label="+ 2 Hours" value="+2">+ 2 Hours</option>
<option label="+ 3 Hours" value="+3">+ 3 Hours</option>
<option label="+ 3.5 Hours" value="+3.5">+ 3.5 Hours</option>
<option label="+ 4 Hours" value="+4">+ 4 Hours</option>
<option label="+ 4.5 Hours" value="+4.5">+ 4.5 Hours</option>
<option label="+ 5 Hours" value="+5">+ 5 Hours</option>
<option label="+ 5.5 Hours" value="+5.5">+ 5.5 Hours</option>
<option label="+ 6 Hours" value="+6">+ 6 Hours</option>
<option label="+ 6.5 Hours" value="+6.5">+ 6.5 Hours</option>
<option label="+ 7 Hours" value="+7">+ 7 Hours</option>
<option label="+ 8 Hours" value="+8" selected="selected">+ 8 Hours</option>
<option label="+ 9 Hours" value="+9">+ 9 Hours</option>
<option label="+ 9.5 Hours" value="+9.5">+ 9.5 Hours</option>
<option label="+ 10 Hours" value="+10">+ 10 Hours</option>
<option label="+ 11 Hours" value="+11">+ 11 Hours</option>
<option label="+ 12 Hours" value="+12">+ 12 Hours</option>
<option label="+ 13 Hours" value="+13">+ 13 Hours</option>

						</select></td>
					</tr>
					<tr>
						<td class="asterisk width10" valign="top">*</td>
						<th valign="top">Role</th>
						<td>
                        <table class="spbform" cellspacing="0" cellpadding="1" border="0">
							<tbody>
                            <tr>
                            <td valign="top">&nbsp;&nbsp;Available<br>
								
                                <select name="spb273648" size="10" style="width: 228px" ondblclick="swpAddSwapValue(this,'spb924665','srole',0)" id="spb273648" multiple>
                                
								<option label="Super Admin" value="superadmin">Super Admin</option>                                <option label="MANAGER" value="manager">MANAGER</option>                  				
								</select>
                                
                                </td>
								<td valign="middle">
                          <div onclick="swpAddSwapValue(document.getElementById('spb273648'),'spb924665','srole',0)" title="Add" style="position: relative">
                           <img src="images/right.png" style="width:25px;">
                                </div>
                                
                                <br>
						<div onclick="swpRemoveSwapValue(document.getElementById('spb924665'),'spb924665','srole')" title="Remove" style="position: relative">
                                <img src="images/left.png" style="width:25px;">
                                </div>
                                <div style="position: relative">
                                <img alt="" src="image/spacer.gif" border="0">
                                </div>                                
                                </td>
                                
                                <td valign="top">
                                	Current
                                   <br>
                                
                                <select name="spb924665" size="10" style="width: 228px" ondblclick="swpRemoveSwapValue(this,'spb924665','srole')" id="spb924665" multiple>	
                                <?php									
                                	if(isset($_GET['edit_id'])){
										$userrole=explode(",", $userrows['type']);
										//print_r($userrole);
										//echo count($userrole);
										for($i=0; $i<count($userrole) && $userrole[$i]!==''; $i++)
										{
											echo "<option value='".$userrole[$i]."'>".ucfirst($userrole[$i])."</option>";	
										}
									}
								?>															                               	
                                </select>
                                
                                <br>
								</td>
								<td valign="middle"></td>
							</tr>
							</tbody>
                            </table>
							<input type="hidden" name="srole" value="" id="srole">
						</td>
					</tr>					
					
					<tr>
						<td class="asterisk width10">*</td>
						<th>Status</th>
						<td>
                        <label><input type="radio" name="istatus" value="active" checked>Active</label>&nbsp;
						<label><input type="radio" name="istatus" value="suspended">Suspended</label>&nbsp;
						</td>
					</tr>
					</tbody>
	              </table>
                  
				</div>
			</div>
       	</div>
			
			<div class="notice1">( <span class="asterisk">*</span> ) Mandatory field</div>
		</td>
	</tr>
	</tbody>
    </table>
</div>

		<div class="btn_bar1">
          <input class="btn1" type="button" name="sbtt" value="Submit" onClick="sendMe(this);"></button>&nbsp;          <a href="user_manage.php" class="btn1" style="color:#fff;"> Back </a>
 		</div>
     <input type="hidden" name="action" value="doadd">  
</form>

</div>
 </body>
 </html>
 
<script>

function swpAddSwapValue(usertype, userid, num){	
	
	var sourceuser= jQuery(usertype).val();	
	if(jQuery("#spb273648 option").is(":selected")){		
		jQuery('#'+userid+' select').html('<option value=""> </option>');			
		jQuery('#'+userid).append("<option value='"+sourceuser+"'>"+sourceuser+"</option>");
	}
	var srole=[];
	jQuery("#"+userid+ " option").each(function(){		
		srole.push(jQuery(this).val());
	});	
		
	var sroleval= srole.join(",");		
	jQuery("#srole").val(sroleval);						
}

function swpRemoveSwapValue(usertypeget, userid){	
	var usertype= jQuery(usertypeget).val();		
	jQuery('#'+userid+' option:selected').remove("[value='"+usertype+"']");
	
	var srole=[];
	jQuery("#"+userid+ " option").each(function(){
		srole.push(jQuery(this).val());
	});	
	
	var sroleval= srole.join(",");
	jQuery("#srole").val(sroleval);
}

function sendMe(t){

	var bnkuserpass= jQuery('#bnkuserpass').val();
	var cbnkuserpass= jQuery('#cbnkuserpass').val();	
//	alert(bnkuserpass);
//	alert(cbnkuserpass);							
	
	if(jQuery("input[name='editadminuser']").val())
	{
		
	if(jQuery("input[name='newusrpassword']").val())
	{
		if(!jQuery('input[name=susername]').val()){
		alert("Username is a mandatory input, please provide a valid entry");	
		return false;			
		}
		
		else if(bnkuserpass != cbnkuserpass){		
			alert('"Password" does not match "Retype Password"');				
			return false;
		}
		else if(!jQuery("#spb924665 option").val()){			
			alert("Role is a mandatory input, please provide a valid entry");
			return false;	
		}		
		else{						
				
		//alert(jQuery("form#spbform").serialize());	                  
		jQuery.ajax({
			data:jQuery("form#spbform").serialize(),
			dataType:"json",
			type:'POST',
			success:function(response){				
				if(response.result == 'success'){			
					window.location.href="https://readyforyourreview.com/BackendCRMsystem/stage2/user_manage.php";	
				}								
			}
		});			
		}
	
	}
	else{
		if(!jQuery('input[name=sfirstname]').val()){
			alert("First Name is a mandatory input, please provide a valid entry");					
			return false;
		}
		
		else if(!jQuery("#spb924665 option").val()){
			alert("Role is a mandatory input, please provide a valid entry");
			return false;	
		}	
		//alert(jQuery("form#spbform").serialize());	                  
		jQuery.ajax({
			data:jQuery("form#spbform").serialize(),
			dataType:"json",
			type:'POST',
			success:function(response){				
				if(response.result == 'success'){			
					window.location.href="https://readyforyourreview.com/BackendCRMsystem/stage2/user_manage.php";	
				}								
			}
		});
		}
	}
	
	if(jQuery("input[name='mdl']").val()){
		
		if(!jQuery('input[name=susername]').val()){
		alert("Username is a mandatory input, please provide a valid entry");	
		return false;			
		}
		else if(bnkuserpass.length < 8){
			alert("Password must be betwen 8 to 16 in length");				
			return false;
		}
		else if(bnkuserpass==''){
			alert("Password is a mandatory input, please provide a valid entry");				
			return false;
		}
		else if(bnkuserpass != cbnkuserpass){		
			alert('"Password" does not match "Retype Password"');				
			return false;
		}	
		else if(!jQuery('input[name=sfirstname]').val()){
			alert("First Name is a mandatory input, please provide a valid entry");					
			return false;
		}
		else if(!jQuery("#spb924665 option").val()){			
			alert("Role is a mandatory input, please provide a valid entry");
			return false;	
		}
		else if(!jQuery('input[name=istatus]').is(':checked')){
			alert("Please select a status");					
			return false;
		}
	
		else{
			//alert(jQuery("form#spbform").serialize());	                  
			jQuery.ajax({
				data:jQuery("form#spbform").serialize(),
				dataType:"json",
				type:'POST',
				success:function(response){				
					if(response.result == 'success'){			
					window.location.href="https://readyforyourreview.com/BackendCRMsystem/stage2/user_manage.php";	
					}								
				}
			});								
		}
	}	
}
</script>