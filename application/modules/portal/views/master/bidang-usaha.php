<thead>
    <tr>
        <th>Sort</th>
        <th>Title</th>
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
        <td>'.$value->title.'</td>
        <td>'.$value->parent.'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("portal/master-portal/add-new-bidang-usaha/".$value->id_portal_bidang_usaha).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>