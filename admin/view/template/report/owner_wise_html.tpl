<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<?php foreach($final_datass as $fkeyss => $final_datas) { ?>  
<div style="page-break-after: always;">
  <h1 style="text-align:center;">
    <?php echo $title; ?><br />
    <p style="display:inline;font-size:13px;"><?php echo 'Period : '. $date_start . ' - ' . $date_end; ?></p>
    <p style="display:inline;font-size:12px;"><?php echo 'Trainer Name : ' . $final_datas[0]['trainer_name']; ?></p>  
  </h1>
  <table class="product">
    <tr class="heading">
      <td class="left"><?php echo 'Sr.No'; ?></td>
      <td align="left"><b><?php echo 'Horse Name'; ?></b></td>
      <td align="left"><b><?php echo 'Owner'; ?></b></td>
    </tr>
    <?php 
	$i = 1; 
  	$total = 0;
    ?>
    <?php foreach ($final_datas as $fkey => $final_data) { ?>
      <tr>
        <td class="left"><?php echo $i; ?></td>
        <td align="left"><?php echo $final_data['horse_name']; ?></td>
        <td align="left"><?php echo $final_data['owner_name']; ?></td>
      </tr>
      <?php 
	$i++; 
      ?>
    <?php } ?>
  </table>
  <table class="store" style="margin-bottom:0px;">
    <tr>
      <td colspan="2" align="center">
        <?php echo 'Powered By E & A InfoTech'; ?> 
      </td>
    </tr>
  </table>
</div>
<?php } ?>
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
