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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><input type="text" name="name" value="<?php echo $name; ?>" size="100" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_trainer; ?></td>
              <td>
                <input type="text" name="trainer" id="trainer" value="<?php echo $trainer; ?>" size="100" />
                <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $trainer_id; ?>" size="100" />
                <?php /* ?>
                <select name="trainer">
                <?php foreach($trainers as $tkey => $tvalue) { ?>
                  <?php if ($tvalue['trainer_id'] == $trainer) { ?>
                  <option value="<?php echo $tvalue['trainer_id']; ?>" selected="selected"><?php echo $tvalue['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tvalue['trainer_id']; ?>"><?php echo $tvalue['name']; ?></option>
                  <?php } ?>
                <?php } ?>
                </select>
                <?php */ ?>
                
                <?php if ($error_trainer) { ?>
                <span class="error"><?php echo $error_trainer; ?></span>
                <?php } ?></td>
            </tr>
            <?php /* ?>
            <tr>
              <td><?php echo $entry_dob; ?></td>
              <td><input type="text" name="dob" value="<?php echo $dob; ?>" size="10" class="date"/>
                <?php if ($error_dob) { ?>
                <span class="error"><?php echo $error_dob; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_doj; ?></td>
              <td><input type="text" name="doj" value="<?php echo $doj; ?>" size="10" class="date"/>
                <?php if ($error_doj) { ?>
                <span class="error"><?php echo $error_doj; ?></span>
                <?php } ?></td>
            </tr>
            <?php */ ?>
          </table>
          <div style="text-align:center;">
            <?php if ($error_share_less) { ?>
            <span class="error"><?php echo $error_share_less; ?></span>
            <?php } ?>
          </div>
          <div class="buttons" style="float:right;">
            <a onclick="addExtraowner();" class="button_save" style="margin-bottom:10px;"><span><?php echo $entry_assign; ?></span></a>
          </div>
          <table id="owner_content" class="list">
            <thead>
              <tr>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_owner; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_share; ?></td>
                <td class="left" style="background-color:#E7EFEF;color:#3e3e3e;"><?php echo $entry_action; ?></td>
              </tr>
            </thead>
            <?php $extra_field_row = 0; ?>
            <?php if($owners) { ?>
              <?php foreach ($owners as $owner) { ?>
                <tbody id="owner_contents_row<?php echo $extra_field_row; ?>">
                  <tr>
                    <td class="left">
                      <input type="text" class="search_owner" id="search_owner-<?php echo $extra_field_row; ?>" name="owners[<?php echo $extra_field_row; ?>][o_name]" value = "<?php echo $owner['o_name'] ?>" />
                      <input type="hidden" class="search_owner_id" id="search_owner_id-<?php echo $extra_field_row; ?>" name="owners[<?php echo $extra_field_row; ?>][o_name_id]" value = "<?php echo $owner['o_name_id'] ?>" />
                      <input type="hidden" name="owners[<?php echo $extra_field_row; ?>][o_field_row]" value = "<?php echo $extra_field_row; ?>" />
                      <?php if(isset($error_owners[$extra_field_row]['owner_name'])) { ?>
                        <span class="error"><?php echo $error_owners[$extra_field_row]['owner_name']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left">
                      <input type="text" name="owners[<?php echo $extra_field_row; ?>][o_share]" value = "<?php echo $owner['o_share'] ?>" />
                      <?php if(isset($error_owners[$extra_field_row]['owner_share'])) { ?>
                        <span class="error"><?php echo $error_owners[$extra_field_row]['owner_share']; ?></span>
                      <?php } ?>
                    </td>
                    <td class="left">
                      <a onclick="remove_folder('<?php echo $extra_field_row; ?>')" class="button">
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
              <tr>
                <td colspan="2"></td>
                <td class="left"><a onclick="addExtraowner('<?php echo $extra_field_row; ?>');" class="button"><?php echo $entry_assign; ?></a></td>
              </tr>
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
$('.date').datepicker({dateFormat: 'yy-mm-dd'});

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
  $('#owner_contents_row'+extra_field_row).remove();
}

var extra_field_row = $('#extra_field_row').val();
function addExtraowner() {
  html  = '<tbody id="owner_contents_row' + extra_field_row + '">';
    html += '<tr>'; 
      html += '<td class="left"><input type="text" class="search_owner" id="search_owner-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_name]" value=""  />';
      html += '<input type="hidden" class="search_owner_id" id="search_owner_id-'+extra_field_row+'" name="owners[' + extra_field_row + '][o_name_id]" value=""  />';
      html += '<input type="hidden" name="owners[' + extra_field_row + '][o_field_row]" value="'+extra_field_row+'"  />';
      html += '</td>';
      html += '<td class="left"><input type="text" name="owners[' + extra_field_row + '][o_share]" value="" /></td>';
      html += '<td class="left"><a onclick="remove_folder('+extra_field_row+')" class="button"><span><?php echo $entry_remove; ?></span></a></td>';
    html += '</tr>';  
  html += '</tbody>';
  $('#owner_content tfoot').before(html);
  //ownerautocomplete(extra_field_row);
  extra_field_row++;
}

//function ownerautocomplete(extra_field_row) {
  //console.log('owners[' + extra_field_row + '][o_name]');
  $('.search_owner').live('focus', function(i){
    $(this).catcomplete({
      delay: 500,
      source: function(request, response) {
        $.ajax({
          url: 'index.php?route=catalog/horse/autocomplete_owner&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
        idss = $(this).attr('id');
        s_id = idss.split('-');
        $('#search_owner-'+s_id[1]).attr('value', ui.item.label);
        $('#search_owner_id-'+s_id[1]).attr('value', ui.item.value);
        return false;
      },
      focus: function(event, ui) {
        return false;
      }
    });
  });
//}

$('#owner_content tbody').each(function(index, element) {
  //ownerautocomplete(index);
});

//--></script>
<script type="text/javascript"><!--
$('input[name=\'trainer\']').autocomplete({
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
    $('input[name=\'trainer\']').val(ui.item.label);
    $('input[name=\'trainer_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script>
<?php echo $footer; ?>
