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
      <td class="left"><?php echo "Sr.No"; ?></td>
      <td class="left"><?php echo $column_invoice_no; ?></td>
      <td class="left"><?php echo $column_owner_name; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
      <td class="right"><?php echo $column_horse_name; ?></td>
    </tr>
    <?php if ($final_datas) { ?>
      <?php $total = 0; ?>
      <?php foreach ($final_datas as $trainer_data) { ?>
	<?php if($trainer_data['trainer_data']) { ?>
		<tr style="background-color: #eee;color:#FFFFFF;">
		  <td>
		    <b><?php echo $column_trainer_name; ?></b>
		  </td>
		  <td colspan="4">
		    <b><?php echo $trainer_data['trainer_name']; ?></b>
		  </td>
		</tr>
		<?php $sub_total = 0;$i=1; ?>
		<?php foreach($trainer_data['trainer_data'] as $tkey => $tvalue) { ?>
		  <tr>
        <td class="left"><?php echo $i; ?></td>
		    <td class="left"><?php echo $tvalue['invoice_id']; ?></td>
		    <td class="left"><?php echo $tvalue['owner_name']; ?></td>
		    <td class="right"><?php echo $tvalue['owner_amount']; ?></td>
		    <td class="left"><?php echo $tvalue['horse_name']; ?></td>
		  </tr>
		  <?php $sub_total = $sub_total + $tvalue['owner_amount']; $i++;?>
		<?php } ?>
		<?php $total = $total + $sub_total; ?>
		<tr>
		  <td>
		  </td>
      <td>
      </td>
		  <td>
		  </td>
		  <td colspan="2" style="border-left:none !important;">  
		    <?php echo $column_subtotal . ' : ' . $sub_total;  ?>
		  </td>
		</tr>
	 <?php } ?>
      <?php } ?>
      <tr>
        <td colspan="5">  
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
        </td>
        <td>
      </td>
        <td>
        </td>
        <td colspan="2" style="border-left:none !important;">  
          <?php echo $column_total . ' : ' . $total;  ?>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>
