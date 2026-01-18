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
    <p style="display:inline;font-size:15px;"><?php echo 'Month : ' . $month . ' | ' .  'Year : ' . $year; ?><p>
  </h1>
  <table class="product">
    <tr class="heading">
      <td class="left"><?php echo 'Sr.No'; ?></td>
      <td align="left"><b><?php echo 'Bill Id'; ?></b></td>
      <td align="left"><b><?php echo 'Owner'; ?></b></td>
      <td align="left"><b><?php echo 'Horse Name'; ?></b></td>
      <td align="left"><b><?php echo 'Trainer'; ?></b></td>
      <td align="right"><b><?php echo 'Total'; ?></b></td>
      <td align="right"><b><?php echo 'Total Received'; ?></b></td>
      <td align="right"><b><?php echo 'Total Pending'; ?></b></td>
      <td class="right"><b><?php echo 'Cheque No'; ?></b></td>
      <td class="right"><b><?php echo 'Payment Type'; ?></b></td>
    </tr>
    <?php 
      $i = 1; 
    ?>
    <?php foreach ($final_datas as $fkey => $final_data) { ?>
      <tr>
        <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $final_data['bill_id']; ?></td>
            <td class="left"><?php echo $final_data['owner_name']; ?></td>
            <td class="left"><?php echo $final_data['horse_name']; ?></td>
            <td class="left"><?php echo $final_data['trainer_name']; ?></td>
            <td class="right"><?php echo $final_data['total']; ?></td>
            <td class="right"><?php echo $final_data['total_received']; ?></td>
            <td class="right"><?php echo $final_data['total_pending']; ?></td>
            <td class="right"><?php echo $final_data['cheque_no']; ?></td>
            <td class="right"><?php echo $final_data['payment_type']; ?></td>
      </tr>
      <?php 
        $i++;
      ?>
    <?php } ?>
      <tr>
        <td colspan="5">
        </td>
        <td class="right">
          <?php echo $raw_total; ?>
        </td>
        <td class="right">
          <?php echo $raw_total_received; ?>
        </td>
        <td class="right">
          <?php echo $raw_total_pending; ?>
        </td>
        <td colspan="2">
        </td>
      </tr>
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