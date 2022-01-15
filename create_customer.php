<?php
include('header.php');

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
 <h3>Create Customer</h3>
 <form method="post" action="dataprocess.php" enctype="multipart/form-data">
<!--1-->
 <div class="form-group">
    <label for="user_id" class="label">User ID </label>
    <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User ID" required oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
 </div>
<!--2-->
<div class="form-group">
    <label for="name" class="label">Name</label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
 </div> 
<!--3-->
<div class="form-group">
    <label for="phone_no" class="label">Phone Number</label>
    <input name="phone_no" id="phone_no" type="text" class="form-control" pattern="[0-9]{10}||[0-9]{11}" placeholder="Phone Number" required>
 </div>
 
<!--4-->
 <div class="form-group">
    <label for="mail" class="label">Mail</label>
    <input name="email" id="email" type="email"  class="form-control"  placeholder="Email">
 </div>
<!--5-->
 <div class="form-group">
    <label for="remark" class="label">Remark</label>
    <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"></textarea>
 </div>

 <!--product ID-->
 <h5 class="mb-2 mt-5">Product ID</h5>
 <?php
 $get_product_id="select id,name from product_info";
 $result=$conn->query($get_product_id);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){      
        $product_id=$row['id'];
        $product_name=$row['name'];
?>
<div class="form-group input-group-append">
    <label class="col-3" for="<?php echo $product_id;?>" class="label"><?php echo $product_name;?></label>
    <input type="text" name="<?php echo $product_id;?>" id="<?php echo $product_id;?>" class="form-control col-9" placeholder="Product ID">
 </div>

<?php }}?>

    <input type="submit" name="create_customer" value="Create" class="btn btn-block btn-info mt-2 text-white">

 </form>
 </div>
 </div>
 
</body>
</html>

<script>
    
</script>