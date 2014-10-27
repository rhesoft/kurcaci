<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal_mrp extends MX_Controller {
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
  
  function products(){
    
    $list = $this->global_models->get_query("
      SELECT A.*, B.name AS kategori
      FROM mrp_products AS A
      LEFT JOIN mrp_sub_product_category AS B ON A.id_mrp_sub_product_category = B.id_mrp_sub_product_category
      WHERE A.id_portal_company = {$this->session->userdata("id_portal_company")}
      ");
    
    $menutable = '
      <li><a href="'.site_url("mrp/portal-mrp/step-one-new-products").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('portal/products', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "mrp/portal-mrp/products",
            'data'        => $list,
            'title'       => lang("mrp_products"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('portal/products');
  }
  
  function categories(){
    
    $list = $this->global_models->get_query("
      SELECT A.*, B.name AS kategori, count(C.id_mrp_products) AS jumlah
      FROM portal_company_sub_product_category AS Z
      LEFT JOIN mrp_sub_product_category AS A ON Z.id_mrp_sub_product_category = A.id_mrp_sub_product_category
      LEFT JOIN mrp_product_category AS B ON A.id_mrp_product_category = B.id_mrp_product_category
      LEFT JOIN mrp_products AS C ON (Z.id_mrp_sub_product_category = C.id_mrp_sub_product_category AND C.id_portal_company = {$this->session->userdata("id_portal_company")})
      WHERE Z.id_portal_company = {$this->session->userdata("id_portal_company")}
      GROUP BY Z.id_mrp_sub_product_category
      ");
    
    $menutable = '<li><a href="'.site_url("mrp/portal-mrp/add-new-category").'"><i class="icon-plus"></i> Add New</a></li>';
    $this->template->build('portal/category', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "mrp/portal-mrp/categories",
            'title'       => lang("mrp_categories"),
            'data'        => $list,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('portal/category');
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
            "id_portal_company" => $this->session->userdata("id_portal_company"),
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
            "id_portal_company" => $this->session->userdata("id_portal_company"),
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
      redirect("mrp/portal-mrp/products");
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
        . " LEFT JOIN mrp_sub_product_category AS B ON A.id_mrp_sub_product_category = B.id_mrp_sub_product_category"
        . " WHERE id_portal_company = {$this->session->userdata("id_portal_company")}");
      
      $this->template->build('portal/add-new-products', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/portal-mrp/products",
              'title'       => lang("mrp_add_products"),
              'breadcrumb'  => array(
                  lang("mrp_products")  => "mrp/portal-mrp/products"
              ),
              'detail'      => $data,
              'foot'        => $foot,
              'css'         => $css,
              'kategori'    => $kategori,
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/add-new-products');
    }
  }
  
  function add_new_category(){
    if($this->input->post()){
      $pst = $this->input->post();
//      $this->debug($pst, true);
      
      $id_mrp_sub_product_category = $this->global_models->get_field("mrp_sub_product_category", "id_mrp_sub_product_category", array("LOWER(name)" => trim(strtolower($pst['mrp_sub_product_category'])), "id_mrp_product_category" => $pst['id_mrp_product_category']));
      
      if(!$id_mrp_sub_product_category){
        $product_category =  $this->global_models->get("mrp_product_category", array("id_mrp_product_category" => $pst['id_mrp_product_category']));
        $last_code = $this->global_models->get_field("mrp_sub_product_category", "MAX(sort)", array("id_mrp_product_category" => $pst['id_mrp_product_category']));
        if($last_code > 0){
          $sort = $last_code + 1;
        }
        else{
          $sort = $product_category[0]->sort + 1;
        }

        $kirim = array(
          "name"                    => trim($pst['mrp_sub_product_category']),
          "nicename"                => $this->global_models->nicename(trim($pst['mrp_sub_product_category']), "mrp_sub_product_category", "id_mrp_sub_product_category"),
          "id_mrp_product_category" => $pst['id_mrp_product_category'],
          "sort"                    => $sort,
          "create_by_users"         => $this->session->userdata("id"),
          "create_date"             => date("Y-m-d H:i:s")
        );
        $id_mrp_sub_product_category = $this->global_models->insert("mrp_sub_product_category", $kirim);
      }
      
      if($id_mrp_sub_product_category){
        if(!$this->global_models->get_field("portal_company_sub_product_category", "id_portal_company", array("id_portal_company" => $this->session->userdata("id_portal_company"), "id_mrp_sub_product_category" => $id_mrp_sub_product_category))){
          $kirim_company = array(
            "id_portal_company"           => $this->session->userdata("id_portal_company"),
            "id_mrp_sub_product_category" => $id_mrp_sub_product_category,
            "create_by_users"         => $this->session->userdata("id"),
            "create_date"             => date("Y-m-d H:i:s")
          );
          $this->global_models->insert("portal_company_sub_product_category", $kirim_company);
        }
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("mrp/portal-mrp/clear-cache/{$pst['id_mrp_product_category']}");
    }
    else{
      $kategori = $this->global_models->get("mrp_product_category", array("id_parent" => 0));
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              $('#category_multi').click(function (){
                $('#create_sub').show();
                $('#mrp_sub_product_category' ).autocomplete('option', 'source', '".site_url("mrp/master-mrp/auto-sub-product-category")."/'+$('#category_multi').val());
              });
              
              $( '#mrp_sub_product_category' ).autocomplete({
                source: '".site_url("mrp/master-mrp/auto-sub-product-category")."/',
                minLength: 1,
                select: function( event, ui ) {
                  
                }
              });
            });
        </script>
        ";
      $this->template->build('portal/add-new-category', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/portal-mrp/categories",
              'title'       => lang("mrp_add_category"),
              'breadcrumb'  => array(
                  lang("mrp_categories")  => "mrp/portal-mrp/categories"
              ),
              'detail'      => $data,
              'foot'        => $foot,
              'css'         => $css,
              'kategori'    => $kategori,
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/add-new-category');
    }
  }
  
  function step_one_new_products(){
    if($this->input->post()){
      $pst = $this->input->post();
      redirect("mrp/portal-mrp/step-two-new-products/{$pst['id_mrp_sub_product_category']}");
    }
    else{
      $kategori = $this->global_models->get("mrp_product_category", array("id_parent" => 0));
      $url_get_option = site_url("mrp/portal-mrp/get-option-sub-category");
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap2.css' rel='stylesheet' type='text/css' />";
//      $css = '<link href="http://static.scripting.com/github/bootstrap2/css/bootstrap.css" rel="stylesheet">';
      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>";
      $url_auto = site_url("mrp/master-mrp/auto-sub-product-category");
      $url_simpan_sub_cate = site_url("mrp/portal-mrp/ajax-simpan-sub-category");
      $foot .= <<<EOD
          <script type='text/javascript'>
            $(function() {
              $('#simpan_new_categori').click(function (){
                $.post('{$url_simpan_sub_cate}',{id_mrp_product_category:$('#category_multi').val(), title:$('#mrp_sub_product_category').val()},function(data){
                  $.post('{$url_get_option}',{id_mrp_product_category:$('#category_multi').val()},function(data){
                  //console.log(data);
                    if(data == "nbs"){
                      $('#sub_kategory').html("");
                      $('#btn_next').hide();
                      $('#btn_create_sub').show();
                    }
                    else{
                      $('#sub_kategory').html(data);
                      $('#btn_create_sub').show();
                    }
                  });
                });
              });
        
              $('#sub_kategory').click(function (){
                $('#btn_create_sub').show();
                if($('#sub_kategory').val()){
                  $('#btn_next').show();
                }
              });
              $('#category_multi').click(function (){
                $('#create_sub').show();
                $.post('{$url_get_option}',{id_mrp_product_category:$('#category_multi').val()},function(data){
                //console.log(data);
                  if(data == "nbs"){
                    $('#sub_kategory').html("");
                    $('#btn_next').hide();
                    $('#btn_create_sub').show();
                  }
                  else{
                    $('#sub_kategory').html(data);
                    $('#btn_create_sub').show();
                  }
                });
              });
                
            });
        </script>
EOD;
      $this->template->build('portal/step-product/1-category', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/portal-mrp/categories",
              'title'       => lang("mrp_add_category_1"),
              'breadcrumb'  => array(
                  lang("mrp_products")  => "mrp/portal-mrp/products"
              ),
              'kategori'    => $kategori,
              'foot'        => $foot,
              'css'         => $css,
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/step-product/1-category');
    }
  }
  
  function step_two_new_products($id_mrp_sub_product_category){
    if($this->input->post()){
      $pst = $this->input->post();
      $id_mrp_product_category = $this->global_models->get_field("mrp_sub_product_category", "id_mrp_product_category", array("id_mrp_sub_product_category" => $id_mrp_sub_product_category));
//      $this->debug($pst, true);
      
      $kirim = array(
        "id_portal_company"             => $this->session->userdata("id_portal_company"),
        "name"                          => $pst['name'],
        "nicename"                      => $this->global_models->nicename($pst['name'], "mrp_product_category", "id_mrp_product_category"),
        "id_mrp_sub_product_category"   => $pst['id_mrp_sub_product_category'],
        "id_mrp_product_category"       => $id_mrp_product_category,
        "sn"                            => $pst['sn'],
        "price"                         => $this->global_models->string_to_number($pst['price']),
        "status"                        => $pst['status'],
        "create_by_users"               => $this->session->userdata("id"),
        "create_date"                   => date("Y-m-d H:i:s")
      );
      
      $id_mrp_products = $this->global_models->insert("mrp_products", $kirim);
      
      if($id_mrp_products){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("mrp/portal-mrp/step-three-new-products/".$kirim['nicename']);
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
        redirect("mrp/portal-mrp/step-two-new-products/".$id_mrp_sub_product_category);
      }
      
    }
    else{
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>
        <script>
          $(function() {
            $( '#price' ).priceFormat({
              prefix: 'Rp ',
              centsLimit: 0,
              thousandsSeparator: '.'
            });
          });
        </script>";
      
      $this->template->build('portal/step-product/2-category', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/portal-mrp/categories",
              'title'       => lang("mrp_add_category_2"),
              'breadcrumb'  => array(
                  lang("mrp_products")        => "mrp/portal-mrp/products",
                  lang("mrp_add_category_1")  => "mrp/portal-mrp/step-one-new-products",
              ),
              'foot'        => $foot,
              'id_mrp_sub_product_category' => $id_mrp_sub_product_category,
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/step-product/2-category');
    }
  }
  
  function step_three_new_products($nicename_mrp_products){
    $products = $this->global_models->get("mrp_products", array("nicename" => str_replace("-", "_", $nicename_mrp_products)));
    if($this->input->post()){
      $pst = $this->input->post();
//      $this->debug($products);
//      $this->debug($pst, true);
      $config['upload_path'] = './files/mrp/products/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';

      $this->load->library('upload', $config);
      
      if($_FILES['picture']['name']){
        if (  $this->upload->do_upload('picture')){
          $data = array('upload_data' => $this->upload->data());
          $kirim['picture'] = $data['upload_data']['file_name'];
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
          $kirim['picture2'] = $data2['upload_data']['file_name'];
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
          $kirim['picture3'] = $data3['upload_data']['file_name'];
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
          $kirim['picture4'] = $data4['upload_data']['file_name'];
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("mrp/master-mrp/add-new-products/".$id_mrp_products)."'>Back</a>";
          die;
        }
      }
      
      $kirim['update_by_users'] = $this->session->userdata("id");
      
      $id_mrp_products = $this->global_models->update("mrp_products", array("id_mrp_products" => $pst['id_mrp_products']), $kirim);
      if($id_mrp_products){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("mrp/portal-mrp/step-four-new-products/".$products[0]->nicename);
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
        redirect("mrp/portal-mrp/step-three-new-products/".$products[0]->nicename);
      }
      
    }
    else{
      $this->template->build('portal/step-product/3-category', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/portal-mrp/categories",
              'title'       => lang("mrp_add_category_3"),
              'breadcrumb'  => array(
                  lang("mrp_products")        => "mrp/portal-mrp/products",
                  lang("mrp_add_category_1")  => "mrp/portal-mrp/step-one-new-products",
                  lang("mrp_add_category_2")  => "mrp/portal-mrp/step-two-new-products/".$products[0]->id_mrp_sub_product_category,
              ),
              'foot'        => $foot,
              'products'    => $products
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/step-product/3-category');
    }
  }
  
  function step_four_new_products($nicename_mrp_products){
    $products = $this->global_models->get("mrp_products", array("nicename" => str_replace("-", "_", $nicename_mrp_products)));
    if($this->input->post()){
      $pst = $this->input->post();
//      $this->debug($products);
//      $this->debug($pst, true);
      
      $kirim = array(
        "note"                    => $pst['note'],
        "spesification"           => $pst['spesification'],
        "tags"                    => $pst['tags'],
        "update_by_users"         => $this->session->userdata("id")
      );
      
      $id_mrp_products = $this->global_models->update("mrp_products", array("id_mrp_products" => $pst['id_mrp_products']), $kirim);
      if($id_mrp_products){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("mrp/portal-mrp/products/");
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
        redirect("mrp/portal-mrp/step-four-new-products/".$products[0]->nicename);
      }
      
    }
    else{
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
      
      $this->template->build('portal/step-product/4-category', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "mrp/portal-mrp/categories",
              'title'       => lang("mrp_add_category_4"),
              'breadcrumb'  => array(
                  lang("mrp_products")        => "mrp/portal-mrp/products",
                  lang("mrp_add_category_1")  => "mrp/portal-mrp/step-one-new-products",
                  lang("mrp_add_category_2")  => "mrp/portal-mrp/step-two-new-products/".$products[0]->id_mrp_sub_product_category,
                  lang("mrp_add_category_3")  => "mrp/portal-mrp/step-three-new-products/".$nicename_mrp_products,
              ),
              'foot'        => $foot,
              'css'         => $css,
              'products'    => $products
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/step-product/4-category');
    }
  }
  
  function get_option_sub_category(){
    $sub_cate = $this->global_models->get_query("SELECT B.*"
      . " FROM portal_company_sub_product_category AS A"
      . " LEFT JOIN mrp_sub_product_category AS B ON A.id_mrp_sub_product_category = B.id_mrp_sub_product_category"
      . " WHERE B.id_mrp_product_category = {$this->input->post("id_mrp_product_category")}"
      . " AND A.id_portal_company = {$this->session->userdata("id_portal_company")}");
    if($sub_cate){
      foreach($sub_cate AS $sc){
        print "<option value='{$sc->id_mrp_sub_product_category}'>{$sc->name}</option>";
      }
    }
    else{
      print "nbs";
    }
    die;
  }
  
  function ajax_simpan_sub_category(){
    $pst = $this->input->post();
    
    $id_mrp_sub_product_category = $this->global_models->get_field("mrp_sub_product_category", "id_mrp_sub_product_category", array("LOWER(name)" => trim(strtolower($pst['title'])), "id_mrp_product_category" => $pst['id_mrp_product_category']));
      
      if(!$id_mrp_sub_product_category){
        $product_category =  $this->global_models->get("mrp_product_category", array("id_mrp_product_category" => $pst['id_mrp_product_category']));
        $last_code = $this->global_models->get_field("mrp_sub_product_category", "MAX(sort)", array("id_mrp_product_category" => $pst['id_mrp_product_category']));
        if($last_code > 0){
          $sort = $last_code + 1;
        }
        else{
          $sort = $product_category[0]->sort + 1;
        }

        $kirim = array(
          "name"                    => trim($pst['title']),
          "nicename"                => $this->global_models->nicename(trim($pst['title']), "mrp_sub_product_category", "id_mrp_sub_product_category"),
          "id_mrp_product_category" => $pst['id_mrp_product_category'],
          "sort"                    => $sort,
          "create_by_users"         => $this->session->userdata("id"),
          "create_date"             => date("Y-m-d H:i:s")
        );
        $id_mrp_sub_product_category = $this->global_models->insert("mrp_sub_product_category", $kirim);
      }
      
      if($id_mrp_sub_product_category){
        $kirim_company = array(
          "id_portal_company"           => $this->session->userdata("id_portal_company"),
          "id_mrp_sub_product_category" => $id_mrp_sub_product_category,
          "create_by_users"         => $this->session->userdata("id"),
          "create_date"             => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("portal_company_sub_product_category", $kirim_company);
      }
      die;
  }
  
  function delete_category($id_mrp_sub_product_category){
    if($this->global_models->delete("portal_company_sub_product_category", array("id_mrp_sub_product_category" => $id_mrp_sub_product_category, "id_portal_company" => $this->session->userdata("id_portal_company")))){
      $this->session->set_flashdata('success', 'Data terhapus');
    }
    else{
      $this->session->set_flashdata('notice', 'Data gagal terhapus');
    }
    
    redirect("mrp/portal-mrp/categories/");
    
  }
  
  function clear_cache($id_mrp_product_category){
    $this->load->library("nbscache");
    $category = $this->global_models->get_query("SELECT id_mrp_sub_product_category, name, nicename"
      . " FROM mrp_sub_product_category"
      . " WHERE id_mrp_product_category = {$id_mrp_product_category}"
      . " ORDER BY sort ASC");
    
    foreach($category AS $cate){
      $hasil[$cate->id_mrp_sub_product_category] = array(
        "name"        => $cate->name,
        "nicename"    => $cate->nicename
      );
    }
    
    $hasil_string = serialize($hasil);
    $this->nbscache->put_tunggal("sub-category", $id_mrp_product_category, $hasil_string);
    redirect("mrp/portal-mrp/categories");
  }
  
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
