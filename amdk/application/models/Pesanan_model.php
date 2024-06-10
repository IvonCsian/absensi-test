<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

	function dataPesanan($data){
        $no_bukti_order = $data['no_bukti_order'];

        $username = $this->session->userdata('username');

        $querydt = "select b.*,c.nm_barang from t_checkout a 
        left join t_checkout_dtl b on a.no_bukti_order = b.no_bukti_order 
        left join m_barang c on b.kd_barang = c.kd_barang
        where a.user_id='$username' and a.no_bukti_order='$no_bukti_order' and a.flag_order<>0 and flag_done=0";
        $query = $this->db->query($querydt);
        return $query->result();
    }

	function cekPesanan(){
        $username = $this->session->userdata('username');

        $query = "select * from t_checkout where user_id='$username' and flag_order<>0 and flag_done=0";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function jmPesanan(){
        $username = $this->session->userdata('username');

        $querydt = "select a.*,b.nm_agen from t_checkout a
        left join m_agen b on a.kd_agen = b.kd_agen 
        where a.user_id='$username' and a.flag_order<>0 and a.flag_done=0";
        $query = $this->db->query($querydt);
        return $query->result();
    }
    

}
?>