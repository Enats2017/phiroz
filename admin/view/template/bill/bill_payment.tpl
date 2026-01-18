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
          <td style="width:1%;">
            <?php echo $entry_bill_id; ?>
            <input type="text" name="filter_bill_id" value="<?php echo $filter_bill_id; ?>" id="filter_bill_id" size="6" />
          </td>
          <td style="width:10%;">
            <?php echo 'Month'; ?>
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
          <td style="width:6%;">
            <?php echo 'Dr'; ?>
            <select name="filter_doctor" id="filter_doctor">
              <option value="0">All</option>
              <?php foreach($doctors as $dkey => $dvalue) { ?>
                <?php if ($filter_doctor == $dvalue['doctor_id']) { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>"><?php echo $dvalue['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:15%;"><?php echo 'Clinic'; ?>
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
          <td style="width:1%;">
            <?php echo 'Batch Id'; ?>
            <input type="text" name="filter_batch_id" value="<?php echo $filter_batch_id; ?>" id="filter_batch_id" size="2" />
          </td>
          <td style="width:12%;"><?php echo 'Type'; ?>
            <select name="filter_type" id="filter_type" style="">
              <?php foreach($types as $tkey => $tvalue) { ?>
                <?php if ($filter_type == $tkey) { ?>
                  <option value="<?php echo $tkey ?>" selected="selected"><?php echo $tvalue; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $tkey ?>"><?php echo $tvalue; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="text-align: right;">
            <a onclick="$('#form').submit();" class="button" style=""><?php echo 'Accept'; ?></a>
            <a onclick="filter();" class="button" style=""><?php echo 'Filter'; ?></a>
            <a onclick="filter_csv();" class="button" style=""><?php echo 'Export CSV'; ?></a>
            <a href="<?php echo $generate_payment ?>" class="button" style=""><?php echo 'Export Payment CSV'; ?></a>
            <a id="import_owner" class="button" style="display:none;"><?php echo 'Import Payment Data'; ?></a>
            <input style="display: none;" type="file" id="import_owner_1">
          </td>
          
          <?php /* ?>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="import">
            <input type="file" name="import_owner" value = "owner" />aaaa
            <input type="file" name="import_bill" value = "bill" />
          </form>
          <?php */ ?>
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
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <?php if ($bill_checklist) { ?>
            <?php $i = 1; ?>
            <?php foreach ($bill_checklist as $order) { ?>
            <tr>
              <td class="left">
                <input type="checkbox" name="selected[]" value="<?php echo $order['id']; ?>" />
              </td>
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
          </form>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
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
  url = 'index.php?route=bill/bill_payment&token=<?php echo $token; ?>';
  
  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
    url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
    url += '&first=0';
  }
  
  if(filter_bill_id == ''){
    inn=0;
    var filter_batch_id = $('input[name=\'filter_batch_id\']').attr('value');
    if (filter_batch_id) {
      url += '&filter_batch_id=' + encodeURIComponent(filter_batch_id);
      url += '&first=0';
    }

    var filter_month = $('select[name=\'filter_month\']').attr('value');
    if (filter_month && filter_month != '0') {
      inn=1;
      url += '&filter_month=' + encodeURIComponent(filter_month);
    }

    var filter_year = $('select[name=\'filter_year\']').attr('value');
    if (filter_year && filter_month != '0') {
      inn=1;
      url += '&filter_year=' + encodeURIComponent(filter_year);
    }
      
    var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
    if (filter_doctor && filter_month != '0') {
      inn=1;
      url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
    }

    var filter_transaction_type = $('select[name=\'filter_transaction_type\']').attr('value');
    if (filter_transaction_type && filter_month != '0') {
      inn=1;
      url += '&filter_transaction_type=' + encodeURIComponent(filter_transaction_type);
    }

    var filter_type = $('select[name=\'filter_type\']').attr('value');
    if (filter_type) {
      inn=1;
      url += '&filter_type=' + encodeURIComponent(filter_type);
    }
    
    if(inn == 1){
      url += '&first=0';
    }
  }

  location = url;
  return false;
}

function filter_csv() {
  url = 'index.php?route=bill/bill_payment/generate_csv&token=<?php echo $token; ?>';
  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if(filter_bill_id == ''){
    inn=0;
    var filter_batch_id = $('input[name=\'filter_batch_id\']').attr('value');
    if (filter_batch_id) {
      url += '&filter_batch_id=' + encodeURIComponent(filter_batch_id);
      url += '&first=0';
    }

    var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
    if (filter_doctor && filter_month != '0') {
      inn=1;
      url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
    }

    if(inn == 1){
      url += '&first=0';
    }
  }

  location = url;
  return false;
}


$('#filter_bill_id, #filter_batch_id').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});

document.getElementById('import_owner').onclick = function() {
    document.getElementById('import_owner_1').click();
};

$('#content').on('change', '#import_owner_1', function(event) {
  if (typeof this.files !== "undefined") {
    filestoup = this.files;
    var formdata = new FormData();
    formdata.append('afile', this.files[0]);
    $.ajax({
      url: 'index.php?route=bill/bill_payment/import_data&token=<?php echo $token; ?>',
      type: 'POST',
      data: formdata,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function(json) {
        console.log(json);
        if(json == 1){
          window.location.reload();
        } else {
          alert('Error Importing File');
          return false;
        }
      }
    });
    
  } 
});

//--></script>

<script type="text/javascript"><!--

$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
  $('#filter_bill_id').focus();
});

//--></script> 
<?php echo $footer; ?>