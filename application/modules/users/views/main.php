<thead>
    <tr>
        <th>Name</th>
        <th>Privilege</th>
        <th>Email</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
      if(is_array($data)){
        foreach ($data as $key => $value) {
          if($value->id_status_user == 1)
            $status = "<span class='label label-success'>Active</span>";
          else
            $status = "<span class='label label-important'>Not Active</span>";

          $link_edit = site_url("users/add-new/".$value->id_users);
          $link_delete = site_url("users/delete/".$value->id_users);
          $link_status = site_url("users/status/".$value->id_users."/$value->id_status_user");
          $link_pass = site_url("users/generate-password/".$value->id_users);
          $link_email_pass = site_url("users/email-pass/".$value->id_users);
          print "
      <tr>
        <td>{$value->name}</td>                     
        <td>{$value->privilege}</td>
        <td>{$value->email}</td>
        <td>{$status}</td>
        <td>
          <div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='{$link_edit}'>Edit</a></li>
              <li><a href='{$link_pass}'>Generate Password</a></li>
              <li><a href='{$link_email_pass}'>Email Password</a></li>
              <li><a href='".site_url("users/biodata/".$value->id_users)."'>Biodata</a></li>
            </ul>
          </div>
        </td>     
      </tr>";
        }
      }
      ?>
</tbody>