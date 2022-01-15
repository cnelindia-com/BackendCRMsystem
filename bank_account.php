<?php
session_start();

$_SESSION['page']='bank';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$success = '';
if(isset($_GET['delete_id']))
{
	$delete_id = $_GET['delete_id'];
	$dlt_sql = "DELETE from bank_account where id=$delete_id";
	if(mysqli_query($conn,$dlt_sql)==TRUE)
	{
		$success='Bank Account Detail Deleted Successfully.';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

     <!-- <script>

      function ConfirmDelete() {  
       var r = confirm("Are you sure you want to DELETE the USER ?");
       if(r==true){var s = confirm("Are you sure you want to DELETE the USER ?(Secrond Confirm)");}else{return false;			}
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
     
      </script>-->

    <style>
.tabcontent{
	font-size: 18px;
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
span{
	color:#ff6c04;
}
.actives{
	color: #000;
	font-family: "微软雅黑", Arial, Tahoma, Helvetica, sans-serif;
	text-decoration: none;
	border: 1px solid #FF6C04;
	background: rgba(255,108,4, 0.2);	
}
.tableborder1 {
    background-color: #fff;
    *border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: solid #ccc 1px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 1px 1px #ccc;
    -moz-box-shadow: 0 1px 1px #ccc;
    box-shadow: 0 1px 1px #ccc;
}
td {
    font-family: "微软雅黑", Arial, Helvetica, sans-serif;
    font-size: 14px;
    cursor: default;
    white-space: nowrap;
	background:#fff;
}
.tableborder1 th {
    background-color: #FFA241;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#FFA241), to(rgb(255, 108, 4)));
    background-image: -webkit-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: -moz-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: -ms-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: -o-linear-gradient(top, #FFA241, rgb(255, 108, 4));
    background-image: linear-gradient(top, #FFA241, rgb(255, 108, 4));
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    -moz-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    border-top: none;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
}
.tableborder1 td, .tableborder1 th {
    border-left: 1px solid #ccc;
    border-top: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
.tableborder1 th {
    color: #ffffff;
    font-weight: 100;
    position: relative;
}
.filternav {
    font-size: 14px;
    margin: 0 auto;
    padding: 2px 14px 3px;
    overflow: hidden;
    background: #E6E6E6;
    border-top: 1px solid #d9d9d9;
    border-bottom: 1px solid #8c8c8c;
    width: auto;
}
.filternav h2 {
    font-weight: bold;
    +padding-bottom: 9px;
}
.filternav h2 {
    font-size: 26px;
    font-family: "微软雅黑", Tahoma, Arial, Helvetica, sans-serif;
    padding-bottom: 7px;
}
.filternav {
    font-size: 14px;
	
}
.pb-5, .py-5 {
    padding-bottom: unset !important;
}

.btn1 {
    border: 0px;
    -webkit-box-shadow: inset 0px 1px 0px 0px #bbdaf7;
    box-shadow: inset 0px 1px 0px 0px #bbdaf7;
    background: rgb(56,56,56);
    background: -moz-linear-gradient(top, rgba(56,56,56,1) 14%, rgba(117,117,117,1) 99%, rgba(117,117,117,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(14%,rgba(56,56,56,1)), color-stop(99%,rgba(117,117,117,1)), color-stop(100%,rgba(117,117,117,1)));
    background: -webkit-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    background: -o-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    background: -ms-linear-gradient(top, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    background: linear-gradient(to bottom, rgba(56,56,56,1) 14%,rgba(117,117,117,1) 99%,rgba(117,117,117,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#383838', endColorstr='#757575',GradientType=0 );
    background-color: #79bbff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: 1px solid #84bbf3;
    display: inline-block;
    color: #EFEFEF;
    font-family: "微软雅黑",arial;
    font-size: 14px;
    font-weight: normal;
    padding: 4px 20px;
    text-decoration: none;
    text-shadow: 1px 1px 0px #528ecc;
    cursor: pointer;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.container{
	background: #dedede;
max-width: 100%;
overflow-y: scroll;
height: 753px;
	}
	.form-group
	{
		display: flex;
	}
	.txt_sp3 a
	{
		color:#007bff;
	}
	
	html, body {
	background: #dedede;
}
    </style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


 <?php 
  $filter = $_POST['aflt'];
 ?>

 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="bank.php" id="sc8_1">Bank</a>
    <span>|</span>
    <a href="bank_account.php" id="sc8_1" class="actives">Bank Account</a>
</div>
<!--<div class="container" >-->
  <div class="filternav">
  <?php 
	if(!empty($success))
	{
	?>
	<div class="row">
    	<div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="alert alert-success" role="alert" style="text-align: center;">
              <?php echo $success;?>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
	<?php
	}
	?>
    </div>
	<h2>Manage Bank Account</h2>
		<form name="spbFormTop" id="spbFormTop" method="post">
        <table>
            <tbody>
                <tr>
                    <th> 
                        <select name="aflt" id="istatus"><option value="">All</option>
                            <option value="Active" <?php if($filter=='Active'){echo "Selected";}?>>Active</option>
                            <option value="Suspended" <?php if($filter=='Suspended'){echo "Selected";}?>>Suspended</option>
                        </select> 
                        <input type="submit" class="btn1" name="submit" value="Search">  &nbsp; 
                        <a href="add_bank_account.php"  class="btn1">NEW</a>
                        <input name="exportexcelbank" type="submit" class="btn1" value="Export Report">  &nbsp;&nbsp;
                    </th>
                  </tr>
             </tbody>
        </table>
        </form>    
    <br/>
    <br/>
    <div class="resulttable" style="">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel">
            <thead style="background-color: #ff720b;">
                <tr>
                  <th>No</th>
                  <th class="col-md-3 col-xs-3">Bank</th>
                  <th class="col-md-3 col-xs-3">Code</th>
                  <th class="col-md-3 col-xs-3">Bank Account Name</th>
                  <th class="col-md-3 col-xs-3">Bank Account Number</th>
                  <th class="col-md-3 col-xs-3">Deposit Total</th>
                  <th class="col-md-3 col-xs-3">Deposit Count</th>
                  <th class="col-md-3 col-xs-3">Withdraw Total</th>
                  <th class="col-md-3 col-xs-3">Withdraw Count</th>
                  <!--<th class="col-md-3 col-xs-3">Transaction From</th>
                  <th class="col-md-3 col-xs-3">To</th>-->
                  <th class="col-md-3 col-xs-3">Currency</th>
                  <th class="col-md-3 col-xs-3">Status</th>
                  <th class="col-md-3 col-xs-3">Sequence</th>
                  <th class="col-md-3 col-xs-3">Action</th>
              	</tr>
            </thead>
            <tbody>
            
            	<?php 				
				$getbank_account = mysqli_query($conn, "Select * from bank_account");
				if(mysqli_num_rows($getbank_account)>0)
				{
					$count=1;
					while($rowbank_acc = mysqli_fetch_assoc($getbank_account))
					{
					?>
					<tr>
                      <td><?php echo $count;?></td>
                      <td>
					  <a href="add_bank_account.php?edit_id=<?php echo $rowbank_acc['id'];?>">
					  <?php 
					  
					  $getbankname = mysqli_query($conn,"select name from bank where id = ".$rowbank_acc['bank_id']);
					  if(mysqli_num_rows($getbankname)>0)
					  {
						 $rowbank = mysqli_fetch_assoc($getbankname);
						 echo $rowbank['name'];
					  }
					  
					  ?>
                      </a>
                      </td>
                      <td><?php echo $rowbank_acc['bank_account_code'];?> </td>
                      <td><?php echo $rowbank_acc['bank_account_name'];?></td>
                      <td><?php echo $rowbank_acc['bank_account_number'];?></td>
                      
                      <?php 
					  	$bnkacc_id= $rowbank_acc['id'];
						$accstatus= $rowbank_acc['status'];	
																   
					     
					    $total_deposit_sql = "SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM transactions WHERE transactiontype = 'Deposit' AND status = 'Approve' AND bankid=$bnkacc_id UNION SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM  bank_transaction WHERE bankaccount_id=$bnkacc_id AND transaction_type IN ('TF Deposit', 'Transfer(+)', 'Other(+)')";
					  
											
					  	$transaction_result= mysqli_query($conn, $total_deposit_sql);
						while($transaction_rows= mysqli_fetch_assoc($transaction_result))
						{
							//print_r($transaction_rows);
							$total_deposit+=$transaction_rows['total_amount'];
							$deposit_count+=$transaction_rows['total_count'];
						}
						 
						$total_deposit_total+=$total_deposit;
						$total_deposit_count+=$deposit_count;
												
						$total_withdrawal_sql = "SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM transactions WHERE transactiontype = 'Withdrawal' AND status = 'Approve' AND withdrawal_bank_id=$bnkacc_id UNION SELECT SUM(amount) AS total_amount, COUNT(id) AS total_count FROM  bank_transaction WHERE bankaccount_id=$bnkacc_id AND transaction_type IN ('TF Withdrawal', 'Transfer(-)', 'Other(-)')" ;
						
						
						$transaction_res=mysqli_query($conn, $total_withdrawal_sql);
						while($trnas_rows= mysqli_fetch_assoc($transaction_res))
						{
							$total_withdrawal+=$trnas_rows['total_amount'];						
							$withdrawal_count+=$trnas_rows['total_count'];
						}
						$total_withdrawal_total+=$total_withdrawal;
						$total_withdrawal_count+=$withdrawal_count;
					  ?>
                      <td><?php echo number_format($total_deposit, '2', '.', ',');?></td>
                      <td><?php echo $deposit_count;?></td>
                      <td><?php echo number_format($total_withdrawal, '2', '.', ',');?></td>
                      <td><?php echo $withdrawal_count;?></td>                                            
                      <!--<td></td>
                      <td></td>-->
                      <td><?php echo $rowbank_acc['currency'];?></td>
                    
					  <?php 
                    if($rowbank_acc['status']=="Active")
                    {
                    ?>
                    <td style="background: #C6FFD9;text-align: center;"><?php echo $rowbank_acc['status'];?></td>  
                    <?php
                    }
                    else if($rowbank_acc['status']=="Suspended")
                    {
                    ?>  
                    <td style="background: #FFCCCC;text-align: center;"><?php echo $rowbank_acc['status'];?></td>    
                    <?php
                    }                  
                    ?>
                      <td><?php echo $count;?></td>
                      <td><i class="fa fa- ml-2"></i> <i class="fa fa-arrow-down ml-2"></i>  <a href="?delete_id=<?php echo $rowbank_acc['id'];?>" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash ml-2"></i></a></td>
                    </tr>
					<?php
					$count++;
					
					
					$total_deposit=0;
					$deposit_count=0;
					$total_withdrawal=0;						
					$withdrawal_count=0;
					}
				}
				?>
            	
            </tbody>
            <tfoot>
            	<tr>
                	<td colspan="5">Total</td>
                     <td><?php echo number_format( $total_deposit_total, '2', '.', ','); ?></td>
                      <td><?php echo $total_deposit_count; ?></td>
                      <td><?php echo number_format($total_withdrawal_total, '2', '.', ','); ?> </td>
                      <td><?php echo $total_withdrawal_count; ?></td>
                      <td colspan="6"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>
<script>
	$(document).ready(function(){
		$("#submit").click(function(){
			$(".resulttable").show();
		});
	});
</script>