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
          <td style="width:13%;"><?php echo $entry_name; ?>
            <input type="text" name="h_name" value="<?php echo $h_name; ?>" id="h_name" size="20" />
            <input type="hidden" name="h_name_id" value="<?php echo $h_name_id; ?>" id="h_name_id" size="20" /></td>
          <td style="text-align: right;">
            <a style="padding: 13px 25px;" onclick="filter();" id="filter" class="button"><?php echo $button_filter; ?></a>
          </td>
        </tr>
      </table>
      <?php if($horse_data) { ?>
      <div>
        <div style="float:left;margin-left:10px;margin-top:10px;">
          <b><?php echo 'Horse Name : '?></b><b><a style="font-size:20px;" href="<?php echo $horse_data['horse_link'] ?>"><?php echo $horse_data['name'] ?></a></b>
        </div>
        <?php /* ?>
        <div style="float:left;margin-left:300px;margin-top:10px;">
          <b><?php echo 'Trainer Name : '?></b><a href="<?php echo $horse_data['horse_link'] ?>"><?php echo $horse_data['trainer_name'] ?></a>
        </div>
        <?php */ ?>
      </div>
      <br />
      <div>
        <div style="margin-left:10px;margin-top:20px;">
          <b><?php echo 'Owner Name : '?></b><?php echo $horse_data['owner_datas']; ?>
        </div>
      </div>
      <div>
        <div style="margin-left:10px;margin-top:10px;">
          <b><?php echo 'Trainer Name : '?></b><a href="<?php echo $horse_data['horse_link'] ?>"><?php echo $horse_data['trainer_name'] ?></a>
        </div>
      </div>
      <div style="border-bottom:1px solid #EEEEEE;padding-bottom:15px;">
        <div style="margin-left:10px;margin-top:10px;">
          <b><?php echo 'Add Treatment : '?></b><a href="<?php echo $horse_data['horse_wise_entry']; ?>">Treatment</a>
        </div>
      </div>
      <h3>Treatment Data :</h3>
      <?php if($horse_treatment) { ?>
        <?php foreach($horse_treatment as $keys => $values) { ?>
          <table style="margin-left:10px;">
            <thead>
            <tr>
              <td colspan="2" style="padding-top:20px;">
                <b><?php echo $keys; ?></b>  
              </td>
            </tr>
            <tr>
              <td style="padding-top:10px;padding-right:100px;">
                <b>Treatment</b>  
              </td>
              <td style="padding-top:10px;text-align:right;">
                <b>Qty</b>  
              </td>
            </tr>
            </thead>
            <tbody>
              <?php foreach($values as $key => $value) { ?>
              <tr>
                <td style="padding-top:10px;">
                  <b><?php echo $value['medicine_name']; ?></b>
                </td>
                <td style="padding-top:10px;text-align:right;">
                  <b><?php echo $value['medicine_quantity']; ?></b>
                </td>
              </tr>      
              <?php } ?>
              <tr>
                <td colspan="2" style="padding-top:10px;">
                  <?php if($value['bill_exist'] == 0) { ?>
                    <a href="<?php echo $value['transaction_edit_link']; ?>">Change Treatment</a>
                  <?php } else { ?>
                    <?php echo 'Billed'; ?>
                  <?php } ?>    
                </td>
              </tr> 
            <tbody>
          </table>

          <?php /* ?>
          <div>
            <div style="margin-left:10px;margin-top:20px;">
              <b><?php echo $keys; ?></b>
            </div>
          </div>
          <div>
            <div style="margin-left:10px;margin-top:10px;">
              <?php echo 'Treatment'; ?>
            </div>
          </div>
          <?php foreach($values as $key => $value) { ?>
          <div>
            <div style="margin-left:10px;margin-top:10px;">
              <b><?php echo $value['medicine_name']; ?> &nbsp;&nbsp;&nbsp; => &nbsp;&nbsp;&nbsp; <?php echo $value['medicine_quantity']; ?></b>
            </div>
          </div>
          <?php } ?>
          <div style="border-bottom:1px solid #EEEEEE;padding-bottom:15px;">
            <div style="margin-left:10px;margin-top:10px;">
              <?php if($value['bill_exist'] == 0) { ?>
                <a href="<?php echo $value['transaction_edit_link']; ?>">Change Treatment</a>
              <?php } else { ?>
                <?php echo 'Billed'; ?>
              <?php } ?>
            </div>
          </div>
          <?php */ ?>
        <?php } ?>
      <?php } ?>
      
      <?php } ?>
      <?php /* ?>
      <div class="pagination"><?php echo $pagination; ?></div>
      <?php */ ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--

$('#h_name').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});

function filter() {
  url = 'index.php?route=report/horse_data&token=<?php echo $token; ?>';
  
  var h_name = $('input[name=\'h_name\']').attr('value');
  
  if (h_name) {
    url += '&h_name=' + encodeURIComponent(h_name);
    var h_name_id = $('input[name=\'h_name_id\']').attr('value');
    if (h_name_id) {
      url += '&h_name_id=' + encodeURIComponent(h_name_id);
    }
  }

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
<?php echo $footer; ?>
