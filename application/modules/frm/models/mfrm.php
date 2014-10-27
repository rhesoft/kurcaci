<?php
class Mfrm extends Global_models {

    function __construct()
    {
        parent::__construct();
    }
    
    function create_journal($tahun, $bulan, $id_portal_company){
      $kirim_frm_journal = array(
        "id_portal_company"           => $id_portal_company,
        "title"                       => date("F Y", strtotime($tahun."-".$bulan."-01")),
        "month"                       => $bulan,
        "year"                        => $tahun,
        "sort"                        => date("Y-m-d", strtotime($tahun."-".$bulan."-01")),
        "status"                      => 1,
        "create_by_users"             => $this->session->userdata("id"),
        "create_date"                 => date("Y-m-d H:i:s")
      );
      $id_frm_journal = $this->insert("frm_journal", $kirim_frm_journal);
      return $id_frm_journal;
    }
    
    /**
     * @param array $set_packet 
     * @param datetime tanggal
     * @param string notransaksi
     * @param double saldo
     * @param tinyint status (1 => aktif, 2 => tidak aktif)
     * @param note text
     * @param int create_by_users this->session->userdata("id")
     * @param datetime create_date
     * @param int debit
     * @param int kredit
     */
    function set_journal_log($set_packet){
      
      $id_portal_company = $this->session->userdata("id_portal_company");
//      cek and set journal
      $id_frm_journal = $this->get_field("frm_journal", "id_frm_journal", 
        array(
          "id_portal_company" => $id_portal_company, 
          "month" => date("m", strtotime($set_packet['tanggal'])),
          "year" => date("Y", strtotime($set_packet['tanggal'])), 
          "status" => 1
        )
      );
      if($id_frm_journal < 1){
//        error, kasih informasi current journal
        $status = 2;
        $note = "informasi current journal";
      }
      else{
        $status = 1;
//      set journal log
        $pst_log = $set_packet;
        $pst_log['id_frm_journal'] = $id_frm_journal;
        unset($pst_log['debit']);
        unset($pst_log['kredit']);
        $id_frm_journal_log = $this->insert("frm_journal_log", $pst_log);
//      set journal log account
        $journal_log_account_debit = array(
          "id_frm_account"              => $set_packet['debit'],
          "id_frm_journal"              => $id_frm_journal,
          "id_frm_journal_log"          => $id_frm_journal_log,
          "saldo"                       => $set_packet['saldo'],
          "pos"                         => 1,
          "create_by_users"             => $this->session->userdata("id"),
          "create_date"                 => date("Y-m-d H:i:s")
        );
        $id_frm_journal_log_account_debit = $this->insert("frm_journal_log_account", $journal_log_account_debit);
        $journal_log_account_debit["id_frm_account"] = $set_packet['kredit'];
        $journal_log_account_debit["pos"] = 2;
        $id_frm_journal_log_account_kredit = $this->insert("frm_journal_log_account", $journal_log_account_debit);
      }
      
      $hasil = array(
        "status"              => $status,
        "note"                => $note,
        "id_frm_journal_log"  => $id_frm_journal_log
      );
      return $hasil;
    }
    
}
?>
