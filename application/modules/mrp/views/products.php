<thead>
    <tr>
        <th>Picture</th>
        <th>Name</th>
        <th>Harga Jual</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Qty</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      if($value->picture)
        $gambar = base_url()."files/mrp/products/{$value->picture}";
      else
        $gambar = base_url()."files/no-pic.png";
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->name.'</td>
        <td style="text-align: right">Rp. '.number_format($value->price, 0, ",", ".").'</td>
        <td>'.$value->kategori.'</td>
        <td>'.$value->brand.'</td>
        <td style="text-align: right">'.$value->jumlah.'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("mrp/master-mrp/add-new-products/".$value->id_mrp_products).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>