<div class="col-md-6">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open("", 'role="form"')?>
    <div class="box-body">
      <div class="form-group">
          <label>Category</label>
          <select id="category_multi" size="10" class="form-control" name="id_mrp_product_category">
            <?php
            foreach($kategori AS $kat){
              print "<option value='{$kat->id_frm_account_category}'>{$kat->title}</option>";
            }
            ?>
          </select>
      </div>
    </div>
  </div>    
</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-body">
      <div class="control-group" id="create_sub" style="display: none">
        <label style="width: 100%">Account</label>
        <br />
        <div id="hasil"></div>
<!--        <span class="btn btn-info btn-xs">Kas</span><a class="btn btn-warning btn-xs">x</a>
        <span class="btn btn-info btn-xs">Kas</span><a class="btn btn-warning btn-xs">x</a>
        <span class="btn btn-info btn-xs">Kas</span><a class="btn btn-warning btn-xs">x</a>-->
        <hr />
        <?php 
        print $this->form_eksternal->form_input("frm_account", "", 'style="width: 90%" id="frm_account" class="form-control input-sm" placeholder="Account"')."<a href='javascript:void(0);' onclick='add_new_account()' class='btn btn-info btn-sm'>Add</a>";
        ?>
      </div>
      
      <div class="box-footer">
          <!--<button class="btn btn-primary" type="submit">Save changes</button>-->
          <a href="<?php print site_url("frm/portal-frm/account")?>" class="btn btn-warning"><?php print lang("back")?></a>
      </div>
      </form>
    </div>
  </div>
</div>