<?php
session_start();
include 'config.php';

if($_SESSION['user_type'] !== 'superadmin')
{
	echo "<script>window.location.assign('home.php')</script>";	
}

if(isset($_POST['delid']) && !empty($_POST['delid']))
{	
	$deleteid=$_POST['delid'];	
	$delsql=mysqli_query($conn, "DELETE FROM `user_info` WHERE id=$deleteid");
	mysqli_query($delsql);
	
	echo json_encode(array('result1'=>'success'));
	die();	
}


$output=array();

if(isset($_POST['id']) && !empty($_POST['id']))
{
	$userid=$_POST['id'];
	$userstatus=$_POST['status'];
	
	if($userstatus=='active')
	{
		$statusupdate_sql="UPDATE `user_info` SET status='suspended' WHERE id=$userid";
		$userstatusres=mysqli_query($conn, $statusupdate_sql);			
	}
	else{
		$statusupdate_sql="UPDATE `user_info` SET status='active' WHERE id=$userid";
		$userstatusres=mysqli_query($conn, $statusupdate_sql);		
	}			
	
	ob_start();	
	$selectstatussql=mysqli_query($conn, "SELECT * FROM `user_info` WHERE id=$userid");
	$userrows=mysqli_fetch_assoc($selectstatussql);
?>	                                
       <a href="javascript:void(0);" class="changeuserstatus_<?php echo $userrows['id'];?>" onClick="changeuserstatus(<?php echo $userrows['id'];?>);" data-status="<?php echo $userrows['status'];?>" style="color:#0055ff;text-decoration: underline;">                    
        	<?php echo ucfirst($userrows['status']);?>						                        
 		</a>      	                	           
<?php               
	$contents=ob_get_contents();
	ob_get_clean();
	$output['result']='success';
	$output['data']['content']=$contents;		
}
echo json_encode($output);
exit();
?>