
<?php print $this->form_eksternal->form_open("", 'role="form"', 
        array("id_detail" => $detail[0]->id_frm_account_category))?>
  <div class="box-body">

    <div class="control-group">
      <h4>Name</h4>
          <?php
          print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control" placeholder="Title"');?>
    </div>

    <div class="control-group">
      <h4>Account Number</h4>
          <?php
          print $this->form_eksternal->form_input('nomor', $detail[0]->nomor, 'class="form-control" placeholder="Account Number"');?>
    </div>

    <div class="control-group">
      <h4>Pos</h4>
          <?php print $this->form_eksternal->form_dropdown('pos', array(1 => "Debit", 2 => "Kredit"), array($detail[0]->pos), 'class="form-control"')?>
    </div>

    <div class="control-group">
      <h4>Status Labarugi</h4>
          <?php print $this->form_eksternal->form_checkbox('labarugi', 2, $labarugi)?> Labarugi
    </div>
    
    <div class="control-group">
      <h4>Status Modal</h4>
          <?php print $this->form_eksternal->form_checkbox('modal', 2, $modal)?> Modal
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("frm/master-frm/account-category")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>
            