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
  <p style="display:inline;font-size:15px;"><h3>Medicine Name :</h3><?php echo $results[0]['medicine_name']; ?></p>
  <table class="product">
    <thead>
      <tr>
        <td class="left"><?php echo 'Sr.No'; ?></td>
        <td class="left"><?php echo 'Horse Name'; ?></td>
        <!-- <td class="left"><?php echo 'Medicine Name'; ?></td> -->
        <td class="left"><?php echo 'Medicine Volume'; ?></td>
        <td class="left" style="width:150px;"><?php echo 'Date'; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($results) { ?>
      <?php $i = 1; ?>
       <?php $total = 0; ?>
      <?php foreach ($results as $res) { ?>
      <tr>
        <td class="left"><?php echo $i; ?></td>
        <td class="left"><?php echo $res['horse_name']; ?></td>
       <!--  <td class="left"><?php echo $res['medicine_name']; ?></td> -->
        <td class="left"><?php echo $res['volume']; ?></td>
        <td class="left"><?php echo date('d-m-Y', strtotime($res['dot'])); ?></td>
      </tr>
      <?php $total+= $res['volume']; ?>
      <?php $i++; ?>
      <?php } ?>
      <tr>
        <td class="right" colspan="2"><?php echo"Total"; ?></td>
        <td class="left" colspan="2"><?php echo $total; ?></td>
      </tr>
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