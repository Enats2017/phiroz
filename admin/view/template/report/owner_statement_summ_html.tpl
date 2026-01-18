<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $titleshead; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<?php foreach($final_datas as $fkeys => $final_data){ ?>
  <div style="page-break-after: always;">
    <p style="display:none;font-size:15px;"><?php echo 'Date : '; ?><b><?php echo $tdate; ?></b><p>
    <table class="store" style="margin-bottom:0px;">
      <tr>
        <td>
          <table>
            <tr>
              <td>
                <b style="font-size:16px;"><?php echo 'To'; ?></b>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;">
                <?php echo $final_datas[0]['responsible_person'] . ','; ?>
              </td>
            </tr>
          </table>
        </td>
        <td align="right" valign="top">
          <table>
            <tr>
              <td>
                <b><?php echo 'Mumbai / Pune'; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Date: '. $tdate; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Bank Details : '. $bank_details; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'Saving Acc No : '. $account_no; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo $bank_name; ?></b>
              </td>
            </tr>
            <tr>
              <td>
                <b><?php echo 'IFSC code : '. $ifsc_code; ?></b>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <b><?php echo 'Dear Sir, <br /> Following is a statement of your share of veterinary bills for treatment done on your horses by Dr. ' . $final_datas[0]['doctor_name'] . ' for the period of ' . $final_datas[0]['month_start'] . ' to ' . $final_datas[0]['month_end'] . '. Kindly settle these dues as soon as possible.';  ?></b>
        </td>
      </tr>
    </table>
    <table class="product" style="border: 1px solid #000000;border-collapse: collapse;">
      <tr class="heading">
        <td class="left" style="width: 10%;border: 1px solid #000000;"><?php echo 'Year'; ?></td>
        <td class="left" style="width: 10%;border: 1px solid #000000;"><?php echo 'Month'; ?></td>
        <td class="right" style="width: 10%;text-align: right;border: 1px solid #000000;"><?php echo 'Amount'; ?></td>
      </tr>
      <?php if ($final_datas) { ?>
        <?php $total = 0; ?>
        <?php foreach ($final_datas[0]['month'] as $mkeys => $mvalue) { ?>
          <tr>
            <td class="left" style="width: 10%;border: 1px solid #000000;"><?php echo $mvalue['year_name']; ?></td>
            <td class="left" style="width: 10%;border: 1px solid #000000;"><?php echo $mvalue['month_name']; ?></td>
            <td class="right" style="width: 10%;text-align: right;border: 1px solid #000000;"><?php echo $mvalue['amount']; ?></td>
          </tr>
          <?php $total = $total + $mvalue['amount']; ?>
        <?php } ?>
        <tr>
          <td colspan="2" style="text-align: right;border: 1px solid #000000;" class="right">  
            <b><?php echo 'Total : '; ?></b>
          </td>
          <td style="text-align: right;border: 1px solid #000000;">
            <?php echo $total; ?>
          </td>
        </tr>
        <?php if($final_datas[0]['balance'] > '0'){ ?>
          <tr style="display:none;border:none !important;">
            <td colspan="3" style="border:none !important;font-weight: bold;">
              Your racing account statement from the RWITC shows an outstanding of Rs <?php echo $final_datas[0]['balance'] ?> payable to <?php echo $final_datas[0]['doctor_name'] ?> upto <?php echo $final_datas[0]['previous_month_year'] ?>. We request you to please clear this too in order to close the older account. We shall be happy to provide any details you wish for the same.  
            </td>
          </tr>
        <?php } ?>
        <tr style="border:none !important;display: none;">
          <td colspan="3" align="right" valign="top" style="text-align: right;border:none !important;">
            <b><?php echo 'Your Faithfully'; ?></b><br /><br /><br />
            <b><?php echo '(Authorized Signatory)'; ?><b><br />
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
<?php } ?>
</body>
</html>