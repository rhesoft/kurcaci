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
                  <label>Privilege New Users</label>
                    <?php 
                    $global_settings_privilege_new_users = $this->nbscache->get_explode("global-settings", "global_settings_privilege_new_users");
                    print $this->form_eksternal->form_dropdown('global_settings_privilege_new_users', $privilege, $global_settings_privilege_new_users[1], 'class="form-control input-sm"');
                    ?>
                </div>
                
                <div class="control-group">
                  <label>Company Position New Users</label>
                    <?php 
                    $global_settings_company_position = $this->nbscache->get_explode("global-settings", "global_settings_company_position");
                    print $this->form_eksternal->form_dropdown('global_settings_company_position', $position, $global_settings_company_position[1], 'class="form-control input-sm"');
                    ?>
                </div>
                
                <div class="box-footer">
                  
                <button class="btn btn-primary" type="submit">Save changes</button>
                
              </div>
            </form>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->