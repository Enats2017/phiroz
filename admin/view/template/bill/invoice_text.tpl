<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<div>
  <table class="store" style="margin-bottom:0px;width:100%">
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
              <?php //echo '1202 Forum, Uday Baug'; ?>
              <?php echo $address_1; ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php //echo 'Pune, Maharashtra 4110313'; ?>
              <?php echo $address_2; ?>
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
  <table class="store" style="margin-bottom:0px;">
    <tr>
      <td>
        <table>
          <tr>
            <td style="padding-top:15px;">
              <?php echo "Dear"; ?> <b style="font-size:15px;"><?php echo $owner_name.' ,'; ?></b>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px;">
              <?php echo "Please Find attached Invoice List For your reference."; ?>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px;">
              <?php echo "If you have any questions you may reach us by calling: ".$telephone." or emailing ". $email; ?>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px;">
              <?php echo "Warm regards,"; ?>
            </td>
          </tr>
          <tr>
            <td style="padding-top:15px;">
              <b><?php echo "Doctor and Staff of ". $doctor_name; ?></b>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
