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
                        array("id_portal_company" => $id_portal_company))?>
                  <div class="box-body">
                    
                    <div class="control-group">
                        <br />
                        <div>
                            <?php
                            print $this->form_eksternal->form_addrow_tr(
                                              array("Users", lang("portal_company_position")), 
                                              $isi, 
                                              site_url("portal/master-portal/add-row-users-company"), 
                                              "items", 
                                              "id_items", 
                                              "nomor_flag", 
                                              $tr, 
                                              "width='100%'", true, true, false, $tambah = array());
                            print $this->form_eksternal->form_input('param', count($isi), 'id="nomor_flag" style="display: none;"');
                            ?>
                        </div>
                      </div>
                  <div class="box-footer">
                      <button class="btn btn-primary" type="submit">Save changes</button>
                      <a href="<?php print site_url("portal/master-portal/company")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
                  </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->