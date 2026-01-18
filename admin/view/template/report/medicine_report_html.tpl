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
    <thead>
      <tr>
        <td class="left"><?php echo 'Sr.No'; ?></td>
        <td class="left"><?php echo 'Category Name'; ?></td>
        <td class="left"><?php echo 'Quantity'; ?></td>
        <td class="left"><?php echo 'Total'; ?></td>
        <td class="left"><?php echo 'Trainer'; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($final_datas) { ?>
      <?php $i = 1; ?>
      <?php foreach ($final_datas as $res) { ?>
      <tr>
        <td class="left"><?php echo $i; ?></td>
        <td class="left"><?php echo $res['category']; ?></td>
        <td class="left"><?php echo $res['medicine_quantity']; ?></td>
        <td class="left"><?php echo $res['medicine_total']; ?></td>
        <td class="left"><?php echo $res['trainer_name']; ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
      </tr>
      <?php } ?>
    </tbody>
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