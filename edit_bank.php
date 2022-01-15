<?php
include('header.php');

if($_SESSION['user_type']!="superadmin"){
   echo "<script>window.location.assign('home.php');</script>";

 }
 if(isset($_GET['id_edit_bank'])){
    $bank_id=$_GET['id_edit_bank'];
 }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

    <style>
html, body {
	background: #dedede;
}
    </style>

</head>
<body class="pb-5">

 <div class="container-fluid pt-5 pb-5 mt-5">

 <div class="row mt-5">
 <div class="col-md-3"></div>
 <div class="col-md-6">
 <h3>Edit Bank</h3>
 <form method="post" action="dataprocess.php" enctype="multipart/form-data">
 <?php

$getdata="SELECT * FROM bank WHERE id='$bank_id'";

$result=$conn->query($getdata);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $bank_id=$row['id'];
    $name=$row['name'];
    $short_name=$row['short_name'];
    $status=$row['status'];

?>

<input type="text" name="id_bank" value="<?php echo $bank_id;?>" style="display:none;">

<!--1-->
 <div class="form-group">
    <label for="name" class="label">Bank Name </label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Bank Name"  value="<?php echo $name;?>">
 </div>
<!--2-->
 <div class="form-group">
    <label for="short_name" class="label">Bank Short Name </label>
    <input type="text" name="short_name" id="short_name" class="form-control" placeholder="Bank Short Name"  value="<?php echo $short_name;?>" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
 </div>
<!--3-->
<div class="form-group">
    <label for="status" class="label">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="active"<?php if($status=="active"){echo 'selected="selected"';}?>>ACTIVE</option>  
        <option value="suspended"<?php if($status=="suspended"){echo 'selected="selected"';}?>>SUSPENDED</option>
            
    </select>
</div>

<?php }}?>

    <input type="submit" name="edit_bank" value="Edit" class="btn btn-block btn-info mt-2 text-white">
    <input type="button" name="back" value="back" class="btn btn-block btn-warning mt-2 text-white" onclick="window.location.assign('bank.php')">

 </form>
 </div>
 </div>
 
</body>
</html>