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
  <h2 style="text-align:left;">
    <?php echo $title; ?>
  </h2>
  <p style="display:inline;font-size:15px;"><?php echo 'Period : '; ?><b><?php echo $date_start; ?> - <?php echo $date_end; ?></b><p>
  <p style="display:inline;font-size:15px;"><?php echo 'Trainer : '; ?><b><?php echo $trainer_name; ?></b><p>
  <table class="product">
    <tr class="heading">
      <td class="left" style="display: none;"><?php echo $column_trainer; ?></td>
      <td class="left" style="border: 1px solid;"><?php echo $column_horse_name; ?></td>
      <td class="left" style="border: 1px solid;"></td>
      
    </tr>
    <?php if ($final_datas) { ?>
      <?php foreach ($final_datas as $trainer_data) { ?>
        <tr style="display: none;">
          <td class="left" style="border:none !important;padding-bottom:15px;"><?php echo $trainer_data['trainer_name']; ?></td>
        </tr>
        <?php $cnt = 0; ?>
        <?php $cnt_log = count($trainer_data['horse_data']); ?>
        <?php foreach($trainer_data['horse_data'] as $hkey => $hvalue) { ?>
          <?php $cnt ++; ?>
          <?php if($cnt == $cnt_log) { ?>
            <tr style="border-bottom:1px solid;border-left: 1px solid;border-right: 1px solid;">
          <?php } else { ?>
            <tr style="border-bottom:1px dotted;border-left: 1px solid;border-right: 1px solid;">
          <?php } ?>
          <td class="left" style="border:none !important;padding-bottom:15px;display: none;"></td>
          <td class="left" style="border:none !important;padding-bottom:15px;"><?php echo $hvalue['horse_name']; ?></td>
          <td class="left" style="border:none !important;padding-bottom:15px;">
            <table style="width: 100%; border: 1px solid;">
                    <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
                      <tr style="border: 1px solid;">
                        <td style="width: 60%; border: 1px solid;">
                          <?php echo $mvalue['medicine_name']; ?>
                        </td>
                        <td style="width: 15%; border: 1px solid;">
                          <?php echo $mvalue['dot']; ?>
                        </td>
                        <td style="width: 15%; border: 1px solid;">
                          <?php echo $mvalue['medicine_amount']; ?>
                        </td>
                        <td style="width: 10%; border: 1px solid;">
                          <?php echo $mvalue['medicine_quantity']; ?>
                        </td>
                      </tr>  
                    <?php } ?>
                  </table>
          </td>
          <?php /*
          <td class="left" style="border:none !important;padding-bottom:15px;">
            <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
              <?php echo $mvalue['dot']; ?><br />
            <?php } ?>
          </td>
          <td class="left" style="border:none !important;padding-bottom:15px;">
            <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
              <?php echo $mvalue['medicine_amount']; ?><br />
            <?php } ?>
          </td>
          <td class="left" style="border:none !important;padding-bottom:15px;">
            <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
              <?php echo $mvalue['medicine_quantity']; ?><br />
            <?php } ?>
          </td>
          */ ?>
        </tr>
        <?php } ?>
      <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="center" colspan="4"><?php echo 'No Results'; ?></td>
    </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>