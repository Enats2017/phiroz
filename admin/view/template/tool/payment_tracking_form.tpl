<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>  
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <?php if($hide_paying == 0) { ?>
          <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <?php } ?>
        <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><?php echo $entry_bill_id; ?></td>
              <td>
                <?php echo $bill_id; ?>
                <input type="hidden" name="bill_id" value="<?php echo $bill_id; ?>" />
                <input type="hidden" name="bill_owner_id" value="<?php echo $bill_owner_id; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_horse_name; ?></td>
              <td>
                <?php echo $horse_name; ?>
                <input type="hidden" name="horse_id" value="<?php echo $horse_id; ?>" />
                <input type="hidden" name="horse_name" value="<?php echo $horse_name; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_owner_name; ?></td>
              <td>
                <?php echo $owner_name; ?>
                <input type="hidden" name="owner_name" value="<?php echo $owner_name; ?>" />
                <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_total; ?></td>
              <td>
                <?php echo $owner_amt; ?>
                <input type="hidden" name="owner_amt" value="<?php echo $owner_amt; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_paid; ?></td>
              <td>
                <?php echo $owner_amt_rec; ?>
                <input type="hidden" name="owner_amt_rec" value="<?php echo $owner_amt_rec; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_balance; ?></td>
              <td>
                <?php echo $owner_amt_balance; ?>
                <input type="hidden" name="owner_amt_balance" value="<?php echo $owner_amt_balance; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_last_payment_date; ?></td>
              <td>
                <?php echo $last_payment_date; ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_paying; ?></td>
              <td>
                <?php if($hide_paying == 0) { ?>
                  <input type="text" name="owner_amt_paying" id="owner_amt_paying" value="<?php echo $owner_amt_paying; ?>" />
                <?php } else { ?>
                  <?php echo "Paid"; ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo 'Discount : %'; ?></td>
              <td>
                  <input type="text" name="owner_discount" id="owner_discount" placeholder="%" value="<?php echo $owner_discount; ?>" />
                  <input type="text" name="t_owner_discount" id="t_owner_discount" value="<?php echo $t_owner_discount; ?>" />
              </td>
            </tr> 
            <tr>
              <td><?php echo 'Total Discount Amount :'; ?></td>
              <td>
                  <input type="text" name="total_owner_discount" id="total_owner_discount" value="<?php echo $total_owner_discount; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_dop; ?></td>  
              <td>
                <?php if($hide_paying == 0) { ?>
                  <input type="text" name="dop" value="<?php echo $dop; ?>" class="date" />
                <?php } else { ?>
                  <?php echo "Paid"; ?>
                <?php } ?>
              </td>
            </tr>
           <!--  <tr> 
            <td style="width:15%;"><?php echo 'Type'; ?>
            <select name="filter_payment_type" id="filter_payment_type" style="width:100%">
              <?php foreach($payment_types as $pkey => $pvalue) { //echo "<pre>";print_r($payment_types);exit;?>
                <?php if ($filter_payment_type == $pkey) { ?>
                  <option value="<?php echo $pkey ?>" selected="selected"><?php echo $pvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $pkey ?>"><?php echo $pvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
            </tr> -->
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();

$(document).ready(function() {
  $('.date').datepicker({dateFormat: 'yy-mm-dd'});
}); 
//--></script> 

<script>
  $('#owner_discount').keyup(function() {
    var owner_amt_paying = $("#owner_amt_paying").val();
    var owner_discount = $("#owner_discount").val();
    var disc_amt = parseFloat(owner_amt_paying) / 100 * owner_discount;
    var final_dis = owner_amt_paying -disc_amt;
    $("#total_owner_discount").val(final_dis.toFixed(2));
    $("#t_owner_discount").val(disc_amt.toFixed(2));
    // alert(calcPrice);  

  }); 
</script>

<?php echo $footer; ?>