<?php
$user=$_SESSION['user']; 	
			
	if(isset($_POST['add_new_deposit_transaction']))
	{					
		if($_POST['newtransaction_type']=='Deposit')
		{			
		//print_r($_POST);
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = $edit_id;
		$Transfer_Date_deposit = (isset($_POST['Transfer_Date_deposit']))?$_POST['Transfer_Date_deposit']:'';
		$hours_deposit = (isset($_POST['hours_deposit']))?$_POST['hours_deposit']:'';
		$minutes_deposit = (isset($_POST['minutes_deposit']))?$_POST['minutes_deposit']:'';
		$seconds_deposit = (isset($_POST['seconds_deposit']))?$_POST['seconds_deposit']:'';
		$Amount_deposit =(isset($_POST['Amount_deposit']))?$_POST['Amount_deposit']:'';
		$payment_method_deposit = (isset($_POST['payment_method_deposit']))?$_POST['payment_method_deposit']:'';
		$product_deposit = (isset($_POST['product_deposit']))?$_POST['product_deposit']:'';
		$BankAccount_deposit = (isset($_POST['BankAccount_deposit']))?$_POST['BankAccount_deposit']:'';
		$Reference_deposit = (isset($_POST['Reference_deposit']))?$_POST['Reference_deposit']:'';
		$bonus_amount_deposit = (isset($_POST['bonus_amount_deposit']))?$_POST['bonus_amount_deposit']:'';
		$Banktype_deposit = (isset($_POST['Banktype_deposit']))?$_POST['Banktype_deposit']:'';					
		
		//bonus transaction
		$bonus_transaction_deposit = (isset($_POST['bonus_transaction_deposit'])) ? $_POST['bonus_transaction_deposit']:'';
		
		
		$Instant_transaction_deposit =(isset($_POST['Instant_transaction_deposit']))?$_POST['Instant_transaction_deposit']:'';
		
		$remark_deposit = (isset($_POST['remark_deposit']))?$_POST['remark_deposit']:'';
		
		if(isset($_POST['Instant_transaction_deposit']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
		$insertdeposit = "INSERT INTO transactions SET
			`accountid`=$account_id,
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$Transfer_Date_deposit',
			`hours`=$hours_deposit,
			`minutes`=$minutes_deposit,
			`seconds`=$seconds_deposit,
			`amount`='$Amount_deposit',
			`payment_method`='$payment_method_deposit',
			`productid_from`=$product_deposit,
			`bankid`=$BankAccount_deposit,
			`reference_no`='$Reference_deposit',
			`bonus_promotion_id`='$Banktype_deposit',
			`bonus_amount`='$bonus_amount_deposit',
			`instant_transaction`='$Instant_transaction_deposit',
			`account_name`='',
			`bank_account_number`='',
			`withdrawal_bank_id`='',
			`productid_to`='',
			`deposit_transaction_id`='',
			`remark`='$remark_deposit',
			`status`='$status'			
		";
		if(mysqli_query($conn,$insertdeposit)==TRUE)
		{
			$deposit_transaction_id = mysqli_insert_id($conn);
			
			if($bonus_transaction_deposit == 'Bonus'){
				$insert_bonus_transaction_for_deposit_sql = "INSERT INTO transactions SET `transactiontype` = 'Bonus', `accountid` = '$account_id', `createdby` = '$user', `transferdate` = '$Transfer_Date_deposit', `hours`= '$hours_deposit', `minutes` = '$minutes_deposit', `seconds` = '$seconds_deposit', `amount` = '$bonus_amount_deposit', `productid_from` = '$product_deposit', `instant_transaction` = '$Instant_transaction_deposit', deposit_transaction_id = '$deposit_transaction_id', `bonus_promotion_id` = '$Banktype_deposit', `remark`='$remark_deposit', `status`='$status'";
				mysqli_query($conn, $insert_bonus_transaction_for_deposit_sql);
				$bonus_transaction_id = mysqli_insert_id($conn);
				
				$update_t_sql = "UPDATE transactions SET bonus_promotion_id = '$bonus_transaction_id' WHERE id = '$deposit_transaction_id'";
				mysqli_query($conn, $update_t_sql);
			}
			$success = 'Deposit Transaction added successfully.';
		}
		}
	}
	
	if(isset($_POST['add_new_withdrawal_transaction']))
	{
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = $edit_id;
		$Transfer_DateWithdrawal = (isset($_POST['Transfer_DateWithdrawal']))?$_POST['Transfer_DateWithdrawal']:'';
		$hoursWithdrawal = (isset($_POST['hoursWithdrawal']))?$_POST['hoursWithdrawal']:'';
		$minutesWithdrawal = (isset($_POST['minutesWithdrawal']))?$_POST['minutesWithdrawal']:'';
		$secondsWithdrawal = (isset($_POST['secondsWithdrawal']))?$_POST['secondsWithdrawal']:'';
		$AmountWithdrawal =(isset( $_POST['AmountWithdrawal']))?$_POST['AmountWithdrawal']:'';
		$payment_methodWithdrawal = (isset($_POST['payment_methodWithdrawal']))?$_POST['payment_methodWithdrawal']:'';
		$productWithdrawal = (isset($_POST['productWithdrawal']))?$_POST['productWithdrawal']:'';
		$BankAccountWithdrawal = (isset($_POST['BankAccountWithdrawal']))?$_POST['BankAccountWithdrawal']:'';
		$bankaccoutnumberWithdrawal = (isset($_POST['bankaccoutnumberWithdrawal']))?$_POST['bankaccoutnumberWithdrawal']:'';
		$ReferenceWithdrawal = (isset($_POST['ReferenceWithdrawal']))?$_POST['ReferenceWithdrawal']:'';
		
		$Instant_transactionWithdrawal = (isset($_POST['Instant_transactionWithdrawal']))?$_POST['Instant_transactionWithdrawal']:'';
		
		$remarkWithdrawal = (isset($_POST['remarkWithdrawal']))?$_POST['remarkWithdrawal']:'';
		$withdrawalaccountWithdrawal = (isset($_POST['withdrawalaccountWithdrawal']))?$_POST['withdrawalaccountWithdrawal']:'';
		$account_name = (isset($_POST['account_name']))?$_POST['account_name']:'';				
		
		if(isset($_POST['Instant_transactionWithdrawal']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
	 	$insertWithdrawal = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$Transfer_DateWithdrawal',
			`hours`=$hoursWithdrawal,
			`minutes`=$minutesWithdrawal,
			`seconds`=$secondsWithdrawal,
			`amount`='$AmountWithdrawal',
			`payment_method`='$payment_methodWithdrawal',
			`productid_from`='$productWithdrawal',
			`bankid`='$BankAccountWithdrawal',
			`reference_no`='$ReferenceWithdrawal',
			`bonus_promotion_id`='',
			`bonus_amount`='',
			`instant_transaction`='$Instant_transactionWithdrawal',
			`account_name`='$account_name',
			`bank_account_number`='$bankaccoutnumberWithdrawal',
			`withdrawal_bank_id`='$withdrawalaccountWithdrawal',
			`productid_to`='',
			`deposit_transaction_id`='',
			`remark`='$remarkWithdrawal',
			`status`='$status'			
		";
		if(mysqli_query($conn,$insertWithdrawal)==TRUE)
		{
			$success = 'Withdrawal Transaction added successfully.';
		}
	}
	
	if(isset($_POST['add_new_transfer_transaction']))
	{
		
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = $edit_id;
		$AmountTransfer = (isset($_POST['AmountTransfer']))?$_POST['AmountTransfer']:'';
		$productfromTransfer = (isset($_POST['productfromTransfer']))?$_POST['productfromTransfer']:'';
		$producttoTransfer = (isset($_POST['producttoTransfer']))?$_POST['producttoTransfer']:'';		
		$Instant_transactionTransfer = (isset($_POST['Instant_transactionTransfer']))?$_POST['Instant_transactionTransfer']:'';			
		$remarkTransfer = (isset($_POST['remarkTransfer']))?$_POST['remarkTransfer']:'';
		
		if(isset($_POST['Instant_transactionTransfer']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}				
		
		$transferdate = date('Y-m-d');
	  	$hours = date('H');
		$minutes = date('i');
		$seconds = date('s');
		
	  	$insertTransfer = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$transferdate',
			`hours`='$hours',
			`minutes`='$minutes',
			`seconds`='$seconds',
			`amount`='$AmountTransfer',
			`payment_method`='',
			`productid_from`='$productfromTransfer',
			`bankid`='',
			`reference_no`='',
			`bonus_promotion_id`='',
			`bonus_amount`='',
			`instant_transaction`='$Instant_transactionTransfer',
			`account_name`='',
			`bank_account_number`='',
			`withdrawal_bank_id`='',
			`productid_to`='$producttoTransfer',
			`deposit_transaction_id`='',
			`remark`='$remarkTransfer',
			`status`='$status'			
		";
		if(mysqli_query($conn,$insertTransfer)==TRUE)
		{
			$success = 'Transfer Transaction added successfully.';
		}
		
	}
	
	if(isset($_POST['add_new_bonusnew_transaction']))
	{
		
		$transaction_type =(isset($_POST['newtransaction_type']))?$_POST['newtransaction_type']:'';
		$account_id = $edit_id;
		$Transfer_DateBonusnew = (isset($_POST['Transfer_DateBonusnew']))?$_POST['Transfer_DateBonusnew']:'';
		$hoursBonusnew = (isset($_POST['hoursBonusnew']))?$_POST['hoursBonusnew']:'';
		$minutesBonusnew = (isset($_POST['minutesBonusnew']))?$_POST['minutesBonusnew']:'';
		$secondsBonusnew = (isset($_POST['secondsBonusnew']))?$_POST['secondsBonusnew']:'';
		$AmountBonusnew = (isset($_POST['AmountBonusnew']))?$_POST['AmountBonusnew']:'';
		$productBonusnew = (isset($_POST['productBonusnew']))?$_POST['productBonusnew']:'';
		$DepositTransactionIdBonusnew = (isset($_POST['DepositTransactionIdBonusnew']))?$_POST['DepositTransactionIdBonusnew']:'';
		$bonustypeBonusnew = (isset($_POST['bonustypeBonusnew']))?$_POST['bonustypeBonusnew']:'';	
		$Instant_transactionBonusnew = (isset($_POST['Instant_transactionBonusnew']))?$_POST['Instant_transactionBonusnew']:'';	
		$remarkBonusnew = (isset($_POST['remarkBonusnew']))?$_POST['remarkBonusnew']:'';		
		
		if(isset($_POST['Instant_transactionBonusnew']))
		{
			$status='Approve';	
		}
		else
		{
			$status='NewTransaction';	
		}
		
		$insertBonus = "INSERT INTO transactions SET
			`accountid`='$account_id',
			`transactiontype`='$transaction_type',
			`createdby`='$user',
			`transferdate`='$Transfer_DateBonusnew',
			`hours`=$hoursBonusnew,
			`minutes`=$minutesBonusnew,
			`seconds`=$secondsBonusnew,
			`amount`='$AmountBonusnew',
			`payment_method`='',
			`productid_from`='$productBonusnew',
			`bankid`='',
			`reference_no`='',
			`bonus_promotion_id`='$bonustypeBonusnew',
			`bonus_amount`='',
			`instant_transaction`='$Instant_transactionBonusnew',
			`account_name`='',
			`bank_account_number`='',
			`withdrawal_bank_id`='',
			`productid_to`='',
			`deposit_transaction_id`='$DepositTransactionIdBonusnew',
			`remark`='$remarkBonusnew',
			`status`='$status'			
		";
		if(mysqli_query($conn,$insertBonus)==TRUE)
		{
			$success = 'Bonus Transaction added successfully.';
		}
		
	}

	
?> 

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

<style>

.bonusdiv,.DepositTransactionId
{
	display:none;
}

</style>

<?php	
  if(isset($_POST['add_new_deposit_transaction']) || isset($_POST['add_new_withdrawal_transaction']) || isset($_POST['add_new_transfer_transaction']) || isset($_POST['add_new_bonusnew_transaction']))
  {
?>
  <script>
    setTimeout(function(){
      $("a[href='#NewTransaction']").trigger('click');
    }, 1000);
  </script>  
<?php				
  }
?>

<div class="row" id="subtabs">
    <div class="col-sm-12">
        <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
            <legend style="background:#fff; width: auto; padding: 4px;">Transaction Type</legend>
            <div class="form-group">
              <div class="col-sm-10">                         
                    <ul>
                        <li><a class="btn btn-outline-dark transactiontypebutton" href="#Deposit">Deposit</a></li>
                        <li><a class="btn btn-outline-dark transactiontypebutton" href="#Withdrawal">Withdrawal</a></li>
                        <li><a class="btn btn-outline-dark transactiontypebutton" href="#Transfer">Transfer</a></li>
                        <li><a class="btn btn-outline-dark transactiontypebutton" href="#Bonusnew">Bonus</a></li>
                    </ul>
              </div>
            </div>
        </fieldset>
        
        <br/>
        
        <div id="Deposit">
        
        <form method="post" id="deposittransaction">
        
            <fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">            	                
                
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                 <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                 
	                <div class="col-sm-9">
                    <input type="text" name="username_deposit" value="<?php echo $username;?>" readonly/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_Date_deposit" value="<?php echo date('Y-m-d');?>"/>
                        
                        <select name="hours_deposit">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<24;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>" <?php if($i == date('H')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="minutes_deposit">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('i')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="seconds_deposit">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('s')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="Amount_deposit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Payment Method</label>
                  <div class="col-sm-9">
                        <input type="radio" name="payment_method_deposit" value="ATM"/> ATM
                        &nbsp;
                        <input type="radio" name="payment_method_deposit" value="Online"/> Online
                        &nbsp;
                        <input type="radio" name="payment_method_deposit" value="Cash"/> Cash
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="product_deposit">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bank Account</label>
                  <div class="col-sm-9">
                        <select name="BankAccount_deposit">
                            <?php 
                            $get_bank = "select * from bank_account";
                            $result = mysqli_query($conn,$get_bank);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['bank_account_code']. ' - '.$row['bank_account_name'].'['.$row['bank_account_number'].']';?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Reference No</label>
                  <div class="col-sm-9">
                        <input type="text" name="Reference_deposit" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="bonus_transaction_deposit" id="bonus_transaction_deposit" value="Bonus"/>&nbsp;Bonus
                  </div>
                </div>
                <div class="form-group bonusdiv">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus Amount</label>
                  <div class="col-sm-9">
                        <input type="text" name="bonus_amount_deposit" value=""/>
                  </div>
                </div>
                <div class="form-group bonusdiv">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus Type</label>
                  <div class="col-sm-9">
                         <select name="Banktype_deposit">
                            <?php 
                            $get_promotion = "select * from promotion";
                            $result = mysqli_query($conn,$get_promotion);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transaction_deposit" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remark_deposit"></textarea>
                  </div>
                </div>
                
               <input type="hidden" name="newtransaction_type" id="newtransaction_type" value="Deposit"/>
                            
            </fieldset>
                        
            <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="add_new_deposit_transaction" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="account_page();">
            </div>
                
            </form>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Deposit" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        
        
                
        <div id="Withdrawal">
        
        	<form method="post" id="withdrawalform">
        	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                        <input type="text" name="usernameWithdrawal" value="<?php echo $username;?>" readonly/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_DateWithdrawal" value="<?php echo date('Y-m-d');?>"/>
                        
                        <select name="hoursWithdrawal">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<24;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>" <?php if($i == date('H')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="minutesWithdrawal">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('i')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="secondsWithdrawal">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('s')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">User Bank</label>
                  <div class="col-sm-9">
                        <select name="BankAccountWithdrawal">
                            <?php 
							$bank_first = '';
                            $get_bank = "select * from bank";
                            $result = mysqli_query($conn,$get_bank);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
									if($count==1)
									{
										$bank_first = $row['id'];
									}
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <?php 
				$bankdetail='';
				$accountnumber = '';
				$accountname = '';
				$select_sql=mysqli_query($conn,"SELECT * From account WHERE id=".$edit_id);
				if(mysqli_num_rows($select_sql)>0)
				{
					$bankdetail=$get_account['bankdetail'];
				}
				if($bankdetail!='')
				{
					$bankdetail = (array)json_decode($bankdetail);
					foreach($bankdetail as $keybank => $accRemark)
					{
						foreach($accRemark->account as $key => $account)
						{
							$accountnumber = $account;
							$accountname = $accRemark->remark[$key];
						}
					}
				}
				?>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Account Name</label>
                  <div class="col-sm-9">
                        <input type="text" name="account_name" value="<?php echo $accountname;?>"/>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bank Account Number</label>
                  <div class="col-sm-9">
                        <input type="number" name="bankaccoutnumberWithdrawal" value="<?php echo $accountnumber;?>"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="AmountWithdrawal" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Payment Method</label>
                  <div class="col-sm-9">
                        <input type="radio" name="payment_methodWithdrawal" value="ATM"/> ATM
                        &nbsp;
                        <input type="radio" name="payment_methodWithdrawal" value="Online"/> Online
                        &nbsp;
                        <input type="radio" name="payment_methodWithdrawal" value="Cash"/> Cash
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="productWithdrawal">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Withdrawal Account</label>
                  <div class="col-sm-9">
                        <select name="withdrawalaccountWithdrawal">
                            <?php 
                            $get_bank = "select * from bank_account";
                            $result = mysqli_query($conn,$get_bank);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['bank_account_code']. ' - '.$row['bank_account_name'].'['.$row['bank_account_number'].']';?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Reference No</label>
                  <div class="col-sm-9">
                        <input type="text" name="ReferenceWithdrawal" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transactionWithdrawal" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remarkWithdrawal"></textarea>
                  </div>
                </div>   
             <input type="hidden" name="newtransaction_type" id="newtransaction_type" value="Withdrawal"/>
                         
                
            </fieldset>
            <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="add_new_withdrawal_transaction" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="account_page();">
            </div>
            </form>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Withdrawal" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        
        
        
        
        <div id="Transfer">
        
        <form method="post" id="transferform">
               
       		<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                        <input type="text" name="usernameTransfer" value="<?php echo $username;?>" readonly/>
                  </div>
                </div>
               
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="AmountTransfer" value=""/>
                  </div>
                </div>
               
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="productfromTransfer">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products (To)</label>
                  <div class="col-sm-9">
                        <select name="producttoTransfer">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transactionTransfer" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remarkTransfer"></textarea>
                  </div>
                </div>                            
            <input type="hidden" name="newtransaction_type" id="newtransaction_type" value="Transfer"/>

            </fieldset>
            <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="add_new_transfer_transaction" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="account_page();">
            </div>
            </form>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Transfer" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div>-->
        </div>
        
        
        
        <div id="Bonusnew">
        
        	<form method="post" id="bonusnewform">            
        	<fieldset style="border: solid 1px #a0a0a0; padding: 2px 30px;">
                <legend style="background:#fff; width: auto; padding: 4px;">Transaction Data</legend>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Username</label>
                  <div class="col-sm-9">
                        <input type="text" name="usernameBonusnew" value="<?php echo $username;?>" readonly/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Transfer Date</label>
                  <div class="col-sm-9">
                        <input type="date" name="Transfer_DateBonusnew" value="<?php echo date('Y-m-d');?>"/>
                        
                        <select name="hoursBonusnew">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<24;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>" <?php if($i == date('H')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="minutesBonusnew">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('i')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select> :
                        <select name="secondsBonusnew">
                            <option value="00">00</option>    
                            <?php 
                            for($i=1;$i<60;$i++)
                            {
                                if($i<10)
                                {
                                    $i = '0'.$i;
                                }
                                ?>
                                <option value="<?php echo $i;?>"  <?php if($i == date('s')){ echo 'selected';}?>><?php echo $i;?></option> 
                                <?php
                            }
                            ?>                    
                        </select>
                  </div>
                </div>
             
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Amount</label>
                  <div class="col-sm-9">
                        <input type="number" name="AmountBonusnew" value=""/>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Products</label>
                  <div class="col-sm-9">
                        <select name="productBonusnew">
                        <?php 
                        $sqlproductname = "SELECT id,name from products";
                        $productname = mysqli_query($conn,$sqlproductname);
                        if(mysqli_num_rows($productname)>0)
                        {		
                            while($row = mysqli_fetch_assoc($productname))
                            {
                        ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php 
                            }
                        }else
                        {
                            echo "No products";
                        }	
                        ?>
                        </select>
                  </div>
                </div>
              	<div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Bonus Type</label>
                  <div class="col-sm-9">
                        <select name="bonustypeBonusnew">
                        <?php 
                            $get_promotion = "select * from promotion";
                            $result = mysqli_query($conn,$get_promotion);
                            if(mysqli_num_rows($result)>0)
                            {
                                $count=1;
                                while($row = mysqli_fetch_assoc($result))
                                {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php }
                            }?>
                        </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Deposit</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Deposit_transactionBonusnew" id="Deposit_transactionBonusnew" value="bonus"/>&nbsp;Deposit
                  </div>
                </div>
                <div class="form-group DepositTransactionId">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Deposit Transaction Id</label>
                  <div class="col-sm-9">
                        <input type="text" name="DepositTransactionIdBonusnew" value=""/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Instant Transaction</label>
                  <div class="col-sm-9">
                        <input type="checkbox" name="Instant_transactionBonusnew" value="1"/>&nbsp;Instant Transaction
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" style="margin-left: 10px;padding-top: unset;">Remark</label>
                  <div class="col-sm-9">
                        <textarea name="remarkBonusnew"></textarea>
                  </div>
                </div>                            
             <input type="hidden" name="newtransaction_type" id="newtransaction_type" value="Bonus"/>

            </fieldset>
            <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="add_new_bonusnew_transaction" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="account_page();">
            </div>
            </form>
            <!-- <div class="btn_bar1" style="bottom:0px;text-align: center;">
                <input class="btn1" type="submit" name="Bonusnew" value="Submit">&nbsp;
                <input id="backLink1" class="btn1" type="button" name="sbtt" value="Back" onclick="history.go(-1);">
            </div> -->
        </div>        
    </div>       
</div>