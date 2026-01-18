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
		  <td style="width:7%;">
			<?php echo $entry_date_start; ?>
			<input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="8" />
		  </td>
		  <td style="width:6%;">
			<?php echo $entry_date_end; ?>
			<input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="8" />
		  </td>
		  <td style="width:9%;">
			<?php echo $entry_name; ?>
			<input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="10" />
			<input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" />
		  </td>
		  <td style="width:9%;">
			<?php echo $entry_owner; ?>
			<input type="text" name="filter_owner" value="<?php echo $filter_owner; ?>" id="filter_owner" size="10" />
			<input type="hidden" name="filter_owner_id" value="<?php echo $filter_owner_id; ?>" id="filter_owner_id" />
		  </td>
		  <td style="width:9%;">
			<?php echo $entry_trainer; ?>
			<input type="text" name="filter_trainer" value="<?php echo $filter_trainer; ?>" id="filter_trainer" size="9" />
			<input type="hidden" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" id="filter_trainer_id" />
		  </td>
		  <td style="width:5%;">
			<?php echo $entry_bill_id; ?>
			<input type="text" name="filter_bill_id" value="<?php echo $filter_bill_id; ?>" id="filter_bill_id" size="1" />
		  </td>
		  <td style="width:1%;">
			<?php echo $entry_doctor; ?>
			<select name="filter_doctor" id="filter_doctor">
			  <?php foreach($doctors as $dkey => $dvalue) { ?>
				<?php if ($filter_doctor == $dvalue['doctor_id']) { ?>
				  <option value="<?php echo $dvalue['doctor_id'] ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
				<?php } else { ?>
				  <option value="<?php echo $dvalue['doctor_id'] ?>"><?php echo $dvalue['name']; ?></option>
				<?php } ?>
			  <?php } ?>
			</select>
		  </td>
	  <td style="width:13%;"><?php echo $entry_transaction_type; ?>
			<select name="filter_transaction_type" id="filter_transaction_type" style="width:100%">
			  <option value="0"><?php echo 'All'; ?></option>
		  <?php foreach($transaction_types as $tkey => $tvalue) { ?>
				<?php if ($filter_transaction_type == $tkey) { ?>
				  <option value="<?php echo $tkey ?>" selected="selected"><?php echo $tvalue; ?></option>
				<?php } else { ?>
				  <option value="<?php echo $tkey ?>"><?php echo $tvalue; ?></option>
				<?php } ?>
			  <?php } ?>
			</select>
		  </td>
		  <td style="text-align: right;">
			<a onclick="filter();" class="button" style="padding: 13px 1px;"><?php echo $button_filter_normal; ?></a>
			<a onclick="filter_print();" class="button" style="padding: 13px 1px;"><?php echo $button_filter; ?></a>
			<a onclick="filter_print_receipt();" class="button" style="padding: 13px 1px;"><?php echo $button_filter_receipt; ?></a>
		  </td>
		</tr>
	  </table>
	  <table class="list" style="width:99%;">
		<thead>
		  <tr>
			<td class="left" style="width:1%;"><?php echo $column_sr_no; ?></td>
			<td class="left" style="width:6%;"><?php echo $column_bill_no; ?></td>
			<td class="left" style="width:15%;"><?php echo $column_horse_name; ?></td>
			<td class="left"><?php echo $column_trainer_name; ?></td>
			<td class="left" style="width:20%;"><?php echo $column_owner_name; ?></td>
			<td class="right"><?php echo $column_total; ?></td>
			<td class="right"><?php echo $column_action; ?></td>
		  </tr>
		</thead>
		<tbody>
		  <?php if ($bill_checklist) { ?>
		  <?php 
			$i = 1; 
			$raw_total = 0;
		  ?>
		  <?php foreach ($bill_checklist as $order) { ?>
		  <tr>
			<td class="left"><?php echo $i; ?></td>
			<td class="left"><?php echo $order['bill_id'].'.'; ?></td>
			<td class="left"><?php echo $order['horse_name']; ?></td>
			<td class="left"><?php echo $order['trainer_name']; ?></td>
			<td class="left"><?php echo $order['owner_name']; ?></td>
			<td class="right"><?php echo $order['total']; ?></td>
			<td class="right"><?php foreach ($order['action'] as $action) { ?>
			<?php if($action['text'] == 'Send Mail') { ?>
			[ <a href="<?php echo $action['href']; ?>" target="blank"><?php echo $action['text']; ?></a> ]
			<?php } else { ?>
			[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
			<?php } ?>
			<?php } ?></td>
		  </tr>
		  <?php 
		  $i++; 
		  $raw_total = $raw_total + $order['raw_total'];
		  ?>
		  <?php } ?>
		  <tr style="display:none;">
			<td colspan = "7">
			  <?php echo $raw_total; ?>
			</td>
		  </tr>
		  <?php } else { ?>
		  <tr>
			<td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
  url = 'index.php?route=bill/bill_history&token=<?php echo $token; ?>';
  
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

  var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  
  if (filter_owner) {
	url += '&filter_owner=' + encodeURIComponent(filter_owner);
	var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
	if (filter_owner_id) {
	  url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
	}
  }

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  
  if (filter_trainer) {
	url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
	var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  
	if (filter_trainer_id) {
	  url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
	}
  }

  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
	url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
	url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type && filter_transaction_type != '0') {
	url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }

  url += '&first=0';
  
  location = url;
  return false;
}

function filter_print() {
  url = 'index.php?route=bill/bill_history/printinvoice&token=<?php echo $token; ?>';
  
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

  var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  
  if (filter_owner) {
	url += '&filter_owner=' + encodeURIComponent(filter_owner);
	var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
	if (filter_owner_id) {
	  url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
	}
  }

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  
  if (filter_trainer) {
	url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
	var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  
	if (filter_trainer_id) {
	  url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
	}
  }

  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
	url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
	url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type && filter_transaction_type != '0') {
	url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }
  
  location = url;
  return false;
}

function filter_print_receipt() {
  url = 'index.php?route=bill/bill_history/printreceipt&token=<?php echo $token; ?>';
  
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

  var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  
  if (filter_owner) {
	url += '&filter_owner=' + encodeURIComponent(filter_owner);
	var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
	if (filter_owner_id) {
	  url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
	}
  }

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  
  if (filter_trainer) {
	url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
	var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  
	if (filter_trainer_id) {
	  url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
	}
  }

  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
	url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  if (filter_doctor) {
	url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type) {
	url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }
  
  location = url;
  return false;
}
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

$('input[name=\'filter_owner\']').autocomplete({
  delay: 500,
  source: function(request, response) {
	$.ajax({
	  url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
	  dataType: 'json',
	  success: function(json) {   
		response($.map(json, function(item) {
		  return {
			label: item.name,
			value: item.owner_id
		  }
		}));
	  }
	});
  }, 
  select: function(event, ui) {
	$('input[name=\'filter_owner\']').val(ui.item.label);
	$('input[name=\'filter_owner_id\']').val(ui.item.value);
	return false;
  },
  focus: function(event, ui) {
	return false;
  }
});

$('input[name=\'filter_trainer\']').autocomplete({
  delay: 500,
  source: function(request, response) {
	$.ajax({
	  url: 'index.php?route=catalog/horse/autocomplete_trainer&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
	  dataType: 'json',
	  success: function(json) {   
		response($.map(json, function(item) {
		  return {
			label: item.name,
			value: item.trainer_id
		  }
		}));
	  }
	});
  }, 
  select: function(event, ui) {
	$('input[name=\'filter_trainer\']').val(ui.item.label);
	$('input[name=\'filter_trainer_id\']').val(ui.item.value);
	return false;
  },
  focus: function(event, ui) {
	return false;
  }
});

$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});

//--></script> 
<?php echo $footer; ?>
