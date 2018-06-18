<?php
function cunvertpdf(){
	global $wpdb;
if($_GET['pid']){   
    $pid = trim($_GET['pid']);
//$con = mysqli_connect('localhost','rupak_db','future@123','rupak_report');
 //$data = mysqli_query($con,'select * from wp_payments where id=1');

 //$rdata = mysqli_fetch_array($data);
 $sqlq = "select D.*,P.* from wp_disbursals as D ,wp_affliate_partner as P where P.Partner_Id = D.Partner_Id group by D.disbursal_date";
$sqluser = "select * from wp_affliate_partner where Partner_Id LIKE '%$pid%'";
 $sqlpayment = "select R.*,P.* from wp_referrals as R,wp_payments as P where P.crm_id = R.crm_id and R.partner_Id LIKE '%$pid%' and P.sms_sent='Y' and P.referral_paid = 'N' group by P.payment_id";

 $countsqlpayment = "select count(*) as data_count,R.*,P.* from wp_referrals as R,wp_payments as P where P.crm_id = R.crm_id and R.partner_Id LIKE '%$pid%' group by R.crm_id";
$countsqlpaymentr = $wpdb->get_results($countsqlpayment); 
 $udata = $wpdb->get_results($sqluser);

 if($countsqlpaymentr[0]->data_count >0){
 $pwdata = $wpdb->get_results($sqlpayment) or die(mysql_error());
 }
 
 $sqlpcount= "select count(*) as count_data from wp_disbursals where partner_Id LIKE '%$pid%'";
 $sqlpcountdata = "select * from wp_disbursals where partner_Id LIKE '%$pid%'";
 
 $sqlpcountrrr = $wpdb->get_results($sqlpcount);
  if($sqlpcountrrr[0]->count_data >0){
 $pdatarrrr = $wpdb->get_results($sqlpcountdata);
  }
//  print_r($udata);
// exit;
require_once("mpdf/mpdf.php"); 
$mpdf=new mPDF();
$currentdate = date('Y-m-d');
 $myhtml='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Report</title>

                </head>

                <body>
				<table width="50%" border="0" style="margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12px;table-layout:fixed;">
				<thead></thead>
				<tbody>
				   <tr>
                    <td style="text-align:center;margin-left:40px">
                        <h1 style="margin-left:20px;">Caboutu</h1>
                    </td>
                  </tr>
				<tr>
					<td><b>First Name</b></td>
					<td>'.$udata[0]->First_Name.'</td>
				</tr>
					<tr>
					<td><b>Last Name</b></td>
					<td>'.$udata[0]->Last_Name.'</td>
				</tr>
				</tr>
				<tr>
					<td><b>Partner Id:</b></td>
					<td>'.$udata[0]->Partner_Id.'</td>
				</tr>
				<tr>
					<td><b>Bank A/c No:</b></td>
					<td>'.$udata[0]->Bank_Ac_Number.'</td>
				</tr>
				</tbody>
				</table>
					
              <table width="100%" border="1" cellpadding="2" cellspacing="0" style="margin-top:10px">
				<thead>
				  <tr>
                    <th style="color:#fff;background-color:#000;">Current Cycle</th>
                  </tr>
			       <tr>
                    <th>Partner Id</th>
                    <th>CRM Id</th>
                    <th>Payment Id</th>
                    <th>Payment Amt</th>
                    <th>Payment Date</th>
                  </tr>
				</thead>
				<tbody>';
				 if($countsqlpaymentr[0]->data_count >0){
					foreach($pwdata as $row){
					    
					  $yrdata= strtotime($row->payment_date);
                       $payment_date = date('d-M-Y', $yrdata);
				
                 $myhtml.= '<tr style="background:#f9f9f9;">
                    <td>'.$row->partner_Id.'</td>
                    <td>'.$row->crm_id.'</td>
                    <td>'.$row->payment_id.'</td>
                    <td>'.$row->payment_amount.'</td>
                    <td>'.$payment_date.'</td>'; 
				 $myhtml.='</tr>';} }
 
           
				$myhtml.='</tbody>

                </table>
				
				<table width="100%" border="1" cellpadding="2" cellspacing="0" style="margin-top:50px">
				<thead>
				  <tr>
                    <th style="color:#fff;background-color:#000;">Previous Cycles</th>
                  </tr>
			       <tr>
                    <th>Month</th>
                    <th>Referred</th>
                    <th>Converted</th>
                    <th>Referral Amt</th>
                    <th>Disbursal Date</th>
                  </tr>
				</thead>
					<tbody>';
			
				 if($sqlpcountrrr[0]->count_data >0){     
					foreach($pdatarrrr as $row){
					    
					   $yrmdata= strtotime($row->mnth);
                       $mnth = date('M-y', $yrmdata);
                       
                      $yrdata= strtotime($row->disbursal_date);
                       $disbursal_date = date('d-M-Y',$yrdata);
				
                 $myhtml.= '<tr style="background:#f9f9f9;">
                    <td>'.$mnth.'</td>
                    <td>'.$row->tot_referred.'</td>
                    <td>'.$row->tot_converted.'</td>
                     <td>'.$row->tot_referral_amount.'</td>
                    <td>'.$disbursal_date.'</td>'; 
				 $myhtml.='</tr>';} }
 
           
				$myhtml.='</tbody>

                </table>
					
			       <div>

                  <p height="20px" style="text-align:center;border:none;font-weight:bold;">Copyright © '.date('Y').' Caboutu.All rights Reserved.</p>
                  </div>
					
                </body>
                </html>';
               $nomFacture = $pid."_".date('Y-m-d').".pdf";
                $filename = $nomFacture;
                $path = plugin_dir_path(__FILE__).'pdf_all';
                $file = $path . "/" . $filename;
                $mpdf->WriteHTML($myhtml);
               $mpdf->Output($file); 
               $file_url = plugin_dir_url( __FILE__ ).'pdf_all/'.$filename;
			if($file){
				echo '<a href="'.$file_url.'" class="btn btn-success" target="_blank">Get Report</a>';
			}
}else{
     echo "<script type=\"text/javascript\">
						alert(\"Invalid Partner\");
					window.location='admin.php?page=disbursalreport'
					</script>";
}		
}
                