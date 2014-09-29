
<?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
        array("id_detail" => $detail[0]->id_mrp_purchase_order))?>
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
      <h4>Supplier</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_dropdown('id_mrp_supplier', $supplier, array($detail[0]->id_mrp_supplier), 'class="form-control"')?>
      </div>
    </div>

    <div class="control-group">
      <h4>Status</h4>
      <div class="input-group">
          <?php print $this->form_eksternal->form_dropdown('status', array(
              1 => "Draft",
              2 => "Request",
              3 => "Accepted",
              4 => "Rejected",
              5 => "Deal",
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
                            array("Products", lang("note"), lang("qty"), lang("price"), lang("discount"), lang("total")), 
                            $isi, 
                            site_url("mrp/add-items-for-purchase-order"), 
                            "items", 
                            "id_items", 
                            "nomor_flag", 
                            $tr, 
                            "width='100%'", true, true, true, $tambah = array());
          print $this->form_eksternal->form_input('param', count($isi), 'id="nomor_flag" style="display: none;"');
          ?>
      </div>
    </div>

  </div>
  <div class="box-footer">
      <button class="btn btn-primary" type="submit">Save changes</button>
      <a href="<?php print site_url("mrp/purchase-order")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</form>
            