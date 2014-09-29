<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal_cms extends MX_Controller {
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
  
  function contact_us(){
    $total = $this->global_models->get_query("SELECT count(id_cms_contact_us_company) AS jml"
      . " FROM cms_contact_us_company WHERE id_portal_company = {$this->session->userdata("id_portal_company")} AND received_status = 1");
      
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
      <script type='text/javascript'>
          $(function() {
              $('#kata_cari_contact').keyup(function(){
                $.post('".site_url("cms/portal-cms/ajax-total-inbox-company")."',{q:$('#kata_cari_contact').val()},function(total_data){
                  $('#total_page').val(total_data);
                  set_daftar(0);
                });
              });
              $('#cms_pesan_to').keyup(function(){
                $.post('".site_url("cms/portal-cms/ajax-company-select/")."', {q: $('#cms_pesan_to').val()},function(data_select){
                  $('#id_portal_company').html(data_select);
                });
              });
              CKEDITOR.replace('editor2');
              CKEDITOR.replace('editor3');
          });
      </script>
      ";
      
    $foot .= "<script>"
      . "function set_daftar(start_page){"
      . " if(typeof start_page === 'undefined'){"
      . "   start_page = 0;"
      . " }"
      . " $.post('".site_url("cms/portal-cms/ajax-inbox-company")."',{start: start_page, q:$('#kata_cari_contact').val()},function(data){"
      . "   $('#set_daftar').html(data);"
      . "   $.post('".site_url("cms/portal-cms/ajax-halaman-mail")."/'+$('#total_page').val()+'/'+start_page,function(data_page){"
      . "     $('#set_daftar_page').html(data_page)"
      . "   });"
      . " });"
      . "}"
      . "set_daftar();"
      . "$('#balas_pesan').click(function(){"
      . " $('#name_users').val($('#pesan_sender').text());"
      . " CKEDITOR.instances.editor3.setData( '<br /><br /><blockquote> '+$('#pesan_note').html()+' </blockquote>' );"
//      . " $('#editor3').val('<br /><hr /> '+$('#pesan_note').text());"
      . " $('#subject_users').val('Re: '+$('#pesan_title').text());"
      . " $('#compose-modal-users').modal('show');"
      . "});"
      
      . "$('#kirim_pesan').click(function(){"
      . "var value_editor2 = CKEDITOR.instances['editor2'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail")."',{id_portal_company: $('#id_portal_company').val(), pesan: value_editor2, subject: $('#subject').val()},function(data_page){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      
      . "$('#kirim_pesan_users').click(function(){"
      . "var value_editor3 = CKEDITOR.instances['editor3'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail-users")."',{email: $('#name_users').val(), pesan: value_editor3, subject: $('#subject_users').val()},function(data_page_users){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      
      . "function klik_star(id_cms_contact_us_company){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star")."',{id: id_cms_contact_us_company},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us_company).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us_company).toggleClass(g.c);"
      . "   });"
      . "}"
      . "function show_detail(id_cms_contact_us_company){"
      . " $.post('".site_url("cms/portal-cms/ajax-detail-pesan")."',{id: id_cms_contact_us_company},function(data_detail_pesan){"
      . "   var data_tampil = jQuery.parseJSON( data_detail_pesan );"
      . "   $('#pesan_title').text(data_tampil.title);"
      . "   $('#pesan_sender').text(data_tampil.sender);"
      . "   $('#pesan_sender_to').text(data_tampil.sender_to);"
      . "   $('#pesan_note').html(data_tampil.note);"
      . "   $('#status_read_'+id_cms_contact_us_company).removeClass();"
      . "   $('#status_read_'+id_cms_contact_us_company).toggleClass('read');"
      . "   $('#jumlah_inbox').text(data_tampil.jumlah_read);"
      . "   $('#labora').modal('show');"
      . " });"
      . "}"
        
        . "function delete_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: $(this).val()},function(data_delete_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox').text(data_delete_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function unread_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-unread-pesan")."',{id: $(this).val()},function(data_unread_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox').text(data_unread_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function read_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-read-pesan")."',{id: $(this).val()},function(data_read_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox').text(data_read_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function delete_detail_pesan(id){"
        . " $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: id},function(data_delete_pesan){"
        . "   set_daftar(0);"
        . "   $('#jumlah_inbox').text(data_delete_pesan);"
        . " });"
        . "}"
      
      . ""
      . "</script>";
      
    $portal_company = $this->global_models->get("portal_company", array("id_portal_company <>" => $this->session->userdata("id_portal_company")));
    
    $jumlah_inbox = $this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1));
    $jumlah_inbox_users = $this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1));
    
    $this->template->build('portal/contact-us', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "cms/portal-cms/contact-us",
            'title'       => lang("cms_contact_us"),
            'inbox_comp'  => "active",
            'foot'        => $foot,
            'css'         => $css,
            'portal_company' => $portal_company,
            'jumlah_inbox' => "({$jumlah_inbox})",
            'jumlah_inbox_users' => "({$jumlah_inbox_users})",
            'total'       => $total[0]->jml,
          ));
    $this->template
      ->set_layout('mail')
      ->build('portal/contact-us');
  }
  
  function inbox(){
    $total = $this->global_models->get_query("SELECT count(id_cms_contact_us) AS jml"
      . " FROM cms_contact_us WHERE id_users = {$this->session->userdata("id")} AND received_status = 1");
      
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>";
      
    $foot .= "<script>"
      . "$(function() {"
      . " $('#kata_cari_contact').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-total-inbox")."',{q:$('#kata_cari_contact').val()},function(total_data){"
      . "     $('#total_page').val(total_data);"
      . "     set_daftar(0);"
      . "   });"
      . " });"
      
      . " $('#cms_pesan_to').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-company-select/")."', {q: $('#cms_pesan_to').val()},function(data_select){"
      . "     $('#id_portal_company').html(data_select);"
      . "   });"
      . " });"
      
      . " CKEDITOR.replace('editor2');"
      . " CKEDITOR.replace('editor3');"
      . "});"
      
      . "function set_daftar(start_page){"
      . " if(typeof start_page === 'undefined'){"
      . "   start_page = 0;"
      . " }"
      . " $.post('".site_url("cms/portal-cms/ajax-inbox")."',{start: start_page, q:$('#kata_cari_contact').val()},function(data){"
      . "   $('#set_daftar').html(data);"
      . "   $.post('".site_url("cms/portal-cms/ajax-halaman-mail")."/'+$('#total_page').val()+'/'+start_page,function(data_page){"
      . "     $('#set_daftar_page').html(data_page)"
      . "   });"
      . " });"
      . "}"
      . "set_daftar();"
      . "$('#balas_pesan').click(function(){"
      . " $('#name_users').val($('#pesan_sender').text());"
//      . " console.log($('#pesan_note').html());"
      . " CKEDITOR.instances.editor3.setData( '<br /><br /><blockquote> '+$('#pesan_note').html()+' </blockquote>' );"
//      . " $('#editor3').val('<br /><hr /> '+$('#pesan_note').text());"
      . " $('#subject_users').val('Re: '+$('#pesan_title').text());"
      . " $('#compose-modal-users').modal('show');"
      . "});"
      . "$('#kirim_pesan').click(function(){"
      . "var value_editor2 = CKEDITOR.instances['editor2'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail")."',{id_portal_company: $('#id_portal_company').val(), pesan: value_editor2, subject: $('#subject').val()},function(data_page){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      
      . "$('#kirim_pesan_users').click(function(){"
      . "var value_editor3 = CKEDITOR.instances['editor3'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail-users")."',{email: $('#name_users').val(), pesan: value_editor3, subject: $('#subject_users').val()},function(data_page_users){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      
      . "function klik_star(id_cms_contact_us_company){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star")."',{id: id_cms_contact_us_company},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us_company).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us_company).toggleClass(g.c);"
      . "   });"
      . "}"
      
      . "function klik_star_users(id_cms_contact_us){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star-users")."',{id: id_cms_contact_us},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us).toggleClass(g.c);"
      . "   });"
      . "}"
      
      . "function show_detail(id_cms_contact_us_company){"
      . " $.post('".site_url("cms/portal-cms/ajax-detail-pesan-users")."',{id: id_cms_contact_us_company},function(data_detail_pesan){"
      . "   var data_tampil = jQuery.parseJSON( data_detail_pesan );"
      . "   $('#pesan_title').text(data_tampil.title);"
      . "   $('#pesan_sender').text(data_tampil.sender);"
      . "   $('#pesan_sender_to').text(data_tampil.sender_to);"
      . "   $('#pesan_note').html(data_tampil.note);"
      . "   $('#status_read_'+id_cms_contact_us_company).removeClass();"
      . "   $('#status_read_'+id_cms_contact_us_company).toggleClass('read');"
      . "   $('#jumlah_inbox_users').text(data_tampil.jumlah_read);"
      . "   $('#labora').modal('show');"
      . " });"
      . "}"
        
        . "function delete_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-delete-pesan-users")."',{id: $(this).val()},function(data_delete_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox_users').text(data_delete_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function unread_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-unread-pesan-users")."',{id: $(this).val()},function(data_unread_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox_users').text(data_unread_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function read_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-read-pesan-users")."',{id: $(this).val()},function(data_read_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox_users').text(data_read_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function delete_detail_pesan(id){"
        . " $.post('".site_url("cms/portal-cms/ajax-delete-pesan-users")."',{id: id},function(data_delete_pesan){"
        . "   set_daftar(0);"
        . "   $('#jumlah_inbox_users').text(data_delete_pesan);"
        . " });"
        . "}"
      
      . ""
      . "</script>";
      
    $portal_company = $this->global_models->get("portal_company", array("id_portal_company <>" => $this->session->userdata("id_portal_company")));
    
    $jumlah_inbox = $this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1));
    $jumlah_inbox_users = $this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1));
    
    $this->template->build('portal/contact-us', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "cms/portal-cms/contact-us",
            'title'       => lang("cms_contact_us"),
            'inbox_users'  => "active",
            'foot'        => $foot,
            'css'         => $css,
            'portal_company' => $portal_company,
            'jumlah_inbox' => "({$jumlah_inbox})",
            'jumlah_inbox_users' => "({$jumlah_inbox_users})",
            'total'       => $total[0]->jml,
          ));
    $this->template
      ->set_layout('mail')
      ->build('portal/contact-us');
  }
  
  function outgoing(){
    $total = $this->global_models->get_query("SELECT count(id_cms_contact_us) AS jml"
      . " FROM cms_contact_us WHERE id_users_from = {$this->session->userdata("id")} AND sender_status = 1");
      
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>";
      
    $foot .= "<script>"
      . "$(function() {"
      . " $('#kata_cari_contact').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-total-outgoing")."',{q:$('#kata_cari_contact').val()},function(total_data){"
      . "     $('#total_page').val(total_data);"
      . "     set_daftar(0);"
      . "   });"
      . " });"
      
      . " $('#cms_pesan_to').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-company-select/")."', {q: $('#cms_pesan_to').val()},function(data_select){"
      . "     $('#id_portal_company').html(data_select);"
      . "   });"
      . " });"
      
      . " CKEDITOR.replace('editor2');"
      . " CKEDITOR.replace('editor3');"
      . "});"
      
      . "function set_daftar(start_page){"
      . " if(typeof start_page === 'undefined'){"
      . "   start_page = 0;"
      . " }"
      . " $.post('".site_url("cms/portal-cms/ajax-outgoing")."',{start: start_page, q:$('#kata_cari_contact').val()},function(data){"
      . "   $('#set_daftar').html(data);"
      . "   $.post('".site_url("cms/portal-cms/ajax-halaman-mail")."/'+$('#total_page').val()+'/'+start_page,function(data_page){"
      . "     $('#set_daftar_page').html(data_page)"
      . "   });"
      . " });"
      . "}"
      . "set_daftar();"
      . "$('#balas_pesan').click(function(){"
      . " $('#name_users').val($('#pesan_sender').text());"
//      . " console.log($('#pesan_note').html());"
      . " CKEDITOR.instances.editor3.setData( '<br /><br /><blockquote> '+$('#pesan_note').html()+' </blockquote>' );"
//      . " $('#editor3').val('<br /><hr /> '+$('#pesan_note').text());"
      . " $('#subject_users').val('Re: '+$('#pesan_title').text());"
      . " $('#compose-modal-users').modal('show');"
      . "});"
      . "$('#kirim_pesan').click(function(){"
      . "var value_editor2 = CKEDITOR.instances['editor2'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail")."',{id_portal_company: $('#id_portal_company').val(), pesan: value_editor2, subject: $('#subject').val()},function(data_page){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      
      . "$('#kirim_pesan_users').click(function(){"
      . "var value_editor3 = CKEDITOR.instances['editor3'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail-users")."',{email: $('#name_users').val(), pesan: value_editor3, subject: $('#subject_users').val()},function(data_page_users){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      
      . "function klik_star(id_cms_contact_us_company){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star")."',{id: id_cms_contact_us_company},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us_company).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us_company).toggleClass(g.c);"
      . "   });"
      . "}"
      
      . "function klik_star_users(id_cms_contact_us){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star-users")."',{id: id_cms_contact_us},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us).toggleClass(g.c);"
      . "   });"
      . "}"
      
      . "function show_detail(id_cms_contact_us_company){"
      . " $.post('".site_url("cms/portal-cms/ajax-detail-pesan-users")."',{id: id_cms_contact_us_company},function(data_detail_pesan){"
      . "   var data_tampil = jQuery.parseJSON( data_detail_pesan );"
      . "   $('#pesan_title').text(data_tampil.title);"
      . "   $('#pesan_sender').text(data_tampil.sender);"
      . "   $('#pesan_sender_to').text(data_tampil.sender_to);"
      . "   $('#pesan_note').html(data_tampil.note);"
      . "   $('#status_read_'+id_cms_contact_us_company).removeClass();"
      . "   $('#status_read_'+id_cms_contact_us_company).toggleClass('read');"
      . "   $('#jumlah_inbox_users').text(data_tampil.jumlah_read);"
      . "   $('#labora').modal('show');"
      . " });"
      . "}"
        
        . "function delete_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-delete-pesan-users")."',{id: $(this).val()},function(data_delete_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox_users').text(data_delete_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function unread_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-unread-pesan-users")."',{id: $(this).val()},function(data_unread_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox_users').text(data_unread_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function read_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-read-pesan-users")."',{id: $(this).val()},function(data_read_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox_users').text(data_read_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function delete_detail_pesan(id){"
        . " $.post('".site_url("cms/portal-cms/ajax-delete-pesan-users")."',{id: id},function(data_delete_pesan){"
        . "   set_daftar(0);"
        . "   $('#jumlah_inbox_users').text(data_delete_pesan);"
        . " });"
        . "}"
      
      . ""
      . "</script>";
      
    $portal_company = $this->global_models->get("portal_company", array("id_portal_company <>" => $this->session->userdata("id_portal_company")));
    
    $jumlah_inbox = $this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1));
    $jumlah_inbox_users = $this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1));
    
    $this->template->build('portal/contact-us', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "cms/portal-cms/contact-us",
            'title'       => lang("cms_contact_us"),
            'sent_users'  => "active",
            'foot'        => $foot,
            'css'         => $css,
            'portal_company' => $portal_company,
            'jumlah_inbox' => "({$jumlah_inbox})",
            'jumlah_inbox_users' => "({$jumlah_inbox_users})",
            'total'       => $total[0]->jml,
          ));
    $this->template
      ->set_layout('mail')
      ->build('portal/contact-us');
  }
  
  function ajax_inbox_company(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%".strtolower($this->input->post("q"))."%' OR LOWER(B.email LIKE '%".strtolower($this->input->post("q"))."%'))";
    $data = $this->global_models->get_query("SELECT A.*, B.email AS users"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE A.id_portal_company = {$this->session->userdata("id_portal_company")} AND A.received_status = 1"
      . $where
      . " ORDER BY A.create_date DESC LIMIT {$this->input->post("start")}, 10");
    
    $html = "<table class='table table-mailbox'>";
    foreach($data AS $dt){
      if($dt->star == 1){
        $star = "fa-star-o";
      }
      else{
        $star = "fa-star";
      }
      if($dt->status == 1){
        $status = "unread";
      }
      else{
        $status = "read";
      }
      
      $html .= ""
        . "<tr id='status_read_{$dt->id_cms_contact_us_company}' class='{$status}'>
              <td class='small-col'><input type='checkbox' value='{$dt->id_cms_contact_us_company}' class='pilih_contact' /></td>
              <td class='small-col'><i id='bintang_{$dt->id_cms_contact_us_company}' onclick='klik_star({$dt->id_cms_contact_us_company})' class='fa {$star}'></i></td>
              <td class='name'><a onclick='show_detail({$dt->id_cms_contact_us_company})' href='javascript:void(0);'>{$dt->users}</a></td>
              <td class='subject'><a onclick='show_detail({$dt->id_cms_contact_us_company})' href='javascript:void(0);'>{$dt->title}</a></td>
              <td class='time'>{$dt->create_date}</td>
              <td class='time'><a href='javascript:void(0);' onclick='delete_detail_pesan({$dt->id_cms_contact_us_company})' ><i class='fa fa-fw fa-eraser'></i></a></td>
          </tr>";
    }
    $html .= "</table>";
    
    print $html;
    die;
  }
  
  function ajax_inbox(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%".strtolower($this->input->post("q"))."%' OR LOWER(B.email LIKE '%".strtolower($this->input->post("q"))."%'))";
    $data = $this->global_models->get_query("SELECT A.*, B.email AS users"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users_from = B.id_users"
      . " WHERE A.id_users = {$this->session->userdata("id")} AND A.received_status = 1"
      . $where
      . " ORDER BY A.create_date DESC LIMIT {$this->input->post("start")}, 10");
    
    $html = "<table class='table table-mailbox'>";
    foreach($data AS $dt){
      if($dt->star == 1){
        $star = "fa-star-o";
      }
      else{
        $star = "fa-star";
      }
      if($dt->status == 1){
        $status = "unread";
      }
      else{
        $status = "read";
      }
      
      $html .= ""
        . "<tr id='status_read_{$dt->id_cms_contact_us}' class='{$status}'>
              <td class='small-col'><input type='checkbox' value='{$dt->id_cms_contact_us}' class='pilih_contact' /></td>
              <td class='small-col'><i id='bintang_{$dt->id_cms_contact_us}' onclick='klik_star_users({$dt->id_cms_contact_us})' class='fa {$star}'></i></td>
              <td class='name'><a onclick='show_detail({$dt->id_cms_contact_us})' href='javascript:void(0);'>{$dt->users}</a></td>
              <td class='subject'><a onclick='show_detail({$dt->id_cms_contact_us})' href='javascript:void(0);'>{$dt->title}</a></td>
              <td class='time'>{$dt->create_date}</td>
              <td class='time'><a href='javascript:void(0);' onclick='delete_detail_pesan({$dt->id_cms_contact_us})' ><i class='fa fa-fw fa-eraser'></i></a></td>
          </tr>";
    }
    $html .= "</table>";
    
    print $html;
    die;
  }
  
  function ajax_outgoing(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%".strtolower($this->input->post("q"))."%' OR LOWER(B.email LIKE '%".strtolower($this->input->post("q"))."%'))";
    $data = $this->global_models->get_query("SELECT A.*, B.email AS users"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE A.id_users_from = {$this->session->userdata("id")} AND A.sender_status = 1"
      . $where
      . " ORDER BY A.create_date DESC LIMIT {$this->input->post("start")}, 10");
    
    $html = "<table class='table table-mailbox'>";
    foreach($data AS $dt){
      if($dt->star_own == 1){
        $star = "fa-star-o";
      }
      else{
        $star = "fa-star";
      }
      if($dt->status == 1){
        $status = "read";
      }
      else{
        $status = "read";
      }
      
      $html .= ""
        . "<tr id='status_read_{$dt->id_cms_contact_us}' class='{$status}'>
              <td class='small-col'><input type='checkbox' value='{$dt->id_cms_contact_us}' class='pilih_contact' /></td>
              <td class='small-col'><i id='bintang_{$dt->id_cms_contact_us}' onclick='klik_star_users({$dt->id_cms_contact_us})' class='fa {$star}'></i></td>
              <td class='name'><a onclick='show_detail({$dt->id_cms_contact_us})' href='javascript:void(0);'>{$dt->users}</a></td>
              <td class='subject'><a onclick='show_detail({$dt->id_cms_contact_us})' href='javascript:void(0);'>{$dt->title}</a></td>
              <td class='time'>{$dt->create_date}</td>
              <td class='time'><a href='javascript:void(0);' onclick='delete_detail_pesan({$dt->id_cms_contact_us})' ><i class='fa fa-fw fa-eraser'></i></a></td>
          </tr>";
    }
    $html .= "</table>";
    
    print $html;
    die;
  }
  
  function ajax_permintaan_company(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%".strtolower($this->input->post("q"))."%' OR LOWER(B.email LIKE '%".strtolower($this->input->post("q"))."%'))";
    $data = $this->global_models->get_query("SELECT A.*, B.title AS users"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN portal_company AS B ON A.id_portal_company = B.id_portal_company"
      . " WHERE A.id_users = {$this->session->userdata("id")} AND A.sender_status = 1"
      . $where
      . " ORDER BY A.create_date DESC LIMIT {$this->input->post("start")}, 10");
    
    $html = "<table class='table table-mailbox'>";
    foreach($data AS $dt){
      if($dt->star_own == 1){
        $star = "fa-star-o";
      }
      else if($dt->star_own == 2){
        $star = "fa-star";
      }
      else{
        $star = "fa-star-o";
      }
      if($dt->status == 1){
        $status = "read";
      }
      else{
        $status = "read";
      }
      
      $html .= ""
        . "<tr id='status_read_{$dt->id_cms_contact_us_company}' class='{$status}'>
              <td class='small-col'><input type='checkbox' value='{$dt->id_cms_contact_us_company}' class='pilih_contact' /></td>
              <td class='small-col'><i id='bintang_{$dt->id_cms_contact_us_company}' onclick='klik_star({$dt->id_cms_contact_us_company})' class='fa {$star}'></i></td>
              <td class='name'><a onclick='show_detail({$dt->id_cms_contact_us_company})' href='javascript:void(0);'>{$dt->users}</a></td>
              <td class='subject'><a onclick='show_detail({$dt->id_cms_contact_us_company})' href='javascript:void(0);'>{$dt->title}</a></td>
              <td class='time'>{$dt->create_date}</td>
              <td class='time'><a href='javascript:void(0);' onclick='delete_detail_pesan({$dt->id_cms_contact_us_company})' ><i class='fa fa-fw fa-eraser'></i></a></td>
          </tr>";
    }
    $html .= "</table>";
    
    print $html;
    die;
  }
  
  function ajax_star_company(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%".strtolower($this->input->post("q"))."%' OR LOWER(B.email LIKE '%".strtolower($this->input->post("q"))."%'))";
    $data = $this->global_models->get_query("SELECT A.*, B.email AS users"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE ((A.id_users = {$this->session->userdata("id")} AND A.sender_status = 1 AND A.star_own = 2)"
      . " OR (A.id_portal_company = {$this->session->userdata("id_portal_company")} AND A.received_status = 1 AND A.star = 2))"
      . $where
      . " ORDER BY A.create_date DESC LIMIT {$this->input->post("start")}, 10");
    
    $html = "<table class='table table-mailbox'>";
    foreach($data AS $dt){
      if($dt->star == 2 OR $dt->star_own == 2){
        $star = "fa-star";
      }
      else{
        $star = "fa-star-o";
      }
      if($dt->status == 1){
        $status = "read";
      }
      else{
        $status = "read";
      }
      
      $html .= ""
        . "<tr id='status_read_{$dt->id_cms_contact_us_company}' class='{$status}'>
              <td class='small-col'><input type='checkbox' value='{$dt->id_cms_contact_us_company}' class='pilih_contact' /></td>
              <td class='small-col'><i id='bintang_{$dt->id_cms_contact_us_company}' onclick='klik_star({$dt->id_cms_contact_us_company})' class='fa {$star}'></i></td>
              <td class='name'><a onclick='show_detail({$dt->id_cms_contact_us_company})' href='javascript:void(0);'>{$dt->users}</a></td>
              <td class='subject'><a onclick='show_detail({$dt->id_cms_contact_us_company})' href='javascript:void(0);'>{$dt->title}</a></td>
              <td class='time'>{$dt->create_date}</td>
              <td class='time'><a href='javascript:void(0);' onclick='delete_detail_pesan({$dt->id_cms_contact_us_company})' ><i class='fa fa-fw fa-eraser'></i></a></td>
          </tr>";
    }
    $html .= "</table>";
    
    print $html;
    die;
  }
  
  function ajax_star(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%".strtolower($this->input->post("q"))."%' OR LOWER(B.email LIKE '%".strtolower($this->input->post("q"))."%'))";
    $data = $this->global_models->get_query("SELECT A.*, B.email AS users"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users_from = B.id_users"
      . " WHERE ((A.id_users_from = {$this->session->userdata("id")} AND A.sender_status = 1 AND A.star_own = 2)"
      . " OR (A.id_users = {$this->session->userdata("id")} AND A.received_status = 1 AND A.star = 2))"
      . $where
      . " ORDER BY A.create_date DESC LIMIT {$this->input->post("start")}, 10");
    
    $html = "<table class='table table-mailbox'>";
    foreach($data AS $dt){
      if($dt->star == 2 OR $dt->star_own == 2){
        $star = "fa-star";
      }
      else{
        $star = "fa-star-o";
      }
      if($dt->status == 1){
        $status = "read";
      }
      else{
        $status = "read";
      }
      
      $html .= ""
        . "<tr id='status_read_{$dt->id_cms_contact_us}' class='{$status}'>
              <td class='small-col'><input type='checkbox' value='{$dt->id_cms_contact_us}' class='pilih_contact' /></td>
              <td class='small-col'><i id='bintang_{$dt->id_cms_contact_us}' onclick='klik_star({$dt->id_cms_contact_us})' class='fa {$star}'></i></td>
              <td class='name'><a onclick='show_detail({$dt->id_cms_contact_us})' href='javascript:void(0);'>{$dt->users}</a></td>
              <td class='subject'><a onclick='show_detail({$dt->id_cms_contact_us})' href='javascript:void(0);'>{$dt->title}</a></td>
              <td class='time'>{$dt->create_date}</td>
              <td class='time'><a href='javascript:void(0);' onclick='delete_detail_pesan({$dt->id_cms_contact_us})' ><i class='fa fa-fw fa-eraser'></i></a></td>
          </tr>";
    }
    $html .= "</table>";
    
    print $html;
    die;
  }
  
  function ajax_halaman_mail($total = 0, $start = 0){
    
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
    $config['function_js'] = "set_daftar";
    $this->pagination->initialize($config); 
    
      print <<<EOD
      <ul class='pagination pagination-sm no-margin pull-right' id='halaman_delete'>
        {$this->pagination->create_links_ajax()}
      </ul>
EOD;
    die;
  }
  
  function ajax_company_select(){
    $company = $this->global_models->get_query("SELECT A.*"
      . " FROM portal_company AS A"
      . " WHERE LOWER(A.title) LIKE '%{$this->input->post("q")}%'"
      . " AND A.id_portal_company <> {$this->session->userdata("id_portal_company")}");
    if($company){
      foreach($company AS $sc){
        print "<option value='{$sc->id_portal_company}'>{$sc->title}</option>";
      }
    }
    die;
  }
  
  function ajax_kirim_mail(){
    $kirim = array(
      	"id_portal_company"       => $this->input->post("id_portal_company"),
        "id_users"                => $this->session->userdata("id"),
        "star"                    => 1,
        "status"                  => 1,
        "sender_status"           => 1,
        "received_status"         => 1,
        "title"                   => $this->input->post("subject"),
        "nicename"                => $this->global_models->nicename($this->input->post("subject"), "cms_contact_us_company", "id_cms_contact_us_company"),
        "note"                    => $this->input->post("pesan"),
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("cms_contact_us_company", $kirim);
    die;
  }
  
  function ajax_kirim_mail_users(){
    $kirim = array(
      	"id_users"                => $this->global_models->get_field("m_users", "id_users", array("email" => $this->input->post("email"))),
        "id_users_from"           => $this->session->userdata("id"),
        "star"                    => 1,
        "status"                  => 1,
        "sender_status"           => 1,
        "received_status"         => 1,
        "title"                   => $this->input->post("subject"),
        "nicename"                => $this->global_models->nicename($this->input->post("subject"), "cms_contact_us_company", "id_cms_contact_us_company"),
        "note"                    => $this->input->post("pesan"),
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("cms_contact_us", $kirim);
    die;
  }
  
  function ajax_ubah_star(){
    $id_cms_contact_us_company = $this->input->post("id");
    $detail = $this->global_models->get("cms_contact_us_company", array("id_cms_contact_us_company" => $id_cms_contact_us_company));
    if($detail[0]->id_users == $this->session->userdata("id")){
      $star_ubah = "star_own";
    }
    else{
      $star_ubah = "star";
    }
    if($detail[0]->$star_ubah == 1){
      $this->global_models->update("cms_contact_us_company", array("id_cms_contact_us_company" => $id_cms_contact_us_company), array($star_ubah => 2));
      $c = "fa fa-star";
    }
    else{
      $this->global_models->update("cms_contact_us_company", array("id_cms_contact_us_company" => $id_cms_contact_us_company), array($star_ubah => 1));
      $c = "fa fa-star-o";
    }
    $hasil = array(
        "c"   => $c,
    );
    print json_encode($hasil);
    die;
  }
  
  function ajax_ubah_star_users(){
    $id_cms_contact_us = $this->input->post("id");
    $detail = $this->global_models->get("cms_contact_us", array("id_cms_contact_us" => $id_cms_contact_us));
    
    if($detail[0]->id_users_from == $this->session->userdata("id")){
      $star_ubah = "star_own";
    }
    else{
      $star_ubah = "star";
    }
    
    if($detail[0]->$star_ubah == 1){
      $this->global_models->update("cms_contact_us", array("id_cms_contact_us" => $id_cms_contact_us), array($star_ubah => 2));
      $c = "fa fa-star";
    }
    else{
      $this->global_models->update("cms_contact_us", array("id_cms_contact_us" => $id_cms_contact_us), array($star_ubah => 1));
      $c = "fa fa-star-o";
    }
    $hasil = array(
        "c"   => $c,
    );
    print json_encode($hasil);
    die;
  }
  
  function ajax_detail_pesan($stat = 0){
    $detail = $this->global_models->get_query("SELECT A.*, B.email AS users, C.title AS users_to"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " LEFT JOIN portal_company AS C ON A.id_portal_company = C.id_portal_company"
      . " WHERE A.id_cms_contact_us_company = {$this->input->post("id")}");
    if($detail[0]->id_users != $this->session->userdata("id"))
      $this->global_models->update("cms_contact_us_company", array("id_cms_contact_us_company" => $this->input->post("id")), array("status" => 2));
    $hasil = array(
        "title"       => $detail[0]->title,
        "sender"      => $detail[0]->users,
        "sender_to"   => $detail[0]->users_to,
        "note"        => $detail[0]->note,
        "jumlah_read" => "(".$this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1)).")"
    );
    print json_encode($hasil);
    die;
  }
  
  function ajax_detail_pesan_users(){
    $detail = $this->global_models->get_query("SELECT A.*, B.email AS users, C.email AS users_from"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " LEFT JOIN m_users AS C ON A.id_users_from = C.id_users"
      . " WHERE A.id_cms_contact_us = {$this->input->post("id")}");
    if($detail[0]->id_users_from != $this->session->userdata("id"))
      $this->global_models->update("cms_contact_us", array("id_cms_contact_us" => $this->input->post("id")), array("status" => 2));
    $hasil = array(
        "title"       => $detail[0]->title,
        "sender"      => $detail[0]->users_from,
        "sender_to"   => $detail[0]->users,
        "note"        => $detail[0]->note,
        "jumlah_read" => "(".$this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1)).")"
    );
    print json_encode($hasil);
    die;
  }
  
  function ajax_delete_pesan(){
    $id_users = $this->global_models->get_field("cms_contact_us_company", "id_users", array("id_cms_contact_us_company" => $this->input->post("id")));
    if($id_users == $this->session->userdata("id")){
      $status = "sender_status";
    }
    else{
      $status = "received_status";
    }
    $this->global_models->update("cms_contact_us_company", array("id_cms_contact_us_company" => $this->input->post("id")), array($status => 2));
    print "(".$this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1)).")";
    die;
  }
  
  function ajax_delete_pesan_users(){
    
    $id_users = $this->global_models->get_field("cms_contact_us", "id_users_from", array("id_cms_contact_us" => $this->input->post("id")));
    if($id_users == $this->session->userdata("id")){
      $status = "sender_status";
    }
    else{
      $status = "received_status";
    }
    
    $this->global_models->update("cms_contact_us", array("id_cms_contact_us" => $this->input->post("id")), array($status => 2));
    print "(".$this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1)).")";
    die;
  }
  
  function ajax_unread_pesan(){
    $this->global_models->update("cms_contact_us_company", array("id_cms_contact_us_company" => $this->input->post("id")), array("status" => 1));
    print "(".$this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1)).")";
    die;
  }
    
  function ajax_unread_pesan_users(){
    $this->global_models->update("cms_contact_us", array("id_cms_contact_us" => $this->input->post("id")), array("status" => 1));
    print "(".$this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users_from" => $this->session->userdata("id"), "status" => 1, "received_status" => 1)).")";
    die;
  }
    
  function ajax_read_pesan(){
    $this->global_models->update("cms_contact_us_company", array("id_cms_contact_us_company" => $this->input->post("id")), array("status" => 2));
    print "(".$this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1)).")";
    die;
  }
  
  function ajax_read_pesan_users(){
    $this->global_models->update("cms_contact_us", array("id_cms_contact_us" => $this->input->post("id")), array("status" => 2));
    print "(".$this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users_from" => $this->session->userdata("id"), "status" => 1, "received_status" => 1)).")";
    die;
  }
  
  function ajax_total_inbox_company(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%{$this->input->post("q")}%' OR LOWER(B.email) LIKE '%{$this->input->post("q")}%')";
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us_company) AS jml"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE A.id_portal_company = {$this->session->userdata("id_portal_company")} AND A.received_status = 1"
      . $where
      . "");
      print $total[0]->jml;
    die;
  }
  
  function ajax_total_inbox(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%{$this->input->post("q")}%' OR LOWER(B.email) LIKE '%{$this->input->post("q")}%')";
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us) AS jml"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users_from = B.id_users"
      . " WHERE A.id_users = {$this->session->userdata("id")} AND A.received_status = 1"
      . $where
      . "");
      print $total[0]->jml;
    die;
  }
  
  function ajax_total_outgoing(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%{$this->input->post("q")}%' OR LOWER(B.email) LIKE '%{$this->input->post("q")}%')";
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us) AS jml"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users_from = B.id_users"
      . " WHERE A.id_users_from = {$this->session->userdata("id")} AND A.sender_status = 1"
      . $where
      . "");
      print $total[0]->jml;
    die;
  }
  
  function ajax_total_permintaan_company(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%{$this->input->post("q")}%' OR LOWER(B.email) LIKE '%{$this->input->post("q")}%')";
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us_company) AS jml"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE A.id_users = {$this->session->userdata("id")} AND A.sender_status = 1"
      . $where
      . "");
      print $total[0]->jml;
    die;
  }
  
  function ajax_total_star_company(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%{$this->input->post("q")}%' OR LOWER(B.email) LIKE '%{$this->input->post("q")}%')";
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us_company) AS jml"
      . " FROM cms_contact_us_company AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE ((A.id_users = {$this->session->userdata("id")} AND A.sender_status = 1 AND A.star_own = 2)"
      . " OR (A.id_portal_company = {$this->session->userdata("id_portal_company")} AND A.received_status = 1 AND A.star = 2))"
      . $where
      . "");
      print $total[0]->jml;
    die;
  }
  
  function ajax_total_star(){
    if($this->input->post("q"))
      $where = " AND (LOWER(A.title) LIKE '%{$this->input->post("q")}%' OR LOWER(B.email) LIKE '%{$this->input->post("q")}%')";
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us) AS jml"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users_from = B.id_users"
      . " WHERE ((A.id_users_from = {$this->session->userdata("id")} AND A.sender_status = 1 AND A.star_own = 2)"
      . " OR (A.id_users = {$this->session->userdata("id")} AND A.received_status = 1 AND A.star = 2))"
      . $where
      . "");
      print $total[0]->jml;
    die;
  }
  
  function permintaan_keluar(){
    $total = $this->global_models->get_query("SELECT count(id_cms_contact_us_company) AS jml"
      . " FROM cms_contact_us_company WHERE id_users = {$this->session->userdata("id")} AND sender_status = 1");
      
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
      <script type='text/javascript'>
          $(function() {
              $('#kata_cari_contact').keyup(function(){
                $.post('".site_url("cms/portal-cms/ajax-total-permintaan-company")."',{q:$('#kata_cari_contact').val()},function(total_data){
                  $('#total_page').val(total_data);
                  set_daftar(0);
                });
              });
              $('#cms_pesan_to').keyup(function(){
                $.post('".site_url("cms/portal-cms/ajax-company-select/")."', {q: $('#cms_pesan_to').val()},function(data_select){
                  $('#id_portal_company').html(data_select);
                });
              });
              CKEDITOR.replace('editor2');
              CKEDITOR.replace('editor3');
          });
      </script>
      ";
      
    $foot .= "<script>"
      . "function set_daftar(start_page){"
      . " if(typeof start_page === 'undefined'){"
      . "   start_page = 0;"
      . " }"
      . " $.post('".site_url("cms/portal-cms/ajax-permintaan-company")."',{start: start_page, q:$('#kata_cari_contact').val()},function(data){"
      . "   $('#set_daftar').html(data);"
      . "   $.post('".site_url("cms/portal-cms/ajax-halaman-mail")."/'+$('#total_page').val()+'/'+start_page,function(data_page){"
      . "     $('#set_daftar_page').html(data_page)"
      . "   });"
      . " });"
      . "}"
      . "set_daftar();"
      . "$('#balas_pesan').click(function(){"
      . " $('#name_users').val($('#pesan_sender').text());"
      . " CKEDITOR.instances.editor3.setData( '<br /><br /><blockquote> '+$('#pesan_note').html()+' </blockquote>' );"
//      . " $('#editor3').val('<br /><hr /> '+$('#pesan_note').text());"
      . " $('#subject_users').val('Re: '+$('#pesan_title').text());"
      . " $('#compose-modal-users').modal('show');"
      . "});"
      . "$('#kirim_pesan').click(function(){"
      . "var value_editor2 = CKEDITOR.instances['editor2'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail")."',{id_portal_company: $('#id_portal_company').val(), pesan: value_editor2, subject: $('#subject').val()},function(data_page){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      . "function klik_star(id_cms_contact_us_company){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star")."',{id: id_cms_contact_us_company},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us_company).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us_company).toggleClass(g.c);"
      . "   });"
      . "}"
      . "function show_detail(id_cms_contact_us_company){"
      . " $.post('".site_url("cms/portal-cms/ajax-detail-pesan/1")."',{id: id_cms_contact_us_company},function(data_detail_pesan){"
      . "   var data_tampil = jQuery.parseJSON( data_detail_pesan );"
      . "   $('#pesan_title').text(data_tampil.title);"
      . "   $('#pesan_sender').text(data_tampil.sender);"
      . "   $('#pesan_sender_to').text(data_tampil.sender_to);"
      . "   $('#pesan_note').html(data_tampil.note);"
      . "   $('#status_read_'+id_cms_contact_us_company).removeClass();"
      . "   $('#status_read_'+id_cms_contact_us_company).toggleClass('read');"
      . "   $('#jumlah_inbox').text(data_tampil.jumlah_read);"
      . "   $('#labora').modal('show');"
      . " });"
      . "}"
        
        . "function delete_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: $(this).val()},function(data_delete_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox').text(data_delete_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function unread_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-unread-pesan")."',{id: $(this).val()},function(data_unread_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox').text(data_unread_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function read_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-read-pesan")."',{id: $(this).val()},function(data_read_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox').text(data_read_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function delete_detail_pesan(id){"
        . " $.post('".site_url("cms/portal-cms/ajax-delete-pesan/1")."',{id: id},function(data_delete_pesan){"
        . "   set_daftar(0);"
        . "   $('#jumlah_inbox').text(data_delete_pesan);"
        . " });"
        . "}"
      
      . ""
      . "</script>";
      
    $portal_company = $this->global_models->get("portal_company", array("id_portal_company <>" => $this->session->userdata("id_portal_company")));
    
    $jumlah_inbox = $this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1));
    $jumlah_inbox_users = $this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1));
    
    $this->template->build('portal/contact-us', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "cms/portal-cms/contact-us",
            'title'       => lang("cms_contact_us"),
            'request_out_comp'  => "active",
            'foot'        => $foot,
            'css'         => $css,
            'portal_company' => $portal_company,
            'jumlah_inbox' => "({$jumlah_inbox})",
            'jumlah_inbox_users' => "({$jumlah_inbox_users})",
            'total'       => $total[0]->jml,
          ));
    $this->template
      ->set_layout('mail')
      ->build('portal/contact-us');
  }
    
  function star_company(){
    $total = $this->global_models->get_query("SELECT count(id_cms_contact_us_company) AS jml"
      . " FROM cms_contact_us_company WHERE ((id_users = {$this->session->userdata("id")} AND sender_status = 1 AND star_own = 2)"
      . " OR (id_portal_company = {$this->session->userdata("id_portal_company")} AND received_status = 1 AND star = 2))");
      
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>";
      
    $foot .= " <script>"
      . "$(function() {"
      . " $('#kata_cari_contact').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-total-star-company")."',{q:$('#kata_cari_contact').val()},function(total_data){"
      . "     $('#total_page').val(total_data);"
      . "     set_daftar(0);"
      . "   });"
      . " });"
      
      . " $('#cms_pesan_to').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-company-select/")."', {q: $('#cms_pesan_to').val()},function(data_select){"
      . "     $('#id_portal_company').html(data_select);"
      . "   });"
      . " });"
      . " CKEDITOR.replace('editor2');"
      . " CKEDITOR.replace('editor3');"
      . "});"
      
      . "function set_daftar(start_page){"
      . " if(typeof start_page === 'undefined'){"
      . "   start_page = 0;"
      . " }"
      . " $.post('".site_url("cms/portal-cms/ajax-star-company")."',{start: start_page, q:$('#kata_cari_contact').val()},function(data){"
      . "   $('#set_daftar').html(data);"
      . "   $.post('".site_url("cms/portal-cms/ajax-halaman-mail")."/'+$('#total_page').val()+'/'+start_page,function(data_page){"
      . "     $('#set_daftar_page').html(data_page)"
      . "   });"
      . " });"
      . "}"
      . "set_daftar();"
      . "$('#balas_pesan').click(function(){"
      . " $('#name_users').val($('#pesan_sender').text());"
      . " CKEDITOR.instances.editor3.setData( '<br /><br /><blockquote> '+$('#pesan_note').html()+' </blockquote>' );"
//      . " $('#editor3').val('<br /><hr /> '+$('#pesan_note').text());"
      . " $('#subject_users').val('Re: '+$('#pesan_title').text());"
      . " $('#compose-modal-users').modal('show');"
      . "});"
      . "$('#kirim_pesan').click(function(){"
      . "var value_editor2 = CKEDITOR.instances['editor2'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail")."',{id_portal_company: $('#id_portal_company').val(), pesan: value_editor2, subject: $('#subject').val()},function(data_page){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      . "function klik_star(id_cms_contact_us_company){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star")."',{id: id_cms_contact_us_company},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us_company).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us_company).toggleClass(g.c);"
      . "   });"
      . "}"
      . "function show_detail(id_cms_contact_us_company){"
      . " $.post('".site_url("cms/portal-cms/ajax-detail-pesan")."',{id: id_cms_contact_us_company},function(data_detail_pesan){"
      . "   var data_tampil = jQuery.parseJSON( data_detail_pesan );"
      . "   $('#pesan_title').text(data_tampil.title);"
      . "   $('#pesan_sender').text(data_tampil.sender);"
      . "   $('#pesan_sender_to').text(data_tampil.sender_to);"
      . "   $('#pesan_note').html(data_tampil.note);"
      . "   $('#status_read_'+id_cms_contact_us_company).removeClass();"
      . "   $('#status_read_'+id_cms_contact_us_company).toggleClass('read');"
      . "   $('#jumlah_inbox').text(data_tampil.jumlah_read);"
      . "   $('#labora').modal('show');"
      . " });"
      . "}"
        
        . "function delete_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: $(this).val()},function(data_delete_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox').text(data_delete_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function unread_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-unread-pesan")."',{id: $(this).val()},function(data_unread_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox').text(data_unread_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function read_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-read-pesan")."',{id: $(this).val()},function(data_read_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox').text(data_read_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function delete_detail_pesan(id){"
        . " $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: id},function(data_delete_pesan){"
        . "   set_daftar(0);"
        . "   $('#jumlah_inbox').text(data_delete_pesan);"
        . " });"
        . "}"
      
      . ""
      . "</script>";
      
    $portal_company = $this->global_models->get("portal_company", array("id_portal_company <>" => $this->session->userdata("id_portal_company")));
    
    $jumlah_inbox = $this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1));
    $jumlah_inbox_users = $this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1));
    
    $this->template->build('portal/contact-us', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "cms/portal-cms/contact-us",
            'title'       => lang("cms_contact_us"),
            'star_comp'   => "active",
            'foot'        => $foot,
            'css'         => $css,
            'portal_company' => $portal_company,
            'jumlah_inbox' => "({$jumlah_inbox})",
            'jumlah_inbox_users' => "({$jumlah_inbox_users})",
            'total'       => $total[0]->jml,
          ));
    $this->template
      ->set_layout('mail')
      ->build('portal/contact-us');
  }
    
  function star(){
    $total = $this->global_models->get_query("SELECT count(id_cms_contact_us) AS jml"
      . " FROM cms_contact_us WHERE ((id_users_from = {$this->session->userdata("id")} AND sender_status = 1 AND star_own = 2)"
      . " OR (id_users = {$this->session->userdata("id")} AND received_status = 1 AND star = 2))");
      
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>";
      
    $foot .= " <script>"
      . "$(function() {"
      . " $('#kata_cari_contact').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-total-star")."',{q:$('#kata_cari_contact').val()},function(total_data){"
      . "     $('#total_page').val(total_data);"
      . "     set_daftar(0);"
      . "   });"
      . " });"
      
      . " $('#cms_pesan_to').keyup(function(){"
      . "   $.post('".site_url("cms/portal-cms/ajax-company-select/")."', {q: $('#cms_pesan_to').val()},function(data_select){"
      . "     $('#id_portal_company').html(data_select);"
      . "   });"
      . " });"
      . " CKEDITOR.replace('editor2');"
      . " CKEDITOR.replace('editor3');"
      . "});"
      
      . "function set_daftar(start_page){"
      . " if(typeof start_page === 'undefined'){"
      . "   start_page = 0;"
      . " }"
      . " $.post('".site_url("cms/portal-cms/ajax-star")."',{start: start_page, q:$('#kata_cari_contact').val()},function(data){"
      . "   $('#set_daftar').html(data);"
      . "   $.post('".site_url("cms/portal-cms/ajax-halaman-mail")."/'+$('#total_page').val()+'/'+start_page,function(data_page){"
      . "     $('#set_daftar_page').html(data_page)"
      . "   });"
      . " });"
      . "}"
      . "set_daftar();"
      . "$('#balas_pesan').click(function(){"
      . " $('#name_users').val($('#pesan_sender').text());"
      . " CKEDITOR.instances.editor3.setData( '<br /><br /><blockquote> '+$('#pesan_note').html()+' </blockquote>' );"
//      . " $('#editor3').val('<br /><hr /> '+$('#pesan_note').text());"
      . " $('#subject_users').val('Re: '+$('#pesan_title').text());"
      . " $('#compose-modal-users').modal('show');"
      . "});"
      . "$('#kirim_pesan').click(function(){"
      . "var value_editor2 = CKEDITOR.instances['editor2'].getData();"
      . "   $.post('".site_url("cms/portal-cms/ajax-kirim-mail")."',{id_portal_company: $('#id_portal_company').val(), pesan: value_editor2, subject: $('#subject').val()},function(data_page){"
      . "     alert('Terkirim');"
      . "   });"
      . "});"
      . "function klik_star(id_cms_contact_us_company){"
      . "   $.post('".site_url("cms/portal-cms/ajax-ubah-star")."',{id: id_cms_contact_us_company},function(data_star){"
      . "     var g = jQuery.parseJSON( data_star );"
      . "     $('#bintang_'+id_cms_contact_us_company).removeClass();"
      . "     $('#bintang_'+id_cms_contact_us_company).toggleClass(g.c);"
      . "   });"
      . "}"
      . "function show_detail(id_cms_contact_us_company){"
      . " $.post('".site_url("cms/portal-cms/ajax-detail-pesan-users")."',{id: id_cms_contact_us_company},function(data_detail_pesan){"
      . "   var data_tampil = jQuery.parseJSON( data_detail_pesan );"
      . "   $('#pesan_title').text(data_tampil.title);"
      . "   $('#pesan_sender').text(data_tampil.sender);"
      . "   $('#pesan_sender_to').text(data_tampil.sender_to);"
      . "   $('#pesan_note').html(data_tampil.note);"
      . "   $('#status_read_'+id_cms_contact_us_company).removeClass();"
      . "   $('#status_read_'+id_cms_contact_us_company).toggleClass('read');"
      . "   $('#jumlah_inbox').text(data_tampil.jumlah_read);"
      . "   $('#labora').modal('show');"
      . " });"
      . "}"
        
        . "function delete_contact_all(){"
        . " $('.pilih_contact').each(function (index){"
        . "   if($(this).prop('checked')){"
        . "     $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: $(this).val()},function(data_delete_pesan){"
        . "       set_daftar(0);"
        . "       $('#jumlah_inbox').text(data_delete_pesan);"
        . "     });"
        . "   }"
        . " });"
        . "}"
        
        . "function unread_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-unread-pesan")."',{id: $(this).val()},function(data_unread_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox').text(data_unread_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function read_contact_all(){"
//        . " $('.pilih_contact').each(function (index){"
//        . "   if($(this).prop('checked')){"
//        . "     $.post('".site_url("cms/portal-cms/ajax-read-pesan")."',{id: $(this).val()},function(data_read_pesan){"
//        . "       set_daftar(0);"
//        . "       $('#jumlah_inbox').text(data_read_pesan);"
//        . "     });"
//        . "   }"
//        . " });"
        . "}"
        
        . "function delete_detail_pesan(id){"
        . " $.post('".site_url("cms/portal-cms/ajax-delete-pesan")."',{id: id},function(data_delete_pesan){"
        . "   set_daftar(0);"
        . "   $('#jumlah_inbox').text(data_delete_pesan);"
        . " });"
        . "}"
      
      . ""
      . "</script>";
      
    $portal_company = $this->global_models->get("portal_company", array("id_portal_company <>" => $this->session->userdata("id_portal_company")));
    
    $jumlah_inbox = $this->global_models->get_field("cms_contact_us_company", "count(id_cms_contact_us_company)", array("id_portal_company" => $this->session->userdata("id_portal_company"), "status" => 1, "received_status" => 1));
    $jumlah_inbox_users = $this->global_models->get_field("cms_contact_us", "count(id_cms_contact_us)", array("id_users" => $this->session->userdata("id"), "status" => 1, "received_status" => 1));
    
    $this->template->build('portal/contact-us', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "cms/portal-cms/contact-us",
            'title'       => lang("cms_contact_us"),
            'star_users'   => "active",
            'foot'        => $foot,
            'css'         => $css,
            'portal_company' => $portal_company,
            'jumlah_inbox' => "({$jumlah_inbox})",
            'jumlah_inbox_users' => "({$jumlah_inbox_users})",
            'total'       => $total[0]->jml,
          ));
    $this->template
      ->set_layout('mail')
      ->build('portal/contact-us');
  }
    
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
