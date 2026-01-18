<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo 'Owner Statement'; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<div style="page-break-after: always;">
  <h3><?php echo 'Doctor Name : ' . $doctor_name; ?></h3>
  <h3 style="display: none;"><?php echo 'Owner Name : ' . $final_datas[0]['owner_name']; ?></h3>
  <table class="product">
    <tr class="heading">
      <td align="left"><b><?php echo 'Bill Id'; ?></b></td>
      <td align="left"><b><?php echo 'Horse Name'; ?></b></td>
      <td align="left"><b><?php echo 'Trainer Name'; ?></b></td>
      <td align="left"><b><?php echo 'Owner Name'; ?></b></td>
      <td align="left"><b><?php echo 'Share'; ?></b></td>
      <td align="left"><b><?php echo 'Month'; ?></b></td>
      <td align="right"><b><?php echo 'Total'; ?></b></td>
      <td align="right"><b><?php echo 'Balance'; ?></b></td>
      <td class="right"><?php echo 'Status'; ?></td>
    </tr>
    <?php 
    $i = 1; 
    $balance_total = 0;
    $total = 0;
    ?>
    <?php foreach ($final_datas as $fkey => $final_data) { ?>
      <tr>
        <td align="left"><?php echo $final_data['bill_id']; ?></td>
        <td align="left"><?php echo $final_data['horse_name']; ?></td>
        <td align="left"><?php echo $final_data['trainer_name']; ?></td>
        <td align="left"><?php echo $final_data['owner_name']; ?></td>
        <td align="left"><?php echo $final_data['share']; ?></td>
        <td align="left"><?php echo $final_data['month']; ?></td>
        <td align="right"><?php echo $final_data['total']; ?></td>
        <td class="right"><?php echo 'Rs.',$final_data['balance']; ?></td>
        <td class="right">
            <?php if($final_data['payment_status'] == 1) {?>
              <?php echo 'Paid'; ?>
            <?php } else {?>
              <?php echo 'Unpaid'; ?>
             <?php }?>
        </td>
             
      </tr>
      <?php 
        $i++; 
        $total = $total + $final_data['raw_total'];
        $balance_total = $balance_total + $final_data['balance'];          
      ?>
    <?php } ?>
    <tr>
      <td colspan="6"></td>
      <td align="right">
        <?php echo "Rs. ".my_money_format($total); ?> 
      </td>
      <td class="right">
        <?php echo "Rs. ".my_money_format($balance_total); ?> 
          
        </td>
    </tr>
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
