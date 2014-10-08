<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_portal extends MX_Controller {
  
  function __construct() {
    $this->load->library('manimage');
    $this->menu = $this->cek();
  }
  
  public function set_company(){
    if(!$this->input->post(NULL)){
      $position = $this->global_models->get_dropdown("portal_company_position", "id_portal_company_position", "title", false);
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
        . "<script type='text/javascript'>
            $(function() {
              $( '#portal_company' ).autocomplete({
                source: '".site_url("portal/master-portal/auto-company")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_portal_company').val(ui.item.id);
                }
              });
            });
        </script>";
      $this->template->build("settings/set-company", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/settings-portal/set-company',
              'title'       => "Set Company",
              'position'    => $position,
              'css'         => $css,
              'foot'        => $foot,
            ));
      $this->template
        ->set_layout('form')
        ->build("settings/set-company");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $ses = array(
        "id_portal_company"           => $pst['id_portal_company'],
        "id_portal_company_position"  => $pst['id_portal_company_position'],
        'company_nicename' => $this->global_models->get_field("portal_company", "nicename", array("id_portal_company" => $pst['id_portal_company'])),
      );
      
      $this->session->set_userdata($ses);
      
      $this->session->set_flashdata('success', 'Data tersimpan');
      redirect("portal/settings-portal/set-company");
    }
  }
  
  public function umum(){
    if(!$this->input->post(NULL)){
      $privilege = $this->global_models->get_dropdown("m_privilege", "id_privilege", "name", false, array("parent >" => 0));
      $position = $this->global_models->get_dropdown("portal_company_position", "id_portal_company_position", "title", false);
//      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
//      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
//        . "<script type='text/javascript'>
//            $(function() {
//              $( '#portal_company' ).autocomplete({
//                source: '".site_url("portal/master-portal/auto-company")."',
//                minLength: 1,
//                select: function( event, ui ) {
//                  $('#id_portal_company').val(ui.item.id);
//                }
//              });
//            });
//        </script>";
      $this->template->build("settings/global-settings", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'portal/settings-portal/umum',
              'title'       => "Global Settings",
              'css'         => $css,
              'foot'        => $foot,
              'privilege'   => $privilege,
              'position'    => $position,
            ));
      $this->template
        ->set_layout('form')
        ->build("settings/global-settings");
    }
    else{
      $pst = $this->input->post(NULL);
      $this->nbscache->put_tunggal("global-settings", "global_settings_privilege_new_users", $pst['global_settings_privilege_new_users']);
      $this->nbscache->put_tunggal("global-settings", "global_settings_company_position", $pst['global_settings_company_position']);
      $this->session->set_flashdata('success', 'Data tersimpan');
      redirect("portal/settings-portal/umum");
    }
  }
  
}
?>