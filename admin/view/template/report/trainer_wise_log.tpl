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
          <td style="width:5%;"><?php echo 'Date Start'; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
            <td style="width:5%;"><?php echo 'Date End:'; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td style="width:5%;"><?php echo 'Trainer'; ?>
            <input type="text" name="filter_trainer" value="<?php echo $filter_trainer; ?>" id="filter_trainer" size="20" />
            <input type="hidden" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" id="filter_trainer_id" size="20" /></td>
          <td style="width:5%;"><?php echo $entry_doctor; ?>
            <select name="filter_doctor" id="filter_doctor">
                <option value="0"><?php echo $text_all; ?></option>
              <?php foreach($doctors as $dkey => $dvalue) { ?>
                <?php if ($filter_doctor == $dvalue['doctor_id']) { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>"><?php echo $dvalue['name']; ?></option>
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
      <h3><?php echo 'Period : ' . date('d-m-Y', strtotime($filter_date_start)) . ' - ' . date('d-m-Y', strtotime($filter_date_end)); ?></h3>
      <?php if($filter_trainer != ''){ ?>
        <h3><?php echo 'Trainer : ' . $filter_trainer; ?></h3>
      <?php } ?>
      <table class="list">
        <thead>
          <tr>
            <td class="left" style="display: none;"><?php echo $column_trainer; ?></td>
            <td class="left" style="border: 1px solid;"><?php echo $column_horse_name; ?></td>
            <td class="left" style="border: 1px solid;"></td>
            
          </tr>
        </thead>
        <tbody>
          <?php if ($trainer_datas) { ?>
            <?php $total = 0; ?>
            <?php foreach ($trainer_datas as $trainer_data) { ?>
              <tr style="display: none;">
                <td class="left" style="border:none !important;padding-bottom:15px;"><?php echo $trainer_data['trainer_name']; ?></td>
              </tr>
              <?php $cnt = 0; ?>
              <?php $cnt_log = count($trainer_data['horse_data']); ?>
              <?php foreach($trainer_data['horse_data'] as $hkey => $hvalue) { ?>
                <?php $cnt ++; ?>
                <?php if($cnt == $cnt_log) { ?>
                  <tr style="border-bottom:1px solid;border-left: 1px solid;border-right: 1px solid;">
                <?php } else { ?>
                  <tr style="border-bottom:1px dotted;border-left: 1px solid;border-right: 1px solid;">
                <?php } ?>
                <td class="left" style="border:none !important;padding-bottom:15px;display: none;"></td>
                <td class="left" style="border:none !important;padding-bottom:15px;"><?php echo $hvalue['horse_name']; ?></td>
                <td class="left" style="border:none !important;padding-bottom:15px;">
                  <table style="width: 100%;">
                    <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
                      <tr>
                        <td style="width: 60%;">
                          <?php echo $mvalue['medicine_name']; ?>
                        </td>
                        <td style="width: 15%;">
                          <?php echo $mvalue['dot']; ?>
                        </td>
                        <td style="width: 15%;">
                          <?php echo $mvalue['medicine_amount']; ?>
                        </td>
                        <td style="width: 10%;">
                          <?php echo $mvalue['medicine_quantity']; ?>
                        </td>
                      </tr>  
                    <?php } ?>
                  </table>
                </td>
                
                <?php /*<td class="left" style="border:none !important;padding-bottom:15px;">
                  <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
                    <?php echo $mvalue['dot']; ?><br />
                  <?php } ?>
                </td>
                <td class="left" style="border:none !important;padding-bottom:15px;">
                  <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
                    <?php echo $mvalue['medicine_amount']; ?><br />
                  <?php } ?>
                </td>
                <td class="left" style="border:none !important;padding-bottom:15px;">
                  <?php foreach($hvalue['medicine_data'] as $mkey => $mvalue) { ?>
                    <?php echo $mvalue['medicine_quantity']; ?><br />
                  <?php } ?>
                </td>
              </tr> */ ?>
              <?php } ?>
            <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=report/trainer_wise_log&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  if (filter_trainer_id) {
    var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
    if (filter_trainer) {
      url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
    }
  }

	var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  location = url;
  return false;
}

function filter_export() {
  url = 'index.php?route=report/trainer_wise_log/export&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  if (filter_trainer_id) {
    var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
    if (filter_trainer) {
      url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
      url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
    }
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
$(document).ready(function() {
	$('#date-start, #date-end').datepicker({dateFormat: 'yy-mm-dd'});
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
//--></script>
<?php echo $footer; ?>