<?php
include('header.php');

if($_SESSION['user_type']!="superadmin"){
   echo "<script>window.location.assign('home.php');</script>";

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
 <h3>Create User</h3>
 <form method="post" action="dataprocess.php" enctype="multipart/form-data">
<!--1-->
 <div class="form-group">
    <label for="name" class="label">Name </label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
 </div>
<!--2-->
<div class="form-group">
    <label for="phone_no" class="label">Phone Number</label>
    <input name="phone_no" id="phone_no" type="text" class="form-control" pattern="[0-9]{10}||[0-9]{11}" placeholder="Phone Number" required>
 </div>
 
<!--3-->
 <div class="form-group">
    <label for="mail" class="label">Mail</label>
    <input name="email" id="email" type="email"  class="form-control"  placeholder="Email">
 </div>
<!--4-->
<div class="form-group">
    <label for="type_user" class="label">Type User </label>
    <select name="type_user" id="type_user" class="form-control">
        <option value="superadmin">Super Admin</option>  
        <option value="admin">Admin</option>
            
    </select>
</div>
<!--5-->
<div class="form-group">
    <label for="user_id" class="label">User ID </label>
    <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User ID" required>
 </div>
 <!--6-->
<div class="form-group">
    <label for="password" class="label">Password  </label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="customCheck" onclick="show()">
      <label class="custom-control-label text-dark" for="customCheck">Show Password</label>

   </div>
   <input type='button' class="btn btn-info btn-sm" value ='generate' onclick='document.getElementById("password").value = Password.generate(8)'>

    
 </div>
 <!--7-->
<div class="form-group">
    <label for="status" class="label">Status </label>
    <select name="status" id="status" class="form-control">
        <option value="active">ACTIVE</option>  
        <option value="suspended">SUSPENDED</option>
            
    </select>
</div>
<!--8-->
 <div class="form-group">
    <label for="remark" class="label">Remark</label>
    <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"></textarea>
 </div>


    <input type="submit" name="create_user" value="Create" class="btn btn-block btn-info mt-2 text-white">

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