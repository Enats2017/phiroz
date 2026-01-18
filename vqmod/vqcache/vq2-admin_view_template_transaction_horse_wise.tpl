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
      
			<h1><img src="view/image/admin_theme/base5builder_impulsepro/icon-products-large.png" alt="" /> <?php echo $heading_title; ?></h1>
			
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_select_horse_wise; ?></td>
              <td>
                <input type="text" name="h_name" id="h_name" value="<?php echo $h_name; ?>" size="100" />
                <input type="hidden" name="h_name_id" id="h_name_id" value="<?php echo $h_name_id; ?>" size="100" />
                <?php if ($error_horse) { ?>
                <span class="error"><?php echo $error_horse; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_dot; ?></td>
              <td><input readonly="readony" style="cursor:default;" type="text" name="dot" value="<?php echo $dot; ?>" size="10" class="date"/>
                <?php if ($error_dot) { ?>
                <span class="error"><?php echo $error_dot; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr style="display:none;">
              <td><span class="required">*</span> <?php echo $entry_transaction_type; ?></td>
              <td>
                <?php if($transaction_type == '1') { ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="1"  checked="checked" />
                    <?php echo 'Cheque'; ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="2" />
                    <?php echo 'Cash'; ?>
                <?php } else { ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="1" />
                    <?php echo 'Cheque'; ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="2" checked="checked" />
                    <?php echo 'Cash'; ?>
                <?php } ?>
              </td>
            </tr>
          </table>
          <div style="text-align:center;">
            <?php if ($error_medicine) { ?>
            <span class="error"><?php echo $error_medicine; ?></span>
            <?php } ?>
          </div>
          <div style="float:left;margin-bottom:10px;">
            <label style="text-align:left"> Medicine</label>
            <input type="text" class="search_medicine" name="medicine_name" id="medicine_name" value="<?php echo $medicine_name; ?>" size="40" />
            <input type="hidden" name="medicine_name_id" id="medicine_name_id" value="<?php echo $medicine_name_id; ?>" size="100" />
          </div>
    <div style="float:right;margin-top:10px;">
    <a href="<?php echo $travelsheet; ?>" >Travel Sheet</a>
          </div>
          <table id="medicine_content" class="list">
            <thead>
              <tr>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_treatment; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_doctor; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Volume'; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_price; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_quantity; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_total; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_action; ?></td>
              </tr>
            </thead>
            <?php $extra_field_row = 0; ?>
            <?php if($medicines) { ?>
              <?php foreach ($medicines as $medicine) { ?>
                <tbody id="medicine_contents_row<?php echo $extra_field_row; ?>">
                  <tr>
                    <td class="left" style="width:35%;">
                      <input type="text" readonly="readonly" id="search_medicine-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][m_name]" value = "<?php echo $medicine['m_name'] ?>" size="50" />
                      <input type="hidden" class="search_medicine_id" id="search_medicine_id-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][m_name_id]" value = "<?php echo $medicine['m_name_id'] ?>" />
                      <input type="hidden" name="medicines[<?php echo $extra_field_row; ?>][m_field_row]" value = "<?php echo $extra_field_row; ?>" />
                      <?php if(isset($error_medicines[$extra_field_row]['medicine_name'])) { ?>
                        <span class="error"><?php echo $error_medicines[$extra_field_row]['medicine_name']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left" style="width:18%;">
                      <input type="text" readonly="readonly" name="medicines[<?php echo $extra_field_row; ?>][m_doctor_name]" value = "<?php echo $medicine['m_doctor_name'] ?>" size="18" />
                      <input type="hidden" name="medicines[<?php echo $extra_field_row; ?>][m_doctor_id]" value = "<?php echo $medicine['m_doctor_id'] ?>" />
                      <input type="hidden" id="m_transaction_id-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][transaction_id]" value = "<?php echo (isset($medicine['transaction_id']) ? $medicine['transaction_id'] : 0) ?>" />
                    </td>
                    <td class="left" style="width:10%;">
                      <input type="text" readonly="readonly" id="m_volume-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][m_volume]" value = "<?php echo $medicine['m_volume'] ?>" size="10"/>
                    </td>
                    <td class="left" style="width:10%;">
                      <input type="text" class="search_medicine_price" id="m_price-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][m_price]" value = "<?php echo $medicine['m_price'] ?>" size="10"/>
                      <?php if(isset($error_medicines[$extra_field_row]['medicine_price'])) { ?>
                        <span class="error"><?php echo $error_medicines[$extra_field_row]['medicine_price']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left" style="width:10%;">
                      <input type="text" class="search_medicine_quantity" id="m_quantity-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][m_quantity]" value = "<?php echo $medicine['m_quantity'] ?>" size="10"/>
                      <?php if(isset($error_medicines[$extra_field_row]['medicine_quantity'])) { ?>
                        <span class="error"><?php echo $error_medicines[$extra_field_row]['medicine_quantity']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left" style="width:10%;">
                      <input type="text" readonly="readonly" id="m_total-<?php echo $extra_field_row; ?>" name="medicines[<?php echo $extra_field_row; ?>][m_total]" value = "<?php echo $medicine['m_total'] ?>" size="10" />
                      <?php if(isset($error_medicines[$extra_field_row]['medicine_total'])) { ?>
                        <span class="error"><?php echo $error_medicines[$extra_field_row]['medicine_total']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left">
                      <a onclick="remove_folder(<?php echo $extra_field_row; ?>)" class="button" id="remove<?php echo $extra_field_row; ?>" >
                        <span><?php echo $entry_remove; ?></span>
                      </a>
                    </td>
                  </tr>
                </tbody>
              <?php $extra_field_row++; ?>
              <?php } ?>
            <?php } else { ?>
            <?php } ?>
            <tfoot>
            </tfoot>
            <input type="hidden" id="extra_field_row" name="extra_field_row" value="<?php echo $extra_field_row; ?>" />
          </table>
          <hr>
        <table>
          <thead>
              <tr>
                  <td><?php echo 'Trearment Medicine' ; ?></td>
              </tr>
              <tr>
                  <td>
                      <input type="text" class="" name="treatment_name" id="treatment_name" value="<?php echo $medicine_name; ?>" size="40" />
                  </td>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>
                      <label style="margin-top: 20px;">Trearment Medicine :</label>
                  </td>
                  <br/>
                  <td>
                      <span type="hidden" id="treatment_div" style="font-size:16px; height:18px;"></span>
                  </td>
              </tr>
          </tbody>
        </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('.date').datepicker({dateFormat: 'dd-mm-yy'});

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

function remove_folder(extra_field_row){
  //$('#medicine_contents_row'+extra_field_row).remove();
  transaction_id = $('#m_transaction_id-'+extra_field_row).val();
  if(transaction_id != '0'){
    $.ajax({
        url: 'index.php?&route=transaction/horse_wise/removetransaction&token=<?php echo $token; ?>&transaction_id='+transaction_id,
        type:'GET',
        asyn: false,
        dataType: 'json',
        beforeSend: function() {
    $('#remove'+extra_field_row).after('<img src="view/image/loading.gif" alt="" />');
        },
        complete: function() {
          $('#medicine_contents_row'+extra_field_row).remove();
        },  
        success: function(data) {
        }
    });
  } else {
    $('#medicine_contents_row'+extra_field_row).remove();
  }
}

var extra_field_row = $('#extra_field_row').val();
function addExtramedicine(name, id, rate, quantity, doctor_name, doctor_id, volume) {
  total = rate * quantity;
  html  = '<tbody id="medicine_contents_row' + extra_field_row + '">';
    html += '<tr>'; 
      html += '<td class="left" style="width:35%;"><input type="text" readonly="readonly" name="medicines[' + extra_field_row + '][m_name]" value="'+name+'"  size="50" />';
      html += '<input type="hidden" name="medicines[' + extra_field_row + '][m_name_id]" value="'+id+'"  />';
      html += '<input type="hidden" name="medicines[' + extra_field_row + '][m_field_row]" value="'+extra_field_row+'"  />';
      html += '</td>';
      html += '<td class="left" style="width:18%;"><input readonly="readonly" type="text" name="medicines[' + extra_field_row + '][m_doctor_name]" value="'+doctor_name+'" size="18" />';
      html += '<input readonly="readonly" type="hidden" name="medicines[' + extra_field_row + '][m_doctor_id]" value="'+doctor_id+'" /><input type="hidden" name="medicines[' + extra_field_row + '][transaction_id]" id="m_transaction_id-'+extra_field_row+'" value="0" />';
      html += '</td>';
      html += '<td class="left" style="width:10%;"><input id="m_volume-'+extra_field_row+'" type="text" name="medicines[' + extra_field_row + '][m_volume]" value="'+volume+'" size="10"/><select name="medicines['+extra_field_row+'][volume]" id="volume-'+extra_field_row+'" class="form-control"><option value="0">0</option><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="60">60</option><option value="70">70</option><option value="80">80</option><option value="90">90</option></select></td>';
      html += '<td class="left" style="width:10%;"><input class="search_medicine_price" id="m_price-'+extra_field_row+'" type="text" name="medicines[' + extra_field_row + '][m_price]" value="'+rate+'" size="10"/></td>';
      html += '<td class="left" style="width:10%;"><input type="text" class="search_medicine_quantity" id="m_quantity-'+extra_field_row+'" name="medicines[' + extra_field_row + '][m_quantity]" value="'+quantity+'" size="10"/></td>';
      html += '<td class="left" style="width:10%;"><input readonly="readonly" id="m_total-'+extra_field_row+'" type="text" name="medicines[' + extra_field_row + '][m_total]" value="'+total+'" size="10" /></td>';
      html += '<td class="left"><a onclick="remove_folder('+extra_field_row+')" class="button"><span><?php echo $entry_remove; ?></span></a></td>';
    html += '</tr>';  
  html += '</tbody>';
  $('#medicine_content tfoot').before(html);
  //ownerautocomplete(extra_field_row);
  extra_field_row++;
}


$('.search_medicine').live('focus', function(i){
  $(this).catcomplete({
    delay: 500,
    source: function(request, response) {
      date = $('.date').val();
      $.ajax({
        url: 'index.php?route=transaction/horse_wise/autocomplete_medicine&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term) +'&date=' + date,
        dataType: 'json',
        success: function(json) { 
          response($.map(json, function(item) {
            return {
              label: item.name,
              value: item.medicine_id,
              rate: item.rate,
              volume: item.volume,
              doctor_id: item.doctor_id,
              doctor_name: item.doctor_name,
              quantity: item.quantity,
              exist_alert : item.exist_alert
            }
          }));
        }
      });
    }, 
    select: function(event, ui) {
      $('input[name=\'medicine_name\']').val('');
      addExtramedicine(ui.item.label, ui.item.value, ui.item.rate, ui.item.quantity, ui.item.doctor_name, ui.item.doctor_id, ui.item.volume);
      if (ui.item.exist_alert != '') {
        alert(ui.item.exist_alert);
      }
      return false;
    },
    focus: function(event, ui) {
      return false;
    }
  });
});

$('.search_medicine_quantity').live('keyup', function(i){
  idss = $(this).attr('id');
  s_id = idss.split('-');
  quantity = $('#m_quantity-'+s_id[1]).attr('value');
  price = $('#m_price-'+s_id[1]).attr('value');
  total = price * quantity;
  $('#m_total-'+s_id[1]).attr('value', total);
});

$('.search_medicine_price').live('keyup', function(i){
  idss = $(this).attr('id');
  s_id = idss.split('-');
  quantity = $('#m_quantity-'+s_id[1]).attr('value');
  price = $('#m_price-'+s_id[1]).attr('value');
  total = price * quantity;
  $('#m_total-'+s_id[1]).attr('value', total);
});

//--></script>
<script type="text/javascript"><!--
$('input[name=\'h_name\']').autocomplete({
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
    $('input[name=\'h_name\']').val(ui.item.label);
    $('input[name=\'h_name_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});





//--></script>


<script type="text/javascript"><!--
$('input[name=\'treatment_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    console.log(request.term);
    $.ajax({
      url: 'index.php?route=catalog/treatments/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.treatment_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'treatment_name\']').val(ui.item.label);
        html  = '<div class="col-sm-5" style="border:1px solid #c1c4c0; background-color:#E7EFEF; width:200px; border-radius:4px; padding:6px 6px;">'+ui.item.label+'</div>';
        $('#treatment_div').html('');
        $('#treatment_div').append(html);
        return false; // prevent the button click from happening
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script>
<?php echo $footer; ?>