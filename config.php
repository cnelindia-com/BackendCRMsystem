<?php
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$pieces = parse_url($actual_link);
$domain = isset($pieces['host']) ? $pieces['host'] : '';
	
//include('auth.php');

if($domain=='stage1.readyforyourreview.com')
{
	$servername = "localhost";
	$username = "ccrdskmy_bcs_1";
	$password = "QZOVAIPZeH(V";
	$dbname = "ccrdskmy_backendcromsystem_1";
}
else if($domain=='stage2.readyforyourreview.com')
{		
	$servername = "localhost";
	$username = "ccrdskmy_bcs_2";
	$password = "3MC){%Z}5bFr";
	$dbname = "ccrdskmy_backendcromsystem_2";
}
else if($domain='stage3.readyforyourreview.com')
{
	$servername = "localhost";
	$username = "ccrdskmy_bcs_3";
	$password = "+jRhkbM(v@?X";
	$dbname = "ccrdskmy_backendcromsystem_3";
}
else if($domain=='stage4.readyforyourreview.com')
{
	$servername = "localhost";
	$username = "ccrdskmy_bcs_4";
	$password = "uf~v4i6*JbJG";
	$dbname = "ccrdskmy_backendcromsystem_4";
}
else if($domain=='stage5.readyforyourreview.com')
{
	$servername = "localhost";
	$username = "ccrdskmy_bcs_5";
	$password = "W7=B%&WJ+}E?";
	$dbname = "ccrdskmy_backendcromsystem_5";
}

else if($domain=='stage6.readyforyourreview.com')
{
	$servername = "localhost";
	$username = "ccrdskmy_bcs_6";
	$password = "Ka*qo^k{F^lO";
	$dbname = "ccrdskmy_backendcromsystem_6";
	
}

/*echo $servername."<br>";
echo $username."<br>";
echo $password."<br>";
echo $dbname."<br>";
die();*/
$conn = new mysqli($servername, $username, $password, $dbname);	
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

?>