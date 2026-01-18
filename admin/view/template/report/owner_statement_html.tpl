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
    <h2 style="text-align:left;display: none;">
      <?php echo $title; ?>
    </h2>
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
                <?php echo $final_data[0]['responsible_person'] . ','; ?>
              </td>
            </tr>
            <tr style="display: none;">
              <td>
                <?php echo 'R. W. I. T. C LTD.'; ?>
              </td>
            </tr>
            <tr style="display: none;">
              <td >
                <?php echo 'Mumbai / Pune'; ?>
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
          <?php /* ?>
          <b><?php echo 'The Following is a statement of your share of veterinary bills for treatment done on your horses by Dr. ' . $final_data[0]['doctor_name'] . ' in the month of ' . $final_data[0]['month'] . ' ' . $final_data[0]['year'] . ' Owned by ' . $final_data[0]['owner_name'] . '. Kindly settle these dues as soon as possible.';  ?></b>
          <?php */ ?>
          <b><?php echo 'Dear Sir, <br /> Following is a statement of your share of veterinary bills for treatment done on your horses by Dr. ' . $final_data[0]['doctor_name'] . ' in the month of ' . $final_data[0]['month'] . ' ' . $final_data[0]['year'] . '. Kindly settle these dues as soon as possible.';  ?></b>
        </td>
      </tr>
    </table>
    <table class="product" style="border-right: none !important;">
      <tr class="heading">
        <td class="left" style="width:6%;"><?php echo 'Sr.No'; ?></td>
        <td class="left" style="width:6%;"><?php echo 'Bill Number'; ?></td>
        <td class="left" style="width:30%;"><?php echo 'Horse Name'; ?></td>
        <td class="left" style="width:20%;"><?php echo 'Trainer Name'; ?></td>
        <td class="left" style="width:20%;"><?php echo 'Owner Name'; ?></td>
        <td class="left" style="width:20%;"><?php echo 'Month'; ?></td>
        <td class="right" style="width:10%;text-align: right;border-right: 1px solid #CDDDDD;"><?php echo 'Total'; ?></td>
      </tr>
      <?php if ($final_data) { ?>
        <?php $total = 0;$i=1; ?>
        <?php foreach ($final_data as $tvalue) { ?>
          <tr>
            <td class="left" style=""><?php echo $i; ?></td>
            <td class="left" style=""><?php echo $tvalue['invoice_id']; ?></td>
            <td class="left" style=""><?php echo $tvalue['horse_name']; ?></td>
            <td class="left" style=""><?php echo $tvalue['trainer_name']; ?></td>
            <td class="left" style=""><?php echo $tvalue['owner_name'].' (' . $tvalue['owner_share'] . ' %)'; ?></td>
            <td class="left" style=""><?php echo $tvalue['invoice_date']; ?></td>
            <td class="right" style="text-align: right;border-right: 1px solid #CDDDDD;"><?php echo $tvalue['owner_amount']; ?></td>
          </tr>
          <?php $total = $total + $tvalue['owner_amount'];$i++ ?>
        <?php } ?>
        <tr>
          <td style="">
          </td>
          <td style="">
          </td>
          <td style="">
          </td>
          <td style="">
          </td>
          <td colspan="2" style="text-align: right;" class="right">  
            <b><?php echo 'Sub Total : '; ?></b>
          </td>
          <td style="text-align: right;border-right: 1px solid #CDDDDD;">
            <?php echo $total; ?>
          </td>
        </tr>
        <?php if($tvalue['balance'] > '0'){ ?>
          <tr style="border:none !important;">
            <td colspan="6" style="border:none !important;font-weight: bold;">
              Your racing account statement from the RWITC shows an outstanding of Rs <?php echo $tvalue['balance'] ?> payable to <?php echo $tvalue['doctor_name'] ?> upto <?php echo $tvalue['previous_month_year'] ?>. We request you to please clear this too in order to close the older account. We shall be happy to provide any details you wish for the same.  
            </td>
          </tr>
        <?php } ?>
        <tr style="border:none !important;">
          <td colspan="3" style="border:none !important;"></td>
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