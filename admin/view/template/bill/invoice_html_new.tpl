<?php if(!isset($html_show)) { ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<?php } ?>
<?php foreach ($final_datas as $fkey => $final_data) { ?>
  <?php foreach ($final_data as $key => $data) { ?>
  <div style="page-break-after: always;margin-left:30px;margin-right:10px;">
    <h1 style="text-align:center;"><?php echo $text_invoice; ?></h1>
    <table class="store" style="margin-bottom:0px;">
      <tr>
        <td>
          <table>
            <tr>
              <td>
                <b style="font-size:18px;"><?php echo $data['doctor_name']; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <?php //echo '1202 Forum, Uday Baug'; ?>
                <?php echo $address_1; ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php //echo 'Pune, Maharashtra 4110313'; ?>
                <?php echo $address_2; ?>
              </td>
            </tr>
            <tr>
              <td style="padding-top:40px;">
                <b style="font-size:11px;"><?php echo $data['owner_name']; ?></b>
              </td>
            </tr>
          </table>
        </td>
        <td align="right" valign="top">
          <table>
            <tr>
              <td>
                <?php echo 'Tel: '. $telephone; ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $email; ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table class="address">
      <tr class="heading">
        <td style="width:100%"><?php echo 'Invoice No: '; ?><b><?php echo  $data['bill_id'] . '  ' . $data['month'] .' '. $data['year']; ?></b></td>
      </tr>
      <tr>
        <td style="width:100%">
          <b style="font-size:11px;"><?php echo $data['horse_name'] . ' (' . $data['owner_share'] . '%)'; ?></b>
      </tr>
    </table>
  
    <table class="product">
      <tr class="heading">
        <td><b><?php echo 'Date'; ?></b></td>
        <td style="display: none;"><b><?php echo 'Medicine Code'; ?></b></td>
        <td><b><?php echo 'Description'; ?></b></td>
        <!-- <td><b><?php echo 'Name'; ?></b></td> -->
        <td align="right"><b><?php echo 'Qty'; ?></b></td>
        <td align="right"><b><?php echo 'Fees'; ?></b></td>
      </tr>
      <!-- <?php $medicine_total = 0.00; ?>
      <?php foreach ($data['transaction_data'] as $medicine) { ?>
      <tr>
        <td style="width:15%;font-size:11px;"><?php echo $medicine['dot']; ?></td>
        <td style="font-size:11px;"><?php echo $medicine['medicine_name']; ?></td>
        <td style="font-size:11px;"><?php echo $medicine['treatment_name']; ?></td>
        <td style="font-size:11px;" align="right"><?php echo $medicine['medicine_quantity']; ?></td>
        <td style="font-size:11px;" align="right"><?php echo $medicine['medicine_total']; ?></td>
      </tr>
      <?php $medicine_total = $medicine_total + $medicine['medicine_total']; ?>
      <?php } ?> -->

      <?php $medicine_total_1 = 0.00; ?>
      <?php foreach ($data['medicine_datas'] as $medi) { //echo "<pre>";print_r($medi);?>
      <tr>
        <td style="width:15%;font-size:11px;"><?php echo $medi['dot']; ?></td>
        <td style="font-size:11px;"><?php echo $medi['medicine_name']; ?></td>
        <!-- <td style="font-size:11px;"><?php echo $medi['treatment_name']; ?></td> -->
        <td style="font-size:11px;" align="right"><?php echo $medi['medicine_quantity']; ?></td>
        <td style="font-size:11px;" align="right"><?php echo $medi['medicine_total']; ?></td>
      </tr>
      <?php $medicine_total = $medicine_total + $medi['medicine_total']; ?>
      <?php } //exit;?>
      <!-- <?php $medicine_total_2 = $medicine_total + $medicine_total_1; ?> -->

      <tr>
        <td align="right" colspan="4"><b><?php echo 'Total Amount Rs'; ?>:</b></td>
        <td align="right"><?php echo my_money_format($medicine_total); ?></td>
      </tr>
      <tr>
        <td align="right" colspan="4"><b><?php echo 'Payable Amount as per share (' . $data['owner_share'] .' %) Rs'; ?>:</b></td>
        <td align="right"><?php echo my_money_format($data['owner_share_amount']); ?></td>
      </tr> 
    </table>
    <table class="store" style="margin-bottom:0px;">
      <tr>
        <td>
          <table>
            <tr>
              <td>
                <?php echo 'Trainer :' ?><b style="font-size:11px;"><?php echo $data['trainer_name']; ?></b>
              </td>
            </tr>
          </table>
        </td>
        <td align="right" valign="top">
          <table>
            <tr>
              <td>
                <?php echo 'Your Faithfully'; ?>
              </td>
            </tr>
            <tr>
              <td style="padding-top :30px;">
                <?php echo $data['doctor_name'];  ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <?php } ?>
<?php } ?>
<?php if(!isset($html_show)) { ?>
</body>
</html>
<?php } ?>
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
