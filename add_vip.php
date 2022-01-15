<?php
session_start();

$_SESSION['page']='customer';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$success = '';
if(isset($_POST['sbtt']))
{
	$name = $_POST['name'];
	$description = $_POST['description'];
	$total_deposit = $_POST['total_deposit'];
	$status = $_POST['status'];	
	
	$edit_id_vip = $_POST['edit_id_vip'];
	if(!empty($edit_id_vip))
	{
		$update_sql = "UPDATE  vip_setting SET `name`='$name', `description`='$description',`totaldeposit`=$total_deposit,`status`='$status' where id =$edit_id_vip";
		if(mysqli_query($conn,$update_sql)==TRUE)
		{
			$success = 'VIP Updated Successfully.';
		}
		
	}
	else
	{
	
		$insert_sql = "INSERT INTO vip_setting SET `name`='$name', `description`='$description',`totaldeposit`=$total_deposit,`status`='$status'";
		
		if(mysqli_query($conn,$insert_sql)==TRUE)
		{
			$success = 'VIP Added Successfully.';
		}
	}
}


$name = $description=$totaldeposit=$status = '';
$edit_id = '';
if(isset($_GET['edit_id']))
{
	$edit_id = $_GET['edit_id'];
	
	$get_bank_detail = mysqli_query($conn,"SELECT * from vip_setting where id = $edit_id ");
	if(mysqli_num_rows($get_bank_detail)>0)
	{
		$rows = mysqli_fetch_assoc($get_bank_detail);
		
		$name =$rows['name'];
		$description=$rows['description'];
		$totaldeposit=$rows['totaldeposit'];
		$status = $rows['status'];
	}
		
}

?>

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
<!DOCTYPE html>
<html lang="en">
<head>
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
<body background="#cccccc">
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="customer.php" id="sc8_1" style="margin-left:18px;">Account</a>
    <span>|</span>
   <!-- <a href="#" id="sc8_1">Online User</a>
    <span>|</span>
    <a href="#" id="sc8_1">VIP</a>
    <span>|</span>-->
    <a href="vip_setting.php" id="sc8_1"  class="actives">VIP Setting</a>
</div>
<div class="container">
	<center><h2><strong>VIP LevelInsert</strong></h2></center>
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
  		<form class="form-horizontal" method="post">
        <input type="hidden" name="edit_id_vip" value="<? echo $edit_id;?>"/>
   			<div class="container-fluid">
    			<div class="row">
      				<div class="col-sm-12">
      					<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
  							<legend style="background:#fff; width: 121px; padding: 4px;">VIP LevelInsert</legend>
                                <div class="form-group">
                                  <label class="control-label col-sm-3" style="margin-left: 10px;"><span class="red">*</span>Name</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control" name="name" value="<? echo $name;?>" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-3"style="margin-left: 10px;" ><span class="red">*</span>Description</label>
                                  <div class="col-sm-7">          
                                    <input type="text" class="form-control" name="description"  value="<? echo $description;?>" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" style="margin-left: 10px;" ><span class="red">*</span>Total Deposit</label>
                                    <div class="col-sm-7" style="display:flex;">          
                                    <input type="text" class="form-control"  name="total_deposit"  value="<? echo $totaldeposit;?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-3" style="margin-left: 10px;"><span class="red">*</span>Status</label>
                                  <div class="col-sm-7">
                                    <input type="radio" name="status" value="Active" <?php if($status=='Active'){echo 'checked';}?> required/> Active
                                    &nbsp;&nbsp;
                                    <input type="radio" name="status" value="Suspended" <?php if($status=='Suspended'){echo 'checked';}?> required/> Suspended
                                  </div>
                                </div>
    						</fieldset>
						</div>
                       
					</div>  
				</div> 
                <br/>
               
                <div style="margin-left:1%;"><p>( <span class="red">*</span> ) Mandatory field</p></div>
                
				<div class="btn_bar1" style="bottom:0px;">
					<input class="btn1" type="submit" name="sbtt" value="Submit">&nbsp;
					<input id="backLink1" class="btn1" type="button" name="sbtt" value="Back">
				</div>
			</div>  
		</form>
<script>
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div style="display:flex;"><input type="text" name="mytext[]" class="form-control" id="pwd" name="pwd" style="margin-left: -29px; margin-top: 4px;"/><a href="#" class="remove_field"><i class="fa fa-remove blue-color "  style="color: red; font-size: 20px;"></i> </a></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
	
	
});
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_bank"); //Fields wrapper
	var add_button      = $(".hwe_add_bank"); //Add button ID
	var x = 1; 
	 
	
	$(add_button).click(function(e){ //on add input button click
	var selectedCountry = $(".hwe_bank option:selected").val(); 
	e.preventDefault();
	if(x < max_fields){ //max input box allowed
		x++; //text box increment
		$(wrapper).append('<div class="form-group"><label class="control-label col-sm-2" style="margin-left: 40px;">'+selectedCountry+'</label><div class="col-sm-8" style="display:flex; margin-left: 23px;"><input type="radio" name="bank_radio"><input type="text" class="form-control" style="margin-left: 10px;" name="account_no" placeholder="Bank Account No"> <input type="text" class="form-control" placeholder="Remark" style="margin-left: 5px;"><a href="#" class="remove_field_bank"><i class="fa fa-remove blue-color" style="color: red; font-size: 20px;"></i></a></div></div>'); 
		}
	});
	$(wrapper).on("click",".remove_field_bank", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
	})
});
</script>
</body>
</html>