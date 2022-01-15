<?php
include('header.php');

if($_SESSION['user_type']!="superadmin"){
   echo "<script>window.location.assign('home.php');</script>";

 }
 if(isset($_GET['id'])){
    $bank_id=$_GET['id'];
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

$getdata="SELECT * FROM bank_info WHERE id='$bank_id'";

$result=$conn->query($getdata);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $bank_id=$row['id'];
    $bank=$row['bank'];
    $short_code=$row['short_code'];
    $account_no=$row['account_no'];
    $account_name=$row['account_name'];
    $status=$row['status'];
    $remark=$row['remark'];

?>

<input type="text" name="id_bank" value="<?php echo $bank_id;?>" style="display:none;">

<!--1-->
 <div class="form-group">
    <label for="bank" class="label">Bank </label>
    <select name="bank" id="status" class="form-control">
      <?php 
        $sql="SELECT * From bank";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $bank_name=$row['name'];
            $bank_short_name=$row['short_name'];
      ?>
        <option value="<?php echo $bank_name;?>" <?php if($bank_name==$bank){echo 'selected="selected"';}?>><?php echo $bank_name." (".$bank_short_name.")";?></option>  
      <?php }}?>
    </select> </div>
<!--2-->
 <div class="form-group">
    <label for="short_code" class="label">Bank Short Code </label>
    <input type="text" name="short_code" id="short_code" class="form-control" placeholder="Bank Short Code"  value="<?php echo $short_code;?>" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
 </div>
<!--3-->
<div class="form-account_name">
    <label for="short_name" class="label">Account Name </label>
    <input type="text" name="account_name" id="account_name" class="form-control" placeholder="Account Name" value="<?php echo $account_name;?>">
 </div>
<!--4-->
<div class="form-group">
    <label for="account_no" class="label">Account Number</label>
    <input name="account_no" id="account_no" type="text" class="form-control" placeholder="Account Number"  value="<?php echo $account_no;?>">
 </div>
<!--5-->
<div class="form-group">
    <label for="status" class="label">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="active"<?php if($status=="active"){echo 'selected="selected"';}?>>ACTIVE</option>  
        <option value="suspended"<?php if($status=="suspended"){echo 'selected="selected"';}?>>SUSPENDED</option>
            
    </select>
</div>
<!--5-->
 <div class="form-group">
    <label for="remark" class="label">Remark</label>
    <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"><?php echo $remark;?></textarea>
 </div>

<?php }}?>

    <input type="submit" name="edit_bank_account" value="Edit" class="btn btn-block btn-info mt-2 text-white">
    <input type="button" name="back" value="back" class="btn btn-block btn-warning mt-2 text-white" onclick="window.location.assign('bank_Account.php')">


 </form>
 </div>
 </div>
 
</body>
</html>

<script>
    function show() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
};

var Password = {
 
 _pattern : /[a-zA-Z0-9_\-\+\.]/,
 
 
 _getRandomByte : function()
 {
   // http://caniuse.com/#feat=getrandomvalues
   if(window.crypto && window.crypto.getRandomValues) 
   {
     var result = new Uint8Array(1);
     window.crypto.getRandomValues(result);
     return result[0];
   }
   else if(window.msCrypto && window.msCrypto.getRandomValues) 
   {
     var result = new Uint8Array(1);
     window.msCrypto.getRandomValues(result);
     return result[0];
   }
   else
   {
     return Math.floor(Math.random() * 256);
   }
 },
 
 generate : function(length)
 {
   return Array.apply(null, {'length': length})
     .map(function()
     {
       var result;
       while(true) 
       {
         result = String.fromCharCode(this._getRandomByte());
         if(this._pattern.test(result))
         {
           return result;
         }
       }        
     }, this)
     .join('');
 }    

};
</script>