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
          <td style="width:15%;display:none;">
            <?php echo $entry_name; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" />
          </td>
          <td style="width:15%;display:none;">
            <?php echo $entry_trainer; ?>
            <input type="text" name="filter_trainer" value="<?php echo $filter_trainer; ?>" id="filter_trainer" size="15" />
            <input type="hidden" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" id="filter_trainer_id" />
          </td>
          <td style="width:15%;">
            <?php echo $entry_owner; ?>
            <input type="text" name="filter_owner" value="<?php echo $filter_owner; ?>" id="filter_owner" size="20" />
            <input type="hidden" name="filter_owner_id" value="<?php echo $filter_owner_id; ?>" id="filter_owner_id" />
          </td>
          <td style="width:8%;">
            <?php echo 'From Month'; ?>
            <select name="filter_from_month" id="filter_from_month">
              <?php foreach($months as $mkey => $mvalue) { ?>  <!-- echo"<pre>"; print_r("months"); exit; -->
                <?php if ($mkey == $filter_from_month) { ?>
                  <option value="<?php echo $mkey ?>" selected="selected"><?php echo $mvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $mkey ?>"><?php echo $mvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:8%;">
            <?php echo 'To Month'; ?>
            <select name="filter_to_month" id="filter_to_month">
              <?php foreach($months as $mkey => $mvalue) { ?>  
                <?php if ($mkey == $filter_to_month) { ?>
                  <option value="<?php echo $mkey ?>" selected="selected"><?php echo $mvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $mkey ?>"><?php echo $mvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:5%;">
            <?php echo 'Year'; ?>
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
          <td style="width:7%; display:none;">
            <?php echo $entry_bill_id; ?>
            <input type="text" name="filter_bill_id" value="<?php echo $filter_bill_id; ?>" id="filter_bill_id" size="4" />
          </td>
          <td style="width:8%; display:none;">
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
          <td style="width:15%; display:none;">
            <?php echo 'Cheque No'; ?>
            <input type="text" name="filter_cheque_no" value="<?php echo $filter_cheque_no; ?>" id="filter_cheque_no" size="15" />
          </td>
          <td style="width:8%;">
            <?php echo 'Amount'; ?>
            <input type="text" name="filter_amount" value="<?php echo $filter_amount; ?>" id="filter_amount" size="7" />
          </td>
         <!--  <td style="width:8%;">
            <?php echo 'Discount'; ?>
            <input type="text" name="filter_amount" value="<?php echo $filter_amount; ?>" id="filter_amount" size="7" />
          </td> -->
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
          <td style="text-align: right;">
            <a onclick="filter();" class="button" style="padding: 13px 4px;"><?php echo $button_filter_normal; ?></a>
            <a onclick="$('#form').submit();" class="button" style=""><?php echo 'Paid'; ?></a>
            <a href="<?php echo $bulk_track; ?>" class="button" style="padding: 13px 4px;"><?php echo $button_bulk_track; ?></a>
          </td>
        </tr>
      </table>
      <table class="list" style="width:99%;">
        <thead>
          <tr>
            <td class="left" style="width:1%;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left" style="width:1%;"><?php echo $column_sr_no; ?></td>
            <td class="left" style="width:6%;"><?php echo $column_bill_no; ?></td>
            <td class="left" style="width:15%;"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_trainer_name; ?></td>
            <td class="left" style="width:20%;"><?php echo $column_owner_name; ?></td>
            <td class="right"><?php echo 'Month'; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_balance; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <tbody>
            <?php if ($bill_checklist) { ?>
            <?php 
            $i = 1;
            $total_total = 0;
            $total_balance = 0; 
            ?>
            <?php foreach ($bill_checklist as $order) { ?>
            <tr>
              <td class="left">
                <input type="checkbox" name="selected[]" value="<?php echo $order['id']; ?>" />
              </td>
              <td class="left"><?php echo $i; ?></td>
              <td class="left"><a href="<?php echo $order['bill_href']; ?>"><?php echo $order['bill_id']; ?></a></td>
              <td class="left"><?php echo $order['horse_name']; ?></td>
              <td class="left"><?php echo $order['trainer_name']; ?></td>
              <td class="left"><?php echo $order['owner_name']; ?></td>
              <td class="right"><?php echo $order['month']; ?></td>
              <td class="right"><?php echo $order['total']; ?></td>
              <td class="right"><?php echo $order['balance']; ?></td>
              <td class="right"><?php foreach ($order['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
            </tr>
            <?php 
            $total_total = $total_total + $order['total_raw'];
            $total_balance = $total_balance + $order['balance_raw'];
            $i++; 
            ?>
            <?php } ?>
            <tr> 
            <td colspan="7" class="right">
              <?php echo 'Total : '; ?>
            </td>
            <td class="right">
              <?php echo $this->currency->format($total_total, $this->config->get('config_currency')); ?>
            </td>
            <td class="right">
              <?php echo $this->currency->format($total_balance, $this->config->get('config_currency')); ?>
            </td>
            <td></td>
            </tr>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </form>
      </table>
      <?php /* ?>
      <div class="pagination"><?php echo $pagination; ?></div>
      <?php */ ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=tool/payment_tracking&token=<?php echo $token; ?>';
  
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

  var filter_cheque_no = $('input[name=\'filter_cheque_no\']').attr('value');
  if (filter_cheque_no) {
    url += '&filter_cheque_no=' + encodeURIComponent(filter_cheque_no);
  }

  var filter_amount = $('input[name=\'filter_amount\']').attr('value');
  if (filter_amount) {
    url += '&filter_amount=' + encodeURIComponent(filter_amount);
  }

  var filter_payment_type = $('select[name=\'filter_payment_type\']').attr('value');
  if (filter_payment_type) {
    url += '&filter_payment_type=' + encodeURIComponent(filter_payment_type);
  }

  var filter_from_month = $('select[name=\'filter_from_month\']').attr('value');
  if (filter_from_month) {
    url += '&filter_from_month=' + encodeURIComponent(filter_from_month);
  }

  var filter_to_month = $('select[name=\'filter_to_month\']').attr('value');
  if (filter_to_month) {
    url += '&filter_to_month=' + encodeURIComponent(filter_to_month);
  }


  var filter_year = $('select[name=\'filter_year\']').attr('value');
  if (filter_year) {
    url += '&filter_year=' + encodeURIComponent(filter_year);
  }

  url += '&first=0';
  
  location = url;
  return false;
}

$('#filter_bill_id').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
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