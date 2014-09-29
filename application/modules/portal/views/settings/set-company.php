<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"')?>
              <div class="box-body">
                <div class="control-group">
                  <label>Company</label>
                  <?php 
                  print $this->form_eksternal->form_input("portal_company", $this->global_models->get_field("portal_company", "title", array("id_portal_company" => $this->session->userdata("id_portal_company"))), 'id="portal_company" class="form-control input-sm" placeholder="Company"');
                  print $this->form_eksternal->form_input("id_portal_company", $this->session->userdata("id_portal_company"), 'id="id_portal_company" style="display: none"');
                  ?>
                </div>
                <div class="control-group">
                  <label>Position</label>
                    <?php print $this->form_eksternal->form_dropdown('id_portal_company_position', $position, $this->session->userdata("id_portal_company_position"), 'class="form-control input-sm"')?>
                </div>
                <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
              </div>
            </form>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->