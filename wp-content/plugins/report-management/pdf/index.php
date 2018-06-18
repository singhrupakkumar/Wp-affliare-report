<?php
$con = mysqli_connect('localhost','rupak_db','future@123','rupak_report');
 $data = mysqli_query($con,'select * from wp_payments where id=1');
 $rdata = mysqli_fetch_array($data);
// require('fpdf.php');
// $pdf = new FPDF();
// $pdf->AddPage();
// $row=file('toys.txt');
// $pdf->SetFont('Arial','B',12);	
// foreach($rdata as $rowValue) {
// 	$data=explode(';',$rowValue);
// 	foreach($data as $columnValue)
// 		$pdf->Cell(90,12,$columnValue,1);
// 		$pdf->SetFont('Arial','',12);		
// 		$pdf->Ln();
// }
// $pdf->Output();
require_once("MPDF57/mpdf.php"); 
$mpdf=new mPDF();
$currentdate = date('Y-m-d');
 $myhtml='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Report</title>

                </head>

                <body>

                <table width="600" border="0" style="margin:0px auto; font-family:Arial, Helvetica, sans-serif; font-size:12px;table-layout:fixed;">
                  <tr>
                    <td style="text-align:center;">
                        <h1 style="margin:0;">True Laboratories LLC</h1>
                    </td>
                  </tr>
                   <tr>
                    <td style="text-align:center;">
                        <p style="margin-top:0;"><b>Oak Forest, IL. 60452. Tel No (708) 620-5790. Fax No (708) 620-5215</b></p><br />
                    </td>
                  </tr>
                  <tr>
                    <td style="border:none; padding:0;">
                        <table width="100%" border="0" cellpadding="10" cellspacing="0">
                  <tr>
                    <td style="border:1px solid #bababa; border-right:none;">PATIENT LAST NAME :</td>
                    <td style="border:1px solid #bababa; border-right:none;">'.$rdata['id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none;">REQUEST DATE :</td>
                    <td style="border:1px solid #bababa;">'.$currentdate.'</td>
                  </tr>
                  <tr>

                  <tr style="background:#f9f9f9;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">PATIENT FIRST NAME :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">CLINIC/AGENCY NAME :</td>';
                    if($rdata['crm_id'] != NULL){
                      $myhtml.='<td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>';
                    }else{
                      $myhtml.='<td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>';  
                    }    
                  $myhtml.='</tr>
                  <tr style="background:#fff;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">DATE OF BIRTH :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">OFFICE NUMBER :</td>';
                    if($rdata['crm_id'] != NULL){
                      $myhtml.='<td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>';
                    }   
                  $myhtml.='</tr>

                  <tr style="background:#f9f9f9;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">AGE :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">FAX NUMBER :</td>
                    ';
                    if($rdata['crm_id'] != NULL){
                      $myhtml.='<td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>';
                    }else{
                      $myhtml.='<td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>';  
                    }
                    
                  $myhtml.='</tr>

                  <tr style="background:#fff;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">GENDER :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">ADDRESS :</td>
                    <td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].','.$rdata['crm_id'].'</td>
                  </tr>

                  <tr style="background:#f9f9f9;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">PHONE NUMBER :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">CITY, STATE, ZIP CODE :</td>
                    <td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].','.$rdata['crm_id'].','.$rdata['crm_id'].'</td>
                  </tr>

                  <tr style="background:#fff;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">ADDRESS :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">DOCTOR NAME :</td>
                    <td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>
                  </tr>

                  <tr style="background:#f9f9f9;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">ADDRESS2 :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">DOCTOR NPI NO. :</td>
                    <td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>
                  </tr>

                  <tr style="background:#fff;">
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">PATIENT INSURANCE NAME :</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">'.$rdata['crm_id'].'</td>
                    <td style="border:1px solid #bababa; border-right:none; border-top:none;">PATIENT INSURANCE NUMBER :</td>
                    <td style="border:1px solid #bababa; border-top:none;">'.$rdata['crm_id'].'</td>
                  </tr>

                  <tr>

                    <td style="border:1px solid #bababa; border-bottom:none;" colspan="4"><p>I AUTHORIZE THE RELEASE OF MY INSURANCE CARRIER OF ANY MEDICAL INFORMATION NECESSARY TO PROCESS THIS CLAIM AND I AUTHORIZE PAYMENT OF MEDICAL BENEFITS DIRECTLY TO TRUE LABORATORIES LLC.</p></td>
                  </tr>
                  <tr>
                        <td colspan="2" style="border:1px solid #bababa; border-right:none;">
                        PATIENT’S SIGNATURE
                    </td>
                 
                  </tr>

                </table>

                    </td>
                  </tr>
                </table>


                </body>
                </html>';
               $nomFacture = time().".pdf";
                $filename = $nomFacture;

                $path = 'MPDF57/pdf';
                $file = $path . "/" . $filename;
  
                $mpdf->WriteHTML($myhtml);
                $mpdf->Output($file, 'F'); 
                $mpdf->Output($file, 'D');
?>