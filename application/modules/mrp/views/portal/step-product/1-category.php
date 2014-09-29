<div class="col-md-6">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open("", 'role="form"')?>
    <div class="box-body">
      <div class="form-group">
          <label>Category</label>
          <select id="category_multi" size="25" class="form-control" name="id_mrp_product_category">
            <?php
            foreach($kategori AS $kat){
              print "<option value='{$kat->id_mrp_product_category}'>{$kat->name}</option>";
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
        <label>Sub Category</label>
        <select id="sub_kategory" size="25" class="form-control" name="id_mrp_sub_product_category">
          
        </select>
      </div>
      
      <div class="box-footer">
          <button style="display: none" id="btn_next" class="btn btn-primary" type="submit">Next</button>
          <a style="display: none" id="btn_create_sub" href="#myModal" data-toggle="modal" class="btn btn-importent btn-modal"> + Create Category</a>
          <a href="<?php print site_url("mrp/portal-mrp/products")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal hide fade" id="myModal" aria-hidden="true" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Create Sub Caregoru</h3>
  </div>
  <div class="modal-body">
    <?php print $this->form_eksternal->form_input("mrp_sub_product_category", "", 'id="mrp_sub_product_category" class="form-control input-sm" placeholder="Company"');?>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a href="javascript:void(0);" class="btn btn-primary" data-dismiss="modal" id="simpan_new_categori">Save changes</a>
  </div>
</div>