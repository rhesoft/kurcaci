<div class="col-md-12">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open("", 'role="form"', 
          array("id_mrp_sub_product_category" => $id_mrp_sub_product_category))?>
    <div class="box-body">
      <div class="control-group">
        <label>Name</label>
        <?php print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control input-sm" placeholder="Name"');?>
      </div>
      
      <div class="control-group">
        <label>SN</label>
        <?php print $this->form_eksternal->form_input('sn', $detail[0]->sn, 'class="form-control input-sm" placeholder="SN"');?>
      </div>

      <div class="control-group">
        <label>Status</label>
        <?php print $this->form_eksternal->form_dropdown('status', array(1 => "Active", 2 => "Draft", 3 => "Sold Out"), array($detail[0]->status), 'class="form-control input-sm"')?>
      </div>

      <div class="control-group">
        <label>Price</label>
        <?php print $this->form_eksternal->form_input('price', $detail[0]->price, 'id="price" class="form-control input-sm" placeholder="Price"')?>
      </div>
      
      <div class="box-footer">
          <button class="btn btn-primary" type="submit">Next</button>
          <a href="<?php print site_url("mrp/master-mrp/products")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
      </form>
      
    </div>
  </div>    
</div>
