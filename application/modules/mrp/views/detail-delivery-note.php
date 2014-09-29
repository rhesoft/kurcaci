
<?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
        array("id_detail" => $detail[0]->id_mrp_delivery_note))?>
  <div class="box-body">

    <div class="control-group">
      <h4>Title</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control" placeholder="Title"');?>
      </div>
    </div>

    <div class="control-group">
      <h4>No Transaksi</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input('no_transaksi', $detail[0]->no_transaksi, 'class="form-control" placeholder="No Transaksi"');?>
      </div>
    </div>

    <div class="control-group">
      <h4>Tanggal</h4>
      <div class="input-group">
          <?php
          print $this->form_eksternal->form_input("tanggal", $detail[0]->tanggal, 'id="tanggal" class="form-control" placeholder="Tanggal"');?>
      </div>
    </div>

    <div class="control-group">
      <h4>Purchase Order</h4>
      <div class="input-group">
          <a href="<?php print site_url("mrp/add-purchase-order/".$detail[0]->id_mrp_purchase_order)?>"><?php print $this->global_models->get_field("mrp_purchase_order", "no_transaksi", array("id_mrp_purchase_order" => $detail[0]->id_mrp_purchase_order))?></a>
      </div>
    </div>

    <div class="control-group">
      <h4>Status</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_dropdown('status', array(
              1 => "Draft",
              2 => "Accepted",
              3 => "Rejected",
          ), array($detail[0]->status), 'class="form-control"')?>
      </div>
    </div>

    <div class="control-group">
      <h4>Document</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_upload('document', $detail[0]->document, 'class="form-control"');
          if($detail[0]->document)
            print "<br /><a href='".base_url()."files/mrp/purchase-order/{$detail[0]->document}' >{$detail[0]->document}</a>";
          ?>
      </div>
    </div>

    <div class="control-group">
      <h4>Note</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control" id="editor1"')?>
      </div>
    </div>        
    <div class="control-group">
      <br />
      <div>
          <?php
          print $this->form_eksternal->form_addrow_tr(
                            array("Products", lang("note"), lang("qty")), 
                            $isi, 
                            site_url("mrp/add-items-for-purchase-order"), 
                            "items", 
                            "id_items", 
                            "nomor_flag", 
                            $tr, 
                            "width='100%'", false, false, false, $tambah = array());
          print $this->form_eksternal->form_input('param', count($isi), 'id="nomor_flag" style="display: none;"');
          ?>
      </div>
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("mrp/delivery-note")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>
            