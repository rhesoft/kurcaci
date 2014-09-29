<div class="col-md-12">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open("", 'role="form"', 
          array("id_mrp_products" => $products[0]->id_mrp_products))?>
    <div class="box-body">
      
      <div class="control-group">
        <label>Spesification</label>
        <?php print $this->form_eksternal->form_textarea('spesification', $detail[0]->spesification, 'class="form-control input-sm" id="editor2"')?>
      </div>
      
      <div class="control-group">
        <label>Description</label>
        <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor1"')?>
      </div>
      
      <div class="control-group">
        <label>Tags</label>
        <?php print $this->form_eksternal->form_input('tags', $detail[0]->tags, 'class="form-control input-sm"')?>
      </div>

      <div class="box-footer">
          <button class="btn btn-primary" type="submit">Save changes</button>
          <a href="<?php print site_url("mrp/master-mrp/products")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
      </form>

    </div>
  </div>    
</div>