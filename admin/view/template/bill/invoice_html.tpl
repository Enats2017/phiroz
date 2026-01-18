<?php if(!isset($html_show)) { ?> <?php echo '
<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> <?php echo $title; ?> </title>
        <base href="
      <?php echo $base; ?>" />
        <link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            .test {
                padding: 0.2rem !important;
            }

            .test td,
            .test th {
                padding: 0.2rem !important;
            }

            .table-bordered {
                border: 2px solid black !important;
            }

            .table-bordered td,
            .table-bordered th {
                border: 2px solid black !important;
            }
        </style>
    </head>
    <body> <?php } ?> <?php foreach ($final_datas as $fkey => $final_data) { ?> <?php foreach ($final_data as $key => $data) { ?> <div style="page-break-after: always;margin-left:30px;margin-right:30px;font-family: revert;margin-bottom: 30px;">
            <h1 style="text-align:center;border-bottom:1px solid #80808063 !important; padding-bottom: 20px;">INVOICE</h1>
            <table class="table table-borderless" style="width: 100%;margin-bottom: 0px;">
                <tr style="width: 100%;line-height: 0px;">
                    <td>
                        <b style="font-size:22px;"> <?php echo $data['doctor_name']; ?> </b>
                    </td>
                    <td style="text-align:right;font-size: 18px;"> <?php echo 'Tel:  '. $telephone; ?> </td>
                </tr>
                <tr style="width: 100%;line-height: 0px;font-size: 18px;">
                    <td> <?php echo $address_1; ?> </td>
                    <td style="text-align:right;"> <?php echo $email; ?> </td>
                </tr>
                <tr style="line-height: 0px;font-size: 18px;">
                    <td> <?php echo $address_3; ?> </td>
                </tr>
                <tr style="line-height: 0px;font-size: 18px;">
                    <td> <?php //echo 'Pune, Maharashtra 4110313'; ?> <?php echo $address_2; ?> </td>
                </tr>
                <tr style="line-height: 20px;font-size: 18px;">
                    <td style="padding-top:40px;padding-bottom: 1px !important;">
                        <p style="font-weight: bolder;margin-bottom: 0px;">
                            <?php echo $data['owner_name']; ?> 
                        </p>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered test" style="padding: 0.2rem;">
                <tr>
                    <td style="font-size: 18px;"> <?php echo 'Invoice No: '; ?> <b> <?php echo  $data['bill_id'] . '  ' . $data['month'] .' '. $data['year']; ?> </b>
                    </td>
                </tr>
                <tr>
                    <td style="width:100%">
                        <b style="font-size:16px;"> <?php echo $data['horse_name'] . ' (' . $data['owner_share'] . '%)'; ?> </b>
                </tr>
            </table>
            <table class="table table-bordered test" style="padding: 0.2rem;">
                <tr style="font-size:17px !important">
                    <td>
                        <b> <?php echo 'Date'; ?> </b>
                    </td>
                    <td style="display: none;">
                        <b> <?php echo 'Medicine Code'; ?> </b>
                    </td>
                    <td>
                        <b> <?php echo 'Description'; ?> </b>
                    </td>
                    <td align="right">
                        <b> <?php echo 'Qty'; ?> </b>
                    </td>
                    <td align="right">
                        <b> <?php echo 'Fees'; ?> </b>
                    </td>
                </tr> <?php $medicine_total = 0.00; ?> <?php foreach ($data['transaction_data'] as $medicine) { ?> <tr style="font-size:17px !important">
                    <td style="width:15%;"> <?php echo $medicine['dot']; ?> </td>
                    <td style=" display: none;"> <?php echo $medicine['medicine_id']; ?> </td>
                    <td style="letter-spacing: 0.5px"> <?php echo $medicine['medicine_name']; ?> </td>
                    <!-- <td style="">
                <?php //echo $medicine['treatment_name']; ?></td> -->
                    <td style="" align="right"> <?php echo $medicine['medicine_quantity']; ?> </td>
                    <td style="" align="right"> <?php echo $medicine['medicine_total']; ?> </td>
                </tr> <?php $medicine_total = $medicine_total + $medicine['medicine_total']; ?> <?php } ?> <tr>
                    <td align="right" colspan="3">
                        <b> <?php echo 'Total Amount Rs'; ?>: </b>
                    </td>
                    <td align="right" colspan="1" style="font-size:17px;font-weight: bolder;"> <?php echo my_money_format($medicine_total); ?> </td>
                </tr>
                <tr>
                    <td align="right" colspan="3">
                        <b> <?php echo 'Payable Amount as per share (' . $data['owner_share'] .' %) Rs'; ?>: </b>
                    </td>
                    <td align="right" colspan="1" style="font-size:17px;font-weight: bolder;"> <?php echo my_money_format($data['owner_share_amount']); ?> </td>
                </tr>
            </table>
            <table class="table table-borderless test" style="margin-bottom:0px;width: 100% !important;">
            <?php if ($data['doctor_name'] == "Dr. Phiroz Khambatta") { ?>
                <tr>
                    <td style="position: relative;top: 50px;"> <?php echo 'Trainer :' ?> <b style="font-size:18px;"> <?php echo $data['trainer_name']; ?> </b>
                    </td>
                    <td style="text-align: end;font-size:18px;"> <?php echo 'Your Faithfully'; ?> </td>
                    <!-- <td style="text-align: end;font-size:18px;"> <php echo 'Your Faithfully'; ?> </td> -->
                </tr>
                <tr>
                    <td></td>
                    <!-- <td style="text-align: end;position: relative;top: 50px;font-size:18px;"> <php echo $data['doctor_name'];  ?> </td> -->
                    <td style="text-align: end; position: relative;">
                        <img src="http://5.161.114.135/phiroz_2020/image/sign_stamp.png" alt="Dr. Phiroz Khambatta"style="height: 170px; width: 230px;">
                    </td>
                </tr>
            <?php  } else {?>
                <tr>
                    <td style="position: relative;top: 50px;"> <?php echo 'Trainer :' ?> <b style="font-size:18px;"> <?php echo $data['trainer_name']; ?> </b>
                    </td>
                    <td style="text-align: end;font-size:18px;"> <?php echo 'Your Faithfully'; ?> </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: end;position: relative;top: 50px;font-size:18px;"> <?php echo $data['doctor_name'];  ?> </td>
                </tr>
            <?php  } ?>
            </table>
        </div> <?php } ?> <?php } ?> <?php if(!isset($html_show)) { ?> </body>
</html> <?php } ?> <?php
function my_money_format($number) 
{ 
    //$number = '2953154.83';

    $negative = '';
    if(strstr($number,"-")) 
    { 
        $number = str_replace("-","",$number); 
        $negative = "-"; 
    } 
    
    $split_number = @explode(".",$number); 
    $rupee = $split_number[0]; 
    if(isset($split_number[1])){
      $paise = @$split_number[1]; 
    } else {
      $paise = '00';
    }
    
    if(@strlen($rupee)>3) 
    { 
        $hundreds = substr($rupee,strlen($rupee)-3); 
        $thousands_in_reverse = strrev(substr($rupee,0,strlen($rupee)-3)); 
        $thousands = '';
        
        for($i=0; $i<(strlen($thousands_in_reverse)); $i=$i+2) 
        {
            if(isset($thousands_in_reverse[$i+1])){
              $thousands .= $thousands_in_reverse[$i].$thousands_in_reverse[$i+1].","; 
            } else {
              $thousands .= $thousands_in_reverse[$i].","; 
            }
        } 
        $thousands = strrev(trim($thousands,",")); 
        $formatted_rupee = $thousands.",".$hundreds; 
    } else { 
        $formatted_rupee = $rupee; 
    } 
    
    $formatted_paise = '.00';
    if((int)$paise>0) 
    { 
        $formatted_paise = ".".substr($paise,0,2); 
    } 
    
    return $negative.$formatted_rupee.$formatted_paise; 

}
?>