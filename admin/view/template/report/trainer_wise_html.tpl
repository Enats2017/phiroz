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
  <h1 style="text-align:center;">
    <?php echo $title; ?><br />
    <p style="display:inline;font-size:15px;"><?php echo 'Period : '. $date_start . ' - ' . $date_end; ?><p>
  </h1>
  <table class="product">
    <tr class="heading">
      <td class="left"><?php echo 'Sr.No'; ?></td>
      <td align="left"><b><?php echo 'Trainer'; ?></b></td>
      <td align="left"><b><?php echo 'Date Of Treatment'; ?></b></td>
      <td align="left"><b><?php echo 'Horse Name'; ?></b></td>
      <td align="left"><b><?php echo 'Medicine Name'; ?></b></td>
      <td align="right"><b><?php echo 'Qty'; ?></b></td>
      <td align="right"><b><?php echo 'Total'; ?></b></td>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($final_datas as $fkey => $final_data) { ?>
      <tr>
        <td class="left"><?php echo $i; ?></td>
        <td align="left"><?php echo $final_data['trainer_name']; ?></td>
        <td align="left"><?php echo $final_data['date_treatment']; ?></td>
        <td align="left"><?php echo $final_data['horse_name']; ?></td>
        <td align="left"><?php echo $final_data['medicine_name']; ?></td>
        <td align="right"><?php echo $final_data['medicine_quantity']; ?></td>
        <td align="right"><?php echo $final_data['total']; ?></td>
      </tr>
      <?php $i++; ?>
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
</body>
</html>