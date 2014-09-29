<thead>
  <tr>
    <th>Picture</th>
    <th>Title</th>
    <th>PIC</th>
    <th>Telphone</th>
    <th>Email</th>
    <th>Option</th>
  </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      if(!$value->picture){
        $picture = base_url()."/files/no-pic.png";
      }
      else{
        $picture = base_url()."/files/mrp/supplier/50/".$value->picture;
      }
      print "
  <tr>
    <td><img src='".$picture."' width='50' /></td>
    <td>{$value->title}</td>
    <td>{$value->pic}</td>
    <td>{$value->telp}</td>
    <td>{$value->email}</td>
    <td>
      <div class='btn-group'>
        <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
        <ul class='dropdown-menu'>
          <li><a href='".site_url("mrp/master-mrp/add-new-supplier/".$value->id_mrp_supplier)."'>Edit</a></li>
          <li><a href='".site_url("mrp/hutang-supplier/".$value->id_mrp_supplier)."'>".lang('mrp_hutang_supplier')."</a></li>
          <li><a href='{$link_delete}'>Delete</a></li>
        </ul>
      </div>
    </td>
  </tr>";
    }
  }
  ?>
</tbody>