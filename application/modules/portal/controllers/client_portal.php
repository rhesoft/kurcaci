<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_portal extends MX_Controller {
  
  function __construct() {
    $this->load->library('manimage');
    $this->menu = $this->cek();
    $this->cek_session();
  }
  
  private function cek_session(){
    if(!$this->session->userdata("id_portal_company")){
      redirect("portal/settings-portal/set-company");
    }
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
  
  private function form_promo($detail){
    $this->template->build("client/add-new-promo", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'portal/client-portal/promo',
            'title'       => "Create Promo",
            'detail'      => $detail,
            'breadcrumb'  => array(
                  "Promo"  => "portal/client-portal/promo"
              ),
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
  
}
?>