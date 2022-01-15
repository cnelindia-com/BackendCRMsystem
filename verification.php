<?php
include('config.php');
require "class.DetectDevice.php";
	
function get_client_ip()
{
		  
	if(getenv('HTTP_CLIENT_IP'))
	{
		$ipaddress = getenv('HTTP_CLIENT_IP');  
	}
	else if(getenv('HTTP_FORWARDED_FOR'))
	{
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');  
	}
	else if(getenv('HTTP_X_FORWARDED'))
	{
		$ipaddress = getenv('HTTP_X_FORWARDED');  
	}
	else if(getenv('HTTP_X_FORWARDED'))
	{
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');  
	}
	else if(getenv('HTTP_FORWARDED'))
	{
		$ipaddress = getenv('HTTP_FORWARDED');  
	}
	else if(getenv('REMOTE_ADDR'))
	{
		$ipaddress = getenv('REMOTE_ADDR');  
	}	
	else
	{
		$ipaddress='UNKNOWN';  
	}	  		  	  					
	return $ipaddress;
}

$client_ip_address=get_client_ip();	
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function detectdevice()
{
	$device=new DetectDevice();
	$devicetype=$device->getDeviceType();	
	
	if($devicetype=='computer')
	{
		$elitem='PC';
		return($elitem);	
	}
	if($devicetype=='mobile')
	{
		$elitem='MOBILE';
		return($elitem);	
	}
	if($devicetype=='tablet')
	{
		$elitem='TABLET';
		return($elitem);	
	}
		
}

$devicename=detectdevice();	

if(isset($_POST['login'])){
    $u_type="Incorrect User ID or Password";
    $login_date=date('Y-m-d H:i:s');
    $u=$_POST['ID'];
    $p=$_POST['password'];
    $p = md5($p);
	$gettype="select type,name,status from user_info where user_id='$u' and password='$p'";
    $update_last_login="UPDATE user_info SET last_login='$login_date' WHERE user_id='$u'";
    $result=$conn->query($gettype);
    
    if($stmt = $conn->prepare("select user_id,type from user_info where user_id=? and password=?")){
    
        $stmt->bind_param("ss",$u,$p);
        $stmt->execute();

        if($stmt->fetch()){
            $_SESSION['user']=$u;

        while($row=$result->fetch_assoc()){
            $_SESSION['user_type'] = $row['type'];
            $u_type=$_SESSION['user_type'];
            $_SESSION['user_name'] = $row['name'];
            $status = $row['status'];
        }

    }
    else{

         echo"<script>alert('Incorrect User ID or Password');</script>";
         echo"<script>window.location.assign('index.html');</script>";
            
    }
        $stmt->close();
    }
    if(isset($status)){
    if($status=='active'){       

      $status_login="Active User Login";				
	
      $result=$conn->query("INSERT into login_log value('','$u', '$client_ip_address', '$devicename', '',  '$u_type','$login_date','$status_login', '$user_agent')");

      $result=$conn->query($update_last_login);
      $_SESSION['page']='home';

       echo "<script>alert('Successfully logged in');</script>";
       echo "<script>window.location.assign('home.php');</script>";
       
      }else if($status=='suspended'){				
		
        $status_login="Suspended User Login Unsuccessful";
		
        $result=$conn->query("INSERT into login_log value('','$u', '$client_ip_address', '$devicename', '',  '$u_type','$login_date','$status_login', '$user_agent')");

        echo "<script>alert('Account already Suspended');</script>";
        session_destroy();
        echo "<script>window.location.assign('index.html');</script>";

      }}
    }

    if(isset($_GET['logout'])){
              
        session_destroy();
        echo "<script>window.location.assign('index.html');</script>";
        }
?>