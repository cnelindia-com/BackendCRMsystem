<?php
include('config.php');
$my_id=$_SESSION['user'];
$dateandtime=date('Y-m-d H:i:s');
//user part------------------------------------------------------------------------------------
if(isset($_POST['create_user'])){
    $name=$_POST['name'];
    $phone_no=$_POST['phone_no'];
    $email=$_POST['email'];
    $type_user=$_POST['type_user'];
    $user_id=$_POST['user_id'];
    $password=$_POST['password'];
    $status=$_POST['status'];
    $remark=$_POST['remark'];

    $num=0;
    $checkagent="select user_id from user_info";
          $result=$conn->query($checkagent);
         if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()){            
           $user_id_check=$row['user_id'];

        if($user_id_check==$user_id){
         $num++;
         echo "<script>alert('User already exist......')</script>";
         echo "<script>window.history.go(-1);</script>";
         break;
         
      }
    }}
    if($num==0){
        $sql="insert into user_info values ('$user_id','$password','$type_user','$name','$phone_no','$email','$status','$remark','')";
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New User......')</script>";
        echo "<script>window.location.assign('create_user.php');</script>";
    }
}

if(isset($_POST['edit_user'])){
    $id_user=$_POST['id_user'];
    $info="SELECT * FROM user_info WHERE user_id='$id_user'";

        $result=$conn->query($info);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {

             if(isset($_POST['name'])){
             $name=$_POST['name'];}
             else{ $name = $row['name'];}

             if(isset($_POST['phone_no']))
             $phone_no=$_POST['phone_no'];
             else{ $phone_no = $row['phone_no'];}

             if(isset($_POST['email']))
             $email=$_POST['email'];
             else{ $email = $row['email'];}

             if(isset($_POST['type_user']))
             $type_user=$_POST['type_user'];
             else{ $type_user = $row['type_user'];}

             if(isset($_POST['user_id']))
             $user_id=$_POST['user_id'];
             else{ $user_id = $row['user_id'];}

             if(isset($_POST['password']))
             $password=$_POST['password'];
             else{ $password = $row['password'];}

             if(isset($_POST['status']))
             $status=$_POST['status'];
             else{ $status = $row['status'];}

             if(isset($_POST['remark']))
             $remark=$_POST['remark'];
             else{ $remark = $row['remark'];}

    }}

    $editUser="UPDATE user_info SET name='".$name."',phone_no='".$phone_no."'
    ,email='".$email."',type='".$type_user."',user_id='".$user_id."',password='".$password."',remark='".$remark."',status='".$status."'
     WHERE user_id='".$id_user."'";
    
    $result=$conn->query($editUser);

    echo "<script>alert('Complete edit User......')</script>";
    echo "<script>window.history.go(-1);</script>";

}
//user part------------------------------------------------------------------------------------
//bank part------------------------------------------------------------------------------------
if(isset($_POST['create_bank_account'])){
    $bank=$_POST['bank'];
    $short_code=$_POST['short_code'];
    $account_name=$_POST['account_name'];
    $account_no=$_POST['account_no'];
    $status=$_POST['status'];
    $remark=$_POST['remark'];

        $sql="insert into bank_info values ('','$bank','$short_code','$account_name','$account_no','$status','$remark')";
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New Bank Account......')</script>";
        echo "<script>window.location.assign('bank_account.php');</script>";
    
}
if(isset($_POST['edit_bank_account'])){
    $id_bank=$_POST['id_bank'];
    $info="SELECT * FROM bank_info WHERE id='$id_bank'";

        $result=$conn->query($info);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {

             if(isset($_POST['bank'])){
             $bank=$_POST['bank'];}
             else{ $bank = $row['bank'];}

             if(isset($_POST['short_code'])){
             $short_code=$_POST['short_code'];}
             else{ $short_code = $row['short_code'];}

             if(isset($_POST['account_no'])){
             $account_no=$_POST['account_no'];}
             else{ $account_no = $row['account_no'];}

             if(isset($_POST['account_name'])){
             $account_name=$_POST['account_name'];}
             else{ $account_name = $row['account_name'];}

             if(isset($_POST['status'])){
             $status=$_POST['status'];}
             else{ $status = $row['status'];}

             if(isset($_POST['remark'])){
             $remark=$_POST['remark'];}
             else{ $remark = $row['remark'];}

    }}

    $editbank="UPDATE bank_info SET bank='".$bank."',short_code='".$short_code."',account_name='".$account_name."'
    ,account_no='".$account_no."',remark='".$remark."',status='".$status."'
     WHERE id='".$id_bank."'";
    
    $result=$conn->query($editbank);

    echo "<script>alert('Complete edit Bank Account......')</script>";
    echo "<script>window.history.go(-1);</script>";

}
if(isset($_GET['suspendbank'])){
    $bank_id=$_GET['suspendbank'];
    $updatestatus="UPDATE bank set status='suspended' where id='$bank_id'";

    $result=$conn->query($updatestatus);

    echo "<script>alert('Complete SUSPENDED')</script>";
    echo "<script>window.location.assign('bank.php');</script>";
}
if(isset($_GET['activebank'])){
    $bank_id=$_GET['activebank'];
    $updatestatus="UPDATE bank set status='active' where id='$bank_id'";

    $result=$conn->query($updatestatus);

    echo "<script>alert('Complete ACTIVE')</script>";
    echo "<script>window.location.assign('bank.php');</script>";

}
if(isset($_POST['new_bank'])){
    $name=$_POST['bank_name'];
    $short_name=$_POST['short_name'];
    $status=$_POST['status'];

        $sql="insert into bank values ('','$name','$short_name','$status')";
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New Bank......')</script>";
        echo "<script>window.location.assign('bank.php');</script>";

}
if(isset($_POST['edit_bank'])){
    $id_bank=$_POST['id_bank'];

    $info="SELECT * FROM bank WHERE id='$id_bank'";

    $result=$conn->query($info);
     if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {

    if(isset($_POST['bank_name'])){
        $bank_name=$_POST['bank_name'];}
        else{ $bank_name = $row['name'];}

        if(isset($_POST['short_name'])){
        $short_name=$_POST['short_name'];}
        else{ $short_name = $row['short_name'];}

        if(isset($_POST['status'])){
        $status=$_POST['status'];}
        else{ $status = $row['status'];}
     }}

        $sql="UPDATE bank set name='$bank_name',short_name='$short_name',status='$status' where id='$id_bank'";
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete edit the Bank......')</script>";
        echo "<script>window.location.assign('bank.php');</script>";

}
//bank part------------------------------------------------------------------------------------
//product part------------------------------------------------------------------------------------
if(isset($_POST['create_product'])){
    $name=$_POST['name'];
    $type_product=$_POST['type_product'];
    $status=$_POST['status'];
    $remark=$_POST['remark'];

        $sql="insert into product_info values ('','$name','$type_product','$status','$remark')";
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New Product......')</script>";
        echo "<script>window.location.assign('add_product.php');</script>";
    
}
if(isset($_POST['edit_product'])){
    $id_product=$_POST['id_product'];
    $info="SELECT * FROM product_info WHERE id='$id_product'";

        $result=$conn->query($info);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {

             if(isset($_POST['name'])){
             $name=$_POST['name'];}
             else{ $name = $row['name'];}

             if(isset($_POST['type_product']))
             $type_product=$_POST['type_product'];
             else{ $type_product = $row['type_product'];}

             if(isset($_POST['status']))
             $status=$_POST['status'];
             else{ $status = $row['status'];}

             if(isset($_POST['remark']))
             $remark=$_POST['remark'];
             else{ $remark = $row['remark'];}

    }}

    $editproduct="UPDATE product_info SET name='".$name."',type_product='".$type_product."'
    ,remark='".$remark."',status='".$status."'
     WHERE id='".$id_product."'";
    
    $result=$conn->query($editproduct);

    echo "<script>alert('Complete edit Product......')</script>";
    echo "<script>window.history.go(-1);</script>";

}
if(isset($_POST['cash_in'])){
    $user_id=$_SESSION['user'];
    $id_product=$_POST['id_product'];
    $product_name=$_POST['product_name'];
    $amount=$_POST['amount'];
    $remark=$_POST['remark'];
    $create_time=date('Y-m-d H:i:s');

    $insert_cash_in="INSERT into product_credit value('','$id_product','$product_name','in','$amount','$create_time','$user_id','$remark')";
    $result=$conn->query($insert_cash_in);

    echo "<script>window.location.assign('product.php');</script>";
}
if(isset($_POST['cash_out'])){
    $user_id=$_SESSION['user'];
    $id_product=$_POST['id_product'];
    $product_name=$_POST['product_name'];
    $amount=$_POST['amount'];
    $remark=$_POST['remark'];
    $create_time=date('Y-m-d H:i:s');

    $insert_cash_out="INSERT into product_credit value('','$id_product','$product_name','out','$amount','$create_time','$user_id','$remark')";
    $result=$conn->query($insert_cash_out);

    echo "<script>window.location.assign('product.php');</script>";
}
//product part------------------------------------------------------------------------------------
//customer part------------------------------------------------------------------------------------
if(isset($_POST['create_customer'])){
    $name=$_POST['name'];
    $phone_no=$_POST['phone_no'];
    $email=$_POST['email'];
    $user_id=$_POST['user_id'];
    $remark=$_POST['remark'];
    $register_date=date('Y-m-d H:i:s');

    $admin_id=$_SESSION['user'];

    $num=0;
    $checkagent="select user_id from customer_info";
          $result=$conn->query($checkagent);
         if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()){            
           $user_id_check=$row['user_id'];

        if($user_id_check==$user_id){
         $num++;
         echo "<script>alert('Customer ID already exist......')</script>";
         echo "<script>window.history.go(-1);</script>";
         break;
         
      }
    }}
    if($num==0){
        $sql="insert into customer_info values ('$user_id','$name','$phone_no','$email','$register_date','$remark','$admin_id')";
        $result=$conn->query($sql);
        
        
    

    $get_product_id="select id,name from product_info";
          $result2=$conn->query($get_product_id);
         if ($result2->num_rows > 0) {
             while($row = $result2->fetch_assoc()){      
                 $product_id=$row['id'];
                 $product_name=$row['name'];

                 if($_POST[$product_id]!=""){
                 $customer_product_id=$_POST[$product_id];
                 
                    $insert_customer_product_id="insert into customer_product_info value('','$product_id','$product_name','$user_id','$customer_product_id')";
                    $result=$conn->query($insert_customer_product_id);
                }   

    }}
    echo "<script>alert('Complete add New Customer......')</script>";
    echo "<script>window.location.assign('create_customer.php');</script>";
    }
}

if(isset($_POST['edit_customer'])){
    $id_customer=$_POST['id_customer'];
    $info="SELECT * FROM customer_info WHERE user_id='$id_customer'";

        $result=$conn->query($info);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {

             if(isset($_POST['name'])){
             $name=$_POST['name'];}
             else{ $name = $row['name'];}

             if(isset($_POST['phone_no'])){
             $phone_no=$_POST['phone_no'];}
             else{ $phone_no = $row['phone'];}

             if(isset($_POST['email'])){
             $email=$_POST['email'];}
             else{ $email = $row['email'];}

             if(isset($_POST['remark'])){
             $remark=$_POST['remark'];}
             else{ $remark = $row['remark'];}

    }}

    $edit_customer="UPDATE customer_info SET name='$name',phone='$phone_no',email='$email',remark='$remark' WHERE user_id='$id_customer'";
    $result=$conn->query($edit_customer);

    $get_p_id="SELECT id,name FROM product_info";
    $result2=$conn->query($get_p_id);
         if ($result2->num_rows > 0) {
         while($row = $result2->fetch_assoc()) {
            $product_id=$row['id'];
            $product_name=$row['name'];

            $customer_product_id=$_POST[$product_id];

            $check_c_p_id_01="SELECT * FROM customer_product_info WHERE customer_id='$id_customer' and product_id='$product_id'";
            $result3=$conn->query($check_c_p_id_01);
            if ($result3->num_rows > 0) {
                while($row = $result3->fetch_assoc()) {

                    $update_customer_product_id="UPDATE customer_product_info SET customer_product_id='$customer_product_id' 
                    WHERE product_id='$product_id' and customer_id='$id_customer'";
                    $result4=$conn->query($update_customer_product_id); 
                
                }}else if($customer_product_id!=""){
                    $insert_customer_product_id="insert into customer_product_info value('','$product_id','$product_name','$id_customer','$customer_product_id')";
                    $result4=$conn->query($insert_customer_product_id);
                }                  

         }}
         echo "<script>alert('Complete edit Customer......')</script>";
         echo "<script>window.history.go(-1);</script>";
}
//customer part------------------------------------------------------------------------------------
//transaction part------------------------------------------------------------------------------------
if(isset($_POST['create_transaction_deposit'])){
    $user_id=$_POST['user_id'];
    $type="Deposit";
    $amount=$_POST['amount'];
    $product_id=$_POST['product'];
    $payment_type=$_POST['payment_type'];

    $bank_id=$_POST['bank'];
    $remark=$_POST['remark'];

    $transfer_date=$_POST['transfer_date'];

    $create_by=$_SESSION['user'];

    $status="processing";
    /*
    processing
    approve
    reject
    */
    $get_bank_detail="SELECT short_code,account_name,account_no from bank_info Where id='$bank_id'";

    $result2=$conn->query($get_bank_detail);
    if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
        $short_code=$row['short_code'];
       $account_name=$row['account_name'];
       $account_no=$row['account_no'];

       $bank_detail=$account_name." (".$account_no.")";
    }}

    $get_product_detail="SELECT name from product_info Where id='$product_id'";

    $result3=$conn->query($get_product_detail);
    if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
       $name=$row['name'];
    }}


    $num=0;
    $checkcustomer="SELECT user_id from customer_info WHERE user_id='$user_id'";
          $result=$conn->query($checkcustomer);
         if ($result->num_rows > 0) {

    }else{
        $num++;
        echo "<script>alert('User does not exist......')</script>";
        echo "<script>window.history.go(-1);</script>";
        }

    if($num==0){

        $c_p_id="SELECT customer_product_id FROM customer_product_info WHERE product_id='$product_id' and customer_id='$user_id'";
        $c_p_id_result=$conn->query($c_p_id);
        if ($c_p_id_result->num_rows > 0) {
          while($row = $c_p_id_result->fetch_assoc()) {
            $customer_product_id=$row['customer_product_id'];
          }}else{$customer_product_id="None";}

          $product_detail=$name." (".$customer_product_id.")";
 
        $sql="insert into transaction_info values ('','$user_id','$type','$amount','$product_id','$product_detail'
        ,'$payment_type','$bank_id','$short_code','$bank_detail','','','$remark','$create_by','$transfer_date','$status','','')";
 
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New Transaction [DEPOSIT]......')</script>";
        echo "<script>window.location.assign('home.php');</script>";
    }
}
if(isset($_POST['create_transaction_withdraw'])){
    $user_id=$_POST['user_id'];
    $type="Withdraw";
    $amount=$_POST['amount'];
    $product_id=$_POST['product'];
    $payment_type=$_POST['payment_type'];

    $bank_user=$_POST['bank_user'];
    $c_account_no=$_POST['c_account_no'];
    $c_account_name=$_POST['c_account_name'];
    $customer_detail=$c_account_name." (".$c_account_no.")";

    $bank_id=$_POST['bank'];
    $remark=$_POST['remark'];

    $transfer_date=$_POST['transfer_date'];

    $create_by=$_SESSION['user'];

    $status="processing";
    /*
    processing
    approve
    reject
    */
    $get_bank_detail="SELECT short_code,account_name,account_no from bank_info Where id='$bank_id'";

    $result2=$conn->query($get_bank_detail);
    if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
        $short_code=$row['short_code'];
       $account_name=$row['account_name'];
       $account_no=$row['account_no'];

       $bank_detail=$account_name." (".$account_no.")";
    }}

    $get_product_detail="SELECT name from product_info Where id='$product_id'";

    $result3=$conn->query($get_product_detail);
    if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
       $name=$row['name'];
    }}


    $num=0;
    $checkcustomer="SELECT user_id from customer_info WHERE user_id='$user_id'";
          $result=$conn->query($checkcustomer);
         if ($result->num_rows > 0) {

    }else{
        $num++;
        echo "<script>alert('User does not exist......')</script>";
        echo "<script>window.history.go(-1);</script>";
        }

    if($num==0){

        $c_p_id="SELECT customer_product_id FROM customer_product_info WHERE product_id='$product_id' and customer_id='$user_id'";
        $c_p_id_result=$conn->query($c_p_id);
        if ($c_p_id_result->num_rows > 0) {
          while($row = $c_p_id_result->fetch_assoc()) {
            $customer_product_id=$row['customer_product_id'];
          }}else{$customer_product_id="None";}

          $product_detail=$name." (".$customer_product_id.")";
 
        $sql="insert into transaction_info values ('','$user_id','$type','$amount','$product_id','$product_detail'
        ,'$payment_type','$bank_id','$short_code','$bank_detail','$bank_user','$customer_detail','$remark','$create_by','$transfer_date','$status','','')";
 
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New Transaction [WITHDRAW]......')</script>";
        echo "<script>window.location.assign('home.php');</script>";
    }
}
if(isset($_POST['create_transaction_bonus'])){
    $user_id=$_POST['user_id'];
    $type="Bonus";
    $amount=$_POST['amount'];
    $product_id=$_POST['product'];

    $remark=$_POST['remark'];

    $transfer_date=$_POST['transfer_date'];

    $create_by=$_SESSION['user'];

    $status="processing";
    /*
    processing
    approve
    reject
    */

    $get_product_detail="SELECT name from product_info Where id='$product_id'";

    $result3=$conn->query($get_product_detail);
    if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
       $name=$row['name'];
    }}

    $num=0;
    $checkcustomer="SELECT user_id from customer_info WHERE user_id='$user_id'";
          $result=$conn->query($checkcustomer);
         if ($result->num_rows > 0) {

    }else{
        $num++;
        echo "<script>alert('User does not exist......')</script>";
        echo "<script>window.history.go(-1);</script>";
        }

    if($num==0){

        $c_p_id="SELECT customer_product_id FROM customer_product_info WHERE product_id='$product_id' and customer_id='$user_id'";
        $c_p_id_result=$conn->query($c_p_id);
        if ($c_p_id_result->num_rows > 0) {
          while($row = $c_p_id_result->fetch_assoc()) {
            $customer_product_id=$row['customer_product_id'];
          }}else{$customer_product_id="None";}

          $product_detail=$name." (".$customer_product_id.")";
 
        $sql="insert into transaction_info values ('','$user_id','$type','$amount','$product_id','$product_detail'
        ,'','','','','','','$remark','$create_by','$transfer_date','$status','','')";
 
        $result=$conn->query($sql);
        
        echo "<script>alert('Complete add New Transaction [BONUS]......')</script>";
        echo "<script>window.location.assign('home.php');</script>";
    }
}

if(isset($_POST['approve_transaction'])){
    $id_transaction=$_POST['id_transaction'];

    $amount=$_POST['amount'];

    if(isset($_POST['bank'])){
        $bank_id=$_POST['bank'];
        
        $get_bank_detail="SELECT short_code,account_name,account_no from bank_info Where id='$bank_id'";

        $result2=$conn->query($get_bank_detail);
        if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $short_code=$row['short_code'];
           $account_name=$row['account_name'];
           $account_no=$row['account_no'];
    
           $bank_detail=$account_name." (".$account_no.")";
        }}
    }else{$bank_id="";$short_code="";$bank_detail="";}

    $remark=$_POST['remark'];

    $checkstatus="SELECT status,handler FROM transaction_info WHERE id='$id_transaction'";
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
      $update="UPDATE transaction_info set amount='$amount',bank_id='$bank_id',bank_name='$short_code',bank_detail='$bank_detail',remark='$remark',status='approve',handler='$my_id',processing_date='$dateandtime' WHERE id='$id_transaction'";
      $result=$conn->query($update);
      echo "<script>alert('Successfully approve the transaction')</script>";
      echo "<script>window.location.assign('transaction_detail.php?history=$id_transaction');</script>";
    }
  }}else{
    echo "<script>alert('Transaction has been cancelled')</script>";
      echo "<script>window.location.assign('home.php');</script>";
  }
}

if(isset($_POST['reject_transaction'])){
    $id_transaction=$_POST['id_transaction'];

    $amount=$_POST['amount'];

    if(isset($_POST['bank'])){
        $bank_id=$_POST['bank'];
        
        $get_bank_detail="SELECT short_code,account_name,account_no from bank_info Where id='$bank_id'";

        $result2=$conn->query($get_bank_detail);
        if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $short_code=$row['short_code'];
           $account_name=$row['account_name'];
           $account_no=$row['account_no'];
    
           $bank_detail=$account_name." (".$account_no.")";
        }}
    }else{$bank_id="";$short_code="";$bank_detail="";}

    $remark=$_POST['remark'];

    $checkstatus="SELECT status,handler FROM transaction_info WHERE id='$id_transaction'";
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
      $update="UPDATE transaction_info set amount='$amount',bank_id='$bank_id',bank_name='$short_code',bank_detail='$bank_detail',remark='$remark',status='reject',handler='$my_id',processing_date='$dateandtime' WHERE id='$id_transaction'";
      $result=$conn->query($update);
      echo "<script>alert('Successfully reject the transaction')</script>";
      echo "<script>window.location.assign('transaction_detail.php?history=$id_transaction');</script>";
    }
  }}else{
    echo "<script>alert('Transaction has been cancelled')</script>";
      echo "<script>window.location.assign('home.php');</script>";
  }
}

if(isset($_POST['update_transaction'])){
    $id_transaction=$_POST['id_transaction'];

    $amount=$_POST['amount'];

    if(isset($_POST['bank'])){
        $bank_id=$_POST['bank'];
        
        $get_bank_detail="SELECT short_code,account_name,account_no from bank_info Where id='$bank_id'";

        $result2=$conn->query($get_bank_detail);
        if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $short_code=$row['short_code'];
           $account_name=$row['account_name'];
           $account_no=$row['account_no'];
    
           $bank_detail=$account_name." (".$account_no.")";
        }}
    }else{$bank_id="";$short_code="";$bank_detail="";}

    $remark=$_POST['remark'];

    $status=$_POST['status'];

      $update="UPDATE transaction_info set amount='$amount',bank_id='$bank_id',bank_name='$short_code',bank_detail='$bank_detail',remark='$remark',status='$status' WHERE id='$id_transaction'";
      $result=$conn->query($update);
      echo "<script>alert('Successfully UPDATE the transaction')</script>";
      echo "<script>window.location.assign('transaction_detail.php?".$_SESSION['t_detail']."=$id_transaction');</script>";
    
}
//transaction part------------------------------------------------------------------------------------
?>