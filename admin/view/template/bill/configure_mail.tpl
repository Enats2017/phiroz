<?php echo $header; ?>
<div id="content">
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content sales-report">
      <table class="form">
        <tr>
          <td style="width:15%;">
            <?php echo $entry_email; ?>
            <input type="text" name="filter_mail" value="<?php echo $filter_mail; ?>" id="filter_mail" size="35" />
            <input type="hidden" name="filter_bill_id" value="<?php echo $filter_bill_id; ?>" id="filter_bill_id" />
            <input type="hidden" name="filter_horse_id" value="<?php echo $filter_horse_id; ?>" id="filter_horse_id" />
            <input type="hidden" name="filter_owner" value="<?php echo $filter_owner; ?>" id="filter_owner" />
          </td>
          <td style="text-align: right;">
            <a onclick="filter();" class="button" style="padding: 13px 15px;"><?php echo $button_mail; ?></a>
          </td>
        </tr>
      </table>
      <?php echo $invoice_mail_html; ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});

function filter() {
  url = 'index.php?route=bill/bill_history/send_mail&token=<?php echo $token; ?>';
  var filter_mail = $('input[name=\'filter_mail\']').attr('value');
  if (filter_mail) {
    url += '&filter_mail=' + encodeURIComponent(filter_mail);
  }

  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
    url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
  }

  var filter_horse_id = $('input[name=\'filter_horse_id\']').attr('value');
  if (filter_horse_id) {
    url += '&filter_horse_id=' + encodeURIComponent(filter_horse_id);
  }

  var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  if (filter_owner) {
    url += '&filter_owner=' + encodeURIComponent(filter_owner);
  }
  location = url;
  return false;
}
//--></script> 
<?php echo $footer; ?>