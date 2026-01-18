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
      <h1><img src="view/image/report.png" alt="" /> <?php echo 'Treadmill Report'; ?></h1>
    </div>
    <div class="content sales-report">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" style="overflow-x:hidden !important;">
      <table class="form">
        <tr>
          <td style="width:13%;"><?php echo "Date"; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td style="width:13%;"><?php echo $entry_name; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" /></td>
          <td style="width:13%;"><?php echo $entry_doctor; ?>
            <select name="filter_doctor" id="filter_doctor">
              <option value="0"><?php echo 'All Doctor'; ?></option>
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
            <a style="padding: 13px 25px;" onclick="$('#form').submit();" id="export" class="button"><?php echo 'Export'; ?></a>
          </td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="center" style="width:3%;">
              <input type="checkbox" id="sel_ptk" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
            </td>
            <td class="left"><?php echo $column_horse_name; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($horse_wise) { ?>
          <?php $i = 1; ?>
          <?php foreach ($horse_wise as $order) { ?>
          <tr>
            <td style="text-align: center;">
              <?php if ($order['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order['horse_id']; ?>" checked="checked" />
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order['horse_id']; ?>" />
              <?php } ?>
            </td>
            <td class="left"><?php echo $order['horse_name']; ?></td>
          </tr>
          <?php $i++; ?>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="2"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/horse_wise_tread&token=<?php echo $token; ?>';
	
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

  /*
  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type != '*') {
    url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }
  */

	location = url;
  return false;
}

function filter_export() {
  url = 'index.php?route=report/horse_wise_tread/export&token=<?php echo $token; ?>';
  
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

  /*
  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type != '*') {
    url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }
  */
  
  location = url;
  return false;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});

  out_status = '<?php echo $out_status; ?>';
  //out_status = 1;
  if(out_status == 1){
    //$('#export').trigger('click');
  }
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