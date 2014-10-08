<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_portal extends MX_Controller {
  
  function __construct() {
    $this->load->library('manimage');
    $this->menu = $this->cek();
//    $this->cek_session();
  }
  
  private function cek_session(){
    if(!$this->session->userdata("id_portal_company")){
      redirect("portal/settings-portal/set-company");
    }
  }
  
  
  private function form_promo($detail){
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
    $this->template->build("client/add-new-promo", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'portal/client-portal/promo',
            'title'       => "Create Promo",
            'detail'      => $detail,
            'breadcrumb'  => array(
                  "Promo"  => "portal/client-portal/promo"
              ),
              'css'       => $css,
              'foot'       => $foot,
          ));
    $this->template
      ->set_layout('form')
      ->build("client/add-new-promo");
  }

  public function add_promo($id_portal_promo = 0){
    $detail = $this->global_models->get("portal_promo", array("id_portal_promo" => $id_portal_promo, "id_portal_company" => $this->session->userdata("id_portal_company")));
    if(!$this->input->post(NULL)){
      $this->form_promo($detail);
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/portal/promo/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '600';
      $config['max_height']  = '600';

      $this->load->library('upload', $config);
      
      $detail[0]->link = $pst['link'];
      $this->form_promo($detail);
      
      /**
       * cek ketersediaan
       */
      
      if($pst['id_detail']){
        $where = " AND id_portal_promo <> {$pst['id_detail']}";
        $pst['start_date'] = $detail[0]->start_date;
        $pst['end_date'] = $detail[0]->end_date;
      }
      
      $data_cek = $this->global_models->get_query("SELECT count(id_portal_promo) AS jml"
        . " FROM portal_promo"
        . " WHERE ((start_date BETWEEN '{$pst['start_date']}' AND '{$pst['end_date']}')"
        . " OR (end_date BETWEEN '{$pst['start_date']}' AND '{$pst['end_date']}')"
        . " OR ('{$pst['start_date']}' BETWEEN start_date AND end_date)"
        . " OR ('{$pst['end_date']}' BETWEEN start_date AND end_date))"
        . " AND status = 4"
        . $where);
        
      
      
      if($_FILES['gambar']['name']){
        if (  $this->upload->do_upload('gambar')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("portal/client-portal/add-promo/".$id_portal_promo)."'>Back</a>";
          die;
        }
      }
        
      if($data_cek[0]->jml < 3){
        if($pst['id_detail']){
          $kirim = array(
              "title"           => $pst['title'],
              "nicename"        => $this->global_models->nicename($pst['title'], "portal_promo", "id_portal_promo"),
              "status"          => $pst['status'],
              "update_by_users"   => $this->session->userdata("id"),
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
              "id_portal_company" => $this->session->userdata("id_portal_company"),
              "start_date"      => $pst['start_date'],
              "end_date"        => $pst['end_date'],
              "link"            => $this->session->userdata("company_nicename")."/home",
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
        redirect("portal/client-portal/promo");
      }
      else{
        $detail[0]->id_portal_promo = $pst['id_detail'];
        $detail[0]->start_date = $pst['start_date'];
        $detail[0]->end_date = $pst['end_date'];
        $detail[0]->status = $pst['status'];
        $detail[0]->gambar = $data['upload_data']['file_name'];
        $this->form_promo($detail);
      }
    }
  }
  
  function promo(){
    $list = $this->global_models->get("portal_promo", array("id_portal_company" => $this->session->userdata("id_portal_company")));
    
    $menutable = '
      <li><a href="'.site_url("portal/client-portal/add-promo").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('client/promo', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "portal/client-portal/promo",
            'data'        => $list,
            'title'       => lang("portal_promo"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('client/promo');
  }
  
  function add_new_company(){
    if($this->input->post()){
      $pst = $this->input->post();
      
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
          print "<br /> <a href='".site_url("portal/client-portal/add-new-company/")."'>Back</a>";
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
            "facebook"        => $pst['facebook'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['logo'] = $data['upload_data']['file_name'];
        }
        $id_portal_company = $this->global_models->update("portal_company", array("id_portal_company" => $pst['id_detail']),$kirim);
        $newdata = array(
          'company_nicename' => $kirim['nicename'],
        );
        $this->session->set_userdata($newdata);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename($pst['title'], "portal_company", "id_portal_company"),
            "email"           => $pst['email'],
            "handphone"       => $pst['handphone'],
            "telphone"        => $pst['telphone'],
            "bbm"             => $pst['bbm'],
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
        $global_settings_company_position = $this->nbscache->get_explode("global-settings", "global_settings_company_position");
        $this->global_models->insert("portal_company_users", array("id_portal_company" => $id_portal_company, "id_users" => $this->session->userdata("id"), "id_portal_company_position" => $global_settings_company_position[1]));
        
        $newdata = array(
          'id_portal_company' => $id_portal_company,
          'id_portal_company_position' => $global_settings_company_position[1],
          'company_nicename' => $kirim['nicename'],
        );
        $this->session->set_userdata($newdata);
        
      }
      if($id_portal_company){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/client-portal/add-new-company-address");
      
    }
    else{
      $id_portal_company = $this->global_models->get_field("portal_company_users", "id_portal_company", array("id_users" => $this->session->userdata("id")));
      $detail = $this->global_models->get("portal_company", array("id_portal_company" => $id_portal_company));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
            
              CKEDITOR.replace('editor3');
            });
        </script>
        ";
      
      $this->template->build("client/add-new-company", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users/detail-biodata',
              'title'       => "Create Company",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Biodata"  => "users/detail-biodata"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("client/add-new-company");
    }
  }
  
  function add_new_company_address(){
    if($this->input->post()){
      $pst = $this->input->post();
      if($pst['id_detail']){
        $kirim = array(
            "address"         => $pst['address'],
            "id_portal_lokasi" => $pst['id_portal_lokasi'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_portal_company = $this->global_models->update("portal_company", array("id_portal_company" => $pst['id_detail']),$kirim);
      }
      if($id_portal_company){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/client-portal/add-new-company-bidang-usaha");
    }
    else{
      $detail = $this->global_models->get("portal_company", array("id_portal_company" => $this->session->userdata("id_portal_company")));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
            
            
              $( '#portal_lokasi' ).autocomplete({
                source: '".site_url("portal/master-portal/auto-lokasi")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_portal_lokasi').val(ui.item.id);
                }
              });
            
              CKEDITOR.replace('editor1');
            });
        </script>
        ";
      
      $this->template->build("client/add-new-company-address", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users/detail-biodata',
              'title'       => "Company Address",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Biodata"  => "users/detail-biodata",
                    "Company"  => "portal/client-portal/add-new-company"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("client/add-new-company-address");
    }
  }
  
  function add_new_company_bidang_usaha(){
    if($this->input->post()){
      $pst = $this->input->post();
      if($pst['id_detail']){
        $kirim = array(
            "id_portal_bidang_usaha" => $pst['id_portal_bidang_usaha'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_portal_company = $this->global_models->update("portal_company", array("id_portal_company" => $pst['id_detail']),$kirim);
      }
      if($id_portal_company){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("portal/client-portal/add-new-company-about-us");
    }
    else{
      $detail = $this->global_models->get("portal_company", array("id_portal_company" => $this->session->userdata("id_portal_company")));
      $portal_bidang_usaha = $this->global_models->get("portal_bidang_usaha", array("parent >" => 0));
      
      $this->template->build("client/add-new-company-bidang-usaha", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users/detail-biodata',
              'title'       => "Company Business Fields",
              'detail'      => $detail,
              'portal_bidang_usaha' => $portal_bidang_usaha,
              'breadcrumb'  => array(
                    "Biodata"  => "users/detail-biodata",
                    "Company"  => "portal/client-portal/add-new-company",
                    "Company Address"  => "portal/client-portal/add-new-company-address"
                ),
            ));
      $this->template
        ->set_layout('form')
        ->build("client/add-new-company-bidang-usaha");
    }
  }
  
  function add_new_company_about_us(){
    if($this->input->post()){
      $pst = $this->input->post();
      if($pst['id_detail']){
        $kirim = array(
            "about_us" => $pst['about_us'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_portal_company = $this->global_models->update("portal_company", array("id_portal_company" => $pst['id_detail']),$kirim);
      }
      if($id_portal_company){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("users/detail-biodata");
    }
    else{
      $detail = $this->global_models->get("portal_company", array("id_portal_company" => $this->session->userdata("id_portal_company")));
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
            
              CKEDITOR.replace('editor1');
            });
        </script>
        ";
      
      $this->template->build("client/add-new-company-about-us", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users/detail-biodata',
              'title'       => "Company Business Fields",
              'detail'      => $detail,
              'portal_bidang_usaha' => $portal_bidang_usaha,
              'css'         => $css,
              'foot'        => $foot,
              'breadcrumb'  => array(
                    "Biodata"  => "users/detail-biodata",
                    "Company"  => "portal/client-portal/add-new-company",
                    "Company Address"  => "portal/client-portal/add-new-company-address",
                    "Company Business Fields"  => "portal/client-portal/add-new-company-bidang-usaha"
                ),
            ));
      $this->template
        ->set_layout('form')
        ->build("client/add-new-company-about-us");
    }
  }
  
}
?>