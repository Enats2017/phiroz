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
			
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td>
                <?php if ($sort == 'trainer') { ?>
                <a href="<?php echo $sort_trainer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_trainer; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_trainer; ?>"><?php echo $column_trainer; ?></a>
                <?php } ?>
              </td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>"  style="width:210px;" /></td>
              <td>
                <input type="text" id="filter_trainer" name="filter_trainer" value="<?php echo $filter_trainer; ?>" style="width:150px;"/>
                <input type="hidden" id="filter_trainer_id" name="filter_trainer_id" value="<?php echo $filter_trainer_id; ?>" />
                <?php /* ?>
                <select name="filter_trainer" id="filter_trainer">
                  <option value="*"></option>
                  <?php foreach($doctors as $dkey => $dvalue) { ?>
                    <?php if ($dvalue['trainer_id'] == $filter_trainer) { ?>
                    <option value="<?php echo $dvalue['trainer_id']; ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $dvalue['trainer_id']; ?>"><?php echo $dvalue['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <?php */ ?>
              </td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
              <?php if ($horses) { ?>
              <?php foreach ($horses as $horse) { ?>
              <tr>
                <td style="text-align: center;"><?php if ($horse['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $horse['horse_id']; ?>" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $horse['horse_id']; ?>" />
                  <?php } ?></td>
                <td class="left"><?php echo $horse['name']; ?></td>
                <td class="left"><?php echo $horse['trainer_name']; ?></td>
                <td class="right"><?php foreach ($horse['action'] as $action) { ?>
                  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                  <?php } ?></td>
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
  url = 'index.php?route=catalog/horse&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_trainer_id = $('input[name=\'filter_trainer_id\']').attr('value');
  var filter_trainer = $('input[name=\'filter_trainer\']').attr('value');
  if (filter_trainer) {
    url += '&filter_trainer_id=' + encodeURIComponent(filter_trainer_id);
    url += '&filter_trainer=' + encodeURIComponent(filter_trainer);
  }
  
  location = url;
  return false;
}
//--></script>
<script type="text/javascript"><!--
$('#filter_name, #filter_trainer').keydown(function(e) {
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
      url: 'index.php?route=catalog/horse/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
    $('input[name=\'filter_name\']').val(ui.item.label);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script>
<script type="text/javascript"><!--
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