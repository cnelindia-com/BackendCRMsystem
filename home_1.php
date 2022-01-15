<?php
session_start();

$my_id=$_SESSION['user'];

$_SESSION['page']='home';

include('header.php');

$dateandtime=date('Y-m-d H:i:s');
$type_search="";
$type_search_selected="";
$product_search="";
$bank_search="";

$start_d = explode('-', date('Y-m-d'));
              $year  = $start_d[0];
              $month = $start_d[1];
              $day   = $start_d[2];

$end_d = explode('-', date('Y-m-d'));
              $year  = $end_d[0];
              $month = $end_d[1];
              $day   = $end_d[2];

$date_start=date('Y-m-d', mktime(0, 0, 0, $start_d[1], 1, $start_d[0]));
$end_date=date('Y-m-d', mktime(0, 0, 0, $end_d[1]+1, 1, $end_d[0]));

$page=" Limit 50";
$editPage="";
if(isset($_GET['page'])){
  $editPage = $_GET['page'];
  $page = " Limit 50";
  if($_GET['page']>1){
  $page = " Limit ".(($_GET['page']*50)-50).",50";
  }
}
//search selected info
      if(isset($_POST['searchkey'])){$searchk=$_POST['searchkey'];}
      else if(isset($_GET['searchk'])){$searchk=$_GET['searchk'];}else{$searchk="";}

      if(isset($_POST['type'])){$searchtype=$_POST['type'];}
      else if(isset($_GET['searchtype'])){$searchtype=$_GET['searchtype'];}else{$searchtype="";}

      if(isset($_POST['product'])){$searchproduct=$_POST['product'];}
      else if(isset($_GET['searchproduct'])){$searchproduct=$_GET['searchproduct'];}else{$searchproduct="";}

      if(isset($_POST['bank'])){$searchbank=$_POST['bank'];}
      else if(isset($_GET['searchbank'])){$searchbank=$_GET['searchbank'];}else{$searchbank="";}

      if(isset($_POST['date_start'])){$searchds=$_POST['date_start'];}
      else if(isset($_GET['searchds'])){$searchds=$_GET['searchds'];}else{$searchds="";}

      if(isset($_POST['end_date'])){$searched=$_POST['end_date'];}
      else if(isset($_GET['searched'])){$searched=$_GET['searched'];}else{$searched="";}
//search selected info

if($_SESSION['user_type']=="superadmin"){
$search=" and create_date>='$date_start' and create_date<='$end_date'";


if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];

    if($_POST['type']!=""){
      $type_search=" and type='".$_POST['type']."'";
      $type_search_selected=$_POST['type'];
    }else{$type_search="";}
   
    if($_POST['product']!=""){$product_search=" and product_id='".$_POST['product']."'";}else{$product_search="";}
    
    if($_POST['bank']!=""){$bank_search=" and bank_name='".$_POST['bank']."' or user_bank='".$_POST['bank']."'";}else{$bank_search="";}

    $date_start=$_POST['date_start'];
    $end_date=$_POST['end_date'];

    $end_d = explode('-', $end_date);
    $year  = $end_d[0];
    $month = $end_d[1];
    $day   = $end_d[2];

    $end_date = date('Y-m-d', mktime(0, 0, 0, $end_d[1], $end_d[2]+1, $end_d[0]));

    $search=" and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%')".$type_search.$product_search.$bank_search." and create_date>='$date_start' and create_date<='$end_date'";

    /*if($type_search==""){$search=" and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and (type LIKE '%$type_search%') and create_date>='$date_start' and create_date<='$end_date'";}
    if($type_search=="Deposit"){$search=" and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and (type LIKE '%$type_search%') and create_date>='$date_start' and create_date<='$end_date'";}
    if($type_search=="Withdawn"){$search=" and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and type='Withdawn' and create_date>='$date_start' and create_date<='$end_date'";}
    if($type_search=="Bonus"){$search=" and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and type='Bonus' and create_date>='$date_start' and create_date<='$end_date'";}
*/
}

if(isset($_GET['searchk'])||isset($_GET['searchtype'])||isset($_GET['searchproduct'])||isset($_GET['searchbank'])||isset($_GET['searchds'])||isset($_GET['searched'])){

  if(isset($_GET['searchk'])){$searchkey=$_GET['searchk'];}
  else{$searchkey="";}

  if(isset($_GET['searchtype'])){
    $type_search=" and type='".$_GET['searchtype']."'";
    $type_search_selected=$_GET['searchtype'];
  }else{$type_search="";}
 
  if(isset($_GET['searchproduct'])){$product_search=" and product_id='".$_GET['searchproduct']."'";}else{$product_search="";}
  
  if(isset($_GET['searchbank'])){$bank_search=" and bank_name='".$_GET['searchbank']."' or user_bank='".$_GET['searchbank']."'";}else{$bank_search="";}

  if(isset($_GET['searchds'])){
  if($_GET['searchds']!=""&&$_GET['searched']!=""){
  $date_start=$_GET['searchds'];
  $end_date=$_GET['searched'];}}

  $end_d = explode('-', $end_date);
  $year  = $end_d[0];
  $month = $end_d[1];
  $day   = $end_d[2];

  $end_date = date('Y-m-d', mktime(0, 0, 0, $end_d[1], $end_d[2]+1, $end_d[0]));

  $search=" and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%')".$type_search.$product_search.$bank_search." and create_date>='$date_start' and create_date<='$end_date'";

}
}

if($_SESSION['user_type']!="superadmin"){
    $search="and create_by='$my_id' and create_date>='$date_start' and create_date<='$end_date'";

    if(isset($_POST['search'])){
    
        $searchkey=$_POST['searchkey'];
        if($_POST['type']!=""){
          $type_search=" and type='".$_POST['type']."'";
          $type_search_selected=$_POST['type'];
        }else{$type_search="";}
       
        if($_POST['product']!=""){$product_search=" and product_id='".$_POST['product']."'";}else{$product_search="";}
        
        if($_POST['bank']!=""){$bank_search=" and bank_name='".$_POST['bank']."' or user_bank='".$_POST['bank']."'";}else{$bank_search="";}
        $date_start=$_POST['date_start'];
        $end_date=$_POST['end_date'];

        $end_d = explode('-', $end_date);
        $year  = $end_d[0];
        $month = $end_d[1];
        $day   = $end_d[2];

        $end_date = date('Y-m-d', mktime(0, 0, 0, $end_d[1], $end_d[2]+1, $end_d[0]));

        $search=" and create_by='$my_id' and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%')".$type_search.$product_search.$bank_search." and create_date>='$date_start' and create_date<='$end_date'";

    
        /*if($type_search==""){$search=" and user_id='$my_id' and (product_name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and create_date>='$date_start' and create_date<='$end_date'";}
        if($type_search=="in"){$search=" and user_id='$my_id' and (product_name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and type='in' and create_date>='$date_start' and create_date<='$end_date'";}
        if($type_search=="out"){$search=" Wheandre user_id='$my_id' and (product_name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%') and type='out' and create_date>='$date_start' and create_date<='$end_date'";}
        */
      }

      if(isset($_GET['searchk'])||isset($_GET['searchtype'])||isset($_GET['searchproduct'])||isset($_GET['searchbank'])||isset($_GET['searchds'])||isset($_GET['searched'])){

        if(isset($_GET['searchk'])){$searchkey=$_GET['searchk'];}
        else{$searchkey="";}
      
        if(isset($_GET['searchtype'])){
          $type_search=" and type='".$_GET['searchtype']."'";
          $type_search_selected=$_GET['searchtype'];
        }else{$type_search="";}
       
        if(isset($_GET['searchproduct'])){$product_search=" and product_id='".$_GET['searchproduct']."'";}else{$product_search="";}
        
        if(isset($_GET['searchbank'])){$bank_search=" and bank_name='".$_GET['searchbank']."' or user_bank='".$_GET['searchbank']."'";}else{$bank_search="";}
      
        if(isset($_GET['searchds'])){
          if($_GET['searchds']!=""&&$_GET['searched']!=""){
          $date_start=$_GET['searchds'];
          $end_date=$_GET['searched'];}}
      
        $end_d = explode('-', $end_date);
        $year  = $end_d[0];
        $month = $end_d[1];
        $day   = $end_d[2];
      
        $end_date = date('Y-m-d', mktime(0, 0, 0, $end_d[1], $end_d[2]+1, $end_d[0]));
      
        $search=" and create_by='$my_id' and (product_detail LIKE '%$searchkey%' or user_id LIKE '%$searchkey%')".$type_search.$product_search.$bank_search." and create_date>='$date_start' and create_date<='$end_date'";
      
      }
    }

    if(isset($_GET['approve'])){
      $t_id=$_GET['approve'];

      $checkstatus="SELECT status,handler FROM transaction_info WHERE id='$t_id'";
      $resultcheck=$conn->query($checkstatus);
         if ($resultcheck->num_rows > 0) {
          while($row = $resultcheck->fetch_assoc()) {
            $c_status=$row['status'];
            $handler=$row['handler'];
      
      if($c_status!='processing'){
      echo "<script>alert('Transaction already PROCESSING BY [".$handler."]')</script>";
      echo "<script>window.location.assign('home.php');</script>";
    }
      else if($c_status=='processing'){
        $update="UPDATE transaction_info set status='approve',handler='$my_id',processing_date='$dateandtime' WHERE id='$t_id'";
        $result=$conn->query($update);
        echo "<script>alert('Successfully approve the transaction')</script>";
        echo "<script>window.location.assign('home.php');</script>";
      }
    }}else{
      echo "<script>alert('Transaction has been cancelled')</script>";
        echo "<script>window.location.assign('home.php');</script>";
    }
    
    }

    if(isset($_GET['reject'])){
      $t_id=$_GET['reject'];

      $checkstatus="SELECT status,handler FROM transaction_info WHERE id='$t_id'";
      $resultcheck=$conn->query($checkstatus);
         if ($resultcheck->num_rows > 0) {
          while($row = $resultcheck->fetch_assoc()) {
            $c_status=$row['status'];
            $handler=$row['handler'];
          
      if($c_status!='processing'){
      echo "<script>alert('Transaction already PROCESSING BY [".$handler."]')</script>";
      echo "<script>window.location.assign('home.php');</script>";
    }
      else if($c_status=='processing'){
        $update="UPDATE transaction_info set status='reject',handler='$my_id',processing_date='$dateandtime' WHERE id='$t_id'";
        $result=$conn->query($update);
        echo "<script>alert('Successfully reject the transaction')</script>";
        echo "<script>window.location.assign('home.php');</script>";
      }
    }}else{
      echo "<script>alert('Transaction has been cancelled')</script>";
        echo "<script>window.location.assign('home.php');</script>";
    }
    
    }

    if(isset($_GET['cancel'])){
      $t_id=$_GET['cancel'];

      $checkstatus="SELECT status,handler FROM transaction_info WHERE id='$t_id'";
      $resultcheck=$conn->query($checkstatus);
         if ($resultcheck->num_rows > 0) {
          while($row = $resultcheck->fetch_assoc()) {
            $c_status=$row['status'];
            $handler=$row['handler'];
          }}
      if($c_status!='processing'){
      echo "<script>alert('Transaction already PROCESSING BY [".$handler."]')</script>";
      echo "<script>window.location.assign('home.php');</script>";
    }
      else if($c_status=='processing'){
        $cancel="DELETE FROM transaction_info WHERE id='$t_id'";
        $result=$conn->query($cancel);
        echo "<script>alert('Successfully CANCEL the transaction')</script>";
        echo "<script>window.location.assign('home.php');</script>";
      }
    
    }

?>

<!DOCTYPE html>
<html>
<head>
<!--<meta http-equiv="refresh" content="11" > -->
	<title>Admin Panel</title>

      <script>

      function ConfirmSubmit() {  
      return confirm("Are you sure you want to Submit the TRANSACTION ?");
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

      function getFocus(){
        searchbox.focus();
        var length = searchbox.value.length;  
        searchbox.setSelectionRange(length, length);

      }
     
      </script>

    <style>
html, body {
	background: #dedede;
}
    </style>

</head>
<body <?php if(isset($_POST['searchkey'])){?>onload="getFocus()"<?php }?>>



<div class="row mt-5">
<div class="col-md-12">

<ul class="nav nav-tabs">
 <li class="nav-item">
   <a class="nav-link active" href="#">New Transaction</a>
 </li>
 <li class="nav-item">
   <a class="nav-link" href="transaction_history.php">Transaction History</a>
 </li>
 <li class="nav-item">
   <a class="nav-link" href="transaction_report.php">Report</a>
 </li>
</ul>

</div></div>

 
 <div class="row mt-5">
 <div class="col-md-3"><h3 class="ml-2">New Transaction (<span id="countdown">30</span>)</div>
 </div>
<form method="post" action="home.php" enctype="multipart/form-data">
 <div class="row">

    <div class="col-md-2">

    <div class="input-group mb-3">
     <span class="input-group-text" id="date_start">From</span>
     <input class="form-control" type="date" id="date_start" name="date_start" 
    value="<?php if(isset($_POST['searchkey'])){echo $_POST['date_start'];}else if(isset($_GET['searchsd'])){echo $_GET['searchsd'];}else{echo date('Y-m-d', mktime(0, 0, 0, $start_d[1], 1, $start_d[0]));}?>">
    </div>

    </div>

    <div class="col-md-2">

    <div class="input-group mb-3">
     <span class="input-group-text" id="end_date">To</span>
     <input class="form-control" type="date" id="end_date" name="end_date" 
    value="<?php if(isset($_POST['searchkey'])){echo $_POST['end_date'];}else if(isset($_GET['searched'])){echo $_GET['searched'];}else{echo date('Y-m-d', mktime(0, 0, 0, $end_d[1]+1, 1-1, $end_d[0]));}?>">
    </div>

    </div>

    <div class="col-md-2">
    
    <div class="input-group mb-3">
     <span class="input-group-text" id="type">Type</span>
    <select name="type" id="type" class="form-control">
        <option value="">All</option>
        <option value="Deposit" <?php if($type_search_selected=="Deposit"){echo 'selected="selected"';}?>>Deposit</option>  
        <option value="Withdraw" <?php if($type_search_selected=="Withdraw"){echo 'selected="selected"';}?>>Withdraw</option>
        <option value="Bonus" <?php if($type_search_selected=="Bonus"){echo 'selected="selected"';}?>>Bonus</option>
                 
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    
    <div class="input-group mb-3">
     <span class="input-group-text" id="product">Product</span>
    <select name="product" id="product" class="form-control">
        <option value="">All</option>
        <?php 
        $sql="SELECT id,name,status from product_info";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $id=$row['id'];
              $name=$row['name'];
              $p_status=$row['status'];

        ?>
        <option value="<?php echo $id;?>" <?php if(isset($_POST['product'])){if($_POST['product']=="$id"){echo 'selected="selected"';}}if(isset($_GET['searchproduct'])){if($_GET['searchproduct']=="$id"){echo 'selected="selected"';}}?>><?php echo $name." (".$p_status.")";?></option>  
        <?php }}?>
                 
    </select>
    </div>
    </div>

  <div class="col-md-2">
    
  <div class="input-group mb-3">
     <span class="input-group-text" id="bank">Bank Code</span>
    
     <input class="form-control" type="text" id="bank"  placeholder="CODE" name="bank" 
    value="<?php if(isset($_POST['bank'])){echo $_POST['bank'];}?>" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
    </div>
    </div>

    <div class="col-md-2">

    <div class="input-group mb-3">
    <input class="form-control" type="text" id="searchbox"  placeholder="Search..." name="searchkey" 
    value="<?php if(isset($_POST['searchkey'])){echo $_POST['searchkey'];}?>">
    <div class="input-group-append">
    <input class="btn btn-outline-primary" type="submit" name="search" value="Search" >
    <a href="home.php">
    <input class="btn btn-outline-primary" type="button" name="clear" value="Clear" >
    </a>
    </div>
    </div>
   
    </div>
    </div></form>

    <div class="row mt-2">
    <div class="col-md-11"></div>
    <div class="col-md-1 mt-2">
      <input type="button" name="new" value="Add New" class="btn btn-dark rounded" onclick="window.location.assign('add_transaction.php')">
    </div>
    </div>
 
 <div class="row">

  <div class="col-md-12 tableSetting mt-2">
 
  <table class="table table-bordered">
  <thead>
    <tr class="my-table-tr-top text-white">
      <th scope="col">#</th>
      <th scope="col">User ID</th> 
      <th scope="col">Amount</th>

      <th scope="col">Type</th>

      <!--<th scope="col">Customer Bank</th>
      <th scope="col">Customer Account.No</th>
      <th scope="col">Customer Account Name</th>-->
      <th scope="col">Bank</th>
      <th scope="col">Code</th>
      <th scope="col">Account</th>
      <th scope="col">Product</th>
      <th scope="col">Transfer Date</th>
      <th scope="col">Create by</th>    
      <th scope="col">Remark</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
  
  $getdata="SELECT * FROM transaction_info WHERE status='processing'".$search." order by create_date DESC".$page;
  $i=0;

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
      $bank_name=$row['bank_name'];
      $code=$row['user_bank'];
      $bank_detail=$row['bank_detail'];
      $user_bank_detail=$row['user_bank_detail'];
      $create_by=$row['create_by'];
      $transfer_date=$row['create_date'];
      $status=$row['status'];
      $remark=$row['remark'];
      $i++;

      /*$c_p_status="SELECT status FROM product_info WHERE id='$product_id'";
      $c_p_result=$conn->query($c_p_status);
      if ($c_p_result->num_rows > 0) {
        while($row = $c_p_result->fetch_assoc()) {
          $check_product=$row['status'];
        }}else{$check_product="Deleted";}*/

  ?>
    <tr class="info <?php if($type=="Withdraw"){echo 'out';}else{echo 'in';}?>">

      <th scope="row"><?php echo $i;?></th>
      <td><a href="view_customer.php?id=<?php echo $user_id;?>"><?php echo $user_id;?></a></td>
      <td><?php echo $amount;?></td>
      <td><?php echo $type;if($payment_type!=""){echo " (".$payment_type.")";}?></td>

      <td><?php echo $bank_name;?></td>
      <td><?php echo $code;?></td>
      <td><?php if($type!="Withdraw"){echo $bank_detail;}else if($type=="Withdraw"){echo $user_bank_detail;}?></td>
      <td><?php echo $product_detail;?></td>
      <td><?php echo $transfer_date;?></td>
      <td><?php echo $create_by;?></td>
      <td><?php echo $remark;?></td>
      <td class="text-uppercase" style="background-color:#5cff7f;"><?php echo $status;?></td>

     <td>
    <div class="input-group-append">
     <?php if($_SESSION['user_type']!="superadmin"){?>
        <input class="btn btn-success" type="button" name="approve" value="Approve" onclick="InsufficientPermissions()">
        <?php }?>
        <?php if($_SESSION['user_type']=="superadmin"){?>
        <a href="home.php?approve=<?php echo $id;?>">
        <input class="btn btn-success" type="button" name="approve" value="Approve" onclick="return ConfirmApprove()">
        </a>
        <?php }?>
     
        <?php if($_SESSION['user_type']!="superadmin"){?>
          <a href="home.php?cancel=<?php echo $id;?>">
        <input class="btn btn-danger ml-1" type="button" name="cancel" value="Cancel" onclick="return ConfirmCancel()">
        </a>
        <?php }?>
        <?php if($_SESSION['user_type']=="superadmin"){?>
        <a href="home.php?reject=<?php echo $id;?>">
        <input class="btn btn-danger ml-1" type="button" name="reject" value="Reject" onclick="return ConfirmReject()">
        </a>
     <?php }?>

     <a href="transaction_detail.php?new=<?php echo $id;?>">
     <input class="btn btn-info ml-1" type="button" name="detail" value="Detail">
     </a>

     </div>
     </td>

    </tr>
    <?php }}else{ echo "<tr class='text-center'><td colspan='16'>Nothing Record Now</td></tr>";}?>

  </tbody>
</table>
 </div>
 </div>


 <div class="row mt-3">

 <div class="col-md-12">

  <nav aria-label="Page navigation">
  <ul class="pagination float-right">
  <?php                                            
      
      $getdata="SELECT * FROM transaction_info WHERE status='processing'".$search." order by create_date DESC";
        
      $result2 = $conn->query($getdata);
      $count = $result2->num_rows;
                                            
      $a = $count / 50;
      $a = ceil($a);
      
      if($count>0){ ?>
       <li class="page-item"><a class="page-link bg-white text-dark" href="home.php<?php echo "?searchk=".$searchk;if($searchtype!=""){echo "&searchtype=".$searchtype;}if($searchproduct!=""){echo "&searchproduct=".$searchproduct;}if($searchbank!=""){echo "&searchbank=".$searchbank;}if($searchds!=""){echo "&searchds=".$searchds;}if($searched!=""){echo "&searched=".$searched;}?>">
       <img src="https://img.icons8.com/fluent-systems-regular/12/000000/back.png"/></a></li>

    <?php }for ($i = 1; $i <= $a; $i++) { ?>

        <li class="page-item"><a class="page-link bg-white text-dark" href="home.php?page=<?php echo $i;?><?php echo "&searchk=".$searchk;if($searchtype!=""){echo "&searchtype=".$searchtype;}if($searchproduct!=""){echo "&searchproduct=".$searchproduct;}if($searchbank!=""){echo "&searchbank=".$searchbank;}if($searchds!=""){echo "&searchds=".$searchds;}if($searched!=""){echo "&searched=".$searched;}?>"><?php echo $i;?></a></li>

     <?php } 
     if($count>0){?>
      <li class="page-item"><a class="page-link bg-white text-white" href="home.php?page=<?php echo $a;echo "&searchk=".$searchk;if($searchtype!=""){echo "&searchtype=".$searchtype;}if($searchproduct!=""){echo "&searchproduct=".$searchproduct;}if($searchbank!=""){echo "&searchbank=".$searchbank;}if($searchds!=""){echo "&searchds=".$searchds;}if($searched!=""){echo "&searched=".$searched;}?>">
      <img src="https://img.icons8.com/fluent-systems-regular/12/000000/forward.png"/></a></li>
    <?php }
     ?>
  </ul>
</nav>

  </div>
  </div>


 
 </body>
 </html>
 <script>
 
  var timeleft = 30;
   
/*   function run() {
    
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdown").textContent = timeleft;
    if(timeleft <= 0){
    var r = confirm("Do you want to refesh now ?");
}
    },1000);
   }
  run();
   if(r==true){
         window.location.assign('home.php');
       }
       if(r==false){
        clearInterval(downloadTimer);
        timeleft = 10;
        run();
        
        }*/

var ticker = function() {
  timeleft--;
  document.getElementById("countdown").textContent = timeleft;
  if(timeleft<0){
  window.clearInterval(myTimer);
  var r = confirm("Do you want to refesh now ?");
    if(r==true){
            window.location.assign('home.php');
          }
    if(r==false){
    timeleft=30;
    document.getElementById("countdown").textContent = timeleft;
    myTimer = window.setInterval(ticker, 1000);}
  }

}

var myTimer = window.setInterval(ticker, 1000);

</script>