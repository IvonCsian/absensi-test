<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

	function dataPembelian($data){
        $no_bukti_bi = $data['no_bukti_bi'];
        $querydt = "select a.*,b.nm_barang from t_bi_detail a 
        left join m_barang b on a.kd_barang = b.kd_barang
        where a.no_bukti_bi='$no_bukti_bi'";
        $query = $this->db->query($querydt);
        return $query->result();
    }

	function cekPembelian(){
        $username = $this->session->userdata('username');

        $query = "select * from t_bi where user_id='$username' and flag_bi<>0";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function jmPembelian(){
        $username = $this->session->userdata('username');

        $querydt = "select a.* from t_bi a
        where a.user_id='$username' and a.flag_bi<>0 order by a.tgl_bi desc";
        $query = $this->db->query($querydt);
        return $query->result();
    }

    function jmBarang($data){
        $no_bukti_bi = $data['no_bukti_bi'];
        $query = "select * from t_bi_detail where no_bukti_bi='$no_bukti_bi'";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function HeaderBI($data){
        $no_bukti_bi = $data['no_bukti_bi'];

        $querydt = "select a.* from t_bi a
        where a.no_bukti_bi='$no_bukti_bi'";
        $query = $this->db->query($querydt);
        return $query->result();
    }
    
    // --- po pabrik ---
    function cekPO(){
        $username = $this->session->userdata('username');

        $query = "select * from t_order where user_id='$username' and is_del=0";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function jmPo(){
        $username = $this->session->userdata('username');

        $querydt = "select a.* from t_order a
        where a.user_id='$username' and a.is_del=0 order by a.tgl_order desc";
        $query = $this->db->query($querydt);
        return $query->result();
    }

    function dataPOpabrik($data){
        $no_bukti_po = $data['no_bukti_po'];
        $querydt = "select a.*,b.nm_barang from t_order_detail a 
        left join m_barang b on a.kd_barang = b.kd_barang
        where a.no_bukti_po='$no_bukti_po'";
        $query = $this->db->query($querydt);
        return $query->result();
    }

    function jmBarangPo($data){
        $no_bukti_po = $data['no_bukti_po'];
        $query = "select * from t_order_detail where no_bukti_po='$no_bukti_po'";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function HeaderPO($data){
        $no_bukti_po = $data['no_bukti_po'];

        $querydt = "select a.* from t_order a
        where a.no_bukti_po='$no_bukti_po'";
        $query = $this->db->query($querydt);
        return $query->result();
    }

}
?>