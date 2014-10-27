<thead>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Pos</th>
        <th>Labarugi</th>
        <th>Modal</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    $pos = array(1 => "<span class='label label-success'>Debit</span>", 2 => "<span class='label label-warning'>Kredit</span>");
    $s_labarugi = array("" => "<span class='label label-warning'>Non-Active</span>", 1 => "<span class='label label-warning'>Non-Active</span>", 2 => "<span class='label label-success'>Active</span>");
    $s_modal = array("" => "<span class='label label-warning'>Non-Active</span>", 1 => "<span class='label label-warning'>Non-Active</span>", 2 => "<span class='label label-success'>Active</span>");
    foreach ($data as $key => $value) {
      print '
      <tr>
        <td>'.$value->nomor.'</td>
        <td>'.$value->title.'</td>
        <td>'.$pos[$value->pos].'</td>
        <td>'.$s_labarugi[$value->labarugi].'</td>
        <td>'.$s_modal[$value->modal].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("frm/master-frm/add-account/".$value->id_frm_account).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>