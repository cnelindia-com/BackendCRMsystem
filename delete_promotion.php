<?php
session_start();

$_SESSION['page']='promotion';

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

html, body {
	background: #dedede;
}
</style>

</head>
<body <?php if(isset($_POST['searchkey'])){?>onload="getFocus()"<?php }?>>
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="show_promotion_list.php" id="sc8_1" >Promotion</a><span style="color:#ff6c04;">|</span>									
	<a href="promotion_setting.php" class="actives" id="sc8_2" onclick="doChangeStyle(this);">Promotion Setting</a>						
</div>

<div class="horline_wt popmenu">
<div class="title1"><h2>New Promotion</h2></div>
<form name="spbform" id="spbform" method="POST" >
<?php
	$id = $_GET['id'];
	$delete="DELETE FROM promotion where id='".$id."'";
	$result=$conn->query($delete);
	$result=$conn->query($select_sql);
	echo "<script>
	window.location.href='show_promotion_list.php';
	</script>";
	

?>
</form>



<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
  </div>
 </div>
 </body>
 </html>
