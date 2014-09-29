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
        <?php 
        print $this->form_eksternal->form_input("mrp_sub_product_category", "", 'id="mrp_sub_product_category" class="form-control input-sm" placeholder="Company"');
        ?>
      </div>
      
      <div class="box-footer">
          <button class="btn btn-primary" type="submit">Save changes</button>
          <a href="<?php print site_url("mrp/master-mrp/products")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
      </form>
    </div>
  </div>
</div>