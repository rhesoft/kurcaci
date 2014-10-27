
<?php print $this->form_eksternal->form_open("", 'role="form"', 
        array("id_detail" => $detail[0]->id_frm_account))?>
  <div class="box-body">

    <div class="control-group">
      <h4>Name</h4>
          <?php
          print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control" placeholder="Title"');?>
    </div>

    <div class="control-group">
      <h4>Account Category</h4>
          <?php print $this->form_eksternal->form_dropdown('id_frm_account_category', $category, array($detail[0]->id_frm_account_category), 'class="form-control"')?>
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("frm/master-frm/account")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>
            