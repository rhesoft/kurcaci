<div class="col-md-6">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open("", 'role="form"')?>
    <div class="box-body">
      <div class="form-group">
          <label>Tahun (Wajib dipilih)</label>
          <select id="category_multi" size="18" class="form-control" name="tahun">
            <?php
            for($th = $tahun_awal ; $th <= date("Y") ; $th++){
              print "<option value='{$th}'>{$th}</option>";
            }
            ?>
          </select>
      </div>
    </div>
  </div>    
</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-body">
      <div class="control-group" id="create_sub">
        <label>Bulan (Wajib dipilih)</label>
        <select id="sub_kategory" size="15" class="form-control" name="bulan">
            <?php
//            foreach($bulan AS $k => $bln){
//              print "<option value='{$k}'>{$bln['id']}</option>";
//            }
            ?>
          </select>
      </div>
      
      <div class="box-footer">
          <button class="btn btn-primary" type="submit">Next</button>
          <a href="<?php print site_url("mrp/master-mrp/products")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
      </form>
    </div>
  </div>
</div>