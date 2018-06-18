<?php
 function deletepayment()
 {
  global $wpdb;
 
             if(isset($_POST['paymentdelete'])) {
            $emp_id = $_POST['paymentdelete']; 
            $ref_id = $_POST['ref_id'] ;
            foreach($emp_id as $did){
              	$delete = $wpdb->query("DELETE FROM wp_payments WHERE referral_paid !='Y' AND id=".$did);   
            }
           
           	
           	  if($delete){
			    echo "<script type=\"text/javascript\">
						alert(\"Record deleted successfully!\");
							window.location='admin.php?page=viewsingle&reffralid=".$ref_id."'
					</script>";
		     }else{
		         
		          echo "<script type=\"text/javascript\">
						alert(\"You cannot Delete this records.\");
					window.location='admin.php?page=viewsingle&reffralid=".$ref_id."'
					</script>";
		     }
          
            }
}

 function viewsingle_reffral(){
       global $wpdb;
	      $sql = "SELECT * FROM wp_referrals where id=".$_GET['reffralid'];
	      $result = $wpdb->get_results($sql) or die(mysql_error());
		  $crm_id = $result[0]->crm_id;
		  $sqlc = "SELECT * FROM wp_payments where crm_id='$crm_id'";		 $sqlco = "SELECT count(*) as data_count FROM wp_payments where crm_id='$crm_id'";				   $resultpayment_sqlco = $wpdb->get_results($sqlco) or die(mysql_error());
		if($resultpayment_sqlco[0]->data_count >0){		$resultpayment = $wpdb->get_results($sqlc) or die(mysql_error());
		}	    		
		   if(isset($_POST['edit_payment'])){
 $p_sms = $_POST['sms_sent'];   
 $p_id = $_POST['pay_id'];   
 $referral_paid_date = $_POST['referral_paid_date'];   
 $referral_paid = $_POST['referral_paid'];   
 $reffralid = $_POST['reffralid'];   
 $update = $wpdb->query("UPDATE wp_payments SET 
 sms_sent = '$p_sms',
 referral_paid_date = '$referral_paid_date',
 referral_paid = '$referral_paid'
 WHERE id= $p_id");
   if (!$update) {
          $error = 1;
          echo $error;
        }
        else {
           echo "<script type=\"text/javascript\">
						alert(\"Updated successfully!\");
						window.location='admin.php?page=viewsingle&reffralid=".$reffralid."'	
					</script>";
        }
		  
		   }
 ?>
 
 <div class="container">
  
        <div class="col-md-3 col-lg-3 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

          <div class="panel panel-info">
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>CRM_Id:</td>
                        <td><?php echo $result[0]->crm_id ?></td>
                      </tr>
                      <tr>
                        <td>First_Name:</td>
                        <td><?php echo $result[0]->first_name ?></td>
                      </tr>
                      <tr>
                        <td>Mobile Number:</td>
                        <td><?php echo $result[0]->mobile_number ?></td>
                      </tr>
                   
                        <tr>
                       <tr>
                        <td>Convert or Remind</td>
                        <td><?php echo $result[0]->convert_or_remind ?></td>
                      </tr>
                        <tr>
                        <td>Reminder</td>
                        <td><?php echo $result[0]->reminder ?></td>
                      </tr>
                      <tr>
                        <td>Referral Allow</td>
                        <td><?php echo $result[0]->referral_allow ?></td>
                      </tr>
                      
                           
                      </tr>
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
              
            
          </div>
        </div>
      </div>
	  
	<h3>Referrals Payments</h3> 
<a href="javascript:void(0)" style="float:right;" id="paydelbtn" class="btn btn-danger">Delete</a>
<a href="admin.php?page=addpayments&referralid=<?php echo $result[0]->id?>" style="float:right;" class="btn btn-info">Add New Payments</a>
   <form action="admin.php?page=deletepay" id="deletepayrowform1" method="POST">
 <table style="font-size:12px;" id="exampleuserpayment" class="table table-bordered table-hover" cellspacing="0" width="100%">

            <input type="hidden" name="deletepayrow" value="deletepayrow"> 
             <input type="hidden" name="ref_id" value="<?php echo $result[0]->id ?>"> 
              <input type="hidden" id="checkval" name="checkval[]" value=""> 
   <thead>
	<tr>
	 <th scope="col" class="manage-column sortable desc">#</th>
         <th scope="col" class="manage-column sortable desc">CRM ID</th>
         <th scope="col" class="manage-column sortable desc">Payment Id</th>
         <th scope="col" class="manage-column sortable desc">Payment Amt</th>
         <th scope="col" class="manage-column sortable desc">Payment Date</th>
         <th scope="col" class="manage-column sortable desc">SMS Sent</th>
         <th scope="col" class="manage-column sortable desc">Referral Paid</th>
         <th scope="col" class="manage-column sortable desc">Referral Paid Date</th>
        

    </tr>
 </thead>
   <tbody>
           
            
    <?php if($resultpayment_sqlco[0]->data_count >0){	
    foreach($resultpayment as $key=>$value){
    ?>
    <tr>
   
       <td><input type="checkbox" class="form" name="paymentdelete[]" value="<?php echo $value->id;?>"></td>
        <td><?php echo $value->crm_id;?></td>
        <td><a href="admin.php?page=addpayments&edit=1&editpay=<?php echo $value->id;?>"><?php echo $value->payment_id;?></a></td>

        <td class="simple-table-manager-list-all-odd"><?php echo $value->payment_amount;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->payment_date;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->sms_sent;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->referral_paid;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->referral_paid_date;?></td>
      
       
   </tr>
  
     <?php }	 			}	 ?>
     
 </tbody>

</table>
 </form>
 <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#exampleuserpayment').DataTable(); 
    $('#paydelbtn').click(function(){ 
var len = $('[name="paymentdelete[]"]:checked').length;
if(len < 1){
alert('Please check delete row');
}else{

if (window.confirm('Do You really want to delete?'))
{
 $('#deletepayrowform1').submit();
}
else
{
  return false;
}	


}
        });
        
    } );
</script>   
 <?php
 }
  function payment_add() { 
	global $wpdb;

  if(isset($_POST['add_payment'])){
	$post_crm = $_POST['crm_id'] ;
	 $post_entryfirst = array(
 'payment_id' => $_POST['payment_id'],
 'crm_id' => $_POST['crm_id'],
 'payment_amount' => $_POST['payment_amount'],
 'payment_date' => $_POST['payment_date'],
 'sms_sent' => 'N',
 'referral_paid' => 'N',
 'referral_paid_date' => NULL, 
 'referral_allow' => 'Y'
 );
 
  $csql = "SELECT count(*) as count1 FROM wp_payments where crm_id=".$post_crm;
	      $cresult = $wpdb->get_results($csql) or die(mysql_error());
if($cresult[0]->count1==0){
		
 $convert_date = date('Y-m-d');
 
 $update = $wpdb->query("UPDATE wp_referrals SET 
 convert_or_remind = 'Y',
 convert_date = '$convert_date'
 WHERE crm_id= $post_crm");
   if (!$update) {
          $error = 1;
          echo $error;
        }
        else {
          echo "update Success";
        }
	
		  
   if ($wpdb->insert('wp_payments', $post_entryfirst) === FALSE) {
          $error = 1;
          echo $error;
        }
        else {
           echo "<script type=\"text/javascript\">
						alert(\"Payment added Successfully!\");
							
					</script>";
        }	
	
}else{
			  
   if ($wpdb->insert('wp_payments', $post_entryfirst) === FALSE) {
          $error = 1;
          echo $error;
        }
        else {
          echo "<script type=\"text/javascript\">
						alert(\"Payment added Successfully!\");
							
					</script>";
        }
}

		
  }	
  if(isset($_GET['referralid'])){
   $sql = "SELECT * FROM wp_referrals where id=".$_GET['referralid'];
	      $result = $wpdb->get_results($sql) or die(mysql_error());
		  $crm_id = $result[0]->crm_id;
  }	
 
 ?>
	<div class="container">
    <div class="row">
 <div class="col-md-6">  
<?php if($_GET['edit']==1){
  if(isset($_GET['editpay'])){
   $sql = "SELECT * FROM wp_payments where id=".$_GET['editpay'];
	      $result = $wpdb->get_results($sql) or die(mysql_error());
		  $crm_id = $result[0]->crm_id;
		  
		   $sql11 = "SELECT * FROM wp_referrals where crm_id=".$crm_id;
	      $resultrrrr = $wpdb->get_results($sql11) or die(mysql_error());
		  
  }	 
	?> 
<div class="wrap">
<h1>Edit Payment</h1>
<form action="admin.php?page=viewsingle&reffralid=<?php echo $resultrrrr[0]->id;; ?>" method="post">
  <input type="hidden" name="edit_payment" value="edit_payment">
  <input type="hidden" name="reffralid" value="<?php echo $resultrrrr[0]->id;; ?>">
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">CRM ID</label>
  <div class="col-10">
   <input class="form-control" name="pay_id" type="hidden" value="<?php echo $result[0]->id; ?>" >
    <input class="form-control" name="crm_id" type="text"
	value="<?php echo $crm_id; ?>" readonly>
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">CRM Payment ID</label>
  <div class="col-10">
    <input class="form-control" name="payment_id" type="text"
	value="<?php echo $result[0]->payment_id; ?>" readonly id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Referral Amt</label>
  <div class="col-10">
    <input class="form-control" name="referral_amt" type="text"
	value=""  id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-number-input" class="col-2 col-form-label">SMS Sent</label>
  <div class="col-10">
    <input class="form-control" <?php if($result[0]->sms_sent=='Y'){echo "checked"; } ?> value="Y" type="radio" name="sms_sent" id="example-number-input">YES
    <input class="form-control" <?php if($result[0]->sms_sent=='N'){echo "checked"; } ?> value="N" type="radio" name="sms_sent" id="example-number-input">NO
  </div>
</div>

 <div class="form-group row">
  <label for="example-number-input" class="col-2 col-form-label">Referral Paid</label>
  <div class="col-10">
    <input class="form-control" <?php if($result[0]->referral_paid=='Y'){echo "checked"; } ?> value="Y" type="radio" name="referral_paid" id="example-number-input">YES
    <input class="form-control" <?php if($result[0]->referral_paid=='N'){echo "checked"; } ?> value="N" type="radio" name="referral_paid" id="example-number-input">NO
  </div>
</div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Referral Paid Date</label>
  <div class="col-10">
    <input class="form-control" name="referral_paid_date" type="text"
	value=""  id="referral_paid_date">
  </div>
 </div>

 <?php submit_button(); ?>   <script>    jQuery(document).ready(function() {  jQuery( function() {    jQuery("#referral_paid_date").datepicker({        dateFormat: 'yy-mm-dd'    });  } );      } );  </script> 
</form>
</div>
<?php }else{ ?>
<div class="wrap">
<h1>Add Payment</h1>
<form action="admin.php?page=addpayments&referralid=<?php echo $result[0]->id; ?>" method="post">
  <input type="hidden" name="add_payment" value="add_payment">
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">CRM ID</label>
  <div class="col-10">
    <input class="form-control" name="crm_id" type="text"
	value="<?php echo $crm_id; ?>" readonly>
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">CRM Payment ID</label>
  <div class="col-10">
    <input class="form-control" name="payment_id" type="text"
	value="<?php if(isset($_POST['payment_id'])){ echo $_POST['payment_id']; } ?>" id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Payment Amount</label>
  <div class="col-10">
    <input class="form-control" name="payment_amount" type="text"
	value="<?php if(isset($_POST['payment_amount'])){ echo $_POST['payment_amount']; } ?>" id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-number-input" class="col-2 col-form-label">Payment Date</label>
  <div class="col-10">
    <input class="form-control" value="<?php if(isset($_POST['payment_date'])){ echo $_POST['payment_date']; } ?>" type="text" name="payment_date" id="payment_date">
  </div>
</div>   <script>    jQuery(document).ready(function() {  jQuery( function() {    jQuery("#payment_date").datepicker({        dateFormat: 'yy-mm-dd'    });  } );      } );  </script> 

 <?php submit_button(); ?>
</form>
</div>
<?php } ?>
</div>
</div>
</div>
<?php
 }
	