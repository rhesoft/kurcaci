<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk extends MX_Controller {
    
  function __construct() {      
    
//    $this->debug($this->menu, true);
  }
	public function index(){
    
    $product = $this->global_models->get_query("SELECT A.*, B.title AS company, B.nicename AS company_nicename, C.title AS lokasi, C.nicename AS lokasi_nicename, B.address"
      . " FROM mrp_products AS A"
      . " LEFT JOIN portal_company AS B ON A.id_portal_company = B.id_portal_company"
      . " LEFT JOIN portal_lokasi AS C ON B.id_portal_lokasi = C.id_portal_lokasi"
      . " ORDER BY name ASC LIMIT 0,5");
    
    /**
     * wajib
     */
    $provinsi = $this->global_models->get_query("SELECT *"
      . " FROM portal_lokasi"
      . " ORDER BY title ASC");
    
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
            'ads'         => array("inti" => $ads, "tambahan" => $ads_default),
            'new_product' => $new_product,
            'menu_atas'   => array("produk" => "active"),
            'products'    => $product,
          ));
    $this->template
      ->set_layout('dashboard')
      ->build("main");
	}
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */