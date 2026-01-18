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
      <table class="form" style="">
        <tr>
          <td style="width:5%;"><?php echo 'Date From'; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td style="width:5%;"><?php echo 'Date To'; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td style="width:5%;"><?php echo 'Category'; ?>
            <select name="filter_category" id="filter_category">
              <?php foreach($categories as $key => $value) { ?>
                <?php if ($filter_category == $key) { ?>
                  <option value="<?php echo $key ?>" selected="selected"><?php echo $value; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:5%;"><?php echo 'Trainer'; ?>
            <input type="text" name="filter_trainer" value="<?php echo $filter_trainer; ?>" id="filter_trainer" size="20" />
            <input type="hidden" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" id="filter_trainer_id" />
          </td>
          <td style="width:5%;"><?php echo 'Doctor'; ?>
            <select name="filter_doctor" id="filter_doctor">
              <?php foreach($doctors as $key => $value) { ?>
                <?php if ($filter_doctor == $value['doctor_id']) { ?>
                  <option value="<?php echo $value['doctor_id'] ?>" selected="selected"><?php echo $value['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $value['doctor_id'] ?>"><?php echo $value['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="text-align: right;">
            <a style="padding: 13px 25px;" onclick="filter();" id="filter" class="button"><?php echo $button_filter; ?></a>
            <a style="padding: 13px 25px;" onclick="filter_export();" id="filter_export" class="button"><?php echo 'Export'; ?></a>
          </td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo 'Sr.No'; ?></td>
            <td class="left"><?php echo 'Category Name'; ?></td>
            <td class="left"><?php echo 'Quantity'; ?></td>
            <td class="left"><?php echo 'Total'; ?></td>
            <td class="left"><?php echo 'Trainer'; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($horse_wise) { ?>
          <?php $i = 1; ?>
          <?php foreach ($horse_wise as $res) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $res['category']; ?></td>
            <td class="left"><?php echo $res['medicine_quantity']; ?></td>
            <td class="left"><?php echo $res['medicine_total']; ?></td>
            <td class="left"><?php echo $res['trainer_name']; ?></td>
          </tr>
          <?php $i++; ?>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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
  url = 'index.php?route=report/medicine_report&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
    
  var filter_category = $('select[name=\'filter_category\']').attr('value');
  if (filter_category) {
      url += '&filter_category=' + encodeURIComponent(filter_category);
  }

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  if (filter_trainer) {
    var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
    if (filter_trainer_id) {
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
      url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
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
  url = 'index.php?route=report/medicine_report/export&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
    
  var filter_category = $('select[name=\'filter_category\']').attr('value');
  if (filter_category) {
      url += '&filter_category=' + encodeURIComponent(filter_category);
  }

  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  if (filter_trainer) {
    var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
    if (filter_trainer_id) {
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
      url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
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

$('input[name=\'filter_trainer\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/trainer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
//--></script> 
<?php echo $footer; ?>
