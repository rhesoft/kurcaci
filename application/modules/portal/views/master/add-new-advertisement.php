<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
                    array("id_detail" => $detail[0]->id_portal_advertisement))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Company</label>
                    <?php print $this->form_eksternal->form_input('portal_company', $this->global_models->get_field("portal_company", "title", array("id_portal_company" => $detail[0]->id_portal_company)), 'id="portal_company" class="form-control input-sm" placeholder="Company"');
                    print $this->form_eksternal->form_input('id_portal_company', $detail[0]->id_portal_company, 'id="id_portal_company" style="display:none"');
                    ?>
                </div>
                
                <div class="control-group">
                  <label>Start Date</label>
                    <?php print $this->form_eksternal->form_input("start_date", $detail[0]->start_date, 'id="start_date" class="form-control" placeholder="Start Date"');?>
                </div>

                <div class="control-group">
                  <label>End Date</label>
                    <?php print $this->form_eksternal->form_input("end_date", $detail[0]->end_date, 'id="end_date" class="form-control" placeholder="End Date"');?>
                </div>

                <div class="control-group">
                  <label>Link</label>
                    <?php print $this->form_eksternal->form_input("link", $detail[0]->link, 'class="form-control" placeholder="Link"');?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Draft", '2' => "Default", '3' => "Aktif"), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>

                <div class="control-group">
                  <label>Gambar</label>
                  <?php print $this->form_eksternal->form_upload('gambar', $detail[0]->gambar, "class='form-control input-sm'");
                  if($detail[0]->gambar)
                    print "<br /><img src='".base_url()."files/portal/promo/{$detail[0]->gambar}' width='50' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("portal/master-portal/company")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->