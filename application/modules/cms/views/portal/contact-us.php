<div class="col-md-9 col-sm-8">
  <div class="row pad">
      <div class="col-sm-6">
          <label style="margin-right: 10px;">
              <input type="checkbox" id="check-all"/>
          </label>
          <!-- Action button -->
          <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                  Action <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                  <li><a onclick="read_contact_all()" href="javascript:void(0);">Mark as read</a></li>
                  <li><a onclick="unread_contact_all()" href="javascript:void(0);">Mark as unread</a></li>
                  <li class="divider"></li>
                  <li><a onclick="delete_contact_all()" href="javascript:void(0);">Delete</a></li>
              </ul>
          </div>

      </div>
      <div class="col-sm-6 search-form">
          <div class="input-group">
              <input type="text" class="form-control input-sm" placeholder="Search" id="kata_cari_contact">
              <div class="input-group-btn">
                <a href="javascript:void(0);" onclick="cari_contact()" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a></button>
              </div>
          </div>
      </div>
  </div><!-- /.row -->

  <div class="table-responsive" id="set_daftar">
      <!-- THE MESSAGES -->
      
  </div><!-- /.table-responsive -->
  <div class="box-footer clearfix">
    <div class="pagination pagination-sm no-margin pull-right" id="set_daftar_page">
      
    </div>
  </div>
</div><!-- /.col (RIGHT) -->

<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
          </div>
          <form action="#" method="post">
              <div class="modal-body">
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon">TO:</span>
                          <?php
                          print $this->form_eksternal->form_input("cms_pesan_to", "", 'id="cms_pesan_to" class="form-control input-sm" placeholder="Company"')."<br />";
                          ?>
                          <select id="id_portal_company" size="5" class="form-control" name="id_portal_company">
                            <?php
                            foreach($portal_company AS $pc){
                              print "<option value='{$pc->id_portal_company}'>{$pc->title}</option>";
                            }
                            ?>
                          </select>
                          <!--<input name="email_to" type="email" class="form-control" placeholder="Email TO">-->
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">S:</span>
                      <?php print $this->form_eksternal->form_input('subject', "", 'class="form-control input-sm" id="subject"')?>
                    </div>
                  </div>
                  <div class="form-group">
                      <?php print $this->form_eksternal->form_textarea('message', "", 'class="form-control input-sm" id="editor2"')?>
                  </div>
              </div>
              <div class="modal-footer clearfix">

                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                  <button id="kirim_pesan" type="button" class="btn btn-primary pull-left" data-dismiss="modal"><i class="fa fa-envelope"></i> Send Message</button>
              </div>
          </form>
      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="compose-modal-users" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"><i class="fa fa-envelope-o"></i> <span id="title_compose">Compose New Message</span></h4>
          </div>
          <form action="#" method="post">
              <div class="modal-body">
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon">TO:</span>
                          <?php
                          print $this->form_eksternal->form_input("name_users", "", 'id="name_users" class="form-control input-sm" placeholder="User"')."<br />";
                          ?>
                          <!--<input name="email_to" type="email" class="form-control" placeholder="Email TO">-->
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">S:</span>
                      <?php print $this->form_eksternal->form_input('subject_users', "", 'class="form-control input-sm" id="subject_users"')?>
                    </div>
                  </div>
                  <div class="form-group">
                      <?php print $this->form_eksternal->form_textarea('message_users', "", 'class="form-control input-sm" id="editor3"')?>
                  </div>
              </div>
              <div class="modal-footer clearfix">

                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                  <button id="kirim_pesan_users" type="button" class="btn btn-primary pull-left" data-dismiss="modal"><i class="fa fa-envelope"></i> Send Message</button>
              </div>
          </form>
      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="labora" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="pesan_title"><i class="fa fa-envelope-o"></i> <span id="pesan_title"></span></h4>
          </div>
          <form action="#" method="post">
              <div class="modal-body">
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon">FROM:</span>
                          <span class="form-control" id="pesan_sender"></span>
                          <!--<input name="email_to" type="email" class="form-control" placeholder="Email TO">-->
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon"> TO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                          <span class="form-control" id="pesan_sender_to"></span>
                          <!--<input name="email_to" type="email" class="form-control" placeholder="Email TO">-->
                      </div>
                  </div>
                  <div class="form-group">
                    <p id="pesan_note"></p>
                  </div>
              </div>
              <div class="modal-footer clearfix">

                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>

                  <button id="balas_pesan" type="button" class="btn btn-primary pull-left" data-dismiss="modal"><i class="fa fa-envelope"></i> Reply Message</button>
              </div>
          </form>
      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<?php
print $this->form_eksternal->form_input("total_page", $total, "id='total_page' style='display: none'");
?>