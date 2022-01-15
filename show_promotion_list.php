<?php
session_start();

$_SESSION['page']='promotion';

include('header.php');

if($_SESSION['user_type']!="superadmin"){
  echo "<script>window.location.assign('home.php');</script>";

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>

      <!--<script>

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


 
<div id="sc8" class="tabcontent" style="display: block;">
	<a href="show_promotion_list.php" id="sc8_1" class="actives">Promotion</a>
</div>
  <div class="container" >
  <div class="filternav">
  <?php 
  $filter = $_POST['aflt'];
 
  ?>
	<h2>Promotion</h2>
	<form name="spbFormTop" id="spbFormTop" method="POST">
					<input type="hidden" name="action" value="show"><input type="hidden" name="mdl" value="promotion">
                    <table>
                    	<tbody>
                    		<tr>
								<th> 
                                    <select name="aflt" id="istatus"><option value="">All</option>
                                        <option value="Active"  <?php if($filter=='Active'){echo "Selected";}?>>Active</option>
                                        <option value="Suspended"  <?php if($filter=='Suspended'){echo "Selected";}?>>Suspended</option>
                                    </select> 
                                    <input type="submit" class="btn1" name="submit" value="Search">  &nbsp; 
                                    <a href="new_promotion.php"  class="btn1">NEW</a>
                                    <input name="exportexcel" type="submit" class="btn1" value="Export Report">  &nbsp;&nbsp;
                                </th>
                              </tr>
                       	 </tbody>
                    </table>
     </form>
</div>


<span class="counter pull-right"></span>
<table class="table table-hover table-bordered results" id="table2excel">
  <thead style="background-color: #ff720b;">
    <tr>
      <th>NO</th>
      <th class="col-md-3 col-xs-3">Name</th>
      <th class="col-md-3 col-xs-3">Promotion Code</th>
      <th class="col-md-3 col-xs-3">Transaction From</th>
      <th class="col-md-3 col-xs-3">To</th>
      <th class="col-md-3 col-xs-3">Status</th>
     <!-- <th class="col-md-3 col-xs-3">Sequence</th>-->
      <th class="col-md-3 col-xs-3">Action</th>
      </tr>
  </thead>
<tbody>
  <?php 
  
  if(!empty($filter)){
	     $sqla="SELECT * From promotion WHERE status='$filter'";
        $results=$conn->query($sqla);
        if ($results->num_rows > 0) {
          while($rows = $results->fetch_assoc()) {
			  $csv_data[] = array($row['id'], $row['name'], $row['promotion_code'], $row['transaction_from'], $row['transaction_to'], $row['status'], $row['sequence']);
			  ?>
	  <tr class="noExl">
      <td scope="row"><?php echo $rows['id']; ?></td>
      <td><a href="editpromotion.php?id=<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></a></td>
      <td><?php echo $rows['promotion_code']; ?></td>
      <td><?php echo $rows['transaction_from']; ?></td>
      <td><?php echo $rows['transaction_to']; ?></td>
      <?php if($rows['status'] == 'Active'){ ?>
      <td style="background:#00ff7f; color:black;"><?php echo $rows['status']; }?></td>
      <?php if($rows['status'] == 'Suspended'){ ?>
      <td style="background:#ffc1cc; color:black;"><?php echo $rows['status']; }?></td>
     <!-- <td><?php echo $rows['sequence']; ?></td>-->
      <td align="left">
		<a class="delet_proction" id="myModal" onclick="return confirm('Are you sure you want to delete?');" href="delete_promotion.php?id=<?php echo $row['id']; ?>"><i class="fa fa-close"></i></a>
       <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Some text in the Modal..</p>
  </div>

</div>
	 </td>
     </tr>
    <?php
		  }
		  }
  
		
	  }else{
        $sql="SELECT * From promotion";
        $result=$conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
			  $csv_data[] = array($row['id'], $row['name'], $row['promotion_code'], $row['transaction_from'], $row['transaction_to'], $row['status'], $row['sequence']);
  ?>
    <tr class="noExl">
      <td scope="row"><?php echo $row['id']; ?></td>
      <td><a style="text-decoration: underline;color:#0055ff;" href="editpromotion.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
      <td><?php echo $row['promotion_code']; ?></td>
      <td><?php echo $row['transaction_from']; ?></td>
      <td><?php echo $row['transaction_to']; ?></td>
      <?php if($row['status'] == 'Active'){?>
      <td style="background:#00ff7f; color:black;"><?php echo $row['status']; }?></td>
       <?php if($row['status'] == 'Suspended'){?>
      <td style="background:#ffc1cc; color:black;"><?php echo $row['status']; }?></td>
      <!--<td><?php echo $row['sequence']; ?></td>-->
      <td align="left">
		<a class="delet_proction" id="myModal" onclick="return confirm('Are you sure you want to delete?');" href="delete_promotion.php?id=<?php echo $row['id']; ?>"><i class="fa fa-close"></i></a>
        <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Some text in the Modal..</p>
  </div>

</div>
	 </td>
    </tr>
   <?php 
		  }
		}
	  }
	?>	

 </tbody>
</table>
</div>
</div>
<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>



<?php
if(isset($_POST['exportexcel'])){
$filename = 'Promoction.csv';
	$file = fopen($filename,"w");
	foreach ($csv_data as $line){

				fputcsv($file,$line);
			}

fclose($file);
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   

         $url = "https://";   

    else  

         $url = "http://";   

    // Append the host(domain name, ip) to the URL.   

   		$url.= $_SERVER['HTTP_HOST'];

	 $open_url = $url.'/BackendCRMsystem/'.$filename;

	 //file_get_contents('download-file.php');

	 

	 ?>

	 <script>

	 var url = "<?php echo $open_url ?>";

	 //location.replace(url);

	  //window.open(url, "datacsvWindow5", "width=800,height=600");

	  window.open(url);

	</script>
    <?php
}