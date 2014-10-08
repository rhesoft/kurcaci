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
                  <label>About Us</label>
                      <?php print $this->form_eksternal->form_textarea('about_us', $detail[0]->about_us, 'class="form-control input-sm" id="editor1"')?>
                </div>
                
                <div class="box-footer">
                  <a href="<?php print site_url("portal/client-portal/add-new-company-bidang-usaha")?>" class="btn btn-info"><?php print lang("prev")?></a>
                  <button class="btn btn-primary" type="submit">Finish</button>
                  <a href="<?php print site_url("users/detail-biodata")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
            </form>

              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->