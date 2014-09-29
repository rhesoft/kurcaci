<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
                    array("id_detail" => $detail[0]->id_portal_company))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Bidang Usaha</label>
                    <?php print $this->form_eksternal->form_input('portal_bidang_usaha', $this->global_models->get_field("portal_bidang_usaha", "title", array("id_portal_bidang_usaha" => $detail[0]->id_portal_bidang_usaha)), 'id="portal_bidang_usaha" class="form-control input-sm" placeholder="Bidang Usaha"');
                    print $this->form_eksternal->form_input('id_portal_bidang_usaha', $detail[0]->id_portal_bidang_usaha, 'id="id_portal_bidang_usaha" style="display:none"');
                    ?>
                </div>
                
                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Draft", '2' => "Active", '3' => "Block"), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>

                <div class="control-group">
                  <label>Logo</label>
                  <?php print $this->form_eksternal->form_upload('logo', $detail[0]->logo, "class='input-sm'");
                  if($detail[0]->logo)
                    print "<br /><img src='".base_url()."files/portal/company/logo/{$detail[0]->logo}' width='50' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>

                <div class="control-group">
                  <label>Alamat</label>
                      <?php print $this->form_eksternal->form_textarea('address', $detail[0]->address, 'class="form-control input-sm" id="editor1"')?>
                </div>
                
                <div class="control-group">
                  <label>Propinsi</label>
                    <?php print $this->form_eksternal->form_input('portal_lokasi', $this->global_models->get_field("portal_lokasi", "title", array("id_portal_lokasi" => $detail[0]->id_portal_lokasi)), 'id="portal_lokasi" class="form-control input-sm" placeholder="Propinsi"');
                    print $this->form_eksternal->form_input('id_portal_lokasi', $detail[0]->id_portal_lokasi, 'id="id_portal_lokasi" style="display:none"');
                    ?>
                </div>

              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
    <div class="col-md-6">
      <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <div class="box-body">
              
              <div class="control-group">
                  <label>Email</label>
                      <?php print $this->form_eksternal->form_input('email', $detail[0]->email, 'class="form-control input-sm" placeholder="Email"')?>
                </div>

                <div class="control-group">
                  <label>Telphone</label>
                      <?php print $this->form_eksternal->form_input('telphone', $detail[0]->telphone, 'class="form-control input-sm" placeholder="Telphone"')?>
                </div>

                <div class="control-group">
                  <label>Handphone</label>
                      <?php print $this->form_eksternal->form_input('handphone', $detail[0]->handphone, 'class="form-control input-sm" placeholder="Handphone"')?>
                </div>

                <div class="control-group">
                  <label>BBM</label>
                      <?php print $this->form_eksternal->form_input('bbm', $detail[0]->bbm, 'class="form-control input-sm" placeholder="BBM"')?>
                </div>

                <div class="control-group">
                  <label>Facebook</label>
                      <?php print $this->form_eksternal->form_input('facebook', $detail[0]->facebook, 'class="form-control input-sm" placeholder="Facebook"')?>
                </div>
              
              <div class="control-group">
                  <label>About Us</label>
                      <?php print $this->form_eksternal->form_textarea('about_us', $detail[0]->about_us, 'class="form-control input-sm" id="editor2"')?>
                </div>
              
              <div class="control-group">
                  <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor3"')?>
                </div>
              
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("portal/master-portal/company")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
            </form>
              
            </div>
      </div>
    </div>
</div>   <!-- /.row -->