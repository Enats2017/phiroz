<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo 'Owner Bill'; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<div style="page-break-after: always;">
  <!-- <h3><?php echo 'Doctor Name : ' . $doctor_name; ?></h3> -->
  <!-- <h3 ><?php echo 'Owner Name : ' . $final_datas[0]['owner_name']; ?></h3> -->
  <table class="store" style="margin-bottom:0px;">
      <tr>
        <td>
          <table>
            <tr>
              <td>
                <b style="font-size:16px;"><?php echo 'To'; ?></b>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;">
                <?php echo $final_datas[0]['owner_name'] . ','; ?>
              </td>
            </tr>
            <tr style="display: none;">
              <td>
                <?php echo 'R. W. I. T. C LTD.'; ?>
              </td>
            </tr>
            <tr style="display: none;">
              <td >
                <?php echo 'Mumbai / Pune'; ?>
              </td>
            </tr>
          </table>
        </td>
        <td align="right" valign="top">
          <table>
            <tr>
              <td>
                <b><?php echo 'Mumbai / Pune'; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Date: '. date('d M, Y'); ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Bank Details : Phiroz Talib Khambatta'; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Saving Acc No : 000501023668'; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'ICICI Bank, Bund garden road Branch, <br /> pune'; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'IFSC code : ICIC0000005'; ?></b>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b><?php echo 'Dear Sir, <br /> Following is a statement of your share of veterinary bills for treatment done on your horses by Dr. Phiroz Talib Khambatta in the month of . Kindly settle these dues as soon as possible.';  ?></b>
        </td>
      </tr>
    </table>
  <table class="product">
    <tr class="heading">
      <td align="left" colspan="2"><b><?php echo 'Bill Id'; ?></b></td>
      <td align="left" colspan="2"><b><?php echo 'Owner Name'; ?></b></td>
      <td align="left" colspan="2"><b><?php echo 'Month'; ?></b></td>
      <td align="right" colspan="2"><b><?php echo 'Total'; ?></b></td>
       <td class="right" colspan="2"><?php echo 'balance'; ?></td>
      <td class="right" colspan="2"><?php echo 'Status'; ?></td>
    </tr>
     <?php $total1 = 0; ?>
     <?php $balance_total = 0; ?>
    <?php 
    $i = 1; 
    $total1 = 0;
    ?>
    <?php foreach ($final_datas as $fkey => $final_data) { ?>
      <tr>
      <td align="left"  colspan="2"><?php echo $final_data['bill_id']; ?></td>
      <td align="left"  colspan="2"><?php echo $final_data['owner_name']; ?></td>
      <td align="left"  colspan="2"><?php echo $final_data['month']; ?></td>
      <td align="right" colspan="2"><?php echo 'Rs.',$final_data['total']; ?></td>
      <td class="right" colspan="2"><?php echo 'Rs.',$final_data['balance']; ?></td>
      <td class="right" colspan="2">
      <?php if($final_data['payment_status'] == 1) {?>
        <?php echo 'Paid'; ?>
      <?php } else {?>
        <?php echo 'Unpaid'; ?>
       <?php }?>
      </td>
      </tr>
      <?php 
      $i++; 
      $total1 = $total1 + $final_data['raw_total'];
      $balance_total = $balance_total + $final_data['balance'];          
      ?>
    <?php } ?>
    <tr>
       <td colspan="6" align="right" style="font-weight: bolder">Total :</td>
      <td align="right" colspan="2" style="font-weight:bolder; padding:10px; font-size: 15px;" >
        <?php echo "Rs. ".my_money_format($total1); ?> 
      </td>
       <td align="right" colspan="2" style="font-weight:bolder; padding:10px; font-size: 15px;">
        <?php echo "Rs. ",$balance_total; ?></td>
      <td colspan="2"> </td>
    </tr>
  </table>

<!------------------------------------------- debit amount ------------------------------------------------------>
  <table class="product">
    <tr class="heading">
      <td align="left" colspan="2"><b><?php echo 'Owner Name'; ?></b></td>
      <td align="right" colspan="2"><b><?php echo 'Comment'; ?></b></td>
      <td align="left" colspan="2"><b><?php echo 'Debit Amount'; ?></b></td>
    </tr>
    <?php $total2 = 0; ?>
    <?php 
    $i = 1; 
    $total2 = 0;
    ?>
    <?php foreach ($bill_debits as $final_data) { ?>
      <tr>
      <td align="left"  colspan="2"><?php echo $final_data['owner_name']; ?></td>
      <td align="left"  colspan="2"><?php echo $final_data['comment']; ?></td>
      <td align="right" colspan="2"><?php echo $final_data['debit_amount']; ?></td>
      </tr>
      <?php   
       $i++; 
       $total2 = $total2 + $final_data['debit_amount'];         
      ?>
    <?php } ?>
    <tr>
      <td colspan="4"></td>
      <td align="right" style="font-weight:bolder; padding:10px; font-size: 15px;">
        <?php echo "Rs. ".my_money_format($total2); ?> 
      </td>
    </tr>
  </table>

  <!------------------------------------------- Credit amount ------------------------------------------------------>
  <table class="product">
    <tr class="heading">
      <td align="left" colspan="2"><b><?php echo 'Owner Name'; ?></b></td>
      <td align="right" colspan="2"><b><?php echo 'Comment'; ?></b></td>
      <td align="left" colspan="2"><b><?php echo 'Credit Amount'; ?></b></td>
    </tr>
    <?php $total3 = 0; ?>    
    <?php 
    $i = 1; 
    $total3 = 0;
    ?>
    <?php foreach ($bill_credits as $final_data) { ?>
      <tr>
      <td align="left"  colspan="2"><?php echo $final_data['owner_name']; ?></td>
      <td align="left"  colspan="2"><?php echo $final_data['comment']; ?></td>
      <td align="right" colspan="2"><?php echo $final_data['credit_amount']; ?></td>
      </tr>
      <?php   
       $i++; 
       $total3 = $total3 + $final_data['credit_amount'];         
      ?>
    <?php } ?>
    <tr>
      <td colspan="4"></td>
      <td align="right" style="font-weight:bolder; padding:10px; font-size: 15px;">
        <?php echo "Rs. ".my_money_format($total3); ?> 
      </td>
    </tr>
  </table><br/>

   <table style="margin:auto;">
        <thead>
          <?php  {  $total_a = $total1 + $total2;  $total_amount = $total_a - $total3;?>

          <tr>
            
            <td colspan="6" style="font-size:25px;">Total Amount : <?php echo $total_amount ?></td>
          </tr>
          <?php } ?>
        </thead>
      </table>

</div>
</body>
</html>
<?php
function my_money_format($number) 
{ 
    //$number = '2953154.83';

    $negative = '';
    if(strstr($number,"-")) 
    { 
        $number = str_replace("-","",$number); 
        $negative = "-"; 
    } 
    
    $split_number = @explode(".",$number); 
    $rupee = $split_number[0]; 
    if(isset($split_number[1])){
      $paise = @$split_number[1]; 
    } else {
      $paise = '00';
    }
    
    if(@strlen($rupee)>3) 
    { 
        $hundreds = substr($rupee,strlen($rupee)-3); 
        $thousands_in_reverse = strrev(substr($rupee,0,strlen($rupee)-3)); 
        $thousands = '';
        
        for($i=0; $i<(strlen($thousands_in_reverse)); $i=$i+2) 
        {
            if(isset($thousands_in_reverse[$i+1])){
              $thousands .= $thousands_in_reverse[$i].$thousands_in_reverse[$i+1].","; 
            } else {
              $thousands .= $thousands_in_reverse[$i].","; 
            }
        } 
        $thousands = strrev(trim($thousands,",")); 
        $formatted_rupee = $thousands.",".$hundreds; 
    } else { 
        $formatted_rupee = $rupee; 
    } 
    
    $formatted_paise = '.00';
    if((int)$paise>0) 
    { 
        $formatted_paise = ".".substr($paise,0,2); 
    } 
    
    return $negative.$formatted_rupee.$formatted_paise; 

}
?>
