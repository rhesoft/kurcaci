<thead>
  <tr>
    <th>Picture</th>
    <th>Title</th>
    <th>ID</th>
    <th>Option</th>
  </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      if($value->picture)
        $gambar = base_url()."files/mrp/brand/{$value->picture}";
      else
        $gambar = base_url()."files/no-pic.png";
      print "
  <tr>
    <td><img src='{$gambar}' width='100'></td>
    <td>{$value->name}</td>
    <td>{$value->id_mrp_inventory_brand}</td>
    <td>
      <div class='btn-group'>
        <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
        <ul class='dropdown-menu'>
          <li><a href='".site_url("mrp/master-mrp/add-new-brand/".$value->id_mrp_inventory_brand)."'>Edit</a></li>
        </ul>
      </div>
    </td>
  </tr>";
    }
  }
  ?>
</tbody>