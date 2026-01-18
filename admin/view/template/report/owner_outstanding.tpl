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
          <td style="width:13%;"><?php echo 'Owner Name'; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" /></td>
          
          <td style="text-align: right;">
            <a style="padding: 13px 25px;" onclick="filter();" id="filter" class="button"><?php echo $button_filter; ?></a>
            <!-- <a style="padding: 13px 25px;" onclick="filter_export();" id="export" class="button"><?php echo 'Send Mail'; ?></a> -->
          </td>
        </tr>
      </table>
      <table class="list">
        <thead>

          <tr>
            <td class="left" style="width:6%;"><?php echo "SR.No"; ?></td>
            <td class="left" style="width:10%;"><?php echo "Owner Name" ?></td>
            <td class="right"><?php echo "Pre July 2017 PTK" ?></td>
            <td class="right"><?php echo "Post July 2017 PTK" ?></td>
            <td class="right"><?php echo "Pre July 2017 LMF" ?></td>
            <td class="right"><?php echo "Post July 2017 LMF" ?></td>
            <td class="right"><?php echo "Total" ?></td>
            <td class="right"><?php echo "Action" ?></td>

          </tr>
        </thead>
        <tbody>
          <?php if ($owner_datas) { ?>
            <?php $total = 0; ?>
            <?php $total_ptk = 0; ?>
            <?php $total_lmf = 0; ?>
            <?php $totalbill_ptk = 0; ?>
            <?php $totalbill_lmf = 0; ?>
            <?php $i = 1; ?>
            <?php foreach ($owner_datas as $tvalue) { ?>
              <tr>
                <td class="left"><?php echo $i; ?></td>
                <td class="left"><?php echo $tvalue['name']; ?></td>
                <td class="right"><?php echo $tvalue['outamutptk']; ?></td>
                <td class="right"><?php echo $tvalue['billamount_ptk']; ?></td>
                <td class="right"><?php echo $tvalue['outamutlmf']; ?></td>
                <td class="right"><?php echo $tvalue['billamount_lmf']; ?></td>
                <td class="right"><?php echo $tvalue['total']; ?></td>
                <td class="right"><?php foreach ($tvalue['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
              </tr>
              <?php $i ++; ?>
              <?php $total = $total + $tvalue['total']; ?>
              <?php $total_ptk = $total_ptk + $tvalue['outamutptk']; ?>
              <?php $total_lmf = $total_lmf + $tvalue['outamutlmf']; ?>
              <?php $totalbill_ptk = $totalbill_ptk + $tvalue['billamount_ptk']; ?>
              <?php $totalbill_lmf = $totalbill_lmf + $tvalue['billamount_lmf']; ?>
            <?php } ?>
            <tr>
<<<<<<< HEAD
              <td class="center" colspan="2"><?php echo "Total"; ?></td>
=======
              <td class="center" colspan="2"><?php echo $text_no_results; ?></td>
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
              <td class="right"><?php echo $total_ptk; ?></td>
              <td class="right"><?php echo $totalbill_ptk; ?></td>
              <td class="right"><?php echo $total_lmf; ?></td>
              <td class="right"><?php echo $totalbill_lmf; ?></td>
              <td class="right"><?php echo $total; ?></td>
              <td></td>
            </tr>
          <?php } else { ?>
          <tr>
<<<<<<< HEAD
            <td class="center" colspan="8"><?php echo "No result Found"; ?></td>
=======
            <td class="center" colspan="5"><?php echo "Total"; ?></td>
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
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
  url = 'index.php?route=report/owner_outstanding&token=<?php echo $token; ?>';
  
  var filter_month = $('select[name=\'filter_month\']').attr('value');
<<<<<<< HEAD
=======
  
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
  if (filter_month) {
    url += '&filter_month=' + encodeURIComponent(filter_month);
  }

  var filter_year = $('select[name=\'filter_year\']').attr('value');
<<<<<<< HEAD
=======
  
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
  if (filter_year) {
    url += '&filter_year=' + encodeURIComponent(filter_year);
  }
    
  var filter_name = $('input[name=\'filter_name\']').attr('value');
<<<<<<< HEAD
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);

  var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
=======
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
  }

  var filter_email = $('input[name=\'filter_email\']').attr('value');
<<<<<<< HEAD
=======
  
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
<<<<<<< HEAD
=======
  
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

<<<<<<< HEAD

  url += '&filter_once=1';


=======
>>>>>>> 79e793ffc8cfa07948d2a0738f869177d11048db
  location = url;
  return false;
}

function filter_export() {
  url = 'index.php?route=report/owner_wise_email/export&token=<?php echo $token; ?>';
  
  var filter_month = $('select[name=\'filter_month\']').attr('value');
  
  if (filter_month) {
    url += '&filter_month=' + encodeURIComponent(filter_month);
  }

  var filter_year = $('select[name=\'filter_year\']').attr('value');
  
  if (filter_year) {
    url += '&filter_year=' + encodeURIComponent(filter_year);
  }
    
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
  }

  var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
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
      url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.owner_id,
      email: item.email
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_name\']').val(ui.item.label);
    $('input[name=\'filter_name_id\']').val(ui.item.value);
    $('input[name=\'filter_email\']').val(ui.item.email);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script> 
<?php echo $footer; ?>