<?php
include('header.php');

if($_SESSION['user_type']!="superadmin"){
   echo "<script>window.location.assign('home.php');</script>";

 }
 if(isset($_GET['id'])){
    $product_id=$_GET['id'];
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
h2 strong {
	font-size: 16px;
}

legend {
	font-size: 14px;
}
    </style>

</head>
<body class="pb-5">

 <div class="container-fluid pt-5 pb-5 mt-5">

 <div class="row mt-5">
 <div class="col-md-3"></div>
 <div class="col-md-6">
 <h3>Edit Product</h3>
 <form method="post" action="dataprocess.php" enctype="multipart/form-data">
 <?php

$getdata="SELECT * FROM product_info WHERE id='$product_id'";

$result=$conn->query($getdata);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $bank_id=$row['id'];
    $name=$row['name'];
    $type=$row['type_product'];
    $status=$row['status'];
    $remark=$row['remark'];

?>

<input type="text" name="id_product" value="<?php echo $product_id;?>" style="display:none;">

<!--1-->
 <div class="form-group">
    <label for="name" class="label">Product Name </label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Bank Name"  value="<?php echo $name;?>">
 </div>
<!--2-->
<div class="form-group">
    <label for="type_product" class="label">Type</label>
    <select name="type_product" id="type_product" class="form-control">
        <option value="4D" <?php if($type=="4D"){echo 'selected="selected"';}?>>4D</option>  
        <option value="Sportbook" <?php if($type=="Sportbook"){echo 'selected="selected"';}?>>Sportbook</option>
        <option value="Casino" <?php if($type=="Casino"){echo 'selected="selected"';}?>>Casino</option>
            
    </select>
</div>
<!--3-->
<div class="form-group">
    <label for="status" class="label">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="active"<?php if($status=="active"){echo 'selected="selected"';}?>>ACTIVE</option>  
        <option value="suspended"<?php if($status=="suspended"){echo 'selected="selected"';}?>>SUSPENDED</option>
            
    </select>
</div>
<!--4-->
 <div class="form-group">
    <label for="remark" class="label">Remark</label>
    <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"><?php echo $remark;?></textarea>
 </div>

<?php }}?>

    <input type="submit" name="edit_product" value="Edit" class="btn btn-block btn-info mt-2 text-white">

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