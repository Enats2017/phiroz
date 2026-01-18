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
          <td>
            <?php echo $entry_owner; ?>
            <input type="text" name="filter_owner" value="<?php echo $filter_owner; ?>" id="filter_owner" size="25" />
            <input type="hidden" name="filter_owner_id" value="<?php echo $filter_owner_id; ?>" id="filter_owner_id" />
          </td>
          <td>
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
            <a onclick="filter();" class="btn btn-primary" ><?php echo $button_filter_normal; ?></a>
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
          <?php if(isset($this->request->get['first']) && $this->request->get['first'] == 0) { ?>
            <td style="">
              <?php echo $entry_amount; ?>
              <input type="text" name="filter_amount" value="<?php echo $filter_amount; ?>" id="filter_amount" size="10" />
              <?php echo $entry_dop; ?>
              <input type="text" name="filter_dop" value="<?php echo $filter_dop; ?>" id="filter_dop" size="10" class="date" />
              <?php if(isset($this->request->get['first']) && $this->request->get['first'] == 0) { ?>
                <a onclick="filter_payment();" class="btn btn-primary"><?php echo $button_payment; ?></a>
              <?php } ?>
            </td>
          <?php } ?>
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
            <td class="right"><?php echo $column_balance; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($bill_checklist) { ?>
          <?php 
          $i = 1;
          $total_total = 0;
          $total_balance = 0; 
          ?>
          <?php foreach ($bill_checklist as $order) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $order['bill_id']; ?></td>
            <td class="left"><?php echo $order['horse_name']; ?></td>
            <td class="left"><?php echo $order['trainer_name']; ?></td>
            <td class="left"><?php echo $order['owner_name']; ?></td>
            <td class="right"><?php echo $order['total']; ?></td>
            <td class="right"><?php echo $order['balance']; ?></td>
          </tr>
          <?php 
          $total_total = $total_total + $order['total_raw'];
          $total_balance = $total_balance + $order['balance_raw'];
          $i++; 
          ?>
          <?php } ?>
          <tr> 
            <td colspan="5" class="right">
              <?php echo 'Total : '; ?>
            </td>
            <td class="right">
              <?php echo $this->currency->format($total_total, $this->config->get('config_currency')); ?>
            </td>
            <td class="right">
              <?php echo $this->currency->format($total_balance, $this->config->get('config_currency')); ?>
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
  url = 'index.php?route=tool/payment_tracking_owners&token=<?php echo $token; ?>';
  
  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }
  
  var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  if (filter_owner) {
    url += '&filter_owner=' + encodeURIComponent(filter_owner);
    var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
    if (filter_owner_id) {
      url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
    }
  }

  url += '&first=0';
  
  location = url;
  return false;
}

function filter_payment() {
  url = 'index.php?route=tool/payment_tracking_owners/payment&token=<?php echo $token; ?>';
  
  var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  
  if (filter_owner) {
    url += '&filter_owner=' + encodeURIComponent(filter_owner);
    var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
    if (filter_owner_id) {
      url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
    }
  }

  var filter_amount = $('input[name=\'filter_amount\']').attr('value');
  
  if (filter_amount) {
    url += '&filter_amount=' + encodeURIComponent(filter_amount);
  }

  var filter_dop = $('input[name=\'filter_dop\']').attr('value');
  
  if (filter_dop) {
    url += '&filter_dop=' + encodeURIComponent(filter_dop);
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


$(document).ready(function() {
  $('.date').datepicker({dateFormat: 'yy-mm-dd'});
});

//--></script> 
<?php echo $footer; ?>