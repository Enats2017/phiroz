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
          <td style="width:13%;">
            <?php echo $entry_name; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" />
          </td>
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
          <td style="width:6%;">
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
          <td style="width:15%;"><?php echo $entry_transaction_type; ?>
            <select name="filter_transaction_type" id="filter_transaction_type" style="width:100%">
              <?php foreach($transaction_types as $tkey => $tvalue) { ?>
                <?php if ($filter_transaction_type == $tkey) { ?>
                  <option value="<?php echo $tkey ?>" selected="selected"><?php echo $tvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $tkey ?>"><?php echo $tvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:15%;"><?php echo 'Type'; ?>
            <select name="filter_type" id="filter_type" style="width:100%">
              <?php foreach($types as $ttkey => $ttvalue) { ?>
                <?php if ($filter_type == $ttkey) { ?>
                  <option value="<?php echo $ttkey ?>" selected="selected"><?php echo $ttvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $ttkey ?>"><?php echo $ttvalue; ?></option>
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
            <td class="left"><?php echo 'Sr.No'; ?></td>
            <td class="left"><?php echo $column_bill_id; ?></td>
            <td class="left"><?php echo $column_owner; ?></td>
            <td class="left"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_trainer; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_received; ?></td>
            <td class="right"><?php echo $column_pending; ?></td>
            <td class="right"><?php echo 'Cheque No'; ?></td>
            <td class="right"><?php echo 'Payment Type'; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($pending_bills) { ?>
          <?php 
            $i = 1; 
          ?>
          <?php foreach ($pending_bills as $order) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $order['bill_id']; ?></td>
            <td class="left"><?php echo $order['owner_name']; ?></td>
            <td class="left"><?php echo $order['horse_name']; ?></td>
            <td class="left"><?php echo $order['trainer_name']; ?></td>
            <td class="right"><?php echo $order['total']; ?></td>
            <td class="right"><?php echo $order['total_received']; ?></td>
            <td class="right"><?php echo $order['total_pending']; ?></td>
            <td class="right"><?php echo $order['cheque_no']; ?></td>
            <td class="right"><?php echo $order['payment_type']; ?></td>
          </tr>
          <?php 
            $i++;
          ?>
          <?php } ?>
          <tr>
            <td colspan="5">
            </td>
            <td class="right">
              <?php echo $raw_total; ?>
            </td>
            <td class="right">
              <?php echo $raw_total_received; ?>
            </td>
            <td class="right">
              <?php echo $raw_total_pending; ?>
            </td>
            <td colspan="2">
            </td>
          </tr>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=report/pending_bills&token=<?php echo $token; ?>';
  
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
  
  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type) {
    url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }

  var filter_type = $('select[name=\'filter_type\']').attr('value');
  
  if (filter_type) {
    url += '&filter_type=' + encodeURIComponent(filter_type);
  }

  location = url;
  return false;
}

function filter_export() {
  url = 'index.php?route=report/pending_bills/export&token=<?php echo $token; ?>';
  
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

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
  
  if (filter_transaction_type) {
    url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
  }

  var filter_type = $('select[name=\'filter_type\']').attr('value');
  
  if (filter_type) {
    url += '&filter_type=' + encodeURIComponent(filter_type);
  }

  location = url;
  return false;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  /*$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});*/
  
  /*$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});*/
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
      url: 'index.php?route=catalog/horse/autocomplete_owner&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
    $('input[name=\'filter_name\']').val(ui.item.label);
    $('input[name=\'filter_name_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script>
<?php
function my_money_format($number) 
{ 
    //$number = '2953154.83';

    $negative = '';
    if(strstr($number,"-")) 
    { 
        $number = str_replace("-","",$number); 
        $negative = "-"; 
    } 
    
    $split_number = @explode(".",$number); 
    $rupee = $split_number[0]; 
    if(isset($split_number[1])){
      $paise = @$split_number[1]; 
    } else {
      $paise = '00';
    }
    
    if(@strlen($rupee)>3) 
    { 
        $hundreds = substr($rupee,strlen($rupee)-3); 
        $thousands_in_reverse = strrev(substr($rupee,0,strlen($rupee)-3)); 
        $thousands = '';
        
        for($i=0; $i<(strlen($thousands_in_reverse)); $i=$i+2) 
        {
            if(isset($thousands_in_reverse[$i+1])){
              $thousands .= $thousands_in_reverse[$i].$thousands_in_reverse[$i+1].","; 
            } else {
              $thousands .= $thousands_in_reverse[$i].","; 
            }
        } 
        $thousands = strrev(trim($thousands,",")); 
        $formatted_rupee = $thousands.",".$hundreds; 
    } else { 
        $formatted_rupee = $rupee; 
    } 
    
    $formatted_paise = '.00';
    if((int)$paise>0) 
    { 
        $formatted_paise = ".".substr($paise,0,2); 
    } 
    
    return $negative.$formatted_rupee.$formatted_paise; 

}
?> 
<?php echo $footer; ?>
