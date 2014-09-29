<thead>
    <tr>
        <th>Title</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      print '
      <tr>
        <td>'.$value->title.'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("portal/master-portal/add-new-company-position/".$value->id_portal_company_position).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>