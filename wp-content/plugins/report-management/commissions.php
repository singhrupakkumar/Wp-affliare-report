<?php
function get_list_commissions()
 {

	        global $wpdb;
		
	      $csql = "SELECT count(*) as data_count from wp_commissions";
	      $sql = "SELECT * from wp_commissions";
	      $countresult = $wpdb->get_results($csql) or die(mysql_error());
		  if($countresult[0]->data_count >0){	
	      $result = $wpdb->get_results($sql) or die(mysql_error());
		  }

		  if(isset($_GET['del_id'])){
			$delete = $wpdb->query("DELETE FROM wp_commissions WHERE id=".$_GET['del_id']);  
		  if($delete){
			    echo "<script type=\"text/javascript\">
						alert(\"Successfully Deleted.\");
						window.location='admin.php?page=commissions_page'
					</script>";
		  } 
		  }
		  
		  if(isset($_POST['edit_Commissions'])){
			$edit_id =  $_POST['edit_id'];
			$from_amt =  $_POST['from_amt'];
			$to_amt =  $_POST['to_amt'];
			$percent =  $_POST['percent'];
			  $update = $wpdb->query("UPDATE wp_commissions SET 
 from_amt = '$from_amt',
 percent = '$percent',

 to_amt = '$to_amt'

 WHERE id= $edit_id");

   if (!$update) {

          $error = 1;

          echo $error;

        }

        else {

          echo "update Success";

        }

		  }
		if(isset($_GET['edit_id'])){ 
		  $sql = "SELECT * from wp_commissions where id=".$_GET['edit_id'];
	      $resultdata = $wpdb->get_results($sql) or die(mysql_error());
		?>		
 <h1>Edit Commission</h1>
<form action="admin.php?page=commissions_page" method="post">
  <input type="hidden" name="edit_Commissions" value="edit_Commissions">
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">From amt</label>
  <input class="form-control" name="edit_id" type="hidden"
	value="<?php echo $_GET['edit_id'];?>	">
  <div class="col-10">
    <input class="form-control" name="from_amt" type="text"
	value="<?php echo $resultdata[0]->from_amt;?>"  id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">to amt</label>
  <div class="col-10">
    <input class="form-control" name="to_amt" type="text"
	value="<?php echo $resultdata[0]->to_amt;?>"  id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Percent</label>
  <div class="col-10">
    <input class="form-control" name="percent" type="text"
	value="<?php echo $resultdata[0]->percent;?>" id="example-text-input">
  </div>
 </div>
 
 <?php submit_button('Update'); ?>
</form>
	<?php		   
	    }
	  
 ?>
 <h1>Commissions Percent</h1> 
 <a href="admin.php?page=addcommissionspage" style="float:right;" class="btn btn-info">Add New</a>
 <table style="font-size:12px;" id="example4" class="table table-bordered table-hover" cellspacing="0" width="100%">
   <thead>
	<tr>
         <th scope="col" class="manage-column sortable desc">Sr.no</th>
         <th scope="col" class="manage-column sortable desc">From Amount</th>
         <th scope="col" class="manage-column sortable desc">To Amount</th>
         <th scope="col" class="manage-column sortable desc">Percent</th>
         <th scope="col" class="manage-column sortable desc">Action</th>

    </tr>
 </thead>
   <tbody>
    <?php
	 if($countresult[0]->data_count >0){	
    foreach($result as $key=>$value){
    ?>
    <tr>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->id;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->from_amt;?></td>
        <td class="simple-table-manager-list-all-odd"><?php echo $value->to_amt;?></td>

        <td class="simple-table-manager-list-all-odd"><?php echo $value->percent."%";?></td>	
        <td>
		<a href="admin.php?page=commissions_page&edit_id=<?php echo $value->id;?>" class="btn btn-success">Edit</a>
		<a href="admin.php?page=commissions_page&del_id=<?php echo $value->id;?>" class="btn btn-danger">Delete</a>
		</td>
        
		
        
   </tr>
     <?php 
	 }
 }
	 ?>
 </tbody>

</table>
 <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#example4').DataTable();
    } );
</script> 
<?php }
	function addcommissions(){
	  global $wpdb;
  if(isset($_POST['add_Commissions'])){
 $post_entry = array(
 'from_amt' => $_POST['from_amt'],
 'to_amt' => $_POST['to_amt'],
 'percent' => $_POST['percent']
 );
   if ($wpdb->insert('wp_commissions', $post_entry) === FALSE) {
          $error = 1;
          echo $error;
	
        }
        else {
           echo "<script type=\"text/javascript\">
						alert(\"Commissions added successfully!\");
						window.location='admin.php?page=commissions_page'
						
					</script>";
        }
		
  }	
		
		?>
  <div class="container">
    <div class="row">
 <div class="col-md-6"> 		
	 <h1>Add Commission</h1> 
<form action="admin.php?page=addcommissionspage" method="post">
  <input type="hidden" name="add_Commissions" value="add_Commissions">
  <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">From amt</label>
  <div class="col-10">
    <input class="form-control" name="from_amt" type="text"
	value="<?php echo $resultdata[0]->from_amt;?>"  id="example-text-input" required>
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">to amt</label>
  <div class="col-10">
    <input class="form-control" name="to_amt" type="text"
	value="<?php echo $resultdata[0]->to_amt;?>"  id="example-text-input">
  </div>
 </div>
 <div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Percent</label>
  <div class="col-10">
    <input class="form-control" name="percent" type="text"
	value="<?php echo $resultdata[0]->percent;?>" id="example-text-input">
  </div>
 </div>
 
 <?php submit_button('Update'); ?>
</form>	
</div>		
</div>		
</div>		
<?php		
	}