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
    <p style="display:inline;font-size:15px;"><?php echo $doctor_name; ?></p>
  </h1>
  <table class="product" style="width:100% !important;">
    <tbody>
      <tr>
        <td style="width:45%;">
          Med Name
        </td>
        <td>
          Price 
        </td>
        <td>
          Service 
        </td>
        <td>
          Med Id
        </td>
        <td>
          Surgery
        </td>
      </tr>
      <?php if($final_datas) { ?>
        <?php $i = 1; ?>
        <?php foreach($final_datas as $final_data) { ?>
          <tr style="font-weight:bold;font-size:11px;">
            <td>
              <?php echo $final_data['name']; ?>
            </td>
            <td>
              <?php echo $final_data['price']; ?>
            </td>
             <td>
              <?php echo $final_data['service']; ?>
            </td>
            <td>
              <?php echo $final_data['medicine_id']; ?>
            </td>
            <td>
              <?php if($final_data['is_surgery'] == 1){ ?>
                <?php echo 'Yes'; ?>
              <?php } else { ?>
                <?php echo 'No'; ?>
              <?php } ?>
            </td>
          </tr>
          <?php $i++; ?>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>