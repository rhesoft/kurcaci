<div class="col-md-6">
  <div class="box box-primary">
  <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
          array("id_detail" => $detail[0]->id_mrp_products))?>
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
        <label>Category</label>
        <select name="id_mrp_sub_product_category" class="form-control input-sm">
          <?php foreach($kategori AS $kt){
            if($kt->id_mrp_sub_product_category == $detail[0]->id_mrp_sub_product_category){
              $selec = "selected";
            }
            else{
              $selec = "";
            }
            print "<option {$selec} value='{$kt->id_mrp_sub_product_category}'>{$kt->name}</option>";
          }
          ?>
        </select>
      </div>
      
      <div class="control-group">
        <label>Status</label>
        <?php print $this->form_eksternal->form_dropdown('status', array(1 => "Active", 2 => "Draft", 3 => "Sold Out"), array($detail[0]->status), 'class="form-control input-sm"')?>
      </div>

      <div class="control-group">
        <label>Price</label>
        <?php print $this->form_eksternal->form_input('price', $detail[0]->price, 'id="price" class="form-control input-sm" placeholder="Price"')?>
      </div>
      
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
        <label>Spesification</label>
        <?php print $this->form_eksternal->form_textarea('spesification', $detail[0]->spesification, 'class="form-control input-sm" id="editor2"')?>
      </div>

    </div>
  </div>    
</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-body">
      <div class="control-group">
        <label>Picture 2</label>
        <?php print $this->form_eksternal->form_upload('picture2', $detail[0]->picture2, 'class="form-control input-sm"');
        if($detail[0]->picture2)
          print "<br /><img src='".base_url()."files/mrp/products/{$detail[0]->picture2}' width='50' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
        ?>
      </div>

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