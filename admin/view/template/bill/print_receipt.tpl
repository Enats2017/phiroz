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
          <td style="width:15%;">
            <?php echo $entry_name; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" />
          </td>
          <td style="width:15%;">
            <?php echo $entry_trainer; ?>
            <input type="text" name="filter_trainer" value="<?php echo $filter_trainer; ?>" id="filter_trainer" size="20" />
            <input type="hidden" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" id="filter_trainer_id" size="20" />
          </td>
          <td style="width:10%;">
            <?php echo $entry_month; ?>
            <select name="filter_month" id="filter_month" style="width:83px;">
              <?php foreach($months as $key => $value) { ?>
                <?php if ($filter_month == $key) { ?>
                  <option value="<?php echo $key ?>" selected="selected"><?php echo $value; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:6%;">
            <?php echo $entry_year; ?>
            <select name="filter_year" id="filter_year" style="width:68px;">
              <?php for($i=2009; $i<=2020; $i++) { ?>
                <?php if($filter_year == $i) { ?>
                  <option value="<?php echo $i ?>" selected="selected"><?php echo $i; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $i ?>"><?php echo $i; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:13%;">
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
          <?php if(isset($this->request->get['bill']) && $this->request->get['bill'] == 1) { ?>
          <td style="width:13%;display:none;"><?php echo $entry_transaction_type; ?>
            <select name="filter_transaction_type" id="filter_transaction_type" style="width:77%">
              <?php foreach($transaction_types as $tkey => $tvalue) { ?>
                <?php if ($filter_transaction_type == $tkey) { ?>
                  <option value="<?php echo $tkey ?>" selected="selected"><?php echo $tvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $tkey ?>"><?php echo $tvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <?php } ?>
          <td style="text-align: right;">
            <a onclick="filter_list();" class="button" style="padding: 13px 18px;"><?php echo $button_list; ?></a>
            <a onclick="filter_print();" class="button" style="padding: 13px 18px;"><?php echo $button_filter; ?></a>
          </td>
        </tr>
      </table>
      <table class="list" style="width:99%;">
        <thead>
          <tr>
            <td class="left"><?php echo $column_sr_no; ?></td>
            <td class="left"><?php echo $column_bill_no; ?></td>
            <td class="left"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_trainer_name; ?></td>
            <td class="left"><?php echo $column_owner_name; ?></td>
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
            [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
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
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter_list() {
	url = 'index.php?route=bill/print_receipt&token=<?php echo $token; ?>';
	
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

  url += '&bill=1';
  
  /*
  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type) {
    url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }
  */
  /*
  var win = window.open(url, '_blank');
  win.focus();
	*/
  location = url;
  return false;
}

function filter_print() {
  url = 'index.php?route=bill/print_receipt/printreceipt&token=<?php echo $token; ?>';
  
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
  
  /*
  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type) {
    url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }
  */
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

/*
setInterval(function(){
  var fileLoading = $.cookie('fileLoading');
  if(fileLoading != '' && fileLoading != null){
    // clean the cookie for future downoads
    $.cookie('fileLoading', '', { expires: 30});
    url = 'index.php?route=bill/print_receipt&token=<?php echo $token; ?>';
  
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