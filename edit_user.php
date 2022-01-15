<?php
include('header.php');

 if(isset($_GET['id'])){
    $user_id=$_GET['id'];

    if($user_id==$_SESSION['user']){$user_check="yes";}
    else{$user_check="no";}

}else{
    echo "<script>window.location.assign('user.php');</script>";
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
 <h3>Edit User</h3>
 <form method="post" action="dataprocess.php" enctype="multipart/form-data">

 <?php

$getdata="SELECT * FROM user_info WHERE user_id='$user_id'";
$i=0;

$result=$conn->query($getdata);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $user_id=$row['user_id'];
      $name=$row['name'];
      $type_user=$row['type'];
      $phone_no=$row['phone_no'];
      $email=$row['email'];
      $password=$row['password'];
      $status=$row['status'];
      $remark=$row['remark'];

?>
<input type="text" name="id_user" value="<?php echo $user_id;?>" style="display:none;">

<!--1-->
 <div class="form-group">
    <label for="name" class="label">Name </label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="<?php echo $name;?>">
 </div>
<!--2-->
<div class="form-group">
    <label for="phone_no" class="label">Phone Number</label>
    <input name="phone_no" id="phone_no" type="text" class="form-control" pattern="[0-9]{10}||[0-9]{11}" placeholder="Phone Number" value="<?php echo $phone_no;?>">
 </div>
 
<!--3-->
 <div class="form-group">
    <label for="email" class="label">Mail</label>
    <input name="email" id="email" type="email"  class="form-control"  placeholder="Email" value="<?php echo $email;?>">
 </div>
<!--4-->
<?php if($user_check=="no"){?>
<div class="form-group">
    <label for="type_user" class="label">Type User </label>
    <select name="type_user" id="type_user" class="form-control">
        <option value="superadmin"<?php if($type_user=="agent"){echo 'selected="selected"';}?>>Super Admin</option>  
        <option value="admin"<?php if($type_user=="admin"){echo 'selected="selected"';}?>>Admin</option>
            
    </select>
</div>
<?php }else if($user_check="yes"){?>
  <div class="form-group">
    <label for="type_user" class="label">Type User</label>
    <input type="text" name="type_user" id="type_user" class="form-control" placeholder="Type User" value="<?php echo $type_user;?>" readonly>
 </div>
<?php }?>
<!--5-->
<div class="form-group">
    <label for="user_id" class="label">User ID </label>
    <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User ID" value="<?php echo $user_id;?>" readonly>
 </div>
 <!--6-->
<div class="form-group">
    <label for="password" class="label">Password  </label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?php echo $password;?>">

    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="customCheck" onclick="show()">
      <label class="custom-control-label text-dark" for="customCheck">Show Password</label>

   </div>
   <input type='button' class="btn btn-info btn-sm" value ='generate' onclick='document.getElementById("password").value = Password.generate(8)'>

    
 </div>
 <!--7-->
 <?php if($user_check=="no"){?>
<div class="form-group">
    <label for="status" class="label">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="active"<?php if($status=="active"){echo 'selected="selected"';}?>>ACTIVE</option>  
        <option value="suspended"<?php if($status=="suspended"){echo 'selected="selected"';}?>>SUSPENDED</option>
            
    </select>
</div>
<?php }else if($user_check="yes"){?>
  <div class="form-group">
    <label for="status" class="label">Status</label>
    <input type="text" name="status" id="status" class="form-control" placeholder="Status" value="<?php echo $status;?>" readonly>
 </div>
<?php }?>
<!--8-->
 <div class="form-group">
    <label for="remark" class="label">Remark</label>
    <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"><?php echo $remark;?></textarea>
 </div>

<?php }}?>

    <input type="submit" name="edit_user" value="Edit" class="btn btn-block btn-info mt-2 text-white">

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