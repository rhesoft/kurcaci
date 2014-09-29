<?php
require_once 'system/core/Model.php';
class Global_models extends CI_Model{
  function __construct(){
      parent::__construct();
      $this->load->database();
  }
  function get_connect($database){
    $this->load->database($database, true);
  }
  function insert($table, $kirim){
    $this->db->insert($table, $kirim);
    return $this->db->insert_id();
  }
  function insert_batch($table, $kirim){
    $this->db->insert_batch($table, $kirim);
    return $this->db->insert_id();
  }
  function update_duplicate($table, $kirim, $else){
    $no = 0;
    foreach($kirim as $key => $krm){
      if($no > 0){
        $field .= ", ";
        $value .= ", ";
      }
      $field .= "`$key`";
      if($krm > 0 OR $krm)
        $value .= "'$krm'";
      else
        $value .= "NULL";
      $no++;
    }
    $no = 0;
    foreach($else as $ky => $el){
      $le= "";
      if($el > 0 OR $el)
        $le .= "'$el'";
      else
        $le .= "NULL";
      if($no > 0)
        $update .= ",";
      $update .= "`$ky` = $le";
      $no++;
    }
    $query = "
      INSERT INTO {$table} ({$field}) VALUES({$value}) ON DUPLICATE KEY UPDATE {$update};
      ";
//      print $query;die;
    $this->db->query($query);
    return $this->db->insert_id();
  }
  function delete($table, $where, $id_table = ""){
    $this->db->delete($table, $where);
    if($id_table){
      $data = $this->get_field($table, "max({$id_table})") + 1;
      $this->query("ALTER TABLE  {$table} AUTO_INCREMENT = {$data}");
    }
    return true;
  }
  function update($table, $where, $kirim){
    $this->db->where($where);
    return $this->db->update($table, $kirim);
  }
  function get_field($table, $field, $where = array()){
    $this->db->select($field." as a");
    if($where)
      $this->db->where($where);
    $w = $this->db->get($table)->row();
    if($w)
      return $w->a;
    else
      return false;
  }
  function get_dropdown($table, $key, $name, $pilih = TRUE, $where = array(), $field_not = "nbs", $not_in = array(), $tambahan = ""){
    if($pilih === TRUE)
      $data[0] = "- Pilih -";
    $rec = $this->get($table, $where, $field_not, $not_in);
    if(is_array($rec)){
      foreach ($rec as $value) {
        $data[$value->$key] = $value->$name;
        if($tambahan)
          $data[$value->$key] .= " - ".$value->$tambahan;
      }
    }
    return $data;
  }
  function get_query($query){
    return $this->db->query($query)->result();
  }
  function get($table, $where = array(), $field_not = "nbs", $not_in = array(), $select = "*"){
    if($field_not != "nbs" AND $not_in)
      $this->db->where_not_in($field_not, $not_in);
    if($where)
      $this->db->where($where);
    $this->db->select($select);
    $data = $this->db->get($table)->result();
    if(is_array($data))
      return $data;
    else
      return array();
  }
  function get_array($field, $table, $where = array(), $field_not = "nbs", $not_in = array()){
    $temp = $this->get($table, $where, $field_not, $not_in);
    $return = array();
    if(is_array($temp)){
      foreach ($temp as $key => $value) {
        $return[] = $value->$field;
      }
    }
    return $return;
  }
  function get_user_outlet($id_outlet, $privilege){
    $query = "
      SELECT A.*
      FROM m_users AS A
      JOIN d_user_privilege AS B ON A.id_users = B.id_users
      JOIN m_privilege AS C ON B.id_privilege = C.id_privilege
      JOIN d_outlet_users AS D ON A.id_users = D.id_users AND D.id_outlet = {$id_outlet}
      WHERE C.name = '{$privilege}'
      ";
    return $this->get_query($query);
  }
  function get_outlet_user($id_users){
    $query = "
      SELECT A.*
      FROM m_outlet AS A
      JOIN d_outlet_users AS B ON A.id_outlet = B.id_outlet AND B.id_users = {$id_users}
      ";
    return $this->get_query($query);
  }
  function truncate($table = ''){
    return $this->db->truncate($table);
  }
  function ambildah(){
    return get_class_methods('Users');
  }
  function query($query){
    return $this->db->query($query);
  }
  function nicename($string, $table, $id){
    $string = str_replace(":", "", $string);
    $hasil = urlencode(strtolower(str_replace(" ", "_", str_replace("-", "_", $string))));
    $cek = $this->get($table, array($id => $hasil));
    if($cek)
      $hasil .= rand(100, 9999);
    
    return $hasil;
  }
  function ganerate_so(){
    return rand();
  }
  function cek_po($id_po){
    $items = $this->get("d_po_items", array("id_po" => $id_po, "status > " => 0));
    $cek = "sudah";
    foreach($items as $inti){
      $qty = $this->get_field("d_rg_items", "sum(qty)", array("id_po_items" => $inti->id_po_items));
      $selisih = 0;
      if($qty){
        if($qty < $inti->qty){
          $cek = "belum";
          $selisih = $inti->qty - $qty;
        }
      }
      else{
        $cek = "belum";
        $selisih = $inti->qty;
      }
      $kekurangan[$inti->id_po_items] = $selisih;
    }
    if($cek == "sudah")
//      return $kekurangan;
      return "nbs";
    else
      return $kekurangan;
  }
  function cek_so($id_so){
    $items = $this->get("d_so_items", array("id_so" => $id_so, "status > " => 0));
    $cek = "sudah";
    foreach($items as $inti){
      $qty = $this->get_field("d_dn_items", "sum(qty)", array("id_so_items" => $inti->id_so_items));
      $selisih = 0;
      if($qty){
        if($qty < $inti->qty){
          $cek = "belum";
          $selisih = $inti->qty - $qty;
        }
      }
      else{
        $cek = "belum";
        $selisih = $inti->qty;
      }
      $kekurangan[$inti->id_so_items] = $selisih;
    }
    if($cek == "sudah")
//      return $kekurangan;
      return "nbs";
    else
      return $kekurangan;
  }
  function selisih_hari($start_date, $end_date){
    $startDate = strtotime($start_date);
    $endDate = strtotime($end_date);

    $interval = $endDate - $startDate;
    $days = ($interval / (60 * 60 * 24));
    return $days;
  }
  function get_month_array(){
    return array(
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'Nopember',
        12 => 'Desember',
    );
  }
  function sign_keuangan($sk, $y, $m, $type, $grand_total){
    $id_close_ab = $this->get("d_close_ab", array("akun" => $sk, "year" => $y, "month" => $m, "type" => $type));
    $pos = array(
        "pendapatan"          => 2,
        "beban_hpp"           => 1,
        "hutang_po"           => 2,
        "hutang_po_produksi"  => 2,
        "persediaan_product"  => 1,
        "prepaid_income"      => 2,
        "prepaid_inventory"   => 1,
        "hutang_affiliate"    => 2,
        "beban_affiliate"     => 1,
        "beban_kas"           => 1,
        "kas"                 => 1,
        "modal"               => 2,
        "piutang"             => 1,
    );
    if($id_close_ab[0]->id_close_ab > 0){
      $this->query("
        UPDATE d_close_ab
        SET price	= price + {$grand_total}, update_by_users = {$this->session->userdata("id")}
        WHERE id_close_ab = {$id_close_ab[0]->id_close_ab}
        ");
    }
    else{
      $kirim_close = array(
          "akun"            => $sk,
          "pos"             => $pos[$sk],
          "price"           => $grand_total,
          "year"            => $y,
          "month"           => $m,
          "type"            => $type,
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d")
      );
      $this->insert("d_close_ab", $kirim_close);
    }
  }
  function get_field_query($query,$field,$key,$pih){
    $data =  $this->db->query($query)->result();
    if($pih == ""){
     $return[0] = "- Pilih -";
    }
  
    if(is_array($data)){
      foreach ($data as $value) {
          $return[$value->$key] = $value->$field;
      }
    }
    return $return;
  }
  
  function string_to_number($string){
    $satu = explode(" ", $string);
    if($satu[1]){
      $dua = str_replace(".", "", $satu[1]);
    }
    else{
      $dua = str_replace(".", "", $satu[0]);
    }
    if(trim($dua) == "Rp")
      $dua = 0;
    return $dua;
  }
  
  function string_to_number_array($array){
    foreach ($array AS $k => $v){
      $array_hasil[$k] = $this->string_to_number($v);
    }
    return $array_hasil;
  }
  
  function trans_begin(){
    return $this->db->trans_begin();
  }
  
  function trans_rollback(){
    return $this->db->trans_rollback();
  }
  
  function trans_commit(){
    $this->db->trans_commit();
  }
  
  function set_variable($code, $isi){
    $code_cek = $this->get_field("variable", "code", array("code" => $code));
    if($code_cek){
      $this->update("variable", array("code" => $code), array("isi" => $isi));
    }
    else{
      $this->insert("variable", array("code" => $code, "isi" => $isi));
    }
    return true;
  }
  
  function get_variable($code){
    $isi = $this->get_field("variable", "isi", array("code" => $code));
    return $isi;
  }
  
  function del_variable($code){
    $isi = $this->delete("variable", array("code" => $code));
    return true;
  }
  
  function informasi_promo(){
    $promo_terakhir = $this->get_query("SELECT A.*, B.title AS company"
      . " FROM portal_promo AS A"
      . " LEFT JOIN portal_company AS B ON A.id_portal_company = B.id_portal_company"
      . " WHERE A.status = 4 AND ('".date("Y-m-d")."' BETWEEN A.start_date AND A.end_date)"
      . " ORDER BY A.end_date DESC");
    for($p = 0 ; $p < 3 ; $p++){
      if($promo_terakhir[$p]->id_portal_promo){
        $hasil[] = array(
          "title"           => $promo_terakhir[$p]->title,
          "company"         => $promo_terakhir[$p]->company,
          "end_date"        => $promo_terakhir[$p]->end_date,
          "link"            => $promo_terakhir[$p]->link,
        );
      }
      else{
        $hasil[] = array(
          "title"           => "Tersedia",
          "company"         => "-",
          "end_date"        => date("Y-m-d"),
          "link"            => "portal/client-portal/add-promo",
        );
      }
    }
    return $hasil;
  }
  
}
?>
