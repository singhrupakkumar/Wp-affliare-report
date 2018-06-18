<?php
/**
 * Plugin Name: Report Management and Referrals Listing
 * Description: This plugin adds global options Report Management
 * Version: 1.0.0
 * Author: Rupak Kumar Singh
 */
include('reffral.php');
include('commissions.php');
include('pdf_convert.php');
$con = mysqli_connect('localhost','rupak_db','future@123','rupak_report');
add_action('admin_menu', 'neo_price_list_menus');
function neo_price_list_menus() {
	add_menu_page('Report Management and Referrals Listing', 'Affliate Partner', 'administrator', __FILE__, 'my_dashboard' ,'dashicons-admin-site' );
	add_submenu_page('', '','','manage_options','addpartnerpage','addpartner');
	
   add_submenu_page('','','','manage_options','addform','my_cool_plugin_settings_page' ); 
   add_submenu_page('report-management/shipping_n_moving.php','Referrals','Referrals','manage_options','view_order', 'view_my_moving_order' );
   add_submenu_page('report-management/shipping_n_moving.php','Payment Upload','Payment Upload','manage_options','fileupload', 'upload_file');
  
   add_submenu_page('','','','manage_options','addpayments', 'payment_add' );
   add_submenu_page('','','','manage_options','deletepay', 'deletepayment' );
   add_submenu_page('','','','manage_options','viewsingle', 'viewsingle_reffral');
   add_submenu_page('','','','manage_options','pdfpage', 'cunvertpdf');
   add_submenu_page('','','','manage_options','addcommissionspage', 'addcommissions');
   add_submenu_page('','','','manage_options','pdfgenrat', 'pdf_genrator' );
   add_submenu_page('report-management/shipping_n_moving.php','SMS Reprt','SMS Reprt','manage_options','sms_report', 'get_list_sms' );
   add_submenu_page('report-management/shipping_n_moving.php','Disbursal Report','Disbursal Report','manage_options','disbursalreport', 'disbursalreportcalculat' );
   add_submenu_page('report-management/shipping_n_moving.php','Commissions','Commissions','manage_options','commissions_page', 'get_list_commissions' );
	add_action( 'admin_init', 'price_settings_page_action' );
	add_action( 'admin_enqueue_scripts', 'my_enqueue' );
	
}

function my_enqueue($hook) {
   wp_enqueue_style( 'my_custom_script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
   wp_enqueue_style( 'my_customc_script', 'https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css' );
   wp_enqueue_style( 'my_customc_scripts11', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' ); 
   wp_enqueue_style( 'my_customc_scripts12', '/resources/demos/style.css' );
    wp_enqueue_script( 'my_custom_script12', '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js' );
    wp_enqueue_script( 'my_custom_script14', 'https://code.jquery.com/jquery-1.12.4.js' );
      wp_enqueue_script( 'my_custom_scriptcsv', plugin_dir_url( __FILE__ ).'js/csvExport.js' );
    wp_enqueue_script( 'my_custom_script13', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js' );
   wp_enqueue_script( 'my_custom_script2', 'https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js' );
    wp_enqueue_script( 'my_custom_script3', 'https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js' );}

	function pdf_genrator(){

	}
 function my_dashboard() {
		         global $wpdb;
	      $sql = "SELECT * FROM wp_affliate_partner";
	      $countsql = "SELECT count(*) as data_count FROM wp_affliate_partner";
	
	$countresult = $wpdb->get_results($countsql) or die(mysql_error());
	 if($countresult[0]->data_count >0) {

	$result = $wpdb->get_results($sql) or die(mysql_error());
	 }
	?>
 <h1>Affiliate</h1> 
<a href="admin.php?page=addpartnerpage" style="float:right;" class="btn btn-info">Add New</a>

 <table style="font-size:12px;" id="exampleuser" class="table table-bordered table-hover" cellspacing="0" width="100%">
   <thead>
	<tr>
         <th scope="col" class="manage-column sortable desc">ID</th>
         <th scope="col" class="manage-column sortable desc">First Name</th>
         <th scope="col" class="manage-column sortable desc">Last Name</th>
         <th scope="col" class="manage-column sortable desc">Mobile Number</th>
         <th scope="col" class="manage-column sortable desc">Email</th>
         <th scope="col" class="manage-column sortable desc">Status</th>

    </tr>
 </thead>
   <tbody>
    <?php
	
	 if($countresult[0]->data_count >0) {
    foreach($result as $key=>$value){
    ?>
    <tr>
      
        <td><a href="admin.php?page=addpartnerpage&edit_Affiliate=1&userid=<?php echo $value->id;?>"><?php echo $value->Partner_Id;?></a></td>
        <td><a href="admin.php?page=addpartnerpage&edit_Affiliate=1&userid=<?php echo $value->id;?>"><?php echo $value->First_Name;?></a></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->Last_Name;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->Mob_Number;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->Email_Id;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->Status;?></td> 
   </tr>
     <?php } 
	 }
	 ?>
 </tbody>

</table>
 <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#exampleuser').DataTable(); 
    } );
</script> 
 <?php

 }
function addpartner() {
	  global $wpdb;
  if(isset($_POST['add_Affiliate'])){
 $post_entry = array(
 'Partner_Id' => trim($_POST['Partner_Id']),
 'First_Name' => $_POST['First_Name'],
 'Last_Name' => $_POST['Last_Name'],
 'Address1' => $_POST['Address1'],
 'Address2' => $_POST['Address2'],
 'City' => $_POST['City'],
 'State' => $_POST['State'],
 'Mob_Number' => $_POST['Mob_Number'],
 'Email_Id'=> $_POST['Email_Id'],
 'Bank_Ac_Number'=> $_POST['Bank_Ac_Number'],
 'IFSC_Code'=> $_POST['IFSC_Code'],
 'Affliate_To'=> $_POST['Affliate_To'],
 'Bank_Name'=> $_POST['Bank_Name'],
 'Status'=> $_POST['Status'],
 'Joining_Date'=>$_POST['Joining_Date']
 );
   if ($wpdb->insert('wp_affliate_partner', $post_entry) === FALSE) {
          $error = 1;
          echo $error;
        }
        else {
          echo "<script type=\"text/javascript\">
						alert(\"Partner added successfully!\");
							
					</script>";
        }
		
  }	
  if(isset($_POST['edit_Affiliate'])){
	  $userid = $_POST['userid'];
 $Partner_Id = trim($_POST['Partner_Id']) ;
 $First_Name = $_POST['First_Name'] ;
 $Last_Name = $_POST['Last_Name'] ;
 $Address1 = $_POST['Address1'] ;
 $Address2 = $_POST['Address2'] ;
 $City = $_POST['City'] ;
 $State = $_POST['State'] ;
 $Email_Id = $_POST['Email_Id'] ;
 $Mob_Number = $_POST['Mob_Number'] ;
 $Bank_Ac_Number = $_POST['Bank_Ac_Number'] ;
 $IFSC_Code = $_POST['IFSC_Code'] ;
 $Affliate_To = $_POST['Affliate_To'] ;
 $Bank_Name = $_POST['Bank_Name'] ;
 $Status = $_POST['Status'] ;
 $Joining_Date = $_POST['Joining_Date'] ;
 $update = $wpdb->query("UPDATE wp_affliate_partner SET 
 Partner_Id = '$Partner_Id',
 First_Name = '$First_Name',
 Last_Name = '$Last_Name',
 Address1 = '$Address1',
 Address2 = '$Address2',
 City = '$City',
 State = '$State',
 Email_Id = '$Email_Id',
 Mob_Number = '$Mob_Number',
 Bank_Ac_Number = '$Bank_Ac_Number',
 IFSC_Code = '$IFSC_Code',
 Affliate_To = '$Affliate_To',
 Bank_Name = '$Bank_Name',
 Status = '$Status',
 Joining_Date = '$Joining_Date'
 WHERE id=$userid");
   if (!$update) {
          $error = 1;
          echo $error;
        }
        else {
          echo "<script type=\"text/javascript\">
						alert(\"Updated successfully!\");
							
					</script>";
        }
		
  }	

  ?>
  <div class="container">
    <div class="row">
 <div class="col-md-6"> 
<?php if($_GET['edit_Affiliate']==1){
		  $sql = "SELECT * FROM wp_affliate_partner where id =".$_GET['userid'];
	      $resultdata = $wpdb->get_results($sql) or die(mysql_error());
	
  ?> 
<div class="wrap">
<h1>Edit Affiliate</h1>
<form action="admin.php?page=addpartnerpage" method="post">
  <input type="hidden" name="edit_Affiliate" value="edit_Affiliate">
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">ID</label>
  <input class="form-control" name="userid" type="hidden"
	value="<?php echo $resultdata[0]->id;?>	">
  <div class="col-10">
    <input class="form-control" name="Partner_Id" type="text"
	value="<?php echo $resultdata[0]->Partner_Id;?>" readonly id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
  <div class="col-10">
    <input class="form-control" name="First_Name" type="text"
	value="<?php echo $resultdata[0]->First_Name;?>" readonly id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Last Name</label>
  <div class="col-10">
    <input class="form-control" name="Last_Name" type="text"
	value="<?php echo $resultdata[0]->Last_Name;?>" id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Address1</label>
  <div class="col-10">
    <input class="form-control" name="Address1" type="text"
	value="<?php echo $resultdata[0]->Address1;?>" id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Address2</label>
  <div class="col-10">
    <input class="form-control" name="Address2" type="text"
	value="<?php echo $resultdata[0]->Address2;?>" id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">City</label>
  <div class="col-10">
    <input class="form-control" name="City" type="text"
	value="<?php echo $resultdata[0]->City;?>" id="example-text-input">
  </div>
 </div>
   <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">State</label>
  <div class="col-10">
    <input class="form-control" name="State" type="text"
	value="<?php echo $resultdata[0]->State;?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Mob Number</label>
  <div class="col-10">
    <input class="form-control" name="Mob_Number" type="tel"
	value="<?php echo $resultdata[0]->Mob_Number;?>" id="example-text-input" required>
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Email Id</label>
  <div class="col-10">
    <input class="form-control" name="Email_Id" type="text"
	value="<?php echo $resultdata[0]->Email_Id;?>" id="example-text-input" required>
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Bank Ac Number</label>
  <div class="col-10">
    <input class="form-control" name="Bank_Ac_Number" type="text"
	value="<?php echo $resultdata[0]->Bank_Ac_Number;?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">IFSC_Code</label>
  <div class="col-10">
    <input class="form-control" name="IFSC_Code" type="text"
	value="<?php echo $resultdata[0]->IFSC_Code;?>" id="example-text-input">
  </div>
 </div>
 
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Bank_Name</label>
  <div class="col-10">
    <input class="form-control" name="Bank_Name" type="text"
	value="<?php echo $resultdata[0]->Bank_Name;?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Joining_Date</label>
  <div class="col-10">
    <input class="form-control" name="Joining_Date" type="text"
	value="<?php echo $resultdata[0]->Joining_Date;?>" id="1datepicker">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Affliate_To</label>
  <div class="col-10">
    <input class="form-control" name="Affliate_To" type="text"
	value="<?php echo $resultdata[0]->Affliate_To;?>" id="example-text-input">
  </div>
 </div>
 
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Status</label>
  <div class="col-10">
    <select name="Status" class="form-control">
		<option <?php if($resultdata[0]->Status=='active') { echo "selected"; }?> value="active">Active</option>
		<option <?php if($resultdata[0]->Status=='deactive') { echo "selected"; }?> value="deactive">DeActive</option>
		
	</select>
  </div>
 </div>
   <script> 
   jQuery(document).ready(function() {
  jQuery( function() {
	  jQuery("#1datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
		  maxDate: 0
    });
	  } ); 
     } );
  </script> 
 <?php submit_button('Update'); ?>
</form>

  <?php }else{ ?>
<div class="wrap">
<h1>Add Affiliate</h1>
<form action="admin.php?page=addpartnerpage" method="post">
  <input type="hidden" name="add_Affiliate" value="add_Affiliate">
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">ID</label>
  <div class="col-10">
    <input class="form-control" name="Partner_Id" type="text"
	value="<?php if(isset($_POST['Partner_Id'])){ echo $_POST['Partner_Id']; } ?>" id="example-text-input" required>
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
  <div class="col-10">
    <input class="form-control" name="First_Name" type="text"
	value="<?php if(isset($_POST['First_Name'])){ echo $_POST['First_Name']; } ?>" id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Last Name</label>
  <div class="col-10">
    <input class="form-control" name="Last_Name" type="text"
	value="<?php if(isset($_POST['Last_Name'])){ echo $_POST['Last_Name']; } ?>" id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Address1</label>
  <div class="col-10">
    <input class="form-control" name="Address1" type="text"
	value="<?php if(isset($_POST['Address1'])){ echo $_POST['Address1']; } ?>" id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Address2</label>
  <div class="col-10">
    <input class="form-control" name="Address2" type="text"
	value="<?php if(isset($_POST['Address2'])){ echo $_POST['Address2']; } ?>" id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">City</label>
  <div class="col-10">
    <input class="form-control" name="City" type="text"
	value="<?php if(isset($_POST['City'])){ echo $_POST['City']; } ?>" id="example-text-input">
  </div>
 </div>
   <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">State</label>
  <div class="col-10">
    <input class="form-control" name="State" type="text"
	value="<?php if(isset($_POST['State'])){ echo $_POST['State']; } ?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Mob Number</label>
  <div class="col-10">
    <input class="form-control" name="Mob_Number" type="tel"
	value="<?php if(isset($_POST['Mob_Number'])){ echo $_POST['Mob_Number']; } ?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Email Id</label>
  <div class="col-10">
    <input class="form-control" name="Email_Id" type="text"
	value="<?php if(isset($_POST['Email_Id'])){ echo $_POST['Email_Id']; } ?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Bank Ac Number</label>
  <div class="col-10">
    <input class="form-control" name="Bank_Ac_Number" type="text"
	value="<?php if(isset($_POST['Bank_Ac_Number'])){ echo $_POST['Bank_Ac_Number']; } ?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">IFSC_Code</label>
  <div class="col-10">
    <input class="form-control" name="IFSC_Code" type="text"
	value="<?php if(isset($_POST['IFSC_Code'])){ echo $_POST['IFSC_Code']; } ?>" id="example-text-input">
  </div>
 </div>
 
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Bank_Name</label>
  <div class="col-10">
    <input class="form-control" name="Bank_Name" type="text"
	value="<?php if(isset($_POST['Bank_Name'])){ echo $_POST['Bank_Name']; } ?>" id="example-text-input">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Joining_Date</label>
  <div class="col-10">
    <input class="form-control"  name="Joining_Date" type="text"
	value="<?php if(isset($_POST['Joining_Date'])){ echo $_POST['Joining_Date']; } ?>" id="datepicker">
  </div>
 </div>
    <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Affliate_To</label>
  <div class="col-10">
    <input class="form-control" name="Affliate_To" type="text"
	value="<?php if(isset($_POST['Affliate_To'])){ echo $_POST['Affliate_To']; } ?>" id="example-text-input">
  </div>
 </div>
 
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Status</label>
  <div class="col-10">
    <select name="Status" class="form-control">
		<option value="active">Active</option>
		<option value="deactive">DeActive</option>
		
	</select>
  </div>
 </div>
   <script> 
   jQuery(document).ready(function() {
  jQuery( function() { 
  jQuery("#datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0
       
    });
  } ); 
     } );
  </script> 
 <?php submit_button('Save'); ?>
</form>
</div>
  <?php } ?>
</div>
</div>
</div>
<?php	  
  }
 function price_settings_page_action() {


}



function my_cool_plugin_settings_page() {
	
	 global $wpdb;

  if(isset($_POST['add_referrals'])){
 $post_entry = array(
 'first_name' => $_POST['first_name'],
 'crm_id' => trim($_POST['crm_id']),
 'last_name' => $_POST['last_name'],
 'mobile_number' => $_POST['mobile_number'],
 'partner_Id'=> trim($_POST['partner_Id']),
 'convert_or_remind'=> $_POST['convert_or_remind'],
 'reminder'=> $_POST['reminder'],
 'referral_allow'=> $_POST['referral_allow'],
 'convert_date'=>$_POST['convert_date']
 );
   if ($wpdb->insert('wp_referrals', $post_entry) === FALSE) {
          $error = 1;
          echo $error;
        }
        else {
          echo "<script type=\"text/javascript\">
						alert(\"Referral added successfully!\");
							window.location='admin.php?page=view_order'
					</script>";
        }
		
  }
  
	$sql1part = "SELECT * FROM wp_affliate_partner";
	$blogusers = $wpdb->get_results($sql1part) or die(mysql_error());
	?>
<div class="container">
    <div class="row">
 <div class="col-md-6"> 
<?php if($_GET['editreffral']==1){
	 $sql1 = "SELECT * FROM wp_referrals where id=".$_GET['reffralid'];

	  $resultdata = $wpdb->get_results($sql1) or die(mysql_error());
?> 

<div class="wrap">
<h1>Edit Referrals</h1>

<form action="admin.php?page=view_order" method="post">
  <input type="hidden" name="edit_reffralid" value="edit_reffralid">
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
  <div class="col-10">
    <input class="form-control" name="reffralid" type="hidden"
	value="<?php echo  $resultdata[0]->id ?>">
    <input class="form-control" name="first_name" type="text"
	value="<?php echo  $resultdata[0]->first_name ?>" readonly id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">CRM ID</label>
  <div class="col-10">
    <input class="form-control" name="crm_id" type="text"
	value="<?php echo  $resultdata[0]->crm_id ?>" readonly id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Mobile</label>
  <div class="col-10">
    <input class="form-control" name="mobile_number" type="tel"
	value="<?php echo  $resultdata[0]->mobile_number ?>" readonly id="example-text-input">
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Partner</label>
  <div class="col-10">
    <select name="partner_Id" class="form-control">
	<?php foreach($blogusers as $user){  ?>
		<option <?php if($resultdata[0]->partner_Id== $user->Partner_Id){ echo "selected";}?>  value="<?php echo  $user->Partner_Id ;?>"><?php echo $user->Partner_Id;?></option>
	<?php } ?>	
	</select>
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Convert Or Remind</label>
  <div class="col-10">
    <select name="convert_or_remind" class="form-control">
		<option <?php if($resultdata[0]->convert_or_remind=='N'){ echo "selected";}?> value="N">NO</option>
		<option <?php if($resultdata[0]->convert_or_remind=='R'){ echo "selected";}?> value="R">Reminder</option>
		<option <?php if($resultdata[0]->convert_or_remind=='Y'){ echo "selected";}?> value="Y">YES</option>
		
	</select>
  </div>
 </div>
<div class="form-group row">
  <label for="example-tel-input" class="col-2 col-form-label">Reminder</label>
  <div class="col-10">
    <input class="form-control" type="text" name="reminder" value="<?php if(isset($_POST['reminder'])){ echo $_POST['reminder']; } ?>" id="rdatepicker">
  </div>
</div>
<div class="form-group row">
  <label for="example-password-input" class="col-2 col-form-label">Referral_Allow
</label>
  <div class="col-10">
     <?php echo  $resultdata[0]->referral_allow ?>
  </div>
</div>
   <script> 
   jQuery(document).ready(function() {
  jQuery( function() {   
  jQuery("#rdatepicker").datepicker({
        dateFormat: 'yy-mm-dd',
		  maxDate: 0
    });
  } ); 
     } );
  </script> 
 <?php submit_button(); ?>
</form>
</div>

<?php }else{ ?>
<div class="wrap">
<h1>Add Referrals</h1>

<form action="admin.php?page=addform" method="post">
  <input type="hidden" name="add_referrals" value="add_referrals">
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
  <div class="col-10">
    <input class="form-control" name="first_name" type="text"
	value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; } ?>" id="example-text-input" required>
  </div>
 </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">CRM ID</label>
  <div class="col-10">
    <input class="form-control" name="crm_id" type="text"
	value="<?php if(isset($_POST['crm_id'])){ echo $_POST['crm_id']; } ?>" id="example-text-input" required>
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Last Name</label>
  <div class="col-10">
    <input class="form-control" name="last_name" type="text"
	value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; } ?>" id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Mobile</label>
  <div class="col-10">
    <input class="form-control" name="mobile_number" type="tel"
	value="<?php if(isset($_POST['mobile_number'])){ echo $_POST['mobile_number']; } ?>" id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Converted?</label>
  <div class="col-10">
    <select name="convert_or_remind" class="form-control">
		<option value="N">NO</option>
		<option value="R">Reminder</option>
		<option value="Y">YES</option>
		
	</select>
  </div>
 </div>
 
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Partner</label>
  <div class="col-10">
    <select name="partner_Id" class="form-control">
	<?php foreach($blogusers as $user){  ?>
	<option value="<?php echo  $user->Partner_Id ;?>"><?php echo $user->Partner_Id;?></option>
	<?php } ?>	
	</select>
  </div>
 </div>
<div class="form-group row">
  <label for="example-tel-input" class="col-2 col-form-label">Reminder</label>
  <div class="col-10">
    <input class="form-control" type="text" name="reminder" value="<?php if(isset($_POST['reminder'])){ echo $_POST['reminder']; } ?>" id="ardatepicker">
  </div>
</div>
<div class="form-group row">
  <label for="example-password-input" class="col-2 col-form-label">Referral_Allow
</label>
  <div class="col-10">
 <label class="checkbox-inline">
      <input class="form-control" type="radio" value="Y" name="referral_allow" id="example-password-input">YES
    </label>
    <label class="checkbox-inline">
        <input class="form-control" type="radio" value="N" name="referral_allow" id="example-password-input">NO
    </label>
   
  
  </div>
</div>
<div class="form-group row">
  <label for="example-number-input" class="col-2 col-form-label">Convert_Date</label>
  <div class="col-10">
    <input class="form-control" type="text" value="<?php if(isset($_POST['convert_date'])){ echo $_POST['convert_date']; } ?>" name="convert_date" id="convert_date">
  </div>
</div>
   <script> 
   jQuery(document).ready(function() {
  jQuery( function() {jQuery("#ardatepicker").datepicker(
  {
        dateFormat: 'yy-mm-dd'
    }
  );  } ); 
  
  jQuery( function() {jQuery("#convert_date").datepicker(
  {
        dateFormat: 'yy-mm-dd'
    }
  );  } ); 
     } );
  </script> 
 <?php submit_button(); ?>
</form>
</div>
<?php } ?>
</div>
</div>
</div>

<?php }
function view_my_moving_order(){
         global $wpdb;
	      $sql = "SELECT R.*,A.Affliate_To FROM wp_referrals as R,wp_affliate_partner as A where A.Partner_Id=A.Partner_Id group by R.`crm_id`";
	      $sqlc = "SELECT count(*) as data_count FROM wp_referrals";
	      
	      $resultpayment_sqlco = $wpdb->get_results($sqlc) or die(mysql_error());
			 if($resultpayment_sqlco[0]->data_count >0){
		 $result = $wpdb->get_results($sql) or die(mysql_error());
			 }
		 if(isset($_POST['edit_reffralid'])){
$reffralid = $_POST['reffralid'];
$partner_Id = trim($_POST['partner_Id']); 
 $convert_or_remind = $_POST['convert_or_remind'] ;
 $reminder = $_POST['reminder'] ;
 
 $update = $wpdb->query("UPDATE wp_referrals SET 
 convert_or_remind = '$convert_or_remind',
 partner_Id = '$partner_Id',
 reminder = '$reminder'
 WHERE id=$reffralid");
   if (!$update) {
          $error = 1;
          echo $error;
        }
        else {
          echo "<script type=\"text/javascript\">
						alert(\"Updated successfully!\");
							window.location.reload();
					</script>";
        }
		
  }	


 ?>
 <h1>Referral</h1>
<a href="admin.php?page=addform" style="float:right;" class="btn btn-info">Add New</a>
 <table style="font-size:12px;" id="example1" class="table table-bordered table-hover" cellspacing="0" width="100%">
   <thead>
	<tr>
         <th scope="col" class="manage-column sortable desc">ID</th>
         <th scope="col" class="manage-column sortable desc">First Name</th>
         <th scope="col" class="manage-column sortable desc">Last Name</th>
         <th scope="col" class="manage-column sortable desc">Mobile Number</th>
         <th scope="col" class="manage-column sortable desc">Partner ID</th>
         <th scope="col" class="manage-column sortable desc">Affliate To</th>
         <th scope="col" class="manage-column sortable desc">Reminder</th>
         <th scope="col" class="manage-column sortable desc">Reminder Date</th>
         <th scope="col" class="manage-column sortable desc">Referral Allow</th>
         <th scope="col" class="manage-column sortable desc">Action</th>
   </tr>
 </thead>
   <tbody>
    <?php
	 if($resultpayment_sqlco[0]->data_count >0){
    foreach($result as $key=>$value){
    ?>
    <tr>
      
        <td><a href="admin.php?page=addform&editreffral=1&reffralid=<?php echo $value->id;?>"><?php echo $value->crm_id;?></a></td>
        <td><a href="admin.php?page=addform&editreffral=1&reffralid=<?php echo $value->id;?>"><?php echo $value->first_name;?></a></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->last_name;?></td>

        <td class="simple-table-manager-list-all-odd">
        <?php echo $value->mobile_number;?>
       
        </td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->partner_Id;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->Affliate_To;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->reminder;?></td>
		        <td class="simple-table-manager-list-all-odd"><?php echo $value->convert_date;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->referral_allow;?></td> 
        <td><a class="btn btn-success" href="admin.php?page=viewsingle&reffralid=<?php echo $value->id;?>">View</a></td> 
   </tr>
     <?php } 
	 }
	 ?>
 </tbody>

</table>
 <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#example1').DataTable(); 
    } );
</script>  
<?php 
}

 function get_list_sms(){
	        global $wpdb;
			
			 if(isset($_POST['smsedit'])) {
            $smsedit = $_POST['smsedit'];
            foreach($smsedit as $smsid){
              $update = $wpdb->query("UPDATE wp_payments SET 
				 sms_sent = 'Y'
				 WHERE id= $smsid");
				  
            }
           
           	
           	  if($update){
			    echo "<script type=\"text/javascript\">
						alert(\"Updated successfully!\");
							window.location.reload();
					</script>";
		     }else{
		         
		          echo "<script type=\"text/javascript\">
						alert(\"Something Wrong.\");
					window.location.reload();
					</script>";
		     }
          
            }
	$count_sql ="SELECT count(*) as data_count, P.payment_date,P.id as payid,P.payment_amount,P.payment_id,P.sms_sent,A.Partner_Id,A.Mob_Number,R.crm_id from wp_payments as P,wp_referrals as R,
		  wp_affliate_partner as A where P.crm_id=R.crm_id and R.partner_Id = A.Partner_Id and P.sms_sent='N' and P.referral_allow = 'Y'";
	      $sql = "SELECT P.payment_date,P.id as payid,P.payment_amount,P.payment_id,P.sms_sent,A.Partner_Id,A.Mob_Number,R.crm_id from wp_payments as P,wp_referrals as R,
		  wp_affliate_partner as A where P.crm_id=R.crm_id and R.partner_Id = A.Partner_Id and P.sms_sent='N' and P.referral_allow = 'Y'";
	      $countresult = $wpdb->get_results($count_sql) or die(mysql_error());
		  if($countresult[0]->data_count >0){	
	      $result = $wpdb->get_results($sql) or die(mysql_error());
		  }
 ?>
 <h1>Sms Report</h1>
 <a href="javascript:void(0)" style="float:right;" id="editsmsbtn" class="btn btn-success">UPDATE</a>
  <form action="admin.php?page=sms_report" id="editsmsrowform1" method="POST">
 <table style="font-size:12px;" id="example3" class="table table-bordered table-hover" cellspacing="0" width="100%">
   <thead>
	<tr>


         <th scope="col" class="manage-column sortable desc">#</th>
         <th scope="col" class="manage-column sortable desc">CRM ID</th>
         <th scope="col" class="manage-column sortable desc">Partner Id</th>
         <th scope="col" class="manage-column sortable desc">Partner Mob Number</th>
         <th scope="col" class="manage-column sortable desc">Payment Id</th>
         <th scope="col" class="manage-column sortable desc">Payment Amt</th>
         <th scope="col" class="manage-column sortable desc">Payment Date</th>
         <th scope="col" class="manage-column sortable desc">SMS Sent</th>
		
</tr>
 </thead>
   <tbody>
    <?php
	 if($countresult[0]->data_count >0){	
    foreach($result as $key=>$value){
    ?>
    <tr>
       <td><input type="checkbox" class="form" name="smsedit[]" value="<?php echo $value->payid;?>"></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->crm_id;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->Partner_Id;?></td>

        <td class="simple-table-manager-list-all-odd"><?php echo $value->Mob_Number;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->payment_id;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->payment_amount;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->payment_date;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->sms_sent;?></td>	

   </tr>
     <?php }
	 }
	 ?>
 </tbody>

</table>
</form>

 <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#example3').DataTable();
	 $('#editsmsbtn').click(function(){ 
var len = $('[name="smsedit[]"]:checked').length;
if(len < 1){
alert('Please check edit row');
}else{

if (window.confirm('Do You really want to update?'))
{
 $('#editsmsrowform1').submit();
}
else
{
  return false;
}	


}
        });

   } );
</script> 
<?php }
function disbursalreportcalculat(){
	global $wpdb,$con;
	
//	$con = mysqli_connect('localhost','rupak_db','future@123','rupak_report');
	if(isset($_POST['disbursalreport'])){
		$disbursalid = $_POST['disbursalid'];
		$datein = date('Y-m-d');
		$mtn = date('Y-m-d');

  		  foreach($disbursalid as $key=>$id){  
			  
			  $id = trim($id);
			  
// 		$sqlcount = "SELECT count(*) as datarow, sum(P.payment_amount) as total_amount from wp_referrals as R,wp_payments as P where P.crm_id=R.crm_id and P.sms_sent='Y' and P.referral_paid = 'N' and MONTH(P.payment_date) = MONTH('$datein') and R.partner_Id LIKE'%$id%' group by R.partner_Id";		  
			  
// 		  $counresultss = $wpdb->get_results($sqlcount) or die(mysql_error());
	
		
// 		if(!empty($counresultss[0]->datarow)){   
	$sql = "SELECT sum(P.payment_amount) as total_amount from wp_referrals as R,wp_payments as P where P.crm_id=R.crm_id and P.sms_sent='Y' and P.referral_paid = 'N' and MONTH(P.payment_date) = MONTH('$datein') and R.partner_Id LIKE'%$id%' group by R.partner_Id";
	
     	$counresult = mysqli_query($con,$sql)or die(mysql_error($con)); 
	     // $counresult = $con->query($sql) or die(mysql_error($con));  
 if(mysqli_num_rows($counresult) > 0) {


  $row = mysqli_fetch_array($counresult,MYSQLI_ASSOC);
	
		$curent = $row['total_amount'];
			
			
		
			 $secondqury = "SELECT percent
FROM wp_commissions
WHERE $curent between from_amt and to_amt";

 $result1 = $wpdb->get_results($secondqury) or die(mysql_error());

 $reffral_ammountrr = $curent*$result1[0]->percent/100;
 // echo "<script>alert('yes s')</script>";
 
		$refertcount = "SELECT  count(*) as datacount from wp_referrals where MONTH(joining_date) = MONTH(NOW()) and partner_Id LIKE'%$id%'";
      $refertcountresut = $wpdb->get_results($refertcount) or die(mysql_error());
	  
	  $srefertcount = "SELECT  count(*) as datacount from wp_referrals where MONTH(convert_date) = MONTH(NOW()) and partner_Id LIKE'%$id%'";
	  
	  $refertcountresutseco = $wpdb->get_results($srefertcount) or die(mysql_error());
	  
	  
	  if($refertcountresut[0]->datacount > 0){
		$tot_referred =  $refertcountresut[0]->datacount; 
	  }else{
		  $tot_referred = 0;
	  }
	  
	  if($refertcountresutseco[0]->datacount > 0){
		$tot_converted =  $refertcountresutseco[0]->datacount; 
	  }else{
		  $tot_converted = 0;
	  }
		 $post_entry = array(   
		   'partner_Id' => $id,
		   'mnth' => $mtn ,
		   'tot_referred' => $tot_referred,
		   'tot_converted' => $tot_converted,
		   'tot_referral_amount' => $curent
		  
		  );
		  
		 // $checksql ="SELECT count(*) as rowcount, DATE_FORMAT('$mtn','%Y-%m') from wp_disbursals where partner_Id LIKE'%$id%'";
		  $checksql ="select count(*) as rowcount FROM wp_disbursals
WHERE MONTH(mnth) = MONTH(CURRENT_DATE()) and  partner_Id LIKE'%$id%'";
		 $checksqlresult1 = $wpdb->get_results($checksql) or die(mysql_error());
		   if($checksqlresult1[0]->rowcount > 0){
			  echo "<script>alert('Month Exist')</script>";	   
		  }else{ 
		   if ($wpdb->insert('wp_disbursals', $post_entry) === FALSE) {
          $error = 1;
          echo $error;
		   echo "<script>alert('error')</script>";
        }
        else {
         
        }
		  }
		  
/* 		  $update = $wpdb->query("UPDATE wp_payments SET 
 referral_paid_date = '$datein',
 referral_paid = 'Y'
 WHERE id= $p_id");
   if (!$update) {
          $error = 1;
          echo $error;
        } */
		  
 } 
		  }
	 echo "<script>alert('Successfully added!')</script>";	  

	}
?>
<div class="container">
    <div class="row">
 <div class="col-md-6">        
<h3>Disbursal Report</h3>

<form action="admin.php?page=disbursalreport" method="post">
  <input type="hidden" name="searchdate_reffral" value="searchdate_reffral">
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">To date</label>
  <div class="col-10">
    <input class="form-control" name="searchdate" type="text"
	value="<?php if(isset($_POST['searchdate'])){ echo $_POST['searchdate']; } ?>" id="searchdate"> </div>
 </div>
   <script> 
   jQuery(document).ready(function() {
  jQuery( function() {    jQuery("#searchdate").datepicker({
        dateFormat: 'yy-mm-dd'
    });  } ); 
     } );
  </script> 
 <?php submit_button('Submit'); ?>
</form>

</div>
</div>
</div>
  <?php 
 global $wpdb;
		if(isset($_POST['searchdate'])){
			$searchdate = $_POST['searchdate'];
	    $csql = "SELECT count(*) as data_count , R.partner_Id,sum(P.payment_amount) as total_amount from wp_referrals as R,wp_payments as P where P.crm_id=R.crm_id and P.sms_sent='Y' and P.referral_paid = 'N' and P.payment_date <='$searchdate' group by R.partner_Id";
	    $sql = "SELECT R.partner_Id,sum(P.payment_amount) as total_amount from wp_referrals as R,wp_payments as P where P.crm_id=R.crm_id and P.sms_sent='Y' and P.referral_paid = 'N' and P.payment_date <='$searchdate' group by R.partner_Id";
	      $countresult = $wpdb->get_results($csql) or die(mysql_error());
if($countresult[0]->data_count >0){		  
	      $result = $wpdb->get_results($sql) or die(mysql_error()); 
		 
}		 
		  ?>
	 <h1>Data</h1>
<form action="admin.php?page=disbursalreport" method="post" id="Disbursalrowform1">	 
<input type="hidden" name="disbursalreport" value="1">
 <table style="font-size:12px;" id="example5" class="table table-bordered table-hover" cellspacing="0" width="100%">
   <thead>
	<tr>
         <th>#</th>
         <th scope="col" class="manage-column sortable desc">Partner Id</th>
         <th scope="col" class="manage-column sortable desc">Total Payment Amt</th>
         <th scope="col" class="manage-column sortable desc">Referral_Amt</th>
    </tr>
 </thead>
   <tbody>
    <?php
	if($countresult[0]->data_count >0){	
	$i =0;
    foreach($result as $key=>$value){
		$i++;
		$curent = $value->total_amount;
		
if(!empty($curent)){ 
 $secondqury = "SELECT percent
FROM wp_commissions
WHERE $curent between from_amt and to_amt";

 $result1 = $wpdb->get_results($secondqury) or die(mysql_error());

 $reffral_ammountrr = $curent*$result1[0]->percent/100;

}
    ?>
    <tr>
      
        <td><input type="checkbox" name="disbursalid[]" value="<?php echo trim($value->partner_Id);?>"></td>
        <td style="cursor: pointer;color:blue;" onclick="mypdfconver('<?php echo trim($value->partner_Id);?>');"><?php echo trim($value->partner_Id);?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->total_amount ;?></td>

        <td class="simple-table-manager-list-all-odd"><?php  echo $reffral_ammountrr;?></td>	

   </tr> 
     <?php }
		}
	 ?>
 </tbody>

</table>
</form>
<button id="disbursal_insert" class="btn btn-primary">Disbursal</button>
<button id="exportcsv" class="btn btn-primary">Download</button>
 <script type="text/javascript" charset="utf-8">
     function mypdfconver(pid){
           if (window.confirm('Do You really want to Pdf Report?'))
        {
       
       window.location='admin.php?page=pdfpage&pid='+pid+''
        }
        else
        {
          return false;
        }  
     }
    $(document).ready(function() {
        var newDate = new Date();  
        
      $('#example5').DataTable();
	
		
			 $('#disbursal_insert').click(function(){ 
var len = $('[name="disbursalid[]"]:checked').length;
if(len < 1){
alert('Please check Disbursal row');
}else{

if (window.confirm('Do You really want to Disbursal?'))
{
 $('#Disbursalrowform1').submit();
}
else
{
  return false;
}	


}
        });

     $('#exportcsv').on('click',function(){
         if (window.confirm('Do You really want to export in excel?'))
        {
         $('#example5').csvExport();
        }
        else
        {
          return false;
        }
         
     });   

    } );
    

</script> 	  
	<?php
	} 
}
 //////////////////payment upload/////////////////
function upload_file(){
	global $wpdb;

 if(isset($_POST["Import"])){
		
		$filename=$_FILES["file"]["tmp_name"];		
		$filenamereal=$_FILES["file"]["name"];		
	$mimes = array('application/vnd.ms-excel','text/csv');
	if(in_array($_FILES['file']['type'],$mimes)){

		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
				 $filenamecsql = "SELECT count(*) as countfile FROM wp_fileupload where file_name= '$filenamereal'";

	      $filenamecsqlcresult = $wpdb->get_results($filenamecsql) or die(mysql_error());

          if($filenamecsqlcresult[0]->countfile==0){
					 $post_entryfile = array(
						 'file_name' => $filenamereal,
						 );	
			  if ($wpdb->insert('wp_fileupload', $post_entryfile) === FALSE) {
				  echo "error 1";
			  }else{
				  echo "success"; 
				  
			  }
             }else{
				
         	echo "<script type=\"text/javascript\">
							alert(\"File already Uploaded.\");
						
						  </script>";
			
			 }
			
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
			$import_crm = trim($getData[0]) ;
			 $import_pay_id = $getData[1];
			 
			   $csql = "SELECT count(*) as count1 FROM wp_payments where crm_id=".$import_crm;
			$cresult = $wpdb->get_results($csql) or die(mysql_error());
			if($cresult[0]->count1==0){
				 $convert_date = date('Y-m-d');
			 
			 $update = $wpdb->query("UPDATE wp_referrals SET 
			 convert_or_remind = 'Y',
			 convert_date = '$convert_date'
			 WHERE crm_id= $import_crm");
			   if (!$update) {
					  $error = 1;
					  echo $error;
					}
					else {
					  echo "update Success";
					}
				
			  }
			 
			 
		 $pcsql = "SELECT count(*) as count2 FROM wp_payments where crm_id= $import_crm and payment_id = $import_pay_id";

	      $pcresult = $wpdb->get_results($pcsql) or die(mysql_error());

if($pcresult[0]->count2==0){
			
		 $post_entryfirst = array(
 'crm_id' => trim($getData[0]),
 'payment_id' => $getData[1],
 'payment_amount' => $getData[2]
 );		
				
   if ($wpdb->insert('wp_payments', $post_entryfirst) === FALSE) {

         	echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
						
						  </script>";	

        }else{
			
				  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						
					</script>";
			
		}

				
	         }
			 }		 
			
	         fclose($file);	
		 }
	}else{
		  echo "<script type=\"text/javascript\">
						alert(\"Only CSV file allowed.\");
						
					</script>";
		
	}
	}	 

?>

     <div class="container">
            <div class="row">
 
                <form class="form-horizontal" action="admin.php?page=fileupload" method="post" name="upload_excel" enctype="multipart/form-data">
             
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
 
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
 
                 
                </form>
 
            </div>
          
        </div>

<?php
	 $filenamecsql = "SELECT count(*) as countfile FROM wp_fileupload";
 $filenamecsqlcresult = $wpdb->get_results($filenamecsql) or die(mysql_error());
  if($filenamecsqlcresult[0]->countfile >0){
 $filenams = "SELECT * FROM wp_fileupload";
 $filenresult = $wpdb->get_results($filenams) or die(mysql_error());
  } 
	?>
		<h3>Files</h3> 
 <table style="font-size:12px;" id="exampleuserpaymentfile" class="table table-bordered table-hover" cellspacing="0" width="100%">

   <thead>

	<tr>

	 <th scope="col" class="manage-column sortable desc">SrNo</th>

         <th scope="col" class="manage-column sortable desc">Date</th>

         <th scope="col" class="manage-column sortable desc">Upload file Name</th>

    </tr>

 </thead>

   <tbody>

    <?php


	  if($filenamecsqlcresult[0]->countfile >0){
    foreach($filenresult as $key=>$value){

    ?>

    <tr>

        <td><?php echo $value->id;?></td>
        <td><?php echo $value->upload_date;?></td>

        <td><?php echo $value->file_name;?></td>
   </tr>

     <?php 
	 	
		}
	  }	
	 ?>
 </tbody>



</table>

 <script type="text/javascript" charset="utf-8">

    $(document).ready(function() {

        $('#exampleuserpaymentfile').DataTable(); 

    } );

</script>   

<?php	
}

