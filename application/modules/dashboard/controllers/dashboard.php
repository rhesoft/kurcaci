<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller {
    
  function __construct() {      
    
//    $this->debug($this->menu, true);
  }
	public function index(){
    $provinsi = $this->global_models->get_query("SELECT *"
      . " FROM portal_lokasi"
      . " ORDER BY title ASC");
    
    $slide_pengumuman = $this->global_models->get_query("SELECT *"
      . " FROM portal_promo"
      . " WHERE ('".date("Y-m-d")."' BETWEEN start_date AND end_date) AND status = 5"
      . " ORDER BY end_date ASC LIMIT 0,3");
    
    $slide_prioritas = $this->global_models->get_query("SELECT *"
      . " FROM portal_promo"
      . " WHERE ('".date("Y-m-d")."' BETWEEN start_date AND end_date) AND status = 4"
      . " ORDER BY end_date ASC LIMIT 0,3");
    
    $jml_prioritas = count($slide_prioritas);
    $jml_pengumuman = count($slide_pengumuman);
    $jml_random = 2 + (3-$jml_prioritas) + (3-$jml_pengumuman);
    
    $slide_random = $this->global_models->get_query("SELECT *"
      . " FROM portal_promo"
      . " WHERE ('".date("Y-m-d")."' BETWEEN start_date AND end_date) AND status = 3"
      . " ORDER BY RAND() LIMIT 0,{$jml_random}");
    
    $jml_dpt_random = count($slide_random);
    if($jml_random > $jml_dpt_random){
      $slide_default = $this->global_models->get_query("SELECT *"
        . " FROM portal_promo"
        . " WHERE status = 6"
        . " ORDER BY RAND() LIMIT 0,".($jml_random-$jml_dpt_random));
    }
    
    $ads = $this->global_models->get_query("SELECT *"
      . " FROM portal_advertisement"
      . " WHERE ('".date("Y-m-d")."' BETWEEN start_date AND end_date) AND status = 3"
      . " ORDER BY end_date DESC LIMIT 0,3");
    
    $banyak_ads = count($ads);
    if($banyak_ads < 3){
      $sel = 3 - $banyak_ads;
      $ads_default = $this->global_models->get_query("SELECT *"
        . " FROM portal_advertisement"
        . " WHERE status = 2"
        . " ORDER BY end_date DESC LIMIT 0,{$sel}");
    }
    
    $new_product = $this->global_models->get_query("SELECT A.*"
      . " FROM mrp_products AS A"
      . " WHERE A.status = 1"
      . " ORDER BY create_date DESC LIMIT 0,8");
    
    $this->template->build("main", 
      array(
            'url'         => base_url()."themes/idtrade/",
            'theme2nd'    => 'idtrade',
            'breadcrumb'  => array(),
            'provinsi'    => $provinsi,
            'slide'       => array("prioritas" => $slide_prioritas, "random" => $slide_random, "pengumuman" => $slide_pengumuman, "default" => $slide_default),
            'ads'         => array("inti" => $ads, "tambahan" => $ads_default),
            'new_product' => $new_product,
            'menu_atas'   => array("home" => "active"),
          ));
    $this->template
      ->set_layout('dashboard')
      ->build("main");
	}
  
  function logout(){
    $this->session->sess_destroy();
    redirect("");
  }
  function login(){
    $this->load->library('encrypt');
    if($this->input->post()){
      $pst = $this->input->post();
//      $this->debug($pst, true);
      if($pst['submit'] == "login"){
        $data = $this->global_models->get("m_users", array("email" => $pst['email']));
        if($data){
          if($pst['sandi'] == $this->encrypt->decode($data[0]->pass)){
            $priv = $this->global_models->get("d_user_privilege", array("id_users" => $data[0]->id_users));
            if(!$priv){
              $priv[0] = (object) array('id_user_privilege' => "", 'id_privilege' => 0);
            }
            $id_portal_company = $this->global_models->get_field("portal_company_users", "id_portal_company", array("id_users" => $data[0]->id_users));
            $newdata = array(
              'name'  => $data[0]->name,
              'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($data[0]->name),
              'epass'  => substr(md5(date("d")), -5).$data[0]->pass,
              'email'     => $data[0]->email,
              'id'     => $data[0]->id_users,
              'outlet'     => 0,
              'privilege'     => $priv[0]->id_user_privilege,
              'id_privilege'     => $priv[0]->id_privilege,
              'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => $priv[0]->id_privilege)),
              'id_portal_company' => $id_portal_company,
              'id_portal_company_position' => $this->global_models->get_field("portal_company_users", "id_portal_company_position", array("id_users" => $data[0]->id_users)),
              'company_nicename' => $this->global_models->get_field("portal_company", "nicename", array("id_portal_company" => $id_portal_company)),
              'logged_in' => TRUE
            );
            $this->session->set_userdata($newdata);
          }
        }

        redirect($pst['lokasi']);
      }
      else{
//        $this->debug($pst, true);
//        insert to users
        if($this->cek_form($pst) === TRUE){
          $kirim = array(
            "name"            => $pst['first_name']." ".$pst['last_name'],
            "pass"            => $this->encrypt->encode($pst['pass']),
            "email"           => $pst['daftar_email'],
            "id_status_user"  => mt_rand(1111111111, 9999999999),
          );
          $id_users = $this->global_models->insert("m_users", $kirim);
//        set privilege
          $global_settings_privilege_new_users = $this->nbscache->get_explode("global-settings", "global_settings_privilege_new_users");
          
          $hasil_pr = $this->global_models->insert("d_user_privilege", 
                  array(
                      "id_privilege"  =>  $global_settings_privilege_new_users[1],
                      "id_users"  =>  $id_users
                      ));
//        kirim konfirmasi email
//        
          $this->email->from('no-reply@technomotor.co.id', 'Administrator');
          $this->email->to($kirim["email"]);

          $this->email->subject('Pendaftaran : Konfirmasi Email');
          $this->email->message("
            Berikut adalah akunt untuk akses Outlet Monitoring :
            link => ".base_url()."
            user => {$email_user[0]->name}
            pass => {$new_password}
            ");

          if($this->email->send() === TRUE){
            $this->session->set_flashdata('daftar_berhasil_email_send', "Email Konfirmasi Terkirim");
          }
          else{
            $this->session->set_flashdata('daftar_gagal_email_send', "Email Konfirmasi Gagal Terkirim");
          }
//        
//        login first time
          $newdata = array(
            'name'  => $kirim['name'],
            'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($kirim['name']),
            'epass'  => substr(md5(date("d")), -5).$pst['pass'],
            'email'     => $kirim['email'],
            'id'     => $id_users,
            'outlet'     => 0,
            'privilege'     => $hasil_pr,
            'id_privilege'     => $global_settings_privilege_new_users[1],
            'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => $global_settings_privilege_new_users[1])),
            'logged_in' => TRUE
          );
          $this->session->set_userdata($newdata);
        }
      }
    }
    redirect($pst['lokasi']);
  }
  
  function cek_form($pst){
//    cek ketersediaan first name
    if(!$pst['first_name']){
      $this->session->set_flashdata('daftar_gagal_first_name', $pst['first_name']);
      $salah = "nbs";
    }
//    cek ketersediaan email
    if(!$pst['daftar_email']){
      $this->session->set_flashdata('daftar_gagal_email', $pst['daftar_email']);
      $salah = "nbs";
    }
//    cek ketersediaan pass
    if(!$pst['pass']){
      $this->session->set_flashdata('daftar_gagal_pass', $pst['pass']);
      $salah = "nbs";
    }
//    cek ketersediaan repass
    if(!$pst['re_pass']){
      $this->session->set_flashdata('daftar_gagal_re_pass', $pst['re_pass']);
      $salah = "nbs";
    }
//    cek kesamaan pass dan repass
    if($pst['pass'] != $pst['re_pass']){
      $this->session->set_flashdata('daftar_gagal_cek_pass', 'Password dan Ulangi Password tidak sama');
      $salah = "nbs";
    }
    
    if($salah == "nbs"){
      redirect($pst['lokasi']);
    }
    return TRUE;
  }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */