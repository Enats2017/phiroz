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
          <td style="width:10%;">
            <?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="9" />
          </td>
          <td style="width:10%;">
            <?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="9" />
          </td>
          <td style="width:15%;">
            <?php echo $entry_name; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="15" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" />
          </td>
          <td style="width:15%;">
            <?php echo $entry_trainer; ?>
            <input type="text" name="filter_trainer" value="<?php echo $filter_trainer; ?>" id="filter_trainer" size="15" />
            <input type="hidden" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" id="filter_trainer_id" />
          </td>
          <td style="width:8%;">
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
          <td style="text-align: right;">
            <a onclick="filter_generate();" class="button" style="padding: 13px 5px;"><?php echo $button_generate; ?></a>
            <a onclick="filter_print();" class="button" style="padding: 13px 5px;"><?php echo $button_filter; ?></a>
            <a onclick="filter_print_receipt();" class="button" style="padding: 13px 5px;"><?php echo $button_filter_receipt; ?>
            <a class="button" style="padding: 13px 5px;" href="<?php echo $update_ref_id; ?>"><?php echo 'Script Run'; ?></a>
            </a>
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
          <?php $i = 1; ?>
          <?php foreach ($bill_checklist as $order) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $order['bill_id']; ?></td>
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
          <?php $i++; ?>
          <?php } ?>
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
function filter_generate() {
	url = 'index.php?route=bill/print_invoice/generateinvoice&token=<?php echo $token; ?>';
	
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

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  
  if (filter_trainer) {
    url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
    var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  
    if (filter_trainer_id) {
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
    }
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  //var win = window.open(url, '_blank');
  //win.focus();
	location = url;
  return false;
}

function filter_print() {
  url = 'index.php?route=bill/print_invoice/printinvoice&token=<?php echo $token; ?>';
  
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

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  
  if (filter_trainer) {
    url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
    var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  
    if (filter_trainer_id) {
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
    }
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  /*
  var win = window.open(url, '_blank');
  win.focus();
  */
  location = url;
  return false;
}

function filter_print_receipt() {
  url = 'index.php?route=bill/print_receipt/printreceipt&token=<?php echo $token; ?>';
  
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

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  
  if (filter_trainer) {
    url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
    var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  
    if (filter_trainer_id) {
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
    }
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  /*
  var win = window.open(url, '_blank');
  win.focus();
  */
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

/*
setInterval(function(){
  var fileLoading = $.cookie('fileLoading');
  if(fileLoading != '' && fileLoading != null){
    // clean the cookie for future downoads
    $.cookie('fileLoading', '', { expires: 30});
    url = 'index.php?route=bill/print_invoice&token=<?php echo $token; ?>';
  
    var filter_name = $('input[name=\'filter_name\']').attr('value');
    
    if (filter_name) {
      url += '&filter_name=' + encodeURIComponent(filter_name);
      var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    
      if (filter_name_id) {
        url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
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

    var filter_month = $('select[name=\'filter_month\']').attr('value');
    
    if (filter_month) {
      url += '&filter_month=' + encodeURIComponent(filter_month);
    }
      
    var filter_year = $('select[name=\'filter_year\']').attr('value');
    
    if (filter_year) {
      url += '&filter_year=' + encodeURIComponent(filter_year);
    }

    var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
    
    if (filter_doctor) {
      url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
    }

    
    var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
    
    if (filter_transaction_type) {
      url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
    }
    
    
    url += '&bill=1';
    //redirect
    location = url;
    return false;
  } else {
  }
},1000);
*/
//--></script> 
<?php echo $footer; ?>