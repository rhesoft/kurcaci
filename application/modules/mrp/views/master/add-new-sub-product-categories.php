
<?php print $this->form_eksternal->form_open("", 'role="form"', 
        array("id_detail" => $detail[0]->id_mrp_sub_product_category))?>
  <div class="box-body">

    <div class="control-group">
      <h4>Name</h4>
          <?php
          print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control" placeholder="Name"');?>
    </div>

    <div class="control-group">
      <h4>Parent</h4>
          <?php print $this->form_eksternal->form_dropdown('id_mrp_product_category', $parent, array($detail[0]->id_mrp_product_category), 'class="form-control"')?>
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("mrp/master-mrp/sub-product-category")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>
            