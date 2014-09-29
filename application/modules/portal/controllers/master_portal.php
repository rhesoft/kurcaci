<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_portal extends MX_Controller {
  
  function __construct() {
    $this->load->library('manimage');
    $this->menu = $this->cek();
  }
  
  function company(){
    $list = $this->global_models->get_query("SELECT A.*, B.title AS bidang_usaha, C.title AS lokasi"
      . " FROM portal_company AS A"
      . " LEFT JOIN portal_bidang_usaha AS B ON A.id_portal_bidang_usaha = B.id_portal_bidang_usaha"
      . " LEFT JOIN portal_lokasi AS C ON A.id_portal_lokasi = C.id_portal_lokasi");
    
    $menutable = '
      <li><a href="'.site_url("portal/master-portal/add-new-company").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/company', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "portal/master-portal/company",
            'data'        => $list,
            'title'       => lang("portal_company"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/company');
  }
  
  function promo(){
    $list = $this->global_models->get("portal_promo");
    
    $menutable = '
      <li><a href="'.site_url("portal/master-portal/add-new-promo").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/promo', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "portal/master-portal/promo",
            'data'        => $list,
            'title'       => lang("portal_promo"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/promo');
  }
  
  function lokasi(){
    $list = $this->global_models->get("portal_lokasi");
    
    $menutable = '
      <li><a href="'.site_url("portal/master-portal/add-new-lokasi").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/lokasi', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "portal/master-portal/lokasi",
            'data'        => $list,
            'title'       => lang("portal_lokasi"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/lokasi');
  }
  
  function company_position(){
    $list = $this->global_models->get("portal_company_position");
    
    $menutable = '
      <li><a href="'.site_url("portal/master-portal/add-new-company-position").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/company-position', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "portal/master-portal/company-position",
            'data'        => $list,
            'title'       => lang("portal_company_position"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/company-position');
  }
  
  function bidang_usaha(){
    $list = $this->global_models->get_query("SELECT A.*, B.title AS parent"
      . " FROM portal_bidang_usaha AS A"
      . " LEFT JOIN portal_bidang_usaha AS B ON A.parent = B.id_portal_bidang_usaha"
      . " GROUP BY A.id_portal_bidang_usaha");
    
    $menutable = '
      <li><a href="'.site_url("portal/master-portal/add-new-bidang-usaha").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/bidang-usaha', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "portal/master-portal/bidang-usaha",
            'data'        => $list,
            'title'       => lang("portal_bidang_usaha"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/bidang-usaha');
  }
  
  public function add_new_company($id_portal_company = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("portal_company", array("id_portal_company" => $id_portal_company));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
            
              $( '#portal_bidang_usaha' ).autocomplete({
                source: '".site_url("portal/master-portal/auto-bidang-usaha")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_portal_bidang_usaha').val(ui.item.id);
                }
              });
            
              $( '#portal_lokasi' ).autocomplete({
                source: '".site_url("portal/master-portal/auto-lokasi")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_portal_lokasi').val(ui.item.id);
                }
              });
            
              CKEDITOR.replace('editor1');
              CKEDITOR.replace('editor2');
              CKEDITOR.replace('editor3');
            });
        </script>
        ";
      
      $this->template->build("master/add-new-company", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/master-portal/company',
              'title'       => "Create Company",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Company"  => "portal/master-portal/company"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-company");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/portal/company/logo/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '700';
      $config['max_height']  = '700';

      $this->load->library('upload', $config);
      
      if($_FILES['logo']['name']){
        if (  $this->upload->do_upload('logo')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("portal/master-portal/add-new-company/".$id_portal_company)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_company", "id_portal_company"),
            "email"           => $pst['email'],
            "handphone"       => $pst['handphone'],
            "telphone"        => $pst['telphone'],
            "bbm"             => $pst['bbm'],
            "address"         => $pst['address'],
            "about_us"        => $pst['about_us'],
            "id_portal_bidang_usaha" => $pst['id_portal_bidang_usaha'],
            "id_portal_lokasi" => $pst['id_portal_lokasi'],
            "facebook"        => $pst['facebook'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['logo'] = $data['upload_data']['file_name'];
        }
        $id_portal_company = $this->global_models->update("portal_company", array("id_portal_company" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_company", "id_portal_company"),
            "email"           => $pst['email'],
            "handphone"       => $pst['handphone'],
            "telphone"        => $pst['telphone'],
            "bbm"             => $pst['bbm'],
            "address"         => $pst['address'],
            "about_us"        => $pst['about_us'],
            "id_portal_bidang_usaha" => $pst['id_portal_bidang_usaha'],
            "id_portal_lokasi" => $pst['id_portal_lokasi'],
            "facebook"        => $pst['facebook'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['logo'] = $data['upload_data']['file_name'];
        }
        $id_portal_company = $this->global_models->insert("portal_company", $kirim);
      }
      if($id_portal_company){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/master-portal/company");
    }
  }
  
  public function add_new_promo($id_portal_promo = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("portal_promo", array("id_portal_promo" => $id_portal_promo));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              $( '#portal_company' ).autocomplete({
                source: '".site_url("portal/master-portal/auto-company")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_portal_company').val(ui.item.id);
                }
              });
              
              $( '#start_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
            });
        </script>
        ";
      
      $this->template->build("master/add-new-promo", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/master-portal/promo',
              'title'       => "Create Promo",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Company"  => "portal/master-portal/promo"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-promo");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/portal/promo/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '600';
      $config['max_height']  = '600';

      $this->load->library('upload', $config);
      
      if($_FILES['gambar']['name']){
        if (  $this->upload->do_upload('gambar')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("portal/master-portal/add-new-promo/".$id_portal_promo)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_promo", "id_portal_promo"),
            "id_portal_company" => $pst['id_portal_company'],
            "start_date"      => $pst['start_date'],
            "end_date"        => $pst['end_date'],
            "link"            => $pst['link'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['gambar'] = $data['upload_data']['file_name'];
        }
        $id_portal_promo = $this->global_models->update("portal_promo", array("id_portal_promo" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_promo", "id_portal_promo"),
            "id_portal_company" => $pst['id_portal_company'],
            "start_date"      => $pst['start_date'],
            "end_date"        => $pst['end_date'],
            "link"            => $pst['link'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['gambar'] = $data['upload_data']['file_name'];
        }
        $id_portal_promo = $this->global_models->insert("portal_promo", $kirim);
      }
      if($id_portal_promo){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/master-portal/promo");
    }
  }
  
  public function add_new_lokasi($id_portal_lokasi = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("portal_lokasi", array("id_portal_lokasi" => $id_portal_lokasi));
      
      $this->template->build("master/add-new-lokasi", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/master-portal/lokasi',
              'title'       => "Create Lokasi",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Company"  => "portal/master-portal/lokasi"
                ),
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-lokasi");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/portal/propinsi/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_width']  = '700';
      $config['max_height']  = '700';

      $this->load->library('upload', $config);
      
      if($_FILES['logo']['name']){
        if (  $this->upload->do_upload('logo')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("portal/master-portal/add-new-lokasi/".$id_portal_company)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_lokasi", "id_portal_lokasi"),
            "status"          => $pst['status'],
            "ibu_kota"        => $pst['ibu_kota'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['logo'] = $data['upload_data']['file_name'];
        }
        $id_portal_lokasi = $this->global_models->update("portal_lokasi", array("id_portal_lokasi" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_lokasi", "id_portal_lokasi"),
            "status"          => $pst['status'],
            "ibu_kota"        => $pst['ibu_kota'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['logo'] = $data['upload_data']['file_name'];
        }
        $id_portal_lokasi = $this->global_models->insert("portal_lokasi", $kirim);
      }
      if($id_portal_lokasi){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/master-portal/lokasi");
    }
  }
  
  public function add_new_company_position($id_portal_company_position = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("portal_company_position", array("id_portal_company_position" => $id_portal_company_position));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor1');
            });
        </script>
        ";
      
      $this->template->build("master/add-new-company-position", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/master-portal/company-position',
              'title'       => "Create Company Position",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Company Position"  => "portal/master-portal/company-position"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-company-position");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_company_position", "id_portal_company_position"),
            "note"            => $pst['note'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_portal_company_position = $this->global_models->update("portal_company_position", array("id_portal_company_position" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_company_position", "id_portal_company_position"),
            "note"            => $pst['note'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_portal_company_position = $this->global_models->insert("portal_company_position", $kirim);
      }
      if($id_portal_company_position){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/master-portal/company-position");
    }
  }
  
  public function add_new_bidang_usaha($id_portal_bidang_usaha = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("portal_bidang_usaha", array("id_portal_bidang_usaha" => $id_portal_bidang_usaha));
      $parent = $this->global_models->get_dropdown("portal_bidang_usaha", "id_portal_bidang_usaha", "title", true, array("parent" => 0));
      $this->template->build("master/add-new-bidang-usaha", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/master-portal/bidang-usaha',
              'title'       => "Create Bidang Usaha",
              'detail'      => $detail,
              'parent'      => $parent,
              'breadcrumb'  => array(
                    "Bidang Usaha"  => "portal/master-portal/bidang-usaha"
                ),
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-bidang-usaha");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "title"             => $pst['title'],
            "parent"            => $pst['parent'],
            "sort"              => $pst['sort'],
            "nicename"          => $this->global_models->nicename($pst['title'], "portal_bidang_usaha", "id_portal_bidang_usaha"),
            "update_by_users"   => $this->session->userdata("id"),
        );
        $id_portal_bidang_usaha = $this->global_models->update("portal_bidang_usaha", array("id_portal_bidang_usaha" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"             => $pst['title'],
            "parent"            => $pst['parent'],
            "sort"              => $pst['sort'],
            "nicename"          => $this->global_models->nicename($pst['title'], "portal_bidang_usaha", "id_portal_bidang_usaha"),
            "create_by_users"   => $this->session->userdata("id"),
            "create_date"       => date("Y-m-d H:i:s")
        );
        $id_portal_bidang_usaha = $this->global_models->insert("portal_bidang_usaha", $kirim);
      }
      if($id_portal_bidang_usaha){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/master-portal/bidang-usaha");
    }
  }
  
  function auto_bidang_usaha(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM portal_bidang_usaha
      WHERE LOWER(title) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    foreach($items as $tms){
      $result[] = array(
          "id"    => $tms->id_portal_bidang_usaha,
          "label" => $tms->title,
          "value" => $tms->title,
      );
    }
    echo json_encode($result);
    die;
  }
  
  function auto_lokasi(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM portal_lokasi
      WHERE LOWER(title) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    foreach($items as $tms){
      $result[] = array(
          "id"    => $tms->id_portal_lokasi,
          "label" => $tms->title,
          "value" => $tms->title,
      );
    }
    echo json_encode($result);
    die;
  }
  
  function users_company($id_portal_company){
    if($this->input->post()){
      $pst = $this->input->post();
      $this->global_models->delete("portal_company_users", array("id_portal_company" => $pst['id_portal_company']));
      foreach($pst['id_users'] AS $k => $id_users){
        $kirim[] = array(
          "id_portal_company"       => $pst['id_portal_company'],
          "id_users"                => $id_users,
          "id_portal_company_position" => $pst['id_portal_company_position'][$k],
          "create_by_users"         => $this->session->userdata("id"),
          "create_date"             => date("Y-m-d H:i:s")
        );
      }
      if($kirim){
        $this->global_models->insert_batch("portal_company_users", $kirim);
      }
      
      $this->session->set_flashdata('success', 'Data tersimpan');
      redirect("portal/master-portal/company");
    }
    else{
      $data = $this->global_models->get("portal_company_users", array("id_portal_company" => $id_portal_company));
      $t = 0;
      foreach($data AS $dt){
        $isi[$t] = array(
          $this->form_eksternal->form_autocomplate("users[]", "id_users[]", "users_".$t, "id_users_".$t, site_url("users/auto-users"), $this->global_models->get_field("m_users", "name", array("id_users" => $dt->id_users)), $dt->id_users),
          $this->form_eksternal->form_autocomplate("portal_company_position[]", "id_portal_company_position[]", "portal_company_position_".$t, 
            "id_portal_company_position_".$t, site_url("portal/master-portal/auto-company-position"), $this->global_models->get_field("portal_company_position", "title", array("id_portal_company_position" => $dt->id_portal_company_position)), $dt->id_portal_company_position),
        );
        $tr[$t] = "tr_".$t;
        $t++;
      }
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script>
          function add_row_tambahan(table,url,act,param){
            var no = parseInt($('#'+param).val());
            $('#'+param).val(no+1);
            $.post(url,{no:$('#'+param).val(),action:act},function(data){
                $(data).clone(true).insertBefore('#'+table+' #'+act);
            });
          }
          function del_row_lokal(tr){
            $('#'+tr).remove();
          }
        
        </script>
        ";
      $this->template->build("master/users-company", 
          array(
                'url'         => base_url()."themes/".DEFAULTTHEMES."/",
                'menu'        => 'portal/master-portal/company',
                'title'       => "Users Company",
                'detail'      => $detail,
                'breadcrumb'  => array(
                      "Company"  => "portal/company"
                  ),
                'foot'        => $foot,
                'css'         => $css,
                'id_portal_company' => $id_portal_company,
                'isi'         => $isi,
                'tr'          => $tr,
              ));
        $this->template
          ->set_layout('form')
          ->build("master/users-company");
    }
  }
  
  function add_row_users_company(){
    $key = $this->input->post('no');
    $isi = array(
      $this->form_eksternal->form_autocomplate("users[]", "id_users[]", "users_".$key, "id_users_".$key, site_url("users/auto-users"), ""),
      $this->form_eksternal->form_autocomplate("portal_company_position[]", "id_portal_company_position[]", "portal_company_position_".$key, 
        "id_portal_company_position_".$key, site_url("portal/master-portal/auto-company-position"), ""),
    );
    foreach($isi as $si){
      $sisip .= "<td>{$si}</td>";
    }
    print <<<EOD
    <tr id='tr_{$key}'>{$sisip}
      <td><a href='javascript:void(0)' class='remove-element' onclick='del_row_lokal("tr_{$key}")' title='Remove' >Remove</a></td>
    </tr>
EOD;
    die;
  }
  
  function auto_company_position(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM portal_company_position
      WHERE 
      LOWER(title) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_portal_company_position,
            "label" => $tms->title,
            "value" => $tms->title,
        );
      }
    }
    else{
      $result[] = array(
          "id"    => 0,
          "label" => "No Found",
          "value" => "No Found",
      );
    }
    echo json_encode($result);
    die;
  }
  
  function auto_company(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM portal_company
      WHERE 
      LOWER(title) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_portal_company,
            "label" => $tms->title,
            "value" => $tms->title,
        );
      }
    }
    else{
      $result[] = array(
          "id"    => 0,
          "label" => "No Found",
          "value" => "No Found",
      );
    }
    echo json_encode($result);
    die;
  }
  
}
?>