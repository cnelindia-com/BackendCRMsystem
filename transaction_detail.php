<?php
include('header.php');

if(isset($_GET['history'])||isset($_GET['new'])||isset($_GET['bank'])){
    if(isset($_GET['history'])){
    $page_from="history";$transaction_id=$_GET['history'];$_SESSION['t_detail']="history";}
    if(isset($_GET['bank'])){
      $page_from="bank";$transaction_id=$_GET['bank'];$_SESSION['t_detail']="bank";}
    if(isset($_GET['new'])){
    $page_from="new";$transaction_id=$_GET['new'];$_SESSION['t_detail']="new";}

    $sql="SELECT user_id,status from transaction_info where id='$transaction_id'";
    $result=$conn->query($sql);
     if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $user_id=$row['user_id'];
            $status=$row['status'];
        }}

}else{
    echo "<script>window.history.go(-1);</script>";
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

      function ConfirmSubmit() {  
         return confirm("Are you sure you want to UPDATE the TRANSACTION information ?");
      }

      function ConfirmApprove() {  
        var r = confirm("Are you sure you want to APPROVE the TRANSACTION ?");
        if(r!=true){return false;}
      }


      function ConfirmReject() {  
        var r = confirm("Are you sure you want to REJECT the TRANSACTION ?");
        if(r==false){return false;}
      }

      function ConfirmCancel() {  
        var r = confirm("Are you sure you want to CANCEL the TRANSACTION ?");
        if(r==false){return false;}
      }


      function InsufficientPermissions() {  
       alert("Insufficient Permissions");
      }


    </script>

</head>
<body class="pb-5">

 <div class="row mt-5"><div class="col-md-12 text-center">
    <h3>Transaction Detail - <?php echo $user_id;?><?php echo " <<i class='text-info'>".strtoupper($status)."</i>>";?></h3>
</div></div>
 <div class="row mt-5">
 <div class="col-md-2"></div>
 <div class="col-md-4 bg-light">
 
 <form method="post" action="dataProcess.php" enctype="multipart/form-data">
 <?php

  $getdata="SELECT * FROM transaction_info where id='$transaction_id'";

  $result=$conn->query($getdata);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id=$row['id'];
        $user_id=$row['user_id'];
        $type=$row['type'];
        $amount=$row['amount'];
        $product_id=$row['product_id'];
        $product_detail=$row['product_detail'];
        $payment_type=$row['payment_type'];
        $bank_id=$row['bank_id'];
        $bank_name=$row['bank_name'];
        $code=$row['user_bank'];
        $bank_detail=$row['bank_detail'];
        $user_bank_detail=$row['user_bank_detail'];
        $create_by=$row['create_by'];
        $create_by=$row['create_by'];
        $create_date=$row['create_date'];
        $status=$row['status'];
        $remark=$row['remark'];
        $processing_date=$row['processing_date'];
        $handler=$row['handler'];

  ?>
  <input type="text" name="id_transaction" value="<?php echo $id;?>" style="display:none;">
  <h4>Transaction Data - </strong><?php echo $type;?></h4>
 
  <p><strong>User ID : </strong><?php echo $user_id;?></p>
  <p><strong>Transfer Date : </strong><?php echo $create_date;?></p>

  <?php if($type!="Bonus"){?>
  <p><strong>Payment Method : </strong><?php echo $payment_type;?></p>
  <?php }?>

  <div class="form-group">
    <label for="amount" class="label"><strong>Amount</strong></label>
    <input type="text" name="amount" id="amount" class="form-control" placeholder="0.00" pattern="^\d*(\.\d{0,2})?$" required value="<?php echo $amount;?>">
    </div>


  <?php if($type!="Bonus"){?>
  <div class="form-group">
    <label for="bank" class="label"><strong>Bank Account</strong></label>
    <select name="bank" id="bank" class="form-control">
        <?php 
        $sql="SELECT id,short_code,account_name,account_no,status from bank_info order by status ASC";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $b_id=$row['id'];
              $short_code=$row['short_code'];
              $account_name=$row['account_name'];
              $account_no=$row['account_no'];
              $b_status=$row['status'];

        ?>
        <option <?php if($bank_id==$b_id){echo 'selected="selected"';}?>value="<?php echo $b_id;?>"><?php echo $short_code."-".$account_name." (".$account_no.")[".$b_status."]";?></option>  
        <?php }}?>
                 
    </select>
    </div>

<?php }if($type=="Withdraw"){?>
  <p><strong>Withdraw To Bank Account : </strong><?php echo $user_bank_detail." | ".$code;?></p>
<?php }if(isset($_GET['history'])||isset($_GET['bank'])){?>

  <div class="form-group">
    <label for="status" class="label"><strong>Status </strong></label>
    <select name="status" id="status" class="form-control">
        <option value="approve"<?php if($status=="approve"){echo 'selected="selected"';}?>>Approve</option>  
        <option value="reject"<?php if($status=="reject"){echo 'selected="selected"';}?>>Reject</option>
            
    </select>
</div>
<?php }?>
  <p><strong>Create By : </strong><?php echo $create_by;?></p>
  <p><strong>Processing By : </strong><?php if($handler!=""){echo $handler;}else{echo "none";}?></p>
  <p><strong>Processing Date : </strong><?php if($processing_date!=0){echo $processing_date;}else{echo "none";}?></p>

  <div class="form-group">
    <label for="remark" class="label"><strong>Remark</strong></label>
    <textarea name="remark" id="remark" class="form-control" placeholder="Remark" rows="3"><?php echo $remark;?></textarea>
 </div>
  
 <?php }}?>
 </div>

 <div class="col-md-4 bg-light ml-2">
 <?php

$getdata="SELECT * FROM customer_info where user_id='$user_id'";

$result2=$conn->query($getdata);
if ($result2->num_rows > 0) {
  while($row = $result2->fetch_assoc()) {
    $user_name=$row['name'];
    $user_phone_no=$row['phone'];
    $user_email=$row['email'];
    $user_register_date=$row['register_date'];
    $user_create_by=$row['create_by'];
    $user_remark=$row['remark'];

?>
<input type="text" name="id_transaction" value="<?php echo $id;?>" style="display:none;">
<h4>User Data</strong></h4>
<p><strong>User ID : </strong><?php echo $user_id;?></p>
<p><strong>Name : </strong><?php echo $user_name;?></p>
<p><strong>Phone No : </strong><?php echo $user_phone_no;?></p>
<p><strong>Email : </strong><?php echo $user_email;?></p>
<p><strong>Register On : </strong><?php echo $user_register_date;?></p>
<p><strong>Create By : </strong><?php echo $user_create_by;?></p>
<p><strong>Remark : </strong><?php echo $user_remark;?></p>

<a href="view_customer.php?id=<?php echo $user_id;?>&t_id=<?php echo $transaction_id;?>">
      <input type="button" name="view" value="View" class="btn btn-info rounded">
</a>

<?php }}?>
 </div>
</div>

 <div class="row mt-5">
     <div class="col-md-5"></div>
     <div class="col-md-2">
     <div class="input-group">
     <?php if(isset($_GET['history'])|isset($_GET['bank'])){
         if($_SESSION['user_type']=="superadmin"){
             ?>
    
    <input type="submit" name="update_transaction" value="Save" class="btn btn-info mt-2 text-white" onclick="return ConfirmSubmit()">

    <?php }else{?>
    <input type="button" name="update_transaction" value="Save" class="btn btn-info mt-2 text-white" onclick="InsufficientPermissions()">
    <?php }}
    else if(isset($_GET['new'])){?>

<?php if($_SESSION['user_type']!="superadmin"){?>
        <input class="btn btn-success mt-2" type="button" name="approve" value="Approve" onclick="InsufficientPermissions()">
        <?php }?>
        <?php if($_SESSION['user_type']=="superadmin"){?>

        <input class="btn btn-success mt-2" type="submit" name="approve_transaction" value="Approve" onclick="return ConfirmApprove()">
  
        <?php }?>
     
        <?php if($_SESSION['user_type']!="superadmin"){?>
          <a href="home.php?cancel=<?php echo $id;?>">
        <input class="btn btn-danger mt-2 ml-2" type="button" name="cancel" value="Cancel" onclick="return ConfirmCancel()">
        </a>
        <?php }?>
        <?php if($_SESSION['user_type']=="superadmin"){?>

        <input class="btn btn-danger mt-2 ml-2" type="submit" name="reject_transaction" value="Reject" onclick="return ConfirmReject()">
   
     <?php }?>
    
    <?php }?>
    

    <?php if(isset($_GET['history'])){?>
        <input type="button" name="back" value="back" class="btn btn-warning mt-2 ml-2 text-white" onclick="window.location.assign('transaction_history.php')">
    <?php }else if(isset($_GET['new'])){?>
        <input type="button" name="back" value="back" class="btn btn-warning mt-2 ml-2 text-white" onclick="window.location.assign('home.php')">
    <?php }else if(isset($_GET['bank'])){?>
        <input type="button" name="back" value="back" class="btn btn-warning mt-2 ml-2 text-white" onclick="window.location.assign('bank_transaction.php')">
    <?php }?>

 </div>
 </div>
 </form>

 
 
</body>
</html>

<script>
    
</script>