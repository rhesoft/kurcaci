<div class="col-md-6">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
          array("id_mrp_products" => $products[0]->id_mrp_products))?>
    <div class="box-body">
      <div class="control-group">
        <label>Picture</label>
        <?php print $this->form_eksternal->form_upload('picture', $detail[0]->picture, 'class="form-control input-sm"');
        if($detail[0]->picture)
          print "<br /><img src='".base_url()."files/mrp/products/{$detail[0]->picture}' width='50' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
        ?>
      </div>
      <div class="control-group">
        <label>Picture 2</label>
        <?php print $this->form_eksternal->form_upload('picture2', $detail[0]->picture2, 'class="form-control input-sm"');
        if($detail[0]->picture2)
          print "<br /><img src='".base_url()."files/mrp/products/{$detail[0]->picture2}' width='50' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
        ?>
      </div>
      
      <div class="box-footer">
          <button class="btn btn-primary" type="submit">Save changes</button>
          <a href="<?php print site_url("mrp/master-mrp/products")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
      
    </div>
  </div>    
</div>
<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-body">
      
      <div class="control-group">
        <label>Picture 3</label>
        <?php print $this->form_eksternal->form_upload('picture3', $detail[0]->picture3, 'class="form-control input-sm"');
        if($detail[0]->picture3)
          print "<br /><img src='".base_url()."files/mrp/products/{$detail[0]->picture3}' width='50' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
        ?>
      </div>

      <div class="control-group">
        <label>Picture 4</label>
        <?php print $this->form_eksternal->form_upload('picture4', $detail[0]->picture4, 'class="form-control input-sm"');
        if($detail[0]->picture4)
          print "<br /><img src='".base_url()."files/mrp/products/{$detail[0]->picture4}' width='50' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
        ?>
      </div>
      
      </form>
      
    </div>
  </div>    
</div>