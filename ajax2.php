<?php
session_start();
include 'config.php';

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

$output = array();
if(isset($_POST['daily_date']) && !empty($_POST['daily_date'])){
	$daily_date = $_POST['daily_date'];
	$productschecked = $_POST['productschecked'];
	$productschecked_implode = implode(',', $productschecked);
	
	$productres=mysqli_query($conn, "SELECT * FROM `products` WHERE id IN($productschecked_implode)");
	$productres_numrows = mysqli_num_rows($productres);
	
	$row1countmonthp = 1;
	ob_start();
	while($productrows= mysqli_fetch_assoc($productres))
	{
		
		$product_id = $productrows['id'];

		$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND productid_from = '$product_id' AND transferdate = '$daily_date'";
		$t1_query = mysqli_query($conn, $t1_sql);
		$t1_row = mysqli_fetch_assoc($t1_query);
		$deposit_amount = $t1_row['deposit'];
		
		$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND productid_from = '$product_id' AND transferdate = '$daily_date'";
		$t2_query = mysqli_query($conn, $t2_sql);
		$t2_row = mysqli_fetch_assoc($t2_query);
		$bonus_amount = $t2_row['bonus'];
		
		$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND productid_from = '$product_id' AND transferdate = '$daily_date'";
		$t3_query = mysqli_query($conn, $t3_sql);
		$t3_row = mysqli_fetch_assoc($t3_query);
		$withdrawal_amount = $t3_row['withdrawal'];
		
		$winloss = $deposit_amount - $withdrawal_amount;
		
		if($deposit_amount == 0 && $bonus_amount == 0 && $withdrawal_amount == 0){
			continue;
		}
		?>
		<tr>
		  <?php 
		  if($row1countmonthp == 1){
		  ?>							  
		  <td style="vertical-align: middle;" class="dailytbfirsttd" rowspan=""><?php echo date('d/m/Y', strtotime($daily_date)); ?></td>
		  <?php
		  }
		  ?>
		  <td><?php echo $productrows['name'];?></td>
		  <td><?php echo number_format($deposit_amount, 2);?></td>
		  <td><?php echo number_format($bonus_amount, 2);?></td>
		  <td><?php echo number_format($withdrawal_amount, 2);?></td>
		  <td><?php echo number_format($winloss, 2);?></td>
		</tr>
		<?php
		$row1countmonthp++;
	}
	

	$content = ob_get_contents();
	ob_get_clean();
	
	$output['result'] = 'success';
	$output['data']['content'] = $content;
}

else if(isset($_POST['daily_monthly']) && !empty($_POST['daily_monthly'])){
	$daily_monthly = $_POST['daily_monthly'];
	$daily_year = $_POST['year'];
	
	$productschecked = $_POST['productschecked'];
	$productschecked_implode = implode(',', $productschecked);
	
	$get_dates_of_month_sql = "SELECT DISTINCT(transferdate) AS mydate FROM transactions WHERE status = 'Approve' AND transactiontype IN('Deposit', 'Withdrawal', 'Bonus') AND MONTH(transferdate) = '$daily_monthly' AND YEAR(transferdate) = '$daily_year'";
	
	$get_dates_of_month_query = mysqli_query($conn, $get_dates_of_month_sql);
	$alldatacount = array();
	ob_start();
	while($get_dates_of_month_row = mysqli_fetch_assoc($get_dates_of_month_query)){
		$mydate = $get_dates_of_month_row['mydate'];
		
		
		$productres=mysqli_query($conn, "SELECT * FROM `products` WHERE id IN($productschecked_implode)");
		$productres_numrows = mysqli_num_rows($productres);
		
		$row1countmonthp = 1;
		$eachalldatacount = array();
		while($productrows= mysqli_fetch_assoc($productres))
		{
			
			$product_id = $productrows['id'];

			$t1_sql = "SELECT SUM(amount) AS deposit FROM transactions WHERE status = 'Approve' AND transactiontype = 'Deposit' AND productid_from = '$product_id' AND transferdate = '$mydate'";
			$t1_query = mysqli_query($conn, $t1_sql);
			$t1_row = mysqli_fetch_assoc($t1_query);
			$deposit_amount = $t1_row['deposit'];
			
			$t2_sql = "SELECT SUM(amount) AS bonus FROM transactions WHERE status = 'Approve' AND transactiontype = 'Bonus' AND productid_from = '$product_id' AND transferdate = '$mydate'";
			$t2_query = mysqli_query($conn, $t2_sql);
			$t2_row = mysqli_fetch_assoc($t2_query);
			$bonus_amount = $t2_row['bonus'];
			
			$t3_sql = "SELECT SUM(amount) AS withdrawal FROM transactions WHERE status = 'Approve' AND transactiontype = 'Withdrawal' AND productid_from = '$product_id' AND transferdate = '$mydate'";
			$t3_query = mysqli_query($conn, $t3_sql);
			$t3_row = mysqli_fetch_assoc($t3_query);
			$withdrawal_amount = $t3_row['withdrawal'];
			
			$winloss = $deposit_amount - $withdrawal_amount;
			
			if($deposit_amount == 0 && $bonus_amount == 0 && $withdrawal_amount == 0){
				continue;
			}
			
			$eachalldatacount[] =  $productrows['name'];
			?>
			<tr class="daily_row_month_<?php echo date('dmY', strtotime($mydate)); ?>">
			  <?php 
			  if($row1countmonthp == 1){
				  
			  ?>							  
			  <td style="vertical-align: middle;" class="dailymohnthtbfirsttd" rowspan=""><?php echo date('d/m/Y', strtotime($mydate)); ?></td>
			  <?php
			  }
			  ?>
			  <td><?php echo $productrows['name'];?></td>
			  <td><?php echo number_format($deposit_amount, 2);?></td>
			  <td><?php echo number_format($bonus_amount, 2);?></td>
			  <td><?php echo number_format($withdrawal_amount, 2);?></td>
			  <td><?php echo number_format($winloss, 2);?></td>
			</tr>
			<?php
			$row1countmonthp++;
		}
		
		$alldatacount['daily_row_month_'.date('dmY', strtotime($mydate))] = $eachalldatacount;
	
	}
	
	$content = ob_get_contents();
	ob_get_clean();
	
	$output['result'] = 'success';
	$output['data']['content'] = $content;
	$output['data']['alldatacount'] = $alldatacount;
	
}
echo json_encode($output);
exit();
?>