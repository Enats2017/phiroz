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
            <td style="width:7%;">
              <?php echo $entry_date_start; ?>
              <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="8" />
            </td>
            <td style="width:6%;">
              <?php echo $entry_date_end; ?>
              <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="8" />
            </td>
            <td style="width:9%;">
              <?php echo $entry_owner; ?>
              <input type="text" name="filter_owner" value="<?php echo $owner_name; ?>"  class="filter_owner" size="30" />
              <input type="hidden" name="filter_owner_id" value="<?php echo $owner_id; ?>" id="filter_owner_id" /> 
            </td>
            <td style="width:13%;"><?php echo 'Owner Email'; ?>
              <input type="text" name="filter_email" value="<?php echo $email; ?>" id="filter_email" size="20" />
            </td>
            <td style="text-align: right;">
              <a onclick="filter();" class="button" style="padding: 15px 15px;"><?php echo $button_filter_normal; ?></a>
              <a onclick="filter_export();" class="button" style="padding: 15px 15px;"><?php echo 'Export'; ?></a>
              <a onclick="myFunction();" class="button" style="padding: 13px 1px;"><?php echo 'Invoice Email'; ?></a>
            </td>
        </tr>
      </table>
      <table class="list" style="width:99%;">
        <thead>
          <tr>
            <td class="left" colspan="2"><?php echo $column_sr_no; ?></td>
            <td class="left" colspan="2"><?php echo $column_bill_no; ?></td>
            <td class="left" colspan="2"><?php echo $column_owner_name; ?></td>
            <td class="left" colspan="2"><?php echo 'Month'; ?></td>
            <td class="right" colspan="2"><?php echo $column_total; ?></td>
            <td class="right" colspan="2"><?php echo 'balance'; ?></td>
            <td class="right" colspan="2"><?php echo 'Status'; ?></td>
            <td class="center" colspan="2"><?php echo 'Payment Date'; ?></td>
            <td class="right" colspan="2"><?php echo 'Payment Type'; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php $total1 = 0; ?>
        <?php $balance_total = 0; ?>
          <?php if ($bill_checklist) { ?>
          <?php 
            $i = 1; 
            $total1 = 0;
          ?>
          <?php foreach ($bill_checklist as $order) { ?>
          <tr>
            <td class="left" colspan="2"><?php echo $i; ?></td>
            <td class="left" colspan="2"><a href="<?php echo $order['bill_href']; ?>"><?php echo $order['bill_id']; ?></a></td>
            <td class="left" colspan="2"><?php echo $order['owner_name']; ?></td>
            <td class="left" colspan="2"><?php echo $order['month']; ?></td>
             <td class="right" colspan="2"><?php echo 'Rs.',$order['total']; ?></td>
            <td class="right" colspan="2"><?php echo 'Rs.',$order['balance']; ?></td>
            <td class="right" colspan="2">
            <?php if($order['payment_status'] == 1) {?>
              <?php echo 'Paid'; ?>
            <?php } else {?>
              <?php echo 'Unpaid'; ?>
             <?php }?>
            </td>
            <td class="right" colspan="2"><?php echo $order['payment_date']; ?></td>
            <td class="center" colspan="2">
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
            $total1 = $total1 + $order['raw_total'];
            $balance_total = $balance_total + $order['balance']; 
          ?>
          <?php } ?>
          <tr>
            <td colspan="8" align="right" style="font-weight: bolder">Total :</td>
            <td class="right" colspan="2">
              <?php echo $this->currency->format($total1, $this->config->get('config_currency')); ?>
            </td>
            <td colspan="2" class="right"><?php echo $this->currency->format($balance_total, $this->config->get('config_currency')); ?></td>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td colspan="2"></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <br/>
      <!---------------------------------------- Debit Amount ------------------------------------->
      <table class="list" style="width:99%;">
          <thead>
            <tr>
              <td class="left" colspan="2"><?php echo 'Sr No'; ?></td>
              <td class="left" colspan="2" style="display: none"><?php echo $column_owner_name; ?></td>
              <td class="left" colspan="2"><?php echo 'Comment'; ?></td>
              <td class="right" colspan="2"><?php echo 'Debit Amount'; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php $total2 = 0; ?>
            <?php if ($bill_debits) { ?>
            <?php 
              $i = 1; 
            ?>
            <?php foreach ($bill_debits as $orders) { ?>
            <tr>
              <td class="left" colspan="2"><?php echo $i; ?></td>
              <td class="left" colspan="2" style="display: none"><?php echo $orders['owner_name']; ?></td>
              <td class="left" colspan="2"><?php echo $orders['comment']; ?></td>
              <td class="right" colspan="2"><?php echo $orders['debit_amount']; ?></td>
            </tr>
            <?php 
              $i++;
              $total2 = $total2 + $orders['debit_amount']; 
            ?>
            <?php } ?>
            <tr>
              <td colspan="4">
              </td>
              <td class="right" colspan="5">
                <?php echo $this->currency->format($total2, $this->config->get('config_currency')); ?> 
            </td>
            </tr>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
      </table>
      <br/>
      <!---------------------------------------- Credit Amount ------------------------------------->
      <table class="list" style="width:99%;">
        <thead>
          <tr>
            <td class="left" colspan="2"><?php echo 'Sr No'; ?></td>
            <td class="left" colspan="2" style="display: none"><?php echo $column_owner_name; ?></td>
            <td class="left" colspan="2"><?php echo 'Comment'; ?></td>
            <td class="right" colspan="2"><?php echo 'Credit Amount'; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php $total3 = 0; ?>
          <?php if ($bill_credits) { ?>
          <?php 
            $i = 1; 
            $total3 = 0;
          ?>
          <?php foreach ($bill_credits as $orders) { ?>
          <tr>
            <td class="left" colspan="2"><?php echo $i; ?></td>
            <td class="left" colspan="2" style="display: none"><?php echo $orders['owner_name']; ?></td>
            <td class="left" colspan="2"><?php echo $orders['comment']; ?></td>
            <td class="right" colspan="2"><?php echo $orders['credit_amount']; ?></td>
          </tr>
          <?php 
            $i++;
            $total3 = $total3 + $orders['credit_amount']; 
          ?>
          <?php } ?>
          <tr>
            <td colspan="4">
            </td>
            <td class="right" colspan="5">
               <?php echo $this->currency->format($total3, $this->config->get('config_currency')); ?>
            </td>
          </tr>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
    </table>
    <br/>
    <table style="margin:auto;">
      <thead>
        <?php  {  $total_a = $total1 + $total2;  $total_amount = $total_a - $total3;
          ?>
        <tr>
          <td colspan="6" style="font-size:25px;">Total Amount : <?php echo $total_amount ?></td>
        </tr>
        <?php } ?>
      </thead>
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


$('.filter_owner').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>&filter_name_1=' +  encodeURIComponent(request.term),
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
    $('input[name=\'filter_owner\']').val(ui.item.label);
    $('input[name=\'filter_owner_id\']').val(ui.item.value);
    $('input[name=\'filter_email\']').val(ui.item.email);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});


function filter() {
  url = 'index.php?route=reports/owner_bill&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

   var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  
  if (filter_owner) {
    url += '&filter_owner=' + encodeURIComponent(filter_owner);
  }

  var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
  if (filter_owner_id) {
    url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
  }

   var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }

  url += '&first=0';
  
  location = url;
  return false;
}


function filter_export() {
  url = 'index.php?route=reports/owner_bill/export&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

   var filter_owner = $('input[name=\'filter_owner\']').attr('value');
  
  if (filter_owner) {
    url += '&filter_owner=' + encodeURIComponent(filter_owner);
  }

  var filter_owner_id = $('input[name=\'filter_owner_id\']').attr('value');
  
  if (filter_owner_id) {
    url += '&filter_owner_id=' + encodeURIComponent(filter_owner_id);
  }

  // var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  // if (filter_email) {
  //   url += '&filter_email=' + encodeURIComponent(filter_email);
  // }

  url += '&first=0';
  
  location = url;
  return false;
}


function filter_print() {
  url = 'index.php?route=reports/owner_bill/printinvoice&token=<?php echo $token; ?>';
  
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

  var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
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
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});



function myFunction() {
  confirmation = confirm('are you sure send mail!');
  if (confirmation == true) {
    filter_print();
  } else {
    return false;
  }
}
//</script>  -->
<?php echo $footer; ?>
