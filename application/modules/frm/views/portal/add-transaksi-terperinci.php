<div class="col-md-6">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open("", 'role="form"')?>
    <div class="box-body">
      <div class="form-group">
          <label>Tanggal</label>
          <div class="control-group">
              <?php 
              if(set_value('tanggal'))
                $set_tanggal = set_value('tanggal');
              else
                $set_tanggal = $tahun."-".$bulan."-".date("d H:i");

              print $this->form_eksternal->form_input('tanggal', $set_tanggal, 'id="tanggal" class="form-control input-sm" placeholder="Tanggal dan Waktu" '.$red_tanggal);
              ?>
          </div>
      </div>
      <div class="form-group">
          <label>No Transaksi</label>
          <div class="control-group">
              <?php 
              print $this->form_eksternal->form_input('notransaksi', "", 'class="form-control input-sm" placeholder="Nomor Transaksi" ');
              ?>
          </div>
      </div>
      <div class="form-group">
          <label>Note</label>
          <div class="control-group">
              <?php 
              print $this->form_eksternal->form_textarea('note', "", 'class="form-control input-sm" placeholder="Note" ');
              ?>
          </div>
      </div>
    </div>
  </div>    
</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-body">
      <div class="form-group">
          <label>Debit</label>
          <div class="control-group">
              <?php 
              print $this->form_eksternal->form_input('note', "", 'class="form-control input-sm" placeholder="Note" ');
              print $this->form_eksternal->form_input('note', "", 'class="form-control input-sm" placeholder="Note" ');
              ?>
          </div>
      </div>
      <div class="form-group">
          <label>Kredit</label>
          <div class="control-group">
              <?php 
              print $this->form_eksternal->form_input('note', "", 'class="form-control input-sm" placeholder="Note" ');
              print $this->form_eksternal->form_input('note', "", 'class="form-control input-sm" placeholder="Note" ');
              ?>
          </div>
      </div>
      <div class="box-footer">
          <button class="btn btn-primary" type="submit">Save changes</button>
          <a href="<?php print site_url("frm/portal-frm/account")?>" class="btn btn-warning"><?php print lang("back")?></a>
      </div>
      </form>
    </div>
  </div>
</div>