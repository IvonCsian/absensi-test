<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}
	

    function StokBarangAgen_backup(){
        $username = $this->session->userdata('username');

        $querycek = "SELECT a.*,b.hrg_satuan FROM m_barang a 
        LEFT JOIN m_harga_agen b ON a.kd_barang = b.kd_barang 
        WHERE b.kd_agen = '$username'";
        $rdt = $this->db->query($querycek)->num_rows();
        if($rdt > 0){
            $query = $this->db->query($querycek);
            return $query->result();
        }
        else{
            $querycek = "SELECT *,0 as hrg_satuan FROM m_barang";
            $query = $this->db->query($querycek);
            return $query->result();
        }
       
    }

    function StokBarangAgen(){
        $username = $this->session->userdata('username');

        $querycek = "SELECT a.*,b.nm_barang FROM t_stok_barang a 
        left join m_barang b on a.kd_barang = b.kd_barang
        WHERE a.kd_agen = '$username'";
        $rdt = $this->db->query($querycek)->num_rows();
        if($rdt > 0){
            $query = $this->db->query($querycek);
            return $query->result();
        }
        else{
            $querycek = "SELECT * FROM t_stok_barang";
            $query = $this->db->query($querycek);
            return $query->result();
        }
       
    }

	function cekStok($data){
		$username = $this->session->userdata('username');
		$kd_barang = $data['kd_barang'];

		$querycek = "SELECT * FROM t_kartubarang where kd_barang = '$kd_barang' and kd_agen = '$username' order by id desc limit 1";
        $rdt = $this->db->query($querycek)->num_rows();
        if($rdt > 0){
		    $query = $this->db->query($querycek);
		    return $query->result();
        }
        else{
            $querycek = "SELECT '0' as kwt_akhir FROM t_kartubarang";
            $query = $this->db->query($querycek);
		    return $query->result();
        }
	}

    
}
?>