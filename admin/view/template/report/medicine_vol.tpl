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
          <td style="width:15%;"><?php echo 'Date From'; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td style="width:15%;"><?php echo 'Date To'; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td style="width:13%;"><?php echo "Medicine Name"; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <span id="required" style="display: none; color: red; font-family: cursive;" >Please Enter Medicine Name!</span></td>
          <?php /* ?>
    <td style="display: none; width:15%;"><?php echo 'Is Surgery'; ?>
            <select name="filter_surgery" id="filter_surgery">
              <?php foreach($is_surgerys as $key => $value) { ?>
                <?php if ($filter_surgery == $key) { ?>
                  <option value="<?php echo $key ?>" selected="selected"><?php echo $value; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
    <?php */ ?>
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
            <td class="left"><?php echo 'Horse Name'; ?></td>
           <!--  <td class="left"><?php echo $column_name; ?></td> -->
            <td class="left"><?php echo "Volume"; ?></td>
            <td class="left" style="width:150px;"><?php echo 'Date'; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($results) { ?>
          <?php $i = 1; ?>
          <?php $total = 0; ?>
          <?php foreach ($results as $res) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $res['horse_name']; ?></td>
           <!--  <td class="left"><?php echo $res['medicine_name']; ?></td> -->
            <td class="left"><?php echo $res['volume']; ?></td>
            <td class="left"><?php echo date('d-m-Y', strtotime($res['dot'])); ?></td>
          </tr>
          <?php $total+= $res['volume']; ?>
          <?php $i++; ?>
          <?php } ?>
          <tr>
            <td class="right" colspan="2"><?php echo"Total"; ?></td>
            <td class="left" colspan="2"><?php echo $total; ?></td>
          </tr>
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
  if (document.getElementById('filter_name').value=="") {
    $( "#filter_name" ).focus();

      $('#required').show();
    //alert("Date Field Required.");
    } else {

  url = 'index.php?route=report/medicine_vol&token=<?php echo $token; ?>';
  
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
}

function filter_export() {
  url = 'index.php?route=report/medicine_vol/export&token=<?php echo $token; ?>';
  
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

$('input[name=\'filter_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=report/medicine_vol/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.medicine_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_name\']').val(ui.item.label);
   // $('input[name=\'filter_name_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script> 
<?php echo $footer; ?>