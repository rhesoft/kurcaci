<thead>
    <tr>
        <th>Logo</th>
        <th>Title</th>
        <th>Ibu Kota</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      $status = array(
          1 => "<span class='label label-default'>Draft</span>",
          2 => "<span class='label label-success'>Active</span>",
      );
      if($value->logo)
        $gambar = base_url()."files/portal/propinsi/{$value->logo}";
      else
        $gambar = base_url()."files/no-pic.png";
      print '
      <tr>
        <td><img src="'.$gambar.'" width="50"></td>
        <td>'.$value->title.'</td>
        <td>'.$value->ibu_kota.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("portal/master-portal/add-new-lokasi/".$value->id_portal_lokasi).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>