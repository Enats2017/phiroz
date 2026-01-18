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
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content sales-report">
      <table class="form">
        <tr>
          <td style="width:13%;"><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td style="width:13%;"><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td style="width:13%;"><?php echo $entry_name; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" /></td>
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
            <a style="padding: 13px 25px;" onclick="filter_export();" id="export" class="button"><?php echo $button_export; ?></a>
          </td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left" style="width:6%;"><?php echo $column_invoice_no; ?></td>
            <td class="left"><?php echo $column_trainer_name; ?></td>
            <td class="left" style="width:19%;"><?php echo $column_owner_name; ?></td>
            <td class="right"><?php echo $column_amount; ?></td>
            <td class="left"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_invoice_date; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($owner_datas) { ?>
            <?php $total = 0; ?>
            <?php foreach ($owner_datas as $owner_data) { ?>
              <?php $sub_total = 0; ?>
              <?php foreach($owner_data['owner_data'] as $tkey => $tvalue) { ?>
                <tr>
                  <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_id']; ?></td>
                  <td class="left" style="border:none !important;"><?php echo $tvalue['trainer_name']; ?></td>
                  <td class="left" style="border:none !important;"><?php echo $tvalue['owner_name']; ?></td>
                  <td class="right" style="border:none !important;"><?php echo $tvalue['owner_amount']; ?></td>
                  <td class="left" style="border:none !important;"><?php echo $tvalue['horse_name']; ?></td>
                  <td class="left" style="border:none !important;"><?php echo $tvalue['invoice_date']; ?></td>
                </tr>
                <?php $sub_total = $sub_total + $tvalue['owner_amount']; ?>
              <?php } ?>
              <?php $total = $total + $sub_total; ?>
              <tr style="border-bottom:1px dotted #CBCACA !important;">
                <td style="border:none !important;">
                </td>
                <td style="border:none !important;">
                </td>
                <td style="border:none !important;">
                </td>
                <td style="border:none !important;">
                </td>
                <td colspan="2" style="border:none !important;">  
                  <b><?php echo $column_subtotal . ' : ' . $sub_total;  ?><b>
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td colspan="6" style="border:none !important;">  
                &nbsp;
              </td>
            </tr>
            <tr>
              <td style="border:none !important;">
              </td>
              <td style="border:none !important;">
              </td>
              <td style="border:none !important;">
              </td>
              <td style="border:none !important;">
              </td>
              <td colspan="2" style="border:none !important;">  
                <b><?php echo $column_total . ' : ' . $total;  ?></b>
              </td>
            </tr>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=report/owner_wise_statement&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  location = url;
  return false;
}

function filter_export() {
  url = 'index.php?route=report/owner_wise_statement/export&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
    
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
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
      url: 'index.php?route=transaction/horse_wise/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.horse_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_name\']').val(ui.item.label);
    $('input[name=\'filter_name_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script> 
<?php echo $footer; ?>