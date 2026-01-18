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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content sales-report">
      <table class="form">
        <tr>
          <td style="width:10%;">
            <?php echo $entry_month; ?>
            <select name="filter_month" id="filter_month">
              <?php foreach($months as $key => $value) { ?>
                <?php if ($filter_month == $key) { ?>
                  <option value="<?php echo $key ?>" selected="selected"><?php echo $value; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:7%;">
            <?php echo $entry_year; ?>
            <select name="filter_year" id="filter_year">
              <?php foreach($years as $mkey => $mvalue) { ?>
                <?php if ($mvalue == $filter_year) { ?>
                  <option value="<?php echo $mvalue ?>" selected="selected"><?php echo $mvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $mvalue ?>"><?php echo $mvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
    <td style="width:13%;"><?php echo 'Owner Name'; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" /></td>
          <td style="width:13%;"><?php echo 'Owner Email'; ?>
            <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" id="filter_email" size="20" />
    </td>
    <td style="width:13%;"><?php echo $entry_doctor; ?>
            <select name="filter_doctor" id="filter_doctor">
                <option value="0"><?php echo $text_all; ?></option>
              <?php foreach($doctors as $dkey => $dvalue) { ?>
                <?php if ($filter_doctor == $dvalue['doctor_id']) { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>"><?php echo $dvalue['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="text-align: right;">
            <a style="padding: 13px 25px;" onclick="filter();" id="filter" class="button"><?php echo $button_filter; ?></a>
            <a style="padding: 13px 25px;" onclick="filter_export();" id="export" class="button"><?php echo 'Send Mail'; ?></a>
          </td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left" style="width:6%;"><?php echo $column_invoice_no; ?></td>
            <td class="left"><?php echo $column_trainer_name; ?></td>
            <td class="right"><?php echo $column_amount; ?></td>
            <td class="left"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_invoice_date; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($owner_datas) { ?>
            <?php $total = 0; ?>
            <?php foreach ($owner_datas as $tvalue) { ?>
                <tr>
        <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_id']; ?></td>
        <td class="left" style="border:none !important;"><?php echo $tvalue['trainer_name']; ?></td>
        <td class="right" style="border:none !important;"><?php echo $tvalue['owner_amount']; ?></td>
        <td class="left" style="border:none !important;"><?php echo $tvalue['horse_name']; ?></td>
        <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_date']; ?></td>
                </tr>
                <?php $total = $total + $tvalue['owner_amount']; ?>
            <?php } ?>
            <tr>
              <td colspan="5" style="border:none !important;">  
                &nbsp;
              </td>
            </tr>
            <tr>
              <td style="border:none !important;">
              </td>
              <td style="border:none !important;">
              </td>
              <td style="border:none !important;" class="right">  
                <b><?php echo $column_total . ' : ' . $total;  ?></b>
              </td>
              <td style="border:none !important;">
              </td>
              <td style="border:none !important;">
              </td>
            </tr>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php /* ?>
      <div class="pagination"><?php echo $pagination; ?></div>
      <?php */ ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=report/owner_wise_email&token=<?php echo $token; ?>';
  
  var filter_month = $('select[name=\'filter_month\']').attr('value');
  
  if (filter_month) {
    url += '&filter_month=' + encodeURIComponent(filter_month);
  }

  var filter_year = $('select[name=\'filter_year\']').attr('value');
  
  if (filter_year) {
    url += '&filter_year=' + encodeURIComponent(filter_year);
  }
    
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
  }

  var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  location = url;
  return false;
}

function filter_export() {
  url = 'index.php?route=report/owner_wise_email/export&token=<?php echo $token; ?>';
  
  var filter_month = $('select[name=\'filter_month\']').attr('value');
  
  if (filter_month) {
    url += '&filter_month=' + encodeURIComponent(filter_month);
  }

  var filter_year = $('select[name=\'filter_year\']').attr('value');
  
  if (filter_year) {
    url += '&filter_year=' + encodeURIComponent(filter_year);
  }
    
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
  }

  var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  location = url;
  return false;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript"><!--

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

$('input[name=\'filter_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.owner_id,
      email: item.email
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_name\']').val(ui.item.label);
    $('input[name=\'filter_name_id\']').val(ui.item.value);
    $('input[name=\'filter_email\']').val(ui.item.email);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script> 
<?php echo $footer; ?>