<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<?php foreach ($final_data as $key => $data) { ?>
  <div style="page-break-after: always;">
    <h1 style="text-align:center;"><?php echo $text_invoice; ?></h1>
    <table class="store" style="margin-bottom:0px;width:90%;" align="center">
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
                 <b><?php echo $data['owner_name']; ?></b>
              </td>
            </tr>
          </table>
        </td>
        <br>
        <br>
        <td align="right" valign="top">
          <table>
            <tr>
              <td>
                <b><?php echo 'Mumbai / Pune'; ?></b><br />
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Date: '. $data['invoice_date']; ?></b><br />
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b><?php echo 'Payment Received Dr. ' . $data['doctor_name'] . ' Following Vet Bill for the Month of ' . $data['month'] . ' ' . $data['year'] . ' Owned by ' . $data['owner_name'];  ?></b>
          <br />
          <b><?php echo 'Owner Share ' . $data['owner_share']. '%' ?></b>
        </td>
      </tr>
    </table>
    <table class="address" align="center" style="width:90%;">
      <tr class="heading">
        <td colspan="3" style="width:100%;"><b><?php echo 'Owner Invoice Receipt Report'; ?></b></td>
      </tr>
      <tr>
        <td style="width:33%;">
          <b style="font-size:14px;"><?php echo 'Horse A/C'; ?></b>
        </td>
        <td style="width:33%">
          <b style="font-size:14px;"><?php echo 'Invoice No'; ?></b>
        </td>
        <td style="width:33%">
          <b style="font-size:14px;"><?php echo 'Amount'; ?></b>
        </td> 
      </tr>
      <tr>
        <td style="width:33%;">
          <?php echo $data['horse_name']; ?>
        </td>
        <td style="width:33%">
          <?php echo $data['bill_id']; ?>
        </td>
        <td style="width:33%">
          <?php echo $data['total']; ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="width:66%;">
          <b style="font-size:14px;"><?php echo 'TOTAL'; ?></b>
        </td>
        <td style="width:33%">
          <?php echo $data['total']; ?>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="width:100%;">
          <?php echo 'Trainer: ';?> <b><?php echo  $data['trainer_name']; ?></b>
        </td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td align="center" valign="top" style="border-left:0px;">
          <b><?php echo 'Your Faithfully'; ?></b><br /><br /><br />
          <b><?php echo '(Authorized Signatory)'; ?><b><br />
        </td>
      </tr>
    </table>
  </div>
<?php } ?>
</body>
</html>