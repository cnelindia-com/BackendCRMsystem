<?php
session_start();

$_SESSION['page']='promotion';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}


if(!isset($_GET['id'])){
	die("Invalid URL");
}

$id = $_GET['id'];

if(isset($_POST['sbtt'])){
	
	$name = trim($_POST['sname']);
	$promotion_code = $_POST['scode'];
	$transaction_from = $_POST['sdatefrom'];
	$transaction_to = $_POST['sdateto'];
	$istatus = $_POST['istatus'];

	$update = "UPDATE promotion set name = '$name', promotion_code = '$promotion_code', transaction_from = '$transaction_from', `transaction_to`='$transaction_to', status='$istatus' WHERE id='$id'";
	
	$result=$conn->query($update);
	echo "<script>
	alert('Updated successfully ');
	window.location.href='show_promotion_list.php';
	</script>";
}


$select_sql="SELECT * From promotion WHERE id='$id'";
$result=$conn->query($select_sql);
$row = $result->fetch_assoc();




?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

      <!--<script>

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
	/*background:#fff;*/
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
	
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
html, body {
	background: #dedede;
}
h2 strong {
	font-size: 16px;
}

legend {
	font-size: 14px;
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
	<a href="show_promotion_list.php" id="sc8_1" class="actives">Promotion</a>
</div>

<div class="container" >
	<center><h2><strong>Edit Promotion</strong></h2></center>
  
    <!--	<h2>Promotion</h2>-->
    <form name="spbform" id="spbform" method="POST" >
    
		<div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                        <legend style="background:#fff; width: auto; padding: 4px;font-size: 16px;">Edit Promotion</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Name</label>
                            <div class="col-sm-9">
                            	<input type="text" name="sname" maxlength="255" value="<?php echo $row['name']; ?>" class="textbox1 width250">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Promotion Code</label>
                            <div class="col-sm-9">
                            	<input type="text" name="scode" maxlength="45" value="<?php echo $row['promotion_code']; ?>" class="textbox1 width250">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Expiry Date</label>
                            <div class="col-sm-9">
                            	Transaction From&nbsp;
											<input type="date" id="transferdatefrom" name="sdatefrom" class="textbox1 hasDatepicker" size="10" value="<?php echo $row['transaction_from']; ?>">
											&nbsp;&nbsp;To&nbsp;&nbsp;
											<input type="date" id="transferdateto" name="sdateto" class="textbox1 hasDatepicker" size="10" value="<?php echo $row['transaction_to']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Status</label>
                            <div class="col-sm-9">


                            	<input type="radio" name="istatus" value="Active" <?php if($row['status'] == 'Active'){ echo 'checked="checked"';} ?> />Active &nbsp;&nbsp;
                                <input type="radio" name="istatus" value="Suspended" <?php if($row['status'] == 'Suspended'){ echo 'checked="checked"'; }?> /> Suspended
                            </div>
                        </div>
                    
                    </fieldset>                   
                </div>
              
            </div>
          </div>
          <div style="margin-left:1%;"><p>( <span class="red">*</span> ) Mandatory field</p></div>
          <div class="notice1" style="margin-left:1%;">
						Notice:
						<ol style="list-style-type:decimal; padding-left: 40px;">
							<li><b>Promotion Code</b> cannot be modified once it is set.</li>
							<li>
								<b>Behavior</b>
								<ul style="list-style-type:circle; padding-left: 20px;">
									<li>Display and Select : Display banner in promotion page and allow user to select in deposit page.</li>
									<li>Display Only : Only display banner in promotion page.</li>
									<li>Select Only : Only allow user to select in deposit page.</li>
								</ul>
							</li>
						</ol>
					</div>
		<div class="btn_bar1" style="bottom:0px;text-align:center;">
            <input class="btn1" type="submit" name="sbtt" value="Update">&nbsp;
            <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
        </div>




	<!--<div>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody><tr valign="top">
				<td class="content_table2">
					<div class="outerformborder1">
						<div class="innerformborder1">
							<div class="subtitle1"><b>New Promotion</b></div>
							<div class="form_sp1">
								<table class="formtable1" cellspacing="0" cellpadding="0" border="0">
									<tbody>
                                    <?php
									$id = $_GET['id'];
									$select_sql="SELECT * From promotion WHERE id='$id'";
									$result=$conn->query($select_sql);
									$row = $result->fetch_assoc();
																	
									?>
                                    <tr>
										<td class="asterisk width10">*</td>
										<th>Name</th>
										<td><input type="text" name="sname" maxlength="255" value=" <?php echo $row['name']; ?>" class="textbox1 width250"></td>
									</tr>
									<tr>
										<td class="asterisk width10">*</td>
										<th>Promotion Code</th>
										<td>
											<input type="text" name="scode" maxlength="45" value="<?php echo $row['promotion_code']; ?>" class="textbox1 width250">
										</td>
									</tr>
									<tr>
										<td class="asterisk width10"></td>
										<th>Expiry Date</th>
										<td>
											Transaction From&nbsp;
											<input type="date" id="transferdatefrom" name="sdatefrom" class="textbox1 hasDatepicker" size="10" value="<?php echo $row['transaction_from']; ?>">
											&nbsp;&nbsp;To&nbsp;&nbsp;
											<input type="date" id="transferdateto" name="sdateto" class="textbox1 hasDatepicker" size="10" value="<?php echo $row['to']; ?>">
										</td>
									</tr>
									
									<tr>
										<td class="asterisk width10">*</td>
										<th>Status</th>
										<td>
                                        <?php
										if( $row['status'] == 'Active' ){
										?>
                                        <label><input type="radio" name="istatus" value="Active" checked>Active</label>&nbsp;
                                        <?php
										}else{ ?> <label><input type="radio" name="istatus" value="Active">Active</label>&nbsp; <?php }
										if( $row['status'] == 'Suspended' ){
										?>
                                        <label><input type="radio" name="istatus" value="Suspended" checked>Suspended</label>&nbsp;
                                        <?php
                                      	  }else{ ?><label><input type="radio" name="istatus" value="Suspended"> Suspended</label>&nbsp; <?php } ?>
										
										
                                        </td>
									</tr>
								</tbody>
                             </table>
						</div>
					</div>
				</div>
					<div class="notice1">( <span class="asterisk">*</span> ) Mandatory field</div>
					<br>
					<div class="notice1">
						Notice:
						<ol style="list-style-type:decimal; padding-left: 40px;">
							<li><b>Promotion Code</b> cannot be modified once it is set.</li>
							<li>
								<b>Behavior</b>
								<ul style="list-style-type:circle; padding-left: 20px;">
									<li>Display and Select : Display banner in promotion page and allow user to select in deposit page.</li>
									<li>Display Only : Only display banner in promotion page.</li>
									<li>Select Only : Only allow user to select in deposit page.</li>
								</ul>
							</li>
						</ol>
					</div>
									</td>
			</tr>
		</tbody></table>
	</div>-->
	<!--<div class="btn_bar1">
		<input class="btn1" type="submit" name="sbtt" value="Update">&nbsp;
		<input class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
	</div>-->
	<input type="hidden" name="mdl" value="promotion"><input type="hidden" name="action" value="doadd">
</form>
</div>
</div>
<!--
<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
  </div>-->
 
 </body>
 </html>
