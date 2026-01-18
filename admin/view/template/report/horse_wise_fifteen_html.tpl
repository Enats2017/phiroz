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
  <table class="store" style="margin-bottom:0px;width:100%;" align="center">
    <tr>
      <td>
        <table>
          <tr>
            <td>
              <b style="font-size:16px;"><?php echo 'To'; ?><br /></b>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo 'The Secretary,'; ?><br />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo 'R. W. I. T. C LTD.'; ?><br />
            </td>
          </tr>
          <tr>
            <td >
              <?php echo 'Mumbai / Pune'; ?><br />
            </td>
          </tr>
        </table>
      </td>
      <td align="right" valign="top">
        <table>
          <tr>
            <td>
              <b><?php echo 'Mumbai / Pune'; ?></b><br />
            </td>
          </tr>
          <tr>
            <td>
              <b><?php echo 'Date: '. $tdate; ?></b><br />
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <b><?php echo 'Sir,';  ?></b>
        <br />
        <b><?php echo 'The Following horses engaged to run today on ' . $tdate_1 . ' have been treated by ' . $doctor_name . ' in the past 15 days as follows';  ?></b>
      </td>
    </tr>
  </table>
  <table class="product">
    <tr class="heading">
      <td class="left" colspan="2"><?php echo 'Total Horses [' . count($final_datas) . ']'; ?></td>
    </tr>
    <?php foreach($final_datas as $fkey => $fvalue) { ?>
      <tr>
        <td colspan="2">
          <b><?php echo $fvalue['horse_name'] . ' [Treatments]'; ?><b>
        </td>
      </tr>
      <tr>
        <td>
          <b><?php echo 'Medicine Name' ?></b>
        </td>
        <td>
          <b><?php echo 'Date' ?></b>
        </td>
      </tr>
      <?php foreach($fvalue['transaction_data'] as $key => $value) { ?>
      <tr>
        <td>
          <?php echo $value['medicine_name'] ?>
        </td>
        <td>
          <?php echo $value['date_treatment'] ?>
        </td>
      </tr>
      <?php } ?>
    <?php } ?>
  </table>
</div>
</body>
</html>