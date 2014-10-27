<?php
if($detail[0]->status == 1){
?>
<div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title"><a href="javascript:void(0);" onclick="conf_pemasukan()">Transaksi Sederhana (klik)</a></h3>
          </div>
            <?php
            $pemasukan = "none";
            if(form_error('tanggal')){
              $red_tanggal = "style='border-color: red'";
              $pemasukan = "block";
            }

            if(form_error('notransaksi')){
              $red_notransaksi = "style='border-color: red'";
              $pemasukan = "block";
            }

            if(form_error('id_debit')){
              $red_id_debit = "style='border-color: red'";
              $pemasukan = "block";
            }

            if(form_error('id_kredit')){
              $red_id_kredit = "style='border-color: red'";
              $pemasukan = "block";
            }

            if(form_error('saldo')){
              $red_saldo = "style='border-color: red'";
              $pemasukan = "block";
            }
            ?>
            <div class="box-body" id="pemasukan" style="display: <?php print $pemasukan?>">
              <?php 
              print $this->form_eksternal->form_open("", 'role="form"');
              ?>
                <div class="control-group">
                    <?php 
                    if(set_value('tanggal'))
                      $set_tanggal = set_value('tanggal');
                    else
                      $set_tanggal = $tahun."-".$bulan."-".date("d H:i");
                    
                    print $this->form_eksternal->form_input('tanggal', $set_tanggal, 'id="tanggal" class="form-control input-sm" placeholder="Tanggal dan Waktu" '.$red_tanggal);
                    ?>
                </div><!-- /input-group -->
                <div class="control-group">
                    <?php print $this->form_eksternal->form_input('notransaksi', set_value('notransaksi'), 'class="form-control input-sm" placeholder="Nomor Transaksi" '.$red_notransaksi);?>
                </div><!-- /input-group -->
                <div class="control-group">
                    <?php 
                    print $this->form_eksternal->form_input('debit', set_value('debit'), 'id="frm_account_debit" class="form-control input-sm" placeholder="Account Debit" '.$red_id_debit);
                    print $this->form_eksternal->form_input('id_debit', set_value('id_debit'), 'id="id_frm_account_debit" style="display: none"');
                    ?>
                </div><!-- /input-group -->
                <div class="control-group">
                    <?php 
                    print $this->form_eksternal->form_input('kredit', set_value('kredit'), 'id="frm_account_kredit" class="form-control input-sm" placeholder="Account Kredit" '.$red_id_kredit);
                    print $this->form_eksternal->form_input('id_kredit', set_value('id_kredit'), 'id="id_frm_account_kredit" style="display: none"');
                    ?>
                </div><!-- /input-group -->
                <div class="control-group">
                    <?php print $this->form_eksternal->form_input('saldo', set_value('saldo'), 'id="saldo" class="form-control input-sm" placeholder="Nominal" '.$red_saldo);?>
                </div><!-- /input-group -->
                <div class="control-group">
                    <?php print $this->form_eksternal->form_textarea('note', set_value('note'), 'class="form-control input-sm" placeholder="Note"');?>
                </div><!-- /input-group -->
                
                <br />
                <div class="input-group">
                  <button class="btn btn-primary" type="submit" name="masuk" value="masuk">Save changes</button>
                  <a href="<?php print site_url("frm/portal-frm/catatan-transaksi")?>" class="btn btn-warning"><?php print lang("back")?></a>
                </div>
            </form>
          </div><!-- /.box-body -->
      </div><!-- /.box -->

    </div>
  </div>

<?php }?>
<hr />
<table class="table table-bordered">
  <thead>
    <tr>
        <th>Tanggal</th>
        <th colspan="2">Account</th>
        <th>No Ref</th>
        <th>Debit</th>
        <th>Kredit</th>
    </tr>
  </thead>
  <tbody id="data_list">
    
  </tbody>
  <tfoot>
    <tr>
      <th colspan="6"></th>
    </tr>
  </tfoot>
</table>
<div class="box-footer clearfix" id="halaman_set">
    <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">»</a></li>
    </ul>
</div>