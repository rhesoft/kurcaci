<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_mrp extends MX_Controller {
  function __construct() {
    $this->load->library('manimage');
    $this->menu = $this->cek();
  }
  function product_categories(){
    $list = $this->global_models->get_query("
      SELECT A.*, B.name AS ayah
      FROM mrp_product_category AS A
      LEFT JOIN mrp_product_category AS B ON A.id_mrp_product_category = B.id_parent
      ");
    
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-product-categories").'"><i class="icon-plus"></i> Add New</a></li>
      <li><a href="'.site_url("mrp/master-mrp/clear-cache").'"><i class="icon-plus"></i> Clear Cache</a></li>
      ';
    $this->template->build('master/product-categories', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "mrp/master-mrp/product-categories",
            'data'        => $list,
            'title'       => lang("mrp_product_categories"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/product-categories');
  }
  
  function sub_product_categories(){
    $list = $this->global_models->get_query("
      SELECT A.*, B.name AS ayah
      FROM mrp_sub_product_category AS A
      LEFT JOIN mrp_product_category AS B ON A.id_mrp_product_category = B.id_mrp_product_category
      ");
    
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-sub-product-categories").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/sub-product-categories', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "mrp/master-mrp/sub-product-categories",
            'data'        => $list,
            'title'       => lang("mrp_sub_product_categories"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/sub-product-categories');
  }
  
  function gudang(){
    $list = $this->global_models->get("mrp_gudang");
    
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-gudang").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/gudang', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "mrp/master-mrp/gudang",
            'data'        => $list,
            'title'       => lang("mrp_gudang"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/gudang');
  }
  
  function products(){
    $list = $this->global_models->get_query("
      SELECT A.*, B.name AS kategori
      FROM mrp_products AS A
      LEFT JOIN mrp_sub_product_category AS B ON A.id_mrp_sub_product_category = B.id_mrp_sub_product_category
      ");
    
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-products").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/products', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "mrp/master-mrp/products",
            'data'        => $list,
            'title'       => lang("mrp_products"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/products');
  }
  
  function add_new_product_categories($id_mrp_product_category = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      if(!$pst['id_parent'])
        $pst['id_parent'] = 0;
      
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"        => $this->global_models->nicename($pst['name'], "mrp_product_category", "id_mrp_product_category"),
            "sort"            => $pst['sort'],
            "id_parent"       => $pst['id_parent'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_mrp_product_category = $this->global_models->update("mrp_product_category", array("id_mrp_product_category" => $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"        => $this->global_models->nicename($pst['name'], "mrp_product_category", "id_mrp_product_category"),
            "id_parent"       => $pst['id_parent'],
            "sort"            => $pst['sort'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s")
        );
        $id_mrp_product_category = $this->global_models->insert("mrp_product_category", $kirim);
      }
      if($id_mrp_product_category){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("mrp/master-mrp/product-categories");
    }
    else{
      $data = $this->global_models->get("mrp_product_category", array("id_mrp_product_category" => $id_mrp_product_category));
      $this->template->build('master/add-new-product-categories', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/master-mrp/product-categories",
              'title'       => lang("mrp_add_product_categories"),
              'breadcrumb'  => array(
                  lang("mrp_product_categories")  => "mrp/master-mrp/product-categories"
              ),
              'parent'      => $this->global_models->get_dropdown("mrp_product_category", "id_mrp_product_category", "name", TRUE, array("id_parent" => 0)),
              'detail'      => $data,
            ));
      $this->template
        ->set_layout('form')
        ->build('master/add-new-product-categories');
    }
  }
  
  function add_new_sub_product_categories($id_mrp_sub_product_category = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"        => $this->global_models->nicename($pst['name'], "mrp_sub_product_category", "id_mrp_sub_product_category"),
            "id_mrp_product_category"       => $pst['id_mrp_product_category'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_mrp_sub_product_category = $this->global_models->update("mrp_sub_product_category", array("id_mrp_sub_product_category" => $pst['id_detail']), $kirim);
      }
      else{
        $product_category =  $this->global_models->get("mrp_product_category", array("id_mrp_product_category" => $pst['id_mrp_product_category']));
        $last_code = $this->global_models->get_field("mrp_sub_product_category", "MAX(sort)", array("id_mrp_product_category" => $pst['id_mrp_product_category']));
        if($last_code > 0){
          $sort = $last_code + 1;
        }
        else{
          $sort = $product_category[0]->sort + 1;
        }
        
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"        => $this->global_models->nicename($pst['name'], "mrp_product_category", "id_mrp_product_category"),
            "id_mrp_product_category"       => $pst['id_mrp_product_category'],
            "sort"            => $sort,
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s")
        );
        $id_mrp_sub_product_category = $this->global_models->insert("mrp_sub_product_category", $kirim);
      }
      if($id_mrp_sub_product_category){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("mrp/master-mrp/sub-product-categories");
    }
    else{
      $data = $this->global_models->get("mrp_sub_product_category", array("id_mrp_sub_product_category" => $id_mrp_sub_product_category));
      $this->template->build('master/add-new-sub-product-categories', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/master-mrp/sub-product-categories",
              'title'       => lang("mrp_add_sub_product_categories"),
              'breadcrumb'  => array(
                  lang("mrp_sub_product_categories")  => "mrp/master-mrp/sub-product-categories"
              ),
              'parent'      => $this->global_models->get_dropdown("mrp_product_category", "id_mrp_product_category", "name", FALSE, array("id_parent" => 0)),
              'detail'      => $data,
            ));
      $this->template
        ->set_layout('form')
        ->build('master/add-new-sub-product-categories');
    }
  }
  
  function add_new_products($id_mrp_products = 0){
    if($this->input->post()){
      
      $config['upload_path'] = './files/mrp/products/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';

      $this->load->library('upload', $config);
      
      if($_FILES['picture']['name']){
        if (  $this->upload->do_upload('picture')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("mrp/master-mrp/add-new-products/".$id_mrp_products)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['picture2']['name']){
        if (  $this->upload->do_upload('picture2')){
          $data2 = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("mrp/master-mrp/add-new-products/".$id_mrp_products)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['picture3']['name']){
        if (  $this->upload->do_upload('picture3')){
          $data3 = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("mrp/master-mrp/add-new-products/".$id_mrp_products)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['picture4']['name']){
        if (  $this->upload->do_upload('picture4')){
          $data4 = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("mrp/master-mrp/add-new-products/".$id_mrp_products)."'>Back</a>";
          die;
        }
      }
      
      $pst = $this->input->post();
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "id_portal_company" => $pst["id_portal_company"],
            "nicename"        => $this->global_models->nicename($pst['name'], "mrp_product_category", "id_mrp_product_category"),
            "id_mrp_sub_product_category" => $pst['id_mrp_sub_product_category'],
            "id_mrp_product_category" => $this->global_models->get_field("mrp_sub_product_category", "id_mrp_product_category", array("id_mrp_sub_product_category" => $pst['id_mrp_sub_product_category'])),
            "sn"              => $pst['sn'],
            "price"           => $this->global_models->string_to_number($pst['price']),
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "spesification"   => $pst['spesification'],
            "tags"            => $pst['tags'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        if($data2['upload_data']['file_name']){
          $kirim['picture2'] = $data2['upload_data']['file_name'];
        }
        if($data3['upload_data']['file_name']){
          $kirim['picture3'] = $data3['upload_data']['file_name'];
        }
        if($data4['upload_data']['file_name']){
          $kirim['picture4'] = $data4['upload_data']['file_name'];
        }
//        $this->debug($kirim, true);
        $id_mrp_products = $this->global_models->update("mrp_products", array("id_mrp_products" => $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "id_portal_company" => $pst["id_portal_company"],
            "nicename"        => $this->global_models->nicename($pst['name'], "mrp_product_category", "id_mrp_product_category"),
            "id_mrp_sub_product_category" => $pst['id_mrp_sub_product_category'],
            "id_mrp_product_category" => $this->global_models->get_field("mrp_sub_product_category", "id_mrp_product_category", array("id_mrp_sub_product_category" => $pst['id_mrp_sub_product_category'])),
            "sn"              => $pst['sn'],
            "price"           => $this->global_models->string_to_number($pst['price']),
            "note"            => $pst['note'],
            "spesification"   => $pst['spesification'],
            "tags"            => $pst['tags'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        if($data2['upload_data']['file_name']){
          $kirim['picture2'] = $data2['upload_data']['file_name'];
        }
        if($data3['upload_data']['file_name']){
          $kirim['picture3'] = $data3['upload_data']['file_name'];
        }
        if($data4['upload_data']['file_name']){
          $kirim['picture4'] = $data4['upload_data']['file_name'];
        }
        $id_mrp_products = $this->global_models->insert("mrp_products", $kirim);
      }
      if($id_mrp_products){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("mrp/master-mrp/products");
    }
    else{
      $data = $this->global_models->get("mrp_products", array("id_mrp_products" => $id_mrp_products));
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script>
          $(function() {
            $( '#price' ).priceFormat({
              prefix: 'Rp ',
              centsLimit: 0,
              thousandsSeparator: '.'
            });
          });
        </script>
        <script type='text/javascript'>
            $(function() {
              $( '#portal_company' ).autocomplete({
                source: '".site_url("portal/master-portal/auto-company")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_portal_company').val(ui.item.id);
                }
              });
              
                CKEDITOR.replace('editor1');
                CKEDITOR.replace('editor2');
            });
        </script>
        ";
      $kategori = $this->global_models->get_query("SELECT B.*"
        . " FROM portal_company_sub_product_category AS A"
        . " LEFT JOIN mrp_sub_product_category AS B ON A.id_mrp_sub_product_category = B.id_mrp_sub_product_category");
//        . " WHERE id_portal_company = {$this->session->userdata("id_portal_company")}");
      $this->template->build('master/add-new-products', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/master-mrp/products",
              'title'       => lang("mrp_add_products"),
              'breadcrumb'  => array(
                  lang("mrp_products")  => "mrp/master-mrp/products"
              ),
              'detail'      => $data,
              'foot'        => $foot,
              'css'         => $css,
              'kategori'    => $kategori,
            ));
      $this->template
        ->set_layout('form')
        ->build('master/add-new-products');
    }
  }
  
	public function supplier(){
    $data = $this->global_models->get("mrp_supplier");
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-supplier").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build("master/supplier",
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'mrp/master-mrp/supplier',
            'title'       => lang("mrp_supplier"),
            'data'        => $data,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("master/supplier");
	}
  
  
	public function add_new_supplier($id_mrp_supplier = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      $pst = $this->input->post();
      $config['upload_path'] = './files/mrp/supplier/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '600';
      $config['max_height']  = '400';

      $this->load->library('upload', $config);
      if($_FILES['picture']['name']){
        if ( ! $this->upload->do_upload('picture')){
          $error = array('error' => $this->upload->display_errors());
          print $this->upload->display_errors();
          die;
        }
        else{
          $data = array('upload_data' => $this->upload->data());
          $this->manimage->load('./files/mrp/supplier/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(590); 
          $this->manimage->save('./files/mrp/supplier/'.$data['upload_data']['file_name']);

          $this->manimage->load('./files/mrp/supplier/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(270); 
          $this->manimage->save('./files/mrp/supplier/270/'.$data['upload_data']['file_name']);

          $this->manimage->load('./files/mrp/supplier/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(50); 
          $this->manimage->save('./files/mrp/supplier/50/'.$data['upload_data']['file_name']);
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            'title'           => $pst['title'],
            'id_mrp_bank'     => $pst['id_mrp_bank'],
            'pic'             => $pst['pic'],
            'telp'            => $pst['telp'],
            'email'           => $pst['email'],
            'account_number'  => $pst['account_number'],
            'account_name'    => $pst['account_name'],
            'address'         => $pst['address'],
            'update_by_users' =>  $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        $id_mrp_supplier = $this->global_models->update("mrp_supplier", array("id_mrp_supplier"=> $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
            'title'           => $pst['title'],
            'id_mrp_bank'     => $pst['id_mrp_bank'],
            'pic'             => $pst['pic'],
            'telp'            => $pst['telp'],
            'email'           => $pst['email'],
            'account_number'  => $pst['account_number'],
            'account_name'    => $pst['account_name'],
            'address'         => $pst['address'],
            'create_by_users' =>  $this->session->userdata("id"),
            'create_date'     =>  date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        $id_mrp_supplier = $this->global_models->insert("mrp_supplier", $kirim);
      }
      if($id_mrp_supplier){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data gagal disimpan');
      }
      redirect("mrp/master-mrp/supplier");
    }
    else{
      $data = $this->global_models->get("mrp_supplier", array("id_mrp_supplier" => $id_mrp_supplier));
      $bank = $this->global_models->get_dropdown('mrp_bank', "id_mrp_bank", "title");
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
                CKEDITOR.replace('editor1');
            });
        </script>
        ";
      $this->template->build("master/add-new-supplier",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'mrp/master-mrp/supplier',
              'title'       => lang("mrp_supplier"),
              'detail'      => $data,
              'bank'        => $bank,
              'foot'        => $foot,
              'css'         => $css
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-supplier");
    }
  }
  
	public function add_new_gudang($id_mrp_gudang = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      $pst = $this->input->post();
      $config['upload_path'] = './files/mrp/gudang/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '600';
      $config['max_height']  = '400';

      $this->load->library('upload', $config);
      if($_FILES['picture']['name']){
        if ( ! $this->upload->do_upload('picture')){
          $error = array('error' => $this->upload->display_errors());
          print $this->upload->display_errors();
          die;
        }
        else{
          $data = array('upload_data' => $this->upload->data());
          $this->manimage->load('./files/mrp/gudang/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(590); 
          $this->manimage->save('./files/mrp/gudang/'.$data['upload_data']['file_name']);

          $this->manimage->load('./files/mrp/gudang/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(270); 
          $this->manimage->save('./files/mrp/gudang/270/'.$data['upload_data']['file_name']);

          $this->manimage->load('./files/mrp/gudang/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(50); 
          $this->manimage->save('./files/mrp/gudang/50/'.$data['upload_data']['file_name']);
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            'title'           => $pst['title'],
            'telp'            => $pst['telp'],
            'email'           => $pst['email'],
            'address'         => $pst['address'],
            'note'            => $pst['note'],
            'update_by_users' =>  $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        $id_mrp_gudang = $this->global_models->update("mrp_gudang", array("id_mrp_gudang"=> $pst['id_detail']), $kirim);
        
        $rak = explode(",", $pst['rak']);
        $this->global_models->update("mrp_gudang_rak", array("id_mrp_gudang"=> $pst['id_detail']), array("status" => 2));
        foreach ($rak AS $rk){
          if(trim($rk)){
            $cek = $this->global_models->get_field("mrp_gudang_rak", "id_mrp_gudang_rak", array("title" => trim($rk), "id_mrp_gudang" => $pst['id_detail']));
            if($cek){
              $this->global_models->update("mrp_gudang_rak", array("id_mrp_gudang_rak" => $cek), array("status" => 1));
            }
            else{
              $kirim_rak[] = array(
                  "id_mrp_gudang"   => $pst['id_detail'],
                  "title"           => trim($rk),
                  "status"          => 1,
                  'create_by_users' => $this->session->userdata("id"),
                  'create_date'     => date("Y-m-d H:i:s")
              );
              $btc ="nbs";
            }
          }
        }
        if($btc == "nbs")
          $this->global_models->insert_batch("mrp_gudang_rak", $kirim_rak);
        
      }
      else{
        $kirim = array(
            'title'           => $pst['title'],
            'telp'            => $pst['telp'],
            'email'           => $pst['email'],
            'address'         => $pst['address'],
            'note'            => $pst['note'],
            'create_by_users' =>  $this->session->userdata("id"),
            'create_date'     =>  date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        $id_mrp_gudang = $this->global_models->insert("mrp_gudang", $kirim);
        $rak = explode(",", $pst['rak']);
        foreach ($rak AS $rk){
          if(trim($rk)){
            $kirim_rak[] = array(
                "id_mrp_gudang"   => $id_mrp_gudang,
                "title"           => trim($rk),
                "status"          => 1,
                'create_by_users' => $this->session->userdata("id"),
                'create_date'     => date("Y-m-d H:i:s")
            );
          }
        }
        $this->global_models->insert_batch("mrp_gudang_rak", $kirim_rak);
        
      }
      if($id_mrp_gudang){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data gagal disimpan');
      }
      redirect("mrp/master-mrp/gudang");
    }
    else{
      $data = $this->global_models->get("mrp_gudang", array("id_mrp_gudang" => $id_mrp_gudang));
      $rak = $this->global_models->get("mrp_gudang_rak", array("id_mrp_gudang" => $id_mrp_gudang, "status" => 1));
      foreach($rak AS $rk){
        $rak_string .= $rk->title.", ";
      }
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
                CKEDITOR.replace('editor1');
                CKEDITOR.replace('editor2');
            });
        </script>
        ";
      $this->template->build("master/add-new-gudang",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'mrp/master-mrp/gudang',
              'title'       => lang("mrp_gudang"),
              'detail'      => $data,
              'foot'        => $foot,
              'css'         => $css,
              'rak_string'  => $rak_string
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-gudang");
    }
  }
  
	public function bank(){
    $data = $this->global_models->get("mrp_bank");
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-bank").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build("master/bank",
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'mrp/master-mrp/bank',
            'title'       => lang("mrp_bank"),
            'data'        => $data,
            'menutable'   => $menutable
          ));
    $this->template
      ->set_layout('datatables')
      ->build("master/bank");
	}
  
	public function add_new_bank($id_mrp_bank = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      if($pst['id_detail']){
        $kirim = array(
            'title'           => $pst['title'],
            'code'            => $pst['code'],
            'update_by_users' =>  $this->session->userdata("id"),
        );
        $id_mrp_bank = $this->global_models->update("mrp_bank", array("id_mrp_bank"=> $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
            'title'           => $pst['title'],
            'code'            => $pst['code'],
            'create_by_users' =>  $this->session->userdata("id"),
            'create_date'     =>  date("Y-m-d H:i:s")
        );
        $id_mrp_bank = $this->global_models->insert("mrp_bank", $kirim);
      }
      if($id_mrp_bank){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data gagal disimpan');
      }
      redirect("mrp/master-mrp/bank");
    }
    else{
      $data = $this->global_models->get("mrp_bank", array("id_mrp_bank" => $id_mrp_bank));
      $this->template->build("master/add-new-bank",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'mrp/master-mrp/bank',
              'title'       => lang("mrp_bank"),
              'detail'      => $data,
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-bank");
    }
  }
  
	public function brand(){
    $data = $this->global_models->get("mrp_inventory_brand");
    $menutable = '
      <li><a href="'.site_url("mrp/master-mrp/add-new-brand").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build("master/brand",
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'mrp/master-mrp/brand',
            'title'       => lang("mrp_brand"),
            'data'        => $data,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("master/brand");
	}
  
	public function add_new_brand($id_mrp_inventory_brand = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      
      if($_FILES['picture']['name']){
          $config['upload_path'] = './files/mrp/brand/';
          $config['allowed_types'] = 'gif|jpg|png';
          $config['max_width']  = '500';
          $config['max_height']  = '500';

          $this->load->library('upload', $config);
          if($_FILES['picture']['name']){
            if (  $this->upload->do_upload('picture')){
              $data = array('upload_data' => $this->upload->data());
            }
            else{
              print $this->upload->display_errors();
              print "<br /> <a href='".site_url("mrp/master-mrp/add-new-products/".$id_mrp_products)."'>Back</a>";
              die;
            }
          }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            'name'            => $pst['name'],
            'nicename'        => $this->global_models->nicename($pst['name'],"mrp_inventory_brand","id_mrp_inventory_brand"),
            'note'            => $pst['note'],
            'update_by_users' =>  $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        $id_mrp_inventory_brand = $this->global_models->update("mrp_inventory_brand", array("id_mrp_inventory_brand"=> $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
            'name'            => $pst['name'],
            'nicename'        => $this->global_models->nicename($pst['name'],"mrp_inventory_brand","id_mrp_inventory_brand"),
            'note'            => $pst['note'],
            'create_by_users' =>  $this->session->userdata("id"),
            'create_date'     =>  date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['picture'] = $data['upload_data']['file_name'];
        }
        $id_mrp_inventory_brand = $this->global_models->insert("mrp_inventory_brand", $kirim);
      }
      if($id_mrp_inventory_brand){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data gagal disimpan');
      }
      redirect("mrp/master-mrp/brand");
    }
    else{
      $data = $this->global_models->get("mrp_inventory_brand", array("id_mrp_inventory_brand" => $id_mrp_inventory_brand));
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
                CKEDITOR.replace('editor1');
            });
        </script>
        ";
      $this->template->build("master/add-new-brand",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'mrp/master-mrp/brand',
              'title'       => lang("mrp_brand"),
              'detail'      => $data,
              'css'         => $css,
              'foot'        => $foot,
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-brand");
    }
  }
  
  function auto_products(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM mrp_products
      WHERE 
      LOWER(name) LIKE '%{$q}%' OR LOWER(sn) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_mrp_products,
            "label" => $tms->name,
            "value" => $tms->name,
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
  
  function auto_gudang_rak(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT A.*, B.title AS gudang
      FROM mrp_gudang_rak AS A
      LEFT JOIN mrp_gudang AS B ON A.id_mrp_gudang = B.id_mrp_gudang
      WHERE 
      LOWER(A.title) LIKE '%{$q}%' OR LOWER(B.title) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_mrp_gudang_rak,
            "label" => $tms->gudang." - ".$tms->title,
            "value" => $tms->gudang." - ".$tms->title,
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
  
  function auto_sub_product_category($id_mrp_product_category){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT A.*
      FROM mrp_sub_product_category AS A
      WHERE 
      LOWER(A.name) LIKE '%{$q}%' AND A.id_mrp_product_category = {$id_mrp_product_category}
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_mrp_sub_product_category,
            "label" => $tms->name,
            "value" => $tms->name,
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
  
  function clear_cache(){
    $this->load->library("nbscache");
    $category = $this->global_models->get_query("SELECT id_mrp_product_category, name, nicename"
      . " FROM mrp_product_category"
      . " ORDER BY sort ASC");
    foreach($category AS $cate){
      $hasil[$cate->id_mrp_product_category] = array(
        "name"        => $cate->name,
        "nicename"    => $cate->nicename
      );
    }
    
    $hasil_string = serialize($hasil);
    $this->nbscache->put_tunggal("category", "head", $hasil_string);
    redirect("mrp/master-mrp/product-categories");
  }
  
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
