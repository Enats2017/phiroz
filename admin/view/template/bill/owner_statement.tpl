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
          <td style="width:35%;">
            <?php echo $entry_owner; ?>
            <select name="filter_owner[]" class="filter_owner" multiple="multiple">
              <?php foreach($filter_owner as $fkey => $fvalue){ ?>
                <option value="<?php echo $fkey; ?>" selected="selected"><?php echo $fvalue; ?></option>
              <?php } ?>
            </select>
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
            <a onclick="filter_export();" class="button" style="padding: 13px 1px;"><?php echo 'Export'; ?></a>
            <a onclick="csv_export();" class="button" style="padding: 13px 1px;"><?php echo 'Csv'; ?></a>
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
            <td class="left" style="width:20%;"><?php echo "Share"; ?></td>
            <td class="left"><?php echo 'Month'; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo 'Balance'; ?></td>
            <td class="right"><?php echo 'Status'; ?></td>
            <td class="right"><?php echo 'Payment Type'; ?></td>
            
          </tr>
        </thead>
        <tbody>
          <?php $balance_total = 0; ?>
          <?php if ($bill_checklist) { ?>
          <?php 
            $i = 1; 
            $total = 0;
          ?>
          <?php foreach ($bill_checklist as $order) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $order['bill_id']; ?></td>
            <td class="left"><?php echo $order['horse_name']; ?></td>
            <td class="left"><?php echo $order['trainer_name']; ?></td>
            <td class="left"><?php echo $order['owner_name']; ?></td>
            <td class="left"><?php echo $order['share']; ?></td>
            <td class="left"><?php echo $order['month']; ?></td>
            <td class="right"><?php echo $order['total']; ?></td>
            <td class="right"><?php echo 'Rs.',$order['balance']; ?></td>
            <td class="right">
            <?php if($order['payment_status'] == 1) {?>
              <?php echo 'Paid'; ?>
            <?php } else {?>
              <?php echo 'Unpaid'; ?>
             <?php }?>
            </td>
            <td class="center">
            <?php if($order['payment_type'] == 1) {?>
               <?php echo 'Cash'; ?>
            <?php } elseif($order['payment_type'] == 2) { ?>
              <?php echo 'Cheque'; ?>
             <?php } elseif($order['payment_type'] == 3) { ?>
              <?php echo 'Online-Payment'; ?>
              <?php }?>
            </td>
             
          </tr>
          <?php 
            $i++;
            $total = $total + $order['raw_total']; 
            $balance_total = $balance_total + $order['balance']; 
          ?>
          <?php } ?>
          <tr>
            <td colspan="7">
            </td>
            <td class="right">
              <?php echo $this->currency->format($total, $this->config->get('config_currency')); ?>
            </td>
            <td class="right"><?php echo $this->currency->format($balance_total, $this->config->get('config_currency')); ?></td>
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

function formatRepo (repo) {
  if (repo.loading) return repo.text;

  var markup = '<div class="clearfix">' +
  '<div class="col-sm-6">' + repo.text + '</div>' +
  '</div>';
  markup += '</div></div>';
  return markup;
}

function formatRepoSelection (repo) {
  return repo.text || repo.text;
}

$('.filter_owner').select2({
  //filter_name = $('input[name=\'filter_owner\']').val();
  ajax: {
    //url: "https://api.github.com/search/repositories",
    url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>',
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data,
        pagination: {
          more: (params.page * 10) < 7000
        }
      };
    },
    cache: true
  },
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 1,
  templateResult: formatRepo, // omitted for brevity, see the source of this page
  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
});

function filter() {
  url = 'index.php?route=bill/owner_statement&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  filter_owner_selected = jQuery('.filter_owner').select2('data');
  owner_string = '';
  owner_name = '';
  //console.log(filter_owner_selected);
  //return false;
  for(i=0;i<filter_owner_selected.length; i++){
    owner_string += filter_owner_selected[i]['id']+',';
    owner_name += filter_owner_selected[i]['text']+',';
  }
  //var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  if (owner_string) {
    //url += '&filter_owner=' + encodeURIComponent(filter_owner);
    //var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
    //if (filter_owner_id) {
      url += '&filter_owner_id=' + encodeURIComponent(owner_string);
      url += '&filter_owner=' + encodeURIComponent(owner_name);
    //}
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

function filter_export() {
  url = 'index.php?route=bill/owner_statement/export&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
  
  filter_owner_selected = jQuery('.filter_owner').select2('data');
  owner_string = '';
  owner_name = '';
  for(i=0;i<filter_owner_selected.length; i++){
    owner_string += filter_owner_selected[i]['id']+',';
    owner_name += filter_owner_selected[i]['text']+',';
  }
  //var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  if (owner_string) {
    //url += '&filter_owner=' + encodeURIComponent(filter_owner);
    //var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
    //if (filter_owner_id) {
      url += '&filter_owner_id=' + encodeURIComponent(owner_string);
      url += '&filter_owner=' + encodeURIComponent(owner_name);
    //}
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
function csv_export() {
  url = 'index.php?route=bill/owner_statement/csv_export&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
  
  filter_owner_selected = jQuery('.filter_owner').select2('data');
  owner_string = '';
  owner_name = '';
  for(i=0;i<filter_owner_selected.length; i++){
    owner_string += filter_owner_selected[i]['id']+',';
    owner_name += filter_owner_selected[i]['text']+',';
  }
  //var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  if (owner_string) {
    //url += '&filter_owner=' + encodeURIComponent(filter_owner);
    //var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
    //if (filter_owner_id) {
      url += '&filter_owner_id=' + encodeURIComponent(owner_string);
      url += '&filter_owner=' + encodeURIComponent(owner_name);
    //}
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

/*
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
*/

$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});

//--></script> 
<?php echo $footer; ?>
