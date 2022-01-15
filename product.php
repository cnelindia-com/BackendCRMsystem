<?php
session_start();

$_SESSION['page']='product';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}
//print_r($_SESSION);
$user_name=$_SESSION['user_name'];

/*
$user=$_SESSION['user'];
$search="";
$searchkey='';
if(isset($_POST['search'])){

    $searchkey=$_POST['searchkey'];
    $search=" WHERE (name LIKE '%$searchkey%' or user_id LIKE '%$searchkey%' or phone_no LIKE '%$searchkey%')";
}

$csv_data[] = array("No", "Username", "User Code", "Full Name", "Email", "Phone", "IP", "Registered On", "Last Active", "Status");*/
$success='';
if(isset($_POST['submitIN']))
{
	$product_name = $_POST['productnamein'];
	$Amount = $_POST['Amount'];
	$Remark = $_POST['Remark'];
	$date = date('Y-m-d H:i:s');
	$created_by = $user_name;
	
	$insert_cash_in = "INSERT INTO product_credit_balance SET `product_name`='$product_name',`created_by`='$created_by',`cash_in`='$Amount',`cash_out`='0.00',`Remark`='$Remark',`created_date`='$date'"; 
	if(mysqli_query($conn,$insert_cash_in)==TRUE)
	{
		$success="Cash IN added successfully.";
	}
}
if(isset($_POST['submitOUT']))
{
	$product_name = $_POST['productnameout'];
	$Amount = $_POST['Amount'];
	$Remark = $_POST['Remark'];
	$date = date('Y-m-d H:i:s');
	$created_by = $user_name;
	
	$insert_cash_in = "INSERT INTO product_credit_balance SET `product_name`='$product_name',`created_by`='$created_by',`cash_in`='0.00',`cash_out`='$Amount',`Remark`='$Remark',`created_date`='$date'"; 
	if(mysqli_query($conn,$insert_cash_in)==TRUE)
	{
		$success="Cash OUT added successfully.";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

<style>
.popupDiv-overlay {
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
	z-index: 99;
	position: absolute;
	top: 0;
	left: 0;
	margin-top: 138px;	
}
.popupDiv-overlay{
	display:none;
}
.cashin,.cashout {
	border: 2px solid #000;
	display: block;
	background-color: #eee;	
}
.cashin,.cashout{
	display:none;
}
.cashin .top,.cashout .top {
	padding: 2px 5px 0 5px;
	display: block;
	height: 29px;
	border-bottom: 1px solid #000;
	font-size: 16px;
	font-weight:600;
}
.cashin .cashInDiv,.cashout .cashInDiv{
	font-size: 14px;
	padding:10px;
}
.cashin td,.cashout td {
    font-family: "微软雅黑", Arial, Helvetica, sans-serif;
    font-size: 14px;
    cursor: default;
    white-space: nowrap;
	background:#eee;
	padding: 0 15px 2px 15px;
}
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
	color:black;
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
	
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.modal-content
{
	padding:unset;
	width: 100%;
}
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
	<a href="product.php" id="sc8_1" class="actives">Product</a>
    <span>|</span>
   <!-- <a href="#" id="sc8_1">Online User</a>
    <span>|</span>
    <a href="#" id="sc8_1">VIP</a>
    <span>|</span>-->
    <a href="product_credit_log.php" id="sc8_1">Credit Balance Log</a>
</div>

<div class="container">

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
        <h2>Products</h2>
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
                        <a href="add_product.php"  class="btn1">NEW</a>
                        <input name="exportexcelbank" type="submit" class="btn1" value="Export Report">  &nbsp;&nbsp;
                    </th>
                  </tr>
             </tbody>
        </table>
        
	</form>
        
	</div>    

    <br/>
    <br/>
    <div class="resulttable" style="">
    
        <span class="counter pull-right"></span>
        <table class="table table-hover table-bordered results" id="table2excel" style="width: 60%;">
            <thead style="background-color: #ff720b;">
                <tr>
                  <th>No</th>
                  <th class="col-md-3 col-xs-3">Name</th>
                 <!-- <th class="col-md-3 col-xs-3">Demo Account</th>-->
                  <th class="col-md-3 col-xs-3">Product Type</th>
                  <th class="col-md-3 col-xs-3">Min Bet</th>
                  <th class="col-md-3 col-xs-3">Current Credit Balance </th>
                  <!--<th class="col-md-3 col-xs-3">Maintenance</th>-->
                  <th class="col-md-3 col-xs-3">Status</th>
                  <th class="col-md-3 col-xs-3">Sequence</th>
                  <th class="col-md-3 col-xs-3">Action</th>
              	</tr>
            </thead>
            <tbody>
            
            	<?php 
				$get_product = mysqli_query($conn,"select * from products");
				if(mysqli_num_rows($get_product)>0)
				{
					$count=1;
					while($rowproduct = mysqli_fetch_assoc($get_product))
					{
					?>
                    <tr>
                      <td><?php echo $count;?></td>
                      <td><a href="add_product.php?edit_id=<?php echo $rowproduct['id'];?>"><?php echo $rowproduct['name'];?></a></td>
                      <!--<td><?php //echo $rowproduct['demo_account'];?></td>-->
                      <td><?php echo $rowproduct['product_type'];?></td>
                      <td><?php echo $rowproduct['min_per_bet'];?></td>
                      <td>
                      
                      <?php
					  	$produ_name=$rowproduct['name'];
					  	$current_credit_sql= "SELECT SUM(CASE WHEN(product_name='$produ_name') THEN cash_in ELSE 0 END) AS cashin, SUM(CASE WHEN(product_name='$produ_name') THEN cash_out ELSE 0 END) AS cashout, product_credit_balance.* FROM `product_credit_balance` WHERE product_name='".$rowproduct['name']."' GROUP BY product_name";
						
						$current_credit_res= mysqli_query($conn, $current_credit_sql);
						$current_credit_rows= mysqli_fetch_assoc($current_credit_res);
																															
						$prodsql="SELECT SUM(CASE WHEN (transactiontype='Deposit') THEN amount ELSE 0 END) AS produ_deposit, SUM(CASE WHEN (transactiontype='Withdrawal') THEN amount ELSE 0 END) AS produ_withdrawal FROM `transactions` WHERE productid_from='".$rowproduct['id']."' AND status='Approve'";
							//echo $prodsql;
							$prodres= mysqli_query($conn, $prodsql);
							$prodrow= mysqli_fetch_assoc($prodres);
							
						if($current_credit_rows['product_name']==$produ_name){																			
																		
							$current_credit_balance=($current_credit_rows['cashin']+$prodrow['produ_deposit'])-($current_credit_rows['cashout']+$prodrow['produ_withdrawal']);	
							
							echo $current_credit_balance;
						}					
						else{
							$current_credit_balance= $prodrow['produ_deposit']-$prodrow['produ_withdrawal'];
							echo $current_credit_balance;
						}
												
					  ?>
                      
                      </td>
                     <!-- <td>
                        <label class="switch">
                          <input type="checkbox" checked>
                          <span class="slider round"></span>
                        </label>
                      </td>-->
                      
						<?php 
                        if($rowproduct['status']=="Active")
                        {
                        ?>
                      <td style="background: #C6FFD9;text-align: center;"><?php echo $rowproduct['status'];?></td>  
                        <?php
                        }
						else if($rowproduct['status']=="Suspended")
						{
                        ?>  
                      <td style="background: #FFCCCC;text-align: center;"><?php echo $rowproduct['status'];?></td>    
                        <?php
                        }                  
						?>
                                      
                      <td><?php echo $count;?></td>
                      <td> <a href="#" class="cashinbtn" data-id="<?php echo $rowproduct['name'];?>">Cash In</a> <span>|</span> <a href="#" data-id="<?php echo $rowproduct['name'];?>" class="cashoutbtn">Cash Out</a> <span>|</span> <i class="fa fa-arrow-down ml-2"></i> <i class="fa fa-arrow-down ml-2"></i></td>
                    </tr>
                    
                    <?php 
					$count++;
					}
				}
				?>
            	
            </tbody>
        </table>
    </div>
</div>


	<div class="popupDiv-overlay"></div>
		<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -141.5px; margin-top: -74px;"class="cashin">
        
			<div class="top">
                <span class="productname_span"></span>
                <button type="button" class="close closebtn" data-dismiss="modal" aria-label="Close" style="font-weight: 600;font-size: 16px;">
                	<span>[X]</span>
                </button>
            </div>
            
    <div class="cashInDiv">
    	<form method="post" name="cashinForm">            		
    
			<table>
       			<tbody>
                
                <tr>
                    <th><span>Products</span></th>
                    <td>:</td>
                    <td><span class="producth4name"></span></td>
                </tr>
                  
                <tr>
                    <th><span>Amount</span></th>
                    <td>:</td>
                    <td><input type="number" class="" name="Amount" id="Amount"></td>
                </tr>
                
                <tr>
                    <th><span>Remark</span></th>
                    <td>:</td>
                    <td>
                    	<input type="text" class="" name="Remark" id="Remark" placeholder="enter remark" style="    width: 157px;">					 					</td>
                </tr>
                
                <tr>
                    <td colspan="3" style="text-align:center;">
                    	<button type="submit" class="" name="submitIN">Submit</button>
                    	<button type="button" class="closebtn" data-dismiss="modal">Close</button>
                    </td>
                </tr>
        </tbody>
        </table>
        
        <input type="hidden" name="productnamein" class="productnamein" value="">
        <input type="hidden" name="ipid" value="">
        </form>
        
	</div>
</div>
            
</form>
<div class="popupDiv-overlay"></div>
<div style="position: absolute; z-index: 100; top: 50%; left: 50%; margin-left: -141.5px; margin-top: -74px;"class="cashout">
        
			<div class="top">
                <span class="productname_span"></span>
                <button type="button" class="close closebtn" data-dismiss="modal" aria-label="Close" style="font-weight: 600;font-size: 16px;">
                	<span>[X]</span>
                </button>
            </div>
            
    <div class="cashInDiv">
    	<form method="post">            		
    
			<table>
       			<tbody>
                
                <tr>
                    <th><span>Products</span></th>
                    <td>:</td>
                    <td><span class="producth4nameout"></span></td>
                </tr>
                  
                <tr>
                    <th><span>Amount</span></th>
                    <td>:</td>
                    <td><input type="number" class="" name="Amount" id="Amount"></td>
                </tr>
                
                <tr>
                    <th><span>Remark</span></th>
                    <td>:</td>
                    <td>
                    	<input type="text" class="" name="Remark" id="Remark" placeholder="enter remark" style="    width: 157px;">					 					</td>
                </tr>
                
                <tr>
                    <td colspan="3" style="text-align:center;">
                    	<button type="submit" class="" name="submitOUT">Submit</button>
                    	<button type="button" class="closebtn" data-dismiss="modal">Close</button>
                    </td>
                </tr>
        </tbody>
        </table>
        
        <input type="hidden" name="productnameout" class="productnameout" value="">
        <input type="hidden" name="ipid" value="">
        </form>
        
	</div>
</div>


<!--<div class="modal cashout" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closebtn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="post">
      <div class="modal-body">
      		<h3>Cash In - <span class="productname_spanout"></span></h3>
           
            <input type="hidden" name="productnameout" class="productnameout" value=""/>
            	<div class="form-group">
                    <h4>Products</h4> &nbsp; &nbsp; <h4 class="producth4nameout"></h4>
                </div>
                <div class="form-group">
                	<div class="col-md-3">
                	<label for="Amount" class="col-form-label">Amount : </label></div>
                    <div class="col-md-9">
                     <input type="text" class="form-control" name="Amount" id="Amount"></div>
                </div>
                <div class="form-group">
                	<div class="col-md-3">
                    <label for="Remark" class="col-form-label">Remark : </label></div>
                    
                    <div class="col-md-9">
                     <input type="text" class="form-control" name="Remark" id="Remark"></div>
                </div>
			
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="submitOUT">Submit</button>
        <button type="button" class="btn btn-secondary closebtn" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>-->
</body>
</html>
<script>
$(document).ready(function(){
	$(".cashinbtn").click(function(){
		var productname=  $(this).attr('data-id');
		$(".productnamein").val(productname);
		$(".productname_span").text("Cash In - "+productname);
		$(".producth4name").text(productname);
		$(".cashin").show();
		$(".popupDiv-overlay").show();
	});	
	
	$(".cashoutbtn").click(function(){
		var productname=  $(this).attr('data-id');
		$(".productnameout").val(productname);
		$(".productname_span").text("Cash Out - "+productname);
		$(".producth4nameout").text(productname);
		$(".cashout").show();
		$(".popupDiv-overlay").show();
	});	
	$(".closebtn").click(function(){
		$(".cashin").hide();	
		$(".cashout").hide();			
		$(".popupDiv-overlay").hide();		
	});	
});
</script>