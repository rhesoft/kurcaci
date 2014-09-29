<?php print $this->form_eksternal->form_open_multipart("", 'class=" form-horizontal well" id="formoutlet"', 
        array("id_detail" => $detail[0]->id_mrp_inventory_brand))?>
  <fieldset>
    <div class="control-group">
      <h4>Title</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control" placeholder="Name"');?>
      </div>
    </div>
    <div class="control-group">
      <h4>Picture</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_upload('picture', $detail[0]->picture, 'class="form-control"');
          if($detail[0]->picture)
            print "<br /><img src='".base_url()."files/mrp/products/{$detail[0]->picture}' width='50' />";
          else
            print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
          ?>
      </div>
    </div>
    <div class="control-group">
      <h4>Note</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control" id="editor1"')?>
      </div>
    </div>
  </fieldset>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("mrp/master-mrp/brand")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>