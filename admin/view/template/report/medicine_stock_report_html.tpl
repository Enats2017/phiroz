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
      <td class="left" style="width:50%;"><?php echo 'Medicine Name'; ?></td>
      <td class="left" style="width:25%;"><?php echo 'Quantity'; ?></td>
    </tr>
    <?php if ($final_datas) { ?>
      <?php foreach ($final_datas as $owner_data) { ?>
        <?php if($owner_data['owner_data']) { ?>
          <tr style="background-color: #777777;color:#FFFFFF;">
            <td>
              <b><?php echo 'Owner Name'; ?></b>
            </td>
            <td>
              <b><?php echo $owner_data['owner_name']; ?></b>
            </td>
          </tr>
          <?php foreach($owner_data['owner_data'] as $tkey => $tvalue) { ?>
            <tr>
              <td class="left" style="border:none !important;"><?php echo $tvalue['medicine_name']; ?></td>
              <td class="left" style="border:none !important;"><?php echo round($tvalue['quantity_share'], 4); ?></td>
            </tr>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </table>
</div>
</body>
</html>