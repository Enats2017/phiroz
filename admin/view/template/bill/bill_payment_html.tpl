<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<div style="page-break-after: always;">
  <h3 style="text-align:center;">
    <p style="display:inline;"><?php echo ''; ?></p><br />
  </h3>
  <table class="product">
    <thead>
      <thead>
      <tr>
        <td class="left" style="width:4%;"><?php echo 'BILL NO'; ?></td>
        <td class="left" style="width:7%;"><b><?php echo 'TRAINER'; ?></b></td>
        <td class="left" style="width:20%;"><b><?php echo 'HORSE'; ?></b></td>
        <td class="right" style="width:12%;"><b><?php echo 'AMOUNT'; ?></b></td>
        <td class="left" style="width:12%;"><b><?php echo 'MONTH/YR'; ?></b></td>
        <td class="left" style="width:12%;"><b><?php echo 'VET BILL'; ?></b></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($final_datas) { ?>
        <?php 
          $total = 0;
        ?>
        <?php foreach ($final_datas as $order) { ?>
          <tr>
            <td class="left"><?php echo $order['BILLNO']; ?></td>
            <td class="left"><?php echo $order['TRAINER']; ?></td>
            <td class="left"><?php echo $order['HORSE']; ?></td>
            <td class="right"><?php echo my_money_format($order['AMOUNT']); ?></td>
            <td class="left"><?php echo $order['MONTH/YR']; ?></td>
            <td class="left"><?php echo $order['VETBILL']; ?></td>
          </tr>
          <?php 
            $total = $total + $order['AMOUNT'];
          ?>
        <?php } ?>
        <tr>
          <td colspan="2"></td>
          <td align="right">Total</td>
          <td align="right"><?php echo my_money_format($total); ?></td>
          <td colspan="2"></td>
        </tr>
      <?php } else { ?>
      <tr>
        <td class="center" colspan="6"><?php echo 'No Results!'; ?></td>
      </tr>
      <?php } ?>
    </tbody>
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