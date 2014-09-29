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
                    array("id_detail" => $detail[0]->id_portal_lokasi))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>
                
                <div class="control-group">
                  <label>Ibu Kota</label>
                  <?php print $this->form_eksternal->form_input('ibu_kota', $detail[0]->ibu_kota, 'class="form-control input-sm" placeholder="Ibu Kota"');?>
                </div>
                
                <div class="control-group">
                  <label>Logo</label>
                  <?php print $this->form_eksternal->form_upload('logo', $detail[0]->logo, "class='form-control input-sm'");
                  if($detail[0]->logo)
                    print "<br /><img src='".base_url()."files/portal/propinsi/{$detail[0]->logo}' width='50' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Draft", '2' => "Active"), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>
                <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("portal/master-portal/lokasi")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
            </form>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->