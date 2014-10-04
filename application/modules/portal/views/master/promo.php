<thead>
    <tr>
        <th>Gambar</th>
        <th>Title</th>
        <th>Company</th>
        <th>Start Date</th>
        <th>End Date</th>
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
          2 => "<span class='label label-denger'>Cancel</span>",
          3 => "<span class='label label-success'>Active</span>",
          4 => "<span class='label label-warning'>Prioritas</span>",
          5 => "<span class='label label-primary'>Pengumuman</span>",
          6 => "<span class='label label-info'>Default</span>",
      );
      
      if($value->gambar)
        $gambar = base_url()."files/portal/promo/{$value->gambar}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.'</td>
        <td>'.$value->company.'</td>
        <td>'.$value->start_date.'</td>
        <td>'.$value->end_date.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("portal/master-portal/add-new-promo/".$value->id_portal_promo).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>