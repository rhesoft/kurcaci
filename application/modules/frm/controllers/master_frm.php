<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_frm extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function account_category(){
    $list = $this->global_models->get("frm_account_category");
    
    $menutable = '
      <li><a href="'.site_url("frm/master-frm/add-account-category").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/account-category', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "frm/master-frm/account-category",
            'data'        => $list,
            'title'       => lang("frm_account_categories"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/account-category');
  }
  
  public function add_account_category($id_frm_account_category = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      if($pst['id_detail']){
        $kirim = array(
            'title'           => $pst['title'],
            'nomor'           => $pst['nomor'],
            'pos'             => $pst['pos'],
            'labarugi'        => $pst['labarugi'],
            'modal'           => $pst['modal'],
            'update_by_users' =>  $this->session->userdata("id"),
        );
        $id_frm_account_category = $this->global_models->update("frm_account_category", array("id_frm_account_category"=> $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
            'title'           => $pst['title'],
            'nomor'           => $pst['nomor'],
            'pos'             => $pst['pos'],
            'labarugi'        => $pst['labarugi'],
            'modal'           => $pst['modal'],
            'create_by_users' =>  $this->session->userdata("id"),
            'create_date'     =>  date("Y-m-d H:i:s")
        );
        $id_frm_account_category = $this->global_models->insert("frm_account_category", $kirim);
      }
      if($id_frm_account_category){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data gagal disimpan');
      }
      redirect("frm/master-frm/account-category");
    }
    else{
      $data = $this->global_models->get("frm_account_category", array("id_frm_account_category" => $id_frm_account_category));
      $this->template->build("master/add-account-category",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "frm/master-frm/account-category",
              'title'       => lang("frm_account_categories"),
              'detail'      => $data,
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-account-category");
      
    }
  }
  
  function account(){
    $list = $this->global_models->get_query("SELECT A.*, B.pos, B.labarugi, B.modal"
      . " FROM frm_account AS A"
      . " LEFT JOIN frm_account_category AS B ON A.id_frm_account_category = B.id_frm_account_category");
    
    $menutable = '
      <li><a href="'.site_url("frm/master-frm/add-account").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/account', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "frm/master-frm/account",
            'data'        => $list,
            'title'       => lang("frm_account"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/account');
  }
  
  public function add_account($id_frm_account = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      if($pst['id_detail']){
        $kirim = array(
            'title'           => $pst['title'],
            'update_by_users' =>  $this->session->userdata("id"),
        );
        $id_frm_account = $this->global_models->update("frm_account", array("id_frm_account"=> $pst['id_detail']), $kirim);
      }
      else{
        $last_nomber = $this->global_models->get_field("frm_account", "MAX(nomor)", array("id_frm_account_category" => $pst['id_frm_account_category']));
        if($last_nomber < 1){
          $last_nomber = $this->global_models->get_field("frm_account_category", "nomor", array("id_frm_account_category" => $pst['id_frm_account_category']));
        }
        $kirim = array(
            'title'           => $pst['title'],
            'nomor'           => ($last_nomber+1),
            "id_frm_account_category" => $pst['id_frm_account_category'],
            'create_by_users' =>  $this->session->userdata("id"),
            'create_date'     =>  date("Y-m-d H:i:s")
        );
        $id_frm_account = $this->global_models->insert("frm_account", $kirim);
      }
      if($id_frm_account){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data gagal disimpan');
      }
      redirect("frm/master-frm/account");
    }
    else{
      $data = $this->global_models->get("frm_account", array("id_frm_account" => $id_frm_account));
      $category = $this->global_models->get_dropdown("frm_account_category", "id_frm_account_category", "title", FALSE);
      $this->template->build("master/add-account",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "frm/master-frm/account",
              'title'       => lang("frm_account"),
              'detail'      => $data,
              'category'    => $category
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-account");
    }
  }
  
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
