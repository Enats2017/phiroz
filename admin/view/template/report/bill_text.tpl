<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
<style>
  .product,.heading1{
    border:1px solid black;
    border-collapse: collapse;
  }
  .heading1{
    width:200px;
  }
 </style>
</head>
<body>
<div>
    <div >
       <b> <?php echo "Dear Sir, "; ?><b><b style="font-size:15px;"><?php echo $owner_name.''; ?></b>
    </div>
    <br>
    <div style="font-size:15px;">
     <?php echo "The following is the statement of account for horses owned by <b>" .$owner_name. "</b> for treatment done by Dr. P. T. Khambatta in  <b>".date('d-M-Y',strtotime($filter_date_start)) ."</b> To <b>".date('d-M-Y',strtotime($filter_date_end)) ."</b>"; ?>
    </div>
        <table class="product" >
            <tr class="heading1" style="background-color: #E7EFEF;">
              <td align="center" colspan="2" class="heading1"><b><?php echo 'Bill Id'; ?></b></td>
              <td align="center" colspan="2" class="heading1" ><b><?php echo 'Owner Name'; ?></b></td>
              <td align="center" colspan="2" class="heading1" ><b><?php echo 'Trainer Name'; ?></b></td>
              <td align="center" colspan="2" class="heading1" ><b><?php echo 'Month'; ?></b></td>
              <td align="center" colspan="2" class="heading1" ><b><?php echo 'Share'; ?></b></td>
              <td align="center" colspan="2" class="heading1" ><b><?php echo 'Total'; ?></b></td>
              <!-- <td align="center" colspan="2" class="heading1" ><b><?php echo 'balance'; ?></b></td> -->
            </tr>
             <?php $total1 = 0; ?>
             <?php $balance_total = 0; ?>
            <?php 
            $i = 1; 
            $total1 = 0;
            ?>
            <?php foreach ($final_datas as $fkey => $final_data) {  ?>  <!-- echo"<pre>"; print_r($final_datas); exit; -->

              <tr class="heading1">
              <td align="center"  colspan="2" class="heading1" ><b><?php echo $final_data['bill_id']; ?></b></td>
              <td align="center"  colspan="2" class="heading1" ><b><?php echo $final_data['owner_name']; ?></b></td>
              <td align="center"  colspan="2" class="heading1" ><b><?php echo $final_data['trainer_name']; ?></b></td>
              <td align="center"  colspan="2" class="heading1" ><b><?php echo $final_data['month']; ?></b></td>
              <td align="center"  colspan="2" class="heading1" ><b><?php echo $final_data['owner_share']; ?></b></td>
              <td align="center" colspan="2" class="heading1" ><b><?php echo 'Rs.',$final_data['total']; ?></b></td>
              <!-- <td align="center" colspan="2" class="heading1"><b><?php echo 'Rs.',$final_data['balance']; ?></b></td> -->
              </tr>
              <?php 
              $i++; 
              $total1 = $total1 + $final_data['raw_total'];
              $balance_total = $balance_total + $final_data['balance'];          
              ?>
            <?php } ?>
            <tr class="heading1">
               <td colspan="10" align="right" class="heading1" style="font-weight: bolder; border: 1px solid black;"><b>Total :</b></td>
              <!--  <td align="center" colspan="2" class="heading1" style="font-weight:bolder; padding:10px; font-size: 15px; ">
                <?php echo "Rs. ",$balance_total; ?></td> -->
              <td align="center" colspan="2" class="heading1" style="font-weight:bolder; padding:10px; font-size: 15px; " >
                <?php echo "Rs. ".my_money_format($total1); ?> 
              </td>
            </tr>
        </table>
        <table>
          <tr>
            <td style="padding-top:15px; font-weight:5px; font-family:'Courier New';">
              <b><?php echo "We request you to clear the bills at your earliest ."; ?></b>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px;">
              <span style="font-size:18px; font-family:'Courier New';"><b><?php echo "Bank details are as follows,"; ?></b></span><br>
              <span style="font-size:16px;font-family:'Courier New';"><b><?php echo "Name:DR.PHIROZ TALIB.KHAMBATTA"; ?></b></span><br>
              <span style="font-size:14px; font-family:Times New Roman,Times,serif;">BANK NAME :ICICI BANK,</span><br>
              <span style="font-family:'Courier New';"><b>A/c No.000501023668</b></span><br>
              <span  style="font-family:'Courier New';"><b>Branch:Bund Garden Road,Pune</b></span><br>
              <span style="font-family:'Courier New';"><b>IFSC CODE; ICIC0000005</b></span>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px; font-family:'Courier New'; ">
              <b><?php echo "Thanking you"; ?></b>
            </td>
          </tr>
          <br />
          <!-- <tr>
            <td style="padding-top:15px; font-family:'Courier New';">
             <b> <?php echo "Regards,"; ?></b>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px; font-family:'Courier New';">
              <b><?php echo "Aditya Singh"; ?><b>
            </td>
          </tr> -->
          <tr>
            <td style="padding-top:15px; font-family:'Courier New';">
              <b><?php echo "Accounts Department"; ?></b>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px; font-family:'Courier New';">
             <b> <?php echo "Dr.Phiroz Khambatta"; ?></b>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px; font-family:'Courier New';">
              <b><?php echo "Contact No:-9371108208"; ?></b>
            </td>
          </tr>
          <br>
          <tr>
            <td style="padding-top:15px; font-family:'Courier New';">
              <b><?php echo $path; ?></b>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</body>
</html>