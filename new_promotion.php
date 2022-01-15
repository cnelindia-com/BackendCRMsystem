<?php
session_start();

$_SESSION['page']='promotion';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}


if(isset($_POST['sbtt'])){
	$name = $_POST['sname'];
	$ptomotion_code = $_POST['scode'];
	$transaction_from = $_POST['sdatefrom'];
	$to = $_POST['sdateto'];
	$status = $_POST['istatus'];
	$sequence = 1;
	$sql = "INSERT INTO promotion (name, promotion_code, transaction_from, `transaction_to`, status, sequence)
VALUES ('$name', '$ptomotion_code', '$transaction_from', '$to', '$status', '$sequence')";
    $result=$conn->query($sql);
	
	echo "<script>
	alert('Promotion create successfully');
	window.location.href='show_promotion_list.php';
	</script>";
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
body{
	background: #e6e6e6;
	}	
.tabcontent{
	font-size: 27px;
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
.actives{
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
	text-decoration: none;
	border: 1px solid #FF6C04;
	background: rgba(255,108,4, 0.2);	
}
#popmenu {
    font-size: 14px;
    color: #000;
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, SimSun, sans-serif;
    font-family: "微软雅黑", Arial, Tahoma, Helvetica, Hiragino Sans GB, WenQuanYi Micro Hei, Verdana, Aril, sans-serif;
    background: #DEDEDE;
    margin: 0 0 50px;
    margin-bottom: 50px;
}
.horline_wt {
    border-top: 1px solid #fff;
}
.title1 {
    text-align: center;
    margin: 18px auto 19px;
}
.title1 h2 {
    font-size: 16px;
    font-family: "微软雅黑", Tahoma, Arial, Helvetica, sans-serif;
}
.content_table2 {
    width: 50%;
}
.outerformborder1 {
    border: 1px solid #808080;
    margin: 0 10px 20px;
}
.innerformborder1 {
    border: 1px solid #fff;
}
td {
    font-family: "微软雅黑", Arial, Helvetica, sans-serif;
    font-size: 14px;
    cursor: default;
    white-space: nowrap;
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
.formtable1 th, .formtable1 td {
    height: 25px;
    white-space: nowrap;
    text-align: left;
}
.asterisk {
    font-size: 14px;
    color: #e60000;
}
.width10 {
    width: 10px;
}
.horline_wt.popmenu {
    background: #dedede;
    width: 102%;
    margin-left: -12px;
}
.btn1:hover {
    background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
        background-color: rgba(0, 0, 0, 0);
    background: -moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
    background-color: #378de5;
    cursor: pointer;
}
.btn_bar1 {
    background: inherit;
    margin: 0 10px;
    padding: 5px 0 5px 0;
    +padding: 6px 0 4px 0;
    text-align: center;
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

html, body {
	background: #dedede;
}
</style>

</head>
<body <?php if(isset($_POST['searchkey'])){?>onload="getFocus()"<?php }?>>



 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="show_promotion_list.php" id="sc8_1" >Promotion</a>															
</div>

<div class="horline_wt popmenu">
<div class="title1"><h2>New Promotion</h2></div>
<form name="spbform" id="spbform" method="POST" >
	<div>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody><tr valign="top">
				<td class="content_table2">
					<div class="outerformborder1">
						<div class="innerformborder1">
							<div class="subtitle1"><b>New Promotion</b></div>
							<div class="form_sp1">
								<table class="formtable1" cellspacing="0" cellpadding="0" border="0">
									<tbody><tr>
										<td class="asterisk width10">*</td>
										<th>Name</th>
										<td><input type="text" name="sname" maxlength="255" value="" class="textbox1 width250"></td>
									</tr>
									<tr>
										<td class="asterisk width10">*</td>
										<th>Promotion Code</th>
										<td>
											<input type="text" name="scode" maxlength="45" value="" class="textbox1 width250">
										</td>
									</tr>
									<tr>
										<td class="asterisk width10"></td>
										<th>Expiry Date</th>
										<td>
											Transaction From&nbsp;
											<input type="date" id="transferdatefrom" name="sdatefrom" class="textbox1 hasDatepicker" size="10">
											&nbsp;&nbsp;To&nbsp;&nbsp;
											<input type="date" id="transferdateto" name="sdateto" class="textbox1 hasDatepicker" size="10">
										</td>
									</tr>
									
									<tr>
										<td class="asterisk width10">*</td>
										<th>Status</th>
										<td>
                                        <label><input type="radio" name="istatus" value="Active">Active</label>&nbsp;
										<label><input type="radio" name="istatus" value="Suspended">Suspended</label>&nbsp;
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
	</div>
	<div class="btn_bar1">
		<input class="btn1" type="submit" name="sbtt" value="Submit">&nbsp;
		<input class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
	</div>
	<input type="hidden" name="mdl" value="promotion"><input type="hidden" name="action" value="doadd">
</form>
</div>


<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
  </div>
 </div>
 </body>
 </html>
