<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal_frm extends MX_Controller {
  function __construct() {
    $this->load->model('frm/mfrm');
    $this->menu = $this->cek();
  }
  
  function account(){
//    $this->cek_journal();
    $list = $this->global_models->get_query("SELECT A.*, B.pos, B.labarugi, B.modal, B.title AS category"
      . " FROM portal_company_account AS Z"
      . " LEFT JOIN frm_account AS A ON A.id_frm_account = Z.id_frm_account"
      . " LEFT JOIN frm_account_category AS B ON A.id_frm_account_category = B.id_frm_account_category");
    
    $menutable = '
      <li><a href="'.site_url("frm/portal-frm/add-account").'"><i class="icon-plus"></i>Konfigurasi</a></li>
      ';
    $this->template->build('portal/account', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "frm/portal-frm/account",
            'data'        => $list,
            'title'       => lang("frm_account"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('portal/account');
  }
  
  function add_account(){
//    $this->cek_journal();
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
      $kategori = $this->global_models->get("frm_account_category");
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $base_url = base_url()."themes/".DEFAULTTHEMES."/";
      $site_auto = site_url("frm/portal-frm/auto-account");
      $site_save_account = site_url("frm/portal-frm/post-ajax-save-account");
      $site_get_account = site_url("frm/portal-frm/post-ajax-get-account");
      $site_add_account = site_url("frm/portal-frm/post-ajax-add-account");
      $site_del_account = site_url("frm/portal-frm/post-ajax-del-account");
      $foot = <<<EOD
        <script src='{$base_url}js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              $('#category_multi').click(function (){
                $('#create_sub').show();
        
                $.post('{$site_get_account}',{id_frm_account_category: $('#category_multi').val()},function(data_hasil_account){
                  $('#hasil').html(data_hasil_account);
                });
                
                $('#frm_account' ).autocomplete('option', 'source', '{$site_auto}/'+$('#category_multi').val());
              });
              $( '#frm_account' ).autocomplete({
                source: '{$site_auto}/',
                minLength: 1,
                select: function( event, ui ) {
                  $.post('{$site_save_account}',{id_account: ui.item.id},function(data_save_account){
                    if(data_save_account == 'ok'){
                      $('#hasil').append('<span id="grape_account'+ui.item.id+'"><span class="btn btn-info btn-xs">'+ui.item.label+'</span><a onclick="del_pilihan('+ui.item.id+')" class="btn btn-warning btn-xs">x</a> &nbsp;</span>');
                    }
                    $('#frm_account').val('');
                  });
                  
                  return false;
                }
              });
            });
            function add_new_account(){
                if($('#frm_account').val()){
                  $.post('{$site_add_account}',{title: $('#frm_account').val(), id_frm_account_category: $('#category_multi').val()},function(data_add_account){
                    if((data_add_account*1) > 0){
                      $('#hasil').append('<span id="grape_account'+data_add_account+'"><span class="btn btn-info btn-xs">'+$('#frm_account').val()+'</span><a onclick="del_pilihan('+data_add_account+')" class="btn btn-warning btn-xs">x</a> &nbsp;</span>');
                    }
                    $('#frm_account').val('');
                  });
                }
            }
            function del_pilihan(id_frm_account){
                  $.post('{$site_del_account}',{id: id_frm_account},function(data_del_account){
                    $("#grape_account"+id_frm_account).remove();
                  });
            }
        </script>
EOD;
      $this->template->build('portal/add-account', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "frm/portal-frm/account",
              'title'       => lang("frm_account"),
              'breadcrumb'  => array(
                  lang("frm_account")  => "frm/portal-frm/account"
              ),
              'detail'      => $data,
              'foot'        => $foot,
              'css'         => $css,
              'kategori'    => $kategori,
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/add-account');
    }
  }
  
  function auto_account($id_frm_account_category = 0){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    if($id_frm_account_category > 0){
      $where = "AND A.id_frm_account_category = {$id_frm_account_category}";
    }
    $items = $this->global_models->get_query("
      SELECT A.*
      FROM frm_account AS A
      WHERE 
      LOWER(A.title) LIKE '%{$q}%' {$where}
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_frm_account,
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
  
  function auto_account_company(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    
    $items = $this->global_models->get_query("
      SELECT A.*
      FROM frm_account AS A
      LEFT JOIN portal_company_account AS B ON A.id_frm_account = B.id_frm_account
      WHERE 
      LOWER(A.title) LIKE '%{$q}%' {$where} AND B.id_portal_company = '{$this->session->userdata("id_portal_company")}'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_frm_account,
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
  
  function post_ajax_save_account(){
    $id_frm_account = $this->input->post("id_account");
    
    $cek = $this->global_models->get_field("portal_company_account", "id_frm_account", array("id_portal_company" => $this->session->userdata("id_portal_company"), "id_frm_account" => $id_frm_account));
    if($cek > 0){
      print "gagal";
    }
    else{
      $kirim = array(
        "id_portal_company"         => $this->session->userdata("id_portal_company"),
        "id_frm_account"            => $id_frm_account,
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("portal_company_account", $kirim);
      print "ok";
    }
    die;
  }
  
  function post_ajax_get_account(){
    $id_frm_account_category = $this->input->post("id_frm_account_category");
    $data = $this->global_models->get_query("SELECT B.*"
      . " FROM portal_company_account AS A"
      . " LEFT JOIN frm_account AS B ON A.id_frm_account = B.id_frm_account"
      . " WHERE B.id_frm_account_category = '{$id_frm_account_category}'");
    foreach($data AS $dt){
      print "<span id='grape_account{$dt->id_frm_account}'><span class='btn btn-info btn-xs'>{$dt->title}</span><a onclick='del_pilihan({$dt->id_frm_account})' class='btn btn-warning btn-xs'>x</a> &nbsp;</span>";
    }
    die;
  }
  
  function post_ajax_add_account(){
    $title = $this->input->post("title");
    $id_frm_account_category = $this->input->post("id_frm_account_category");
    $cek = $this->global_models->get_field("frm_account", "id_frm_account", array("LOWER(title)" => strtolower($title), "id_frm_account_category" => $id_frm_account_category));
    if($cek > 0){
      $cek2 = $this->global_models->get_field("portal_company_account", "id_frm_account", array("id_portal_company" => $this->session->userdata("id_portal_company"), "id_frm_account" => $cek));
      if($cek2 > 0){
        print "gagal";
      }
      else{
        $kirim = array(
          "id_portal_company"         => $this->session->userdata("id_portal_company"),
          "id_frm_account"            => $cek,
          "create_by_users"           => $this->session->userdata("id"),
          "create_date"               => date("Y-m-d H:i:s"),
        );
        $this->global_models->insert("portal_company_account", $kirim);
        print $cek;
      }
    }
    else{
//      create account
      $last_nomber = $this->global_models->get_field("frm_account", "MAX(nomor)", array("id_frm_account_category" => $id_frm_account_category));
      if($last_nomber < 1){
        $last_nomber = $this->global_models->get_field("frm_account_category", "nomor", array("id_frm_account_category" => $id_frm_account_category));
      }
        
      $kirim = array(
        "title"                   => ucwords($title),
        "nomor"                   =>($last_nomber+1),
        "id_frm_account_category" => $id_frm_account_category,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $id_frm_account = $this->global_models->insert("frm_account", $kirim);
      $kirim_company_account = array(
        "id_portal_company"         => $this->session->userdata("id_portal_company"),
        "id_frm_account"            => $id_frm_account,
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("portal_company_account", $kirim_company_account);
      print $id_frm_account;
    }
    die;
  }
  
  function post_ajax_del_account(){
    $id_frm_account = $this->input->post("id");
    $this->global_models->delete("portal_company_account", array("id_portal_company" => $this->session->userdata("id_portal_company"), "id_frm_account" => $id_frm_account));
    print "ok";
    die;
  }
  
  function get_option_bulan(){
    $sub_cate = $this->global_models->get_query("SELECT *"
      . " FROM frm_journal"
      . " WHERE year = '{$this->input->post("tahun")}'"
      . " AND id_portal_company = '{$this->session->userdata("id_portal_company")}'"
      . " ORDER BY sort ASC");
    if($sub_cate){
      foreach($sub_cate AS $sc){
        if($sc->status == 1){
          $warna = "black";
          $selected = "selected";
        }
        else{
          $warna = "red";
          $selected = "";
        }
        print "<option value='{$sc->month}' {$selected} style='color: {$warna}'>".date("F", strtotime($sc->sort))."</option>";
      }
    }
    else{
      print "nbs";
    }
    die;
  }
  
  function catatan_transaksi(){
    $this->cek_journal();
    if($this->input->post("tahun") AND $this->input->post("bulan")){
      redirect("frm/portal-frm/transaksi-bulanan/".$this->input->post("tahun")."/".$this->input->post("bulan"));
    }
    else{
      $menutable = '
        <li><a href="'.site_url("frm/portal-frm/add-catatan-transaksi").'"><i class="icon-plus"></i>Add New</a></li>
        ';
      $tahun_awal = $this->global_models->get_field("frm_journal", "MIN(year)", array("id_portal_company" => $this->session->userdata("id_portal_company")));
      if($tahun_awal < 1){
        $tahun_awal = date("Y");
      }
      $foot = "<script>"
        . "$(function() {"
        . "$('#category_multi').click(function (){ "
        . "$.post('".site_url("frm/portal-frm/get-option-bulan")."',{tahun:$('#category_multi').val()},function(data){ "
          . "$('#sub_kategory').html(data); "
          . "}); "
          . "});"
          . "});"
        . "</script>";
      $this->load->library('global_variable');
      $this->template->build('portal/catatan-transaksi', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "frm/portal-frm/catatan-transaksi",
              'title'       => lang("frm_catatan_transaksi"),
              'menutable'   => $menutable,
              'foot'        => $foot,
              'tahun_awal'  => $tahun_awal,
              'bulan'       => $this->global_variable->bulan(),
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/catatan-transaksi');
    }
  }
  
  private function form_transaksi_bulanan($tahun, $bulan, $detail){
    
    $jumlah_list = $this->global_models->get_field("frm_journal_log", "count(id_frm_journal_log)", array());
    
    $url_list = site_url("frm/portal-frm/ajax-journal-log/".$jumlah_list);
    $url_list_halaman = site_url("frm/portal-frm/ajax-halaman-journal-log/".$jumlah_list);
    $foot = "<script>"
      . "function get_list(start){ "
      . "if(typeof start === 'undefined'){ "
      . "start = 0; "
      . "} "
      . "$.post('{$url_list}/'+start, function(data){ "
      . "$('#data_list').html(data); "
        . "$.post('{$url_list_halaman}/'+start, function(data){ "
        . "$('#halaman_set').html(data); "
          . "}); "
          . "}); "
          . "} "
          . "get_list(0); "
          . "</script>";
    
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
      . "<script>"

      . "function conf_pemasukan(){"
      . " $('#pemasukan').toggle();"
      . "}"

      . "$(function() {"
      
      . "  $( '#tanggal' ).datetimepicker({"
      . "   dateFormat: 'yy-mm-dd',"
      . "   timeFormat: 'HH:mm',"
      . "  });"

      . " $( '#saldo' ).priceFormat({ "
      . "   prefix: 'Rp ', "
        . " centsLimit: 0, "
        . " thousandsSeparator: '.' "
      . " });"

      . " $( '#frm_account_debit' ).autocomplete({ "
      . "   source: '".site_url("frm/portal-frm/auto-account-company")."', "
      . "   minLength: 1, "
      . "   select: function( event, ui ) { "
      . "     $('#id_frm_account_debit').val(ui.item.id); "
      . "   }"
      . " });"

      . " $( '#frm_account_kredit' ).autocomplete({ "
      . "   source: '".site_url("frm/portal-frm/auto-account-company")."', "
      . "   minLength: 1, "
      . "   select: function( event, ui ) { "
      . "     $('#id_frm_account_kredit').val(ui.item.id); "
      . "   }"
      . " });"

      . "});"
      . "</script>";
    if($detail[0]->status == 1){
      $menutable = '
          <li><a href="'.site_url("frm/portal-frm/add-transaksi-terperinci/{$tahun}/{$bulan}").'"><i class="icon-plus"></i>Transaksi Terperinci</a></li>
          ';
    }
    $this->template->build('portal/transaksi-bulanan', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "frm/portal-frm/catatan-transaksi",
            'data'        => $list,
            'title'       => lang("frm_transaksi_bulanan"),
            'menutable'   => $menutable,
            'foot'        => $foot,
            'css'         => $css,
            'tahun'       => $tahun,
            'bulan'       => $bulan,
            'detail'      => $detail,
            'breadcrumb'  => array(
                  lang("frm_catatan_transaksi")  => "frm/portal-frm/catatan-transaksi"
              ),
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('portal/transaksi-bulanan');
  }
  
  function buku_besar($id_frm_journal, $id_frm_account){
    $frm_journal = $this->global_models->get("frm_journal", array("id_frm_journal" => $id_frm_journal));
    $total['debit'] = $this->global_models->get_field("frm_journal_log_account", "sum(saldo)", array("id_frm_journal" => $id_frm_journal, "id_frm_account" => $id_frm_account, "pos" => 1));
    $total['kredit'] = $this->global_models->get_field("frm_journal_log_account", "sum(saldo)", array("id_frm_journal" => $id_frm_journal, "id_frm_account" => $id_frm_account, "pos" => 2));
    
    $jumlah_list = $this->global_models->get_field("frm_journal_log_account", "count(id_frm_journal_log_account)", array("id_frm_account" => $id_frm_account, "id_frm_journal" => $id_frm_journal));
    
    $url_list = site_url("frm/portal-frm/ajax-buku-besar/".$jumlah_list);
    $url_list_halaman = site_url("frm/portal-frm/ajax-halaman-journal-log/".$jumlah_list);
    $foot = "<script>"
      . "function get_list(start){ "
      . "if(typeof start === 'undefined'){ "
      . "start = 0; "
      . "} "
      . "$.post('{$url_list}/'+start, {id_frm_journal: {$id_frm_journal}, id_frm_account: {$id_frm_account}}, function(data){ "
      . "$('#data_list').html(data); "
        . "$.post('{$url_list_halaman}/'+start, function(data){ "
        . "$('#halaman_set').html(data); "
          . "}); "
          . "}); "
          . "} "
          . "get_list(0); "
          . "</script>";
   
    $this->template->build('portal/buku-besar', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "frm/portal-frm/catatan-transaksi",
            'data'        => $list,
            'title'       => lang("frm_buku_besar"),
            'foot'        => $foot,
            'css'         => $css,
            'total'       => $total,
            'breadcrumb'  => array(
                  lang("frm_catatan_transaksi")  => "frm/portal-frm/catatan-transaksi",
                  lang("frm_transaksi_bulanan")  => "frm/portal-frm/transaksi-bulanan/{$frm_journal[0]->year}/{$frm_journal[0]->month}"
              ),
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('portal/buku-besar');
  }
  
  function transaksi_bulanan($tahun, $bulan){
    $this->cek_journal();
    $this->load->library('form_validation');
    $detail = $this->global_models->get("frm_journal", array("month" => $bulan, "year" => $tahun, "id_portal_company" => $this->session->userdata("id_portal_company")));
    $pst = $this->input->post();
    if($pst['masuk'] == 'masuk'){
      $set_config = "frm_simple_transaksi_masuk";
      $set_packet = array(
        "tanggal"           => $pst['tanggal'],
        "notransaksi"       => $pst['notransaksi'],
        "saldo"             => $this->global_models->string_to_number($pst['saldo']),
        "status"            => 1,
        "note"              => $pst['note'],
        "create_by_users"   => $this->session->userdata("id"),
        "create_date"       => date("Y-m-d H:i:s"),
        "debit"             => $pst['id_debit'],
        "kredit"            => $pst['id_kredit'],
      );
    }
    
    
    if ($this->form_validation->run($set_config) == FALSE){
      $this->form_transaksi_bulanan($tahun, $bulan, $detail);
    }
    elseif($detail[0]->status == 1){
      $this->load->model('frm/mfrm');
      
      $frm_journal = $this->mfrm->set_journal_log($set_packet);
      
      if($frm_journal['status'] == 2){
        $this->session->set_flashdata('notice', $frm_journal['note']);
        redirect("frm/portal-frm/transaksi-bulanan/{$tahun}/{$bulan}");
      }
      else{
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("frm/portal-frm/transaksi-bulanan/{$tahun}/{$bulan}");
      }
    }
    else{
      redirect("frm/portal-frm/transaksi-bulanan/{$tahun}/{$bulan}");
    }
  }
  
  private function cek_journal(){
    $cek = $this->global_models->get("frm_journal", array("status" => 1));
    if($cek[0]->id_frm_journal < 1){
      redirect("frm/portal-frm/start-journal");
    }
  }
  
  function start_journal(){
    if($this->input->post()){
      $pst = $this->input->post();
      $id_frm_journal = $this->mfrm->create_journal($pst['tahun'], $pst['bulan'], $this->session->userdata("id_portal_company"));
      if($id_frm_journal){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("frm/portal-frm/catatan-transaksi");
      }
      else{
        $this->session->set_flashdata('notice', $frm_journal['note']);
        redirect("frm/portal-frm/start-journal");
      }
    }
    else{
      $this->template->build('portal/start-journal', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "frm/portal-frm/catatan-transaksi",
              'title'       => lang("frm_start_journal"),
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/start-journal');
    }
  }
  
  function ajax_journal_log($total = 0, $start = 0){
    
    $journal = $this->global_models->get_query("
      SELECT A.*, B.year, B.month
      FROM frm_journal_log AS A
      LEFT JOIN frm_journal AS B ON A.id_frm_journal = B.id_frm_journal
      ORDER BY tanggal ASC
      LIMIT {$start}, 10
      ");
    
    foreach($journal AS $jrnl){
      $log_account = $this->global_models->get_query("SELECT A.*, B.title AS account, B.nomor AS noaccount"
        . " FROM frm_journal_log_account AS A"
        . " LEFT JOIN frm_account AS B ON A.id_frm_account = B.id_frm_account"
        . " WHERE A.id_frm_journal_log = '{$jrnl->id_frm_journal_log}'");
      $tanggal = "<td rowspan='".count($log_account)."'>"
        . "<span class='fa fa-fw fa-calendar'></span> ".date("Y-m-d", strtotime($jrnl->tanggal))."<br />"
        . "<span class='fa fa-fw fa-clock-o'></span> ".date("H:i", strtotime($jrnl->tanggal))
        . "</td>";
      foreach($log_account AS $la){
        if($la->pos == 1){
          $account_debit = "<a href='".site_url("frm/portal-frm/buku-besar/{$jrnl->id_frm_journal}/{$la->id_frm_account}")."'>".$la->account."</a>";
          $account_kredit = "";
          $saldo_debit = $la->saldo;
          $saldo_kredit = 0;
        }
        else{
          $account_debit = "";
          $account_kredit = "<a href='".site_url("frm/portal-frm/buku-besar/{$jrnl->id_frm_journal}/{$la->id_frm_account}")."'>".$la->account."</a>";
          $saldo_debit = 0;
          $saldo_kredit = $la->saldo;
        }
        $hasil .= "<tr>"
          . "{$tanggal}"
          . "<td>{$account_debit}</td>"
          . "<td>{$account_kredit}</td>"
          . "<td>{$la->noaccount}</td>"
          . "<td style='text-align: right'>".  number_format($saldo_debit, 0, ",", ".")."</td>"
          . "<td style='text-align: right'>".  number_format($saldo_kredit, 0, ",", ".")."</td>"
          . "</tr>";
        $tanggal = "";
      }
      $hasil .= "<tr style='background-color: #D0D0D0;font-weight: bold'>"
        . "<td colspan='3'>{$jrnl->note}</td>"
        . "<td>{$jrnl->notransaksi}</td>"
        . "<td style='text-align: right'>".  number_format($jrnl->saldo, 0, ",", ".")."</td>"
        . "<td style='text-align: right'>".  number_format($jrnl->saldo, 0, ",", ".")."</td>"
        . "</tr>";
    }
    
    print $hasil;
    die;
  }
  
  function ajax_buku_besar($total = 0, $start = 0){
    
    $journal = $this->global_models->get_query("
      SELECT A.*, B.tanggal, B.note AS note, B.notransaksi
      FROM frm_journal_log_account AS A
      LEFT JOIN frm_journal_log AS B ON A.id_frm_journal_log = B.id_frm_journal_log
      WHERE A.id_frm_account = '{$this->input->post('id_frm_account')}' AND A.id_frm_journal = '{$this->input->post('id_frm_journal')}'
      ORDER BY B.tanggal DESC
      LIMIT {$start}, 10
      ");
      
    $pos_asli = $this->global_models->get_query("SELECT B.pos"
      . " FROM frm_account AS A"
      . " LEFT JOIN frm_account_category AS B ON A.id_frm_account_category = B.id_frm_account_category"
      . " WHERE A.id_frm_account = '{$this->input->post("id_frm_account")}'");
    
    foreach($journal AS $jrnl){
      
      if($pos_asli[0]->pos == 1){
        if($jrnl->pos == 1){
          $saldo_debit = $jrnl->saldo;
          $saldo_kredit = 0;
        }
        else{
          $saldo_debit = 0;
          $saldo_kredit = $jrnl->saldo;
        }
      }
      else{
        if($jrnl->pos == 1){
          $saldo_debit = 0;
        $saldo_kredit = $jrnl->saldo;
        }
        else{
          $saldo_debit = $jrnl->saldo;
          $saldo_kredit = 0;
        }
      }
      
      $hasil .= "<tr>"
        . "<td>{$jrnl->tanggal}</td>"
        . "<td>{$jrnl->note}</td>"
        . "<td>{$jrnl->notransaksi}</td>"
        . "<td style='text-align: right'>".  number_format($saldo_debit, 0, ",", ".")."</td>"
        . "<td style='text-align: right'>".  number_format($saldo_kredit, 0, ",", ".")."</td>"
        . "</tr>";
    }
    
    print $hasil;
    die;
  }
  
  function ajax_halaman_journal_log($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 10; 
    $config['uri_segment'] = 5; 
    $config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>"; 
    $config['cur_tag_close'] = "</a></li>"; 
    $config['first_tag_open'] = "<li>"; 
    $config['first_tag_close'] = "</li>"; 
    $config['last_tag_open'] = "<li>"; 
    $config['last_tag_close'] = "</li>"; 
    $config['next_tag_open'] = "<li>"; 
    $config['next_tag_close'] = "</li>"; 
    $config['prev_tag_open'] = "<li>"; 
    $config['prev_tag_close'] = "</li>"; 
    $config['num_tag_open'] = "<li>"; 
    $config['num_tag_close'] = "</li>";
    $config['function_js'] = "get_list";
    $this->pagination->initialize($config); 
    
      print "<ul id='halaman_delete' class='pagination pagination-sm no-margin pull-right'>"
    . "{$this->pagination->create_links_ajax()}"
    . "</ul>";
    die;
  }
  
  function add_transaksi_terperinci($tahun, $bulan){
    if($this->input->post()){
      
    }
    else{
      $journal = $this->global_models->get("frm_journal", array("status" => 1, "id_portal_company" => $this->session->userdata("id_portal_company")));
      $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
      . "<script>"

      . "$(function() {"
      
      . "  $( '#tanggal' ).datetimepicker({"
      . "   dateFormat: 'yy-mm-dd',"
      . "   timeFormat: 'HH:mm',"
      . "  });"
      . "});"
      . "</script>";
      $this->template->build('portal/add-transaksi-terperinci', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "frm/portal-frm/catatan-transaksi",
              'title'       => lang("frm_transaksi"),
              'breadcrumb'  => array(
                  lang("frm_catatan_transaksi")  => "frm/portal-frm/catatan-transaksi",
                  lang("frm_transaksi_bulanan")  => "frm/portal-frm/transaksi-bulanan/{$journal[0]->year}/{$journal[0]->month}"
              ),
              'detail'      => $data,
              'foot'        => $foot,
              'css'         => $css,
              'kategori'    => $kategori,
              'tahun'       => $journal[0]->year,
              'bulan'       => $journal[0]->month,
            ));
      $this->template
        ->set_layout('form')
        ->build('portal/add-transaksi-terperinci');
    }
  }
  
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
