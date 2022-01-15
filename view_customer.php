<?php
include('header.php');

if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
    if(isset($_GET['t_id'])){$transaction_id=$_GET['t_id'];$delete_recovery="&t_id=$transaction_id";}
}else{
    echo "<script>window.location.assign('customer.php');</script>";
}

if(isset($_GET['d'])){

    $cid=$_GET['d'];
  
    $delete="DELETE FROM customer_product_info where id='".$cid."'";
    $result=$conn->query($delete);
  
    echo "<script>window.location.assign('view_customer.php?id=".$customer_id.$delete_recovery."');</script>";
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

    <script>
    function ConfirmDelete() {  
       var r = confirm("Are you sure you want to DELETE the Product ID ?");
       if(r==false){return false;}
      }
 
      function ConfirmSubmit() {  
         return confirm("Are you sure you want to UPDATE the Customer information ?");
      }

      function InsufficientPermissions() {  
       alert("Insufficient Permissions");
      }

    </script>

</head>
<body class="pb-5">

 <div class="container-fluid pt-5 pb-5 mt-5">

 <div class="row mt-5">
 <div class="col-md-1"></div>
 <div class="col-md-5">
 <h3>Customer Detail (<?php echo $customer_id;?>)</h3>
 <form method="post" action="dataprocess.php" enctype="multipart/form-data">
 <?php

  $getdata="SELECT * FROM customer_info where user_id='$customer_id'";

  $result=$conn->query($getdata);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $user_id=$row['user_id'];
        $name=$row['name'];
        $phone_no=$row['phone'];
        $email=$row['email'];
        $remark=$row['remark'];
        $register_date=$row['register_date'];
        $create_by=$row['create_by'];

  ?>
  <input type="text" name="id_customer" value="<?php echo $customer_id;?>" style="display:none;">
<!--1-->
 <div class="form-group mt-3">
    <label for="user_id" class="label">User ID </label>
    <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User ID" required 
    oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" readonly value="<?php echo $user_id;?>">
 </div>
<!--2-->
<div class="form-group">
    <label for="name" class="label">Name</label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Name" required value="<?php echo $name;?>">
 </div> 
<!--3-->
<div class="form-group">
    <label for="phone_no" class="label">Phone Number</label>
    <input name="phone_no" id="phone_no" type="text" class="form-control" pattern="[0-9]{10}||[0-9]{11}" placeholder="Phone Number" required value="<?php echo $phone_no;?>">
 </div>
 
<!--4-->
 <div class="form-group">
    <label for="mail" class="label">Mail</label>
    <input name="email" id="email" type="email"  class="form-control"  placeholder="Email" value="<?php echo $email;?>">
 </div>
<!--5-->

 <?php }}?>
 </div>

 <!--product ID-->
 <div class="col-md-5">
 <h5 class="mb-2 mt-5">Product ID</h5>
 <?php
 $get_product_id="select id,name from product_info";
 $result=$conn->query($get_product_id);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){      
        $product_id=$row['id'];
        $product_name=$row['name'];

        $get_customer_product_id="select customer_product_id from customer_product_info where product_id='$product_id' and customer_id='$customer_id'";
        $result2=$conn->query($get_customer_product_id);
        if ($result2->num_rows > 0) {
            while($row = $result2->fetch_assoc()){      
                $customer_product_id=$row['customer_product_id'];}}else{$customer_product_id="";}
?>
<div class="form-group input-group-append">
    <label class="col-3" for="<?php echo $product_id;?>" class="label"><?php echo $product_name;?></label>
    <input type="text" name="<?php echo $product_id;?>" id="<?php echo $product_id;?>" class="form-control col-9" 
    placeholder="Product ID" value="<?php echo $customer_product_id;?>">
</div>

<?php }}?>       
<h6 class="mt-5">Deleted Product</h6>
  <table class="table table-hover table-bordered">
  <thead>
    <tr class="my-table-tr-top text-white">
      <th scope="col">Product Name</th> 
      <th scope="col">ID</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
  <?php 
     $get_customer_p_id="select id,product_id,product_name,customer_product_id from customer_product_info where customer_id='$customer_id'";
     $result3=$conn->query($get_customer_p_id);
    if ($result3->num_rows > 0) {
        while($row = $result3->fetch_assoc()){
            $id=$row['id'];
            $product_id=$row['product_id'];
            $product_name=$row['product_name'];
            $customer_product_id=$row['customer_product_id'];
            $checkproduct="SELECT id from product_info WHERE id='$product_id'";
            $result4=$conn->query($checkproduct);
            if ($result4->num_rows <= 0) {?> 
       <tr class="info">        
            <td><?php echo $product_name." (Deleted)";?></td>
            <td><?php echo $customer_product_id;?></td>
            <td><a href="view_customer.php?d=<?php echo $id."&id=".$customer_id.$delete_recovery;?>" onclick="return ConfirmDelete()">Delete</a></td>
       </tr>
  <?php }}}?>
  </table>
  </tbody>

 </div></div>

 <div class="row mt-5">
     <div class="col-md-1"></div>
     <div class="col-md-5 bg-light rounded">
         <h4>More Detail</h4>
         <p class="mt-3"><strong>Register On : </strong><?php echo $register_date;?></p>
         <p><strong>Create By : </strong><?php echo $create_by;?></p>

         <?php
         $totalDeposit="SELECT sum(amount) as total_d FROM transaction_info WHERE user_id='$customer_id' and type='Deposit'";
         $resultdeposit=$conn->query($totalDeposit);
         if ($resultdeposit->num_rows > 0) {
             while($row = $resultdeposit->fetch_assoc()){      
                 $total_d=$row['total_d'];

                 if($total_d==""){$total_d='0.00';}
         ?>

         <p><strong>Total Deposit : </strong><?php echo $total_d;?></p>

         <?php }}
          $totalWithdraw="SELECT sum(amount) as total_w FROM transaction_info WHERE user_id='$customer_id' and type='Withdraw'";
          $resultWithdraw=$conn->query($totalWithdraw);
          if ($resultWithdraw->num_rows > 0) {
              while($row = $resultWithdraw->fetch_assoc()){      
                  $total_w=$row['total_w'];

                  if($total_w==""){$total_w='0.00';}
         ?>

         <p><strong>Total Withdraw : </strong><?php echo $total_w;?></p>

         <?php }}
          $totalBonus="SELECT sum(amount) as total_b FROM transaction_info WHERE user_id='$customer_id' and type='Bonus'";
          $resultBonus=$conn->query($totalBonus);
          if ($resultBonus->num_rows > 0) {
              while($row = $resultBonus->fetch_assoc()){      
                  $total_b=$row['total_b'];

                  if($total_b==""){$total_b='0.00';}
         ?>

         <p><strong>Total Bonus : </strong><?php echo $total_b;?></p>

         <?php }}?>
            
     </div>
     <div class="col-md-5">
        <div class="form-group">
        <label for="remark" class="label">Remark</label>
        <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"><?php echo $remark;?></textarea>
        </div>
     </div>
</div>

 <div class="row mt-5">
     <div class="col-md-5"></div>
     <div class="col-md-1">
    <?php 
         if($_SESSION['user_type']=="superadmin"||$_SESSION['user']==$create_by){
             ?>
    
    <input type="submit" name="edit_customer" value="Submit" class="btn btn-block btn-info mt-2 text-white" onclick="return ConfirmSubmit()">

    <?php }else{?>
    <input type="button" name="edit_customer" value="Submit" class="btn btn-block btn-info mt-2 text-white" onclick="InsufficientPermissions()">
    <?php }?>
    </div>
    <div class="col-md-1">
<?php if(isset($_GET['t_id'])){?>
    <input type="button" name="back" value="back" class="btn btn-block btn-warning mt-2 text-white" onclick="window.location.assign('transaction_detail.php?<?php echo $_SESSION['t_detail'].'='.$transaction_id;?>')">
<?php }else if($_SESSION['page']!='home'){?>
    <input type="button" name="back" value="back" class="btn btn-block btn-warning mt-2 text-white" onclick="window.location.assign('customer.php')">
<?php }else if($_SESSION['page']=='home'){?>
    <input type="button" name="back" value="back" class="btn btn-block btn-warning mt-2 text-white" onclick="window.location.assign('home.php')">
<?php }?>
 </div>
 </div>
 </form>

 
 
</body>
</html>

<script>
    
</script>