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
        <a onclick="$('#form').submit();" class="button"><?php echo 'Save'; ?></a>
        <a href="<?php echo $cancel; ?>" class="button"><?php echo 'Cancel'; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo 'General'; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><?php echo 'Bill Id'; ?></td>
              <td>
                <?php echo $bill_id; ?>
                <input type="hidden" name="bill_id" value="<?php echo $bill_id; ?>" />
                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>" />
                <input type="hidden" name="month" value="<?php echo $month; ?>" />
                <input type="hidden" name="year" value="<?php echo $year; ?>" />
                <input type="hidden" name="cheque_no" value="<?php echo $cheque_no; ?>" />
                <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>" />
                <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>" />
                <input type="hidden" name="invoice_date" value="<?php echo $invoice_date; ?>" />
                <input type="hidden" name="accept" value="<?php echo $accept; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo 'Horse Name'; ?></td>
              <td>
                <?php echo $horse_name; ?>
                <input type="hidden" name="horse_id" value="<?php echo $horse_id; ?>" />
                <input type="hidden" name="horse_name" value="<?php echo $horse_name; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo 'Trainer Name'; ?></td>
              <td>
                <?php echo $trainer_name; ?>
                <input type="hidden" name="trainer_name" value="<?php echo $trainer_name; ?>" />
                <input type="hidden" name="trainer_id" value="<?php echo $trainer_id; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo 'Total Amt'; ?></td>
              <td>
                <?php echo $total_amt; ?>
                <input type="hidden" name="total_amt" value="<?php echo $total_amt; ?>" />
              </td>
            </tr>
          </table>
          <div style="text-align:center;">
            <?php if ($error_share_less) { ?>
            <span class="error"><?php echo $error_share_less; ?></span>
            <?php } ?>
          </div>
          <div class="buttons" style="float:right;">
            <a onclick="addExtraowner();" class="button_save" style="margin-bottom:10px;"><span><?php echo 'Add Owner'; ?></span></a>
          </div>
          <table id="owner_content" class="list">
            <thead>
              <tr>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Owner'; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Share'; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Amount'; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Action'; ?></td>
              </tr>
            </thead>
            <?php $extra_field_row = 0; ?>
            <?php if($owners) { ?>
              <?php foreach ($owners as $owner) { ?>
                <tbody id="owner_contents_row<?php echo $extra_field_row; ?>">
                  <tr>
                    <td class="left">
                      <input type="text" class="search_owner" id="search_owner-<?php echo $extra_field_row; ?>" name="owners[<?php echo $extra_field_row; ?>][o_name]" value = "<?php echo $owner['o_name'] ?>" />
                      <input type="hidden" class="search_owner_id" id="search_owner_id-<?php echo $extra_field_row; ?>" name="owners[<?php echo $extra_field_row; ?>][o_name_id]" value = "<?php echo $owner['o_name_id'] ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_field_row]" value = "<?php echo $extra_field_row; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_dop]" value = "<?php echo $owner['o_dop']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_accept]" value = "<?php echo $owner['o_accept']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_invoice_date]" value = "<?php echo $owner['o_invoice_date']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_transaction_type]" value = "<?php echo $owner['o_transaction_type']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_id]" value = "<?php echo $owner['o_id']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_owner_amt_rec]" value = "<?php echo $owner['o_owner_amt_rec']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_payment_status]" value = "<?php echo $owner['o_payment_status']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_owner_code]" value = "<?php echo $owner['o_owner_code']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_batch_id]" value = "<?php echo $owner['o_batch_id']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_cheque_no]" value = "<?php echo $owner['o_cheque_no']; ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_total_amount]" value = "<?php echo $owner['o_total_amount']; ?>" />
                      <?php if(isset($error_owners[$extra_field_row]['owner_name'])) { ?>
                        <span class="error"><?php echo $error_owners[$extra_field_row]['owner_name']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left">
                      <input type="text" name="owners[<?php echo $extra_field_row; ?>][o_share]" value = "<?php echo $owner['o_share'] ?>" />
                      <?php if(isset($error_owners[$extra_field_row]['owner_share'])) { ?>
                        <span class="error"><?php echo $error_owners[$extra_field_row]['owner_share']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left">
                      <input type="text" name="owners[<?php echo $extra_field_row; ?>][o_amt]" value = "<?php echo $owner['o_amt'] ?>" />
                      <?php if(isset($error_owners[$extra_field_row]['owner_share'])) { ?>
                        <span class="error"><?php echo $error_owners[$extra_field_row]['owner_share']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left">
                      <a onclick="remove_folder('<?php echo $extra_field_row; ?>')" class="button">
                        <span><?php echo 'Remove'; ?></span>
                      </a>
                    </td>
                  </tr>
                </tbody>
              <?php $extra_field_row++; ?>
              <?php } ?>
            <?php } else { ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td class="left"><a onclick="addExtraowner('<?php echo $extra_field_row; ?>');" class="button"><?php echo 'Add Owner'; ?></a></td>
              </tr>
            </tfoot>
            <input type="hidden" id="extra_field_row" name="extra_field_row" value="<?php echo $extra_field_row; ?>" />
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();

$.widget('custom.catcomplete', $.ui.autocomplete, {
  _renderMenu: function(ul, items) {
    var self = this, currentCategory = '';
    $.each(items, function(index, item) {
      if (item.category != currentCategory) {
        //ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
        currentCategory = item.category;
      }
      self._renderItem(ul, item);
    });
  }
});

function remove_folder(extra_field_row){
  $('#owner_contents_row'+extra_field_row).remove();
}

var extra_field_row = $('#extra_field_row').val();
function addExtraowner() {
  html  = '<tbody id="owner_contents_row' + extra_field_row + '">';
    html += '<tr>'; 
      html += '<td class="left"><input type="text" class="search_owner" id="search_owner-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_name]" value=""  />';
      html += '<input type="hidden" class="search_owner_id" id="search_owner_id-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_name_id]" value=""  />';
      html += '<input type="hidden" id="search_id-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_id]" value="" />';
      html += '<input type="hidden" id="search_dop-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_dop]" value="" />';
      html += '<input type="hidden" id="search_accept-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_accept]" value="" />';
      html += '<input type="hidden" id="search_invoice_date-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_invoice_date]" value="" />';
      html += '<input type="hidden" id="search_transaction_type-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_transaction_type]" value="" />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_field_row]" value="'+extra_field_row+'"  />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_owner_amt_rec]" value=""  />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_payment_status]" value=""  />';
      html += '<input type="hidden" id="search_owner_code-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_owner_code]" value=""  />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_batch_id]" value=""  />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_cheque_no]" value=""  />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_total_amount]" value=""  />';
      html += '</td>';
      html += '<td class="left"><input type="text" name="owners[' + extra_field_row + '][o_share]" value="" /></td>';
      html += '<td class="left"><input type="text" name="owners[' + extra_field_row + '][o_amt]" value="" /></td>';
      html += '<td class="left"><a onclick="remove_folder('+extra_field_row+')" class="button"><span><?php echo "Remove"; ?></span></a></td>';
    html += '</tr>';  
  html += '</tbody>';
  $('#owner_content tfoot').before(html);
  //ownerautocomplete(extra_field_row);
  extra_field_row++;
}


$('.search_owner').live('focus', function(i){
  $(this).catcomplete({
    delay: 500,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/horse/autocomplete_owner&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) { 
          response($.map(json, function(item) {
            return {
              label: item.name,
              value: item.owner_id,
              transaction_type: item.transaction_type,
              owner_code: item.owner_code
            }
          }));
        }
      });
    }, 
    select: function(event, ui) {
      idss = $(this).attr('id');
      s_id = idss.split('-');
      $('#search_owner-'+s_id[1]).attr('value', ui.item.label);
      $('#search_owner_id-'+s_id[1]).attr('value', ui.item.value);
      $('#search_transaction_type-'+s_id[1]).attr('value', ui.item.transaction_type);
      $('#search_owner_code-'+s_id[1]).attr('value', ui.item.owner_code);
      return false;
    },
    focus: function(event, ui) {
      return false;
    }
  });
});

$(document).ready(function() {
  $('.date').datepicker({dateFormat: 'yy-mm-dd'});
}); 
//--></script> 
<?php echo $footer; ?>