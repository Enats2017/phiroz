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
      
			<h1><img src="view/image/admin_theme/base5builder_impulsepro/icon-products-large.png" alt="" /> <?php echo $heading_title; ?></h1>
			
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
              <td><span class="required">*</span> <?php echo $entry_doctor; ?></td>
              <td>
                <select name="doctor">
                <?php foreach($doctors as $dkey => $dvalue) { ?>
                  <?php if ($dvalue['doctor_id'] == $doctor) { ?>
                  <option value="<?php echo $dvalue['doctor_id']; ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $dvalue['doctor_id']; ?>"><?php echo $dvalue['name']; ?></option>
                  <?php } ?>
                <?php } ?>
                </select>
                <?php if ($error_doctor) { ?>
                <span class="error"><?php echo $error_doctor; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_rate; ?></td>
              <td><input type="text" name="rate" value="<?php echo $rate; ?>" size="100" />
                <?php if ($error_rate) { ?>
                <span class="error"><?php echo $error_rate; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_service; ?></td>
              <td><input type="text" name="service" value="<?php echo $service; ?>" size="100" />
                <?php if ($error_service) { ?>
                <span class="error"><?php echo $error_service; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_sirin; ?></td>
              <td><input type="text" name="sirin" value="<?php echo $sirin; ?>" size="100" />
                <?php if ($error_sirin) { ?>
                <span class="error"><?php echo $error_sirin; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_quantity; ?></td>
              <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" size="100" />
                <?php if ($error_quantity) { ?>
                <span class="error"><?php echo $error_quantity; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_travel_sheet; ?></td>
              <td>
                <?php if($travel_sheet == '1') { ?>
                    <input type="radio" name="travel_sheet" class="travel_sheet" value="1"  checked="checked" />
                    <?php echo 'Yes'; ?>
                    <input type="radio" name="travel_sheet" class="travel_sheet" value="0" />
                    <?php echo 'No'; ?>
                <?php } else { ?>
                    <input type="radio" name="travel_sheet" class="travel_sheet" value="1" />
                    <?php echo 'Yes'; ?>
                    <input type="radio" name="travel_sheet" class="travel_sheet" value="0" checked="checked" />
                    <?php echo 'No'; ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo 'Is Surgery'; ?></td>
              <td>
                <?php if($is_surgery == '1') { ?>
                    <input type="radio" name="is_surgery" class="is_surgery" value="1"  checked="checked" />
                    <?php echo 'Yes'; ?>
                    <input type="radio" name="is_surgery" class="is_surgery" value="0" />
                    <?php echo 'No'; ?>
                <?php } else { ?>
                    <input type="radio" name="is_surgery" class="is_surgery" value="1" />
                    <?php echo 'Yes'; ?>
                    <input type="radio" name="is_surgery" class="is_surgery" value="0" checked="checked" />
                    <?php echo 'No'; ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo 'Volume <br /> (In ML)'; ?></td>
              <td>
                <input type="text" name="volume" value="<?php echo $volume; ?>" size="100" />
              </td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 
<?php echo $footer; ?>