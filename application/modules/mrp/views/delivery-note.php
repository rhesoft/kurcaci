<thead>
    <tr>
        <th>Tanggal</th>
        <th>Title</th>
        <th>No PO</th>
        <th>No Transaksi</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  $status = array(
      1 => "<span class='label label-warning'>Draft</span>",
      2 => "<span class='label label-success'>Received</span>",
      3 => "<span class='label label-denger'>Rejected</span>",
  );
  if(is_array($data)){
    foreach ($data as $key => $value) {
      print '
      <tr>
        <td>'.$value->tanggal.'</td>
        <td>'.$value->title.'</td>
        <td>'.$this->global_models->get_field("mrp_purchase_order", "no_transaksi", array("id_mrp_purchase_order" => $value->id_mrp_purchase_order)).'</td>
        <td>'.$value->no_transaksi.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("mrp/detail-delivery-note/".$value->id_mrp_delivery_note).'">Detail</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>