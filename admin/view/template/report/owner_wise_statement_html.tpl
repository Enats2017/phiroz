<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $titleshead; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<div style="page-break-after: always;">
  <p style="display:inline;font-size:15px;"><?php echo 'Date : '; ?><b><?php echo $tdate; ?></b><p>
  <h2 style="text-align:left;">
    <?php echo $title; ?>
  </h2>
  <table class="product">
    <tr class="heading">
      <td class="left" style="width:6%;"><?php echo "Sr.No"; ?></td>
      <td class="left" style="width:6%;"><?php echo $column_invoice_no; ?></td>
      <td class="left"><?php echo $column_trainer_name; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
      <td class="left"><?php echo $column_horse_name; ?></td>
      <td class="left"><?php echo $column_invoice_date; ?></td>
    </tr>
    <?php if ($final_datas) { ?>
      <?php $total = 0; ?>
      <?php foreach ($final_datas as $owner_data) { ?>
        <?php if($owner_data['owner_data']) { ?>
          <tr style="background-color: #777777;color:#FFFFFF;">
            <td>
              <b><?php echo $column_owner_name; ?></b>
            </td>
            <td colspan="5">
              <b><?php echo $owner_data['owner_name']; ?></b>
            </td>
          </tr>
          <?php $sub_total = 0;$i=1; ?>
          <?php foreach($owner_data['owner_data'] as $tkey => $tvalue) { ?>
            <tr>
              <td class="left" style="border:none !important;"><?php echo $i; ?></td>
              <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_id']; ?></td>
              <td class="left" style="border:none !important;"><?php echo $tvalue['trainer_name']; ?></td>
              <td class="right" style="border:none !important;"><?php echo $tvalue['owner_amount']; ?></td>
              <td class="left" style="border:none !important;"><?php echo $tvalue['horse_name']; ?></td>
              <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_date']; ?></td>
            </tr>
            <?php $sub_total = $sub_total + $tvalue['owner_amount'];$i++; ?>
          <?php } ?>
          <?php $total = $total + $sub_total; ?>
          <tr style="border-bottom:1px dotted #CBCACA !important;">
            <td style="border:none !important;">
            </td>
            <td style="border:none !important;">
            </td>
            <td style="border:none !important;">
            </td>
            <td style="border:none !important;" class="right">  
              <b><?php echo $column_subtotal . ' : ' . $sub_total;  ?><b>
            </td>
            <td style="border:none !important;">
            </td>
            <td style="border:none !important;">
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
      <tr>
        <td colspan="5" style="border:none !important;">  
          &nbsp;
        </td>
      </tr>
      <tr>
        <td style="border:none !important;">
        </td>
        <td style="border:none !important;">
        </td>
        <td style="border:none !important;" class="right">  
          <b><?php echo $column_total . ' : ' . $total;  ?></b>
        </td>
        <td style="border:none !important;">
        </td>
        <td style="border:none !important;">
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>