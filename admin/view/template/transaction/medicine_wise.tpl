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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a id="save" onclick="filter_save();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_select_medicine_wise; ?></td>
              <td>
                <input type="text" name="medicine_name" id="medicine_name" value="<?php echo $medicine_name; ?>" size="100" tabindex="2" />
                <input type="text" name="no_mouse"  id="no_mouse" class="med_id" value="focus here and press enter" tabindex="3" />
                <input type="hidden" name="medicine_name_id" id="medicine_name_id" value="<?php echo $medicine_name_id; ?>" size="100" />
                <?php if ($error_medicine_name) { ?>
                <span class="error"><?php echo $error_medicine_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr style="display:none;">
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
          <div class="buttons" style="text-align:center;">
            <h4>Treatment Details</h4>
          </div>
          <div style="text-align:center;">
            <?php if ($error_medicine) { ?>
            <span class="error"><?php echo $error_medicine; ?></span>
            <?php } ?>
          </div>
          <table id="medicine_content" class="list">
            <thead>
              <tr>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_treatment; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_doctor; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Volume'; ?></td>
<!--                 <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo 'Volume'; ?></td>
 -->                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_price; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_quantity; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_total; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_action; ?></td>
              </tr>
            </thead>
            <?php $medicine_field_row = 0; ?>
            <?php //if($medicine_name_id != '') { ?>
              <?php foreach ($medicines as $medicine) { ?>
              <tbody id="medicine_contents_row<?php echo $medicine_field_row; ?>">
                <tr>
                  <td class="left" style="width:35%;">
                    <input type="text" readony="readonly" name="medicines[<?php echo $medicine_field_row ?>][m_name]" value = "<?php echo $medicine['m_name'] ?>"  size="50" />
                    <input type="text"  readony="readonly" name="medicines[<?php echo $medicine_field_row ?>][m_name_id]" value = "<?php echo $medicine['m_name_id'] ?>"  size="50" />
                  </td>
                  <td class="left" style="width:18%;">
                    <input type="text" readonly="readonly" name="medicines[<?php echo $medicine_field_row ?>][m_doctor_name]" value = "<?php echo $medicine['m_doctor_name'] ?>" size="18" />
                    <input type="hidden" readonly="readonly" name="medicines[<?php echo $medicine_field_row ?>][m_doctor_id]" value = "<?php echo $medicine['m_doctor_id'] ?>" />
                  </td>
                  <td class="left" style="width:10%;">
                    <input type="text" readonly="readonly" id="m_volume-<?php echo $medicine_field_row ?>" name="medicines[<?php echo $medicine_field_row ?>][m_volume]" value = "<?php echo $medicine['m_volume'] ?>" size="10" />
                  </td>
                  <td class="left" style="width:10%;">
                    <select name="office_location" id="office_location" class="form-control">
                    <?php foreach ($volumes as $volume) { ?>
                     <?php if ($office_location == $volume) { ?>
                      <option value="<?php echo $volume; ?>" selected><?php echo $volume; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $volume; ?>" ><?php echo $volume; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                  <td class="left" style="width:10%;">
                    <input type="text" class="search_medicine_price" id="m_price-<?php echo $medicine_field_row ?>" name="medicines[<?php echo $medicine_field_row ?>][m_price]" value = "<?php echo $medicine['m_price'] ?>" size="10"/>
                    <input type="hidden" name="medicines[<?php echo $medicine_field_row; ?>][m_field_row]" value = "<?php echo $medicine_field_row; ?>" />
                    <?php if(isset($error_medicines[$medicine_field_row]['medicine_price'])) { ?>
                      <span class="error"><?php echo $error_medicines[$medicine_field_row]['medicine_price']; ?></span>
                    <?php } ?>
                  </td>
                  <td class="left" style="width:10%;">
                    <input type="text" class="search_medicine_quantity" id="m_quantity-<?php echo $medicine_field_row ?>" name="medicines[<?php echo $medicine_field_row ?>][m_quantity]" value = "<?php echo $medicine['m_quantity'] ?>" size="10" />
                    <?php if(isset($error_medicines[$medicine_field_row]['medicine_quantity'])) { ?>
                      <span class="error"><?php echo $error_medicines[$medicine_field_row]['medicine_quantity']; ?></span>
                    <?php } ?>
                  </td>
                  <td class="left" style="width:10%;">
                    <input type="text" readonly="readonly" id="m_total-<?php echo $medicine_field_row ?>" name="medicines[<?php echo $medicine_field_row ?>][m_total]" value = "<?php echo $medicine['m_total'] ?>" size="10" />
                  </td>
                  <td class="left">
                    <a onclick="remove_folder_medicine(<?php echo $medicine_field_row ?>)" class="button">
                      <span><?php echo $entry_remove; ?></span>
                    </a>
                  </td>
                </tr>
              </tbody>
              <?php $medicine_field_row ++; ?>
              <?php } ?>
            <?php //} ?>
            <tfoot>
              <input type="hidden" id="medicine_field_row" name="medicine_field_row" value="<?php echo $medicine_field_row; ?>" />
            </tfoot>
          </table>
          </div>
            <!---------------------------------------- Treatments Medicine ------------------------------------------------->
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
        <!---------------------------------------- Treatments Medicine End ------------------------------------------------->
          <div class="buttons" style="text-align:center;margin-top:15px;">
            <h4>Horse Details</h4>
            <a style="display:none;" onclick="addExtramedicine();" class="button_save" style="margin-bottom:10px;"><span><?php echo $entry_add_horse; ?></span></a>
          </div>
          <div style="text-align:center;">
            <?php if ($error_horse) { ?>
            <span class="error"><?php echo $error_horse; ?></span>
            <?php } ?>
          </div>
          <div style="float:left;margin-bottom:10px;">
            <input type="text" class="search_horse" name="horse_name" id="horse_name" value="<?php echo $horse_name; ?>" size="40" tabindex="1" />
            <input type="hidden" name="horse_name_id" id="horse_name_id"  value="<?php echo $horse_name_id; ?>" size="100" />
      <input type="text" class="search_date_treatment date" name="search_date_treatment" id="search_date_treatment" value="<?php echo $search_date_treatment; ?>" size="40" />
          </div>
          <table id="horse_content" class="list">
            <thead>
              <tr>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_name; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_trainer; ?></td>
    <?php /* ?>                
    <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_date; ?></td>
    <?php */ ?>                
    <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_action; ?></td>
              </tr>
            </thead>
            <?php $extra_field_row = 0; ?>
            <?php if($horses) { ?>
              <?php foreach ($horses as $horse) { ?>
                <tbody id="horse_contents_row<?php echo $extra_field_row; ?>">
                  <tr>
                    <td class="left" style="width:31%;">
                      <input type="text" readonly="readonly" style="width:31%;" id="search_horse-<?php echo $extra_field_row; ?>" name="horses[<?php echo $extra_field_row; ?>][h_name]" value = "<?php echo $horse['h_name'] ?>" size="40" />
                      <input type="hidden" class="search_horse_id" id="search_horse_id-<?php echo $extra_field_row; ?>" name="horses[<?php echo $extra_field_row; ?>][h_name_id]" value = "<?php echo $horse['h_name_id'] ?>" />
                      <input type="hidden" name="horses[<?php echo $extra_field_row; ?>][h_field_row]" value = "<?php echo $extra_field_row; ?>" />
                      <?php if(isset($error_horses[$extra_field_row]['horse_name'])) { ?>
                        <span class="error"><?php echo $error_horses[$extra_field_row]['horse_name']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left" style="width:28%;">
                      <input type="text" readonly="readonly" class="search_horse_trainer" id="search_horse_trainer-<?php echo $extra_field_row; ?>" name="horses[<?php echo $extra_field_row; ?>][h_trainer]" value = "<?php echo $horse['h_trainer'] ?>" size="35" />
                    </td>
                    <?php /* ?>
        <td class="left">
                      <input type="text" readonly="readonly" class="search_horse_date date" id="search_horse_date-<?php echo $extra_field_row; ?>" name="horses[<?php echo $extra_field_row; ?>][h_date]" value = "<?php echo $horse['h_date'] ?>" />
                    </td>
                    <?php */ ?>
        <td class="left">
                      <a onclick="remove_folder(<?php echo $extra_field_row; ?>)" class="button">
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
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('.date').datepicker({dateFormat: 'dd-mm-yy'});
$('#medicine_name').focus();

$('#no_mouse').live("keypress", function(e) {
        if (e.keyCode == 13) {
            $('#form').submit();
            return false; // prevent the button click from happening
        }
});

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

// $(".med_id").each(function(){
//       alert($(this).val());
// });

    function checkduplicate(medicine_id){
        status = 0;
        $('.med_id').each(function() {
            var pre_did=$(this).attr('id');
            var jackPre_value = $(this).val();
            // alert(jackPre_value);
            if(medicine_id == jackPre_value){
            status = 1;
             alert('This medicine already exist');
            
            }
        });
        return status;
    }

     function checkduplicatehorse(name){
        status = 0;
        $('.horse_check_id').each(function() {
            var pre_did=$(this).attr('id');
            var horsePre_value = $(this).val();
            // alert(jackPre_value);
            if(name == horsePre_value){
            status = 1;
             alert('This Horse already exist');
            
            }
        });
        return status;
    }


$('.search_horse').live('focus', function(i){
  $(this).catcomplete({
    delay: 500,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=transaction/medicine_wise/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) { 
          response($.map(json, function(item) {
            return {
              label: item.name,
              value: item.horse_id,
              trainer_name: item.trainer_name,
              date: item.date,
            }
          }));
        }
      });
    }, 
    select: function(event, ui) {
      getduplicate =  checkduplicatehorse(ui.item.label);
      $('input[name=\'horse_name\']').val('');
      if(getduplicate == 0){
      addExtrahorse(ui.item.label, ui.item.value, ui.item.trainer_name, ui.item.date);
     }
      return false;
    },
    focus: function(event, ui) {
      return false;
    }
  });
});

var extra_field_row = $('#extra_field_row').val();
function addExtrahorse(name, id, trainer, date) {
  html  = '<tbody id="horse_contents_row' + extra_field_row + '">';
    html += '<tr>'; 
      html += '<td class="left" style="width:31%;"><input type="text" readonly="readonly" class="horse_check_id" id="search_horse-'+extra_field_row+'" name="horses[' + extra_field_row + '][h_name]" value="'+name+'"  size="40" />';
      html += '<input type="hidden" class="search_horse_id"  id="search_horse_id-'+extra_field_row+'" name="horses[' + extra_field_row + '][h_name_id]" value="'+id+'"  />';
      html += '<input type="hidden" name="horses[' + extra_field_row + '][h_field_row]" value="'+extra_field_row+'"  />';
      html += '</td>';
      html += '<td class="left" style="width:28%;"><input readonly="readonly" id="search_horse_trainer-'+extra_field_row+'" type="text" name="horses[' + extra_field_row + '][h_trainer]" value="'+trainer+'" size="35" /></td>';
      
      /*
      //html += '<td class="left"><input type="text" class="search_horse_date date" id="search_horse_date-'+extra_field_row+'" name="horses[' + extra_field_row + '][h_date]" value="'+date+'" readonly="readonly" style="cursor:default;" /></td>';
      */
      html += '<td class="left"><a onclick="remove_folder('+extra_field_row+')" class="button"><span><?php echo $entry_remove; ?></span></a></td>';
    html += '</tr>';  
  html += '</tbody>';
  $('#horse_content tfoot').before(html);
  //ownerautocomplete(extra_field_row);
  $('#horse_contents_row' + extra_field_row + ' .date').datepicker({dateFormat: 'dd-mm-yy'});
  //$('.date').datepicker({dateFormat: 'dd-mm-yy'});
  extra_field_row++;
}

function remove_folder(extra_field_row){
  $('#horse_contents_row'+extra_field_row).remove();
  $('#horse_name').focus();
}

//--></script>
<script type="text/javascript"><!--
$('input[name=\'medicine_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=transaction/medicine_wise/autocomplete_medicine&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
            quantity: item.quantity
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    //$('input[name=\'medicine_name_id\']').val(ui.item.value);
    //$('#medicine_contents_row').remove();
     getstatus =  checkduplicate(ui.item.value);
    $('input[name=\'medicine_name\']').val('');
     if(getstatus == 0){
      addExtramedicine(ui.item.label, ui.item.value, ui.item.rate, ui.item.quantity, ui.item.doctor_name, ui.item.doctor_id, ui.item.volume);
     }
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

var medicine_field_row = $('#medicine_field_row').val();
function addExtramedicine(name, id, rate, quantity, doctor_name, doctor_id, volume) {
  total = rate * quantity;
  auto_id = 0;
  html  = '<tbody id="medicine_contents_row' + medicine_field_row + '">';
    html += '<tr>'; 
      html += '<td class="left" style="width:35%;" ><input type="text" readonly="readonly" name="medicines['+medicine_field_row+'][m_name]" value="'+name+'" size="50" /><input type="hidden" id="m_name_id" name="m_name_id" value="'+id+'" />';
      html += '<input readonly="readonly" class="med_id" id="med_id_' + medicine_field_row + '" type="hidden" name="medicines['+medicine_field_row+'][m_name_id]" value="'+id+'" />'
      html += '<input type="hidden" name="medicines[' + medicine_field_row + '][m_field_row]" value="'+medicine_field_row+'"  />';
      html += '</td>';
      html += '<td class="left" style="width:18%;"><input readonly="readonly" type="text" name="medicines['+medicine_field_row+'][m_doctor_name]" value="'+doctor_name+'" size="18" />';
      html += '<input readonly="readonly" type="hidden" name="medicines['+medicine_field_row+'][m_doctor_id]" value="'+doctor_id+'" />'
      html += '</td>';
      // html += '<td class="left" style="width:10%;"></td>';
      html += '<td class="left" style="width:10%;"><input  id="m_volume-'+medicine_field_row+'" type="text" name="medicines['+medicine_field_row+'][m_volume]" value="'+volume+'" size="10" /><select name="medicines['+medicine_field_row+'][volume]" id="volume-'+medicine_field_row+'" class="form-control"><option value="0">0</option><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="60">60</option><option value="70">70</option><option value="80">80</option><option value="90">90</option></select></td>';
      html += '<td class="left" style="width:10%;"><input class="search_medicine_price" id="m_price-'+medicine_field_row+'" type="text" name="medicines['+medicine_field_row+'][m_price]" value="'+rate+'" size="10" /></td>';
      html += '<td class="left" style="width:10%;"><input type="text" class="search_medicine_quantity" id="m_quantity-'+medicine_field_row+'" name="medicines['+medicine_field_row+'][m_quantity]" value="'+quantity+'" size="10" /></td>';
      html += '<td class="left" style="width:10%;"><input readonly="readonly" id="m_total-'+medicine_field_row+'" type="text" name="medicines['+medicine_field_row+'][m_total]" value="'+total+'" size="10" /></td>';
      html += '<td class="left"><a onclick="remove_folder_medicine('+medicine_field_row+')" class="button"><span><?php echo $entry_remove; ?></span></a></td>';
    html += '</tr>';  
  html += '</tbody>';
  $('#medicine_content tfoot').before(html);
  medicine_field_row++;
}

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

function remove_folder_medicine(medicine_field_row){
  $('#medicine_contents_row'+medicine_field_row).remove();
  $('#medicine_name').focus(); 
}

function filter_save(){
  $('#save').attr('onclick', '');
  $('#form').submit();
}

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