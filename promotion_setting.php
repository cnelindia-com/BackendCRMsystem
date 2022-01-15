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
html, body {
	background: #dedede;
}
    </style>

</head>
<body <?php if(isset($_POST['searchkey'])){?>onload="getFocus()"<?php }?>>

 <div class="container-fluid pt-5 pb-5 mt-5">

 
<div id="sc8" class="tabcontent" style="display: block; margin-top: 2%;">
	<a href="show_promotion_list.php" id="sc8_1" >Promotion</a><span style="color:#ff6c04;">|</span>									
	<a href="promotion_setting.php" class="actives" id="sc8_2" onclick="doChangeStyle(this);">Promotion Setting</a>						
</div>
 
  </div>
 
 </body>
 </html>