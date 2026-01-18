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
          <td style="width:7%;">
            <?php echo 'Bill Id'; ?>
            <input type="text" name="filter_bill_id" value="<?php echo $filter_bill_id; ?>" id="filter_bill_id" size="4" />
          </td>
          <td style="text-align: right;">
            <a onclick="$('#form').submit();" class="button" style="display:none;"><?php echo 'Paid'; ?></a>
            <a onclick="filter();" class="button" style="padding: 13px 4px;"><?php echo 'Filter'; ?></a>
          </td>
        </tr>
      </table>
      <table class="list" style="width:99%;">
        <thead>
          <tr>
            <td class="left" style="width:1%;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left" style="width:1%;"><?php echo 'Sr.No'; ?></td>
            <td class="left" style="width:6%;"><?php echo 'Bill Id'; ?></td>
            <td class="left" style="width:15%;"><?php echo 'Horse Name'; ?></td>
            <td class="left"><?php echo 'Trainer Name'; ?></td>
            <td class="right"><?php echo 'Action'; ?></td>
          </tr>
        </thead>
        <form action="<?php //echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <tbody>
            <?php if ($bill_checklist) { ?>
            <?php $i = 1; ?>
            <?php foreach ($bill_checklist as $order) { ?>
            <tr>
              <td class="left">
                <input type="checkbox" name="selected[]" value="<?php echo $order['bill_id']; ?>" />
              </td>
              <td class="left"><?php echo $i; ?></td>
              <td class="left"><?php echo $order['bill_id']; ?></td>
              <td class="left"><?php echo $order['horse_name']; ?></td>
              <td class="left"><?php echo $order['trainer_name']; ?></td>
              <td class="right">
                <?php foreach ($order['action'] as $action) { ?>
                  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?>
              </td>
            </tr>
            <?php $i++; ?>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </form>
      </table>
      <?php /* ?>
      <div class="pagination"><?php echo $pagination; ?></div>
      <?php */ ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=tool/owner_change&token=<?php echo $token; ?>';
  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
    url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
  }
  url += '&first=0';
  location = url;
  return false;
}

$('#filter_bill_id').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
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

$('input[name=\'filter_owner\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
    $('input[name=\'filter_owner\']').val(ui.item.label);
    $('input[name=\'filter_owner_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

//--></script> 
<?php echo $footer; ?>