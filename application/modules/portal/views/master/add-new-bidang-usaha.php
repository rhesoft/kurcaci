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
                        array("id_detail" => $detail[0]->id_portal_bidang_usaha))?>
                  <div class="box-body">
                    
                    <div class="control-group">
                      <h4>Title</h4>
                          <?php
                          print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control" placeholder="Title"');?>
										</div>
                    
										<div class="control-group">
                      <h4>Parent</h4>
                          <?php print $this->form_eksternal->form_dropdown('parent', $parent, array($detail[0]->parent), 'class="form-control"')?>
										</div>
                    
                    <div class="control-group">
                      <h4>Sort</h4>
                          <?php
                          print $this->form_eksternal->form_input('sort', $detail[0]->sort, 'class="form-control" placeholder="Sort"');?>
										</div>
                    
                  </div>
                  <div class="box-footer">
                      <button class="btn btn-primary" type="submit">Save changes</button>
                      <a href="<?php print site_url("portal/master-portal/bidang-usaha")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
                  </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->