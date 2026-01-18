<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
<style>
.product td {
  border-left: 1px solid #CDDDDD;
  border-bottom: 1px solid #CDDDDD;
  padding: 5px;
}
</style>
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
        <b><?php echo 'The Following horses have been given Treadmill exercise on ' . $from_date . ' by ' . $doctor_name . ':';  ?></b>
      </td>
    </tr>
  </table>
  <table class="product" >
    <tr class="heading">
      <td class="left"><?php echo 'Total Horses [' . count($final_datas) . ']'; ?></td>
    </tr>
    <tr class="heading">
      <td>
        Trainer
      </td>
      <td>
        Horse
      </td>
      <td>
        AM/PM
      </td>
      <td>
        INI
      </td>
      <td>
        PhI min
      </td>
      <td>
        PhI km/hr
      </td>
      <td>
        PhII min
      </td>
      <td>
        PhII km/hr
      </td>
      <td>
        Dis.Mtr
      </td>
      <td>
        PhIV min
      </td>
      <td>
        PhIV km/hr
      </td>
      <td>
        Dis.Mtr
      </td>
      <td>
        Work
      </td>
    </tr>

    <?php foreach($final_datas as $fkey => $fvalue) { ?>
      <tr>
        <td>
            <?php echo $fvalue['trainer_name']; ?>
        </td>
        <td>
          <?php echo $fvalue['horse_name']; ?>
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          2 min
        </td>
        <td>
          8km/hr
        </td>
        <td>
          <?php
          $five = array(1389,1369,1368,1370,1372,1371); 
          $ten = array(1388,1374,1373,1375,1377,1376);
          $fifteen = array(1390,1378,1379,1380,1381,1382);
          $twenty = array(1391,1383,1384,1385,1386,1387);

          if(in_array($fvalue['medicine_id'], $five)) {
            echo "5 min";        
          } else if (in_array($fvalue['medicine_id'], $ten)) {
            echo "10 min";
          } else if(in_array($fvalue['medicine_id'], $fifteen)) {
            echo "15 min";
          } else if(in_array($fvalue['medicine_id'], $twenty)) {
            echo "20 min";
          } else {
            echo "No val";
          }

          ?>
        </td>
        <td>
          15km/hr
        </td>
        <td>
          <?php
          $five = array(1389,1369,1368,1370,1372,1371); 
          $ten = array(1388,1374,1373,1375,1377,1376);
          $fifteen = array(1390,1378,1379,1380,1381,1382);
          $twenty = array(1391,1383,1384,1385,1386,1387);

          if(in_array($fvalue['medicine_id'], $five)) {
            echo "1400";        
          } else if (in_array($fvalue['medicine_id'], $ten)) {
            echo "2800";
          } else if(in_array($fvalue['medicine_id'], $fifteen)) {
            echo "4200";
          } else if(in_array($fvalue['medicine_id'], $twenty)) {
            echo "5600";
          } else {
            echo "No val";
          }

          ?>
        </td>
        <td>
          <?php
          $fc5 = array(1374,1378,1383,1369); 
          $fc6 = array(1373,1379,1384,1368);
          $fc7 = array(1375,1380,1385,1370);
          $fc8 = array(1377,1381,1386,1372);
          $fc9 = array(1376,1382,1387,1371);
          $canter = 0;
          if(in_array($fvalue['medicine_id'], $fc5)) {
            echo "2 min";
            $canter = 1;        
          } else if (in_array($fvalue['medicine_id'], $fc6)) {
            echo "2.24 min";
            $canter = 1;
          } else if(in_array($fvalue['medicine_id'], $fc7)) {
            echo "2.48 min";
            $canter = 1;
          } else if(in_array($fvalue['medicine_id'], $fc8)) {
            echo "3.12 min";
            $canter = 1;
          } else if(in_array($fvalue['medicine_id'], $fc9)) {
            echo "3.36 min";
            $canter = 1;
          } else {
            echo " ";
          }

          ?>
        </td>
        <td>
          <?php if($canter == 1) { ?>
            30 km/hr
          <?php } else { ?>
           &nbsp;
          <?php } ?>
        </td>
        <td>
          <?php
          $fc5 = array(1374,1378,1383,1369); 
          $fc6 = array(1373,1379,1384,1368);
          $fc7 = array(1375,1380,1385,1370);
          $fc8 = array(1377,1381,1386,1372);
          $fc9 = array(1376,1382,1387,1371);

          if(in_array($fvalue['medicine_id'], $fc5)) {
            echo "1000";        
          } else if (in_array($fvalue['medicine_id'], $fc6)) {
            echo "1200";
          } else if(in_array($fvalue['medicine_id'], $fc7)) {
            echo "1400";
          } else if(in_array($fvalue['medicine_id'], $fc8)) {
            echo "1600";
          } else if(in_array($fvalue['medicine_id'], $fc9)) {
            echo "1800";
          } else {
            echo " ";
          }

          ?>
        </td>
        <td>
          Walk, Trot
          <?php if($canter == '1') { ?>
            ,Canter
          <?php } ?>
        </td>
      </tr>
      
      
    <?php } ?>
  </table>
</div>
</body>
</html>