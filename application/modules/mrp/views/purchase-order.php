<thead>
    <tr>
        <th>Tanggal</th>
        <th>Title</th>
        <th>No Transaksi</th>
        <th>Price</th>
        <th>Supplier</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  $status = array(
      1 => "<span class='label label-warning'>Draft</span>",
      2 => "<span class='label label-warning'>Request</span>",
      3 => "<span class='label label-success'>Accepted</span>",
      4 => "<span class='label label-denger'>Rejected</span>",
      5 => "<span class='label label-primary'>Deal</span>",
  );
  if(is_array($data)){
    foreach ($data as $key => $value) {
      print '
      <tr>
        <td>'.$value->tanggal.'</td>
        <td>'.$value->title.'</td>
        <td>'.$value->no_transaksi.'</td>
        <td style="text-align: right">Rp. '.number_format($value->price, 0, ",", ".").'</td>
        <td>'.$value->supplier.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("mrp/add-purchase-order/".$value->id_mrp_purchase_order).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>