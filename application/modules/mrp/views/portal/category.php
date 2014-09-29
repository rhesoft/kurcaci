<thead>
    <tr>
        <th>Name</th>
        <th>Category</th>
        <th>(Product)</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      if($value->jumlah > 0){
        $action = "Memiliki Product, tidak dapat dihapus";
      }
      else{
        $action = "<a href='".site_url("mrp/portal-mrp/delete-category/".$value->id_mrp_sub_product_category)."'>Delete</a>";
      }
      print '
      <tr>
        <td>'.$value->name.'</td>
        <td>'.$value->kategori.'</td>
        <td style="text-align: right">'.$value->jumlah.'</td>
        <td>'.$action.'</td>
      </tr>';
    }
  }
  ?>
</tbody>