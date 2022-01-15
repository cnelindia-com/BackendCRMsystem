<?php
session_start();

$_SESSION['page']='customer';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$user=$_SESSION['user'];
$search="";
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

      <script>

      function ConfirmDelete() {  
       var r = confirm("Are you sure you want to DELETE the USER ?");
       if(r==true){var s = confirm("Are you sure you want to DELETE the USER ?(Secrond Confirm)");}else{return false;}
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
body {
    font-size: 14px !important;
    color: #000;
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, SimSun, sans-serif;
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, Hiragino Sans GB, WenQuanYi Micro Hei, Verdana, Aril, sans-serif;
    background: #DEDEDE;
    margin: 0 0 50px;
        margin-bottom: 50px;
}
.tabcontent{
	font-size: 18px;
	background:#cccccc;
	margin-left: -15px;
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
    text-decoration: none !important; 
}
a{
	color:black !important;
}
span{
	color:#ff6c04;
}
.title1 {
    text-align: center;
    margin: 18px auto 19px;
}
#customerInfo {
    position: relative;
    height: 645px;
    width: 100%;
    clear: both;
    overflow: hidden;
}
.actives{
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
	text-decoration: none;
	border: 1px solid #FF6C04;
	background: rgba(255,108,4, 0.2);	
}
div.leftColumn, div.rightColumn {
    width: 50%;
    height: 100%;
    display: block;
    float: left;
}
#customerInfo fieldset, .acc_banktransfer fieldset {
    padding: 2px 20px;
}
.csLegend {
    font-weight: bold;
    background: #ffffff;
}
#customerInfo table {
    width: 100%;
    margin: 10px;
}
div.leftColumn, div.rightColumn {
    width: 50%;
    height: 100%;
    display: block;
    float: left;
}
.btn_bar1 {
    background: inherit;
    margin: 0 10px;
    padding: 5px 0 5px 0;
    +padding: 6px 0 4px 0;
    text-align: center;
}
container-fluid {
  height: 100%;
  background: lightyellow;
}
.container{
    width: 100% !important;
	max-width: 100% !important;
	background:#dedede;

	}
.form-group {
    margin-bottom: 3px !important;
}	
legend{
	font-weight: bold;
}
label {
    font-weight: unset;
	font-size: 12px;
}
.form-horizontal .control-label{
	text-align: unset !important;
}
.btn1:hover {
    background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
        background-color: rgba(0, 0, 0, 0);
    background: -moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
    background-color: #378de5;
    cursor: pointer;
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

element {

}
.btn1:hover {

   
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
    background-color: #378de5;
    cursor: pointer;

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
  
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
   
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
.btn1 {
    +padding-bottom: 0px;
    +top: -1px;
}
input, button {
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
}
.btn_bar1 {
    text-align: center;
}
.red{
	color:red;
}
.fixed-top {
	position:absolute !important;
	}
	html, body {
	background: #dedede;
}
</style>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body <?php if(isset($_POST['searchkey'])){?>onload="getFocus()"<?php }?>>
 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="customer.php" id="sc8_1" style="margin-left:18px;" class="actives">Account</a>
    <span>|</span>
    <!--<a href="#" id="sc8_1">Online User</a>
    <span>|</span>
    <a href="#" id="sc8_1">VIP</a>
    <span>|</span>-->
    <a href="vip_setting.php" id="sc8_1">VIP Setting</a>
</div>
	<div class="container">
 <center><h2><strong>Edit Account</strong></h2></center>
  <form class="form-horizontal" method="post">
   <div class="container-fluid">
   	<div class="row">
    	<div class="col-sm-6">
        	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: 137px; padding: 4px;">Account Search</legend>
                <div class="form-group">
                  <label class="control-label col-sm-1" style="margin-left: 10px;padding-top: unset;">Status</label>
                  <div class="col-sm-10">
                        <select style="margin-left: 25px;" name="statustype">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                        
                        <input type="text" name="searchtext" value=""/>
                        
                        <select style="margin-left: 25px;" name="Username">
                            <option value="">Username / User Code</option>
                        </select>
                        
                        <input type="button" name="search" value="Search"/>
                  </div>
                </div>
			</fieldset>
            
            <br/>
            <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: 137px; padding: 4px;">Menu</legend>
                <div class="form-group">
                  <label class="control-label col-sm-1" style="margin-left: 10px;padding-top: unset;">Status</label>
                  <div class="col-sm-10">                       
                        <input type="button" class="btn btn-light" name="Account" value="Account"/>
                        <input type="button" class="btn btn-light" name="Transaction" value="Transaction"/>
                        <input type="button" class="btn btn-light" name="New_Transaction" value="New Transaction"/>
                        <input type="button" class="btn btn-light" name="Bonus" value="Bonus"/>
                  </div>
                </div>
			</fieldset>
      	</div>
        <div class="col-sm-6">
      	</div>
    </div>
    <br/>
    
    <div class="row">
      <div class="col-sm-6">
      <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 121px; padding: 4px;">Account Details</legend>
    <div class="form-group">
    <?php
	$id = $_GET['id'];
	$select_sql="SELECT * From account WHERE id='$id'";
	$result=$conn->query($select_sql);
	//print_r($result);
	$row = $result->fetch_assoc();
	
	//print_r($row);
	//echo 'sdfg';
	?>
      <label class="control-label col-sm-2" style="margin-left: 10px;">Username<span class="red">*</span></label>
      <div class="col-sm-7">
        <input type="text" class="form-control" name="username" value="<?php echo $row['username'];?>" style="margin-left: 25px;" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3"style="margin-left: 10px;" >Full Name<span class="red">*</span></label>
      <div class="col-sm-7">          
        <input type="text" class="form-control" name="full_name" value="<?php echo $row['full_name'];?>" style="margin-left: -29px;" required>
      </div>
    </div>
     <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;" >Phone (Main)<span class="red">*</span></label>
      <div class="col-sm-7" style="display:flex;">          
        <input type="number" class="form-control"  value="<?php echo $row['phone'];?>" style="margin-left: -29px;" name="phone" required>
         <input type="button" class="add_field_button" value=" Add" style="padding: 0px 5px 0px 5px; margin-right:-3px;">
      </div>
      <div class="col-sm-7 input_fields_wrap">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;">User Code</label>
      <div class="col-sm-7">
        <input type="text" class="form-control" value="<?php echo $row['user_code'];?>" name="user_code" style="margin-left: -29px;">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 10px;" >Email</label>
      <div class="col-sm-7">          
        <input type="email" class="form-control" value="<?php echo $row['email'];?>" name="email" style="margin-left: 25px;">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;">Date of birth</label>
      <div class="col-sm-7"> 
        <input type="date" class="form-control" value="<?php echo $row['dob'];?>" name="dob" style="margin-left: -29px;">
      </div>
    </div>
     <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 10px;">Currency</label>
      <div class="col-sm-7">
       <select style="margin-left: 25px;" name="currency">
       		<option value="MYR">MYR</option>
       		<option value="TNG">TNG</option>
       </select>
       
      </div>
    </div>
     <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 10px;">VIP</label>
      <div class="col-sm-7">
        <select style="margin-left: 25px;" name="vip">
       		<option>Select</option>
       		<option value="Basic">Basic</option>
       </select>
      </div>
    </div>
     <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 10px;">Status</label>
      <div class="col-sm-">
        <input type="radio"  name="status" value="Active" style="margin-left: 40px;" >
  		<label>Active</label><br>
  		<input type="radio" name="status" value="Suspended " style="margin-left: 40px;">
        <label>Suspended </label><br>
      </div>
    </div>
    </fieldset>
     <br>
    <br>
    <!--<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 137px; padding: 4px;">Account Password</legend>
    <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 10px;">Password</label>
      <div class="col-sm-7">
        <input type="Password" name="password" class="form-control"  value="<?php echo $row['password'];?>" style="margin-left: 25px;">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;"  >Repeat Password</label>
      <div class="col-sm-7">          
        <input type="password" name="repeat_password" value="<?php echo $row['repeat_password'];?> "class="form-control" style="margin-left:-29px;">
      </div>
    </div>
    </fieldset>-->
    <br>
    <br>
    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 48px; padding: 4px;">Other</legend>
    <!--<div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;">Registered IP</label>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3"  style="margin-left: 10px;" >Referrer</label>
    </div>-->
     <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;" >Created On</label>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3"  style="margin-left: 10px;">Total Withdraw 	</label>
      </div>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;" >Total Deposit</label>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;">Total Bonus</label>
    </div>
    <!-- <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;">Mobile Apps</label>
    </div>
     <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 10px;">None</label>
    </div>-->
    </fieldset>
    </div>
      <div class="col-sm-6 ">
      <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 138px; padding: 4px;">Product Username</legend>
   <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 25px; font-weight: bold;"><strong>Products</strong></label>
    
      <label class="control-label col-sm-3" style="margin-left: 25px; font-weight: bold;"><strong>Products ID</strong></label>
      
      <label class="control-label col-sm-2" style="margin-left: 25px; font-weight: bold;"><strong>Turnover</strong></label>
     
      <label class="control-label col-sm-1" style="margin-left: 25px; font-weight: bold;"><strong>Last Transaction</strong></label>
    </div>
     <?php 
	$sqlproductname = "SELECT name from product_info";
	$productname = mysqli_query($conn,$sqlproductname);
	if(mysqli_num_rows($productname)>0)
	{		
		while($row = mysqli_fetch_assoc($productname))
		{
	?>
    	<div class="form-group">
          <label class="control-label col-sm-2" style="margin-left: 25px;"><?php echo $row['name'];?></label>
          <div class="col-sm-3">
            <input type="text" class="form-control" name="<?php echo $row['name'];?>" style="margin-left: 25px;">
          </div>
        </div>
    <?php 
		}
	}else
	{
		echo "No products";
	}	
	?>
    </fieldset>
    <br>
    <br>
    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 107px; padding: 4px;">Bank Account</legend>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 25px;">Add Bank Account</label>
      <div class="col-sm-7" style="margin-left: -34px;">
       <select class="hwe_bank" name="bank_account">
            <option label="MAYBANK" value="MAYBANK">MAYBANK</option>
            <option label="BSN BANK" value="BSN BANK">BSN BANK</option>
            <option label="RHB BANK" value="RHB BANK">RHB BANK</option>
            <option label="PUBLIC BANK" value="PUBLIC BANK">PUBLIC BANK</option>
            <option label="CIMB BANK" value="CIMB BANK">CIMB BANK</option>
            <option label="HLB BANK" value="HLB BANK">HLB BANK</option>
            <option label="BANK ISLAM" value="BANK ISLAM">BANK ISLAM</option>
            <option label="UOB BANK" value="UOB BANK">UOB BANK</option>
            <option label="OCBC BANK" value="OCBC BANK">OCBC BANK</option>
            <option label="AMBANK" value="AMBANK">AMBANK</option>
            <option label="AFFIN BANK" value="AFFIN BANK">AFFIN BANK</option>
            <option label="BANK RAKYAT" value="BANK RAKYAT">BANK RAKYAT</option>
            <option label="ALLIANCE BANK" value="ALLIANCE BANK">ALLIANCE BANK</option>
            <option label="MUAMALAT BANK" value="MUAMALAT BANK">MUAMALAT BANK</option>
            <option label="AGRO BANK" value="AGRO BANK">AGRO BANK</option>
            <option label="E-WALLET T&amp;G" value="E-WALLET T&amp;G">E-WALLET T&amp;G</option>
            <option label="PARKING" value="PARKING">PARKING</option>
            <option label="HSBC BANK" value="HSBC BANK">HSBC BANK</option>
		</select>
        <input type="button" class="hwe_add_bank" value="add" style="padding: 0px 5px 0px 5px;">
      </div>
    </div>
     <div class="form-group input_fields_bank">
    
    </div>
    </fieldset>
    <br>
    <br>
    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 54px; padding: 4px;">Upline</legend>
    <div class="form-group">
      <label class="control-label col-sm-3" style="margin-left: 25px;">Admin User</label>
      <div class="col-sm-7">
        <select name="admin_user">
            <option label="-" value="0">-</option>
            <option label="egadmin" value="egadmin">egadmin</option>
            <option label="admin" value="admin">admin</option>
            <option label="hung777" value="hung777">hung777</option>
            <option label="anny" value="anny">anny</option>
            <option label="mandy996" value="mandy996">mandy996</option>
            <option label="eason" value="eason">eason</option>
            <option label="demo123" value="demo123">demo123</option>
            <option label="ahy996" value="ahy996">ahy996</option>
		</select>
      </div>
    </div>
    </fieldset>
    <br>
    <br>
    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  <legend style="background:#fff; width: 63px; padding: 4px;">Remark</legend>
    <div class="form-group">
      <label class="control-label col-sm-2" style="margin-left: 25px;">Remark</label>
      <div class="col-sm-7">
        <textarea rows="4" cols="50" value="<?php echo $row['remark'];?>"  name="remark"></textarea>
      </div>
    </div>

    </fieldset>
      </div>
    </div>  
  </div>
   <div class="btn_bar1" style="bottom:0px;">
        <input class="btn1" type="submit" name="sbtt" value="Update">&nbsp;
        <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back"  onclick="history.go(-1);">
	</div>
  
</div>
  </form>

 </body>
 </html>
<?php

if(isset($_POST['sbtt'])){
	$name = $_POST['sname'];
	$promotion_code = $_POST['scode'];
	$transaction_from = $_POST['sdatefrom'];
	$to = $_POST['sdateto'];
	$status = $_POST['istatus'];
	
	$update="UPDATE account set name='$name',promotion_code='$promotion_code',transaction_from='$transaction_from',`to`='$to',status='$status' WHERE id='$id'";
	$result=$conn->query($update);
	echo "<script>
	alert('updated successfully ');
	window.location.href='https://readyforyourreview.com/BackendCRMsystem/show_promotion_list.php';
	</script>";
	}


?>