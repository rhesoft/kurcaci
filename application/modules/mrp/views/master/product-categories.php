<thead>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Nicename</th>
        <th>Parent</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      print '
      <tr>
        <td>'.$value->sort.'</td>
        <td>'.$value->name.'</td>
        <td>'.$value->nicename.'</td>
        <td>'.$value->ayah.'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("mrp/master-mrp/add-new-product-categories/".$value->id_mrp_product_category).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>