
<?php print $this->form_eksternal->form_open("", 'role="form"')?>
  <div class="box-body">

    <div class="control-group">
      <h4>Tahun</h4>
          <?php 
          for($t = (date("Y") - 4) ; $t <= date("Y") ; $t++){
            $tahun[$t] = $t;
          }
          print $this->form_eksternal->form_dropdown('tahun', $tahun, array(date("Y")), 'class="form-control"');
          ?>
    </div>

    <div class="control-group">
      <h4>Bulan</h4>
          <?php print $this->form_eksternal->form_dropdown('bulan', $this->global_models->get_month_array(), array(date("m")), 'class="form-control"')?>
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Start Journal</button>
  </div>
</form>
            