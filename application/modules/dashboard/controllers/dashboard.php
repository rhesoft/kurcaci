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
    
    $this->template->build("main", 
      array(
            'url'         => base_url()."themes/idtrade/",
            'theme2nd'    => 'idtrade',
            'breadcrumb'  => array(),
            'provinsi'    => $provinsi,
            'slide'       => array("prioritas" => $slide_prioritas, "random" => array(), "pengumuman" => $slide_pengumuman),
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
      $data = $this->global_models->get("m_users", array("email" => $pst['email']));
//      $this->debug($data, true);
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
    redirect("");
  }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */