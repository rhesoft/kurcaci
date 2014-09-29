<?php print $this->form_eksternal->form_open_multipart("", 'class=" form-horizontal well" id="formoutlet"', 
        array("id_detail" => $detail[0]->id_mrp_supplier))?>

  <div class="box-body">
    
    <div class="control-group">
      <h4>Title</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control" placeholder="Title"');?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>PIC</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('pic', $detail[0]->pic, 'class="form-control" placeholder="PIC"');?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>Telphone</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('telp', $detail[0]->telp, 'class="form-control" placeholder="Telphone"');?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>Email</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('email', $detail[0]->email, 'class="form-control" placeholder="Email"');?>
      </div>
    </div>

    <div class="control-group">
      <h4>Bank</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_dropdown('id_mrp_bank', $bank, array($detail[0]->id_mrp_bank), 'class="form-control"')?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>Nama Account</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('account_name', $detail[0]->account_name, 'class="form-control" placeholder="Nama Account"');?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>Nomor Account</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('account_number', $detail[0]->account_number, 'class="form-control" placeholder="Nomor Account"');?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>Picture</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_upload('picture', $detail[0]->picture, 'class="form-control"');
          if($detail[0]->picture)
            print "<br /><img src='".base_url()."files/mrp/supplier/{$detail[0]->picture}' width='50' />";
          else
            print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
          ?>
      </div>
    </div>
    
    <div class="control-group">
      <h4>Alamat</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_textarea('address', $detail[0]->address, 'class="form-control" id="editor1"')?>
      </div>
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("mrp/master-mrp/supplier")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>

</form>