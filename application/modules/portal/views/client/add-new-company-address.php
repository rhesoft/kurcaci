<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id_detail" => $detail[0]->id_portal_company))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Propinsi</label>
                    <?php print $this->form_eksternal->form_input('portal_lokasi', $this->global_models->get_field("portal_lokasi", "title", array("id_portal_lokasi" => $detail[0]->id_portal_lokasi)), 'id="portal_lokasi" class="form-control input-sm" placeholder="Propinsi"');
                    print $this->form_eksternal->form_input('id_portal_lokasi', $detail[0]->id_portal_lokasi, 'id="id_portal_lokasi" style="display:none"');
                    ?>
                </div>
                
                <div class="control-group">
                  <label>Alamat</label>
                      <?php print $this->form_eksternal->form_textarea('address', $detail[0]->address, 'class="form-control input-sm" id="editor1"')?>
                </div>
                
                <div class="box-footer">
                  <a href="<?php print site_url("portal/client-portal/add-new-company")?>" class="btn btn-info"><?php print lang("prev")?></a>
                  <button class="btn btn-primary" type="submit">Next</button>
                  <a href="<?php print site_url("users/detail-biodata")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
            </form>

              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->