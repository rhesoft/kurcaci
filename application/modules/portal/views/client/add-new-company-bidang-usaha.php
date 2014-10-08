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
                  <label>Cari</label>
                    <?php print $this->form_eksternal->form_input('cari_bidang_usaha', "", 'id="cari_bidang_usaha" class="form-control input-sm" placeholder="Cari Bidang Usaha"');
                    ?>
                </div>
                
                <div class="form-group">
                    <label>Bidang Usaha</label>
                    <select id="portal_bidang_usaha" size="23" class="form-control" name="id_portal_bidang_usaha">
                      <?php
                      foreach($portal_bidang_usaha AS $pbu){
                        $select = "";
                        if($pbu->id_portal_bidang_usaha == $detail[0]->id_portal_bidang_usaha){
                          $select = "selected";
                        }
                        print "<option value='{$pbu->id_portal_bidang_usaha}' {$select}>{$pbu->title}</option>";
                      }
                      ?>
                    </select>
                </div>
                
                <div class="box-footer">
                  <a href="<?php print site_url("portal/client-portal/add-new-company-address")?>" class="btn btn-info"><?php print lang("prev")?></a>
                  <button class="btn btn-primary" type="submit">Next</button>
                  <a href="<?php print site_url("users/detail-biodata")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
            </form>

              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->