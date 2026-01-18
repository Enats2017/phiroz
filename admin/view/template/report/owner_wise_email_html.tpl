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
  <table class="store" style="margin-bottom:0px;">
      <tr>
        <td>
          <table>
            <tr>
              <td>
                <b style="font-size:18px;"><?php echo $doctor_name; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo '1202 Forum, Uday Baug'; ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo 'Pune, Maharashtra 4110313'; ?>
              </td>
            </tr>
          </table>
        </td>
        <td align="right" valign="top">
          <table>
            <tr>
              <td>
                <?php echo 'Tel: '. $telephone; ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $email; ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  <table class="product">
    <tr class="heading">
      <td class="left" style="width:6%;"><?php echo $column_invoice_no; ?></td>
      <td class="left"><?php echo $column_trainer_name; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
      <td class="left"><?php echo $column_horse_name; ?></td>
      <td class="left" style="display:none;"><?php echo $column_invoice_date; ?></td>
    </tr>
    <?php if ($final_datas) { ?>
      <?php $total = 0; ?>
      <?php foreach ($final_datas as $tvalue) { ?>
        <tr>
              <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_id']; ?></td>
              <td class="left" style="border:none !important;"><?php echo $tvalue['trainer_name']; ?></td>
              <td class="right" style="border:none !important;"><?php echo $tvalue['owner_amount']; ?></td>
              <td class="left" style="border:none !important;"><?php echo $tvalue['horse_name']; ?></td>
              <td class="left" style="display:none;border:none !important;"><?php echo $tvalue['invoice_date']; ?></td>
        </tr>
        <?php $total = $total + $tvalue['owner_amount']; ?>
      <?php } ?>
      <tr>
        <td colspan="4" style="border:none !important;">  
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
        <td style="display:none;border:none !important;">
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>