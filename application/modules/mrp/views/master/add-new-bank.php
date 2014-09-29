<?php print $this->form_eksternal->form_open("", 'class=" form-horizontal well" id="formoutlet"', 
        array("id_detail" => $detail[0]->id_mrp_bank))?>
  <fieldset>
    <div class="control-group">
      <h4>Title</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control" placeholder="Title"');?>
      </div>
    </div>
    <div class="control-group">
      <h4>Code</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('code', $detail[0]->code, 'class="form-control" placeholder="Code"');?>
      </div>
    </div>
  </fieldset>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("mrp/master-mrp/bank")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>