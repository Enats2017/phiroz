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
			
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button1">Save</a>
        <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
        <a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a>
        <a href="<?php echo $export; ?>" class="button"><?php echo 'Export'; ?></a>
      </div>
    </div>
    <div class="content">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left" style="width:15%;"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td>MRP</td>
              <td>Service</td>
              <td>Cost</td>
              <td>Vol</td>
              <td>Category</td>
              <td>Med_id</td>
              <td>
                <?php if ($sort == 'doctor') { ?>
                <a href="<?php echo $sort_doctor; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_doctor; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_doctor; ?>"><?php echo $column_doctor; ?></a>
                <?php } ?>
              </td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>" style="width:390px;" /></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <select name="filter_doctor" id="filter_doctor">
                  <option value="*"></option>
                  <?php foreach($doctors as $dkey => $dvalue) { ?>
                    <?php if ($dvalue['doctor_id'] == $filter_doctor) { ?>
                    <option value="<?php echo $dvalue['doctor_id']; ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $dvalue['doctor_id']; ?>"><?php echo $dvalue['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <form action="<?php echo $insert_update; ?>" method="post" enctype="multipart/form-data" id="form">
              <?php if ($medicines) { ?>
              <?php foreach ($medicines as $mkey => $medicine) { ?>
              <tr>
                <td style="text-align: center;"><?php if ($medicine['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $medicine['medicine_id']; ?>" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $medicine['medicine_id']; ?>" />
                  <?php } ?></td>
                <td class="left"><?php echo $medicine['name']; ?></td>
                <td class="left"><input type="text" name="medicine_datas[<?php echo $mkey ?>][rate]" size="5" value="<?php echo $medicine['rate']; ?>"></td>
                <td class="left"><?php echo $medicine['service']; ?></td>
                <td><input type="text" size="3" name="medicine_datas[<?php echo $mkey ?>][cost]" value="<?php echo $medicine['cost']; ?>" /></td>
                <td class="left"><input type="text" size="3" name="medicine_datas[<?php echo $mkey ?>][volume]" value="<?php echo $medicine['volume']; ?>" /></td>
                <td>
                  <select name="medicine_datas[<?php echo $mkey ?>][category]" >
                    <option value=""></option>
                    <?php foreach($categories as $ckey => $cvalue) { ?>
                      <?php if ($cvalue == $medicine['category']) { ?>
                      <option value="<?php echo $cvalue; ?>" selected="selected"><?php echo $cvalue; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $cvalue; ?>"><?php echo $cvalue; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </td>
                <td class="left"><?php echo $medicine['medicine_id']; ?></td>
                <input type="hidden" name="medicine_datas[<?php echo $mkey ?>][medicine_id]" value="<?php echo $medicine['medicine_id']; ?>"/>
                <td class="left"><?php echo $medicine['doctor_name']; ?></td>
                <td class="right"><?php foreach ($medicine['action'] as $action) { ?>
                  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                  <br>
                  <?php } ?>
                  </td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </form>
          </tbody>
        </table>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=catalog/medicine&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  if (filter_doctor != '*') {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }
  
  location = url;
  return false;
}
//--></script>
<script type="text/javascript"><!--
$('#filter_name').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/medicine/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script>
<script type="text/javascript">
  
  $(document).on('change', '#input-rate', function(e) {
    alert($('#input-rate').val());
      $('#input-rate1').val($('#input-rate').val());
  });

</script>
<?php echo $footer; ?>